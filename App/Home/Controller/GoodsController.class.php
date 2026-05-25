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
        vendor("PHPExcel.PHPExcel");
        $plate_conts_logs = M("plate_conts_logs");
        $post = I("post.");
        #
        #导入数据
        $file = uploadFile("tmps");
        $objPHPExcel = \PHPExcel_IOFactory::load("./././Public/uploads/tmps/" . $file["file"]["savename"]);
        $sheetSelected = 0;
        $objPHPExcel->setActiveSheetIndex($sheetSelected);
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
        $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
        $dataArr = array();
        for ($row = 2; $row <= $rowCount; $row++) {
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $cell = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                if (is_object($cell)) {
                    $cell = $cell->__toString();
                }
                $dataArr[$row][] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $cell);
            }
        }
        unlink("./././Public/uploads/tmps/" . $file["file"]["savename"]);
        if (count($dataArr) < 1) {
            return get_op_put(0, "没有导入数据");
        }
        $list = array_reverse($dataArr);
        $list = array_reverse($list);
        $cxmark = D("Home/Cxmark", "Opera");
        $numberCount = 0;
        $count = $plate_conts_logs->where(['pid'=>$post['pid'],'cat_index'=>$post["cat_index"]])->count();
        if($count > 0) {
            $numberCount = $count;
        }
        #设置导入数据
        foreach ($list as $k => $v) {
            $last = $plate_conts_logs->query("SHOW TABLE STATUS LIKE 'plate_conts_logs'");
            #
            $number = $numberCount + $k + 1;
            $temp = array(
                "pid" => $post["pid"],
                "cat_index" => $post["cat_index"],
                "type" => 0,
                "ptype" => $post["ptype"],
                "sorts" => $last[0]["auto_increment"],
                "key_0" => $v[0],
                "value_0" => $v[1],
                "key_1" => $v[2],
                "value_1" => $v[3],
                "key_2" => $v[4],
                "value_2" => $v[5],
                "key_3" => $v[6],
                "value_3" => $v[7],
                "key_4" => $v[8],
                "value_4" => $v[9],
                "price" => 0,
                "dratio" => $v[10],
                "trans" => $v[11],
                "status" => 1,
                "uptimes" => 0,
                "times" => time(),
                "number" => $number
            );
            $market = $cxmark->runs($temp);
            $temp["market"] = $market["data"]['market'];
            $temp["price"] = $market["data"]['price'];
            #
            if (!$plate_conts_logs->add($temp)) {
                continue;
            }
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
        $plate_conts_logs = M("plate_conts_logs");
        $plate_conts_logsr = M("plate_conts_logsr");
        $post = I("post.");
        #
        $where = ["pid" => $post["pid"], "cat_index" => $post["cat_index"]];
        if ($post["ptype"] == 2) {
            if (!$plate_conts_logs->where($where)->delete()) {
                return get_op_put(0, "删除失败");
            }
            return get_op_put(1, "删除成功");
        }
        #
        $logsr["_string"] = "pid in (select id from plate_conts_logs where pid='" . $post["pid"] . "' and cat_index='" . $post["cat_index"] . "')";
        if (!$plate_conts_logsr->where($logsr)->delete()) {
            return get_op_put(0, "删除失败");
        }
        if (!$plate_conts_logs->where($where)->delete()) {
            //return get_op_put(0, "删除失败");
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
        $where["pid"] = $post["pid"];
        $where["cat_index"] = $post["cat_index"];
        #
        $res["info"] = $plate_conts_blank->where($where)->find();
        $res["info"]["source"] = json_decode($res["info"]["source"], true);
        $list = $plate_conts_logs->where($where)->order("number asc,id asc")->select();
        foreach ($list as $k => $v) {
            if ($v["ptype"] > 1) {
                continue;
            }
            $list[$k]["child"] = $plate_conts_logsr->where(["pid" => $v["id"]])->order("sorts desc")->select();
        }
        $keya = $plate_conts_logs->where($where)->field("key_0")->group("key_0")->find();
        $keyb = $plate_conts_logs->where($where)->field("key_1")->group("key_1")->find();
        $keyc = $plate_conts_logs->where($where)->field("key_2")->group("key_2")->find();
        $keyd = $plate_conts_logs->where($where)->field("key_3")->group("key_3")->find();
        $keye = $plate_conts_logs->where($where)->field("key_4")->group("key_4")->find();
        $res["key"] = ["keya" => $keya['key_0'], "keyb" => $keyb['key_1'], "keyc" => $keyc['key_2'],"keyd" => $keyd['key_3'],"keye" => $keye['key_4']];
        $res["list"] = $list;
        $tax_list = M('new_tax')->where(['is_del'=>1])->select();
        $res["tax_list"] = $tax_list;
        $price_list = M('plate_conts_price')->where(['cat_index'=>$post["cat_index"]])->where(['plate_conts_id'=>$post["pid"]])->where(['is_del'=>1])->select();
        $res["price_list"] = $price_list;
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
        if ($count["count"] != NULL) {
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
        unset($image[$post["index"]]);
        #
        $save["source"] = json_encode(array_values($image), true);
        $save["uptimes"] = time();
        if (!$plate_conts_blank->where($where)->save($save)) {
            return get_op_put(0, "更新失败");
        }
        return get_op_put(1, "更新成功");
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
