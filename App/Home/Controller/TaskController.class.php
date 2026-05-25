<?php

namespace Home\Controller;

#use Think\Controller;

class TaskController extends CommController {

    public function index() {
        $model = M("task");
        #
        $list = boPage($model, $where, "id desc");
        $status = [1=>'待开始',2=>'进行中',3=>'已完成',4=>'作废'];
        foreach ($list['list'] as $k=>$v){
            $list['list'][$k]['status_title'] = $status[$v['status']];
        }
        $this->assign("list", $list);
        $this->display();
    }
    
 

}
