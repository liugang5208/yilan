<?php

namespace Home\Model;

use Think\Model;

class SysVersionModel extends Model {

    protected $_validate = array(
        array('version', 'require', '请填写版本号'),
        array('file', 'checkImgs', '请上传文件', 1, 'callback', 1),
    );
    #
    protected $_auto = array(
        array('apk', 'set_imgs', 3, 'callback'),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

    /**
     * 检测图片
     * @return type
     */
    protected function checkImgs() {
        if ($_FILES["file"]["name"] == null) {
            return false;
        }
        return true;
    }

    /**
     * 设置图片
     */
    protected function set_imgs() {
        if ($_FILES["file"]['name'] != null) {
            $tmp = uploadFile("ads");
            return $tmp["file"]["savename"];
        }
        $sys_version = M("sys_version");
        $where["id"] = I("post.ids");
        $info = $sys_version->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["apk"];
    }

}
