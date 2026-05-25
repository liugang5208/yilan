<?php

namespace Inter\Controller;

#use Think\Controller;

class ShopsController extends CommController {

    /**
     * 店铺
     */
    public function index() {
        $plate_types = M("plate_types");
        $plate_banner = M("plate_banner");
        $plate = M("plate");
        $shops = M("shops");
        $p = $this->param;
        #
        $res["cats"] = $plate_types->where(["types" => 3, "types_id" => $p["id"], "status" => 1])->order("sorts asc,id desc")->select();
        #
        $where["pid"] = $p["catid"] != NULL ? $p["catid"] : $res["cats"][0]["id"];
        $res["banner"] = $plate_banner->where($where)->select();
        foreach ($res["banner"] as $k => $v) {
            $res["banner"][$k]["source_url"] = C("WEBIMG") . "ads/" . $v["source"];
        }
        #
        $list = $plate->where($where)->order("sorts asc,id desc")->select();
        foreach ($list as $k => $v) {
            $list[$k]["source_url"] = C("WEBIMG") . "ads/" . $v["source"];
            #
            $list[$k]["child"] = $this->listImgs(["pid" => $v["id"]]);
        }
        $res["group"] = $list;
        $res["infos"] = $shops->find($p["id"]);
        $res["infos"]["product"] = replaceHtml($res["infos"]["product"]);
        $res["infos"]["licence"] = replaceHtml($res["infos"]["licence"]);
        $res["infos"]["tickets"] = replaceHtml($res["infos"]["tickets"]);
        #
        return get_op_put(1, "获取成功", $res);
    }

    /**
     * 图片资源加载
     * @param type $where
     * @return string
     */
    private function listImgs($where) {
        $plate_conts = M("plate_conts");
        #
        $temp = $plate_conts->where($where)->select();
        foreach ($temp as $m => $s) {
            $class = "list_line_item";
            if ($s["show_type"] == "2") {
                $class = "list_line_item2";
            }
            if ($s["show_type"] == "3") {
                $class = "list_line_item3";
            }
            if ($s["show_type"] == "4") {
                $class = "list_line_item4";
            }
            $temp[$m]["class"] = $class;
            #
            $temp[$m]["source_url"] = C("WEBIMG") . "ads/" . $s["source"];
        }
        return $temp;
    }

}
