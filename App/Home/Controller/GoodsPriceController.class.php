<?php

namespace Home\Controller;

#use Think\Controller;

class GoodsPriceController extends CommController {

    public function priceList(){
        $price_list = M('plate_conts_price')->where(['cat_index'=>$post["cat_index"]])->where(['plate_conts_id'=>$post["pid"]])->where(['is_del'=>1])->select();
        $res["price_list"] = $price_list;
         return get_op_put(1, "获取成功",$resdata);
        
    }

     public function priceCateList(){
        $param = I("post.");
        $param_pid = $param['pid'];
        $pid = 0;
        if($param_pid > 0){
            $pid = $param_pid;
        }
        //当前分类等级
        $level = 1;
        if($pid > 0){
            $pinfo = M('new_cate')->where(['id'=>$pid])->find();
            if($pinfo){
                $level = $pinfo['level'] + 1;
            }
        }
        
        $where['pid'] = $pid;
        $data['cate_list'] = M('new_cate')->where($where)->select();
        $data['level'] = $level;
        return get_op_put(1, "获取成功",$data);
    }
    
    public function priceAddGet(){
        $param = I("post.");
  
        $data['info']['plate_conts_id'] = $param['plate_conts_id'];
        $data['info']['cat_index'] = $param['cat_index'];
        $data['info']['ratio'] = 1;
        //  $data['ratio'] = 100;
        return get_op_put(1, "获取成功",$data);
    }
    
    public function priceAddPost() {
        $db = D('plate_conts_price');
        $data = I("post.");
        
        if(!isset($data['new_cate_three_id']) || !$data['new_cate_three_id']){
             return get_op_put(0, "请选择分类");
        }
        #
        if (!$db->create($data, 1)) {
            return get_op_put(0, $db->getError());
        }
        $id = $db->add();
        if (!$id) {
            return get_op_put(0, "添加失败");
        }
        
        $blwares = D("Home/Blwares", "Opera");
        $run['pid'] = $data['plate_conts_id'];
        $run['cat_index'] = $data['cat_index'];
        $blwares->runs($run);
        #
        return get_op_put(1, "添加成功");
    }
    
    
     public function priceEditGet(){
        $param = I("post.");
        $id = $param['id'];
        $info = M('plate_conts_price')->where(['id'=>$id])->find();
        // $data['info']['plate_conts_id'] = $param['plate_conts_id'];
        // $data['info']['cat_index'] = $param['cat_index'];
        $info['ratio'] = (float)$info['ratio'];
        $data['info'] = $info;
        
        return get_op_put(1, "获取成功",$data);
    }
    
      public function priceEditpost() {
        $db = D('plate_conts_price');
        $data = I("post.");
        $id = I("post.id");
        $info = $db->where(['id'=>$id])->find();

        #
        $db->where(['id'=>$info['id']])->save($data);
        
        $blwares = D("Home/Blwares", "Opera");
        $run['pid'] = $info['plate_conts_id'];
        $run['cat_index'] = $info['cat_index'];
        $blwares->runs($run);
        return get_op_put(1, "修改成功");
    }
    
    public function delsPrice(){
        $post = I("post.");
        
        $info = M('plate_conts_price')->where(['id'=>$post['id']])->find();

        M('plate_conts_price')->where(['id'=>$post['id']])->delete();

        $blwares = D("Home/Blwares", "Opera");
        $run['pid'] = $info['plate_conts_id'];
        $run['cat_index'] = $info['cat_index'];
        $blwares->runs($run);
        
        return get_op_put(1, "操作成功");
    }
    
    public function delAllPrice(){
        $post = I("post.");
        // var_dump($post);die;
        $pid = $post['pid'];
        $cat_index = $post['cat_index'];
        
        M('plate_conts_price')->where(['plate_conts_id'=>$pid,'cat_index'=>$cat_index])->delete();


        $blwares = D("Home/Blwares", "Opera");
        $run['pid'] = $info['plate_conts_id'];
        $run['cat_index'] = $info['cat_index'];
        $blwares->runs($run);
        
        return get_op_put(1, "操作成功");
    }
    
     public function copyPrice(){
        $post = I("post.");
        // var_dump($post);die;
        $pid = $post['pid'];
        $cat_index = $post['cat_index'];
        if($cat_index == 1){
            return get_op_put(0, "已是第一个版块，无需复制");
        }
        if($cat_index == 2){
            $up_list = M('plate_conts_price')->where(['plate_conts_id'=>$pid,'cat_index'=>1])->select();
        }else{
            $up_list = M('plate_conts_price')->where(['plate_conts_id'=>$pid,'cat_index'=>2])->select();
        }
        if(!$up_list){
            return get_op_put(0, "上一板块没有部件材料");
        }
        // var_dump($up_list);die;
        M('plate_conts_price')->where(['plate_conts_id'=>$pid,'cat_index'=>$cat_index])->delete();
        $db = M('plate_conts_price');
        foreach($up_list as $k=>$v){
            $temp =[
                'plate_conts_id'=>$pid,
                'cat_index'=>$cat_index,
                'new_cate_one_id'=>$v['new_cate_one_id'],
                'new_cate_two_id'=>$v['new_cate_two_id'],
                'new_cate_three_id'=>$v['new_cate_three_id'],
                'name'=>$v['name'],
                'ratio'=>$v['ratio'],
                'sort'=>$v['sort'],
                ];
            
            $id = $db->add($temp);
            if (!$id) {
                return get_op_put(0, "添加失败");
            }
                
        }

        $blwares = D("Home/Blwares", "Opera");
        $run['pid'] = $info['plate_conts_id'];
        $run['cat_index'] = $info['cat_index'];
        $blwares->runs($run);
        
        return get_op_put(1, "操作成功");
    }
    

}
