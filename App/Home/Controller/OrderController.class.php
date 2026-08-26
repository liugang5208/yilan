<?php

namespace Home\Controller;

#use Think\Controller;

class OrderController extends CommController {

    public function index() {
        $orders = M("orders");
        $post = I("get.");
        #
        $post["sn"] != null ? $where["sn"] = array("like", "%" . $post["sn"] . "%") : null;
        if ($post["phone"] != null) {
            $where["_string"] = "uid in (select id from users where phone like '%" . $post["phone"] . "%')";
        }
        #
        $where["status"] = $post["status"] != null ? $post["status"] : array("egt", 0);
        $list = boPage($orders, $where, "id desc");
        #
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 订单详情
     */
    public function infos($id) {
        $orders = M("orders");
        $orders_trans = M("orders_trans");
        #
        $where["id"] = $id;
        $info = $orders->where($where)->find();
        $addr = getAddrName($info["addr_id"]);
        $tic_addr = getAddrName($info["ticket_addr"]);
        $trans = $orders_trans->where(["oid" => $id])->find();
        $goods = $this->index_logs($info);
        #
        $this->assign("info", $info);
        $this->assign("addr", $addr);
        $this->assign("ticaddr", $tic_addr);
        $this->assign("trans", $trans);
        $this->assign("goods", $goods);
        $this->display();
    }

    /**
     * 订单详情-订单商品-订单购物车
     * @param type $sn
     * @return type
     */
    private function index_logs($info) {
        $orders_goods = M("orders_goods");
        #
        $where = ["oid" => $info["id"]];
        $list = $orders_goods->where($where)->select();//var_dump($list);
        #
        $total = 0;
        foreach ($list as $k => $v) {
            $v["ticket_fee"] = $info["ticket_fee"];
            #
            $tmp = $v["types"] > 0 ? lists_more($v, $info["user_up"]) : lists_sigl($v, $info["user_up"]);
            #
            $tmp["types"] = $v["types"];
            $tmp["price"] = round($tmp["full"], 2);
            $tmp["total"] = round($tmp["price"] * $tmp["nums"], 2);
            #
            $tmp['market'] = $v['market'];
            $list[$k] = $tmp;
            $total = $total + $tmp["nums"];
        }
        #
        return ["list" => $list, "total" => $total];
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 物流信息
     */
    public function trans_info() {
        $orders_trans = M("orders_trans");
        $post = I("post.");
        #
        $where["oid"] = $post["ids"];
        $info = $orders_trans->where($where)->find();
        if ($info != NULL) {
            $info["ids"] = $info["id"];
            unset($info["id"]);
        }
        $info["oid"] = $post["ids"];
        #
        return get_op_put(1, null, $info);
    }

    /**
     * 物流更新
     */
    public function trans_up() {
        $orders_trans = D("orders_trans");
        $orders = M("orders");
        $post = I("post.");
        #
        $data = $orders_trans->create($post, 1);
        if (!$data) {
            return get_op_put(0, $orders_trans->getError());
        }
        $imgs = uploadFile("trans_tik");
        $imgs ? $data["trans_imgs"] = $imgs["trans_imgs"]["savename"] : null;
        #
        if ($post["ids"] == NULL) {
            $data["times"] = time();
            if (!$orders_trans->add($data)) {
                return get_op_put(0, "更新失败");
            }
            $orders->where(["id" => $post["oid"]])->save(["status" => 2, "uptimes" => time()]);
            return $this->trans_up_notify($data);
        }
        $data["uptimes"] = time();
        if (!$orders_trans->where(["id" => $post["ids"]])->save($data)) {
            return get_op_put(0, "更新失败[0X]");
        }
        return $this->trans_up_notify($data);
    }

    /**
     * 物流通知
     */
    private function trans_up_notify($data) {
        $orders = M("orders");
        $users = M("users");
        $mess = D("Home/Mess", "Logic");
        #
        $where["id"] = $data["oid"];
        $info = $orders->where($where)->find();
        if ($info == NULL) {
            return get_op_put(1, "更新成功", 404);
        }
        $uinf = $users->where(["id" => $info["uid"]])->find();
        if ($uinf == NULL) {
            return get_op_put(1, "更新成功", 406);
        }
        $param["sn"] = $info["sn"];
        $param["phone"] = $uinf["phone"];
        $param["trans"] = $data["trans"];
        #
        if (!$mess->runs($param, 1)) {
            return get_op_put(1, "更新成功", 4505);
        }
        return get_op_put(1, "更新成功", 200);
    }

}
