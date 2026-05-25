<?php

namespace Inter\Model;

use Think\Model;

class UsersModel extends Model {

    protected $_validate = array(
        //array('prov', 'checkData', '请选择省份', 0, 'callback'),
        //array('city', 'checkData', '请填写城市', 0, 'callback'),
        //array('label', 'checkData', '请填写地区', 0, 'callback'),
        //array('nickname', 'require', '请输入用户名称'),
        array('phone', 'require', '请输入手机号码'),
        array('phone', 'verifyPhone', '手机号码格式不正确', 0, 'callback'),
        array('phone', '', '手机号码已经存在', 0, 'unique', 1),
            //array('passwd', 'require', '请输入登录密码'),
    );
    #
    protected $_auto = array(
        array('passwd', 'md5', 3, 'function'),
        array('ac_level', 1),
        array('status', 1),
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
        if ($data == null || $data == "" || $data == 0) {
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
