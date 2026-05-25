<?php

namespace Inter\Opera;

/**
 * Description of CartsOpera
 * 购物车
 * @author Administrator
 */
class CartsOpera {

    private $param;
    private $puts;

    /**
     * 入口
     */
    public function runs($param) {
        $this->param = $param;
        return $this->setCart();
    }

    /**
     * 检查是否有商品
     */
    private function setCart() {
        $this->puts["uid"] = $this->param["uid"];
        $this->puts["sn"] = "0";
        $this->puts["oid"] = "0";
        $this->puts["types"] = $this->param["types"];
        $this->puts["cont_id"] = $this->param["cont_id"];
        $this->puts["logs_id"] = $this->param["logs_id"];
        #
        return $this->fixRatio();
    }

    /**
     * 修改非同类费率
     */
    private function fixRatio() {
        $carts = M("carts");
        #
        $cond = [
            "uid" => $this->param["uid"],
            "sn" => "0",
            "ticket" => ["neq", $this->param["ticket"]],
            "status" => 1
        ];
        $carts->where($cond)->save(["status" => 0, "uptimes" => time()]);
        #
        return $this->checkIsInfo();
    }

    /**
     * 判断是否加入过购物车
     */
    private function checkIsInfo() {
        $carts = M("carts");
        #
        $where = $this->puts;
        $info = $carts->where($where)->find();
        #有购物车信息
        if ($info != NULL) {
            return $this->cartadd_up($info);
        }
        #无购物车信息
        return $this->addNewCart();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 新记录
     */
    private function addNewCart() {
        $carts = M("carts");
        #
        $this->puts["nums"] = $this->param["nums"];
        $this->puts["ticket"] = $this->param["ticket"];
        $this->puts["ticket_fee"] = $this->param["ticket_fee"];
        $this->puts["status"] = 1;
        $this->puts["uptimes"] = 0;
        $this->puts["times"] = time();
        #
        $id = $carts->add($this->puts);
        if (!$id) {
            return get_op_put(0, "添加数据失败");
        }
        $this->puts["id"] = $id;
        #判断是否立即购物
        if ($this->param["buyer"] > 0) {
            $this->cartadd_up_buy($id);
        }
        if ($this->param["types"] < 1) {
            return get_op_put(1, "更新数据成功", "102");
        }
        return $this->cartadd_up_log($this->puts);
    }

    /**
     * 旧记录
     */
    private function cartadd_up($info) {
        $carts = M("carts");
        #
        $save = [
            "ticket" => $this->param["ticket"],
            "ticket_fee" => $this->param["ticket_fee"],
            "nums" => $this->param["nums"] + $info["nums"],
            "status" => $this->param["status"],
            "uptimes" => time()
        ];
        if ($this->param["buyer"] > 0) {
            $save["nums"] = $this->param["nums"];  //立即购买只按照实际添加数量购买
        }
        #
        if (!$carts->where(["id" => $info["id"]])->save($save)) {
            //return get_op_put(0, "更新数据失败");
        }
        if ($this->param["buyer"] > 0) {
            $this->cartadd_up_buy($info["id"]);
        }
        if ($this->param["types"] < 1) {
            return get_op_put(1, "更新数据成功", "102");
        }
        return $this->cartadd_up_log($info);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 更新立即购买
     * @param type $uid
     * @param type $id
     */
    private function cartadd_up_buy($id) {
        $carts = M("carts");
        #
        $where["uid"] = $this->param["uid"];
        $where["id"] = array("neq", $id);
        $where["status"] = 1;
        #
        return $carts->where($where)->save(["status" => 0]);
    }

    /**
     * 更新商品记录-有则更新无则忽略
     */
    private function cartadd_up_log($info) {
        $carts_logs = M("carts_logs");
        #
        foreach ($this->param["carts_logs"] as $k => $v) {
            if ($v["nums"] < 1) {
                continue;
            }
            #
            $where = ["cart_id" => $info["id"], "g_id" => $v["id"]];
            $count = $carts_logs->where($where)->count();
            if ($count > 0) {
                $carts_logs->where($where)->save(["nums" => $v["nums"]]);
                continue;
            }
            $where["nums"] = $v["nums"];
            $carts_logs->where($where)->add($where);
        }
        return get_op_put(1, "更新数据成功", "103");
    }

}
