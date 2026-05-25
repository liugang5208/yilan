<?php

namespace Inter\Model;

use Think\Model;

class UsersTicketModel extends Model {

    public $param;

    public function __construct() {
        parent::__construct();
        $param = I("request.");
        if (count($param) <= 0) {
            $tmp = file_get_contents('php://input', true);
            $param = json_decode($tmp, true);
        }
        #
        $this->param = $param;
    }

    protected $_validate = array(
        array('tex_type', 'require', '请选择纳税类别'),
        array('ticket_type', 'require', '请选择发票类型'),
        array('comp_name', 'require', '请填写公司名称'),
        array('comp_tex', 'require', '请输入信用代码'),
        array('comp_addr', 'require', '请填写公司地址'),
        array('comp_tele', 'require', '请输入联系电话'),
        array('comp_bank', 'require', '请输入开户银行'),
        array('bank_id', 'require', '请输入银行账户'),
        //array('bank_sn', 'require', '请输入开户行号'),
        //array('pic_id', 'require', '请上传营业执照图片',),
        //array('pic_bank', 'require', '请上传企业开户许可证',),
    );
#
    protected $_auto = array(
        //array('pic_id', 'pic_imgs', 3, 'callback'),
        //array('pic_bank', 'pic_bank_imgs', 3, 'callback'),
        array('status', 1),
        array('uptimes', 'time', 3, 'function'),
        array('times', 'time', 1, 'function'),
    );

    /**
     * 设置图片
     */
    protected function pic_imgs() {
        $data = $this->param["pic_id"];
        if ($data != null) {
            $file = saveImageToFile("ID", $data, "ticket");
            return $file;
        }
        $users_ticket = D("users_ticket");
        #
        $where["id"] = $this->param["ids"];
        $info = $users_ticket->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["pic_id"];
    }

    /**
     * 设置图片
     */
    protected function pic_bank_imgs() {
        $data = $this->param["pic_bank"];
        if ($data != null) {
            $file = saveImageToFile("BA", $data, "ticket");
            return $file;
        }
        $users_ticket = D("users_ticket");
        #
        $where["id"] = $this->param["ids"];
        $info = $users_ticket->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["pic_bank"];
    }

}
