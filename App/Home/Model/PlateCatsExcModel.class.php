<?php

namespace Home\Model;

use Think\Model;

class PlateCatsExcModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写分类名称'),
        array('name', '', '分类名称已经存在', 0, 'unique', 1),
        array('sort', 'require', '请填写排序'),
    );
    #
    protected $_auto = array(
        array('uptimes', 0),
        array('times', 'time', 1, 'function'),
    );

}
