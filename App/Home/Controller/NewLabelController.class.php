<?php

namespace Home\Controller;
use Think\Log;
#use Think\Controller;

class NewLabelController extends CommController {

    public function index() {
        $model   = M("new_label");
        $allList = $model->order('id asc')->select();
        // 构建完整树后按 cate_type 过滤根节点（子材料随父分类，无需重复处理）
        $tree        = getTreeChildren($allList, 0, 'id', 'cate_label_id');
        $baseList    = array_values(array_filter($tree, function($r){ return $r['cate_type'] == 0; }));
        $derivedList = array_values(array_filter($tree, function($r){ return $r['cate_type'] == 1; }));
        $this->assign("baseList",    $baseList);
        $this->assign("derivedList", $derivedList);
        $this->assign("allTree",     $tree);
        $this->display();
    }
    
    public function add() {
        $db = D('new_label');
        $data = I("post.");
        
       
        if($data['pid'] > 0){
            $pinfo = $db->where(['id'=>$data['pid']])->find();
            if(!$pinfo){
                 return get_op_put(0, '上级不存在');
            }//var_dump($data['pid']);var_dump($pinfo);
            $pid_str = '';
            $pid_str = $pinfo['pid_str'];
            if($pid_str){
                 $pid_str = $pid_str.','.$pinfo['id'];
            }else{
                $pid_str = $pinfo['id'];
            }
           
            $data['pid_str'] = $pid_str;//var_dump($pid_str);
            $data['level'] = $pinfo['level']+1;;
        }
        if($data['pid2'] > 0){
            $pinfo2 = $db->where(['id'=>$data['pid2']])->find();
            if(!$pinfo2){
                 return get_op_put(0, '上级不存在');
            }//var_dump($data['pid']);var_dump($pinfo);
            $pid_str2 = '';
            $pid_str2 = $pinfo2['pid_str2'];
            if($pid_str2){
                 $pid_str2 = $pid_str2.','.$pinfo2['id'];
            }else{
                $pid_str2 = $pinfo2['id'];
            }
           
            $data['pid_str2'] = $pid_str2;//var_dump($pid_str);
            $data['level2'] = $pinfo2['level2']+1;;
        }
        if($data['pid3'] > 0){
            $pinfo3 = $db->where(['id'=>$data['pid3']])->find();
            if(!$pinfo3){
                 return get_op_put(0, '上级不存在');
            }//var_dump($data['pid']);var_dump($pinfo);
            $pid_str3 = '';
            $pid_str3 = $pinfo3['pid_str3'];
            if($pid_str3){
                 $pid_str3 = $pid_str3.','.$pinfo3['id'];
            }else{
                $pid_str3 = $pinfo3['id'];
            }
           
            $data['pid_str3'] = $pid_str3;//var_dump($pid_str);
            $data['level3'] = $pinfo3['level3']+1;;
        }
        #
        if (!$db->create($data, 1)) {
            return get_op_put(0, $db->getError());
        }
        $id = $db->add();
        if (!$id) {
            return get_op_put(0, "添加失败");
        }
        
        
        #
        return get_op_put(1, "添加成功");
    }
    
    public function edit(){
        // set_time_limit(600);
        $db = D('new_label');
        $data = I("post.");
        $id = I("post.id");
        $info = $db->where(['id'=>$id])->find();
        $orgPid = $info['pid'];
        
        if($data['pid'] > 0){
            
            
            
            $pinfo = $db->where(['id'=>$data['pid']])->find();
            if(!$pinfo){
                 return get_op_put(0, '上级不存在');
            }
            $temp = explode(',',$pinfo['pid_str']);
            if(in_array($id,$temp)){
                 return get_op_put(0, '上级已存在，请勿添加');
            }
            
            $pid_str = '';
            $pid_str = $pinfo['pid_str'];
            if($pid_str){
                 $pid_str = $pid_str.','.$pinfo['id'];
            }else{
                $pid_str = $pinfo['id'];
            }
           
            $data['pid_str'] = $pid_str;
            $data['level'] = $pinfo['level']+1;;
        }else{
            $data['pid_str'] = '';
            $data['level'] = 0;
        }
        if($data['pid2'] > 0){
            
            $pinfo2 = $db->where(['id'=>$data['pid2']])->find();
            if(!$pinfo2){
                 return get_op_put(0, '上级不存在');
            }
            $temp2 = explode(',',$pinfo2['pid_str']);
            if(in_array($id,$temp2)){
                 return get_op_put(0, '上级已存在，请勿添加');
            }
            
            $pid_str2 = '';
            $pid_str2 = $pinfo2['pid_str2'];
            if($pid_str2){
                 $pid_str2 = $pid_str2.','.$pinfo2['id'];
            }else{
                $pid_str2 = $pinfo2['id'];
            }
           
            $data['pid_str2'] = $pid_str2;
            $data['level2'] = $pinfo2['level2']+1;;
        }else{
            $data['pid_str2'] = '';
            $data['level2'] = 0;
        }
        if($data['pid3'] > 0){
            
            $pinfo3 = $db->where(['id'=>$data['pid3']])->find();
            if(!$pinfo3){
                 return get_op_put(0, '上级不存在');
            }
            $temp3 = explode(',',$pinfo3['pid_str3']);
            if(in_array($id,$temp3)){
                 return get_op_put(0, '上级已存在，请勿添加');
            }
            
            $pid_str3 = '';
            $pid_str3 = $pinfo3['pid_str3'];
            if($pid_str3){
                 $pid_str3 = $pid_str3.','.$pinfo3['id'];
            }else{
                $pid_str3 = $pinfo3['id'];
            }
           
            $data['pid_str3'] = $pid_str3;
            $data['level3'] = $pinfo3['level3']+1;;
        }else{
            $data['pid_str3'] = '';
            $data['level3'] = 0;
        }
        
        #
        $new_label_ids = [];
        $new_label_ids[0] = $id;
        $db->where(['id'=>$info['id']])->save($data);
        $info =   $db->where(['id'=>$id])->find();
        $pid_str = '';
        if($info['pid_str']){
            $pid_str = explode(',',$info['pid_str']);
        }
        
        //原下级
        $orgChildList = $db->where("FIND_IN_SET($id, pid_str)")->order('level asc,id asc')->select();
        // var_dump($orgChildList);die;
         $blwares = D("Home/NewLabel", "Opera");
        foreach ($orgChildList as $k=>$v){
        
              $p = $db->where(['id'=>$v['pid']])->find();
              if($p['pid_str']){
                   $temp = $p['pid_str'].','.$p['id'];
              }else{
                   $temp = $p['id'];
              }
             
              $level = 1;
              
              $up['level'] = count(explode(',',$temp));
              
              $up['pid_str'] = $temp;
              
            //   $_pinfo = $db->where(['id'=>$v['pid']])->find();
              $price = bcmul($p['price'] ,$v['ratio'],6);
              $price = bcdiv($price ,100,4);
              $price2 = 0;
              if($v['pid2'] > 0){
                  $p2 = $db->where(['id'=>$v['pid2']])->find();
                   $price2 = bcmul($p2['price'] ,$v['ratio2'],6);
                   $price2 = bcdiv($price2 ,100,4);
              }
              $price3 = 0;
              if($v['pid3'] > 0){
                  $p3 = $db->where(['id'=>$v['pid3']])->find();
                   $price3 = bcmul($p3['price'] ,$v['ratio3'],6);
                   $price3 = bcdiv($price3 ,100,4);
              }

              $price = bcadd($price,$price2,4);
              $price = bcadd($price,$price3,4);
              $price = bcadd($price, $v['end_ratio'], 4);
              $up['price'] = $price;

              $orgChildList[$k]['_price'] = $up['price'];
              $db->where(['id'=>$v['id']])->save($up);

              array_push($new_label_ids,$v['id']);

            }

        $orgChildList2 = M('new_label')->where("FIND_IN_SET($id, pid2_str)")->order('level2 asc,id asc')->select();
        foreach ($orgChildList2 as $k=>$v){
              $p = $db->where(['id'=>$v['pid2']])->find();
              if($p['pid2_str']){
                  $temp = $p['pid2_str'].','.$p['id'];
              }else{
                  $temp = $p['id'];
              }
              $level = 1;
              $up['level2'] = count(explode(',',$temp));
              $up['pid2_str'] = $temp;

              $price = bcmul($p['price'] ,$v['ratio'],6);
              $price = bcdiv($price ,100,4);
              $price2 = 0;
              if($v['pid2'] > 0){
                  $p2 = $db->where(['id'=>$v['pid2']])->find();
                  $price2 = bcmul($p2['price'] ,$v['ratio2'],6);
                  $price2 = bcdiv($price2 ,100,4);
              }
              $price3 = 0;
              if($v['pid3'] > 0){
                  $p3 = $db->where(['id'=>$v['pid3']])->find();
                  $price3 = bcmul($p3['price'] ,$v['ratio3'],6);
                  $price3 = bcdiv($price3 ,100,4);
              }

              $price = bcadd($price,$price2,4);
              $price = bcadd($price,$price3,4);
              $price = bcadd($price, $v['end_ratio'], 4);
              $up['price'] = $price;

              $orgChildList[$k]['_price'] = $up['price'];
              $db->where(['id'=>$v['id']])->save($up);

              array_push($new_label_ids,$v['id']);

            }

        $orgChildList3 = M('new_label')->where("FIND_IN_SET($id, pid3_str)")->order('level3 asc,id asc')->select();

        foreach ($orgChildList3 as $k=>$v){

              $p = $db->where(['id'=>$v['pid3']])->find();
              if($p['pid3_str']){
                  $temp = $p['pid3_str'].','.$p['id'];
              }else{
                  $temp = $p['id'];
              }

              $level = 1;

              $up['level3'] = count(explode(',',$temp));

              $up['pid3_str'] = $temp;

              $price = bcmul($p['price'] ,$v['ratio'],6);
              $price = bcdiv($price ,100,4);
              $price2 = 0;
              if($v['pid2'] > 0){
                  $p2 = $db->where(['id'=>$v['pid2']])->find();
                  $price2 = bcmul($p2['price'] ,$v['ratio2'],6);
                  $price2 = bcdiv($price2 ,100,4);
              }
              $price3 = 0;
              if($v['pid3'] > 0){
                  $p3 = $db->where(['id'=>$v['pid3']])->find();
                  $price3 = bcmul($p3['price'] ,$v['ratio3'],6);
                  $price3 = bcdiv($price3 ,100,4);
              }

              $price = bcadd($price,$price2,4);
              $price = bcadd($price,$price3,4);
              $price = bcadd($price, $v['end_ratio'], 4);
              $up['price'] = $price;
              
              $orgChildList[$k]['_price'] = $up['price'];
              $db->where(['id'=>$v['id']])->save($up);
              
              array_push($new_label_ids,$v['id']);
            }
            
            // var_dump($new_label_ids);die;
        
            
            $rs = array(
                    "status" => 1,
                    "msg" => '成功',
                    "data" => [],
                );
            // set_time_limit(0);
            // ob_end_clean();
            // header("Connection: close");
            // header("HTTP/1.1 200 OK");
            // header("Content-Type: application/json;charset=utf-8");// 如果前端要的是json则添加，默认是返回的html/text
            // ob_start();
            // echo json_encode($rs);// 输出结果到前端
            // $size = ob_get_length();
            // header("Content-Length: $size");
            // ob_end_flush();
            // flush();
            // if (function_exists("fastcgi_finish_request")) { // yii或yaf默认不会立即输出，加上此句即可（前提是用的fpm）
            //     fastcgi_finish_request(); // 响应完成, 立即返回到前端,关闭连接
            // }
            // sleep(2);
            // ignore_user_abort(true);// 在关闭连接后，继续运行php脚本

            //公式计算价格变更
            if($new_label_ids){
                
    // var_dump($new_label_ids);die;
    // $new_label_ids = [103];
                Log::record(33333333333, 'DEBUG');
                      Log::record(implode(',',$new_label_ids), 'DEBUG');
                $title = '更新'.$info['name'];
                $task = M("task");
                $task->where(['type'=>1,'item_id'=>$id])->where('status=1 OR status=2')->save(['status'=>4]);
                $taskId = $task->add(['type'=>1,'item_id'=>$id,'title'=>$title,'status'=>1,'add_time'=>time(),'up_time'=>time()]);
                foreach ($new_label_ids as $k=>$v){
                    $blwares->runs(['new_label_id'=>$v],$taskId);
                }
            }
         
        return get_op_put(1, "修改成功!!!");
    }
    
    public function addGet(){
        $data = I("post.");
        $data['cate_list'] = M('new_label')->where(['cate_label_id' => array('gt', 0)])->select();
        $data['pid'] = 0;
        return get_op_put(1, "修改成功",$data);
    }

    public function editGet(){
        $param = I("post.");
        $data = M('new_label')->where(['id'=>$param['id']])->find();
        $where['id'] = array('neq', $data['id']);
        $data['cate_list'] = M('new_label')->where($where)->where(['cate_label_id' => array('gt', 0)])->select();
        $data['ratio']     = (float)$data['ratio'];
        $data['ratio2']    = (float)$data['ratio2'];
        $data['ratio3']    = (float)$data['ratio3'];
        $data['end_ratio'] = (float)$data['end_ratio'];
        $data['price']     = number_format((float)$data['price'], 4, '.', '');
        return get_op_put(1, "修改成功",$data);
    }
    

}
