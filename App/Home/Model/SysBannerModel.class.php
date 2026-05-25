<?php

namespace Home\Model;

use Think\Model;

class SysBannerModel extends Model {

    protected $_validate = array(
        array('file', 'checkFile', '请上传图片', 1, 'callback', 1),
        array('target_url', 'require', '请填写关联链接'),
    );
    protected $_auto = array(
        array('imgurl', 'getFile', 3, 'callback'),
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

    ////////////////////////////////////////////////////////////////////////////

    protected function checkFile() {
        return $_FILES["file"]["name"] == NULL ? false : true;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 获取文件
     */
    protected function getFile() {
        if ($_FILES["file"]['name'] != null) {
            $tmp = uploadFile("ads");
            return $tmp["file"]["savename"];
        }
        #
        $sys_banner = M("sys_banner");
        #
        $where["id"] = I("post.ids");
        $info = $sys_banner->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["imgurl"];
    }

}
