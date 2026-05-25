<?php

namespace Home\Controller;

use Think\Controller;

class CommController extends Controller {

    public function _initialize() {
        $ssid = session("yilans_ssid");
        if ($ssid == NULL) {
            return $this->redirect("Index/index");
        }
    }

    public function region() {
        $sysregion = M("sysregion");
        $post = I("post.");
        #
        $where["parent"] = $post["pid"] == NULL ? 1 : $post["pid"];
        $list = $sysregion->where($where)->select();
        #
        return get_op_put(1, NULL, $list);
    }

    /**
     * 获取地址信息
     */
    public function getAddr() {
        $url = "https://restapi.amap.com/v3/geocode/regeo?key=" . C("GD_CONF")["WEBSR"];
        $post = I("post.");
        #
        $url .= "&location=" . $post["lng"] . "," . $post["lat"];
        $res = poCurl($url, NULL);
        $data = json_decode($res, true);
        #
        if ($data["status"] != 1) {
            return get_op_put(0, "地址读取失败", $data);
        }
        $reback = [
            "full" => $data["regeocode"]["formatted_address"],
            "lng" => $post["lng"],
            "lat" => $post["lat"]
        ];
        return get_op_put(1, "地址读取成功", $reback);
    }
    
     public function upload() {
        $post = I("post.");
        #
        $file = uploadFile("group");
        if (!$file) {
            return get_op_put(0, "文件上传失败");
        }
        $data['url'] = $file['file']['savename'];
        $data['path_url'] = C("WEBIMG") . "group/" .$file['file']['savename'];
        return get_op_put(1, "成功", $data);
    }

}
