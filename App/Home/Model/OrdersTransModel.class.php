<?php

namespace Home\Model;

use Think\Model;

class OrdersTransModel extends Model {

    protected $_validate = array(
        array('label', 'require', '请填写到货区域'),
        array('trans', 'require', '请填写承运物流'),
        array('trans_sn', 'require', '请填写物流单号'),
        array('trade_sn', 'require', '请填写货物编号'),
        array('save_name', 'require', '请填写收货人员'),
        array('save_phone', 'require', '请填写收货电话'),
        array('agent_money', 'require', '请填写代收货款'),
        array('trans_fee', 'require', '请填写物流运费'),
        array('trans_phone', 'require', '请填写物流电话'),
        array('get_addr', 'require', '请填写取货地址'),
    );
    #
    protected $_auto = array(
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
