<?php

namespace Home\Opera;

/**
 * Description of BlwaresOpera
 * 更新板块商品
 * @author Administrator
 */
class BlwaresOpera {

    private $param;
    ////
    private $blank;
    private $cats;
    private $lists;

    /**
     * 入口
     */
    public function runs($param) {
        $this->param = $param;
        return $this->getTypes();
    }

    /**
     * 获取商品类别
     */
    private function getTypes() {
        // if ($this->param["type"] > 0) {
        //     return $this->setMoreGoods();
        // }
        return $this->setListGoods();
    }

    /**
     * 列表商品
     */
    private function setListGoods() {
        $plate_conts = M("plate_conts");
        $plate_cats = M("plate_cats");
        $plate_conts_blank = M("plate_conts_blank");
        #
        $conts = $plate_conts->find($this->param["pid"]);
        if ($conts == null) {
            return get_op_res(0, "更新失败[商品信息异常]");
        }
        $where = ["pid" => $this->param["pid"], "cat_index" => $this->param["cat_index"]];
        #
        $this->cats = $plate_cats->find($conts["catid"]);
        $this->blank = $plate_conts_blank->where($where)->find();
        #
        if ($this->blank == NULL) {
            //return get_op_res(0, "更新失败[商品信息异常X2]");
        }
        #
        if(isset($this->param['logs']) && $this->param['logs']){
            $list = json_decode(htmlspecialchars_decode($this->param["logs"]), true);
        }else{//var_dump(333);var_dump($this->param);
            $list = M("plate_conts_logs")
            ->where(['pid'=>$this->param['pid'],"cat_index" => $this->param["cat_index"]])
            ->order('number asc,id asc')
            ->select();
            $pid = $this->param['pid'];
            $cat_index = $this->param['cat_index'];
            $blwares = D("Home/Cxmark", "Opera");
            $plate_conts_logs = D('plate_conts_logs');
            
            // $price_list = M("plate_conts_price")->where(['plate_conts_id'=>$pid,'cat_index'=>$cat_index])->select();
            
            foreach ($list as $k=>$v){//var_dump($v);
                $market = $blwares->runs($v);//var_dump($market);
                $temp["market"] = $market["data"]['market'];
                $temp["price"] = $market["data"]['price'];//var_dump($v['id']);var_dump($temp);die;
                #
                $plate_conts_logs->where(['id'=>$v['id']])->save($temp);
            }
            // $list = M("plate_conts_logs")
            // ->where(['pid'=>$this->param['pid'],"cat_index" => $this->param["cat_index"]])
            // ->order('number asc,id asc')
            // ->select();
            // $this->param["type"] = 0;//var_dump($list[0]);
            // var_dump(444);
             return ['status'=>1,'msg'=>'成功','data'=>[]];
        }
        
        $this->lists = $list;
        return $this->updateListMarket();
    }

    /**
     * 组合商品
     */
    private function setMoreGoods() {
        $plate_conts = M("plate_conts");
        $plate_cats = M("plate_cats");
        $plate_conts_blank = M("plate_conts_blank");
        #
        $conts = $plate_conts->find($this->param["fpid"]);
        if ($conts == null) {
            return get_op_res(0, "更新失败[商品信息异常]");
        }
        $where = ["pid" => $this->param["fpid"], "cat_index" => $this->param["cat_index"]];
        #
        $this->cats = $plate_cats->find($conts["catid"]);
        $this->blank = $plate_conts_blank->where($where)->find();
        if ($this->blank == NULL) {
            //return get_op_res(0, "更新失败[商品信息异常X2]");
        }
        #
        $this->lists = [$this->param];
        $this->updateMoreMarket();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 更新价格
     */
    private function updateListMarket() {
        $plate_conts_logs = M("plate_conts_logs");
        #
        foreach ($this->lists as $k => $v) {
            $where["id"] = $v["id"];
            unset($v["id"]);
            $v["uptimes"] = time();
            #
            $save = $v;
            $save["market"] = round($this->getMarket($v), 2);
            if (!isset($save['key_0']) && $this->param["type"] < 1) {
                $save["key_0"] = $this->param["keya"];
                $save["key_1"] = $this->param["keyb"];
                $save["key_2"] = $this->param["keyc"];
                $save["key_3"] = $this->param["keyd"];
                $save["key_4"] = $this->param["keye"];
            }
            if (!$plate_conts_logs->where($where)->save($save)) {
                // return get_op_put(0, "没有修改[SR]");
            }
        }
        //var_dump(55);
        return ['status'=>1,'msg'=>'成功','data'=>[]];
        // return get_op_put(1, "修改成功");
    }

    /**
     * 更新价格2
     */
    private function updateMoreMarket() {
        $plate_conts_logsr = M("plate_conts_logsr");
        #
        foreach ($this->lists as $k => $v) {
            $where["id"] = $v["id"];
            unset($v["id"]);
            $v["uptimes"] = time();
            #
            $save = $v;
            $save["market"] = round($this->getMarket($v), 2);
            $plate_conts_logsr->where($where)->save($save);
            // if (!$plate_conts_logsr->where($where)->save($save)) {
            //     return get_op_put(0, "没有修改[SR]");
            // }
        }
        return get_op_put(1, "修改成功!!!");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 分类费率检查
     */
    private function plate_cats_ratio() {
        $baseRatio = 100;
        $cats = $this->cats;
        if ($cats == NULL) {
            return 0;
        }
        #
        $firstRatio = $baseRatio * (1 + $cats["up"] / 100) * (1 - $cats["down"] / 100);
        return $firstRatio / 100;
    }

    /**
     * 费率检查
     */
    private function plate_conts_ratio() {
        $baseRatio = 100;
        if ($this->blank == NULL) {
            return $baseRatio / 100;
        }
        #
        $firstRatio = $baseRatio * (1 + $this->blank["up_a"] / 100) * (1 - $this->blank["down_a"] / 100);
        $secondRatio = $firstRatio * (1 + $this->blank["up_b"] / 100) * (1 - $this->blank["down_b"] / 100);
        $thirdRatio = $secondRatio * (1 + $this->blank["up_c"] / 100) * (1 - $this->blank["down_c"] / 100);
        $forthRatio = $thirdRatio * (1 + $this->blank["up_d"] / 100) * (1 - $this->blank["down_d"] / 100);
        $fiveRatio = $forthRatio * (1 + $this->blank["up_e"] / 100) * (1 - $this->blank["down_e"] / 100);
        $sixRatio = $fiveRatio * (1 + $this->blank["up_f"] / 100) * (1 - $this->blank["down_f"] / 100);
        #
        return $sixRatio / 100;
    }

    /**
     * 获取价格
     */
    private function getMarket($v) {
        $runPrice = 0;
        $runPrice =bcmul((string)$v['price'],(string)$v["dratio"],2);
        // $catRatio = round($this->plate_cats_ratio(), 2);
        // $ratio = round($this->plate_conts_ratio(), 2);
        // #
        // $dPrice = $v["price"] * $v["dratio"];
        // $upPrice = $dPrice * $catRatio - $dPrice;
        // $runPrice = $v["price"] + $upPrice;
        #
        return $runPrice;
    }

}
