<?php

namespace Home\Opera;
use Think\Log;
/**
 * Description of BlwaresOpera
 * 更新板块商品
 * @author Administrator
 */
class NewCateOpera {

    private $param;

    private $lists;

    /**
     * 入口
     */
    public function runs($param) {
        $this->param = $param;
       return $this->setListGoods();
    }



    /**
     * 列表商品
     */
    public function setListGoods() {
        $new_cate_id = $this->param['new_cate_id'];
         Log::record(111111111111222, 'DEBUG');
          Log::record($new_cate_id, 'DEBUG');
        $plate_conts_price = M("plate_conts_price");
        // var_dump(222);
        // var_dump($new_cate_id);
        $list = $plate_conts_price->where(['new_cate_three_id'=>$new_cate_id])->select();
        $blwares = D("Home/Blwares", "Opera");
        // if($new_cate_id == 126) {
        //     var_dump($list);
        // }
        foreach($list as $k2=>$v2){
            //更新商品价格
            $run['pid'] = $v2['plate_conts_id'];
            $run['cat_index'] = $v2['cat_index'];
            $run['type'] = 0;
            $blwares->runs($run);
        }
        
       return true;
          
    }


  

}
