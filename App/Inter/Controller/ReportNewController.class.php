<?php

namespace Inter\Controller;

#use Think\Controller;

class ReportNewController extends CommController {
    
    public function checkReport(){
         $post = $this->param;
         if (!$post['uid']) {
            return get_op_put(0, "uid不能为空");
        }
         $report = M('report');
         $count = $report->where(["uid" => $post["uid"], "status" => 1])->order('sort asc,id asc')->count();
         $data['report_count'] = $count;
         return get_op_put(1, "成功",$data);
    }
    
    public function changeTicket() {
        $model = M('report');
        $p = $this->param;
        // $p = I('get.');
        if (!$p['uid']) {
            return get_op_put(0, "uid不能为空");
        }
        if (!$p['ticket'] && $p['ticket'] != 0) {
            return get_op_put(0, "ticket不能为空");
        }
        $where = ["uid" => $p['uid'],"status" => 1];
        $list = $model->where($where)->order('sort asc,id asc')->select();
        $up_data['ticket'] = $p['ticket'];
        
        M('report_temp')->where(['uid'=>$p['uid']])->save($up_data);
        
        if($up_data['ticket'] == 0){
            $up_data['ticket_fee'] = 1;
            $model->where(['uid'=>$p['uid']])->save($up_data);
            return get_op_put(1, "修改成功");
        }
        
        $plate_conts_blank = M("plate_conts_blank");
        $plate_conts_logs = M("plate_conts_logs");
        foreach ($list as $k=>$v){
            $logs = $plate_conts_logs->where(['id'=>$v['logs_id']])->field('cat_index')->find();
            if($logs){
                $where2['pid']=$v['cont_id'];
                $where2['cat_index']=$logs['cat_index'];
                $blank_info = $plate_conts_blank->where($where2)->field('ticket_nor,ticket_person')->find();
                if($blank_info){
                    if($up_data['ticket'] == 0){
                    $up_data['ticket_fee'] = 1;
                    }elseif($up_data['ticket'] == 1){
                        $up_data['ticket_fee'] = 1 + $blank_info['ticket_nor']/100;
                    }elseif($up_data['ticket'] == 2){
                        $up_data['ticket_fee'] = 1 + $blank_info['ticket_person']/100;
                    }
                    $info = $model->where(['id'=>$v['id']])->save($up_data);
                }
                
            }
            
        }
        
        
        
        #
        return get_op_put(1, "修改成功");
    }
    
    public function asdf(){
        $report = M("report");
        $where = ["uid" => 56, "status" => 1];
        $list = $report->where($where)->select();
         return get_op_put(1, "操作成功",$list);
    }
    
    public function reportAgain(){
         $p = $this->param;
         if (!$p['id']) {
            return get_op_put(0, "id不能为空");
         }
         if (!$p['uid']) {
            return get_op_put(0, "uid不能为空");
         }
         $uid = $p['uid'];
         $user = M('users')->where(['id'=>$uid])->find();
         if($user['is_report'] != 1) return get_op_put(0, "您没有权限");
         
         $report = M("report");
         $report_temp = M("report_temp");
         $report_info = M("report_info");
         $report_info_log = M("report_info_log");
         $report->startTrans();
         $report_info_data = $report_info->where(['id'=>$p['id']])->find();
         $report_info_log_data = $report_info_log->where(['repid'=>$report_info_data['id']])->select();
         
         $report_temp_data['uid'] = $uid;
         $report_temp_data['trans_bids'] = $report_info_data['trans_bids'];
         $report_temp_data['ratio'] = $report_info_data['ratio'];
         $report_temp_data['ticket'] = $report_info_data['ticket'];
         $report_temp_data['ticket_fee'] = $report_info_data['ticket_fee'];
         $report_temp_data['check_type'] = $report_info_data['check_type'];
         $report_temp_data['trans_type'] = $report_info_data['trans_type'];
         $report_temp_data['fees_out'] = $report_info_data['fees_out'];
         $report_temp_data['pack_recyle'] = $report_info_data['pack_recyle'];
         $report_temp_data['rep_comp'] = $report_info_data['rep_comp'];
         $report_temp_data['use_comp'] = $report_info_data['use_comp'];
         $report_temp_data['pro_time'] = $report_info_data['pro_time'];
         $report_temp_data['rep_user'] = $report_info_data['rep_user'];
         $report_temp_data['rep_phone'] = $report_info_data['rep_phone'];
         $report_temp_data['rep_date'] = $report_info_data['rep_date'];
         $report_temp_data['tags'] = $report_info_data['tags'];
         $report_temp_data['question_comp'] = $report_info_data['question_comp'];
         $report_temp_data['project_comp'] = $report_info_data['project_comp'];
         $report_temp_data['logo'] = $report_info_data['logo'];
         $report_temp_data['comp_title'] = $report_info_data['comp_title'];
         
        //  $tmplevel = R('Carts/getUser', array($post["uid"]));//var_dump($tmplevel);die;
        //  $up = $tmplevel["up_level"];
        //  $tmplevel = R('Carts/getUser', array($uid));
        //  $up_level = $tmplevel['up_level'];
         $report_data=[];
         foreach ($report_info_log_data as $k=>$v){
             $report_data[$k]['uid'] = $uid;
             $report_data[$k]['types'] = $v['types'];
             $report_data[$k]['cont_id'] = $v['cont_id'];
             $report_data[$k]['logs_id'] = $v['logs_id'];
             $report_data[$k]['good_id'] = $v['good_id'];
             $report_data[$k]['nums'] = $v['nums'];
             $report_data[$k]['ticket'] = $v['ticket'];
             $report_data[$k]['ticket_fee'] = $v['ticket_fee'];
             $report_data[$k]['status'] = 1;
             $report_data[$k]['uptimes'] = time();
             $report_data[$k]['times'] = time();
             $report_data[$k]['unit'] = $v['unit'];
             $report_data[$k]['remark'] = $v['remark'];
            //  $report_data[$k]['price'] = $v['price'];
             $report_data[$k]['trans'] =$v['trans'];
             $report_data[$k]['trans_type'] = $v['trans_type'];
             $report_data[$k]['up'] = $v['up'];
             $report_data[$k]['sort'] = $v['sort'];
            //  $report_data[$k]['attr1'] = $v['attr1'];
            //  $report_data[$k]['attr2'] = $v['attr2'];
            //  $report_data[$k]['attr3'] = $v['attr3'];
             $attr1 = explode(':',$v['attr1']);
             $attr2 = explode(':',$v['attr2']);
             $attr3 = explode(':',$v['attr3']);
             $attr1_value = '';
             foreach ($attr1 as $k1=>$v1){
                 if($k1>0){
                     $attr1_value .=$v1; 
                 }
             }
             $attr2_value = '';
             foreach ($attr2 as $k2=>$v2){
                 if($k2>0){
                     $attr2_value .=$v2; 
                 }
             }
             $attr3_value = '';
             foreach ($attr3 as $k3=>$v3){
                 if($k3>0){
                     $attr3_value .=$v3; 
                 }
             }
             $report_data[$k]['attr1'] = $attr1_value;
             $report_data[$k]['attr1_key'] = $attr1[0];
             $report_data[$k]['attr2'] = $attr2_value;
             $report_data[$k]['attr2_key'] = $attr2[0];
             $report_data[$k]['attr3'] = $attr3_value;
             $report_data[$k]['attr3_key'] = $attr3[0];
             $logs = getplateContslogs($v["logs_id"]);
             if($logs){
                 $price = $logs['market'];
                 $tmplevel = R('Carts/getUser', array($uid,$logs['_cate']['float_cat'],$logs['_cate']['id']));
                if(!empty($tmplevel['up_level'])){
                    $price = round((1+$tmplevel["up_level"]/100)*$price,2);
               
                }
                //  $price = $v['market'];
                //  if($up_level){
                //      $price = round((1+$up_level/100)*$price,2);
                //  }
                //  if($v['ticket_fee']){
                //      $price = round($v['ticket_fee']*$price,2);
                //  }
                // $price = $v['price'];
                 
                 $report_data[$k]['price'] = $price;
             }else{
                 return get_op_put(0, "未找到商品[LORR22]");
                 $report_data[$k]['price'] = $v['market'];
             }
             
        // var_dump($logs);die;
         }
        //  var_dump($uid);
        if ($report->where(['uid'=>$uid])->delete() === false) {
            $report->rollback();
            return get_op_put(0, "创建报价单失败[SF]");
        }
        if ($report_temp->where(['uid'=>$uid])->delete() === false) {
            $report->rollback();
            return get_op_put(0, "创建报价单失败[SF2]");
        }
        if (!$report_temp->add($report_temp_data)) {
            $report->rollback();
            return get_op_put(0, "报价单失败[LORR]");
        } 
        // return get_op_put(1, "创建报价单失败[4545]",$report_data);
        if (!$report->addAll($report_data)) {
            $report->rollback();
            return get_op_put(0, "报价单失败[LOR]");
        }
        #
        $report->commit();
        
         
         
         return get_op_put(1, "操作成功");
    }
    
    public function change2() {
        $model = M('report_temp');
        // $p = $this->param;
        $p = I('get.');
        if (!$p['uid']) {
            return get_op_put(0, "uid不能为空");
        }
        // if (!$p['ids']) {
        //     return get_op_put(0, "ids不能为空");
        // }
        $info = $model->where(['uid'=>$p['uid']])->find();
        
        if(!$info){
           $model->add(['uid'=>$p['uid']]);
        }
        $tmp = file_get_contents('php://input', true);
        $param = json_decode($tmp, true);
        
        #
        // if (!$model->where("uid='" . $p["uid"] . "'")->save($p)) {
        //     return get_op_put(0, "没有修改", $param);
        // }
        
        if (!$model->create($p, 2)) {
            return get_op_put(0, $model->getError());
        }
        $model->where("uid='" . $p["uid"] . "'")->save();
        #
        return get_op_put(1, "修改成功");
    }
    
    public function change() {
        $model = M('report_temp');
        $p = $this->param;
        // $p = I('get.');
        if (!$p['uid']) {
            return get_op_put(0, "uid不能为空");
        }
        // if (!$p['ids']) {
        //     return get_op_put(0, "ids不能为空");
        // }
        $info = $model->where(['uid'=>$p['uid']])->find();
        
        if(!$info){
           $model->add(['uid'=>$p['uid']]);
        }
        $tmp = file_get_contents('php://input', true);
        $param = json_decode($tmp, true);
        
        #
        // if (!$model->where("uid='" . $p["uid"] . "'")->save($p)) {
        //     return get_op_put(0, "没有修改", $param);
        // }
        
        if (!$model->create($p, 2)) {
            return get_op_put(0, $model->getError());
        }
        $model->where("uid='" . $p["uid"] . "'")->save();
        #
        return get_op_put(1, "修改成功");
    }

    /**
     * 
     */
    public function cartadd() {
        $report = M("report");
        $post = $this->param;
        
        $user = M('users')->where(['id'=>$post["uid"]])->find();
         if($user['is_report'] != 1) return get_op_put(0, "您没有权限");
        #
        $where["uid"] = $post["uid"];
        $where["types"] = $post["types"];
        $where["cont_id"] = $post["cont_id"];
        $where["logs_id"] = $post["logs_id"];
        $where["status"] = 1;
        #
        $count = $report->where(["uid" => $post["uid"], "status" => 1])->count();
        $ratio = $this->lists_ratio($post["uid"]);
        if ($count > 0) {
            if ($ratio["ticket"] != $post["ticket"]) {
                $msg = "报价单已存在部分商品报价内容，当前商品税率与现有报价单的【商品税率】不相符，请调整当前商品税率后在进行添加操作";
                return get_op_put(0, $msg . "，或者您可以先清空报价单后在进行当前商品的添加操作，谢谢!", json_encode($ratio) . "=" . $post["ticket_fee"]);
            }
        }
        #
        if ($post["types"] > 0) {
            return $this->cartadd_up_log($where, $post);
        }
        $where["good_id"] = 0;
        $res = $this->cartadd_single($where, $post);
        #
        return get_op_put($res["status"], $res["msg"], $res["data"]);
    }

    /**
     * 单个商品
     */
    public function cartadd_single($where, $post) {
        $report = M("report");
        #
        $info = NULL;
        $plate_conts = M("plate_conts");
        #$info = $report->where($where)->find();
        if ($info == NULL) {
            $where["nums"] = $post["nums"];
            $where["ticket"] = $post["ticket"];
            $where["ticket_fee"] = $post["ticket_fee"];
            $where["uptimes"] = 0;
            $where["times"] = time();
            
            $conts = $plate_conts->find($post["cont_id"]);
            $logs = getplateContslogs($post["logs_id"]);
            $where['attr1'] = $logs['value_0'];
            $where['attr2'] = $logs['value_1'];
            $where['attr3'] = $logs['value_2'];
            // $where['attr1'] = $logs['key_0'].':'.$logs['value_0'];
            // $where['attr2'] = $logs['key_1'].':'.$logs['value_1'];
            // $where['attr3'] = $logs['key_2'].':'.$logs['value_2'];
            $where['attr1_key'] = $logs['key_0'];
            $where['attr2_key'] = $logs['key_1'];
            $where['attr3_key'] = $logs['key_2'];
            $where['price'] = $logs["market"];
            $where['unit'] = $conts["g_unit"];
            // $where['trans'] = $conts["trans"];
            
            $tmplevel = R('Carts/getUser', array($post["uid"],$logs['_cate']['float_cat'],$logs['_cate']['id']));//var_dump($tmplevel);die;
            // $where['up'] = $tmplevel["up_level"];
            if(!empty($tmplevel['up_level'])){
                $where['price'] = round((1+$tmplevel["up_level"]/100)*$where['price'],2);
           
            }
            // if(!empty($where['ticket_fee'])){
            //     $where["price"] = round($where["ticket_fee"]*$where['price'],2);
            // }
            
            $e = $report->where(["uid" => $post["uid"], "status" => 1])->order('sort desc')->find();
            if($e){
                $where['sort'] = $e['sort']+1;
            }else{
                $where['sort'] = 1;
            }
            
            
            if (!$report->add($where)) {
                return get_op_res(0, "添加数据失败");
            }
            //更新temp
            $model = M('report_temp');
            $info = $model->where(['uid'=>$post['uid']])->find();
        
            if(!$info){
               $model->add(['uid'=>$post['uid'],'ticket'=>$post["ticket"],'ticket_fee'=>$post["ticket_fee"]]);
            }
            
            return get_op_res(1, "添加数据成功");
        }
        #
        $save = ["nums" => $post["nums"], "status" => $post["status"], "uptimes" => time()];
        if (!$report->where($where)->save($save)) {
            return get_op_res(0, "更新数据失败");
        }
        return get_op_res(1, "更新数据成功");
    }

    /**
     * 加入购物车-更新商品记录
     */
    private function cartadd_up_log($where, $post) {
        #
        foreach ($post["report_logs"] as $k => $v) {
            if ($v["nums"] < 1) {
                continue;
            }
            
            $where["good_id"] = $v["id"];
            $post["nums"] = $v["nums"];
            $res = $this->cartadd_single($where, $post);
            if ($res["status"] != 1) {
                return get_op_put(0, "更新数据失败");
            }
        }
        return get_op_put(1, "更新数据成功");
    }

    /**
     * 移除报价
     * @return type
     */
    public function cartdel() {
        $report = M("report");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        if (!$report->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        return get_op_put(1, "删除数据成功");
    }

    /**
     * 清空报价
     * @return type
     */
    public function clearall() {
        $report = M("report");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        if (!$report->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        $report_temp = M("report_temp");
        $report_temp->where(['uid'=>$post["uid"]])->delete();
        return get_op_put(1, "删除数据成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 报价单列表
     */
    public function lists() {
        //  return get_op_put(0, "创建报价单失败");
        $report = M("report");
        $post = $this->param;
        // $post =  I('');
        #
        $report_temp = M('report_temp')->where(['uid'=>$post['uid']])->find();
        if($post["ratio"] ==0 ){
            $post["ratio"] = $report_temp['ratio'];
        }
        
        if($report_temp['logo']){
            $report_temp['logo'] = C("WEBIMG").$report_temp['logo'];
        }
        
        $tmplevel = R('Carts/getUser', array($post["uid"]));
        $ratio = 1 + $post["ratio"] / 100;
        $list = $report->where(["uid" => $post["uid"], "status" => 1])->order('sort asc,id asc')->select();
        #
        $total = 0;
        foreach ($list as $k => $v) {
            $tmp = $v["types"] > 0 ? $this->lists_more($v) : $this->lists_sigl($v);
            // $tmp["attr1"] = $v["attr1"];
            // $tmp["attr2"] = $v["attr2"];
            // $tmp["attr3"] = $v["attr3"];
            // $tmp["unit"] = $v["unit"];
            // $tmp["price"] = $v["price"];
            // $tmp["attr1_key"] = $v["attr1_key"];
            // $tmp["attr2_key"] = $v["attr2_key"];
            // $tmp["attr3_key"] = $v["attr3_key"];
            // $tmp["up"] = $v["up"];
            // $tmp["trans"] = $v["trans"];
            // $tmp["trans_type"] = $v["trans_type"];
            // $tmp["price"] = $tmp['price'];
            // var_dump($tmp['price']);
            // var_dump(1+$tmp["up"]/100);
            // var_dump($v["ticket_fee"]);
            // var_dump($ratio);
            // var_dump(1+$tmplevel["up_level"]/100);
            // var_dump(((1+$tmp["up"]/100) * $v["ticket_fee"] * $ratio*(1+$tmplevel["up_level"]/100)));die;
            $price = round($tmp["price"] * ((1+$tmp["up"]/100) * $v["ticket_fee"] * $ratio), 2);
            // var_dump($price);
            // round((1+$tmplevel["up_level"]/100)*$where['price'],2);
            $change_price = $price > 0?$price:0;
            $tmp["change_price"] = $change_price;
            // $tmp["change_price"] = $tmp["price"];
            // $tmp["total"] = round($change_price * $tmp["nums"], 2);
            $tmp["total"] = round($change_price * $tmp["nums"], 2);
            $tmp["id"] = $v["id"];
            $tmp["sort"] = $v["sort"];
            $tmp["ticket_fee"] = $v["ticket_fee"];
           
            #
            $total = $total + $tmp["total"];
            $list[$k] = $tmp;
        }
        #
        $list_ratio = $this->lists_ratio($post["uid"]);
        
        $res = [
            "list" => $list,
            "total" => $total,
            "total_n" => num_to_rmb($total),
            "level" => $tmplevel["up"],
            "ratio" => $list_ratio["ratio"],
            "ticket" => $list_ratio["ticket"],
            "report_temp"=>$report_temp,
        ];
        #
        return get_op_put(1, "获取数据成功", $res);
    }

    /**
     * 获取发票比率
     */
    private function lists_ratio($uid) {
        $report = M("report");
        #
        $list = $report->where(["uid" => $uid])->group("ticket_fee,ticket")->find();
        #
        return ["ticket" => $list["ticket"], "ratio" => $list["ticket_fee"]];
    }

    /**
     * 单个商品
     */
    private function lists_sigl($v) {
        if(!empty($v['attr1'])){
            $tmp["attr1"] =  $v["attr1"]?$v['attr1']:'';
            $tmp["attr2"] = $v["attr2"]?$v['attr2']:'';
            $tmp["attr3"] = $v["attr3"]?$v['attr3']:'';
            $tmp["unit"] = $v["unit"]?$v['unit']:'';
            $tmp["sort"] = $v["sort"]?$v['sort']:'';
            $tmp["price"] = $v["price"]?$v['price']:'';
            $tmp["nums"] = $v["nums"];
            $tmp["attr1_key"] = $v["attr1_key"]?$v['attr1_key']:'';
            $tmp["attr2_key"] = $v["attr2_key"]?$v['attr2_key']:'';
            $tmp["attr3_key"] = $v["attr3_key"]?$v['attr3_key']:'';
            
            $tmp["up"] = $v["up"]?$v['up']:0;
            if(empty($v['trans']) || $v['trans'] == NULL){
                $tmp["trans"] =' ';//var_dump(112);var_dump($tmp['trans']);die;
            }else{
                $tmp["trans"] = $v["trans"];
            }
            if(empty($v['trans_type']) || $v['trans_type'] == NULL){
                $tmp["trans_type"] =' ';
            }else{
                $tmp["trans_type"] = $v["trans_type"];
            }
            if(empty($v['remark']) || $v['remark'] == NULL){
                $tmp["remark"] =' ';
            }else{
                $tmp["remark"] = $v["remark"];
            } 
            // $tmp["trans"] = $v["trans"]?$v['trans']:'';
            // $tmp["trans_type"] = $v["trans_type"]?$v['trans_type']:'';
            // $tmp["remark"] = $v["remark"]?$v['remark']:'';
            return $tmp;
        }else{
             $plate_conts = M("plate_conts");
            #
            $conts = $plate_conts->find($v["cont_id"]);
            $logs = getplateContslogs($v["logs_id"]);
            #
            $res = array(
                "attr1" => $logs["key_0"].':'.$logs["value_0"],
                "attr2" => $logs["key_1"].':'.$logs["value_1"],
                "attr3" => $logs["key_2"].':'.$logs["value_2"],
                
                // "attr1_key" => $logs["key_0"],
                // "attr2_key" => $logs["key_1"],
                // "attr3_key" => $logs["key_2"],
                "unit" => $conts["g_unit"],
                "price" => $logs["market"],
                "nums" => $v["nums"],
                
                "up" => 0,
                "trans" => $logs["trans"]?$logs["trans"]:'',
                "trans_type" => '',
                "remark" => '',
                "sort" => $v["sort"],
            );
             return $res;
        }
        
        
       
       
    }

    /**
     * 多个商品
     */
    private function lists_more($v) {
        $plate_conts = M("plate_conts");
        #
        $conts = $plate_conts->find($v["cont_id"]);
        $logs = getplateContslogs($v["logs_id"]);
        $logsr = getplateContslogsr($v["good_id"]);
        #
        $res = array(
            "attr1" => $logs["key_0"] . ":" . $logs["value_0"],
            "attr2" => $logs["key_1"] . ":" . $logs["value_1"],
            "attr3" => $logs["key_2"] . ":" . $logs["value_2"],
            "unit" => $conts["g_unit"],
            "price" => $logsr["market"],
            "nums" => $v["nums"],
        );
        return $res;
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 创建报价单
     */
    public function lists_add() {
        $report = M("report");
        $report_info = D("report_info");
        $report_info_log = M("report_info_log");
        $post = $this->param;
        
         $user = M('users')->where(['id'=>$post["uid"]])->find();
         if($user['is_report'] != 1) return get_op_put(0, "您没有权限");
        
        $count = M("report_info")->order('id desc')->count();
        $elcc_sn = '';
        if($count > 9999999){
            $elcc_sn = $count;
        }else{
            $elcc_sn = str_pad($count, 7, '0', STR_PAD_LEFT);;
        }
        $post['elcc_sn'] = 'elccc'.$elcc_sn;
        #
        $post['times'] = time();
        if(!$post['rep_date']){
            $post['rep_date'] = date('Y-m-d');
        }
        
        $report_temp = M('report_temp')->where(['uid'=>$post['uid']])->find();
        $post['logo'] = $report_temp['logo'];
        $data = $report_info->create($post, 1);
        if (!$data) {
            return get_op_put(0, $report_info->getError());
        }
        $report_info->startTrans();
        $id = $report_info->add($data);
        if (!$id) {
            $report_info->rollback();
            return get_op_put(0, "创建报价单失败");
        }
        #获取价格比例
        $tmplevel = R('Carts/getUser', array($post["uid"]));
        $ratio = 1 + $data["ratio"] / 100;
        #
        $where = ["uid" => $post["uid"], "status" => 1];
        $list = $report->where($where)->order('sort asc,id asc')->select();
        foreach ($list as $k => $v) {
            $tmp = $v["types"] > 0 ? $this->lists_more($v) : $this->lists_sigl($v);
            #
            $list[$k]["repid"] = $id;
            $list[$k]["attr1"] = $tmp["attr1_key"].':'.$tmp['attr1'];
            $list[$k]["attr2"] = $tmp["attr2_key"].':'.$tmp['attr2'];
            $list[$k]["attr3"] = $tmp["attr3_key"].':'.$tmp['attr3'];
            // $list[$k]["attr1"] = $tmp["attr1"];
            // $list[$k]["attr2"] = $tmp["attr2"];
            // $list[$k]["attr3"] = $tmp["attr3"];
            $list[$k]["sort"] = $tmp["sort"];
            $list[$k]["unit"] = $tmp["unit"];
            $list[$k]["market"] = $tmp["price"];
            $list[$k]["remark"] = $tmp["remark"];
           
            $price = round($tmp["price"] * ((1+$tmp["up"]/100) * $v["ticket_fee"] * $ratio), 2);
            // $price = round($tmp["price"] * (1+$tmp["up"]/100) * $v["ticket_fee"] * $ratio, 2);
            $change_price = $price > 0?$price:0;
            
            $list[$k]["price"] = $change_price;
            $list[$k]["total"] = round($list[$k]["price"] * $tmp["nums"], 2);
            // $list[$k]["price"] = round($tmp["price"] * (1+$tmp["up"]) * $v["ticket_fee"] * $ratio, 2);
            // $list[$k]["total"] = round($list[$k]["price"] * $tmp["nums"], 2);
           
        } 
        // return get_op_put(0, "创建报价单失败[LOR]",$list);
        // var_dump($list[0]);
        // $a = $list[0];
        // unset($list);
        // $list[0]['repid'] = $a['repid'];
        // $list[0]['types'] = $a['types'];
        // $list[0]['cont_id'] = $a['cont_id'];
        // $list[0]['logs_id'] = $a['logs_id'];
        // $list[0]['good_id'] = $a['good_id'];
        // $list[0]['nums'] = $a['nums'];
        // $list[0]['ticket'] = $a['ticket'];
        // $list[0]['ticket_fee'] = $a['ticket_fee'];
        // $list[0]['status'] = $a['status'];
        // $list[0]['uptimes'] = $a['uptimes'];
        // $list[0]['times'] = $a['times'];
        // $list[0]['attr1'] = $a['attr1'];
        // $list[0]['attr2'] = $a['attr2'];
        // $list[0]['attr3'] = $a['attr3'];
        // $list[0]['unit'] = $a['unit'];
        // $list[0]['price'] = $a['price'];
        // $list[0]['trans'] =  $a['trans'];
        // $list[0]['trans_type'] ='';
        // $list[0]['remark'] = $a['remark'];
        // $list[0]['up'] = $a['up'];
        // $list[0]['market'] = $a['market'];
        // $list[0]['total'] = $a['total'];
        
        foreach($list as $k=>$v){
            foreach($v as $k2=>$v2){
                if($v2 == null){
                    $list[$k][$k2] = '';
                }
            }
        }
        
        if (!$report_info_log->addAll($list)) {
            $report_info->rollback();
            return get_op_put(0, "创建报价单失败[LOR]");
        }
        //   $report_info->rollback();
        // return get_op_put(0, "创建报价单失败[4545]");
        #
        if (!$report->where($where)->delete()) {
            $report_info->rollback();
            return get_op_put(0, "创建报价单失败[SF]");
        }
        
        $report_temp = M("report_temp");
        $res = $report_temp->where(['uid'=>$post["uid"]])->delete();
       
        $report_info->commit();
        return get_op_put(1, "获取数据成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 报价单列表
     */
    public function replist() {
        $report_info = D("report_info");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        $list = $report_info->where($where)->order("id desc")->select();
        foreach ($list as $k => $v) {
            $list[$k]["time_zone"] = date("Y-m-d H:i", $v["times"]);
        }
        #
        return get_op_put(1, "获取数据成功", $list);
    }

    /**
     * 移除报价
     * @return type
     */
    public function repdel() {
        $report_info = D("report_info");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        if (!$report_info->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        return get_op_put(1, "删除数据成功");
    }

    /**
     * 清空报价
     * @return type
     */
    public function repall() {
        $report_info = D("report_info");
        $post = $this->param;
        #
        $where["uid"] = $post["uid"];
        if (!$report_info->where($where)->delete()) {
            return get_op_put(0, "删除数据失败");
        }
        return get_op_put(1, "删除数据成功");
    }

    /**
     * 报价单详情
     */
    public function repinfos() {
        $report_info = D("report_info");
        $report_info_log = M("report_info_log");
        $post = $this->param;
        #
        $where["id"] = $post["id"];
        $info = $report_info->where($where)->find();
        #
        $tmplevel = R('Carts/getUser', array($post["uid"]));
        $list = $report_info_log->where(["repid" => $info["id"]])->select();
        #
        $total = 0;
        foreach ($list as $k => $v) {
            $total = $total + $v["total"];
        }
        #
        $res = [
            "list" => $list,
            "total" => $total,
            "total_n" => num_to_rmb($total),
            "level" => $tmplevel["up"],
            "ratio" => ($info["ticket_fee"] - 1) * 100,
            "info" => $info,
        ];
        return get_op_put(1, "获取数据成功", $res);
    }
    
    //生成excel
    public function outUrl(){
         $p = I('');
         if (!$p['id']) {
            return get_op_put(0, "id不能为空");
         }
         if (!$p['uid']) {
            return get_op_put(0, "uid不能为空");
         }
        $info = M('report_info')->where(['id'=>$p['id']])->where(['uid'=>$p['uid']])->find();
        if(!$info){
            return get_op_put(0, "数据不存在");
        }
        $log_info = M('report_info_log')->where(['repid'=>$info['id']])->select();
        $kid_num = 0;
        $goods_num = 0;
        $ticket_title = '';
        foreach ($log_info as $k=>$v){
            $goods_num +=$v['nums'];
            $kid_num ++;
        }
        if($info['ticket'] == 0){
            $ticket_title = '不含税票';
        }elseif($info['ticket'] == 1){
            $ticket_title = '普通发票';
        }elseif($info['ticket'] == 2){
            $ticket_title = '专用发票';
        }else{
             $ticket_title = $info['ticket'];
        }
        $table_str = '';
        foreach ($log_info as $k => $v) {
            $temp = $k+1;
            $table_str .= '<tr id="" class="">'
                . '<td class="text-center">' . $temp . '</td>'
                . '<td class="text-center">' . $v['attr1'].'<br>'.
                $v['attr2'].'<br>'.
                $v['attr3']
                . '</td>'
                . '<td class="text-center">' . $v['unit'] . '</td>'
                . '<td class="text-center">' . $v['nums'] . '</td>'
                . '<td class="text-center">' . $v['price'] . '</td>'
                . '<td class="text-center">' . $v['total'] . '</td>'
                . '<td class="text-center">' . $v['remark'] . '</td>'
                . '</tr>';
        }
        
        $up_data =[];
        $body = file_get_contents("./Public/files/report.html");
        
        $logo = '';
        if($info['logo']){
            $logo = '<img style="height:100px;" src="'.C("WEBIMG") . $info['logo'].'">';
        }
        $tags = '无';
        if($info['tags']){
            $tags = $info['tags'];
        }
        
        
        $body = str_replace('{$logo}', $logo, $body);
        $body = str_replace('{$comp_title}', $info['comp_title'], $body);
        $body = str_replace('{$rep_comp}', $info['rep_comp'], $body);
        $body = str_replace('{$rep_date}', $info['rep_date'], $body);
        $body = str_replace('{$question_comp}', $info['question_comp'], $body);
        $body = str_replace('{$elcc_sn}', $info['elcc_sn'], $body);
        $body = str_replace('{$project_comp}', $info['project_comp'], $body);
        $body = str_replace('{$ticket_title}', $ticket_title, $body);
        
        $body = str_replace('{$table_str}', $table_str, $body);
        
        $body = str_replace('{$count}', $kid_num, $body);
        $body = str_replace('{$goods_num}', $goods_num, $body);
        $body = str_replace('{$money}', $info['money'], $body);
        // $body = str_replace('{$ticket_title}', $info['ticket_title'], $body);
        $body = str_replace('{$big_money}', rmb_capital($info['money']), $body);
        $body = str_replace('{$trans_bids}', $info['trans_bids'], $body);
        $body = str_replace('{$check_type}', $info['check_type'], $body);
        $body = str_replace('{$pack_recyle}', $info['pack_recyle'], $body);
        $body = str_replace('{$trans_type}', $info['trans_type'], $body);
        $body = str_replace('{$fees_out}', $info['fees_out'], $body);
        $body = str_replace('{$rep_user}', $info['rep_user'], $body);
        $body = str_replace('{$rep_phone}', $info['rep_phone'], $body);
        $body = str_replace('{$tags}', $tags, $body);
        
        
// var_dump($body);die;
        
        $title = '报价单';
        if($info['elcc_sn']){
            $title = $info['elcc_sn'];
        }
        // if(!$info['excel_url']){
           $excel_url = $this->_htmlToExcel($body,$title,date('Y-m-d'));
           $up_data['excel_url'] = $excel_url;
        // }
        // if(!$info['img_url']){
           $height = 297;
           if($kid_num >= 13){
               $height = 50+20*$kid_num;
           }
           $img_url = $this->_htmlToPdf($body,$title,date('Y-m-d'),$height);
           $up_data['img_url'] = $img_url;
        // }
        if($up_data){
            M('report_info')->where(['id'=>$info['id']])->save($up_data);
        }
        $info2 = M('report_info')->where(['id'=>$info['id']])->find();
        $data['excel_url'] = C("WEBURL") . $info2['excel_url'];
        $data['img_url'] = C("WEBURL") . $info2['img_url'];
        $data['elcc_sn'] = $info['elcc_sn'];
        
        return get_op_put(1, "获取数据成功", $data);
    }
    
    public function excel(){
        $body = '<div>111222</div>';
        $data =$this->_htmlToExcel($body,'aaa',date('Y-m-d'));
        return get_op_put(1, "获取数据成功", $data);
    }
    
    public function _htmlToExcel($body = '', $title = '', $file_date = ''){
        if (empty($body)) {
            return;
        }
        // $body = file_get_contents("./Public/files/report.html");
        //把左边距替换掉
        // $content = str_replace('margin-left:100px;', '', $content);// es
     $content = '<html xmlns:v="urn:schemas-microsoft-com:vml" 
     xmlns:o="urn:schemas-microsoft-com:office:office"
     xmlns:x="urn:schemas-microsoft-com:office:excel"
     xmlns:w="urn:schemas-microsoft-com:office:word"
     xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
     xmlns="http://www.w3.org/TR/REC-html40">';
     $content .= '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name></x:Name><x:WorksheetOptions><x:Selected/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>';
        $content = $content . '<body>'.$body .'</body></html>';
        // $content = '<html 
        //     xmlns:o="urn:schemas-microsoft-com:office:office" 
        //     xmlns:w="urn:schemas-microsoft-com:office:word" 
        //     xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
        //     xmlns="http://www.w3.org/TR/REC-html40">
        //     <meta charset="UTF-8" />' . $content . '</html>';
        $fileName = '';
        if (empty($file_date)) {
            $file_date = date('Y年m月');
        }
        if (empty($fileName)) {
            $date = date('Ymd');
            $dir = './Public/files/htmlToExcel/' . $date . '/'; //保存到文件
            // var_dump($dir);
            is_dir($dir) or mkdir($dir, 0777, true);
// var_dump($dir);die;
            $uniqid = uniqid();
            $fileName = $dir . $title . '_' . $file_date.'_'.$uniqid . 'report.xls';
            $fileName2 = '/Public/files/htmlToExcel/' . $date . '/' . $title . '_' . $file_date.'_'.$uniqid . 'report.xls'; //保存到文件
        }
        if(file_exists($fileName)){
            unlink($fileName);
        }
        // ob_end_clean();
        $fp = fopen($fileName, 'w');
        fwrite($fp, $content);
        fclose($fp);
        file_put_contents($fileName, $content);
        return $fileName2;

    }
    
    public function toPng(){
        $body = '<div>111222</div>';
        $data =$this->_htmlToPdf($body);
        return get_op_put(1, "获取数据成功", $data);
    }
    
    public function _htmlToPdf($html = '',$title2='',$file_date = '',$height)
    {
        // require './extend/pdf/mpdf/mpdf/mpdf.php';
        // require_once './extend/autoload.php';
        //  require_once './extend/mpdf-8.1.0/src/Mpdf.php';
        try {

            // $mpdf = new \mPDF('zh-cn', 'A4', 0, '宋体', 20, 20);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => './Public/files/tmp','default_font' => 'SimSun',]);
            // $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
           
            // $html = file_get_contents("./Public/files/report.html");
            

// 设置自定义页面宽度和高度（单位为毫米）
            $width = 210; // 自定义宽度
            $height = $height; // 自定义高度
            $mpdf->AddPageByArray([
                'orientation' => 'P', // 页面方向：P 代表纵向，L 代表横向
                'newformat' => [$width, $height] // 页面尺寸
            ]);
            // $html = str_replace('margin-left:100px;', '', $html); // es
            //7.0 写法
            //        $mpdf = new \mPDF(['utf-8', 'A4', 16, '', 10, 10, 15, 1]);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
       
            
            $mpdf->WriteHTML($html);
            
            // $mpdf->AddPage(); // 添加新页面
            // $mpdf->WriteHTML($html); // 将内容写入新页面

            // $mpdf->Output(); //直接输出到页面
            $date = date('Ymd');
            $dir = './Public/files/htmlToPdf/' . $date . '/'; //保存到文件
            is_dir($dir) or mkdir($dir, 0777, true);
            $title = $title2. '_' . $file_date.'_'.uniqid() . 'report.pdf';
            $fileName = $dir . $title;
            $fileName2 = '/Public/files/htmlToPdf/' . $date . '/' .$title; //保存到文件

            $mpdf->Output($fileName);
            $extend  =  pathinfo($fileName);
            $extend  =  strtolower($extend["extension"]);
          
            $file  =  fopen($fileName, "rb");
            // Header("Content-type:  application/octet-stream ");
            // Header("Accept-Ranges:  bytes ");
            // Header("Content-Disposition:  attachment;  filename= $title");
            // while (!feof($file)) {
            //     echo fread($file, 8192);
            //     ob_flush();
            //     flush();
            // }
            // fclose($file);
            $uniqid = uniqid();
            $png = './Public/files/pdfToPng/' . $date . '/' .$title2. '_' . $file_date.'_'.$uniqid. 'report.jpg'; //保存到文件
            $fileName3 = '/Public/files/pdfToPng/' . $date . '/' .$title2. '_' . $file_date.'_'.$uniqid. 'report.jpg'; //保存到文件
            $dir = './Public/files/pdfToPng/' . $date . '/'; //保存到文件
            is_dir($dir) or mkdir($dir, 0777, true);
            $this->_pdf2png('./'.$fileName2,$png);
            return $fileName3;
        } catch (\Exception $e) {var_dump($e->getMessage());
            return false;
        }
    }
    function _pdf2png($PDF, $PNG, $w=200, $h=200){//var_dump($PNG);var_dump($PDF);
        if(!extension_loaded('imagick')){ var_dump(23232);
           return false;
        }
        if(!file_exists($PDF)){ var_dump(44444);var_dump($PDF);
          return false;
        }
        
        $im = new \Imagick();
        
        $im->setResolution($w,$h); //设置分辨率
        $im->setCompressionQuality(50);//设置图片压缩的质量
        
        $im->readImage($PDF); 
        $im->setImageBackgroundColor('white'); // 设置背景颜色为白色

        $im->flattenImages(); // 将所有页面合并为单个图像
        $im->setImageOpacity(1);
        
        $im -> resetIterator();
        $imgs = $im->appendImages(true);
        $imgs->setImageFormat("jpg");
        $img_name = $PNG;
        $imgs->writeImage($img_name);
        $imgs->clear();
        $imgs->destroy();
        $im->clear();
        $im->destroy();
        // echo $imgs->getException();
        return $img_name;
    }
    
//     $pdfFile = \'path/to/file.pdf\';
// $imagick = new Imagick();
// $imagick->readImage($pdfFile);
// // 设置图片宽度和高度
// $imagick->setImageFormat(\'jpg\');
// $imagick->setImageUnits(Imagick::RESOLUTION_PIXELSPERINCH);
// $imagick->setResolution(300, 300);
// $imagick->setCompressionQuality(100);
// // 获取PDF总页数
// $totalPages = $imagick->getNumberImages();
// // 设置每页生成图片的宽度和高度
// $pageWidth = 800;
// $pageHeight = 600;
// // 遍历PDF的每一页，并将其转换为图片
// for ($i = 0; $i < $totalPages; $i++) {
//     $imagick->setIteratorIndex($i);
//     $imagick->setImageFormat(\'jpeg\');
//     $imagick->setImageCompressionQuality(100);
//     $imagick->resizeImage($pageWidth, $pageHeight, Imagick::FILTER_LANCZOS, 1);
//     $imagick->writeImage(\"output/image_{$i}.jpg\");
// }

    // function pdf2png($from_path,$target_path){
    //     try{
    //         $img = new Imagick();
    //         $img->setCompressionQuality(100);
    //         $img->setResolution(120,120);
    //         $img->readImage($from_path);
    //         $canvas = new Imagick();
    //         $imgNum = $img->getNumberImages();
    //         foreach ($img as $k => $sub){
    //             $sub->setImageFormat('png');
    //             $sub->stripImage();
    //             $sub->trimImage(0);
    //             $width = $sub->getImageWidth() + 10;
    //             $height = $sub->getImageHeight() + 10;
    //             if ($k + 1 == $imgNum) $height += 10;
    //             $canvas->newImage($width,$height,new ImagickPixel('white'));
    //             $canvas->compositeImage($sub,Imagick::COMPOSITE_DEFAULT,5,5);
    //         }
    //         $canvas->resetIterator();
    //         $canvas->appendImages(true)->writeImage($target_path);
    //         return true;
    //     }catch (Exception $e){
    //         echo $e->getMessage();
    //         echo $e->getTraceAsString()
    //         ;return false;
    //     }//pdf文件转换为一张图片

}
