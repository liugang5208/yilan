<?php

namespace Home\Controller;

use Think\Controller;

class ConfigController extends CommController {

    public function _initialize() {
    
    }
    
    public function customer_config(){
        $this->display();
    }

    public function customer_config_ajax() {
        $sysregion = M("config");
        $post = I("post.");
        #
        $where["group_id"] = 1;
        $where["status"] = 1;
        $list = $sysregion->where($where)->select();
        // var_dump($list);
        #
        return get_op_put(1, NULL, $list);
    }
    
    public function saveCustomerConfig() {
    $post = I("post.");

    foreach ($post as $key => $val) {
        M("config")
            ->where(["name" => $key])
            ->save(["value" => $val]);
    }

    return get_op_put(1, "保存成功");
}



}
