<?php

namespace Home\Logic;

/**
 * Description of CatioLogic
 * 更新分类数据
 * @author admins
 */
class CatioLogic {

    private $param;
    private $cats;
    private $blank;

    /**
     * 入口
     */
    public function runs($param) {
        $this->param = $param;
        #
        return $this->getInf();
    }

    /**
     * 获取板块信息
     */
    private function getInf() {
        $plate_cats = M("plate_cats");
        $plate_conts = M("plate_conts");
        $plate_conts_blank = M("plate_conts_blank");
        #
        $where["id"] = $this->param["ids"];
        $info = $plate_cats->where($where)->find();
        if ($info == NULL) {
            return get_op_res(0, "分类信息不存在");
        }
        $this->cats = $info;
        #
        $cond["catid"] = $info["id"];
        $list = $plate_conts->where($cond)->select();
        $idArr = i_array_column($list, "id");
        #
        $mode["pid"] = array("in", implode(",", $idArr));
        $blank = $plate_conts_blank->where($mode)->select();
        if (count($list) < 1) {
            return $this->edits();
        }
        $this->blank = $blank;
        #
        return $this->upsetPrice();
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 更新价格
     */
    private function upsetPrice() {
        $plate_conts_logs = M();
        $plate_cats = M("plate_cats");
        $post = $this->param;
        #
        $plate_cats->startTrans();
        foreach ($this->blank as $k => $v) {
            #$temp = $v["up_a"] - $v["down_a"] + $v["up_b"] - $v["down_b"] + $v["up_c"] - $v["down_c"] + $v["up_d"] - $v["down_d"] + $v["up_e"] - $v["down_e"] + $v["up_f"] - $v["down_f"];
            #$nums = 1 + (($temp + $this->param["up"] - $this->param["down"]) / 100);
            #$nums = setRatio($v, $this->param);
            #
            $pre = "select id from plate_conts_logs where pid=" . $v['pid'] . " and cat_index=" . $v['cat_index'];
            $sql = "select count(*) as child from plate_conts_logsr where pid in (" . $pre . ")";
            $cData = $plate_conts_logs->query($sql);
            #
            $catRatio = setCatRatio($this->param);
            $blankRatio = setBlankRatio($v);
            $cex = "(price*dratio*" . $catRatio . "-(price*dratio)+price)*" . $blankRatio;
            #
            $sql2 = "update plate_conts_logs set market=round(" . $cex . ",2) where pid=" . $v['pid'] . " and cat_index=" . $v['cat_index'];
            $plate_conts_logs->execute($sql2);
            #
            if ($cData[0]["child"] > 0) {
                $sql3 = "update plate_conts_logsr set market=round(" . $cex . ",2) where pid in (" . $pre . ")";
                $plate_conts_logs->execute($sql3);
            }
        }
        #
        if (!$plate_cats->create($post, 2)) {
            $plate_cats->rollback();
            return get_op_res(0, $plate_cats->getError());
        }
        $plate_cats->uptimes = time();
        if (!$plate_cats->where("id='" . $post["ids"] . "'")->save()) {
            $plate_cats->rollback();
            return get_op_res(0, "没有修改");
        }
        $plate_cats->commit();
        #
        return get_op_res(1, "修改成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 编辑
     * @param type $model
     */
    private function edits() {
        $plate_cats = M("plate_cats");
        $post = $this->param;
        #
        if (!$plate_cats->create($post, 2)) {
            return get_op_res(0, $plate_cats->getError());
        }
        if (!$plate_cats->where("id='" . $post["ids"] . "'")->save()) {
            return get_op_res(0, "没有修改");
        }
        #
        return get_op_res(1, "修改成功");
    }

}
