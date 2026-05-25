<?php

namespace Inter\Controller;

#use Think\Controller;
use Think\Log;
class UsersController extends CommController {
    
    public function userDel(){
        $p = $this->param;
          
        if (!$p['uid']) {
            return get_op_put(0, "uid不能为空");
        }
        $users = M("users");
        $where["id"] = $p['uid'];
        $info = $users->where($where)->find();
        $users->where($where)->save(['is_del'=>2,'phone'=>$info['phone'].'注销']);
        return get_op_put(1, null);
    }
    public function msgs_dels() {
        $model = M("sys_msgs");
        $p = $this->param;
        #
        if (!$model->where(["uid" => $p["uid"]])->delete()) {
            return get_op_put(0, "删除失败");
        }
        #
        return get_op_put(1, null);
    }
    
    public function upload_logo(){
        $p = $this->param;
        $file = saveImageToFile("logo", $p["file"], "logo");
        if (!$file) {
            return get_op_put(0, "图片保存异常");
        }
        $data['img'] = $file;
        $data['view_url'] = C("WEBIMG").$file;
        return get_op_put(1, "操作成功",$data);
        
    }
    
    public function getRemarkList(){
        $model = M("report_remark");
        $where['uid'] = $this->param["uid"];
        $list = $model->where($where)->order('sort desc,id desc')->select();
        #
        return get_op_put(1, NULL, $list);
    }
    //logo模板
     public function remark_save() {
        $model = M("report_remark");
        $p = $this->param;
        if (!$p['title']) {
            return get_op_put(0, "名称不能为空");
        }
        
        if(isset($p['id']) && $p['id'] > 0){
            
            $save["title"] = $p['title'];
            $save["uptimes"] = time();
            if (!$model->where(['id'=>$p['id']])->save($save)) {
                return get_op_put(0, "更新失败");
            }
        }else{
            $save["title"] = $p['title'];
            $save["uid"] =  $p["uid"];;
            $save["uptimes"] = time();
            $save["times"] = time();
            $data = $model->create($save, 1);
            if (!$data) {
                return get_op_put(0, $model->getError());
            }
            if (!$model->add()) {
                return get_op_put(0, "添加失败");
            }
        }
        
        return get_op_put(1, "操作成功");
    }
    
     public function remark_dels() {
        $model = M("report_remark");
        $p = $this->param;
        #
        if (!$model->where(["id" => $p["id"]])->delete()) {
            return get_op_put(0, "删除失败");
        }
        #
        return get_op_put(1, null);
    }
    
    public function getLogoList(){
        $model = M("report_logo");
        $where['uid'] = $this->param["uid"];
        $list = $model->where($where)->order('sort desc,id desc')->select();
        foreach ($list as $k=>$v){
            $list[$k]['img_site'] = C("WEBIMG").$v['img'];
        }
        #
        return get_op_put(1, NULL, $list);
    }
    //logo模板
     public function logo_save() {
        $model = M("report_logo");
        $p = $this->param;
        // if (!$p['title']) {
        //     return get_op_put(0, "名称不能为空");
        // }
        if (!$p['img']) {
            return get_op_put(0, "图片不能为空");
        }
        if(isset($p['img']) && !empty($p['img'])){
            if ($p["img"] != NULL && $p["img"] != "") {
            // if ($p["img"] != NULL && $p["img"] != "" && (strpos($p["img"], "image/png") || strpos($p["img"], "image/jpeg"))) {    
            // if ($p["img"] != NULL && $p["img"] != "" && strpos($p["img"], "image/jpeg")) {
            // var_dump($p["img"]);
            // Log::record($p["img"], 'DEBUG');
            $p["img"] = saveImageToFile2("logo", $p["img"], "logo");
            // var_dump(112);
            // Log::record($p["img"], 'DEBUG');
            } else {
                $p["img"] = $p["img"];
            }
        }else{
            $p["img"]= '';
        }
        
        
        if(isset($p['id']) && $p['id'] > 0){
            
            // $save["title"] = $p['title'];
            $save["img"] = $p["img"];
            $save["uptimes"] = time();
            if (!$model->where(['id'=>$p['id']])->save($save)) {
                return get_op_put(0, "更新失败");
            }
        }else{
            // $save["title"] = $p['title'];
            $save["uid"] =  $p["uid"];;
            $save["img"] = $p["img"];
            $save["uptimes"] = time();
            $save["times"] = time();
            $data = $model->create($save, 1);
            if (!$data) {
                return get_op_put(0, $model->getError());
            }
            if (!$model->add()) {
                return get_op_put(0, "添加失败");
            }
        }
        
        return get_op_put(1, "操作成功");
    }
    
     public function logo_dels() {
        $model = M("report_logo");
        $p = $this->param;
        #
        if (!$model->where(["id" => $p["id"]])->delete()) {
            return get_op_put(0, "删除失败");
        }
        #
        return get_op_put(1, null);
    }

 

    /**
     * 个人信息
     */
    public function index() {
        $users = M("users");
        $orders = M("orders");
        #
        $where["id"] = $this->param["uid"];
        $info = $users->where($where)->find();
        unset($info["id"]);
        unset($info["passwd"]);
        unset($info["status"]);
        #
        $info["ac_name"] = acType($info["ac_type"]);
        $info["ac_level_name"] = getUsersLv($info["ac_level"]);
        $info["prov_name"] = getRegionName($info["prov"]);
        $info["city_name"] = getRegionName($info["city"]);
        $info["label_name"] = getRegionName($info["label"]);
        $info["headimgurl"] = strpos($info["headimgurl"], "heads") ? C("WEBIMG") . $info["headimgurl"] : C("WEBIMG") . "heads/ic_header.png";
        #
        $info["pic_id"] = C("WEBIMG") . $info["pic_id"];
        $info["pic_back"] = C("WEBIMG") . $info["pic_back"];
        $info["pic_head"] = C("WEBIMG") . $info["pic_head"];
        $info["pic_cont"] = C("WEBIMG") . $info["pic_cont"];
        #
        $cond = ["uid" => $this->param["uid"], "status" => 0];
        $info["order_wait"] = $orders->where($cond)->count();
        $cond["status"] = 1;
        $info["order_trans"] = $orders->where($cond)->count();
        $cond["status"] = 2;
        $info["order_saves"] = $orders->where($cond)->count();
        #
        return get_op_put(1, null, $info);
    }

    /**
     * 个人信息-更新
     */
    public function updates() {
        $users = M("users");
        $p = $this->param;
        #
        $where["id"] = $p["uid"];
        unset($p["id"]);
        #
        if ($p["pic_id"] != NULL && $p["pic_id"] != "" && strpos($p["pic_id"], "image/jpeg")) {
            $p["pic_id"] = saveImageToFile("profi", $p["pic_id"], "heads");
        } else {
            $p["pic_id"] = explode("Public/uploads/", $p["pic_id"])[1];
        }
        if ($p["pic_back"] != NULL && $p["pic_back"] != "" && strpos($p["pic_back"], "image/jpeg")) {
            $p["pic_back"] = saveImageToFile("profi", $p["pic_back"], "heads");
        } else {
            $p["pic_back"] = explode("Public/uploads/", $p["pic_back"])[1];
        }
        if ($p["pic_head"] != NULL && $p["pic_head"] != "" && strpos($p["pic_head"], "image/jpeg")) {
            $p["pic_head"] = saveImageToFile("profi", $p["pic_head"], "heads");
        } else {
            $p["pic_head"] = explode("Public/uploads/", $p["pic_head"])[1];
        }
        if ($p["pic_cont"] != NULL && $p["pic_cont"] != "" && strpos($p["pic_cont"], "image/jpeg")) {
            $p["pic_cont"] = saveImageToFile("profi", $p["pic_cont"], "heads");
        } else {
            $p["pic_cont"] = explode("Public/uploads/", $p["pic_cont"])[1];
        }
        #
        $p["uptimes"] = time();
        if (!$users->where($where)->save($p)) {
            return get_op_put(0, "更新失败");
        }
        #
        return get_op_put(1, null);
    }

    /**
     * 个人信息-保存头像
     */
    public function upset_head() {
        $users = M("users");
        $p = $this->param;
        #
        $where["id"] = $p["uid"];
        $info = $users->where($where)->find();
        if ($info == NULL) {
            return get_op_put(0, "个人信息异常");
        }
        #
        $file = saveImageToFile("HE", $p["image"], "heads");
        if (!$file) {
            return get_op_put(0, "图片保存异常");
        }
        $save["headimgurl"] = $file;
        $save["uptimes"] = time();
        if (!$users->where($where)->save($save)) {
            return get_op_put(0, "更新失败");
        }
        return get_op_put(1, "更新成功");
    }

    /**
     * 个人信息-申请更新
     */
    public function up_check() {
        $users = M("users");
        $p = $this->param;
        #
        $where["id"] = $p["uid"];
        unset($p["id"]);
        #
        $p["uptimes"] = time();
        if (!$users->where($where)->save($p)) {
            return get_op_put(0, "更新失败");
        }
        #
        return get_op_put(1, null);
    }

    /**
     * 个人信息-申请密码
     */
    public function up_passwd() {
        $users = M("users");
        $p = $this->param;
        #
        $where["id"] = $p["uid"];
        $where["passwd"] = md5($p["old"]);
        $count = $users->where($where)->count();
        if ($count < 1) {
            return get_op_put(0, "旧密码错误");
        }
        if ($p["new"] == null || $p["new"] == "") {
            return get_op_put(0, "新密码格式错误，请重新输入新密码");
        }
        #
        $save["passwd"] = md5($p["new"]);
        if ($save["passwd"] == null || $save["passwd"] == "") {
            return get_op_put(0, "新密码格式错误，请重新输入新密码");
        }
        #
        $save["uptimes"] = time();
        if (!$users->where($where)->save($save)) {
            return get_op_put(0, "更新失败");
        }
        #
        return get_op_put(1, null);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 地址-列表
     */
    public function uaddr_list() {
        $users_addr = M("users_addr");
        $p = $this->param;
        #
        $where["uid"] = $p["uid"];
        $list = $users_addr->where($where)->select();
        foreach ($list as $k => $v) {
            $list[$k]["p_name"] = getRegionName($v["prov"]);
            $list[$k]["c_name"] = getRegionName($v["city"]);
            $list[$k]["l_name"] = getRegionName($v["label"]);
        }
        #
        return get_op_put(1, null, $list);
    }

    /**
     * 地址-添加
     */
    public function uaddr_addon() {
        $users_addr = D("users_addr");
        $p = $this->param;
        #
        if (!$users_addr->create($p, 1)) {
            return get_op_put(0, $users_addr->getError());
        }
        if ($p["def"]) {
            $users_addr->where(["uid" => $p["uid"]])->save(["def" => 0]);
        }
        #
        if (!$users_addr->add()) {
            return get_op_put(0, "添加失败");
        }
        #
        return get_op_put(1, null);
    }

    /**
     * 地址-详情
     */
    public function uaddr_info() {
        $users_addr = M("users_addr");
        $sysregion = M("sysregion");
        $p = $this->param;
        #
        $where["id"] = $p["addrid"];
        $info = $users_addr->where($where)->find();
        #
        $cond["parent"] = 1;
        $list = $sysregion->where($cond)->select();
        #
        $res = ["info" => $info, "prov" => $list];
        return get_op_put(1, null, $res);
    }

    /**
     * 地址-编辑
     */
    public function uaddr_edits() {
        $users_addr = D("users_addr");
        $p = $this->param;
        #
        $data = $users_addr->create($p, 2);
        if (!$data) {
            return get_op_put(0, $users_addr->getError());
        }
        $where["uid"] = $p["uid"];
        if ($p["def"]) {
            $users_addr->where($where)->save(["def" => 0]);
        }
        if (!$users_addr->where(["id" => $p["ids"]])->save($data)) {
            return get_op_put(0, "更新失败", $users_addr->getLastSql());
        }
        #
        return get_op_put(1, null);
    }

    /**
     * 地址-删除
     * @return type
     */
    public function uaddr_dels() {
        $users_addr = D("users_addr");
        $p = $this->param;
        #
        if (!$users_addr->where(["id" => $p["id"]])->delete()) {
            return get_op_put(0, "删除失败");
        }
        #
        return get_op_put(1, null);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 发票-列表
     */
    public function ticket_list() {
        $users_ticket = D("users_ticket");
        $p = $this->param;
        #
        $p["type"] != NULL ? $where["ticket_type"] = $p["type"] : NULL;
        $where["uid"] = $p["uid"];
        $list = $users_ticket->where($where)->select();
        #
        return get_op_put(1, null, $list);
    }

    /**
     * 添加发票
     * @return type
     */
    public function ticket_addon() {
        $users_ticket = D("users_ticket");
        $p = $this->param;
        #
        $data = $users_ticket->create($p, 1);
        if (!$data) {
            return get_op_put(0, $users_ticket->getError());
        }
        if (!$users_ticket->add()) {
            return get_op_put(0, "添加失败");
        }
        #
        return get_op_put(1, null);
    }

    /**
     * 添加发票-详情
     */
    public function ticket_info() {
        $users_ticket = D("users_ticket");
        $p = $this->param;
        #
        $where["id"] = $p["tid"];
        $info = $users_ticket->where($where)->find();
        $info["pic_id"] = strpos($info["pic_id"], "ticket") ? C("WEBIMG") . $info["pic_id"] : $info["pic_id"];
        $info["pic_bank"] = strpos($info["pic_bank"], "ticket") ? C("WEBIMG") . $info["pic_bank"] : $info["pic_bank"];
        #
        return get_op_put(1, null, $info);
    }

    /**
     * 添加发票-修改
     */
    public function ticket_edits() {
        $users_ticket = D("users_ticket");
        $p = $this->param;
        #
        $data = $users_ticket->create($p, 2);
        if (!$data) {
            return get_op_put(0, $users_ticket->getError());
        }
        $where["id"] = $p["ids"];
        if (!$users_ticket->where($where)->save($data)) {
            return get_op_put(0, "更新失败");
        }
        #
        return get_op_put(1, null);
    }

    /**
     * 添加发票-删除
     * @return type
     */
    public function ticket_dels() {
        $users_ticket = D("users_ticket");
        $p = $this->param;
        #
        if (!$users_ticket->where(["id" => $p["ids"]])->delete()) {
            return get_op_put(0, "删除失败");
        }
        #
        return get_op_put(1, null);
    }

}
