<?php

namespace Home\Opera;

/**
 * Description of UptemsOpera
 * 上传模板文件
 * @author admins
 */
class UptemsOpera {

    private $param;
    private $fileDir;
    private $list;
    //
    private $puts;
    private $logs;

    public function runs($param) {
        $this->param = $param;
        #
        return $this->uploads();
    }

    /**
     * 上传文件
     */
    private function uploads() {
        $file = uploadFile("tmps");
        if (!$file) {
            return get_op_put(0, "文件上传失败");
        }
        #
        $this->fileDir = "./././Public/uploads/tmps/" . $file["file"]["savename"];
        return $this->decodeLr();
    }

    /**
     * 解析文件
     */
    private function decodeLr() {
        vendor("PHPExcel.PHPExcel");
        #
        $objPHPExcel = \PHPExcel_IOFactory::load($this->fileDir);
        //默认选中sheet0表
        $sheetSelected = 0;
        $objPHPExcel->setActiveSheetIndex($sheetSelected);
        //获取表格行数
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
        if ($rowCount > 5000) {
            return get_op_put(0, "请将数据拆分后在进行导入");
        }
        //获取表格列数
        $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
        $dataArr = array();
        for ($row = 2; $row <= $rowCount; $row++) {
            //列数循环 , 列数是以A列开始
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $cell = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                if (is_object($cell)) {
                    $cell = $cell->__toString();
                }
                $dataArr[$row][] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $cell);
            }
        }
        if (count($dataArr) < 1) {
            return get_op_put(0, "没有导入数据");
        }
        $this->list = $dataArr;
        #
        return $this->checkListType();
    }

    /**
     * 检测上传类型
     */
    private function checkListType() {
        $r = $this->list[2];
        $this->puts = array(
            "name" => $this->param["name"],
            "types" => $this->param["types"],
            "status" => $this->param["status"],
            "key_0" => $r[2],
            "value_0" => $r[3],
            "key_1" => $r[4],
            "value_1" => $r[5],
            "key_2" => $r[6],
            "value_2" => $r[7],
            "trans" => $r[8],
            "uptimes" => 0,
            "times" => time(),
        );
        if ($this->param["types"] > 1) {
            return $this->doSing();
        }
        return $this->doMore();
    }

    /**
     * 单一产品模板
     */
    private function doSing() {
        foreach ($this->list as $k => $v) {
            $ceil = [
                "key_0" => $v[0],
                "value_0" => $v[1],
                "key_1" => $v[2],
                "value_1" => $v[3],
                "key_2" => $v[4],
                "value_2" => $v[5],
                "price" => $v[6],
                "trans" => $v[7],
            ];
            $this->logs[] = $ceil;
        }
        return $this->finalOut();
    }

    /**
     * 多产品模板
     */
    private function doMore() {
        if (count($this->list[2]) < 9) {
            return get_op_put(0, "模板数据异常");
        }
        foreach ($this->list as $k => $v) {
            $ceil = [
                "name" => $v[0],
                "price" => $v[1],
            ];
            $this->logs[] = $ceil;
        }
        return $this->finalOut();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 完成并输出
     */
    private function finalOut() {
        $sys_tmps = M("sys_tmps");
        $sys_tmps_logs = M("sys_tmps_logs");
        #
        $sys_tmps->startTrans();
        #
        if ($this->param["type"] == "1") {
            $id = $sys_tmps->add($this->puts);
        }
        if ($this->param["type"] == "2") {
            $id = $this->param["ids"];
        }
        #
        if (!$id) {
            $sys_tmps->rollback();
            return get_op_put(0, "模板插入失败");
        }
        foreach ($this->logs as $k => $v) {
            $this->logs[$k]["pid"] = $id;
        }
        #
        if (!$sys_tmps_logs->addAll($this->logs)) {
            $sys_tmps->rollback();
            return get_op_put(0, "模板插入失败[LOG]");
        }
        $sys_tmps->commit();
        return get_op_put(1, "添加完成");
    }

}
