<?php

namespace Home\Model;

use Think\Model;

class NewLabelModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写标题'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('up_time', 'time', 3, 'function'),
        array('add_time', 'time', 1, 'function'),
    );

}
