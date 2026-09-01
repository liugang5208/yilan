<?php

namespace Home\Opera;

class BlwaresOpera {

    private $param;
    private $blank;
    private $cats;
    private $lists;
    private $plateId; // 关联 plate.id，用于公共模板模式(dratio_mode=1)现查 plate_premium

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
            $conts         = $plate_conts->find($pid);
            $this->cats    = $conts ? $plate_cats->find($conts["catid"]) : null;
            $this->plateId = $conts ? (int) $conts["pid"] : 0; // plate_conts.pid = plate.id
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
        $plate_premium    = M("plate_premium");
        foreach ($this->lists as $v) {
            $where = array("id" => $v["id"]);
            unset($v["id"]);
            $v["uptimes"] = time();

            // 公共模板模式：忽略提交的 dratio，现查一次公共溢价率覆盖
            // （主要处理刚从“自定义”切到“公共模板”、还没被 PremiumSyncOpera 级联同步过的行）
            // 产品规格列位置不固定（key_0~key_7 可自定义标签），用 plateContsLogSpec() 动态定位
            if (!empty($v['dratio_mode']) && (int)$v['dratio_mode'] === 1 && $this->plateId) {
                $spec = plateContsLogSpec($v);
                if ($spec !== null && $spec !== '') {
                    $premium = $plate_premium->where(array('plate_id' => $this->plateId, 'spec' => $spec))->find();
                    if ($premium) $v['dratio'] = $premium['ratio'];
                }
            }

            $save           = $v;
            $save["market"] = round($this->getMarket($v), 2);
            if (isset($this->param["type"]) && $this->param["type"] < 1) {
                $cleanKey = function($v) { return ($v === null || $v === 'null') ? '' : $v; };
                if (isset($this->param["keya"])) $save["key_0"] = $cleanKey($this->param["keya"]);
                if (isset($this->param["keyb"])) $save["key_1"] = $cleanKey($this->param["keyb"]);
                if (isset($this->param["keyc"])) $save["key_2"] = $cleanKey($this->param["keyc"]);
                if (isset($this->param["keyd"])) $save["key_3"] = $cleanKey($this->param["keyd"]);
                if (isset($this->param["keye"])) $save["key_4"] = $cleanKey($this->param["keye"]);
                if (isset($this->param["keyf"])) $save["key_5"] = $cleanKey($this->param["keyf"]);
                if (isset($this->param["keyg"])) $save["key_6"] = $cleanKey($this->param["keyg"]);
                if (isset($this->param["keyh"])) $save["key_7"] = $cleanKey($this->param["keyh"]);
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
