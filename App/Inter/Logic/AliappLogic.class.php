<?php

namespace Inter\Logic;

/**
 * Description of AliappLogic
 * 支付宝-APP支付
 * @author Administrator
 */
class AliappLogic {

    const baseUrl = "./././Public/certs/alipay/";

    private $param;

    /**
     * 入口
     */
    public function runs($param) {
        $this->param = $param;
        return $this->setBizContent();
    }

    /**
     * 设置参数
     */
    private function setBizContent() {
        //$content = "{" . "\"total_amount\":\"0.01\",";
        $content = "{" . "\"total_amount\":\"" . $this->param["money"] . "\",";
        #
        $content .= "\"subject\":\"" . $this->param["sn"] . "\",";
        $content .= "\"out_trade_no\":\"" . $this->param["sn"] . "\",";
        $content .= "}";
        #
        return $this->createData($content);
    }

    /**
     * 创建支付数据
     */
    private function createData($content) {
        vendor("aliop.AopClient");
        vendor("aliop.request.AlipayTradeAppPayRequest");
        #
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = C("ALI_CONFIG")["APPID"];
        $aop->rsaPrivateKey = file_get_contents(self::baseUrl . "elccc.cn_pri.txt");
        $aop->alipayrsaPublicKey = file_get_contents(self::baseUrl . "elccc.elccc.cn_pub.txt");
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset = 'GBK';
        $aop->format = 'json';
        $request = new \AlipayTradeAppPayRequest();
        $request->setNotifyUrl($this->param["notify_url"]);
        $request->setBizContent($content);
        #
        $result = $aop->sdkExecute($request);
        return $result;
        /**
          $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
          $resultCode = $result->$responseNode->code;
          if (!empty($resultCode) && $resultCode == 10000) {
          return $result;
          }
          return false;
         * 
         */
    }

}
