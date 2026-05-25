<?php

namespace Home\Opera;

/**
 * Description of UptemsOpera
 * 上传多商品文件
 * @author admins
 */
class UpmoresOpera {

    private $param;
    private $fileDir;
    private $list;
    //
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
        $sheetTotal = $objPHPExcel->getSheetCount();
        #
        for ($i = 0; $i < $sheetTotal; $i++) {
            $sheetSelected = $i;
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
                continue;
            }
            $this->list[$i] = $dataArr;
        }
        #
        return $this->doListData();
    }

    /**
     * 格式化数据
     */
    private function doListData() {
        $list = $this->list;
        #
        foreach ($list as $k => $v) {
            $this->logs[$k] = array(
                "pid" => $this->param["pid"],
                "cat_index" => $this->param["cat_index"],
                "ptype" => 1,
                "source" => 0,
                "gnames" => trim($v[2][0]),
                "sorts" => 0,
                "key_0" => trim($v[2][3]),
                "value_0" => trim($v[2][4]),
                "key_1" => trim($v[2][5]),
                "value_1" => trim($v[2][6]),
                "key_2" => trim($v[2][7]),
                "value_2" => trim($v[2][8]),
                "price" => 0,
                "dratio" => 0,
                "market" => 0,
                "trans" => trim($v[2][9]),
                "ticket_nor" => 0,
                "ticket_person" => 0,
                "status" => 1,
                "uptimes" => 0,
                "times" => time(),
                "child" => $v
            );
        }
        #
        return $this->inCeilData();
    }

    /**
     * 插入数据
     */
    private function inCeilData() {
        $plate_conts_logs = M("plate_conts_logs");
        #
        $plate_conts_logs->startTrans();
        foreach ($this->logs as $k => $v) {
            $id = $plate_conts_logs->add($v);
            if (!$id) {
                $plate_conts_logs->rollback();
                return get_op_put(0, "导入失败");
            }
            #
            $child = $this->logsrTools($id, $v["child"]);
            if (!$child) {
                $plate_conts_logs->rollback();
                return get_op_put(0, "导入失败");
            }
        }
        #
        $plate_conts_logs->commit();
        return get_op_put(1, "导入成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 插入数据
     * @param type $v
     */
    private function logsrTools($pid, $data) {
        $plate_conts_logsr = M("plate_conts_logsr");
        $cxmark = D("Home/Cxmark", "Opera");
        #
        $list = [];
        foreach ($data as $k => $v) {
            if ($k < 4) {
                continue;
            }
            if ($v[0] == NULL || $v[0] == "") {
                continue;
            }
            #
            $ceil = array(
                "fpid" => $this->param["pid"],
                "type" => 1,
                "pid" => $pid,
                "cat_index" => $this->param["cat_index"],
                "name" => trim($v[0]),
                "price" => trim($v[2]),
                "dratio" => trim($v[1]),
                "market" => 0,
                "sorts" => 0,
                "status" => 1,
                "uptimes" => 0,
                "times" => time(),
            );
            #
            $market = $cxmark->runs($ceil);
            #
            $ceil["market"] = $market["data"];
            #
            $list[] = $ceil;
        }
        #
        return $plate_conts_logsr->addAll($list);
    }

}
