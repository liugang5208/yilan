<?php

namespace Inter\Model;

use Think\Model;

class BulksRecyleModel extends Model {

    protected $_validate = array(
        array('uid', 'require', '用户信息异常'),
        array('deal_type', 'require', '请选择处理类别'),
        //array('pro_type', 'require', '请填写产品型号'),
        //array('pro_nums', 'require', '请填写产品数量'),
        array('pro_money', 'require', '请填写出售预算'),
        //array('prize', 'require', '请填写所属品牌'),
        array('newold', 'require', '请输入新旧程度'),
        array('location', 'require', '请输入回收地点'),
        array('paytype', 'require', '请选择交易方式'),
        array('use_note', 'require', '请输入使用单位'),
        array('from_type', 'require', '请输入物资属性'),
        array('sale_user', 'require', '请输入出售人员'),
        array('contect', 'require', '请输入联系方式'),
        array('wechat', 'require', '请输入微信号码'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 0),
        array('times', 'time', 1, 'function'),
    );

}
