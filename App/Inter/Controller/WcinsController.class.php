<?php

namespace Inter\Controller;

use Think\Controller;

class WcinsController extends Controller {

    /**
     * 微信返回-WEB支付
     */
    public function respay() {
        $wcres = D("Inter/WcRes", "Logic");
        $data = file_get_contents('php://input', true);
        #
        echo $wcres->entrance($data);
    }

    /**
     * 支付宝返回-WEB支付
     */
    public function alires() {
        $orders = M("orders");
        $request = I("request.");
        #
        if ($request["trade_status"] != "TRADE_SUCCESS") {
            return get_op_put(0, "Error");
        }
        $where["sn"] = $request["out_trade_no"];
        $where["status"] = 0;
        $info = $orders->where($where)->find();
        if ($info == null) {
            return get_op_put(0, "NotFound");
        }
        #
        $save["paytime"] = time();
        $save["status"] = 1;
        $save["uptimes"] = time();
        #
        if (!$orders->where($where)->save($save)) {
            return get_op_put(0, "PayError");
        }
        $this->creInfoPush($info);
        #
        echo "ok";
    }

    /**
     * 推送通知
     */
    private function creInfoPush($puts) {
        $users = M("users");
        $sysconfig = M("sysconfig");
        $mess = D("Home/Mess", "Logic");
        #
        $u = $users->where(["id" => $puts["uid"]])->find();
        if ($u == NULL) {
            return false;
        }
        ////////////////////////////////////////////////////////////////////////
        if ($puts["paymode"] < 3) {
            $param = ["phone" => $u["phone"], "sn" => $puts["sn"], "ticket" => $puts["ticket_fee"], "tex" => $puts["ticket"], "money" => $puts["money"]];
            $mess->runs($param, 0);
            #
            $phone = $sysconfig->where(["id" => 3])->find();
            $param["phone"] = $phone["valuc"];
            $param["phone_push"] = $u["phone"];
            $mess->runs($param, 2);
        }
        #
        return true;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 报价详情
     */
    public function repinfos($id) {
        layout(false);
        $report_info = D("report_info");
        $report_info_log = M("report_info_log");
        #
        $where["id"] = $id;
        $info = $report_info->where($where)->find();
        #
        $tmplevel = R('Carts/getUser', array($info["uid"]));
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
        $logo = '';
        if($info['logo']){
            $logo = '<img style="width: 100vw;" src="'.C("WEBIMG") . $info['logo'].'">';
        }
        
        $kid_num = 0;
        $goods_num = 0;
        $ticket_title = '';
        foreach ($list as $k=>$v){
            $goods_num +=$v['nums'];
            $kid_num ++;
        }
        if($info['ticket'] == 0){
            $ticket_title = '不含税票';
        }elseif($info['ticket'] == 1){
            $ticket_title = '普通发票';
        }elseif($info['ticket'] == 2){
            $ticket_title = '专用发票';
        }else{
             $ticket_title = $info['ticket'];
        }
        $this->assign("kid_num", $kid_num);
        $this->assign("goods_num", $goods_num);
        $this->assign("ticket_title", $ticket_title);
        // var_dump($info['tags']);
        $this->assign("list", $res["list"]);
        $this->assign("total", $res["total"]);
        $this->assign("total_n", $res["total_n"]);
        $this->assign("level", $res["level"]);
        $this->assign("ratio", $res["ratio"]);
        $this->assign("infos", $info);
        $this->assign("logo", $logo);
        $this->display();
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
        $plate_conts_logs = M("plate_conts_logs");
        #
        $conts = $plate_conts->find($v["cont_id"]);
        $logs = $plate_conts_logs->find($v["logs_id"]);
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
        $plate_conts_logs = M("plate_conts_logs");
        $plate_conts_logsr = M("plate_conts_logsr");
        #
        $conts = $plate_conts->find($v["cont_id"]);
        $logs = $plate_conts_logs->find($v["logs_id"]);
        $logsr = $plate_conts_logsr->find($v["good_id"]);
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

}
