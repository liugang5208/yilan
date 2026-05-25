<?php

/**
 * 微信支付
 */

namespace Inter\Logic;

class WcPayLogic {

    //统一下单接口
    const coomUrl = "https://api.mch.weixin.qq.com/pay/unifiedorder";

    //
    private $param;
    //
    private $config;
    private $data;

    public function __construct() {
        $sysconfig = C("WEC_CONFIG");
        $this->config = $sysconfig;
    }

    /**
     * 接口入口
     */
    public function entrance($data) {
        $this->param = $data;
        return $this->coverDatas();
    }

    /**
     * 创建数据
     */
    public function coverDatas() {
        $this->data["appid"] = $this->config["APPID"];
        $this->data["mch_id"] = $this->config["MCHID"];
        #
        //$this->data["device_info"] = "web";
        $this->data["nonce_str"] = md5(time());
        $this->data["body"] = $this->param["body"];
        $this->data["attach"] = trimall($this->param["attach"]);
        $this->data["out_trade_no"] = $this->param["sn"] . "_" . mt_rand(1000, 9999);
        $this->data["total_fee"] = $this->param["money"] * 100;
        //$this->data["total_fee"] = 1;
        //
        $this->data["spbill_create_ip"] = "127.0.0.1";
        $this->data["notify_url"] = $this->config["notifyUrl"];
        $this->data["trade_type"] = "APP";
        #
        return $this->signToData();
    }

    /**
     * 生成SIGN
     */
    private function signToData() {
        $this->data["sign"] = $this->DataToSign($this->data);
        $xml = "<xml>" . data_to_xml($this->data, "xml") . "</xml>";
        return $this->payToBills($xml);
    }

    /**
     * 下单
     * @param type $params
     */
    private function payToBills($params) {
        $res = poCurl(self::coomUrl, $params);
        $tmp = xmlToArray($res);
        //
        if ($tmp["return_code"] != "SUCCESS") {
            $syslog = M("syslog");
            $syslog->name = "WXPAY";
            $syslog->send = $params;
            $syslog->back = $res;
            $syslog->times = date("Y-m-d H:i:s");
            $syslog->add();
            #
            return false;
        }
        #
        $appid = $this->config["APPID"];
        $newPut["appid"] = $appid;
        $time = time();
        #
        $newPut["partnerid"] = $this->config["MCHID"];
        $newPut["prepayid"] = $tmp["prepay_id"];
        $newPut["noncestr"] = $tmp["nonce_str"];
        $newPut["timestamp"] = "$time";
        $newPut["package"] = "Sign=WXPay";
        $newPut["sign"] = $this->DataToSign($newPut);
        return $newPut;
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
            if ($key != "sign" && $value != null) {
                $tmp .= $key . "=" . $value . "&";
            }
        }
        $paykey = $this->config["PAYKEY"];
        $key = $tmp . "key=" . $paykey;
        return strtoupper(md5($key));
    }

}
