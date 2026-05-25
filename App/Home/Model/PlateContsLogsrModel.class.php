<?php

namespace Home\Model;

use Think\Model;

class PlateContsLogsrModel extends Model {

    protected $_validate = array(
        array('pid', 'require', '上级ID异常'),
        array('price', 'require', '请填写价格'),
    );
    protected $_auto = array(
        //array('market', 0),
        array('sorts', 'getSQLID', 1, 'callback'),
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

    protected function getSQLID() {
        $last = M("plate_conts_logsr")->query("SHOW TABLE STATUS LIKE 'plate_conts_logsr'");
        return $last[0]["auto_increment"];
    }

}
