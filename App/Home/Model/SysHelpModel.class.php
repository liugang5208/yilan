<?php

namespace Home\Model;

use Think\Model;

class SysHelpModel extends Model {

    protected $_validate = array(
        array('title', 'require', '请填写帮助名称'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
