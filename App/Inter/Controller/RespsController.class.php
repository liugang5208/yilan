<?php

namespace Inter\Controller;

#use Think\Controller;

class RespsController extends CommController {

    /**
     * 订单更新
     */
    public function orupdate() {
        $orders = M("orders");
        $users = M("users");
        $mess = D("Home/Mess", "Logic");
        #
        $ceil = time() - 86400 * 10;
        $where["status"] = 2;
        $where["_string"] = "uptimes>0 and uptimes<" . $ceil;
        $list = $orders->where($where)->limit(50)->select();
        $save = ["status" => 3, "uptimes" => time()];
        #
        foreach ($list as $k => $v) {
            if (!$orders->where($where)->save($save)) {
                return get_op_put(0, "NO_DATA");
            }
            #
            $u = $users->where(["id" => $v["uid"]])->find();
            $param = ["phone" => $u["phone"], "sn" => $v["sn"], "money" => $v["money"]];
            $mess->runs($param, 5);
        }

        #
        return get_op_put(1, "OK");
    }
    
    public function task(){
        set_time_limit(3000);
        $task_log = M('task_log');
        // $task_log->where('hand_time <= time()-3600*3')->save(['status'=>1]);
        $time = time()-1800;
        // $time = time();
        $task_log->where("hand_time <= $time")->where(['status'=>2])->save(['status'=>1]);
        $Model = M('task');
        $list = $Model->alias('a')->join('task_log b ON b.task_id = a.id')
                ->where('a.type=1')
                ->where('a.status=1 OR a.status=2')
                ->where('b.status=1')
                ->order('a.id asc,b.id asc')
                ->field('a.id,a.status,b.id as task_log_id,b.new_cate_id')
                ->limit(5)
                ->select();
        if($list){
            $blwares = D("Home/NewCate", "Opera");
            $taskIds = [];
            foreach($list as $k=>$v){
                if(!in_array($v['id'],$taskIds)){
                    $taskIds[] = $v['id'];
                    $Model->where(['id'=>$v['id']])->where(['status'=>1])->save(['status'=>2]);
                }
                $task_log->where(['id'=>$v['task_log_id']])->save(['status'=>2,'hand_time'=>time()]);
            }
            foreach($list as $k=>$v){
                
                $run['new_cate_id'] = $v['new_cate_id'];
               
                try{
                    $blwares->runs($run);
                } catch (Exception $e) {
                    // 捕获所有异常并处理
                    // error_log('Error in blwares->runs: ' . $e->getMessage()); // 记录错误日志
                    echo 'An error occurred: ' . $e->getMessage(); // 输出错误信息（仅用于调试）
                }
                
                $task_log->where(['id'=>$v['task_log_id']])->save(['status'=>3,'end_time'=>time()]);
            }
            foreach ($taskIds as $k=>$v){
                $count = $task_log->where(['task_id'=>$v])->where('status=1 OR status=2')->count();
                if($count <= 0){
                    $Model->where(['id'=>$v])->save(['status'=>3,'ratio'=>100]);
                }else{
                   $total = $task_log->where(['task_id'=>$v])->count();
                   $ratio = (1- round($count/$total,2))*100;
                   if($ratio > 100) $ratio = 100;
                    $Model->where(['id'=>$v])->save(['ratio'=>$ratio]);
                }
            }
        } 
         return get_op_put(1, "OK");
    }
    
    public function test(){
         $task_log = M('task_log');
         $time = time()-3600*3;
        $task_log->where("hand_time <= $time")->where(['status'=>2])->save(['status'=>1]);
        // $task_log->where('id > 0')->save(['hand_time'=>time()-3600*3]);
        // $task_log = M('task_log');
        // $Model = M('task');
        // $v = 1;
        // $e = $task_log->where(['task_id'=>$v])->where(['id'=>23])->find();var_dump($e);die;
        // $count = $task_log->where(['task_id'=>$v])->where('status=1 OR status=2')->cache(false)->fetchSql(true)->count();var_dump($count);die;
        // if($count <= 0){
        //     $Model->where(['id'=>$v])->save(['status'=>3,'ratio'=>100]);
        // }else{
        //   $total = $task_log->where(['task_id'=>$v])->count();
        //   $ratio = (1- round($count/$total,2))*100;
        //   if($ratio > 100) $ratio = 100;
        //     $Model->where(['id'=>$v])->save(['ratio'=>$ratio]);
        // }
    }

}
