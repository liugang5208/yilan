<?php

namespace Inter\Controller;

#use Think\Controller;

class CartsController extends CommController {

    public $user;

    /**
     * 获取用户信息
     */
    public function getUser($id, $mode = "0",$plate_cats_id = 0) {
        $users = M("users");
        $users_level = M("users_level");
        #
        $where["id"] = $id;
        $info = $users->where($where)->find();
        unset($info["passwd"]);
        $this->user = $info;
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
        $level["up_level"] = $level["up"];
        $level["up"] = 1 + $level["up"] / 100;
        
        #
        return $level;
    }

    /**
     * 购物车
     */
    public function index() {
        $carts = M("carts");
        $post = $this->param;
        #
        $where = ["uid" => $post["uid"], "status" => array("in", "0,1")];
        $post["type"] > 0 ? $where["status"] = 1 : NULL;
        
        //p>是否含税：<span>{{x?.ticket=='0'?'不含发票':''}}{{x?.ticket=='1'?'普通发票':''}}{{x?.ticket=='2'?'专用发票':''}}</span>
        if(isset($post['ticket']) && $post['ticket'] >= 0){
            $where['ticket'] = $post['ticket'];
        }
        
        $list = $carts->where($where)->order("id asc")->select();
        #
        $nums = 0;
        $price = 0;
        #
        foreach ($list as $k => $v) {
            if ($v["types"] == "0") {
                $temp = $this->index_list($v);
                $list[$k]["list"] = $temp;
                $list[$k]["info"] = getplateConts($v["cont_id"]);
                $list[$k]["cats"] = getCatsName($list[$k]["info"]["catid"]);
                $level = $this->getUser($post["uid"], $list[$k]["cats"]["float_cat"]);
                #
                $list[$k]["nums"] = $v["nums"];
                $list[$k]["price"] = round($temp["market"] * $v["ticket_fee"] * $level["up"], 2) * $v["nums"];
                #
                // if($post['uid'] == 56){
                //     var_dump($temp['market']);var_dump($v['ticket_fee']);var_dump($level['up']);die;
                // }
                if ($v["status"] == "1") {
                    $nums = $nums + $list[$k]["nums"];
                    $price = $price + $list[$k]["price"];
                }
                continue;
            }
            ////////////////////////////////////////////////////////////////////
            $tmp = $this->index_more($v, $post);
            #
            $list[$k] = $tmp["list"];
            if ($v["status"] == "1") {
                $nums = $nums + $tmp['tmp_nums'];
                $price = $price + $tmp['tmp_price'];
            }
        }
        $where["status"] = 1;
        $ticket = $carts->where($where)->group("ticket,ticket_fee")->find();
        #
        $res = [
            "list" => $list,
            "bank_pri" => getBankList(0),
            "bank_pub" => getBankList(1),
            "adlist" => usrAddr($post["uid"]),
            "adef" => usrDefAddr($post["uid"]),
            "nums" => $nums,
            "price" => $price,
            "ulevel" => $level,
            "users" => $this->user,
            "ticket" => $ticket["ticket"],
            "ticket_fee" => $ticket["ticket_fee"]
        ];
        return get_op_put(1, NULL, $res);
    }

    /**
     * 获取列表商品
     */
    private function index_list($v) {
        $plate_conts_blank = M("plate_conts_blank");
        #
        $res = getplateContslogs($v["logs_id"]);
        #
        $cond = ["pid" => $res["pid"], "cat_index" => $res["cat_index"]];
        $blank = $plate_conts_blank->where($cond)->find();
        #
        $res["gimage"] = C("WEBIMG") . "goods/" . $blank["gimage"];
        $res["gnames"] = $blank["gnames"];
        #
        return $res;
    }

    /**
     * 获取多属性商品
     * @param type $v
     */
    private function index_more($v, $post) {
        $carts_logs = M("carts_logs");
        #
        $tmp = $carts_logs->where(["cart_id" => $v["id"]])->select();
        $tmp_nums = 0;
        $tmp_price = 0;
        $price = [];
        #
        foreach ($tmp as $m => $s) {
            $tmp_nums = $tmp_nums + $s["nums"];
            #
            $ginfo = getplateContslogsr($s["g_id"]);
            $level = $this->getUser($post["uid"], $ginfo["catid"]);
            $tmp[$m]["info"] = $ginfo;
            #
            $tmp_price = $tmp_price + round($ginfo["market"] * $v["ticket_fee"] * $level["up"], 2) * $s["nums"];
            $price[] = $tmp_price;
        }
        sort($price);
        #
        $v["s_price"] = $price[0] . "~" . $price[count($price) - 1];
        $v["info"] = getplateConts($v["cont_id"]);
        $v["datr"] = getplateContslogs($v["logs_id"]);
        $v["list"] = $tmp;
        $v["nums"] = $tmp_nums;
        $v["price"] = round($tmp_price, 2);
        $v["gimage"] = C("WEBIMG") . "goods/" . $v["datr"]["source"];
        $v["gnames"] = $v["datr"]["gnames"];

        #
        return ["list" => $v, "tmp_nums" => $tmp_nums, "tmp_price" => $tmp_price];
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 加入购物车
     */
    public function cartadd() {
        $carts = D("Inter/Carts", "Opera");
        $post = $this->param;
        #
        $res = $carts->runs($post);
        #
        return get_op_put($res["status"], $res["msg"], $res["data"]);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 选中/取消
     */
    public function cartcancel() {
        $carts = M("carts");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        $info = $carts->where($where)->find();
        #
        if ($post["status"] > 0) {
            $cond = ["uid" => $info["uid"], "ticket" => array("neq", $info["ticket"]), "status" => array("in", "0,1")];
            $carts->where($cond)->save(["status" => 0, "uptimes" => time()]);
        }
        #
        $save = ["status" => $post["status"], "uptimes" => time()];
        if (!$carts->where($where)->save($save)) {
            return get_op_put(0, "更新失败");
        }
        return get_op_put(1, "更新数据成功");
    }

    /**
     * 更新购物车
     */
    public function cartup() {
        $post = $this->param;
        $dbStr = $post["type"] < 1 ? "carts" : "carts_logs";
        $db = M($dbStr);
        #
        $where["id"] = $post["id"];
        $save = ["nums" => $post["nums"], "uptimes" => time()];
        if (!$db->where($where)->save($save)) {
            return get_op_put(0, "更新失败");
        }
        return get_op_put(1, "更新数据成功");
    }

    /**
     * 清空购物车
     * @return type
     */
    public function cartclear() {
        $carts = M("carts");
        $post = $this->param;
        #
        $where = ["uid" => $post["uid"], "status" => array("in", "0,1")];
        $count = $carts->where($where)->count();
        if ($count < 1) {
            return get_op_put(0, "购物车没有商品了");
        }
        if (!$carts->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        return get_op_put(1, "删除数据成功");
    }

    /**
     * 移除购物车
     * @return type
     */
    public function cartdel() {
        $carts = M("carts");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        if (!$carts->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        return get_op_put(1, "删除数据成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 创建订单
     * @return type
     */
    public function order() {
        $order = D("Inter/Order", "Opera");
        #
        $res = $order->runs($this->param);
        return get_op_put($res["status"], $res["msg"], $res["data"]);
    }

    /**
     * 支付订单
     */
    public function order_pay() {
        $orders = M("orders");
        $wcpay = D("Inter/WcPay", "Logic");
        $post = $this->param;
        #
        $where["id"] = $post["oid"];
        $where["status"] = 0;
        $info = $orders->where($where)->find();
        if ($info == null) {
            return get_op_put(0, "订单信息异常[0XRS]");
        }
        if ($info["paytype"] > 1) {
            return $this->alipay($info);
        }
        #
        $param = array("body" => "订单支付", "attach" => $info["sn"], "sn" => $info["sn"], "money" => $info["money"],);
        $res = $wcpay->entrance($param);
        if (!$res) {
            return get_op_put(0, "微信支付异常[0XLS]");
        }
        return get_op_put(1, "微信拉起成功", $res);
    }

    /**
     * 支付宝支付
     */
    private function alipay($info) {
        $aliapp = D("Inter/Aliapp", "Logic");
        #
        $info["notify_url"] = C("WEBURL") . "Inter/Wcins/alires.html";
        $res = $aliapp->runs($info);
        if (!$res) {
            return get_op_put(0, "支付宝支付异常[0XALI]");
        }
        return get_op_put(1, "支付宝拉起成功", $res);
    }

    /**
     * 支付宝支付
     */
    public function testalipay() {
        $orders = M("orders");
        $aliapp = D("Inter/Aliapp", "Logic");
        #
        $res = $aliapp->runs($orders->find(1));
        if (!$res) {
            return get_op_put(0, "支付宝支付异常[0XALI]");
        }
        return get_op_put(1, "支付宝拉起成功", $res);
    }

}
