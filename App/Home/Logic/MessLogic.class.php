<?php

/**
 * 互亿无线
 */

namespace Home\Logic;

class MessLogic {

    const smsUrl = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
    const timeout = 120;

    //系统参数
    private $account;
    private $password;
    //变量参数
    private $data;

    /**
     * 初始化参数
     */
    public function __construct() {
        $sysconfig = C("SMS_CONF");
        $this->account = $sysconfig["ACCOUNT"];
        $this->password = $sysconfig["PASSWD"];
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 获取验证码
     */
    public function runs($data, $type) {
        $this->data = $data;
        #
        #ORD
        if ($type == 0) {
            return $this->sentOrd();
        }
        if ($type == 6) {
            return $this->sentOrdBank();
        }
        #TRNS
        if ($type == 1) {
            return $this->sentTrans();
        }
        #TRNS
        if ($type == 2) {
            return $this->sentMangOrd();
        }
        #TRNS
        if ($type == 3) {
            return $this->sentMangTrs();
        }
        #UPS
        if ($type == 4) {
            return $this->sentMangUps();
        }
        if ($type == 5) {
            return $this->saveTrans();
        }
        return $this->sentSms("000000");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 下单通知0
     * @return type
     */
    private function sentOrd() {
        $put = "account=" . $this->account . "&password=" . $this->password . "&mobile=" . $this->data["phone"];
        #
        $str = "尊敬的" . $this->data["phone"] . "用户您好，您的订单" . $this->data["sn"] . "提交成功，我们会尽快为您安排发货。感谢您对易缆通的支持与信任。";
        #
        $put .= "&content=" . rawurlencode($str);
        return $this->sentMsnInfo($put);
    }

    /**
     * 下单通知6
     * @return type
     */
    private function sentOrdBank() {
        $put = "account=" . $this->account . "&password=" . $this->password . "&mobile=" . $this->data["phone"];
        #
        $str = "尊敬的" . $this->data["phone"] . "用户您好，您的订单选择了银行转款模式，请完成汇款操作后拍照或者截图上传凭证至软件完成订单成功付款操作。";
        #
        $put .= "&content=" . rawurlencode($str);
        return $this->sentMsnInfo($put);
    }

    /**
     * 物流通知1
     */
    private function sentTrans() {
        $put = "account=" . $this->account . "&password=" . $this->password . "&mobile=" . $this->data["phone"];
        #
        $str = "尊敬的用户您好，您购买的商品已发货，由" . $this->data["trans"] . "承运，为保证您尽快收到商品，请保持收货人电话畅通，谢谢。";
        #
        $put .= "&content=" . rawurlencode($str);
        return $this->sentMsnInfo($put);
    }

    /**
     * 收货通知5
     */
    private function saveTrans() {
        $put = "account=" . $this->account . "&password=" . $this->password . "&mobile=" . $this->data["phone"];
        #
        $str = "尊敬的用户，您的订单已完成，后续有任何使用问题请致电我司，我们将竭诚为您提供优质的售后服务或建议，欢迎您再次使用易缆通APP。";
        #
        $put .= "&content=" . rawurlencode($str);
        return $this->sentMsnInfo($put);
    }

    /**
     * 管理员下单通知2
     */
    private function sentMangOrd() {
        $put = "account=" . $this->account . "&password=" . $this->password . "&mobile=" . $this->data["phone"];
        #
        $str = "用户" . $this->data["phone_push"] . "新订单提交，订单号：" . $this->data["sn"] . "订单金额：" . $this->data["money"] . "请注意及时处理。";
        #
        $put .= "&content=" . rawurlencode($str);
        return $this->sentMsnInfo($put);
    }

    /**
     * 管理员分享通知3
     */
    private function sentMangTrs() {
        $put = "account=" . $this->account . "&password=" . $this->password . "&mobile=" . $this->data["phone"];
        #
        $str = "您有新的报价转发，转发人" . $this->data["trans"] . "，请注意观察！";
        #
        $put .= "&content=" . rawurlencode($str);
        return $this->sentMsnInfo($put);
    }

    /**
     * 管理员客户上传通知4
     */
    private function sentMangUps() {
        $put = "account=" . $this->account . "&password=" . $this->password . "&mobile=" . $this->data["phone"];
        #
        $str = "易缆通用户" . $this->data["phone"] . "已提交转账凭证，订单号：" . $this->data["sn"] . "订单金额：" . $this->data["money"] . "请注意及时处理。";
        #
        $put .= "&content=" . rawurlencode($str);
        return $this->sentMsnInfo($put);
    }

    /**
     * 发送验证码
     * @param type $code
     * @return boolean
     */
    private function sentSms($code) {
        $put = "account=" . $this->account . "&password=" . $this->password . "&mobile=" . $this->data["phone"];
        $put .= "&content=" . rawurlencode("您的验证码是：" . $code . "。请不要把验证码泄露给其他人。");
        return $this->sentMsnInfo($put);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 推送消息
     * @param type $put
     * @return boolean
     */
    private function sentMsnInfo($put) {
        $tmp = poCurl(self::smsUrl, $put);
        $res = xml_to_array($tmp);
        #
        $syslog = M("syslog");
        $syslog->name = "SMSRETURN";
        $syslog->send = $put;
        $syslog->back = $tmp;
        $syslog->times = date("Y-m-d H:i:s");
        $syslog->add();
        #
        if ($res['SubmitResult']['code'] == 2) {
            return true;
        }
        return false;
    }

}
