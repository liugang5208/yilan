<?php

namespace Home\Model;

use Think\Model;

class KnowCatModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写分类名称'),
        array('name', '', '分类名称已经存在', 0, 'unique', 1),
    );
    #
    protected $_auto = array(
        array('pid', 0),
        array('uptimes', 0),
        array('times', 'time', 1, 'function'),
    );

}
