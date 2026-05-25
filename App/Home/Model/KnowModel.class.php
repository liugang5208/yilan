<?php

namespace Home\Model;

use Think\Model;

class KnowModel extends Model {

    protected $_validate = array(
        array('catid', 'require', '请选择分类'),
        array('title', 'require', '请填写标题'),
        array('descr', 'require', '请填写概述'),
        array('context', 'require', '请填写内容'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
