<?php

namespace Inter\Controller;

use Think\Controller;

class CommController extends Controller {

    public $param;

    public function _initialize() {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET,HEAD,POST,TRACE");
        header("Access-Control-Allow-Headers:accept, content-type");
        #
        if (REQUEST_METHOD == "OPTIONS") {
            return get_op_put(0, "TEST_LINK");
        }
        $param = I("post.");
        if (count($param) <= 0) {
            $tmp = file_get_contents('php://input', true);
            $param = json_decode($tmp, true);
        }
        #
        $users = M("users");
        if (isset($param["uid"])) {
            #
            $power = ["x", "Carts", "Order", "Report", "Users"];
            $uinfo = $users->where(["id" => $param["uid"]])->find();
            if ($uinfo["status"] != 1 && array_search(CONTROLLER_NAME, $power)) {
                return get_op_put(1, "您的账户暂不支持查看", 4044);
            }
        }
        #
        $this->param = $param;
    }

    /**
     * 消息
     */
    public function mss() {
        $sys_msgs = M("sys_msgs");
        #
        $where["uid"] = $this->param["uid"];
        $where["i_read"] = 0;
        $where["status"] = 1;
        $list = $sys_msgs->where($where)->order("id desc")->find();
        $count = $sys_msgs->where($where)->count();
        if ($list != NULL) {
            $sys_msgs->where($where)->save(["i_read" => 1, "uptimes" => time()]);
        }
        #
        return get_op_put(1, $count, $list);
    }

}
