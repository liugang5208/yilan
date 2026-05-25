<?php

namespace Home\Model;

use Think\Model;

class PlateContsImgsModel extends Model {

    protected $_validate = array(
        array('pid', 'require', '上级ID异常'),
        array('file', 'checkFile', '请上传展位图', 1, 'callback', 1),
    );
    protected $_auto = array(
        array('source', 'getFile', 3, 'callback'),
    );

    ////////////////////////////////////////////////////////////////////////////

    protected function checkFile() {
        return $_FILES["source"]["name"] == NULL ? false : true;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 获取文件
     */
    protected function getFile() {
        if ($_FILES["source"]['name'] != null) {
            $tmp = uploadFile("group");
            /////
            return $tmp["source"]["savename"];
        }
        #
        $plate_conts_imgs = M("plate_conts_imgs");
        #
        $where["id"] = I("post.ids");
        $info = $plate_conts_imgs->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["source"];
    }

}
