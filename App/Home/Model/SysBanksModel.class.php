<?php

namespace Home\Model;

use Think\Model;

class SysBanksModel extends Model {

    protected $_validate = array(
        array('bank', 'require', '请填写银行名称'),
        array('bank_name', 'require', '请填写银行全称'),
        array('bank_tag', 'require', '请填写银行标记'),
        array('name', 'require', '请填写开户名'),
        array('cardid', 'require', '请填写银行卡号'),
        array('open_bank', 'require', '请填写开户行'),
        array('open_bank_id', 'require', '请填写开户行号'),
    );
    #
    protected $_auto = array(
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

}
