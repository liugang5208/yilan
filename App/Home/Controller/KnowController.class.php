<?php

namespace Home\Controller;

#use Think\Controller;

class KnowController extends CommController {

    /**
     * 分类
     */
    public function cats() {
        $know_cat = M("know_cat");
        #
        $list = boPage($know_cat, $where);
        $this->assign("list", $list);
        $this->display();
    }

    public function index() {
        $know = M("know");
        #
        $list = boPage($know, $where);
        $this->assign("list", $list);
        $this->display();
    }

    public function index_add() {
        $know_cat = M("know_cat");
        #
        $this->assign("list", $know_cat->select());
        $this->display();
    }

    ////////////////////////////////////////////////////////////////////////////

    public function helps() {
        $sys_help = M("sys_help");
        #
        $where["pid"] = 0;
        $list = boPage($sys_help, $where);
        $this->assign("list", $list);
        $this->display();
    }

    public function helps_list($id) {
        $sys_help = M("sys_help");
        #
        $where["pid"] = $id;
        $list = boPage($sys_help, $where);
        #
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->display();
    }

    ////////////////////////////////////////////////////////////////////////////

    public function files() {
        $know_conc = M("know_conc");
        #
        $list = boPage($know_conc, $where);
        $this->assign("list", $list);
        $this->display();
    }

    ////////////////////////////////////////////////////////////////////////////

    public function advs() {
        $sys_banner = M("sys_banner");
        #
        $list = boPage($sys_banner, $where);
        $this->assign("list", $list);
        $this->display();
    }

    ////////////////////////////////////////////////////////////////////////////

    public function sysc() {
        $sys_article = M("sys_article");
        #
        $list = boPage($sys_article, $where);
        $this->assign("list", $list);
        $this->display();
    }

    public function sysc_edit($id) {
        $sys_article = M("sys_article");
        #
        $where["id"] = $id;
        $info = $sys_article->where($where)->find();
        $this->assign("info", $info);
        $this->display();
    }

}
