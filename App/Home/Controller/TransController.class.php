<?php

namespace Home\Controller;

#use Think\Controller;

class TransController extends CommController {

    /**
     * 物流城市
     */
    public function citys() {
        $trans_city = M("trans_city");
        #
        $list = boPage($trans_city, $where);
        #
        $this->assign("list", $list);
        $this->display();
    }

    public function index($id) {
        $trans = M("trans");
        $sysregion = M("sysregion");
        #
        $where["pid"] = $id;
        $list = boPage($trans, $where);
        #
        $this->assign("list", $list);
        $this->assign("id", $id);
        $this->assign("region", $sysregion->where(["parent" => 1])->select());
        $this->display();
    }

    /**
     * 物流-更新图片
     */
    public function index_upsearch() {
        $trans = M("trans");
        $post = I("post.");
        #
        $file = uploadFile("trans");
        if (!$file) {
            return get_op_put(0, "文件上传失败");
        }
        $where["id"] = $post["ids"];
        $save["search"] = $file["search"]["savename"];
        $save["uptimes"] = time();
        #
        if (!$trans->where($where)->save($save)) {
            return get_op_put(0, "文件更新失败");
        }
        return get_op_put(1, "处理成功");
    }

    /**
     * 物流-更新图片
     */
    public function index_upfile() {
        $trans = M("trans");
        $post = I("post.");
        #
        $file = uploadFile("trans");
        if (!$file) {
            return get_op_put(0, "文件上传失败");
        }
        $where["id"] = $post["ids"];
        $save["source"] = $file["source"]["savename"];
        $save["uptimes"] = time();
        #
        if (!$trans->where($where)->save($save)) {
            return get_op_put(0, "文件更新失败");
        }
        return get_op_put(1, "处理成功");
    }

    /**
     * 站点管理
     * @param type $id
     */
    public function index_edits($id) {
        $trans = M("trans");
        $sysregion = M("sysregion");
        #
        $where["id"] = $id;
        $info = $trans->where($where)->find();
        #
        $this->assign("region", $sysregion->where(["parent" => 1])->select());
        $this->assign("id", $id);
        $this->assign("info", $info);
        $this->display();
    }

    /**
     * 站点管理
     * @param type $id
     */
    public function index_logs($id) {
        $trans_log = M("trans_log");
        $get = I("get.");
        #
        $where["tid"] = $id;
        $list = boPage($trans_log, $where);
        #
        $this->assign("id", $id);
        $this->assign("pid", $get["pid"]);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 站点管理-修改
     * @param type $id
     */
    public function index_logs_edt($id) {
        $trans_log = M("trans_log");
        #
        $where["id"] = $id;
        $info = $trans_log->where($where)->find();
        #
        $this->assign("info", $info);
        $this->display();
    }

}
