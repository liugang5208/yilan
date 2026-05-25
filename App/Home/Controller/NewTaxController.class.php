<?php

namespace Home\Controller;

#use Think\Controller;

class NewTaxController extends CommController {

    public function index() {
        $model = M("new_tax");
        #
        $list = boPage($model, $where, "id desc");
        $this->assign("list", $list);
        $this->display();
    }
    
    public function edits() {
        $db = D('new_tax');
        $id =  I("post.id");
        $data = I("post.");
        #
        if (!$db->create(I("post."), 2)) {
            return get_op_put(0, $db->getError());
        }
        if (!$db->where("id='" . I("post.ids") . "'")->save()) {
            return get_op_put(0, "没有修改");
        }
        $blank['ticket_nor'] = $data['normal_tax'];
        $blank['ticket_person'] = $data['special_tax'];
        M('plate_conts_blank')->where(['new_tax_id'=>$id])->save($blank);
        return get_op_put(1, "修改成功");
    }

}
