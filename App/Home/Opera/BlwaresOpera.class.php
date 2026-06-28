<?php

namespace Home\Opera;

class BlwaresOpera {

    private $param;
    private $blank;
    private $cats;
    private $lists;

    public function runs($param) {
        $this->param = $param;
        return $this->setListGoods();
    }

    private function setListGoods() {
        $plate_conts       = M("plate_conts");
        $plate_cats        = M("plate_cats");
        $plate_conts_blank = M("plate_conts_blank");

        // 优先用 blank_id 找 blank，兼容旧传参（pid + cat_index）
        if (!empty($this->param['blank_id'])) {
            $this->blank = $plate_conts_blank->where(array('id' => (int)$this->param['blank_id']))->find();
        } elseif (!empty($this->param['pid']) && isset($this->param['cat_index'])) {
            $this->blank = $plate_conts_blank->where(array('pid' => $this->param['pid'], 'cat_index' => $this->param['cat_index']))->find();
        }

        // 从 blank 取 pid 用于查 plate_conts
        $pid = $this->blank ? $this->blank['pid'] : (isset($this->param['pid']) ? $this->param['pid'] : 0);

        if ($pid) {
            $conts       = $plate_conts->find($pid);
            $this->cats  = $conts ? $plate_cats->find($conts["catid"]) : null;
        }

        // 查 logs：优先 blank_id，兼容 pid+cat_index
        if (isset($this->param['logs']) && $this->param['logs']) {
            $list = json_decode(htmlspecialchars_decode($this->param['logs']), true);
            $this->lists = $list;
            return $this->updateListMarket();
        }

        $blankId = $this->blank ? $this->blank['id'] : 0;
        if ($blankId) {
            $list = M("plate_conts_logs")->where(array('blank_id' => $blankId))->order('number asc, id asc')->select();
        } elseif ($pid && isset($this->param['cat_index'])) {
            $list = M("plate_conts_logs")->where(array('pid' => $pid, 'cat_index' => $this->param['cat_index']))->order('number asc, id asc')->select();
        } else {
            return array('status' => 1, 'msg' => '无需更新', 'data' => array());
        }

        $blwares         = D("Home/Cxmark", "Opera");
        $plate_conts_logs = D('plate_conts_logs');
        foreach ($list as $v) {
            $market = $blwares->runs($v);
            $plate_conts_logs->where(array('id' => $v['id']))->save(array(
                'market' => $market["data"]['market'],
                'price'  => $market["data"]['price'],
                'weight' => isset($market["data"]['weight']) ? $market["data"]['weight'] : 0,
            ));
        }
        return array('status' => 1, 'msg' => '成功', 'data' => array());
    }

    private function updateListMarket() {
        $plate_conts_logs = M("plate_conts_logs");
        foreach ($this->lists as $v) {
            $where = array("id" => $v["id"]);
            unset($v["id"]);
            $v["uptimes"] = time();
            $save           = $v;
            $save["market"] = round($this->getMarket($v), 2);
            if (!isset($save['key_0']) && isset($this->param["type"]) && $this->param["type"] < 1) {
                $save["key_0"] = isset($this->param["keya"]) ? $this->param["keya"] : '';
                $save["key_1"] = isset($this->param["keyb"]) ? $this->param["keyb"] : '';
                $save["key_2"] = isset($this->param["keyc"]) ? $this->param["keyc"] : '';
                $save["key_3"] = isset($this->param["keyd"]) ? $this->param["keyd"] : '';
                $save["key_4"] = isset($this->param["keye"]) ? $this->param["keye"] : '';
                $save["key_5"] = isset($this->param["keyf"]) ? $this->param["keyf"] : '';
                $save["key_6"] = isset($this->param["keyg"]) ? $this->param["keyg"] : '';
                $save["key_7"] = isset($this->param["keyh"]) ? $this->param["keyh"] : '';
            }
            $plate_conts_logs->where($where)->save($save);
        }
        return array('status' => 1, 'msg' => '成功', 'data' => array());
    }

    private function getMarket($v) {
        return bcmul((string)$v['price'], (string)$v['dratio'], 2);
    }

    private function plate_cats_ratio() {
        if ($this->cats == null) return 0;
        $baseRatio  = 100;
        $firstRatio = $baseRatio * (1 + $this->cats["up"] / 100) * (1 - $this->cats["down"] / 100);
        return $firstRatio / 100;
    }

    private function plate_conts_ratio() {
        $baseRatio = 100;
        if ($this->blank == null) return $baseRatio / 100;
        $r = $baseRatio
            * (1 + $this->blank["up_a"] / 100) * (1 - $this->blank["down_a"] / 100)
            * (1 + $this->blank["up_b"] / 100) * (1 - $this->blank["down_b"] / 100)
            * (1 + $this->blank["up_c"] / 100) * (1 - $this->blank["down_c"] / 100)
            * (1 + $this->blank["up_d"] / 100) * (1 - $this->blank["down_d"] / 100)
            * (1 + $this->blank["up_e"] / 100) * (1 - $this->blank["down_e"] / 100)
            * (1 + $this->blank["up_f"] / 100) * (1 - $this->blank["down_f"] / 100);
        return $r / 100;
    }

}
