<?php

namespace Inter\Controller;

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
        $post = $this->param;
        #
        if (!$db->create($post, 1)) {
            return get_op_put(0, $db->getError());
        }
        if (!$db->add()) {
            return get_op_put(0, "添加失败");
        }
        $urls = $this->urls[$model];
        return get_op_put(1, "添加成功", U($urls));
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 编辑
     * @param type $model
     */
    public function edits($model) {
        $db = D($model);
        $post = $this->param;
        #
        if (!$db->create($post, 2)) {
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
     * 编辑
     * @param type $model
     */
    public function change($model) {
        $db = D($model);
        $tmp = file_get_contents('php://input', true);
        $param = json_decode($tmp, true);
        #
        if (!$db->where("id='" . $param["ids"] . "'")->save($param)) {
            return get_op_put(0, "没有修改", $param);
        }
        #
        return get_op_put(1, "修改成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 删除
     * @return type
     */
    public function dels($model) {
        $db = D($model);
        $tmp = file_get_contents('php://input', true);
        $param = json_decode($tmp, true);
        #
        if (!$db->where($param)->delete()) {
            return get_op_put(0, "删除失败", $param);
        }
        #
        $urls = U($this->urls[$model]);
        return get_op_put(1, $post, $urls);
    }

}
