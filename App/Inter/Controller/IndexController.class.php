<?php

namespace Inter\Controller;

#use Think\Controller;
use Think\Log;
class IndexController extends CommController {
    
    
    public function checkArea2(){
        
        $prov = '四川';
        $city = '成都';
        $label = '';
        $ip = '223.104.218.86';
        $checkName = $this->checkIpVersion($ip);
        if($checkName == 'IPv4'){
            $temp = $this->_ipv4($ip); return get_op_put(1, NULL, $temp);
            if(isset($temp['data'])){
                $prov = $temp['data']['prov'];
                $city = $temp['data']['city'];
            }
        }elseif($checkName == 'IPv6'){
            $temp = $this->_ipv6($ip);
            if(isset($temp['data'])){
                $prov = $temp['data']['prov'];
                $city = $temp['data']['city'];
            }
        }
        $list['prov'] = $prov;
        $list['city'] = $city;
        $list['label'] = $label;
        return get_op_put(1, NULL, $list);
    }
    
    public function checkArea(){
          $param = $this->param;
        // var_dump($_SERVER['HTTP_HOST']);
        // $host = $_SERVER['HTTP_HOST'];
        // if($host == 'app.elccc.cn'){
        //     return get_op_put(0, '请下载新的app');
        // }
        if(!isset($param['new']) || $param['new'] != 1){
             return get_op_put(0, '请打开elccc.cn官网下载或者联系管理员安装最新版本易缆通APP');
        }
        $prov = '四川';
        $city = '成都';
        $label = '';
        $ip = getIP();
        $checkName = $this->checkIpVersion($ip);
        if($checkName == 'IPv4'){
            $temp = $this->_ipv4($ip);
            if(isset($temp['data'])){
                $prov = $temp['data']['prov'];
                $city = $temp['data']['city'];
            }
        }elseif($checkName == 'IPv6'){
            $temp = $this->_ipv6($ip);
            if(isset($temp['data'])){
                $prov = $temp['data']['prov'];
                $city = $temp['data']['city'];
            }
        }
        $list['prov'] = $prov;
        $list['city'] = $city;
        $list['label'] = $label;
        return get_op_put(1, NULL, $list);
    }
    
    function _ipv4($ip){
        $token = 'cv2b68kuijrzy5fe98u8xgejqx35lh7m';
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://eolink.o.apispace.com/ipv4city/ip/geo/v1?ip=$ip&coordsys=WGS84",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_HTTPHEADER => array(
            "X-APISpace-Token:$token"
          ),
        ));
        
        $response = curl_exec($curl);
        
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
           Log::record($ip, 'DEBUG');
           Log::record("cURL Error #:" . $err, 'DEBUG');
           return false;
        } else {
          $response = json_decode($response,true);
          return  $response;
        }

    }
    
    function _ipv6($ip){
        $token = 'cv2b68kuijrzy5fe98u8xgejqx35lh7m';
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://eolink.o.apispace.com/ipv6city/ip/geo/v1?ip=$ip&coordsys=WGS84",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_HTTPHEADER => array(
            "X-APISpace-Token:$token"
          ),
        ));
        
        $response = curl_exec($curl);
        
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
           Log::record($ip, 'DEBUG');
           Log::record("cURL Error #:" . $err, 'DEBUG');
           return false;
        } else {
          $response = json_decode($response,true);
          return  $response;
        }
    }
    
    
    function checkIpVersion($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return "IPv4";
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "IPv6";
        } else {
            return false;
        }
    }

    public function update_version()
    {
        $param = $this->param;
        Log::record(22222444556, 'DEBUG');
         Log::record($param['version'], 'DEBUG');
        if (empty($param['version'])) {
             return get_op_put(0, "version 不能为空!");
        }
        if(!isset($param['system']) || !$param['system']){
            $param['system'] = 1;
        }
        
        if (empty($param['system'])) {
             return get_op_put(0, "system 不能为空!");
        }
        $model = M("version");

        $where['system'] = $param['system'];
        $where['version_sort'] = $param['version'];
        $info = $model->where($where)->order('id desc')->find();

        if(!$info){
             return get_op_put(1, "未检测到更新",null);
        };
        $map['system'] = $param['system'];
        $map['version_sort'] = array('gt', $info['version_sort']);
        $list = $model->where($map)->order('version desc,id desc')->find();
        if (empty($list)) {
            return get_op_put(1, "已是最新版本",null);
        }
        $list['package_type'] = 0;
        $list['edition_silence'] = 0;
        $list['edition_url'] = $list['url'];
        $list['edition_force'] = 1;
        $list['edition_number'] = $list['version_sort'];
        $list['edition_name'] = $list['version'];
         return get_op_put(1, NULL, $list);
    }

    public function index() {
        //dump();
    }
    
    public function getBarList(){
        $bar = M("bar");
        $where['is_del'] = 1;
        $where['status'] = 1;
        $list = $bar->where($where)->order('sort desc,id asc')->select();
        #
        return get_op_put(1, NULL, $list);
    }

    /**
     * 地区
     */
    public function region() {
        $sysregion = M("sysregion");
        #
        $where["parent"] = $this->param["pid"] == NULL ? 1 : $this->param["pid"];
        $list = $sysregion->where($where)->select();
        #
        return get_op_put(1, NULL, $list);
    }

    /**
     * 获取验证码
     */
    public function getSmsCode() {
        $vi = D("Inter/Verif", "Logic");
        $post = $this->param;
        #
        if (!preg_match("/1[3,5,6,7,8,9][0-9]\d{8}$/", $post["phone"])) {
            return get_op_put(0, "验证手机号码格式不正确", $post["phone"]);
        }
        //
        $res = $vi->getCode($post["phone"]);
        if ($res != 200) {
            return get_op_put(0, "获取验证码失败", $res);
        }
        return get_op_put(1, "发送成功,请及时查收", $res["msg"]);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 注册
     */
    public function reg() {
        $users = D("users");
        $users_label = M("users_label");
        $vi = D("Inter/Verif", "Logic");
        $p = $this->param;
        #
        $data = $users->create($p, 1);
        if (!$data) {
            return get_op_put(0, $users->getError());
        }
        $where = ["prov" => $users->prov, "city" => $users->city, "label" => $users->label, "status" => 1,];
        $count = $users_label->where($where)->count();
        if ($count > 0) {
            return get_op_put(0, "此区域禁止注册");
        }
        if ($p["code"] == NULL || $p["code"] == "") {
            return get_op_put(0, "请输入短信验证码");
        }
        if ($p["vipass"] == NULL || $p["vipass"] == "") {
            return get_op_put(0, "请输入确认密码");
        }
        if ($p["passwd"] != $p["vipass"]) {
            return get_op_put(0, "两次密码不一致");
        }
        $res = $vi->checkCode($p["phone"], $p["code"]);
        if ($res != 200) {
            return get_op_put(0, "验证码错误");
        }
        // $users->locate = getPhoneArea($users->phone);
        #
        if (!$users->add()) {
            return get_op_put(0, "注册失败");
        }
        return get_op_put(1, "注册成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 登录
     */
    public function login() {
        $users = D("users");
        $p = $this->param;
        #
        $udata = $users->create($p, 2);
        if (!$udata) {
            return get_op_put(0, $users->getError());
        }
        #
        $where = ["phone" => $p["phone"], "passwd" => md5($p["passwd"]),'is_del'=>1];
        $info = $users->where($where)->find();
        if ($info == NULL) {
            return get_op_put(0, "用户名或密码错误,请核实后再次登录");
        }
        if ($info["status"] != "1") {
            return get_op_put(0, "用户已冻结");
        }
        $users->where(["id" => $info["id"]])->save(["last" => time()]);
        #
        // ipLogin($info["id"]);
        $ret["id"] = $info["id"];
        return get_op_put(1, "登录成功", $ret);
    }

    /**
     * 临时注册
     * @param array $data
     * @return type
     */
    private function login_reg($data) {
        $users = D("users");
        #
        $data["passwd"] = md5("000000");
        $id = $users->add($data);
        if (!$id) {
            return get_op_put(0, "登陆失败");
        }
        return get_op_put(1, "登录成功", $id);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 登录-验证码
     */
    public function logCode() {
        $users = D("users");
        $vi = D("Inter/Verif", "Logic");
        $p = $this->param;
        #
        $res = $vi->checkCode($p["phone"], $p["code"]);
        if ($res != 200) {
            return get_op_put(0, "验证码错误");
        }
        #
        $where["phone"] = $p["phone"];
        $where["is_del"] = 1;
        $info = $users->where($where)->find();
        if ($info == NULL) {
            return get_op_put(0, "用户不存在，请注册后再使用");
        }
        if ($info["status"] != "1") {
            return get_op_put(0, "用户已冻结");
        }
        $users->where(["id" => $info["id"]])->save(["last" => time()]);
        #
        // ipLogin($info["id"]);
        $ret["id"] = $info["id"];
        return get_op_put(1, "登录成功", $ret);
    }
    
    public function regionAdd(){
        $p = $this->param;
         Log::record($p['prov'], 'DEBUG');
          Log::record($p['city'], 'DEBUG');
           Log::record($p['label'], 'DEBUG');
        if(!$p['uid']) return get_op_put(1, "操作成功!");
        $ip = getIP();
        $puts["uid"] = $p['uid'];
        $puts["ip"] = $ip;
        $puts["prov"] = getRegionID(str_replace("省", "", $p["prov"]));
        $puts["city"] = getRegionID(str_replace("市", "",$p["city"]));
        $puts["label"] = getRegionID($p["label"]);
        $puts["prov_name"] = $p["prov"];
        $puts["city_name"] = $p["city"];
        $puts["label_name"] = $p["label"];
        $puts["timr"] = 0;
        $puts["times"] = time();
        M("users_logs")->add($puts);
        return get_op_put(1, "操作成功");
    }

    /**
     * 忘记密码
     */
    public function forget() {
        $users = D("users");
        $vi = D("Inter/Verif", "Logic");
        $p = $this->param;
        #
        $res = $vi->checkCode($p["phone"], $p["code"]);
        if ($res != 200) {
            return get_op_put(0, "验证码错误");
        }
        #
        $where["phone"] = $p["phone"];
        $where["is_del"] = 1;
        $info = $users->where($where)->find();
        if ($info == NULL) {
            return get_op_put(0, "用户不存在");
        }
        #
        $save["passwd"] = md5($p["passwd"]);
        $save["uptimes"] = time();
        if (!$users->where($where)->save($save)) {
            return get_op_put(0, "密码重置失败");
        }
        #
        return get_op_put(1, "重置成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 搜索
     */
    public function search() {
        $plate_conts = M("plate_conts");
        $users_search = M("users_search");
        $p = $this->param;
        #
        $svalue = array("like", "%" . $p["keys"] . "%");
        $list = $plate_conts->alias('a')
          ->join("plate b on b.id=a.pid")
          ->join("plate_types c on c.id=b.pid and c.types=1")
          ->where(["a.g_keys" => $svalue, "a.status" => 1])->order('a.id asc')->field('a.*')->select();
        // $list = $plate_conts->where(["g_keys" => $svalue, "status" => 1])->select();
        #
        $res = array();
        foreach ($list as $k => $v) {
            $temp = array(
                "source_id" => $v["price_type"] < 3 ? $v["id"] : $v["price_id"],
                "types" => $v["price_type"],
                "name" => $v["g_name"],
                "unit" => $v["g_unit"],
                "keys" => $v["g_keys"],
                "typr" => $v["g_qq"],
                "imgurl" => C("WEBIMG") . "ads/" . $v["source_display"],
            );
            $res[$k] = $temp;
        }
        $users_search->add(["uid" => $p["uid"], "types" => 1, "keyr" => $p["keys"], "times" => time()]);
        #
        return get_op_put(1, "获取成功", $res);
    }

    /**
     * 广告列表
     */
    public function banner_list() {
        $sys_banner = M("sys_banner");
        $p = $this->param;
        #
        $where["status"] = 1;
        $list = $sys_banner->where($where)->order("rand()")->limit(2)->select();
        foreach ($list as $k => $v) {
            $list[$k]["url"] = C("WEBIMG") . "ads/" . $v["imgurl"];
        }
        if ($p["uid"] != null && $p["uid"] != "") {
            ipLogin($p["uid"]);
        }
        #
        return get_op_put(1, "获取成功", $list);
    }

    /**
     * 加载广告列表
     */
    public function load_banner() {
        $sys_banner = M("sys_banner");
        $sysconfig = M("sysconfig");
        $p = $this->param;
        #
        $version = $sysconfig->find(4);
        $list = $sys_banner->where(["status" => 1])->select();
        #
        if ($version["valuc"] != $p["version"]) {
            foreach ($list as $k => $v) {
                $list[$k] = imgToBase64("./././Public/uploads/ads/" . $v["imgurl"]);
            }
        }
        #
        if ($p["uid"] != null && $p["uid"] != "") {
            ipLogin($p["uid"]);
        }
        #
        $res = [
            "version" => $version["valuc"],
            "match" => $version["valuc"] != $p["version"] ? 0 : 1,
            "list" => $list,
            "show" => mt_rand(0, count($list) - 1)
        ];
        #
        return get_op_put(1, "获取成功", $res);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 消息列表
     */
    public function msg_list() {
        $sys_msgs = M("sys_msgs");
        $p = $this->param;
        #
        $where["uid"] = $p["uid"];
        $res["list"] = $sys_msgs->where($where)->order("id desc")->limit(20)->select();
        foreach ($res["list"] as $k => $v) {
            $res["list"][$k]["icon"] = $v["types"] > 0 ? 'ord' : 'sys';
            $res["list"][$k]["time_zone"] = date("Y-m-d H:i", $v["times"]);
        }
        $where["i_read"] = 0;
        $res["noread"] = $sys_msgs->where($where)->count();
        #
        return get_op_put(1, "获取成功", $res);
    }

    /**
     * 消息详情
     */
    public function msg_info() {
        $sys_msgs = M("sys_msgs");
        $p = $this->param;
        #
        $where["id"] = $p["ids"];
        $info = $sys_msgs->where($where)->find();
        $info["icon"] = $info["types"] > 0 ? 'ord' : 'sys';
        $info["time_zone"] = date("Y-m-d H:i", $info["times"]);
        #
        $sys_msgs->where($where)->save(["i_read" => 1, "uptimes" => time()]);
        #
        return get_op_put(1, "获取成功", $info);
    }

    /**
     * 清除未读
     */
    public function msg_clear() {
        $sys_msgs = M("sys_msgs");
        $p = $this->param;
        #
        $where["uid"] = $p["uid"];
        $where["i_read"] = 0;
        #
        $save = ["i_read" => 1, "uptimes" => time()];
        if (!$sys_msgs->where($where)->save($save)) {
            
        }
        return get_op_put(1, "获取成功");
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     * 文章列表
     */
    public function artall() {
        $sys_article = M("sys_article");
        $p = $this->param;
        #
        $list = $sys_article->select();
        $res = [];
        foreach ($list as $k => $v) {
            $res[$v["models"]] = replaceHtml($v["context"]);
        }
        #
        return get_op_put(1, "获取成功", $res);
    }

    /**
     * 文章列表
     */
    public function article() {
        $sys_article = M("sys_article");
        $p = $this->param;
        #
        $where["models"] = $p["types"];
        $info = $sys_article->where($where)->find();
        $info["context"] = replaceHtml($info["context"]);
        #
        return get_op_put(1, "获取成功", $info);
    }

    /**
     * 文章列表
     */
    public function helps() {
        $sys_help = M("sys_help");
        #
        $where["pid"] = array("neq", 0);
        $where["status"] = 1;
        $list = $sys_help->where($where)->select();
        #
        return get_op_put(1, "获取成功", $list);
    }

    /**
     * 文章列表
     */
    public function helps_child() {
        $sys_help = M("sys_help");
        $p = $this->param;
        #
        $where["pid"] = $p["id"];
        $where["status"] = 1;
        $list = $sys_help->where($where)->select();
        $part = $sys_help->find($p["id"]);
        #
        return get_op_put(1, $part, $list);
    }

    /**
     * 文章列表
     */
    public function helps_info() {
        $sys_help = M("sys_help");
        $p = $this->param;
        #
        $where["id"] = $p["id"];
        $info = $sys_help->where($where)->find();
        $info["context"] = replaceHtml($info["context"]);
        #
        return get_op_put(1, "获取成功", $info);
    }

    /**
     * 检查更新
     */
    public function sysupdate() {
        return get_op_put(1, "暂无更新版本");
    }
    
    public function regionAll(){
         $sysregion = M("sysregion");

          $info = $sysregion->where('parent',1)->select();
          $list = convertToTree($info);
          return get_op_put(1, "获取成功", $list);
    }
    
    public function customerConfig(){
        $sysregion = M("config");
        $post = I("post.");
        #
        $where["group_id"] = 1;
        $where["status"] = 1;
        $list = $sysregion->where($where)->field('id,title,name,value,type')->select();
         return get_op_put(1, "获取成功", $list);
    }

}
