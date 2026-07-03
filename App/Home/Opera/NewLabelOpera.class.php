<?php

namespace Home\Opera;
use Think\Log;
/**
 * Description of BlwaresOpera
 * 更新板块商品
 * @author Administrator
 */
class NewLabelOpera {

    private $param;

    private $lists;
    private $taskId;
    /**
     * 入口
     */
    public function runs($param, $taskId = 0, $fireAsync = true) {
        $this->param = $param;
        if($taskId > 0) $this->taskId = $taskId;
        $result = $this->setListGoods();
        if ($fireAsync) {
            $this->asyncTriggerTask();
        }
        return $result;
    }

    /**
     * 批量写完 task_log 后统一触发一次（供批量场景调用）
     */
    public function triggerAsync() {
        $this->asyncTriggerTask();
    }

    /**
     * 异步触发 Inter/Resps/task 执行 task_log 队列
     * 通过 shell exec + & 后台运行，完全不占用 PHP-FPM worker
     * 从当前请求的 HTTP_HOST 动态构建 URL，自动兼容本地/测试/生产环境
     */
    /**
     * 异步触发 Inter/Resps/task（fire-and-forget）
     * exec/shell_exec 被禁用时自动降级为 PHP curl 超短超时
     */
    private function asyncTriggerTask() {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost:8088';
        $url    = $scheme . '://' . $host . '/Inter/Resps/task.html';

        if (function_exists('exec')) {
            // 优先：shell exec 后台运行，完全不占 FPM worker
            $cmd = "curl -s -X POST " . escapeshellarg($url) . " > /dev/null 2>&1 &";
            exec($cmd);
        } else {
            // 降级：PHP curl 超短超时（100ms），client 断开后 server 端 ignore_user_abort 继续跑
            $ch = curl_init($url);
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => '',
                CURLOPT_TIMEOUT_MS     => 100,
                CURLOPT_NOSIGNAL       => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ));
            @curl_exec($ch);
            curl_close($ch);
        }
    }



    /**
     * 列表商品
     */
    private function setListGoods() {
        $new_label_id = $this->param['new_label_id'];
        
        $info = M('new_label')->where(['id'=>$new_label_id])->find();
        $price = $info['price'];
        
        
        
        $new_cate = M("new_cate");
        $list = $new_cate->where(['new_label_id'=>$new_label_id])->select();
        $new_cate->where(['new_label_id'=>$new_label_id])->save(['price'=>$price]);
        $new_cate_form = M("new_cate_form");
        
        foreach ($list as $k=>$v){
           $cate_form_list = $new_cate_form->where(['new_cate_id'=>$v['id']])->select();
           foreach ($cate_form_list as $k2=>$v2){
                $temp['price'] = $price;
                $temp['calc_base_price'] = bcmul((string)$v2['weight'],(string)$price,4);
                
                // $end_price = bcmul((string)$temp["calc_base_price"],(string)$v2['extra_ratio'],4);
                // $end_price = bcadd($temp["calc_base_price"],$end_price,4);
                $end_price = bcadd($temp["calc_base_price"],(string)$v2['extra_ratio'],4);
                $temp['end_price'] = $end_price;
                $new_cate_form->where(['id'=>$v2['id']])->save($temp);
           }
        }
        // var_dump(111);
        // var_dump($list);die;
        // $i = 1;
        $blwares = D("Home/NewCate", "Opera");
        // $list= [];
        // $list[0]['id'] = 189;
          Log::record(22222222222, 'DEBUG');
           Log::record($new_label_id, 'DEBUG');
          Log::record(implode(',',array_column($list,'id')), 'DEBUG');
          
          $taskLog = M("task_log");
          $task = M("task");
          if($list){
              $url = 'http://47.108.239.113/Home/Command/run';
                $mh = curl_multi_init();
                $chs = [];
                $taskId = $this->taskId;
                $taskLogData = [];
              foreach($list as $k=>$v){
                // var_dump($v);
                //更新商品价格
                $run['new_cate_id'] = $v['id'];
                $taskLogData[$k]['task_id'] = $taskId;
                $taskLogData[$k]['new_cate_id'] = $v['id'];
                $taskLogData[$k]['status'] = 1;
                
                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // // 设置为POST请求
                // curl_setopt($ch, CURLOPT_POST, true);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($run));

                // curl_multi_add_handle($mh, $ch);
                // $chs[$i] = $ch;
                
            
                //   Log::record(1156666667, 'DEBUG');
                //   Log::record($v['id'], 'DEBUG');
                // cUrl('http://47.108.239.113/Home/Command/run',$run);
                //   Log::record(115666666, 'DEBUG');
                //   Log::record($v['id'], 'DEBUG');
               
                // $blwares->runs($run);
                // $i++;break;
            }//var_dump($i);
            if($taskId > 0 && $taskLogData){
               if($taskLogData){
                   $taskLog->addAll($taskLogData);
               }else{
                   $task->where(['id'=>$taskId])->save(['status'=>3,'ratio'=>100]);
               }
               
            }
            
            // $running = null;
            // do {
            //     curl_multi_exec($mh, $running);
            // } while ($running > 0);
             
            // foreach ($chs as $ch) {
            //     $result = curl_multi_getcontent($ch);
            //     curl_multi_remove_handle($mh, $ch);
            //     curl_close($ch);
            //     // echo $result; // 处理结果
            // }
             
            // curl_multi_close($mh);
          }
         // 设置脚本在用户断开连接后继续运行，并移除执行时间限制
        
        
       return true;
          
    }


  

}
