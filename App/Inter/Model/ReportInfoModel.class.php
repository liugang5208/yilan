<?php

namespace Inter\Model;

use Think\Model;

class ReportInfoModel extends Model {

    protected $_validate = array(
        array('uid', 'require', '用户信息异常'),
        array('check_type', 'require', '请选择付款方式'),
        array('trans_type', 'require', '请选择运输方式'),
        array('fees_out', 'require', '请选择运费费用'),
        array('pack_recyle', 'require', '请选择包装选项'),
        //array('rep_user', 'require', '请输入报价人员'),
    );
    #
    protected $_auto = array(
        array('sn', 'getSn', 1, 'callback'),
        array('status', 1),
        array('uptimes', 0),
        array('times', 'time', 1, 'function'),
    );

    protected function getSn() {
        $arr = [
            "A", "B", "C", "D", "E", "F", "G", "H",
            "I", "J", "K", "L", "M", "N", "O", "P",
            "Q", "R", "S", "T", "U", "V", "W", "X",
            "Y", "Z",
        ];
        $pre = "RP" . $arr[mt_rand(0, 25)] . $arr[mt_rand(0, 25)];
        $number = mt_rand(10, 99) . time() . mt_rand(0, 9);
        #
        return $pre . $number;
    }

}
