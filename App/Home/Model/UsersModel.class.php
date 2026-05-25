<?php

namespace Home\Model;

use Think\Model;

class UsersModel extends Model {

    protected $_validate = array(
        array('ac_level', 'checkData', '请选择账户权限级别', 0, 'callback'),
        array('ac_credit', 'checkData', '选择是否签约商户', 0, 'callback'),
        array('phone', 'require', '请输入手机号码'),
        array('phone', 'verifyPhone', '手机号码格式不正确', 0, 'callback'),
        array('phone', '', '手机号码已经存在', 0, 'unique', 1),
        array('passwd', 'require', '请输入登录密码'),
    );
    #
    protected $_auto = array(
        array('passwd', 'md5', 1, 'function'),
        array('uptimes', 0),
        array('times', 'time', 1, 'function'),
    );

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 手机监测
     * @param type $data
     * @return boolean
     */
    protected function checkData($data) {
        if ($data == null || $data == "") {
            return false;
        }
        return true;
    }

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
