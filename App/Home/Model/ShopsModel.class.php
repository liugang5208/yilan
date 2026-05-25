<?php

namespace Home\Model;

use Think\Model;

class ShopsModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写店铺名称'),
        array('name', '', '店铺名称已经存在', 0, 'unique', 1),
        array('qicq', 'require', '请填写QQ'),
        array('phone', 'require', '请填写电话'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
