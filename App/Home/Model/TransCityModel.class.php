<?php

namespace Home\Model;

use Think\Model;

class TransCityModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写城市名称'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
