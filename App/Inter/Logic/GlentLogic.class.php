<?php

namespace Inter\Logic;

/**
 * Description of GlentLogic
 * 高德距离
 * @author Administrator
 */
class GlentLogic {

    const uri = "https://restapi.amap.com/v3/direction/driving?origin=";

    public $param;

    public function runs($param) {
        $this->param = $param;
        return $this->lengthVar();
    }

    /**
     * 计算距离
     */
    private function lengthVar() {
        $url = self::uri . $this->param["from"];
        $url .= "&destination=" . $this->param["to"];
        $url .= "&key=" . C("GD_WEB");
        #
        $res = poCurl($url, $params);
        $data = json_decode($res, true);
        #
        return $data["route"]["paths"][0]["distance"];
    }

}
