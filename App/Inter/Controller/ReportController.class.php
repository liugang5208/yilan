<?php

namespace Inter\Controller;

#use Think\Controller;

class ReportController extends CommController {

    /**
     * 加入购物车
     */
    public function cartadd() {
        $report = M("report");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        $where["types"] = $post["types"];
        $where["cont_id"] = $post["cont_id"];
        $where["logs_id"] = $post["logs_id"];
        $where["status"] = 1;
        #
        $count = $report->where(["uid" => $post["uid"], "status" => 1])->count();
        $ratio = $this->lists_ratio($post["uid"]);
        if ($count > 0) {
            if ($ratio["ticket"] != $post["ticket"]) {
                $msg = "报价单已存在部分商品报价内容，当前商品税率与现有报价单的【商品税率】不相符，请调整当前商品税率后在进行添加操作";
                return get_op_put(0, $msg . "，或者您可以先清空报价单后在进行当前商品的添加操作，谢谢!", json_encode($ratio) . "=" . $post["ticket_fee"]);
            }
        }
        #
        if ($post["types"] > 0) {
            return $this->cartadd_up_log($where, $post);
        }
        $where["good_id"] = 0;
        $res = $this->cartadd_single($where, $post);
        #
        return get_op_put($res["status"], $res["msg"], $res["data"]);
    }

    /**
     * 单个商品
     */
    public function cartadd_single($where, $post) {
        $report = M("report");
        #
        $info = NULL;
        #$info = $report->where($where)->find();
        if ($info == NULL) {
            $where["nums"] = $post["nums"];
            $where["ticket"] = $post["ticket"];
            $where["ticket_fee"] = $post["ticket_fee"];
            $where["uptimes"] = 0;
            $where["times"] = time();
            if (!$report->add($where)) {
                return get_op_res(0, "添加数据失败");
            }
            return get_op_res(1, "添加数据成功");
        }
        #
        $save = ["nums" => $post["nums"], "status" => $post["status"], "uptimes" => time()];
        if (!$report->where($where)->save($save)) {
            return get_op_res(0, "更新数据失败");
        }
        return get_op_res(1, "更新数据成功");
    }

    /**
     * 加入购物车-更新商品记录
     */
    private function cartadd_up_log($where, $post) {
        #
        foreach ($post["report_logs"] as $k => $v) {
            if ($v["nums"] < 1) {
                continue;
            }
            $where["good_id"] = $v["id"];
            $post["nums"] = $v["nums"];
            $res = $this->cartadd_single($where, $post);
            if ($res["status"] != 1) {
                return get_op_put(0, "更新数据失败");
            }
        }
        return get_op_put(1, "更新数据成功");
    }

    /**
     * 移除报价
     * @return type
     */
    public function cartdel() {
        $report = M("report");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        if (!$report->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        return get_op_put(1, "删除数据成功");
    }

    /**
     * 清空报价
     * @return type
     */
    public function clearall() {
        $report = M("report");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        // $count = $report->where($where)->count();
        // if($count <= 0){
        //     return get_op_put(0, "没有订单");
        // }
        $report->where($where)->delete();
        // if ($report->where($where)->delete() == false) {
        //     return get_op_put(0, "删除数据失败");
        // }
        $report_temp = M("report_temp");
        $report_temp->where(['uid'=>$post["uid"]])->delete();
        return get_op_put(1, "删除数据成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 报价单列表
     */
    public function lists() {
        $report = M("report");
        $post = $this->param;
        #
        $tmplevel = R('Carts/getUser', array($post["uid"]));
        $ratio = 1 + $post["ratio"] / 100;
        $list = $report->where(["uid" => $post["uid"], "status" => 1])->select();
        #
        $total = 0;
        foreach ($list as $k => $v) {
            $tmp = $v["types"] > 0 ? $this->lists_more($v) : $this->lists_sigl($v);
            $tmp["price"] = round($tmp["price"] * $tmplevel["up"] * $v["ticket_fee"] * $ratio, 2);
            $tmp["total"] = round($tmp["price"] * $tmp["nums"], 2);
            $tmp["id"] = $v["id"];
            #
            $total = $total + $tmp["total"];
            $list[$k] = $tmp;
        }
        #
        $list_ratio = $this->lists_ratio($post["uid"]);
        $res = [
            "list" => $list,
            "total" => $total,
            "total_n" => num_to_rmb($total),
            "level" => $tmplevel["up"],
            "ratio" => $list_ratio["ratio"],
            "ticket" => $list_ratio["ticket"],
        ];
        #
        return get_op_put(1, "获取数据成功", $res);
    }

    /**
     * 获取发票比率
     */
    private function lists_ratio($uid) {
        $report = M("report");
        #
        $list = $report->where(["uid" => $uid])->group("ticket_fee,ticket")->find();
        #
        return ["ticket" => $list["ticket"], "ratio" => $list["ticket_fee"]];
    }

    /**
     * 单个商品
     */
    private function lists_sigl($v) {
        $plate_conts = M("plate_conts");
        #
        $conts = $plate_conts->find($v["cont_id"]);
        $logs = getplateContslogs($v["logs_id"]);
        #
        $res = array(
            "attr1" => $logs["key_0"] . ":" . $logs["value_0"],
            "attr2" => $logs["key_1"] . ":" . $logs["value_1"],
            "attr3" => $logs["key_2"] . ":" . $logs["value_2"],
            "unit" => $conts["g_unit"],
            "price" => $logs["market"],
            "nums" => $v["nums"],
        );
        return $res;
    }

    /**
     * 多个商品
     */
    private function lists_more($v) {
        $plate_conts = M("plate_conts");
        #
        $conts = $plate_conts->find($v["cont_id"]);
        $logs = getplateContslogs($v["logs_id"]);
        $logsr = getplateContslogsr($v["good_id"]);
        #
        $res = array(
            "attr1" => $logs["key_0"] . ":" . $logs["value_0"],
            "attr2" => $logs["key_1"] . ":" . $logs["value_1"],
            "attr3" => $logs["key_2"] . ":" . $logs["value_2"],
            "unit" => $conts["g_unit"],
            "price" => $logsr["market"],
            "nums" => $v["nums"],
        );
        return $res;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 创建报价单
     */
    public function lists_add() {
        $report = M("report");
        $report_info = D("report_info");
        $report_info_log = M("report_info_log");
        $post = $this->param;
        #
        $data = $report_info->create($post, 1);
        if (!$data) {
            return get_op_put(0, $report_info->getError());
        }
        $report_info->startTrans();
        $id = $report_info->add($data);
        if (!$id) {
            $report_info->rollback();
            return get_op_put(0, "创建报价单失败");
        }
        #获取价格比例
        $tmplevel = R('Carts/getUser', array($post["uid"]));
        $ratio = 1 + $data["ratio"] / 100;
        #
        $where = ["uid" => $post["uid"], "status" => 1];
        $list = $report->where($where)->select();
        foreach ($list as $k => $v) {
            $tmp = $v["types"] > 0 ? $this->lists_more($v) : $this->lists_sigl($v);
            #
            $list[$k]["repid"] = $id;
            $list[$k]["attr1"] = $tmp["attr1"];
            $list[$k]["attr2"] = $tmp["attr2"];
            $list[$k]["attr3"] = $tmp["attr3"];
            $list[$k]["unit"] = $tmp["unit"];
            $list[$k]["market"] = $tmp["price"];
            $list[$k]["price"] = round($tmp["price"] * $tmplevel["up"] * $v["ticket_fee"] * $ratio, 2);
            $list[$k]["total"] = round($list[$k]["price"] * $tmp["nums"], 2);
        }
        if (!$report_info_log->addAll($list)) {
            $report_info->rollback();
            return get_op_put(0, "创建报价单失败[LOR]");
        }
        #
        if (!$report->where($where)->delete()) {
            $report_info->rollback();
            return get_op_put(0, "创建报价单失败[SF]");
        }
        $report_info->commit();
        return get_op_put(1, "获取数据成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 报价单列表
     */
    public function replist() {
        $report_info = D("report_info");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        $list = $report_info->where($where)->order("id desc")->select();
        $log = M('report_info_log');
        foreach ($list as $k => $v) {
            $list[$k]["time_zone"] = date("Y-m-d H:i", $v["times"]);
            $list[$k]['goods_count'] = $log->where(['repid'=>$v['id']])->count();
        }
        #
        return get_op_put(1, "获取数据成功", $list);
    }

    /**
     * 移除报价
     * @return type
     */
    public function repdel() {
        $report_info = D("report_info");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        if (!$report_info->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        return get_op_put(1, "删除数据成功");
    }

    /**
     * 清空报价
     * @return type
     */
    public function repall() {
        $report_info = D("report_info");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        $count = $report_info->where($where)->count();
        if($count <= 0){
            return get_op_put(0, "没有订单");
        }
        if (!$report_info->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        return get_op_put(1, "删除数据成功");
    }

    /**
     * 报价单详情
     */
    public function repinfos() {
        $report_info = D("report_info");
        $report_info_log = M("report_info_log");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        $info = $report_info->where($where)->find();
        
        if($info['logo']){
             $info['logo'] = C("WEBIMG").$info['logo'];
        }
       
        #
        $tmplevel = R('Carts/getUser', array($post["uid"]));
        $list = $report_info_log->where(["repid" => $info["id"]])->select();
        #
        $total = 0;
        foreach ($list as $k => $v) {
            $total = $total + $v["total"];
        }
        #
        $res = [
            "list" => $list,
            "total" => $total,
            "total_n" => num_to_rmb($total),
            "level" => $tmplevel["up"],
            "ratio" => ($info["ticket_fee"] - 1) * 100,
            "info" => $info,
        ];
        return get_op_put(1, "获取数据成功", $res);
    }

}
