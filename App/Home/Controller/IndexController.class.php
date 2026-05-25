<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {
    
    public function _initialize() {
        layout(false);
    }

    public function index() {
        $this->display();
    }

}
