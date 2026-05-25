<?php

namespace Home\Model;

use Think\Model;

class ShopsLogsModel extends Model {

    protected $_validate = array(
        array('loc_type', 'require', '请选择元素位置'),
        array('file', 'checkFile', '请上传图片', 1, 'callback', 1),
        array('source_box', 'checkBoxs', '请选择方块组行数', 1, 'callback', 1),
        array('source_type', 'checkType', '请选择绑定数据类型', 1, 'callback', 1),
            //array('source_id', 'checkID', '请选择数据', 1, 'callback', 1),
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

    protected function checkBoxs($data) {
        $post = I("post.");
        if ($post["loc_type"] != "3") {
            return true;
        }
        return $data == null || $data == "" ? false : true;
    }

    protected function checkType($data) {
        return $data == null || $data == "" ? false : true;
    }

    protected function checkID($data) {
        return $data == null || $data == "" ? false : true;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 获取文件
     */
    protected function getFile() {
        $post = I("post.");
        #
        if ($post["loc_type"] == "1") {
            $file = uploadFile("banner");
        }
        if ($post["loc_type"] == "2") {
            $file = uploadFile("ads");
        }
        if ($post["loc_type"] == "3") {
            $file = uploadFile("group");
        }
        /////////////////////////////////
        return $file["file"]["savename"];
    }

}
