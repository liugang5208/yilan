<?php

namespace Home\Model;

use Think\Model;

class PlateCatsModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写分类名称'),
        array('name', '', '分类名称已经存在', 0, 'unique', 1),
        array('up', 'require', '请填写上调比率'),
        array('down', 'require', '请填写下降比率'),
        array('float_cat', 'require', '请选择浮动参考分类'),
    );
    #
    protected $_auto = array(
        array('uptimes', 0),
        array('times', 'time', 1, 'function'),
    );

}
