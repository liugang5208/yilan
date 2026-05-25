<?php

namespace Inter\Controller;

#use Think\Controller;

class KnowController extends CommController {

    /**
     * 知识
     */
    public function index() {
        $know_cat = M("know_cat");
        $know = M("know");
        $post = $this->param;
        #
        $where["status"] = 1;
        $res["cat"] = $know_cat->where($where)->select();
        #
        $cond["catid"] = $post["cat"] == null ? $res["cat"][0]["id"] : $post["cat"];
        $cond["status"] = 1;
        $res["list"] = $know->where($cond)->select();
        foreach ($res["list"] as $k => $v) {
            $res["list"][$k]["time_zone"] = date("Y/m/d", $v["times"]);
        }
        #
        return get_op_put(1, null, $res);
    }

    /**
     * 文章详情
     */
    public function infos() {
        $know = M("know");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        $info = $know->where($where)->find();
        $info["context"] = replaceHtml($info["context"]);
        $info["time_zone"] = date("Y/m/d", $info["times"]);
        #
        return get_op_put(1, null, $info);
    }

    /**
     * 文件
     */
    public function files() {
        $know_conc = M("know_conc");
        #
        $where["status"] = 1;
        $list = $know_conc->where($where)->select();
        foreach ($list as $k => $v) {
            $list[$k]["source_url"] = C("WEBIMG") . "contact/" . $v["source"];
        }
        #
        return get_op_put(1, null, $list);
    }

    /**
     * 文件详情
     */
    public function file_infos() {
        $know_conc = M("know_conc");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        $info = $know_conc->where($where)->find();
        #
        return get_op_put(1, null, $info);
    }

}
