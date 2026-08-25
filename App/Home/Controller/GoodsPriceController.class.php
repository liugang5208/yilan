<?php

namespace Home\Controller;

class GoodsPriceController extends CommController {

    public function priceCateList(){
        $param     = I("post.");
        $param_pid = $param['pid'];
        $pid       = $param_pid > 0 ? (int)$param_pid : 0;
        $level     = 1;
        if ($pid > 0) {
            $pinfo = M('new_cate')->where(array('id' => $pid))->find();
            if ($pinfo) $level = $pinfo['level'] + 1;
        }
        $data['cate_list'] = M('new_cate')->where(array('pid' => $pid))->select();
        $data['level']     = $level;
        return get_op_put(1, "获取成功", $data);
    }

    public function priceAddGet(){
        $param = I("post.");
        $data['info']['plate_conts_id'] = $param['plate_conts_id'];
        $data['info']['blank_id']       = isset($param['blank_id']) ? (int)$param['blank_id'] : 0;
        $data['info']['cat_index']      = isset($param['cat_index']) ? (int)$param['cat_index'] : 0;
        $data['info']['ratio']          = 100;
        return get_op_put(1, "获取成功", $data);
    }

    public function priceAddPost() {
        $db   = D('plate_conts_price');
        $data = I("post.");

        if (!isset($data['new_cate_three_id']) || !$data['new_cate_three_id']) {
            return get_op_put(0, "请选择分类");
        }
        if (!(int)$data['blank_id']) return get_op_put(0, "请先选择商品属性");

        $blank = M('plate_conts_blank')->where(array('id' => (int)$data['blank_id']))->field('id, pid, cat_index')->find();
        if (!$blank) return get_op_put(0, "商品属性不存在");
        $data['plate_conts_id'] = $blank['pid'];
        $data['cat_index']      = $blank['cat_index'];

        if (!$db->create($data, 1)) return get_op_put(0, $db->getError());
        $id = $db->add();
        if (!$id) return get_op_put(0, "添加失败");

        $blwares = D("Home/Blwares", "Opera");
        $blwares->runs(array('blank_id' => $blank['id']));
        return get_op_put(1, "添加成功");
    }

    public function priceEditGet(){
        $param = I("post.");
        $info  = M('plate_conts_price')->where(array('id' => $param['id']))->find();
        $info['ratio'] = (float)$info['ratio'];
        $data['info']  = $info;
        return get_op_put(1, "获取成功", $data);
    }

    public function priceEditpost() {
        $db   = D('plate_conts_price');
        $data = I("post.");
        $id   = (int)I("post.id");
        $info = $db->where(array('id' => $id))->find();
        if (!$info) return get_op_put(0, "记录不存在");

        $db->where(array('id' => $id))->save($data);

        $blwares = D("Home/Blwares", "Opera");
        $blwares->runs(array('blank_id' => (int)$info['blank_id']));
        return get_op_put(1, "修改成功");
    }

    public function delsPrice(){
        $post = I("post.");
        $info = M('plate_conts_price')->where(array('id' => $post['id']))->find();
        if (!$info) return get_op_put(0, "记录不存在");

        M('plate_conts_price')->where(array('id' => $post['id']))->delete();

        $blwares = D("Home/Blwares", "Opera");
        $blwares->runs(array('blank_id' => (int)$info['blank_id']));
        return get_op_put(1, "操作成功");
    }

    public function delAllPrice(){
        $post     = I("post.");
        $blank_id = (int)$post['blank_id'];
        if (!$blank_id) return get_op_put(0, "参数错误");

        M('plate_conts_price')->where(array('blank_id' => $blank_id))->delete();

        $blwares = D("Home/Blwares", "Opera");
        $blwares->runs(array('blank_id' => $blank_id));
        return get_op_put(1, "操作成功");
    }

    public function copyPrice(){
        $post     = I("post.");
        $blank_id = (int)$post['blank_id'];
        $from_id  = (int)$post['from_blank_id'];
        if (!$blank_id || !$from_id) return get_op_put(0, "参数错误");
        if ($blank_id === $from_id) return get_op_put(0, "不能复制自身");

        $srcPrices = M('plate_conts_price')->where(array('blank_id' => $from_id, 'is_del' => 1))->select();
        if (!$srcPrices) return get_op_put(0, "源商品无属性价格数据");

        $blank = M('plate_conts_blank')->where(array('id' => $blank_id))->field('id, pid, cat_index')->find();
        if (!$blank) return get_op_put(0, "目标商品属性不存在");

        M('plate_conts_price')->where(array('blank_id' => $blank_id))->delete();
        $db = M('plate_conts_price');
        foreach ($srcPrices as $v) {
            unset($v['id']);
            $v['blank_id']       = $blank_id;
            $v['plate_conts_id'] = $blank['pid'];
            $v['cat_index']      = $blank['cat_index'];
            $db->add($v);
        }

        $blwares = D("Home/Blwares", "Opera");
        $blwares->runs(array('blank_id' => $blank_id));
        return get_op_put(1, "操作成功");
    }

}
