<?php

namespace Home\Controller;

#use Think\Controller;

class ShopsController extends CommController {

    /**
     * 店铺
     */
    public function index() {
        $shops = M("shops");
        #
        $list = boPage($shops, $where);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 店铺-分类
     */
    public function index_cats($id) {
        $plate_types = M("plate_types");
        #
        $where["types"] = 3;
        $where["types_id"] = $id;
        $list = boPage($plate_types, $where, "sorts desc,id asc");
        #
        $this->assign("list", $list);
        $this->assign("id", $id);
        $this->display();
    }

    /**
     * 店铺-详情
     */
    public function index_info($id, $tar) {
        $shops = M("shops");
        #
        $where["id"] = $id;
        $info = $shops->where($where)->find();
        #
        $this->assign("id", $id);
        $this->assign("tar", $tar);
        $this->assign("context", $info[$tar]);
        $this->display();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 采购
     */
    public function buyer() {
        $bulks_buyer = M("bulks_buyer");
        #
        $list = boPage($bulks_buyer, $where);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 回收
     */
    public function recyle() {
        $bulks_recyle = M("bulks_recyle");
        #
        $list = boPage($bulks_recyle, $where);
        $this->assign("list", $list);
        $this->display();
    }

}
