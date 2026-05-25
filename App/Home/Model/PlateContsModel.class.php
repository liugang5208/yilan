<?php

namespace Home\Model;

use Think\Model;

class PlateContsModel extends Model {

    private $file;
    protected $_validate = array(
        //array('catid', 'checkID', '请选择商品分类', 1, 'callback', 3),
        array('pid', 'require', '上级ID异常'),
        array('name', 'require', '请填写广告名称'),
        array('file', 'checkFile', '请上传显示图', 1, 'callback', 1),
        array('search', 'checkSearch', '请上传搜索图', 1, 'callback', 1),
        array('sorts', 'require', '请填写排序'),
        array('g_unit', 'require', '请填写商品单位'),
        array('g_keys', 'require', '请填写商品关键词'),
        array('g_name', 'require', '请填写商品名称'),
        array('g_qq', 'require', '请填写QQ'),
        array('g_phone', 'require', '请填写电话'),
    );
    protected $_auto = array(
        array('source', 'getFile', 3, 'callback'),
        array('source_display', 'getSFile', 3, 'callback'),
        array('sorts', 'getSQLID', 1, 'callback'),
        array('status', 1),
        array('uptimes', 'time', 1, 'function'),
        array('uptimes', 'setPrice', 2, 'callback'),
        array('times', 'time', 1, 'function'),
    );

    ////////////////////////////////////////////////////////////////////////////

    protected function checkID($data) {
        return $data == "0" || $data == 0 ? false : true;
    }

    protected function checkFile() {
        return $_FILES["file"]["name"] == NULL ? false : true;
    }

    protected function checkSearch() {
        return $_FILES["search"]["name"] == NULL ? false : true;
    }

    ////////////////////////////////////////////////////////////////////////////

    protected function getSQLID() {
        $last = M("plate_conts")->query("SHOW TABLE STATUS LIKE 'plate_conts'");
        return $last[0]["auto_increment"];
    }

    /**
     * 获取文件
     */
    protected function getFile() {
        if ($_FILES["file"]['name'] != null) {
            $tmp = uploadFile("ads");
            $this->file = $tmp;
            /////
            return $tmp["file"]["savename"];
        }
        if ($_FILES["search"]['name'] != null) {
            $tmp = uploadFile("ads");
            $this->file = $tmp;
        }
        #
        $plate_conts = M("plate_conts");
        #
        $where["id"] = I("post.ids");
        $info = $plate_conts->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["source"];
    }

    /**
     * 获取搜索文件
     */
    protected function getSFile() {
        if ($this->file["search"]['name'] != null) {
            return $this->file["search"]["savename"];
        }
        #
        $plate_conts = M("plate_conts");
        #
        $where["id"] = I("post.ids");
        $info = $plate_conts->where($where)->find();
        if ($info == null) {
            return 0;
        }
        return $info["source_display"];
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 设置价格
     */
    protected function setPrice() {
        $plate_conts = M("plate_conts");
        $plate_cats = M("plate_cats");
        $plate_conts_logs = M();
        $p = I("post.");
        #
        $where["id"] = $p["ids"];
        $v = $plate_conts->where($where)->find();
        $cats = $plate_cats->where(["id" => $p["catid"]])->find();
        #
        if ($v == null) {
            return time();
        }
        #$temp = $v["up_a"] - $v["down_a"] + $v["up_b"] - $v["down_b"] + $v["up_c"] - $v["down_c"] + $v["up_d"] - $v["down_d"] + $v["up_e"] - $v["down_e"] + $v["up_f"] - $v["down_f"];
        #$nums = 1 + (($temp + $cats["up"] - $cats["down"]) / 100);
        $nums = setRatio($v, $cats);
        #
        $pre = "select id from plate_conts_logs where pid=" . $v['id'];
        $sql = "select count(*) as child from plate_conts_logsr where pid in (" . $pre . ")";
        $cData = $plate_conts_logs->query($sql);
        #
        $sql2 = "update plate_conts_logs set market=round(price*" . $nums . ",2) where pid=" . $v['id'];
        $plate_conts_logs->execute($sql2);
        #
        if ($cData[0]["child"] > 0) {
            $sql3 = "update plate_conts_logsr set market=round(price*" . $nums . ",2) where pid in (" . $pre . ")";
            $plate_conts_logs->execute($sql3);
        }
        return time();
    }

}
