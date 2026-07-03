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
        ignore_user_abort(true);  // client 断开后 PHP 继续执行
        set_time_limit(3000);

        $task_log = M('task_log');
        $Model    = M('task');
        $blwares  = D("Home/NewCate", "Opera");

        // 重置超时卡住的 task_log（30 分钟内未完成的重置为待处理）
        $stuckTime = time() - 1800;
        $task_log->where("hand_time <= $stuckTime")->where(['status' => 2])->save(['status' => 1]);

        // 持续消费，直到没有待处理的 task_log
        do {
            $list = $Model->alias('a')->join('task_log b ON b.task_id = a.id')
                ->where('a.type=1 AND (a.status=1 OR a.status=2) AND b.status=1')
                ->order('a.id asc, b.id asc')
                ->field('a.id, a.status, b.id as task_log_id, b.new_cate_id')
                ->limit(5)
                ->select();

            if (empty($list)) break;

            // 标记 task 和 task_log 为处理中
            $taskIds = [];
            foreach ($list as $v) {
                if (!in_array($v['id'], $taskIds)) {
                    $taskIds[] = $v['id'];
                    $Model->where(['id' => $v['id']])->where(['status' => 1])->save(['status' => 2]);
                }
                $task_log->where(['id' => $v['task_log_id']])->save(['status' => 2, 'hand_time' => time()]);
            }

            // 执行更新并标记完成
            foreach ($list as $v) {
                try {
                    $blwares->runs(['new_cate_id' => $v['new_cate_id']]);
                } catch (Exception $e) {
                    // 继续处理下一条，不中断整体流程
                }
                $task_log->where(['id' => $v['task_log_id']])->save(['status' => 3, 'end_time' => time()]);
            }

            // 更新 task 进度
            foreach ($taskIds as $tid) {
                $pending = $task_log->where(['task_id' => $tid])->where('status=1 OR status=2')->count();
                if ($pending <= 0) {
                    $Model->where(['id' => $tid])->save(['status' => 3, 'ratio' => 100]);
                } else {
                    $total = $task_log->where(['task_id' => $tid])->count();
                    $ratio = min(100, (1 - round($pending / $total, 2)) * 100);
                    $Model->where(['id' => $tid])->save(['ratio' => $ratio]);
                }
            }

        } while (true);

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
