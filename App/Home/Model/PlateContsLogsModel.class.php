<?php

namespace Home\Model;

use Think\Model;

class PlateContsLogsModel extends Model {

    protected $_validate = array(
        array('pid', 'require', '上级ID异常'),
        array('file', 'checkFile', '请上传商品图片', 0, 'callback', 1),
        array('key_0', 'require', '请填写参数名称1'),
        array('value_0', 'require', '请填写参数名称1内容'),
        array('key_1', 'require', '请填写参数名称2'),
        array('value_1', 'require', '请填写参数名称2内容'),
        array('key_2', 'require', '请填写参数名称3'),
        array('value_2', 'require', '请填写参数名称3内容'),
        array('trans', 'require', '请填写发货时间'),
    );
    protected $_auto = array(
        array('source', 'getFile', 3, 'callback'),
        //array('price', 0),
        //array('market', 0),
        array('sorts', 'getSQLID', 1, 'callback'),
        array('ticket_nor', 0),
        array('ticket_person', 0),
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

    ////////////////////////////////////////////////////////////////////////////

    protected function checkFile() {
        return $_FILES["file"]["name"] == NULL ? false : true;
    }

    ////////////////////////////////////////////////////////////////////////////
    
    protected function getSQLID() {
        $last = M("plate_conts_logs")->query("SHOW TABLE STATUS LIKE 'plate_conts_logs'");
        return $last[0]["auto_increment"];
    }

    /**
     * 获取文件
     */
    protected function getFile() {
        if ($_FILES["file"]['name'] != null) {
            $tmp = uploadFile("goods");
            /////
            return $tmp["file"]["savename"];
        }
        #
        $plate_conts_logs = M("plate_conts_logs");
        #
        $where["id"] = I("post.ids");
        $info = $plate_conts_logs->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["source"];
    }

}
