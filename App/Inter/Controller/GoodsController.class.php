<?php

namespace Inter\Controller;

#use Think\Controller;

class GoodsController extends CommController {

    /**
     * 获取用户信息
     */
    private function getUser($id, $mode = "0",$plate_cats_id = 0) {
        $users = M("users");
        $users_level = M("users_level");
        #
        if($id > 0){
            $where["id"] = $id;
            $info = $users->where($where)->find();
        }else{
            $info['ac_level'] = 1;
        }
        
        #
        $level = $users_level->where(["id" => $info["ac_level"]])->find();
        if ($level != NULL && $mode != "0") {
            $mode == "1" ? $level["up"] = $level["up_a"] : NULL;
            $mode == "2" ? $level["up"] = $level["up_b"] : NULL;
        }
        if($plate_cats_id > 0){
          $users_cats =  M("users_cats")->where(['ac_level'=>$level['id'],'plate_cats_id'=>$plate_cats_id])->find();
          if($users_cats){
              $level['up'] = $level['up'] + $users_cats['cats_up'];
          }
        }
        $level["up"] = round(1 + $level["up"] / 100, 2);
        $level["limit"] = $level["type_a"] + $level["type_b"] + $level["type_c"];
        #
        return $level;
    }

    /**
     * 商品列表
     */
    public function glist() {
        $plate_conts = M('plate_conts');
        $plate_conts_blank = M("plate_conts_blank");
        $plate_conts_logs = M("plate_conts_logs");
        $p = $this->param;
        #商品详情
        $where["pid"] = $p["gid"];
        $res["info"] = $plate_conts->find($p["gid"]);
        $res["cats"] = getCatsName($res["info"]["catid"]);
        $res["info"]["source_url"] = $res["info"]["source"];
        $res["info"]["g_attr"] = replaceHtml($res["info"]["g_attr"]);
        $res["info"]["g_desc"] = replaceHtml($res["info"]["g_desc"]);
        
        if(isset($p['uid']) && $p['uid']){
            $level = $this->getUser($p["uid"], $res["cats"]["float_cat"],$res['cats']['id']);
        }else{
            $level = $this->getUser(0, $res["cats"]["float_cat"]);
        }
        
        #商品默认分类板块
        $res["blank"] = $plate_conts_blank->where($where)->field("id,catname,cat_index")->order("cat_index asc")->limit($level["limit"])->select();
        $where["cat_index"] = $p["cat_index"] != NULL ? $p["cat_index"] : $res["blank"][0]["cat_index"];
        $res["blank_info"] = $plate_conts_blank->where($where)->find();
        #轮播图
        $source = json_decode($res["blank_info"]["source"], true);
        foreach ($source as $k => $v) {
            $source[$k] = C("WEBIMG") . "banner/" . $v;
        }
        $res["blank_info"]["source_url"] = $source;
        $res["blank_info"]["goods_url"] = C("WEBIMG") . "goods/" . $res["blank_info"]["gimage"];
        #
        $where["ptype"] = 2;
        $list = $plate_conts_logs->where($where)->order("number asc,id asc")->select();
        // $list = $plate_conts_logs->where($where)->order("sorts desc")->select();
        $g_unit = $res["info"]['g_unit'];
        foreach ($list as $k => $v) {
            $ratio = setRatio($res["blank_info"], $res["cats"]);
            $list[$k]["user"] = $level["up"];
            $list[$k]["ratio"] = $ratio;
            $list[$k]["key_3"] = '计量单位';
            $list[$k]["value_3"] = $g_unit;
            #$list[$k]["market"] = round($v["price"] * $ratio, 2);
        }
        #
        $lisr = $list[0];
        #
        $res["ulevel"] = $level;
        $res["cat_index"] = $where["cat_index"];
        $res["list"] = $list;
        $res["keys"] = ["key_1" => $lisr["key_0"], "key_2" => $lisr["key_1"], "key_3" => $lisr["key_2"]];
        #
        return get_op_put(1, null, $res);
    }

    /**
     * 多属性多规格
     */
    public function gmores() {
        $plate_conts = M('plate_conts');
        $plate_conts_blank = M("plate_conts_blank");
        $plate_conts_logs = M("plate_conts_logs");
        $plate_conts_logsr = M("plate_conts_logsr");
        $p = $this->param;
        #商品详情
        $where["pid"] = $p["gid"];
        $res["info"] = $plate_conts->find($p["gid"]);
        $res["cats"] = getCatsName($res["info"]["catid"]);
        $res["info"]["source_url"] = $res["info"]["source"];
        $res["info"]["g_attr"] = replaceHtml($res["info"]["g_attr"]);
        $res["info"]["g_desc"] = replaceHtml($res["info"]["g_desc"]);
        $level = $this->getUser($p["uid"], $res["cats"]["float_cat"],$res['cats']['id']);
        #商品默认分类板块
        $res["blank"] = $plate_conts_blank->where($where)->field("id,catname,cat_index")->order("cat_index asc")->limit($level["limit"])->select();
        $where["cat_index"] = $p["cat_index"] != NULL ? $p["cat_index"] : $res["blank"][0]["cat_index"];
        $res["blank_info"] = $plate_conts_blank->where($where)->find();
        #轮播图
        $source = json_decode($res["blank_info"]["source"], true);
        foreach ($source as $k => $v) {
            $source[$k] = C("WEBIMG") . "banner/" . $v;
        }
        $res["blank_info"]["source_url"] = $source;
        #
        $where["ptype"] = 1;
        $list = $plate_conts_logs->where($where)->order("sorts desc")->select();
        foreach ($list as $k => $v) {
            $list[$k]["source_url"] = C("WEBIMG") . "goods/" . $v["source"];
            #
            $temp = $plate_conts_logsr->where(["pid" => $v["id"]])->order("sorts desc")->select();
            $price = [];
            foreach ($temp as $m => $s) {
                $ratio = setRatio($res["blank_info"], $res["cats"]);
                $temp[$m]["user"] = $level["up"];
                $temp[$m]["ratio"] = $ratio;
                #
                $temp[$m]["nums"] = 0;
                #$temp[$m]["market"] = round($s["price"] * $ratio, 2);
                #
                $price[] = round($s["market"], 2);
            }
            sort($price);
            $list[$k]["s_price_arr"] = [$price[0], $price[count($price) - 1]];
            $list[$k]["s_price"] = $price[0] . "~" . $price[count($price) - 1];
            $list[$k]["child"] = $temp;
        }
        #
        $res["ulevel"] = $level;
        $res["cat_index"] = $where["cat_index"];
        $res["list"] = $list;
        #
        return get_op_put(1, null, $res);
    }

}
