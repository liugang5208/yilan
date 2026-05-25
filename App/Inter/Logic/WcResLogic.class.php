<?php

/**
 * 微信支付返回结果
 */

namespace Inter\Logic;

class WcResLogic {

    //
    private $config;
    //
    private $sn;
    private $data;

    public function __construct() {
        $sysconfig = C("WEC_CONFIG");
        $this->config = $sysconfig["PAYKEY"];
    }

    /**
     * 接口入口
     */
    public function entrance($data) {
        return $this->deCodeXml($data);
    }

    /**
     * 解析XML记录日志
     */
    private function deCodeXml($data) {
        $tmp = xmlToArray($data);
        if (!$tmp) {
            return false;
        }
        #
        $log = M("wcpaylog");
        $tmp["json_code"] = json_encode($tmp);
        $tmp["times"] = time();
        $log->add($tmp);
        #
        unset($tmp["json_code"]);
        unset($tmp["times"]);
        $this->data = $tmp;
        return $this->verifySign();
    }

    /**
     * 验证参数
     * @return boolean
     */
    private function verifySign() {
        $mySign = $this->DataToSign($this->data);
        if ($mySign != $this->data["sign"]) {
            return false;
        }
        return $this->verifyOrds();
    }

    /**
     * 订单验证
     * @return boolean
     */
    private function verifyOrds() {
        $orders = M("orders");
        #
        $tmp = explode("_", $this->data["out_trade_no"]);
        $where["sn"] = $tmp[0];
        $this->sn = $tmp[0];
        //$where["money"] = $this->data["total_fee"] / 100;
        $where["status"] = 0;
        $info = $orders->where($where)->find();
        if ($info == null) {
            return false;
        }
        #
        return $this->veridyStaty();
    }

    /**
     * 订单状态验证
     */
    private function veridyStaty() {
        if ($this->data["result_code"] != "SUCCESS") {
            return $this->wechatRollback();
        }
        $orders = M("orders");
        #
        $where["sn"] = $this->sn;
        $info = $orders->where($where)->find();
        #
        $save["paytime"] = time();
        $save["status"] = 1;
        $save["uptimes"] = time();
        if (!$orders->where($where)->save($save)) {
            return false;
        }
        #MSG
        $this->creInfoPush($info);
        #
        return $this->wechatRollback();
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

    ##################公有方法######################

    /**
     * 生成签名戳
     * @param type $param
     * @return type
     */
    private function DataToSign($param) {
        ksort($param);
        foreach ($param as $key => $value) {
            if ($key != "sign" && $key != "times" && $value != "" && !is_array($value)) {
                $tmp .= $key . "=" . $value . "&";
            }
        }
        $key = $tmp . "key=" . $this->config;
        return strtoupper(md5($key));
    }

    /**
     * 微信返回
     */
    private function wechatRollback() {
        $string = "<xml>";
        $string .= "<return_code><![CDATA[SUCCESS]]></return_code>";
        $string .= "<return_msg><![CDATA[OK]]></return_msg>";
        $string .= "</xml>";
        return $string;
    }

}
