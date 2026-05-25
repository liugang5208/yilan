<?php

namespace Home\Model;

use Think\Model;

class TransModel extends Model {

    protected $_validate = array(
        array('trans_type', 'require', '请选择发货类型'),
        array('name', 'require', '请填写物流公司名称'),
        array('name', '', '物流公司名称已经存在', 0, 'unique', 1),
        //array('base_prov', 'require', '请选择始发省份'),
        //array('base_city', 'require', '请选择始发城市'),
        //array('base_label', 'require', '请选择始发区域'),
        //array('line_prov', 'require', '请选择往返省份'),
        //array('line_city', 'require', '请选择往返城市'),
        //array('line_label', 'require', '请选择往返区域'),
        array('line_trans', 'require', '请填写专线往返'),
        array('line_keys', 'require', '请填写线路关键词'),
        array('agent_save', 'require', '请填写代收发送'),
        array('agent_phone', 'require', '请填写代收查询'),
        array('telephone', 'require', '请填写总部电话'),
        array('addr', 'require', '请填写公司地址'),
    );
    #
    protected $_auto = array(
        array('base_addr', 'getBaseAddr', 3, 'callback'),
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

    protected function getBaseAddr() {
        $trans_city = M("trans_city");
        $post = I("post.");
        #
        $where["id"] = $post["pid"];
        $info = $trans_city->where($where)->find();
        return $info["name"];
    }

}
