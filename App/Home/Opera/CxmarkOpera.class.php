<?php

namespace Home\Opera;

/**
 * Description of CxmarkOpera
 * 计算商品市场价
 * @author Administrator
 */
class CxmarkOpera {

    private $param;

    /**
     * 入口
     */
    public function runs($param) {
        $this->param = $param;
        return $this->setGoods();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 列表商品
     */
    private function setGoods() {
        $plate_conts = M("plate_conts");
        $plate_cats = M("plate_cats");
        $plate_conts_blank = M("plate_conts_blank");
        #
        if(isset($this->param["type"])){
            $pid = $this->param["type"] == 1 ? $this->param["fpid"] : $this->param["pid"];
        }else{
            $pid = $this->param["pid"];
        }
        
        $conts = $plate_conts->find($pid);
        if ($conts == null) {
            return get_op_res(0, "更新失败[商品信息异常]");
        }
        $where = ["pid" => $pid, "cat_index" => $this->param["cat_index"]];
        #
        $this->cats = $plate_cats->find($conts["catid"]);
        $this->blank = $plate_conts_blank->where($where)->find();
        #
        if ($this->blank == NULL) {
            //return get_op_res(0, "更新失败[商品信息异常X2]");
        }
        #
        return $this->getMarket();
    }

    /**
     * 更新价格
     */
    private function getMarket() {
        // $catRatio = round($this->plate_cats_ratio(), 2);
        // $ratio = round($this->plate_blank_ratio(), 2);
        // #
        // $dPrice = $this->param["price"] * $this->param["dratio"];
        // $upPrice = $dPrice * $catRatio - $dPrice;
        // $runPrice = $this->param["price"] + $upPrice;
        #
        $runPrice = 0;
        $pid = $this->param['pid'];
        $cat_index = $this->param['cat_index'];
        $number = $this->param['number'];
        $dratio = $this->param['dratio'];
        $plate_conts = M("plate_conts_price");
        $price_list = $plate_conts->where(['plate_conts_id'=>$pid,'cat_index'=>$cat_index])->select();
        
        $price = 0;
        $form_model = M('new_cate_form');
        foreach ($price_list as $k=>$v){
            $where['new_cate_id'] = $v['new_cate_three_id'];
            $where['number'] = $number;
            $form = $form_model->where($where)->find();
            if($form){
                $temp = bcmul((string)$form['end_price'],(string)$v['ratio'],2);
                $price = bcadd((string)$price,$temp,2);
            }
        }
        $runPrice =bcmul((string)$price,(string)$dratio,2);
        // $dratio_money = bcmul((string)$price,(string)$dratio,2);
        // $runPrice =bcadd((string)$price,(string)$dratio,2);
        
        return get_op_res(1, null, ['market'=>$runPrice,'price'=>$price]);
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
     * 浮动费率检查
     */
    private function plate_blank_ratio() {
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

}
