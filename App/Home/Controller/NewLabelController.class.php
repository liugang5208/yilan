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
            if(!$pinfo) return get_op_put(0, '上级不存在');
            $pid_str = $pinfo['pid_str'] ? $pinfo['pid_str'].','.$pinfo['id'] : $pinfo['id'];
            $data['pid_str'] = $pid_str;
            $data['level']   = $pinfo['level'] + 1;
        } else {
            $data['pid_str'] = '';
            $data['level']   = 0;
        }
        if($data['pid2'] > 0){
            $pinfo2 = $db->where(['id'=>$data['pid2']])->find();
            if(!$pinfo2) return get_op_put(0, '上级不存在');
            $pid_str2 = $pinfo2['pid_str2'] ? $pinfo2['pid_str2'].','.$pinfo2['id'] : $pinfo2['id'];
            $data['pid_str2'] = $pid_str2;
            $data['level2']   = $pinfo2['level2'] + 1;
        } else {
            $data['pid_str2'] = '';
            $data['level2']   = 0;
        }
        if($data['pid3'] > 0){
            $pinfo3 = $db->where(['id'=>$data['pid3']])->find();
            if(!$pinfo3) return get_op_put(0, '上级不存在');
            $pid_str3 = $pinfo3['pid_str3'] ? $pinfo3['pid_str3'].','.$pinfo3['id'] : $pinfo3['id'];
            $data['pid_str3'] = $pid_str3;
            $data['level3']   = $pinfo3['level3'] + 1;
        } else {
            $data['pid_str3'] = '';
            $data['level3']   = 0;
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
              $price = bcdiv($price ,100,2);
              $price2 = 0;
              if($v['pid2'] > 0){
                  $p2 = $db->where(['id'=>$v['pid2']])->find();
                   $price2 = bcmul($p2['price'] ,$v['ratio2'],6);
                   $price2 = bcdiv($price2 ,100,2);
              }
              $price3 = 0;
              if($v['pid3'] > 0){
                  $p3 = $db->where(['id'=>$v['pid3']])->find();
                   $price3 = bcmul($p3['price'] ,$v['ratio3'],6);
                   $price3 = bcdiv($price3 ,100,2);
              }

              $price = bcadd($price,$price2,2);
              $price = bcadd($price,$price3,2);
              $price = bcadd($price, $v['end_ratio'], 2);
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
              $price = bcdiv($price ,100,2);
              $price2 = 0;
              if($v['pid2'] > 0){
                  $p2 = $db->where(['id'=>$v['pid2']])->find();
                  $price2 = bcmul($p2['price'] ,$v['ratio2'],6);
                  $price2 = bcdiv($price2 ,100,2);
              }
              $price3 = 0;
              if($v['pid3'] > 0){
                  $p3 = $db->where(['id'=>$v['pid3']])->find();
                  $price3 = bcmul($p3['price'] ,$v['ratio3'],6);
                  $price3 = bcdiv($price3 ,100,2);
              }

              $price = bcadd($price,$price2,2);
              $price = bcadd($price,$price3,2);
              $price = bcadd($price, $v['end_ratio'], 2);
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
              $price = bcdiv($price ,100,2);
              $price2 = 0;
              if($v['pid2'] > 0){
                  $p2 = $db->where(['id'=>$v['pid2']])->find();
                  $price2 = bcmul($p2['price'] ,$v['ratio2'],6);
                  $price2 = bcdiv($price2 ,100,2);
              }
              $price3 = 0;
              if($v['pid3'] > 0){
                  $p3 = $db->where(['id'=>$v['pid3']])->find();
                  $price3 = bcmul($p3['price'] ,$v['ratio3'],6);
                  $price3 = bcdiv($price3 ,100,2);
              }

              $price = bcadd($price,$price2,2);
              $price = bcadd($price,$price3,2);
              $price = bcadd($price, $v['end_ratio'], 2);
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
        $data['cate_list']          = M('new_label')->where($where)->where(['cate_label_id' => array('gt', 0)])->select();
        $data['ratio']              = (float)$data['ratio'];
        $data['ratio2']             = (float)$data['ratio2'];
        $data['ratio3']             = (float)$data['ratio3'];
        $data['end_ratio']          = (float)$data['end_ratio'];
        $data['price']              = number_format((float)$data['price'], 2, '.', '');
        $data['last_futures_price'] = number_format((float)$data['last_futures_price'], 2, '.', '');
        $data['last_sync_ratio']    = (float)$data['last_sync_ratio'];
        // 是否配置了自动同步（price_sync_config 中存在 auto_sync=1 的有效配置）
        $syncConfig = M('price_sync_config')->where([
            'new_label_id' => $data['id'],
            'auto_sync'    => 1,
            'status'       => 1,
        ])->find();
        $data['has_auto_sync']   = $syncConfig ? 1 : 0;
        $data['sync_config_id']  = $syncConfig ? $syncConfig['id'] : 0;
        return get_op_put(1, "修改成功",$data);
    }

    public function cloneDerivedCate() {
        $sourceId = (int)I('post.source_id');
        $newName  = trim(I('post.new_name'));

        if (!$sourceId) return get_op_put(0, '请选择源分类');
        if (!$newName)  return get_op_put(0, '请输入新分类名称');

        $db = M('new_label');

        // 验证源分类存在且是衍生分类
        $source = $db->where(['id' => $sourceId, 'cate_label_id' => 0, 'cate_type' => 1])->find();
        if (!$source) return get_op_put(0, '源分类不存在或不是衍生分类');
        if ($source['name'] === $newName) return get_op_put(0, '新分类名称不能与源分类名称相同');

        // 1. 创建新根节点
        $newRootId = $db->add([
            'name'         => $newName,
            'cate_label_id'=> 0,
            'cate_type'    => 1,
            'pid'          => 0,
            'status'       => 1,
            'is_del'       => 1,
            'add_time'     => time(),
            'up_time'      => time(),
        ]);
        if (!$newRootId) return get_op_put(0, '创建新分类失败');

        // 2. 查出源分类下所有材料，按 level asc 保证父节点先处理
        $srcMaterials = $db->where(['cate_label_id' => $sourceId])
                           ->order('level asc, id asc')
                           ->select();
        if (!$srcMaterials) {
            return get_op_put(1, '复制完成（源分类无材料）', ['count' => 0]);
        }

        // 3. 构建同分类内的 old_id → new_id 映射
        $srcIds = array_column($srcMaterials, 'id');
        $idMap  = [];
        $count  = 0;

        foreach ($srcMaterials as $m) {
            // 只处理 pid>0 的衍生材料（与页面展示一致）
            if ((int)$m['pid'] === 0) continue;

            // 重映射 pid/pid2/pid3：同分类内引用改为新副本，外部引用保持不变
            $newPid  = in_array($m['pid'],  $srcIds) && isset($idMap[$m['pid']])  ? $idMap[$m['pid']]  : $m['pid'];
            $newPid2 = in_array($m['pid2'], $srcIds) && isset($idMap[$m['pid2']]) ? $idMap[$m['pid2']] : $m['pid2'];
            $newPid3 = in_array($m['pid3'], $srcIds) && isset($idMap[$m['pid3']]) ? $idMap[$m['pid3']] : $m['pid3'];

            // 重建 pid_str
            $newPidStr  = '';
            $newPidStr2 = '';
            $newPidStr3 = '';
            if ($newPid > 0) {
                $p1 = $db->where(['id' => $newPid])->find();
                $newPidStr = $p1 ? ($p1['pid_str'] ? $p1['pid_str'].','.$p1['id'] : $p1['id']) : '';
            }
            if ($newPid2 > 0) {
                $p2 = $db->where(['id' => $newPid2])->find();
                $newPidStr2 = $p2 ? ($p2['pid2_str'] ? $p2['pid2_str'].','.$p2['id'] : $p2['id']) : '';
            }
            if ($newPid3 > 0) {
                $p3 = $db->where(['id' => $newPid3])->find();
                $newPidStr3 = $p3 ? ($p3['pid3_str'] ? $p3['pid3_str'].','.$p3['id'] : $p3['id']) : '';
            }

            // 重新计算价格
            $price = 0;
            if ($newPid > 0) {
                $pp1   = $db->where(['id' => $newPid])->find();
                $price = bcdiv(bcmul((string)$pp1['price'], (string)$m['ratio'], 6), '100', 2);
            }
            $price2 = 0;
            if ($newPid2 > 0) {
                $pp2    = $db->where(['id' => $newPid2])->find();
                $price2 = bcdiv(bcmul((string)$pp2['price'], (string)$m['ratio2'], 6), '100', 2);
            }
            $price3 = 0;
            if ($newPid3 > 0) {
                $pp3    = $db->where(['id' => $newPid3])->find();
                $price3 = bcdiv(bcmul((string)$pp3['price'], (string)$m['ratio3'], 6), '100', 2);
            }
            $totalPrice = bcadd(bcadd($price, $price2, 2), $price3, 2);
            $totalPrice = bcadd($totalPrice, (string)$m['end_ratio'], 2);

            $newId = $db->add([
                'name'          => $m['name'],
                'cate_label_id' => $newRootId,
                'cate_type'     => 0,
                'pid'           => $newPid,
                'pid_str'       => $newPidStr,
                'pid2'          => $newPid2,
                'pid2_str'      => $newPidStr2,
                'pid3'          => $newPid3,
                'pid3_str'      => $newPidStr3,
                'ratio'         => $m['ratio'],
                'ratio2'        => $m['ratio2'],
                'ratio3'        => $m['ratio3'],
                'end_ratio'     => $m['end_ratio'],
                'price'         => $totalPrice,
                'level'         => $m['level'],
                'level2'        => $m['level2'],
                'level3'        => $m['level3'],
                'status'        => 1,
                'is_del'        => 1,
                'add_time'      => time(),
                'up_time'       => time(),
            ]);

            if ($newId) {
                $idMap[$m['id']] = $newId;
                $count++;
            }
        }

        return get_op_put(1, '复制完成', ['count' => $count]);
    }

    public function dels() {
        $id = I('post.id');
        if (!$id) return get_op_put(0, '参数错误');

        $record = M('new_label')->where(['id' => $id])->find();
        if (!$record) return get_op_put(0, '记录不存在');

        if (!M('new_label')->where(['id' => $id])->delete()) {
            return get_op_put(0, '删除失败');
        }

        // 删除对应的期货同步配置（仅针对基础材料）
        if ((int)$record['pid'] === 0 && (int)$record['cate_label_id'] > 0) {
            M('price_sync_config')->where(['new_label_id' => $id])->delete();
        }

        return get_op_put(1, '删除成功');
    }


}
