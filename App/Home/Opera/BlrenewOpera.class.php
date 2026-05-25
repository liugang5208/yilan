<?php

namespace Home\Opera;

/**
 * Description of BlrenewOpera
 * 更新板块
 * @author Administrator
 */
class BlrenewOpera {

    public $param;
    public $blank;

    /**
     * 入口
     */
    public function runs($param) {
        $this->param = $param;
        return $this->updateBlank();
    }

    /**
     * 更新板块费率
     */
    private function updateBlank() {
        $plate_conts_blank = M("plate_conts_blank");
        $post = $this->param;
        #
        unset($post["source"]);
        $count = $this->plate_conts_check();
        $post["uptimes"] = time();
        $this->blank = $post;
        
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
        #
        if ($count["count"] > 0) {
            if (!$plate_conts_blank->where($count["where"])->save($post)) {
                return get_op_res(0, "更新失败");
            }
            return $this->upBlankLog();
        }
        $post["status"] = 1;
        $post["times"] = time();
        if (!$plate_conts_blank->add($post)) {
            return get_op_res(0, "更新失败");
        }
        return $this->upBlankLog();
    }

    /**
     * 更新板块商品
     */
    private function upBlankLog() {
        $plate_conts_logs = M("plate_conts_logs");
        #
        $where["pid"] = $this->blank["pid"];
        $where["cat_index"] = $this->blank["cat_index"];
        $list = $plate_conts_logs->where($where)->select();
        if (count($list) < 1) {
            return get_op_res(1, "更新成功");
        }
        #
        set_time_limit(0);
        foreach ($list as $k => $v) {
            $r = $this->upBlankLogCk($v);
            if (!$r) {
                return get_op_res(0, "更新失败", $r);
            }
        }
        return get_op_res(1, "更新成功");
    }

    /**
     * 更新板块商品-检查更新商品
     * @param type $v
     */
    private function upBlankLogCk($v) {
        if ($v["ptype"] > 1) {
            return $this->upBlankMainLog($v);
        }
        return $this->upBlankChildLog($v);
    }

    /**
     * 更新板块商品-更新主商品
     * @param type $v
     */
    private function upBlankMainLog($v) {
        $plate_conts_logs = M("plate_conts_logs");
        #
        $market = round($this->getMarket($v), 2);
        #
        $where["id"] = $v["id"];
        $save = ["market" => $market, "uptimes" => time()];
        if (!$plate_conts_logs->where($where)->save($save)) {
            return -1;
        }
        return 1;
    }

    /**
     * 更新板块商品-更新子商品
     * @param type $v
     */
    private function upBlankChildLog($v) {
        $plate_conts_logsr = M("plate_conts_logsr");
        #
        $where["pid"] = $v["id"];
        $list = $plate_conts_logsr->where($where)->select();
        foreach ($list as $k => $s) {
            $market = round($this->getMarket($s), 2);
            $save = ["market" => $market, "uptimes" => time()];
            if (!$plate_conts_logsr->where(["id" => $s["id"]])->save($save)) {
                return -2;
            }
        }
        return 1;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 分类费率检查
     */
    private function plate_cats_ratio() {
        $plate_conts = M("plate_conts");
        $plate_cats = M("plate_cats");
        $baseRatio = 100;
        #
        $where["id"] = $this->blank["pid"];
        $info = $plate_conts->where($where)->find();
        $cats = $plate_cats->find($info["catid"]);
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
     * 板块详情广告-检索
     * @param type $post
     */
    private function plate_conts_check() {
        $plate_conts_blank = M("plate_conts_blank");
        #
        $where["pid"] = $this->param["pid"];
        $where["cat_index"] = $this->param["cat_index"];
        $count = $plate_conts_blank->where($where)->count();
        #
        return ["where" => $where, "count" => $count];
    }

    /**
     * 获取价格
     */
    private function getMarket($v) {
        $runPrice = 0;
        $runPrice =bcmul((string)$v['price'],(string)$v["dratio"],2);
        return $runPrice;
        // $catRatio = round($this->plate_cats_ratio(), 2);
        // $ratio = round($this->plate_conts_ratio(), 2);
        // #
        // $dPrice = $v["price"] * $v["dratio"];
        // $upPrice = $dPrice * $catRatio - $dPrice;
        // $runPrice = $v["price"] + $upPrice;
        // #
        // return $runPrice * $ratio;
    }

    ////////////////////////////////////////////////////////////////////////////
}
