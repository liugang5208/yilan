<?php

namespace Inter\Opera;

/**
 * Description of OrderOpera
 * 创建订单
 * @author admins
 */
class OrderOpera {

    public $param;
    public $ulevel;

    /**
     * 入口
     * @param type $param
     */
    public function runs($param) {
        $this->param = $param;
        #
        if ($param["addr_id"] == NULL || $param["addr_id"] < 1) {
            return get_op_res(0, "请选择地址");
        }
        if ($this->param["ticket"] > 0) {
            if ($param["ticket_comp"] == NULL || $param["ticket_comp"] < 1) {
                return get_op_res(0, "请选择【购买人】公司发票信息");
            }
            if ($param["ticket_addr"] == NULL || $param["ticket_addr"] < 1) {
                return get_op_res(0, "请选择发票及合同邮寄地址");
            }
        }
        if ($this->param["paymode"] == "2") {
            if ($param["save_name"] == NULL || $param["save_name"] == "") {
                return get_op_res(0, "请填写发货人名称");
            }
            if ($param["save_phone"] == NULL || $param["save_phone"] == "") {
                return get_op_res(0, "请填写发货人电话");
            }
            if ($param["save_addr"] == NULL || $param["save_addr"] == "") {
                return get_op_res(0, "请填写发货人地址");
            }
        }
        return $this->setOrdInfo();
    }

    /**
     * 设置订单信息
     */
    private function setOrdInfo() {
        $puts["sn"] = $this->getSN();
        $puts["uid"] = $this->param["uid"];
        $puts["addr_id"] = $this->param["addr_id"];
        $puts["paymode"] = $this->param["paymode"];
        $puts["paytype"] = $this->param["paytype"];
        $puts["paytime"] = 0;
        $puts["needlist"] = $this->param["needlist"];
        $puts["tags"] = $this->param["tags"];
        $puts["trade_type"] = $this->param["trade_type"];
        $puts["ori_money"] = $this->getMoney();
        $puts["money"] = $puts["ori_money"];
        if ($this->param["paymode"] == "1") {
            $puts["money"] = $puts["ori_money"] * 0.3;
        }
        #
        $puts["ticket"] = $this->param["ticket"];
        $puts["ticket_fee"] = $this->param["ticket_fee"];
        $puts["trans"] = $this->ulevel["trans"];
        $puts["user_up"] = $this->ulevel["up"];
        #
        $puts["ticket_comp"] = $this->param["ticket_comp"];
        $puts["ticket_tag"] = $this->param["ticket_tag"];
        $puts["ticket_addr"] = $this->param["ticket_addr"];
        #
        $puts["save_name"] = $this->param["save_name"];
        $puts["save_phone"] = $this->param["save_phone"];
        $puts["save_addr"] = $this->param["save_addr"];
        #
        if ($this->param["image"] != NULL) {
            $puts["save_imgs"] = saveImageToFile("FR", $this->param["image"], "ticket");
        }
        #
        $puts["status"] = 0;
        if ($this->param["paymode"] == "4") {
            $puts["paytime"] = time();
            $puts["status"] = 1;
        }
        $puts["uptimes"] = 0;
        $puts["times"] = time();
        #
        #
        return $this->creInfo($puts);
    }

    /**
     * 创建订单
     */
    private function creInfo($puts) {
        $orders = M("orders");
        $carts = M("carts");
        $carts_logs = M("carts_logs");
        $orders_goods = M("orders_goods");
        $orders_goods_logs = M("orders_goods_logs");
        #
        if ($puts["money"] <= 0) {
            return get_op_res(0, "订单金额不能为0");
        }
        #
        $orders->startTrans();
        $id = $orders->add($puts);
        $puts["id"] = $id;
        if (!$id) {
            $orders->rollback();
            return get_op_res(0, "创建订单失败");
        }
        #操作订单表
        $where["uid"] = $this->param["uid"];
        $where["status"] = 1;
        $list = $carts->where($where)->select();
        $goods = [];
        $goodslog = [];
        foreach ($list as $k => $v) {
            $temp = $v["types"] > 0 ? lists_more($v, $this->ulevel["up"]) : lists_sigl($v, $this->ulevel["up"]);
            $market = $v["types"] < 1 ? $temp["market"] : 0;
            $full = $v["types"] < 1 ? $temp["market"] * $v["nums"] : 0;
            #
            $goods[] = [
                "oid" => $id,
                "types" => $v["types"],
                "cont_id" => $v["cont_id"],
                "logs_id" => $v["logs_id"],
                "nums" => $v["nums"],
                "market" => $market,
                "full" => $full,
                "name" => $temp["name"],
                "imgs" => $temp["imgs"],
                "attr1" => $temp["attr1"],
                "attr2" => $temp["attr2"],
                "attr3" => $temp["attr3"],
                "catname" => $temp["catname"],
                "unit" => $temp["unit"],
            ];
            #
            $child = $carts_logs->where(["cart_id" => $v["id"]])->select();
            foreach ($child as $m => $s) {
                $ginfo = getplateContslogsr($s["g_id"]);
                $goodslog[] = [
                    "oid" => $id,
                    "cont_id" => $v["cont_id"],
                    "logs_id" => $v["logs_id"],
                    "g_id" => $s["g_id"],
                    "nums" => $s["nums"],
                    "market" => $ginfo["market"],
                    "full" => $ginfo["market"] * $this->param["ticket_fee"] * $s["nums"] * $this->ulevel["up"]
                ];
            }
        }
        #
        if (!$orders_goods->addAll($goods)) {
            $orders->rollback();
            return get_op_res(0, "创建订单失败[GNS]");
        }
        if (count($goodslog) > 0) {
            if (!$orders_goods_logs->addAll($goodslog)) {
                $orders->rollback();
                return get_op_res(0, "创建订单失败[GLS]");
            }
        }
        #
        if (!$carts->where($where)->delete()) {
            $orders->rollback();
            return get_op_res(0, "创建订单失败[SNID]");
        }
        #
        $orders->commit();
        return $this->creInfoPush($puts);
    }

    /**
     * 推送通知
     */
    private function creInfoPush($puts) {
        $users = M("users");
        $sysconfig = M("sysconfig");
        $mess = D("Home/Mess", "Logic");
        #
        $resmsg = ["id" => $puts["id"], "paytype" => $puts["paytype"]];
        $u = $users->where(["id" => $puts["uid"]])->find();
        if ($u == NULL) {
            return get_op_put(1, "创建订单成功U", $resmsg);
        }
        ////////////////////////////////////////////////////////////////////////
        $param = ["phone" => $u["phone"], "sn" => $puts["sn"], "ticket" => $puts["ticket_fee"], "tex" => $puts["ticket"], "money" => $puts["money"]];
        if ($puts["paymode"] == "3") {
            $mess->runs($param, 6);
        }
        if ($puts["paymode"] == "4") {
            $mess->runs($param, 0);
        }
        if ($puts["paymode"] == "3" || $puts["paymode"] == "4") {
            $phone = $sysconfig->where(["id" => 3])->find();
            $param["phone"] = $phone["valuc"];
            $param["phone_push"] = $u["phone"];
            $mess->runs($param, 2);
        }
        #
        return get_op_res(1, "创建订单成功", $resmsg);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 获取用户信息
     * @return type
     */
    private function getUlevel($mode = "0",$plate_cats_id = 0) {
        $users = M("users");
        $users_level = M("users_level");
        #
        $where["id"] = $this->param["uid"];
        $info = $users->where($where)->find();
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
        $level["up"] = 1 + $level["up"] / 100;
        #
        $this->ulevel = $level;
        return $level;
    }

    /**
     * 获取金额
     */
    private function getMoney() {
        $carts = M("carts");
        $carts_logs = M("carts_logs");
        #
        $where["uid"] = $this->param["uid"];
        $where["status"] = 1;
        $list = $carts->where($where)->select();
        #
        $price = 0;
        foreach ($list as $k => $v) {
            if ($v["types"] == "0") {
                $temp = getplateContslogs($v["logs_id"]);
                
                $info = getplateConts($v["cont_id"]);
                $cats = getCatsName($info["catid"]);
                
                $level = $this->getUlevel($cats["float_cat"],$cats['id']);
                // $level = $this->getUlevel($temp["catid"]);
                $price = $price + round($temp["market"] * $v["ticket_fee"] * $level["up"], 2) * $v["nums"];
                // if($this->param["uid"] == 56){
                //     var_dump($temp['market']);var_dump($v['ticket_fee']);var_dump($level['up']);die;
                // }
                continue;
            }
            ////////////////////////////////////////////////////////////////////
            $tmp = $carts_logs->where(["cart_id" => $v["id"]])->select();
            $tmp_price = 0;
            foreach ($tmp as $m => $s) {
                $ginfo = getplateContslogsr($s["g_id"]);
                $level = $this->getUlevel($ginfo["catid"]);
                $tmp_price = $tmp_price + round($ginfo["market"] * $v["ticket_fee"] * $level["up"], 2) * $s["nums"];
            }
            $price = $price + $tmp_price;
        }
        return $price;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 订单号
     * @return type
     */
    private function getSN() {
        $arr = [
            "A", "B", "C", "D", "E", "F", "G", "H",
            "I", "J", "K", "L", "M", "N", "O", "P",
            "Q", "R", "S", "T", "U", "V", "W", "X",
            "Y", "Z",
        ];
        $pre = "YL" . $arr[mt_rand(0, 25)] . $arr[mt_rand(0, 25)];
        $number = mt_rand(10, 99) . time() . mt_rand(0, 9);
        #
        return $pre . $number;
    }

}
