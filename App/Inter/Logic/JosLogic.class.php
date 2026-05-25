<?php

namespace Inter\Logic;

/**
 * Description of JosLogic
 * 京东SDK
 * @author Administrator
 */
class JosLogic {

    const AppKey = "f2df4af37ab65ed9e9bc7f43200ebb21";
    const AppSecret = "d3969badb73b4f4db9a71745682b187c";
    const uri = "https://api.jd.com/routerjson?";

    private $skid;
    private $puts;

    public function runs($skid) {
        $this->skid = $skid;
        return $this->setParam();
    }

    /**
     * 创建请求参数
     */
    private function setParam() {
        $this->puts["method"] = "jd.union.open.goods.promotiongoodsinfo.query";
        $this->puts["app_key"] = self::AppKey;
        $this->puts["access_token"] = "";
        $this->puts["timestamp"] = date("Y-m-d H:i:s");
        $this->puts["format"] = "json";
        $this->puts["v"] = "1.0";
        $this->puts["sign_method"] = "md5";
        $this->puts["360buy_param_json"] = "{'skuIds':'" . $this->skid . "'}";
        $this->puts["sign"] = $this->generSign($this->puts);
#
        return $this->conUrlsign();
    }

    /**
     * 组合请求参数
     */
    private function conUrlsign() {
        foreach ($this->puts as $k => $v) {
            $pre_url[] = $k . "=" . $v;
        }
        #
        $url = self::uri . implode("&", $pre_url);
        dump($url);
    }

////////////////////////////////////////////////////////////////////////////

    /**
     * 签名
     * @param type $params
     * @return type
     */
    private function generSign($params) {
        ksort($params);
        $stringToBeSigned = self::AppSecret;
        foreach ($params as $k => $v) {
            $stringToBeSigned .= $k . $v;
        }
        $stringToBeSigned .= self::AppSecret;
        return strtoupper(md5($stringToBeSigned));
    }

}
