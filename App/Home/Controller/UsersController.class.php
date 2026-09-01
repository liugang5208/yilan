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
        // 精准查询：只获取手机归属地为空或没有归属地信息的注册用户
        $list = $users->where('id > 0 AND (locate IS NULL OR locate = "")')->field('id,phone')->select();
        
        $successCount = 0; // 统计成功更新的用户数量
        
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $pos = strpos($v['phone'], "注销");
                if ($pos !== false) {
                    continue;
                }
                $area = $this->_check($v['phone']);
                if ($area) {
                    $save = ["locate" => $area, "uptimes" => time()];
                    $res = $users->where(["id" => $v["id"]])->save($save);
                    if ($res !== false) {
                        $successCount++;
                    }
                }
            }
        }
        
        // 弹出确切的提示窗告知更新了多少个用户
        echo "<script>alert('更新完成！本次共成功为 {$successCount} 位没有归属地的注册用户补全了手机归属地。');history.go(-1);</script>";
        exit;
    }
    
    public function _check($mobile=''){
        error_reporting(E_ALL || ~E_NOTICE);
        $host = "https://jisusjhmcx.market.alicloudapi.com";
        $path = "/shouji/query";
        $method = "GET";
        $appcode = "1c571be5cf5a46ce883b8637a7a7d3b6";//开通服务后 买家中心-查看AppCode
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "shouji=$mobile";
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
            $data = json_decode($body,true);
            if(isset($data['status']) && $data['status'] == '0' && isset($data['result'])){
                 $province = isset($data['result']['province']) ? $data['result']['province'] : '';
                 $city = isset($data['result']['city']) ? $data['result']['city'] : '';
                 
                 // 按照要求：省份后面两个空格加个中心点再是两个空格后面再显示城市的名字
                 if(!empty($province) && !empty($city)){
                     return $province . "  ·  " . $city;
                 }elseif(!empty($province)){
                     return $province;
                 }elseif(!empty($city)){
                     return $city;
                 }
                 return '';
            }
            return '';
        } else {
            return '';
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
        $ac_level = $get['id'];
        // 约定 ac_level=0 表示“公共比例”（真实等级id从1开始自增，不会与0冲突）
        $is_public = ($ac_level !== null && (int)$ac_level === 0);
        #
        $where = ['type' => $is_public ? 0 : 1];
        if (!$is_public && $ac_level !== null) {
            $where["ac_level"] = $ac_level;
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
        $this->assign("ac_level", $ac_level);
        $this->assign("is_public", $is_public);
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
        // filter_var(...,FILTER_VALIDATE_INT) 会把 "05" 这种带前导0的合法整数字符串误判为非法，
        // 改用正则宽松校验（允许前导0、正负号、首尾空格），只拒绝真正的小数/非数字
        if (!preg_match('/^[-+]?\d+$/', trim($post['cats_up']))) {
            return get_op_put(0, "比例必须是整数!");
        }
        $cats_up = (int) $post['cats_up'];
        $ac_level = (int) $post['ac_level'];
        $type = $ac_level === 0 ? 0 : 1; // ac_level=0 约定为“公共比例”

        $find = ['plate_cats_id'=>$post['plate_cats_id'], 'type'=>$type];
        if ($type === 1) $find['ac_level'] = $ac_level;
        $info = $users_cats->where($find)->find();
        if($info){
            $result = $users_cats->where(['id'=>$info['id']])->save(['cats_up'=>$cats_up]);
        }else{
            $result = $users_cats->add(['ac_level'=>$ac_level,'plate_cats_id'=>$post['plate_cats_id'],'cats_up'=>$cats_up,'type'=>$type]);
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
        // return get_op_put(1, "操作成功",$form);
        if ($post['ac_level'] == null) {
            return get_op_put(0, "参数错误");
        }
        $ac_level = (int) $post['ac_level'];
        $type = $ac_level === 0 ? 0 : 1; // ac_level=0 约定为“公共比例”
        foreach ($form as $k=>$v){

            if ($v["plate_cats_id"] == null) {
                return get_op_put(0, "plate_cats_id");
            }
            if ($v["cats_up"] == null) {
                return get_op_put(0, "比例不能为空");
            }
            // 防御：前端理论上只应提交标量字符串，若因表单结构问题混入数组，这里直接判非法而不是让 trim() 崩掉
            if (is_array($v['cats_up'])) {
                return get_op_put(0, "第" . ($k + 1) . "行：比例数据格式异常");
            }
            // 同 cats_op()：改用正则宽松校验，避免 "05" 这种带前导0的合法整数被误判
            if (!preg_match('/^[-+]?\d+$/', trim($v['cats_up']))) {
                return get_op_put(0, "第" . ($k + 1) . "行：比例必须是整数!");
            }
            $cats_up = (int) $v['cats_up'];

            $find = ['plate_cats_id'=>$v['plate_cats_id'], 'type'=>$type];
            if ($type === 1) $find['ac_level'] = $ac_level;
            $info = $users_cats->where($find)->find();
            if($info){
                $result = $users_cats->where(['id'=>$info['id']])->save(['cats_up'=>$cats_up]);
            }else{
                $result = $users_cats->add(['ac_level'=>$ac_level,'plate_cats_id'=>$v['plate_cats_id'],'cats_up'=>$cats_up,'type'=>$type]);
            }
            if ($result === false) {
                return get_op_put(0, "第" . ($k + 1) . "个比例设置操作失败");
            }
        }
        #
        
        #
        
        return get_op_put(1, "操作成功");
    }

}