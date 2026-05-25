<?php

namespace Home\Model;

use Think\Model;

class PlateTypesModel extends Model {

    protected $_validate = array(
        array('name', 'require', '请填写分类名称'),
        array('name', '', '分类名称已经存在', 0, 'unique', 1),
    );
    #
    protected $_auto = array(
        array('sorts', 'getSQLID', 1, 'callback'),
        array('uptimes', 0),
        array('times', 'time', 1, 'function'),
    );
    
    protected function getSQLID() {
        $last = M("plate_types")->query("SHOW TABLE STATUS LIKE 'plate_types'");
        return $last[0]["auto_increment"];
    }

}
