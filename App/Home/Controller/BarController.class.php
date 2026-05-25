<?php

namespace Home\Controller;

#use Think\Controller;

class BarController extends CommController {

 
    public function index() {
        $know = M("bar");
        #
        $list = boPage($know, $where);
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




}
