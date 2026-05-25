<?php

namespace Inter\Model;

use Think\Model;

class UsersAddrModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写姓名'),
        array('phone', 'require', '请输入电话'),
        array('phone', 'verifyPhone', '手机号码格式不正确', 0, 'callback'),
        array('prov', 'require', '请选择省份'),
        array('city', 'require', '请填写城市'),
        array('label', 'require', '请填写地区'),
        array('street', 'require', '请输入街道'),
    );

    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

    /**
     * 手机监测
     * @param type $data
     * @return boolean
     */
    protected function verifyPhone($data) {
        if (!preg_match("/1[3,5,7,8,9][0-9]\d{8}$/", $data)) {
            return false;
        }
        return true;
    }

}
