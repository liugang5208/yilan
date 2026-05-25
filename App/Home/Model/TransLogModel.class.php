<?php

namespace Home\Model;

use Think\Model;

class TransLogModel extends Model {

    protected $_validate = array(
        array('from_type', 'require', '请选择发货类型'),
        array('name', 'require', '请填写站点名称'),
        array('name', '', '站点名称已经存在', 0, 'unique', 1),
        array('phone', 'require', '请填写总部电话'),
        array('site_addr', 'require', '请填写公司地址'),
        array('lng', 'require', '请选择地址经纬度'),
        array('lat', 'require', '请选择地址经纬度'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
