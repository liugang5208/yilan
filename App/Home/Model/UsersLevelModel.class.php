<?php

namespace Home\Model;

use Think\Model;

class UsersLevelModel extends Model {

    protected $_validate = array(
        array('level', 'require', '请填写名称'),
        array('ratio', 'require', '请填写比率'),
    );
    #
    protected $_auto = array(
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
