<?php

namespace Inter\Model;

use Think\Model;

class BulksBuyerModel extends Model {

    protected $_validate = array(
        array('uid', 'require', '用户信息异常'),
        array('buy_type', 'require', '请选择采购类别'),
        array('make_lince', 'require', '请选择质量标准'),
        array('tex', 'require', '请选择是否含税'),
        array('paytype', 'require', '请选择付款方式'),
        array('use_addr', 'require', '请输入使用地点'),
        //array('project_name', 'require', '请输入项目名称'),
        array('buy_mode', 'require', '请选择采购模式'),
        //array('prize', 'require', '请输入品牌要求'),
        array('money', 'require', '请输入采购预算'),
        array('comp', 'require', '请输入单位名称'),
        array('comp_user', 'require', '请输入联系人员'),
        array('comp_phone', 'require', '请输入手机号码'),
        array('comp_qq', 'require', '请输入QQ号码'),
        array('comp_mail', 'require', '请输入电子邮箱'),
        array('comp_accept', 'require', '请选择接受方式'),
        array('comp_tags', 'require', '请输入采购备注'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 0),
        array('times', 'time', 1, 'function'),
    );

}
