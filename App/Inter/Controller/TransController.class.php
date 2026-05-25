<?php

namespace Inter\Controller;

#use Think\Controller;

class TransController extends CommController {

    /**
     * 物流
     */
    public function index() {
        $trans_city = M("trans_city");
        $trans = M("trans");
        $trans_log = M("trans_log");
        $glent = D("Inter/Glent", "Logic");
        $post = $this->param;
        #
        $where["status"] = 1;
        $res["city"] = $trans_city->where($where)->field("id,name")->select();
        #
        if ($post["keys"] != null && $post["keys"] != "") {
            $where["name"] = array("like", "%" . $post["keys"] . "%");
        } else {
            #$post["trans"] != null && $post["trans"] != "" ? $where["trans_type"] = array("in", $post["trans"] . ",2") : null;
            $post["base"] != null && $post["base"] != "" ? $where["pid"] = $post["base"] : null;
            $post["line"] != null && $post["line"] != "" ? $where["line_keys"] = array("like", "%" . $post["line"] . "%") : null;
        }
        #
        $res["list"] = $trans->where($where)->limit(10)->select();
        foreach ($res["list"] as $k => $v) {
            $first = $trans_log->where(["tid" => $v["id"]])->find();
            #
            $f = $post["longitude"] . "," . $post["latitude"];
            $t = $first["lng"] . "," . $first["lat"];
            //$kilter = $glent->runs(["from" => $f, "to" => $t]);
            $kilter = getDistancr($post["latitude"], $post["longitude"], $first["lat"], $first["lng"]);
            $res["list"][$k]["kilter"] = $kilter;
            $res["list"][$k]["lnglat"] = ["from" => $f, "to" => $t];
            $res["list"][$k]["search_url"] = C("WEBIMG") . "trans/" . $v["search"];
        }
        $kiArr = i_array_column($res["list"], "kilter");
        array_multisort($kiArr, SORT_ASC, $res["list"]);
        #
        return get_op_put(1, NULL, $res);
    }

    /**
     * 获取到达城市
     */
    public function gettranso() {
        $trans = M("trans");
        $post = $this->param;
        #
        $where["pid"] = $post["base"];
        $list = $trans->where($where)->select();
        $res = array();
        #
        foreach ($list as $k => $v) {
            $tmp = explode(",", $v["line_keys"]);
            $res = array_merge($res, $tmp);
        }
        return get_op_put(1, null, $res);
    }

    /**
     * 详情
     */
    public function infos() {
        $trans = M("trans");
        $trans_log = M("trans_log");
        $glent = D("Inter/Glent", "Logic");
        $post = $this->param;
        #
        $res["info"] = $trans->find($post["tid"]);
        $res["info"]["source_url"] = C("WEBIMG") . "trans/" . $res["info"]["source"];
        #
        $where["tid"] = $post["tid"];
        #$post["trnas"] != null ? $where["from_type"] = array("in", $post["trnas"] . ",2") : null;
        #
        $res["list"] = $trans_log->where($where)->select();
        foreach ($res["list"] as $k => $v) {
            $f = $post["longitude"] . "," . $post["latitude"];
            $t = $v["lng"] . "," . $v["lat"];
            //
            //$kilter = $glent->runs(["from" => $f, "to" => $t]);
            $kilter = getDistancr($post["latitude"], $post["longitude"], $v["lat"], $v["lng"]);
            $res["list"][$k]["kilter"] = $kilter;
            //$res["list"][$k]["kilter"] = $k;
        }
        $kiArr = i_array_column($res["list"], "kilter");
        array_multisort($kiArr, SORT_ASC, $res["list"]);
        #
        return get_op_put(1, $where, $res);
    }

}
