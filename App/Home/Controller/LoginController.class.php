<?php

namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller {

    public function _initialize() {
        layout(false);
    }

    /**
     * 登陆账户
     * @return type
     */
    public function auths() {
        $sysmanag = M("sysmanag");
        $post = I("post.");
        #
        if ($post["name"] == null || $post["passwd"] == null) {
            return get_op_put(0, "请输入用户名和密码");
        }
        $post["passwd"] = md5($post["passwd"]);
        $info = $sysmanag->where($post)->find();
        if ($info == null) {
            return get_op_put(0, "用户名或密码错误");
        }
        #
        session("yilans_ssid", $info["id"]);
        return get_op_put(1, $info, U("Users/index"));
        // return get_op_put(1, $info, U("Bords/index"));
    }

    /**
     * 登出
     */
    public function out() {
        session("yilans_ssid", null);
        if (session("yilans_ssid") != null) {
            session_destroy();
        }
        $this->redirect("Index/index");
    }

}
