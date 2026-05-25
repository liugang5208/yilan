<?php

namespace Home\Model;

use Think\Model;

class PlateBannerModel extends Model {

    protected $_validate = array(
        array('pid', 'require', '上级ID异常'),
        array('name', 'require', '请填写轮播广告名称'),
        array('file', 'checkFile', '请上传图片', 1, 'callback', 1),
        array('sorts', 'require', '请填写排序'),
    );
    protected $_auto = array(
        array('source', 'getFile', 3, 'callback'),
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
        $plate_banner = M("plate_banner");
        #
        $where["id"] = I("post.ids");
        $info = $plate_banner->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["source"];
    }

}
