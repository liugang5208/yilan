<?php

namespace Home\Controller;

use Think\Controller;
use Think\Log;
class CommandController extends Controller {

      public function run(){
           $data = I("post.");
          
           if(!$data){
               return get_op_put(1, "112");
           }
             Log::record(111111111111, 'DEBUG');
          Log::record($data['new_cate_id'], 'DEBUG');
           $blwares = D("Home/NewCate", "Opera");
           $run['new_cate_id'] = $data['new_cate_id'];
           $run['type'] = 0;
           $blwares->runs($run);
           return get_op_put(1, "11");
      }

}
