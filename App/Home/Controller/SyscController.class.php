<?php

namespace Home\Controller;

#use Think\Controller;

class SyscController extends CommController {

    public function index() {
        $sys_version = M("sys_version");
        #
        $list = boPage($sys_version, $where, "id desc");
        $this->assign("list", $list);
        $this->display();
    }

    public function banks() {
        $sys_banks = M("sys_banks");
        #
        $list = boPage($sys_banks, $where, "id desc");
        $this->assign("list", $list);
        $this->display();
    }

}
