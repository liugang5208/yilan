<?php

namespace Home\Controller;

#use Think\Controller;

class GoodsController extends CommController {

    /**
     * 分类
     */
    public function cats() {
        $plate_cats = M("plate_cats");
        $plate_cats_exc = M("plate_cats_exc");
        #
        $list = boPage($plate_cats, $where);
        #
        $this->assign("list", $list);
        $this->assign("cats", $plate_cats_exc->where(["status" => 1])->order("sort desc,id asc")->select());
        $this->display();
    }

    /**
     * 分类更新数据
     */
    public function cats_sync() {
        $plate_cats_exc = M("plate_cats_exc");
        $plate_cats = M("plate_cats");
        $catio = D("Home/Catio", "Logic");
        $post = I("post.");
        #更新分类信息
        foreach ($post as $k => $v) {
            if (!$plate_cats_exc->where(["id" => $k])->save(["value" => $v])) {
                continue;
            }
        }
        set_time_limit(0);
        ini_set('memory_limit', '11468M');
        #计算分类报价
        $list = $plate_cats->where(["mode" => 0, "status" => 1])->select();
        foreach ($list as $k => $v) {
            $exc = $plate_cats_exc->where(["id" => $v["float_cat"]])->find();
            if ($exc == NULL) {
                continue;
            }
            #
            #$save = [];
            $ceil = $exc["value"] - $v["datum"];
            if ($ceil >= 0) {
                $v["up"] = abs($ceil / $v["up_size"] * $v["up_ratio"]);
                $v["down"] = 0;
            }
            if ($ceil < 0) {
                $v["up"] = 0;
                $v["down"] = abs($ceil / $v["down_size"] * $v["down_ratio"]);
            }
            /*
              if (!$plate_cats->where(["id" => $v["id"]])->save($save)) {
              continue;
              }
             * 
             */
            $v["ids"] = $v["id"];
            unset($v["id"]);
            #
            $catio->runs($v);
        }
        #
        return get_op_put(1, null);
    }

    /**
     * 分类更新
     */
    public function cats_edit() {
        $plate_cats = M("plate_cats");
        $plate_cats_exc = M("plate_cats_exc");
        $catio = D("Home/Catio", "Logic");
        $post = I("post.");
        $data['name'] = $post['name'];
        $data['sort'] = $post['sort'];
        $data['status'] = $post['status'];
        $data['uptimes'] = time();
        $plate_cats->where(['id'=>$post['ids']])->save($data);
        return get_op_put(1, "修改成功");
        #
    //     $info = $plate_cats->where(["id" => $post["ids"]])->find();
    //     $excInfo = $plate_cats_exc->where(["id" => $info["float_cat"]])->find();
    //     $ceil = $excInfo["value"] - $post["datum"];
    //     #
    //     if ($ceil >= 0) {
    //         $save["up"] = abs($ceil / $info["up_size"] * $info["up_ratio"]);
    //         $save["down"] = 0;
    //     }
    //     if ($ceil < 0) {
    //         $save["up"] = 0;
    //         $save["down"] = abs($ceil / $info["down_size"] * $info["down_ratio"]);
    //     }
    //     #
    //     $res = $catio->runs($post);
    //     return get_op_put($res["status"], $res["msg"], $res["data"]);
    }
    

    /**
     * 分类
     */
    public function cats_exc() {
        $plate_cats_exc = M("plate_cats_exc");
        #
        $list = boPage($plate_cats_exc, $where);
        #
        $this->assign("list", $list);
        $this->display();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 线缆
     */
    public function liner() {
        $plate_types = M("plate_types");
        #
        $where["types"] = 1;
        $list = boPage($plate_types, $where, "sorts asc,id asc");
        #
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 配套
     */
    public function peita() {
        $plate_types = M("plate_types");
        #
        $where["types"] = 2;
        $list = boPage($plate_types, $where, "sorts asc,id asc");
        #
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 板块详情
     * @param type $id
     */
    public function plate_banner($id) {
        $plate_types = M("plate_types");
        $plate_banner = M("plate_banner");
        #
        $where["id"] = $id;
        $info = $plate_types->where($where)->find();
        $list = boPage($plate_banner, ["pid" => $id], "sorts desc,id asc");
        #
        $this->assign("info", $info);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 板块详情
     * @param type $id
     */
    public function plate_infos($id) {
        $plate_types = M("plate_types");
        $plate = M("plate");
        #
        $where["id"] = $id;
        $info = $plate_types->where($where)->find();
        $list = boPage($plate, ["pid" => $id], "sorts desc,id asc");
        #
        $this->assign("info", $info);
        $this->assign("list", $list);
        $this->display();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 板块详情广告
     */
    public function plate_conts($id) {
        $plate = M("plate");
        $plate_conts = M("plate_conts");
        $shops = M("shops");
        $plate_cats = M("plate_cats");
        #
        $info = $plate->find($id);
        $list = boPage($plate_conts, ["pid" => $id], "sorts desc,id asc");
        #
        $this->assign("info", $info);
        $this->assign("list", $list);
        $this->assign("shop", $shops->where(["status" => 1])->select());
        $this->assign("id", $id);
        $this->assign("cats", $plate_cats->where(["status" => 1])->select());
        $this->display();
    }

    /**
     * 板块详情广告-详情
     */
    public function plate_conts_info($id, $tar) {
        $plate_conts = M("plate_conts");
        #
        $where["id"] = $id;
        $info = $plate_conts->where($where)->find();
        #
        $this->assign("id", $id);
        $this->assign("tar", $tar);
        $this->assign("context", $info[$tar]);
        $this->display();
    }

    /**
     * 板块详情广告-更新图片
     */
    public function plate_conts_upfile() {
        $plate_conts = M("plate_conts");
        $post = I("post.");
        #
        $file = uploadFile("ads");
        if (!$file) {
            return get_op_put(0, "文件上传失败");
        }
        $where["id"] = $post["ids"];
        $save["source"] = $file["source"]["savename"];
        $save["uptimes"] = time();
        #
        if (!$plate_conts->where($where)->save($save)) {
            return get_op_put(0, "文件更新失败");
        }
        return get_op_put(1, "处理成功");
    }

    /**
     * 板块详情广告-更新搜索
     */
    public function plate_conts_search() {
        $plate_conts = M("plate_conts");
        $post = I("post.");
        #
        $file = uploadFile("ads");
        if (!$file) {
            return get_op_put(0, "文件上传失败");
        }
        $where["id"] = $post["ids"];
        $save["source_display"] = $file["source_display"]["savename"];
        $save["uptimes"] = time();
        #
        if (!$plate_conts->where($where)->save($save)) {
            return get_op_put(0, "文件更新失败");
        }
        return get_op_put(1, "处理成功");
    }

    /**
     * 板块详情广告-多商品
     */
    public function plate_conts_more($id) {
        $plate_conts = M("plate_conts");
        $sys_tmps = M("sys_tmps");
        #
        $info = $plate_conts->find($id);
        $list = $sys_tmps->where(["types" => $info["price_type"]])->order("id desc")->select();
        #
        $this->assign("info", $info);
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 板块详情广告-单商品-添加模板数据
     */
    public function plate_conts_more_temp() {
        $sys_tmps = M("sys_tmps");
        $sys_tmps_logs = M("sys_tmps_logs");
        $plate_conts_logs = M("plate_conts_logs");
        $plate_conts_logsr = M("plate_conts_logsr");
        $post = I("post.");
        #
        $plate_conts_logsr->startTrans();
        $info = $sys_tmps->where(["id" => $post["ids"]])->find();
        $list = $sys_tmps_logs->where(["pid" => $post["ids"]])->order("id desc")->select();
        $append = $plate_conts_logs->query("SHOW TABLE STATUS LIKE 'plate_conts_logs'");
        #
        $sing = [
            "pid" => $post["pid"],
            "cat_index" => $post["cat_index"],
            "ptype" => 1,
            "sorts" => $append[0]["auto_increment"],
            "key_0" => $info["key_0"],
            "value_0" => $info["value_0"],
            "key_1" => $info["key_1"],
            "value_1" => $info["value_1"],
            "key_2" => $info["key_2"],
            "value_2" => $info["value_2"],
            "trans" => $info["trans"],
            "status" => 1,
            "uptimes" => 0,
            "times" => time()
        ];
        $id = $plate_conts_logs->add($sing);
        if (!$id) {
            $plate_conts_logsr->rollback();
            return get_op_put(0, "添加失败");
        }
        #
        foreach ($list as $k => $v) {
            $last = $plate_conts_logsr->query("SHOW TABLE STATUS LIKE 'plate_conts_logsr'");
            #
            $ceil = ["pid" => $id, "name" => $v["name"], "price" => $v["price"]];
            $ceil["sorts"] = $last[0]["auto_increment"];
            $ceil["status"] = 1;
            $ceil["uptimes"] = 0;
            $ceil["times"] = time();
            #
            if (!$plate_conts_logsr->add($ceil)) {
                $plate_conts_logsr->rollback();
                return get_op_put(0, "添加失败");
            }
        }
        #
        $plate_conts_logsr->commit();
        return get_op_put(1, "添加成功");
    }

    /**
     * 导入商品
     */
    public function plate_conts_more_im() {
        $upmores = D("Home/Upmores", "Opera");
        $post = I("post.");
        #
        $upmores->runs($post);
    }

    /**
     * 板块详情广告-单商品
     */
    public function plate_conts_list($id) {
        $plate_conts = M("plate_conts");
        $sys_tmps = M("sys_tmps");
        #
        $info = $plate_conts->find($id);
        $list = $sys_tmps->where(["types" => $info["price_type"]])->order("id desc")->select();
        #
        $this->assign("info", $info);
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 板块详情广告-单商品-添加模板数据
     */
    public function plate_conts_list_temp() {
        $sys_tmps_logs = M("sys_tmps_logs");
        $plate_conts_logs = M("plate_conts_logs");
        $post = I("post.");
        #
        $plate_conts_logs->startTrans();
        $list = $sys_tmps_logs->where(["pid" => $post["ids"]])->order("id desc")->select();
        foreach ($list as $k => $v) {
            unset($v["id"]);
            unset($v["pid"]);
            unset($v["name"]);
            #
            $last = $plate_conts_logs->query("SHOW TABLE STATUS LIKE 'plate_conts_logs'");
            #
            $v["pid"] = $post["pid"];
            $v["cat_index"] = $post["cat_index"];
            $v["ptype"] = $post["ptype"];
            $v["sorts"] = $last[0]["auto_increment"];
            $v["status"] = 1;
            $v["uptimes"] = 0;
            $v["times"] = time();
            #
            if (!$plate_conts_logs->add($v)) {
                $plate_conts_logs->rollback();
                return get_op_put(0, "添加失败");
            }
        }
        #
        $plate_conts_logs->commit();
        return get_op_put(1, "添加成功");
    }

    /**
     * 板块详情广告-单商品-导入模板数据
     */
    public function plate_conts_import() {
        ini_set('memory_limit', '512M');
        vendor("PHPExcel.PHPExcel");
        $plate_conts_logs = M("plate_conts_logs");
        $post = I("post.");
        $file        = uploadFile("tmps", isset($_FILES['file']) ? array('file' => $_FILES['file']) : null);
        if (!$file) return get_op_put(0, "文件上传失败");
        $filePath    = "./././Public/uploads/tmps/" . $file["file"]["savename"];
        $objPHPExcel = \PHPExcel_IOFactory::load($filePath);
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount  = $objPHPExcel->getActiveSheet()->getHighestRow();
        $colCount  = $objPHPExcel->getActiveSheet()->getHighestColumn();
        $headerArr = array();
        $dataArr   = array();
        for ($row = 1; $row <= $rowCount; $row++) {
            $rowData = array();
            for ($column = 'A'; $column <= $colCount; $column++) {
                $cell = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                if (is_object($cell)) $cell = $cell->__toString();
                $rowData[] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $cell);
            }
            if ($row === 1) {
                $headerArr = $rowData;
            } else {
                // 跳过全空行（PHPExcel 会把有格式无内容的行也读出来）
                if (strlen(implode('', $rowData)) > 0) {
                    $dataArr[] = $rowData;
                }
            }
        }
        unlink($filePath);
        if (count($dataArr) < 1) {
            return get_op_put(0, "没有导入数据");
        }
        // 列名从第1行读取（A供货方式 B质量标准 C执行标准 D起订数量 E计量单位 F产品型号 G电压等级 H产品规格 I溢价率 J发货时效）
        $keyNames = array(
            'key_0' => isset($headerArr[0]) ? $headerArr[0] : '供货方式',
            'key_1' => isset($headerArr[1]) ? $headerArr[1] : '质量标准',
            'key_2' => isset($headerArr[2]) ? $headerArr[2] : '执行标准',
            'key_3' => isset($headerArr[3]) ? $headerArr[3] : '起订数量',
            'key_4' => isset($headerArr[4]) ? $headerArr[4] : '计量单位',
            'key_5' => isset($headerArr[5]) ? $headerArr[5] : '产品型号',
            'key_6' => isset($headerArr[6]) ? $headerArr[6] : '电压等级',
            'key_7' => isset($headerArr[7]) ? $headerArr[7] : '产品规格',
            'key_8' => isset($headerArr[9]) ? $headerArr[9] : '发货时效',
        );
        $list = $dataArr;

        $cxmark = D("Home/Cxmark", "Opera");
        // 找到对应 blank
        $importBlank   = M('plate_conts_blank')->where(array('pid'=>$post['pid'],'cat_index'=>$post['cat_index']))->field('id')->find();
        $importBlankId = $importBlank ? $importBlank['id'] : 0;
        $numberCount   = 0;
        $countWhere    = $importBlankId > 0 ? array('blank_id'=>$importBlankId) : array('pid'=>$post['pid'],'cat_index'=>$post["cat_index"]);
        $count         = $plate_conts_logs->where($countWhere)->count();
        if ($count > 0) $numberCount = $count;

        foreach ($list as $k => $v) {
            $number = $numberCount + $k + 1;
            $temp   = array_merge($keyNames, array(
                "pid"       => $post["pid"],
                "blank_id"  => $importBlankId,
                "cat_index" => $post["cat_index"],
                "type"      => 0,
                "ptype"     => $post["ptype"],
                "sorts"     => $number,
                "value_0"   => isset($v[0]) ? $v[0] : '',
                "value_1"   => isset($v[1]) ? $v[1] : '',
                "value_2"   => isset($v[2]) ? $v[2] : '',
                "value_3"   => isset($v[3]) ? $v[3] : '',
                "value_4"   => isset($v[4]) ? $v[4] : '',
                "value_5"   => isset($v[5]) ? $v[5] : '',
                "value_6"   => isset($v[6]) ? $v[6] : '',
                "value_7"   => isset($v[7]) ? $v[7] : '',
                "dratio"    => (float)(isset($v[8]) && $v[8] !== '' ? $v[8] : 0),
                "trans"     => isset($v[9]) ? $v[9] : '',
                "value_8"   => isset($v[9]) ? $v[9] : '',
                "price"     => 0,
                "status"    => 1,
                "uptimes"   => 0,
                "times"     => time(),
                "number"    => $number,
            ));
            $market         = $cxmark->runs($temp);
            $temp["market"] = $market["data"]['market'];
            $temp["price"]  = $market["data"]['price'];
            $temp["weight"] = isset($market["data"]['weight']) ? $market["data"]['weight'] : 0;
            if (!$plate_conts_logs->add($temp)) continue;
        }
        #
        return get_op_put(1, null, 1);
    }

    /**
     * 清空数据
     */
    public function plate_conts_clearblank() {
        $plate_conts_blank = M("plate_conts_blank");
        $post = I("post.");
        #
        $where = ["pid" => $post["pid"], "cat_index" => $post["cat_index"]];
        if (!$plate_conts_blank->where($where)->delete()) {
            return get_op_put(0, "删除失败");
        }
        return get_op_put(1, "删除成功");
    }

    /**
     * 清空数据
     */
    public function plate_conts_clearlog() {
        $plate_conts_logs  = M("plate_conts_logs");
        $plate_conts_logsr = M("plate_conts_logsr");
        $post = I("post.");
        #
        // 支持 blank_id（新）或 pid+cat_index（兼容旧）
        if (!empty($post['blank_id'])) {
            $blankId = (int)$post['blank_id'];
        } else {
            $bl = M('plate_conts_blank')->where(array('pid'=>$post['pid'],'cat_index'=>$post['cat_index']))->field('id')->find();
            $blankId = $bl ? $bl['id'] : 0;
        }
        $where = $blankId > 0
            ? array('blank_id' => $blankId)
            : array('pid' => $post['pid'], 'cat_index' => $post['cat_index']);
        $logsrCond = $blankId > 0
            ? "pid in (select id from plate_conts_logs where blank_id=$blankId)"
            : "pid in (select id from plate_conts_logs where pid='" . $post["pid"] . "' and cat_index='" . $post["cat_index"] . "')";
        # 1. 清空子规格
        $plate_conts_logsr->where(array('_string' => $logsrCond))->delete();
        # 2. 清空主规格
        $plate_conts_logs->where($where)->delete();
        # logs_only=1 时只清规格数据，不清属性价格和 blank 字段
        if (!empty($post['logs_only'])) {
            return get_op_put(1, "清空成功");
        }
        # 3. 清空属性价格
        if ($blankId > 0) {
            M('plate_conts_price')->where(array('blank_id' => $blankId))->delete();
        }
        # 4. 重置 blank 字段（保留 blank 记录，仅清空内容）
        if ($blankId > 0) {
            M('plate_conts_blank')->where(array('id' => $blankId))->save(array(
                'gnames'       => '',
                'gimage'       => '',
                'source'       => json_encode(array('')),
                'new_tax_id'   => 0,
                'uptimes'      => time(),
            ));
        }
        return get_op_put(1, "清空成功");
    }

    // ==================== 标准选项分组 CRUD ====================

    public function group_save() {
        $data = I('post.');
        if (empty($data['id'])) return get_op_put(0, '标准选项为全局固定分组，不支持新增');
        if (empty($data['name'])) return get_op_put(0, '请填写选项卡名称');
        $save = array(
            'name'    => $data['name'],
            'ratio'   => isset($data['ratio']) ? (float)$data['ratio'] : 1,
            'up_time' => time(),
        );
        M('plate_conts_blank_group')->where(array('id' => (int)$data['id']))->save($save);
        return get_op_put(1, '更新成功');
    }

    /**
     * 复制标准选项全量数据到目标选项
     * 步骤：清空目标分组 → 逐条复制源分组的 blank + price + logs + logsr
     */
    public function group_copy_from() {
        $pid     = (int)I('post.pid');
        $fromGid = (int)I('post.from_group_id');
        $toGid   = (int)I('post.to_group_id');
        if (!$pid || !$fromGid || !$toGid || $fromGid === $toGid) return get_op_put(0, '参数错误');

        // 1. 清空目标分组现有数据
        $tgtBlanks = M('plate_conts_blank')->where(array('pid' => $pid, 'group_id' => $toGid, 'status' => 1))->field('id')->select();
        foreach ($tgtBlanks as $tb) {
            $tbId = (int)$tb['id'];
            $logIds = M('plate_conts_logs')->where(array('blank_id' => $tbId))->field('id')->select();
            if ($logIds) {
                M('plate_conts_logsr')->where(array('pid' => array('in', array_column($logIds, 'id'))))->delete();
            }
            M('plate_conts_logs')->where(array('blank_id' => $tbId))->delete();
            M('plate_conts_price')->where(array('blank_id' => $tbId))->delete();
            M('plate_conts_blank')->where(array('id' => $tbId))->delete();
        }

        // 2. 读取源分组所有 blank
        $srcBlanks = M('plate_conts_blank')->where(array('pid' => $pid, 'group_id' => $fromGid, 'status' => 1))->order('sorts asc, cat_index asc')->select();
        if (!$srcBlanks) return get_op_put(1, '复制完成（源无数据）');

        $blankModel = M('plate_conts_blank');
        $logsModel  = M('plate_conts_logs');
        $logsrModel = M('plate_conts_logsr');
        $priceModel = M('plate_conts_price');

        foreach ($srcBlanks as $src) {
            // 2a. 复制 blank
            $newBlank = array(
                'pid'          => $pid,
                'group_id'     => $toGid,
                'cat_index'    => $src['cat_index'],
                'catname'      => $src['catname'],
                'sorts'        => $src['sorts'],
                'gnames'       => $src['gnames'],
                'gimage'       => $src['gimage'],
                'source'       => $src['source'],
                'new_tax_id'   => $src['new_tax_id'],
                'ticket_nor'   => $src['ticket_nor'],
                'ticket_person'=> $src['ticket_person'],
                'up_a'         => $src['up_a'],
                'down_a'       => $src['down_a'],
                'up_b'         => $src['up_b'],    'down_b' => $src['down_b'],
                'up_c'         => $src['up_c'],    'down_c' => $src['down_c'],
                'up_d'         => $src['up_d'],    'down_d' => $src['down_d'],
                'up_e'         => $src['up_e'],    'down_e' => $src['down_e'],
                'up_f'         => $src['up_f'],    'down_f' => $src['down_f'],
                'status'       => 1,
                'times'        => time(),
                'uptimes'      => time(),
            );
            $newBlankId = $blankModel->add($newBlank);
            if (!$newBlankId) continue;

            // 2b. 复制属性价格 (plate_conts_price)
            $srcPrices = $priceModel->where(array('blank_id' => $src['id'], 'is_del' => 1))->select();
            foreach ($srcPrices as $sp) {
                unset($sp['id']);
                $sp['blank_id']       = $newBlankId;
                $sp['plate_conts_id'] = $pid;
                $sp['add_time']       = time();
                $sp['up_time']        = time();
                $priceModel->add($sp);
            }

            // 2c. 复制主规格 (plate_conts_logs) 及子规格 (plate_conts_logsr)
            $srcLogs = $logsModel->where(array('blank_id' => $src['id']))->order('number asc, id asc')->select();
            foreach ($srcLogs as $l) {
                $oldLogId = $l['id'];
                unset($l['id']);
                $l['blank_id'] = $newBlankId;
                $l['uptimes']  = time();
                $newLogId = $logsModel->add($l);
                if (!$newLogId) continue;

                // 复制子规格
                $srcLogsr = $logsrModel->where(array('pid' => $oldLogId))->order('sorts asc, id asc')->select();
                foreach ($srcLogsr as $lr) {
                    unset($lr['id']);
                    $lr['pid']     = $newLogId;
                    $lr['uptimes'] = time();
                    $logsrModel->add($lr);
                }
            }
        }
        return get_op_put(1, '复制成功');
    }

    public function group_clear() {
        $pid      = (int)I('post.pid');
        $group_id = (int)I('post.group_id');
        if (!$pid || !$group_id) return get_op_put(0, '参数错误');

        // 找到该分组下所有 blank
        $blanks = M('plate_conts_blank')->where(array('pid' => $pid, 'group_id' => $group_id, 'status' => 1))->field('id, cat_index')->select();
        if (!$blanks) return get_op_put(1, '清空成功（无数据）');

        $blankModel = M('plate_conts_blank');
        foreach ($blanks as $b) {
            $blankId = (int)$b['id'];
            $logsWhere = $blankId > 0
                ? array('blank_id' => $blankId)
                : array('pid' => $pid, 'cat_index' => $b['cat_index']);

            // 0. 删除图片物理文件
            $blankFull = $blankModel->where(array('id' => $blankId))->find();
            $this->deleteBlankFiles($blankFull);

            // 1. 清空子规格 (plate_conts_logsr)
            $logsIds = M('plate_conts_logs')->where($logsWhere)->field('id')->select();
            if ($logsIds) {
                $idArr = array_column($logsIds, 'id');
                M('plate_conts_logsr')->where(array('pid' => array('in', $idArr)))->delete();
            }
            // 2. 清空主规格 (plate_conts_logs)
            M('plate_conts_logs')->where($logsWhere)->delete();
            // 3. 清空属性价格 (plate_conts_price)
            if ($blankId > 0) {
                M('plate_conts_price')->where(array('blank_id' => $blankId))->delete();
            }
            // 4. 删除商品属性记录
            M('plate_conts_blank')->where(array('id' => $blankId))->delete();
        }
        return get_op_put(1, '清空成功');
    }

    public function group_del() {
        return get_op_put(0, '标准选项为全局固定分组，不支持删除');
    }

    /**
     * 复制板块全量数据（blank设置 + price列表 + logs规格行）
     */
    public function plate_conts_copy_block() {
        $post     = I('post.');
        $pid      = (int)$post['pid'];
        $from     = (int)$post['from_cat_index'];
        $to       = (int)$post['to_cat_index'];
        $groupId  = (int)$post['group_id'];

        if (!$pid || !$from || !$to || $from === $to) {
            return get_op_put(0, '参数错误');
        }

        // 1. 复制 blank 设置（保留目标 catname，其余覆盖）
        // 加 group_id 过滤，避免多分组下同 cat_index 取到错误分组的 blank
        $blankWhere = $groupId > 0
            ? array('pid' => $pid, 'cat_index' => $from, 'group_id' => $groupId)
            : array('pid' => $pid, 'cat_index' => $from);
        $srcBlank = M('plate_conts_blank')->where($blankWhere)->find();
        if ($srcBlank) {
            $tgtWhere = $groupId > 0
                ? array('pid' => $pid, 'cat_index' => $to, 'group_id' => $groupId)
                : array('pid' => $pid, 'cat_index' => $to);
            $tgtBlank = M('plate_conts_blank')->where($tgtWhere)->find();
            $saveBlank = array(
                'gnames'        => $srcBlank['gnames'],
                'gimage'        => $srcBlank['gimage'],
                'source'        => $srcBlank['source'],
                'new_tax_id'    => $srcBlank['new_tax_id'],
                'ticket_nor'    => $srcBlank['ticket_nor'],
                'ticket_person' => $srcBlank['ticket_person'],
                'up_a' => $srcBlank['up_a'], 'down_a' => $srcBlank['down_a'],
                'up_b' => $srcBlank['up_b'], 'down_b' => $srcBlank['down_b'],
                'up_c' => $srcBlank['up_c'], 'down_c' => $srcBlank['down_c'],
                'uptimes' => time(),
            );
            if ($tgtBlank) {
                M('plate_conts_blank')->where($tgtWhere)->save($saveBlank);
            } else {
                $saveBlank['pid']       = $pid;
                $saveBlank['cat_index'] = $to;
                $saveBlank['catname']   = $srcBlank['catname'];
                $saveBlank['status']    = 1;
                $saveBlank['times']     = time();
                M('plate_conts_blank')->add($saveBlank);
            }
        }

        // 重新获取 blank id（已存在或刚创建）
        $srcBlankId = $srcBlank ? $srcBlank['id'] : 0;
        $fallbackWhere = $groupId > 0
            ? array('pid' => $pid, 'cat_index' => $to, 'group_id' => $groupId)
            : array('pid' => $pid, 'cat_index' => $to);
        $tgtBlankId = $tgtBlank ? $tgtBlank['id']
            : (int)M('plate_conts_blank')->where($fallbackWhere)->getField('id');

        // 2. 复制 price 列表（用 blank_id）
        if ($srcBlankId && $tgtBlankId) {
            M('plate_conts_price')->where(array('blank_id' => $tgtBlankId))->delete();
            $srcPrices = M('plate_conts_price')->where(array('blank_id' => $srcBlankId, 'is_del' => 1))->select();
            foreach ($srcPrices as $p) {
                unset($p['id']); $p['blank_id'] = $tgtBlankId; $p['cat_index'] = $to;
                M('plate_conts_price')->add($p);
            }
        }

        // 3. 复制 logs 规格行（用 blank_id）
        if ($srcBlankId && $tgtBlankId) {
            M('plate_conts_logs')->where(array('blank_id' => $tgtBlankId))->delete();
            $srcLogs = M('plate_conts_logs')->where(array('blank_id' => $srcBlankId))->order('number asc, id asc')->select();
            foreach ($srcLogs as $l) {
                unset($l['id']); $l['blank_id'] = $tgtBlankId; $l['cat_index'] = $to; $l['uptimes'] = time();
                M('plate_conts_logs')->add($l);
            }
        }

        return get_op_put(1, '复制成功');
    }

    /**
     * 清空板块指定字段（商品名称、图片、banner、税率），不删除记录
     */
    public function plate_conts_blank_fields_clear() {
        $post  = I('post.');
        $where = array('pid' => $post['pid'], 'cat_index' => $post['cat_index']);
        $blank = M('plate_conts_blank')->where($where)->find();
        $this->deleteBlankFiles($blank);
        $save  = array(
            'gnames'        => '',
            'gimage'        => '',
            'source'        => json_encode(array('')),
            'new_tax_id'    => 0,
            'ticket_nor'    => 0,
            'ticket_person' => 0,
            'uptimes'       => time(),
        );
        M('plate_conts_blank')->where($where)->save($save);
        return get_op_put(1, '已清空');
    }

    /**
     * 删除整个板块（blank + logs）
     */
    public function plate_conts_del_block() {
        $post  = I("post.");
        $blank = M('plate_conts_blank')->where(array('pid' => $post['pid'], 'cat_index' => $post['cat_index']))->find();
        if ($blank) {
            $blankId = (int)$blank['id'];
            $this->deleteBlankFiles($blank);
            $logIds = M('plate_conts_logs')->where(array('blank_id' => $blankId))->field('id')->select();
            if ($logIds) {
                M('plate_conts_logsr')->where(array('pid' => array('in', array_column($logIds, 'id'))))->delete();
            }
            M('plate_conts_logs')->where(array('blank_id' => $blankId))->delete();
            M('plate_conts_price')->where(array('blank_id' => $blankId))->delete();
            M('plate_conts_blank')->where(array('id' => $blankId))->delete();
        }
        return get_op_put(1, "删除成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 统计板块商品-判断是否第一次添加
     */
    public function plate_conts_listCov() {
        $plate_conts_logs = M("plate_conts_logs");
        $post = I("post.");
        #
        $where["pid"] = $post["pid"];
        $info = $plate_conts_logs->where($where)->order("id desc")->find();
        if ($info == null) {
            return get_op_put(1, null, 0);
        }
        $last = $plate_conts_logs->query("SHOW TABLE STATUS LIKE 'plate_conts_logs'");
        #
        $post["key_0"] = $info["key_0"];
        $post["key_1"] = $info["key_1"];
        $post["key_2"] = $info["key_2"];
        $post["trans"] = $info["trans"];
        $post["sorts"] = $last[0]["auto_increment"];
        $post["status"] = 1;
        $post["uptimes"] = 0;
        $post["times"] = time();
        if (!$plate_conts_logs->add($post)) {
            return get_op_put(0, "添加失败");
        }
        return get_op_put(1, null, 1);
    }

    /**
     * 板块详情广告-获取板块费率详情
     */
    public function plate_conts_blankr() {
        $plate_conts_blank = M("plate_conts_blank");
        $plate_conts_logs = M("plate_conts_logs");
        $plate_conts_logsr = M("plate_conts_logsr");
        $post = I("post.");
        #
        // 必须提供 blank_id 或 pid+cat_index，否则拒绝执行防止全表扫描
        if (empty($post['blank_id']) && (empty($post['pid']) || !isset($post['cat_index']))) {
            return get_op_put(0, '参数错误');
        }
        #
        $where["pid"] = (int)$post["pid"];
        $where["cat_index"] = (int)$post["cat_index"];
        #
        // 优先用 blank_id 精准定位，避免同 cat_index 不同分组返回错误 blank
        // 统一加 status=1，确保与 all_blanks 过滤条件一致
        if (!empty($post['blank_id'])) {
            $res["info"] = $plate_conts_blank->where(array('id' => (int)$post['blank_id'], 'status' => 1))->find();
        } else {
            $res["info"] = $plate_conts_blank->where(array_merge($where, array('status' => 1)))->find();
        }
        if (!empty($res["info"])) {
            $res["info"]["source"] = json_decode($res["info"]["source"], true);
        }
        $blankId  = isset($res["info"]["id"]) ? (int)$res["info"]["id"] : 0;
        $logWhere = $blankId > 0 ? array('blank_id' => $blankId) : $where;
        $list = $plate_conts_logs->where($logWhere)->order("number asc,id asc")->select();
        foreach ($list as $k => $v) {
            if ($v["ptype"] > 1) continue;
            $list[$k]["child"] = $plate_conts_logsr->where(["pid" => $v["id"]])->order("sorts desc")->select();
        }
        $keya = $plate_conts_logs->where($logWhere)->field("key_0")->group("key_0")->find();
        $keyb = $plate_conts_logs->where($logWhere)->field("key_1")->group("key_1")->find();
        $keyc = $plate_conts_logs->where($logWhere)->field("key_2")->group("key_2")->find();
        $keyd = $plate_conts_logs->where($logWhere)->field("key_3")->group("key_3")->find();
        $keye = $plate_conts_logs->where($logWhere)->field("key_4")->group("key_4")->find();
        $keyf = $plate_conts_logs->where($logWhere)->field("key_5")->group("key_5")->find();
        $keyg = $plate_conts_logs->where($logWhere)->field("key_6")->group("key_6")->find();
        $keyh = $plate_conts_logs->where($logWhere)->field("key_7")->group("key_7")->find();
        $keyi = $plate_conts_logs->where($logWhere)->field("key_8")->group("key_8")->find();
        $res["key"] = array(
            "keya" => $keya['key_0'], "keyb" => $keyb['key_1'], "keyc" => $keyc['key_2'],
            "keyd" => $keyd['key_3'], "keye" => $keye['key_4'],
            "keyf" => $keyf['key_5'], "keyg" => $keyg['key_6'], "keyh" => $keyh['key_7'],
            "keyi" => $keyi['key_8'] ? $keyi['key_8'] : '发货时效',
        );
        $res["list"] = $list;
        $tax_list = M('new_tax')->where(['is_del'=>1])->select();
        $res["tax_list"] = $tax_list;
        // 严格按 blank_id 关联查询属性价格
        $blankId    = isset($res["info"]["id"]) ? (int)$res["info"]["id"] : 0;
        $price_list = $blankId > 0
            ? M('plate_conts_price')->where(array('blank_id' => $blankId, 'is_del' => 1))->order('sort asc, id asc')->select()
            : array();
        $res["price_list"] = $price_list;
        // 返回该商品下所有板块列表（供商品属性管理卡片展示）
        $res["all_blanks"] = M('plate_conts_blank')->where(['pid'=>$post["pid"], 'status'=>1])->order('sorts asc, cat_index asc')->select();
        // 返回标准选项分组列表
        $pid = (int)$post["pid"];
        $group_list = M('plate_conts_blank_group')->where(['pid' => $pid])->order('sort asc, id asc')->select();
        // 新 pid 首次访问自动初始化 10 个分组
        if (empty($group_list) && $pid > 0) {
            $groupInsert = array();
            for ($i = 1; $i <= 10; $i++) {
                $groupInsert[] = array('pid' => $pid, 'name' => '标准选项卡' . $i, 'ratio' => 100.0, 'sort' => $i, 'add_time' => time(), 'up_time' => time());
            }
            M('plate_conts_blank_group')->addAll($groupInsert);
            $group_list = M('plate_conts_blank_group')->where(['pid' => $pid])->order('sort asc, id asc')->select();
        }
        $res["group_list"] = $group_list;
        #
        return get_op_put(1, "获取成功", $res);
    }

    /**
     * 板块详情广告-更新板块费率
     */
    public function plate_conts_blank() {
        $blrenew = D("Home/Blrenew", "Opera");
        $post = I("post.");
        #
        $res = $blrenew->runs($post);
        return get_op_put($res["status"], $res["msg"], $res["data"]);
    }

    /**
     * 板块详情广告-图片更新上传
     */
    public function plate_conts_upload() {
        return get_op_put(0, "图片上传功能暂时关闭");
        $plate_conts_blank = M("plate_conts_blank");
        $post = I("post.");
        #
        $file = uploadFile("banner");
        if (!$file) {
            return get_op_put(0, "文件上传失败");
        }
        #
        $count = $this->plate_conts_check($post);
        if ($count["count"] != NULL) {
            $imgs = array_filter(json_decode($count["count"]["source"], true));
            array_push($imgs, $file["file"]["savename"]);
            if ($imgs == null || $imgs == "" || $imgs == "null") {
                $imgs = [$file["file"]["savename"]];
            }
            $post["source"] = json_encode($imgs, true);
            $post["uptimes"] = time();
            #
            if (!$plate_conts_blank->where($count["where"])->save($post)) {
                return get_op_put(0, "更新失败");
            }
            return get_op_put(1, "更新成功");
        }
        #
        $post["source"] = json_encode([$file["file"]["savename"]], true);
        $post["status"] = 1;
        $post["times"] = time();
        if (!$plate_conts_blank->add($post)) {
            return get_op_put(0, "更新失败");
        }
        return get_op_put(1, "更新成功");
    }

    /**
     * 板块详情广告-图片更新上传2
     */
    public function plate_conts_gimgs() {
        $post = I("post.");
        #
        $file = '';
        $file2 = '';
        if(isset($_FILES['file'])){
             $file = uploadFile("goods",['goods'=>$_FILES['file']]);//var_dump($file);
        }
       
        // var_dump($_FILES['file']);
        // var_dump($_FILES['banner']);die;
        if(isset($_FILES['banner'])){
            $file2 = uploadFile("banner",['banner'=>$_FILES['banner']]);
        }
        
        if ($file || $file2) {//var_dump(111);
            if(isset($file['goods']) && $file['goods']){
                $post["gimage"] = $file["goods"]["savename"];
            }
            if(isset($file2['banner']) && $file2['banner']){
                $imgs = $file2["banner"]["savename"];
                $source[0]= $imgs;
                $post['source'] = json_encode($source,true);
            }else{
                unset($post["source"]);
            }
        }else{
            unset($post["source"]);
        }

    // var_dump($post);die;
        #
        return $this->plate_conts_imageup($post);
    }

    /**
     * 板块详情广告-图片更新上传-图片更新
     * @param type $post
     * @return type
     */
    private function plate_conts_imageup($post) {
        $plate_conts_blank = M("plate_conts_blank");
        #
        $post["uptimes"] = time();
        $count = $this->plate_conts_check($post);
        #
        // unset($post["source"]);
        if(isset($post['new_tax_id']) && $post['new_tax_id'] > 0){
            if($post['new_tax_id'] <= 0){
                return get_op_put(0, "发票税率不能为空");
            }
            $tax = M('new_tax')->where(['id'=>$post['new_tax_id']])->find();
            if(!$tax){
                return get_op_put(0, "发票税率未找到");
            }
            $post['ticket_nor'] = $tax['normal_tax'];
            $post['ticket_person'] = $tax['special_tax'];
        }
        // 防止 $post 中携带的 id/blank_id 等字段干扰 UPDATE
        unset($post['id'], $post['blank_id'], $post['group_id']);
        if ($count["count"] != NULL) {
            // 替换图片前删除旧文件
            $oldBlank = $plate_conts_blank->where($count["where"])->find();
            if ($oldBlank) {
                if (isset($post['gimage']) && $post['gimage'] !== $oldBlank['gimage'] && !empty($oldBlank['gimage'])) {
                    $old = './Public/uploads/goods/' . $oldBlank['gimage'];
                    if (file_exists($old)) @unlink($old);
                }
                if (isset($post['source'])) {
                    $oldSrcs = json_decode($oldBlank['source'], true) ?: array();
                    $newSrcs = json_decode($post['source'], true) ?: array();
                    foreach (array_diff($oldSrcs, $newSrcs) as $del) {
                        if (empty($del)) continue;
                        $p = './Public/uploads/banner/' . $del;
                        if (file_exists($p)) @unlink($p);
                    }
                }
            }
            if (!$plate_conts_blank->where($count["where"])->save($post)) {
                return get_op_put(0, "更新失败");
            }
            return get_op_put(1, "更新成功");
        }
        $post["status"] = 1;
        $post["times"] = time();
        if (!$plate_conts_blank->add($post)) {
            return get_op_put(0, "更新失败");
        }
        return get_op_put(1, "更新成功");
    }

    /**
     * 板块详情广告-图片更新上传-检索板块是否存在
     * @param type $post
     */
    private function plate_conts_check($post) {
        $plate_conts_blank = M("plate_conts_blank");
        #
        $where["pid"] = $post["pid"];
        $where["cat_index"] = $post["cat_index"];
        $count = $plate_conts_blank->where($where)->find();
        #
        return ["where" => $where, "count" => $count];
    }

    /**
     * 删除板块图片
     */
    public function plate_conts_del() {
        $plate_conts_blank = M("plate_conts_blank");
        $post = I("post.");
        #
        $where["pid"] = $post["pid"];
        $where["cat_index"] = $post["cat_index"];
        $info = $plate_conts_blank->where($where)->find();
        if ($info == NULL) {
            return get_op_put(0, "板块信息异常");
        }
        $image = json_decode($info["source"], true);
        // 刪除被移除的圖片物理文件
        if (isset($image[$post["index"]]) && !empty($image[$post["index"]])) {
            $delPath = './Public/uploads/banner/' . $image[$post["index"]];
            if (file_exists($delPath)) @unlink($delPath);
        }
        unset($image[$post["index"]]);
        #
        $save["source"] = json_encode(array_values($image), true);
        $save["uptimes"] = time();
        if (!$plate_conts_blank->where($where)->save($save)) {
            return get_op_put(0, "更新失败");
        }
        return get_op_put(1, "更新成功");
    }

    /**
     * 删除 blank 关联的图片物理文件
     * @param array $blank  plate_conts_blank 记录（含 gimage、source 字段）
     */
    private function deleteBlankFiles($blank) {
        if (empty($blank)) return;
        // 删除商品图片
        if (!empty($blank['gimage'])) {
            $path = './Public/uploads/goods/' . $blank['gimage'];
            if (file_exists($path)) @unlink($path);
        }
        // 删除 banner 图片（source 为 JSON 数组）
        $sources = json_decode($blank['source'], true);
        if (is_array($sources)) {
            foreach ($sources as $img) {
                if (empty($img)) continue;
                $path = './Public/uploads/banner/' . $img;
                if (file_exists($path)) @unlink($path);
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 板块详情广告-更新商品
     */
    public function plate_conts_update() {
        $blwares = D("Home/Blwares", "Opera");
        $post = I("post.");
        #
        $res = $blwares->runs($post);
        return get_op_put($res["status"], $res["msg"], $res["data"]);
    }

    /**
     * 
     */
    public function plate_conts_version() {
        $plate_conts_blank = M("plate_conts_blank");
        #
        $where["source"] = array("exp", "IS NOT NULL");
        $list = $plate_conts_blank->where($where)->select();
        #
        foreach ($list as $k => $v) {
            $cond["id"] = $v["id"];
            #
            $save["source"] = json_encode([$v["source"]], true);
            $plate_conts_blank->where($cond)->save($save);
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 商品模板
     */
    public function tmps() {
        $sys_tmps = M("sys_tmps");
        #
        $list = boPage($sys_tmps, $where, "id desc");
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 商品模板-添加
     */
    public function tmps_addon() {
        $uptems = D("Home/Uptems", "Opera");
        $sys_tmps_logs = M("sys_tmps_logs");
        $post = I("post.");
        #
        if ($post["type"] == "2") {
            $sys_tmps_logs->where(["pid" => $post["ids"]])->delete();
        }
        #
        $uptems->runs($post);
    }

    /**
     * 商品模板-清空
     * @return type
     */
    public function tmps_clear() {
        $sys_tmps_logs = M("sys_tmps_logs");
        $post = I("post.");
        #
        if (!$sys_tmps_logs->where(["pid" => $post["id"]])->delete()) {
            return get_op_put(0, "清空失败");
        }
        return get_op_put(1, "清空完成");
    }

    /**
     * 商品模板-删除
     */
    public function tmps_dels() {
        $sys_tmps = M("sys_tmps");
        $sys_tmps_logs = M("sys_tmps_logs");
        $post = I("post.");
        #
        $sys_tmps->startTrans();
        if (!$sys_tmps->where(["id" => $post["id"]])->delete()) {
            $sys_tmps->rollback();
            return get_op_put(0, "删除失败");
        }
        if (!$sys_tmps_logs->where(["pid" => $post["id"]])->delete()) {
            
        }
        $sys_tmps->commit();
        return get_op_put(1, "删除完成");
    }

    /**
     * 商品模板-日志
     */
    public function tmps_log($id) {
        $sys_tmps = M("sys_tmps");
        $sys_tmps_logs = M("sys_tmps_logs");
        #
        $info = $sys_tmps->where(["id" => $id])->find();
        $where["pid"] = $id;
        $list = boPage($sys_tmps_logs, $where);
        #
        $this->assign("info", $info);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 添加记录
     */
    public function tmps_log_add() {
        $sys_tmps_logs = M("sys_tmps_logs");
        $post = I("post.");
        #
        $where["pid"] = $post["id"];
        $info = $sys_tmps_logs->where($where)->order("id desc")->find();
        #
        $info["name"] = null;
        $info["value_0"] = null;
        $info["value_1"] = null;
        $info["value_2"] = null;
        unset($info["id"]);
        #
        if (!$sys_tmps_logs->add($info)) {
            return get_op_put(0, "添加失败");
        }
        return get_op_put(1, "添加完成");
    }

}
