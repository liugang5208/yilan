<?php

namespace Home\Model;

use Think\Model;

class UsersLabelModel extends Model {

    protected $_validate = array(
        array('prov', 'require', '请选择省份'),
        array('city', 'require', '请选择城市'),
        array('label', 'require', '请选择区域'),
    );
    #
    protected $_auto = array(
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
