<?php

namespace Home\Controller;

#use Think\Controller;

class UsersController extends CommController {

    public function index() {
        $users = M("users");
        $users_level = M("users_level");
        $get = I("get.");
        #
        $get["phone"] != null ? $where["phone"] = array("like", "%" . $get["phone"] . "%") : null;
        #
        $list = boPage($users, $where, "id desc");
        $this->assign("list", $list);
        $this->assign("level", $users_level->select());
        $this->display();
    }

    /**
     * 更新归属地
     */
    public function index_posi() {
        $users = M("users");
        #
        $list = $users->where('id','>',0)->where('locate IS NULL or locate = ""')->field('id,phone')->select();//var_dump($list);die;
        foreach ($list as $k => $v) {
            // $area = getPhoneArea($v["phone"]);
            $pos = strpos($v['phone'], "注销");
            if ($pos !== false) {
                continue;
            }
            $area = $this->_check($v['phone']);
            if($area){
                $save = ["locate" => $area, "uptimes" => time()];
            #
                $users->where(["id" => $v["id"]])->save($save);
            }
            
        }
        echo '更新成功';
        // return get_op_put(1, null);
    }
    
    public function _check($mobile=''){
        error_reporting(E_ALL || ~E_NOTICE);
        $host = "http://plocn.market.alicloudapi.com";
        $path = "/plocn";
        $method = "GET";
        $appcode = "1c571be5cf5a46ce883b8637a7a7d3b6";//开通服务后 买家中心-查看AppCode
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "n=$mobile";
        $bodys = "";
        $url = $host . $path . "?" . $querys;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $out_put = curl_exec($curl);
        
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        list($header, $body) = explode("\r\n\r\n", $out_put, 2);
        if ($httpCode == 200) {
            // print("正常请求计费(其他均不计费)<br>");
            // print($body);
            $data = json_decode($body,true);
            if($data['code'] == 1){
                 return $data['city'];
            }
            print($mobile.'-'.$data['tips']);
            return '';
            print($data['tips']);
        } else {
            if ($httpCode == 400 && strpos($header, "Invalid Param Location") !== false) {
                print("参数错误");
            } elseif ($httpCode == 400 && strpos($header, "Invalid AppCode") !== false) {
                print("AppCode错误");
            } elseif ($httpCode == 400 && strpos($header, "Invalid Url") !== false) {
                print("请求的 Method、Path 或者环境错误");
            } elseif ($httpCode == 403 && strpos($header, "Unauthorized") !== false) {
                print("服务未被授权（或URL和Path不正确）");
            } elseif ($httpCode == 403 && strpos($header, "Quota Exhausted") !== false) {
                print("套餐包次数用完");
            } elseif ($httpCode == 403 && strpos($header, "Api Market Subscription quota exhausted") !== false) {
                print("套餐包次数用完，请续购套餐");
            } elseif ($httpCode == 500) {
                print("API网关错误");
            } elseif ($httpCode == 0) {
                print("URL错误");
            } else {
                print("参数名错误 或 其他错误");
                print($httpCode);
                $headers = explode("\r\n", $header);
                $headList = array();
                foreach ($headers as $head) {
                    $value = explode(':', $head);
                    $headList[$value[0]] = $value[1];
                }
                print($headList['x-ca-error-message']);
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function infos($id) {
        $users = M("users");
        #
        $info = $users->where(["id" => $id])->find();
        $info["p_name"] = getRegionName($info["prov"]);
        $info["c_name"] = getRegionName($info["city"]);
        $info["l_name"] = getRegionName($info["label"]);
        #
        $this->assign("info", $info);
        $this->display();
    }

    /**
     * 登录统计
     */
    public function logrs() {
        $users_logs = M("users_logs");
        $get = I("get.");
        #
        if ($get["phone"] != null) {
            $where["_string"] = "uid in (select id from users where phone like '%" . $get["phone"] . "%')";
        }
        #
        // $where["prov"] = array("=", null);
        $list = boPage($users_logs, $where, "id desc");
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 搜索记录
     */
    public function search() {
        $users_search = M("users_search");
        #
        $list = boPage($users_search, $where, "id desc");
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 禁止区域
     */
    public function label() {
        $users_label = M("users_label");
        $sysregion = M("sysregion");
        #
        $list = boPage($users_label, $where);
        #
        $this->assign("list", $list);
        $this->assign("region", $sysregion->where(["parent" => 1])->select());
        $this->display();
    }

    /**
     * 搜索记录
     */
    public function levels() {
        $users_level = M("users_level");
        #
        $list = boPage($users_level, $where);
        $this->assign("list", $list);
        $this->display();
    }

    ////////////////////////////////////////////////////////////////////////////

    public function mess() {
        $sys_msgs = M("sys_msgs");
        #
        $list = boPage($sys_msgs, $where);
        $this->assign("list", $list);
        $this->display();
    }

    public function mess_op() {
        $sys_msgs = M("sys_msgs");
        $users = M("users");
        $post = I("post.");
        #
        if ($post["title"] == null) {
            return get_op_put(0, "请输入标题");
        }
        if ($post["theme"] == null) {
            return get_op_put(0, "请输入主题");
        }
        if ($post["context"] == null) {
            return get_op_put(0, "请输入内容");
        }
        if ($post["color"] == null) {
            return get_op_put(0, "请选择颜色");
        }
        #
        $list = $users->select();
        $arr = [];
        set_time_limit(0);
        foreach ($list as $k => $v) {
            $arr[] = [
                "uid" => $v["id"], "types" => $post["types"], "title" => $post["title"], "theme" => $post["theme"],
                "context" => $post["context"], "i_read" => 0, "status" => 1, "uptimes" => 0,'color'=>$post['color'], "times" => time()
            ];
        }
        #
        if (!$sys_msgs->addAll($arr)) {
            return get_op_put(0, "添加失败");
        }
        return get_op_put(1, "添加成功");
    }
    //等级分类
    public function cats() {
        $users_cats = M("users_cats");
        $get = I("get.");
        #
        if ($get["id"] != null) {
            $where["ac_level"] = $get['id'];
        }
        
        // $where["prov"] = array("=", null);
        $cats = $users_cats->where($where)->select();
        $cats_end = [];
        foreach ($cats as $k=>$v){
            $cats_end[$v['plate_cats_id']] = $v;
        }
        $list = M('plate_cats')->select();
        foreach ($list as $k=>$v){
            $list[$k]['users_cats_up'] = 0;
            if(isset($cats_end[$v['id']])){
                $list[$k]['users_cats_up'] = $cats_end[$v['id']]['cats_up'];
            }
        }
        // return get_op_put(1, "操作成功",['list'=>$list]);
        $this->assign("list", $list);
        $this->assign("ac_level", $get['id']);
        $this->display();
    }
    public function cats_op() {
        $users_cats = M("users_cats");
        $post = I("post.");
        #
        if ($post["ac_level"] == null) {
            return get_op_put(0, "users_cats");
        }
        if ($post["plate_cats_id"] == null) {
            return get_op_put(0, "plate_cats_id");
        }
        if ($post["cats_up"] == null) {
            return get_op_put(0, "比例不能为空");
        }
        if(is_float($post['cats_up'])){
             return get_op_put(0, "比例必须是整数");
        }
        $cats_up = filter_var($post["cats_up"], FILTER_VALIDATE_INT);

        if ($cats_up === false) {
            return get_op_put(0, "比例必须是整数!");
        }
                
        $info = $users_cats->where(['ac_level'=>$post['ac_level'],'plate_cats_id'=>$post['plate_cats_id']])->find();
        if($info){
            $result = $users_cats->where(['id'=>$info['id']])->save(['cats_up'=>$post['cats_up']]);
        }else{
            $result = $users_cats->add(['ac_level'=>$post['ac_level'],'plate_cats_id'=>$post['plate_cats_id'],'cats_up'=>$post['cats_up']]);
        }
        #
        if ($result === false) {
            return get_op_put(0, "操作失败");
        }
        return get_op_put(1, "操作成功");
    }
    
     public function cats_op_form() {
        $users_cats = M("users_cats");
        $post = I("post.");
        $form = $post['form_data'];
        $ac_level = $post['ac_level'];
        // return get_op_put(1, "操作成功",$form);
        if ($ac_level == null) {
            return get_op_put(0, "参数错误");
        }
        foreach ($form as $k=>$v){
        
            if ($v["plate_cats_id"] == null) {
                return get_op_put(0, "plate_cats_id");
            }
            if ($v["cats_up"] == null) {
                return get_op_put(0, "比例不能为空");
            }
            if(is_float($v['cats_up'])){
                 return get_op_put(0, "比例必须是整数");
            }
            $cats_up = filter_var($v["cats_up"], FILTER_VALIDATE_INT);
    
            if ($cats_up === false) {
                return get_op_put(0, "比例必须是整数!");
            }
                    
            $info = $users_cats->where(['ac_level'=>$ac_level,'plate_cats_id'=>$v['plate_cats_id']])->find();
            if($info){
                $result = $users_cats->where(['id'=>$info['id']])->save(['cats_up'=>$v['cats_up']]);
            }else{
                $result = $users_cats->add(['ac_level'=>$ac_level,'plate_cats_id'=>$v['plate_cats_id'],'cats_up'=>$v['cats_up']]);
            }
            if ($result === false) {
                return get_op_put(0, "'第'. $k+1. '个比例设置操作失败'");
            }
        }
        #
        
        #
        
        return get_op_put(1, "操作成功");
    }

}
