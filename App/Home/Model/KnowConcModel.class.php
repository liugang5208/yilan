<?php

namespace Home\Model;

use Think\Model;

class KnowConcModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写模板名称'),
        array('use_group', 'require', '请填写使用人群'),
        array('file', 'checkImgs', '请上传文件', 1, 'callback', 1),
    );
    #
    protected $_auto = array(
        array('source', 'set_imgs', 3, 'callback'),
        array("status", 1),
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
            $tmp = uploadFile("contact");
            return $tmp["file"]["savename"];
        }
        $know_conc = M("know_conc");
        $where["id"] = I("post.ids");
        $info = $know_conc->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["source"];
    }

}
