<?php

namespace Home\Controller;

#use Think\Controller;

class CoreController extends CommController {

    private $urls = array();

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 添加
     * @param type $model
     */
    public function addon($model) {
        $db = D($model);
        $sysconfig = M("sysconfig");
        #
        if (!$db->create(I("post."), 1)) {
            return get_op_put(0, $db->getError());
        }
        if (!$db->add()) {
            return get_op_put(0, "添加失败");
        }
        if ($model == "sys_banner") {
            $sysconfig->where(["id" => 4])->save(["valuc" => array("exp", "valuc+1")]);
        }
        #
        return get_op_put(1, "添加成功");
    }

    /**
     * 添加
     * @param type $model
     */
    public function addon_check($model) {
        $db = D($model);
        #
        $data = $db->create(I("post."), 1);
        if (!$data) {
            return get_op_put(0, $db->getError());
        }
        return get_op_put(1, "核验成功", $data);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 更新排序
     */
    public function uptypes() {
        $plate_types = M("plate_types");
        $post = I("post.");
        #
        $pre = $plate_types->find($post["id"]);
        $where["types"] = $pre["types"];
        $where["types_id"] = $pre["types_id"];
        $where["sorts"] = $post["redi"] > 0 ? array("gt", $pre["sorts"]) : array("lt", $pre["sorts"]);
        $sorts = $post["redi"] > 0 ? "sorts asc" : "sorts desc";
        #
        $after = $plate_types->where($where)->order($sorts)->find();
        if ($after == NULL) {
            return get_op_put(0, "您的后面已经没有可排序的了，无需重复排序");
        }
        #
        if (!$plate_types->where(["id" => $pre["id"]])->save(["sorts" => $after["sorts"]])) {
            return get_op_put(0, "排序失败[0XR]");
        }
        if (!$plate_types->where(["id" => $after["id"]])->save(["sorts" => $pre["sorts"]])) {
            return get_op_put(0, "排序失败[0X2]");
        }
        return get_op_put(1, "处理完成");
    }

    /**
     * 更新排序
     */
    public function upplate() {
        $db = M("plate");
        $post = I("post.");
        #
        $pre = $db->find($post["id"]);
        $where["sorts"] = $post["redi"] > 0 ? array("gt", $pre["sorts"]) : array("lt", $pre["sorts"]);
        $sorts = $post["redi"] > 0 ? "sorts asc" : "sorts desc";
        #
        $where["pid"] = $pre["pid"];
        $after = $db->where($where)->order($sorts)->find();
        if ($after == NULL) {
            return get_op_put(0, "您的后面已经没有可排序的了，无需重复排序");
        }
        #
        if (!$db->where(["id" => $pre["id"]])->save(["sorts" => $after["sorts"]])) {
            return get_op_put(0, "排序失败[0XR]");
        }
        if (!$db->where(["id" => $after["id"]])->save(["sorts" => $pre["sorts"]])) {
            return get_op_put(0, "排序失败[0X2]");
        }
        return get_op_put(1, "处理完成");
    }

    /**
     * 更新排序
     */
    public function upconts() {
        $db = M("plate_conts");
        $post = I("post.");
        #
        $pre = $db->where(["id" => $post["id"]])->find();
        $where["sorts"] = $post["redi"] > 0 ? array("gt", $pre["sorts"]) : array("lt", $pre["sorts"]);
        $sorts = $post["redi"] > 0 ? "sorts asc" : "sorts desc";
        #
        $where["pid"] = $pre["pid"];
        $after = $db->where($where)->order($sorts)->find();
        if ($after == NULL) {
            return get_op_put(0, "您的后面已经没有可排序的了，无需重复排序");
        }
        #
        if (!$db->where(["id" => $pre["id"]])->save(["sorts" => $after["sorts"]])) {
            return get_op_put(0, "排序失败[0XR]");
        }
        if (!$db->where(["id" => $after["id"]])->save(["sorts" => $pre["sorts"]])) {
            return get_op_put(0, "排序失败[0X2]");
        }
        return get_op_put(1, "处理完成", $after);
    }

    /**
     * 更新排序
     */
    public function uplogs() {
        $plate_conts_logs = M("plate_conts_logs");
        $post = I("post.");
        #
        $pre = $plate_conts_logs->find($post["id"]);
        $where["pid"] = $pre["pid"];
        $where["cat_index"] = $pre["cat_index"];
        $where["sorts"] = $post["redi"] > 0 ? array("gt", $pre["sorts"]) : array("lt", $pre["sorts"]);
        $sorts = $post["redi"] > 0 ? "sorts asc" : "sorts desc";
        #
        $after = $plate_conts_logs->where($where)->order($sorts)->find();
        if ($after == NULL) {
            return get_op_put(0, "您的后面已经没有可排序的了，无需重复排序");
        }
        #
        if (!$plate_conts_logs->where(["id" => $pre["id"]])->save(["sorts" => $after["sorts"]])) {
            return get_op_put(0, "排序失败[0XR]");
        }
        if (!$plate_conts_logs->where(["id" => $after["id"]])->save(["sorts" => $pre["sorts"]])) {
            return get_op_put(0, "排序失败[0X2]");
        }
        return get_op_put(1, "处理完成");
    }

    /**
     * 更新排序
     */
    public function uplogr() {
        $plate_conts_logsr = M("plate_conts_logsr");
        $post = I("post.");
        #
        $pre = $plate_conts_logsr->find($post["id"]);
        $where["pid"] = $pre["pid"];
        $where["sorts"] = $post["redi"] > 0 ? array("gt", $pre["sorts"]) : array("lt", $pre["sorts"]);
        $sorts = $post["redi"] > 0 ? "sorts asc" : "sorts desc";
        #
        $after = $plate_conts_logsr->where($where)->order($sorts)->find();
        if ($after == NULL) {
            return get_op_put(0, "您的后面已经没有可排序的了，无需重复排序");
        }
        #
        if (!$plate_conts_logsr->where(["id" => $pre["id"]])->save(["sorts" => $after["sorts"]])) {
            return get_op_put(0, "排序失败[0XR]");
        }
        if (!$plate_conts_logsr->where(["id" => $after["id"]])->save(["sorts" => $pre["sorts"]])) {
            return get_op_put(0, "排序失败[0X2]");
        }
        return get_op_put(1, "处理完成");
    }

    /**
     * 编辑
     * @param type $model
     */
    public function edits($model) {
        $db = D($model);
        #
        if (!$db->create(I("post."), 2)) {
            return get_op_put(0, $db->getError());
        }
        if (!$db->where("id='" . I("post.ids") . "'")->save()) {
            return get_op_put(0, "没有修改");
        }
        #
        $urls = $this->urls[$model];
        return get_op_put(1, "修改成功", U($urls));
    }

    /**
     * 变更状态
     */
    public function change($model) {
        $db = M($model);
        $post = I("post.");
        #
        $where["id"] = $post["ids"];
        $db->startTrans();
        if (!$db->where($where)->save($post)) {
            $db->rollback();
            return get_op_put(0, "没有修改");
        }
        #
        $db->commit();
        return get_op_put(1, "添加成功", 1);
    }

    /**
     * 更新列表
     */
    public function upList($model) {
        $db = D($model);
        $post = I("post.");
        #
        $list = json_decode(htmlspecialchars_decode($post["logs"]), true);
        foreach ($list as $k => $v) {
            $where["id"] = $v["id"];
            unset($v["id"]);
            $v["uptimes"] = time();
            $save = $v;
            if (!$db->where($where)->save($save)) {
                return get_op_put(0, "没有修改");
            }
        }
        return get_op_put(1, "修改成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 删除
     * @return type
     */
    public function dels($model) {
        $db = D($model);
        $sysconfig = M("sysconfig");
        $post = I("post.");
        #
        if (!$db->where($post)->delete()) {
            return get_op_put(0, "删除失败");
        }
        #
        if ($model == "sys_banner") {
            $sysconfig->where(["id" => 4])->save(["valuc" => array("exp", "valuc+1")]);
        }
        #
        return get_op_put(1, $post, $urls);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 信息
     * @param type $model
     */
    public function infos($model) {
        $db = D($model);
        $post = I("post.");
        #
        $where["id"] = $post["ids"];
        $info = $db->where($where)->find();
        if ($model == "sys_help") {
            $info["context"] = htmlspecialchars_decode($info["context"]);
        }
        #
        return get_op_put(1, "获取成功", $info);
    }

}
