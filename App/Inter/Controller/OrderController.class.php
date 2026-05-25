<?php

namespace Inter\Controller;

#use Think\Controller;

class OrderController extends CommController {

    /**
     * 订单
     */
    public function index() {
        $orders = M("orders");
        $post = $this->param;
        #
        $post["key"] != NULL ? $where["sn"] = array("like", "%" . $post["key"] . "%") : NULL;
        $where["status"] = $post["st"] != 10 ? $post["st"] : array("egt", 0);
        $where["uid"] = $post["uid"];
        $list = $orders->where($where)->order("id desc")->select();
        foreach ($list as $k => $v) {
            $oinfo = $this->index_logs($v);
            $list[$k]["time_zone"] = date("Y/m/d", $v["times"]);
            $list[$k]["oinfo"] = $oinfo["list"];
            $list[$k]["o_name"] = acOrds($v["status"]);
            $list[$k]["count"] = $oinfo["total"];
        }
        return get_op_put(1, null, $list);
    }

    /**
     * 订单购物车
     * @param type $info
     * @return type
     */
    private function index_logs($info) {
        $orders_goods = M("orders_goods");
        #
        $where = ["oid" => $info["id"]];
        $list = $orders_goods->where($where)->select();
        #
        $total = 0;
        foreach ($list as $k => $v) {
            $v["ticket_fee"] = $info["ticket_fee"];
            $v["price"] = $v["market"];
            #
            $list[$k] = $v;
            $total = $total + $v["nums"];
        }
        #
        return ["list" => $list, "total" => $total];
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 订单详情
     */
    public function oinfo() {
        $orders = M("orders");
        $carts = M("carts");
        $orders_trans = M("orders_trans");
        $post = $this->param;
        #
        $where["id"] = $post["oid"];
        $info = $orders->where($where)->find();
        #
        $oinfo = $this->index_logs($info);
        $info["time_zone"] = date("Y-m-d H:i:s", $info["times"]);
        $info["count"] = $carts->where(["sn" => $info["sn"], "status" => 2])->count();
        $info["oinfo"] = $oinfo["list"];
        $info["count"] = $oinfo["total"];
        $info["addr"] = getAddrName($info["addr_id"]);
        $info["trans_vo"] = $orders_trans->where(["oid" => $info["id"]])->find();
        $info["trans_vo"]["time_zon"] = $info["trans_vo"]["times"] != null && $info["trans_vo"]["times"] > 0 ? date("Y-m-d H:i:s", $info["trans_vo"]["times"]) : "-";
        $info["tik_comp"] = getTicketComp($info["ticket_comp"]);
        $info["o_name"] = acOrds($info["status"]);
        $info["pic_imgs"] = C("WEBIMG") . $info["save_imgs"];
        $info["bank_pri"] = getBankList(0);
        $info["bank_pub"] = getBankList(1);
        #
        return get_op_put(1, null, $info);
    }

    /**
     * 更新订单转账信息
     */
    public function oinfo_up() {
        $orders = M("orders");
        $users = M("users");
        $mess = D("Home/Mess", "Logic");
        $post = $this->param;
        #
        $where["id"] = $post["oid"];
        $info = $orders->where($where)->find();
        if ($info == NULL) {
            return get_op_put(0, "订单信息异常");
        }
        #
        $imgs = saveImageToFile("FR", $post["image"], "ticket");
        if (!$imgs) {
            return get_op_put(0, "图片上传失败");
        }
        $save = ["status" => 1, "paytime" => time(), "save_imgs" => $imgs];
        if (!$orders->where($where)->save($save)) {
            return get_op_put(0, "图片上传失败[0X]");
        }
        #
        $u = $users->where(["id" => $info["uid"]])->find();
        $param = ["phone" => $u["phone"], "sn" => $info["sn"], "money" => $info["money"]];
        $mess->runs($param, 4); #发送信息
        #
        return get_op_put(1, null);
    }

    /**
     * 删除订单
     */
    public function oinfo_del() {
        $orders = M("orders");
        $carts = M("carts");
        #$carts_logs = M("carts_logs");
        $post = $this->param;
        #
        $where["id"] = $post["oid"];
        $info = $orders->where($where)->find();
        if ($info == NULL) {
            return get_op_put(0, "订单信息异常");
        }
        #
        $orders->startTrans();
        if (!$orders->where($where)->delete()) {
            $orders->rollback();
            return get_op_put(0, "订单删除异常");
        }
        $carts->where(["sn" => $info["sn"]])->delete();
        #
        $orders->commit();
        return get_op_put(1, "订单删除成功");
    }

    /**
     * 取消订单
     */
    public function oinfo_fixd() {
        $orders = M("orders");
        $mess = D("Home/Mess", "Logic");
        $users = M("users");
        $post = $this->param;
        #
        $where["id"] = $post["oid"];
        $info = $orders->where($where)->find();
        if ($info == NULL) {
            return get_op_put(0, "订单信息异常");
        }
        #
        $save = ["status" => $post["status"], "uptimes" => time()];
        if (!$orders->where($where)->save($save)) {
            return get_op_put(0, "订单处理异常");
        }
        if ($post["status"] == "3") {
            #
            $u = $users->where(["id" => $info["uid"]])->find();
            $param = ["phone" => $u["phone"], "sn" => $info["sn"], "money" => $info["money"]];
            $mess->runs($param, 5);
        }
        return get_op_put(1, "订单处理成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 创建批量信息
     */
    public function bulks_sn() {
        $bulks_sn = M("bulks_sn");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        $where["from_type"] = $post["from"];
        $where["status"] = 0;
        $info = $bulks_sn->where($where)->order("id desc")->find();
        if ($info != NULL) {
            return get_op_put(1, "获取成功", ["sn" => $info["sn"], "list" => $this->bulks_sn_list($info["sn"], $post["from"])]);
        }
        $where["sn"] = md5(uniqid(true));
        $where["times"] = time();
        if (!$bulks_sn->add($where)) {
            return get_op_put(0, "获取失败");
        }
        return get_op_put(1, "获取成功", ["sn" => $where["sn"], "list" => $this->bulks_sn_list($where["sn"], $post["from"])]);
    }

    /**
     * 获取图片资源
     * @param type $sn
     */
    private function bulks_sn_list($sn, $type) {
        $bulks_logs = M("bulks_logs");
        #
        $where = ["target_sn" => $sn, "from_types" => $type];
        $where["types"] = 1;
        $res["pic"] = $bulks_logs->where($where)->select();
        #
        $where["types"] = 2;
        $res["file"] = $bulks_logs->where($where)->select();
        #
        $where["types"] = 3;
        $res["pic_m"] = $bulks_logs->where($where)->select();
        #
        return $res;
    }

    /**
     * 批量采购
     */
    public function buyer() {
        $bulks_buyer = D("bulks_buyer");
        $post = $this->param;
        #
        if (!$bulks_buyer->create($post, 1)) {
            return get_op_put(0, $bulks_buyer->getError());
        }
        if (!$bulks_buyer->add()) {
            return get_op_put(0, "添加失败");
        }
        return get_op_put(1, "添加成功");
    }

    public function buyer_list() {
        $bulks_buyer = M("bulks_buyer");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        $list = $bulks_buyer->where($where)->select();
        foreach ($list as $k => $v) {
            $list[$k]["time_zone"] = date("Y-m-d H:i:s", $v["times"]);
        }
        #
        return get_op_put(1, "添加成功", $list);
    }

    /**
     * 批量回收
     */
    public function recyle() {
        $bulks_recyle = D("bulks_recyle");
        $post = $this->param;
        #
        if (!$bulks_recyle->create($post, 1)) {
            return get_op_put(0, $bulks_recyle->getError());
        }
        if (!$bulks_recyle->add()) {
            return get_op_put(0, "添加失败");
        }
        return get_op_put(1, "添加成功");
    }

    /**
     * 回收列表
     * @return type
     */
    public function recyle_list() {
        $bulks_recyle = M("bulks_recyle");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        $list = $bulks_recyle->where($where)->select();
        foreach ($list as $k => $v) {
            $list[$k]["time_zone"] = date("Y-m-d H:i:s", $v["times"]);
        }
        #
        return get_op_put(1, "添加成功", $list);
    }

    /**
     * 资源上传
     */
    public function source_up() {
        $bulks_logs = M("bulks_logs");
        $post = $this->param;
        #
        $file = uploadFile("bycyle");
        if (!$file) {
            return get_op_put(0, "文件上传失败");
        }
        $puts["from_types"] = $post["form"];
        $puts["target_id"] = 0;
        $puts["target_sn"] = $post["sn"];
        $puts["types"] = $post["types"];
        $puts["source"] = $file["file"]["savename"];
        $puts["times"] = time();
        if (!$bulks_logs->add($puts)) {
            return get_op_put(0, "文件上传失败[LO]");
        }
        return get_op_put(1, "文件上传成功");
    }

}
