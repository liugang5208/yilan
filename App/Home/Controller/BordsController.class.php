<?php

namespace Home\Controller;

#use Think\Controller;

class BordsController extends CommController {

    public function index() {
        $this->display();
    }

    /**
     * 执行排序
     */
    public function dosort() {
        $plate_types = M("plate_types");
        $plate = M("plate");
        $plate_conts = M("plate_conts");
        $plate_conts_logs = M("plate_conts_logs");
        $plate_conts_logsr = M("plate_conts_logsr");
        #
        $ltypes = $plate_types->select();
        foreach ($ltypes as $k => $v) {
            $plate_types->where(["id" => $v["id"]])->save(["sorts" => $v["id"]]);
        }
        $lplate = $plate->select();
        foreach ($lplate as $k => $v) {
            $plate->where(["id" => $v["id"]])->save(["sorts" => $v["id"]]);
        }
        $lconts = $plate_conts->select();
        foreach ($lconts as $k => $v) {
            $plate_conts->where(["id" => $v["id"]])->save(["sorts" => $v["id"]]);
        }
        $llogs = $plate_conts_logs->select();
        foreach ($llogs as $k => $v) {
            $plate_conts_logs->where(["id" => $v["id"]])->save(["sorts" => $v["id"]]);
        }
        $llogsr = $plate_conts_logsr->select();
        foreach ($llogsr as $k => $v) {
            $plate_conts_logsr->where(["id" => $v["id"]])->save(["sorts" => $v["id"]]);
        }
    }

}
