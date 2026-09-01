<?php

/**
 * 输出json
 * @param type $status
 * @param type $data
 * @param type $url
 */
function get_op_put($status, $data, $url = null) {
    $array = array(
        "status" => $status,
        "msg" => $data,
        "data" => $url,
    );
    \Think\Log::record(json_encode($array));
    echo json_encode($array);
    exit;
}

/**
 * 输出数组
 * @param type $status
 * @param type $data
 * @param type $url
 */
function get_op_res($status, $data, $url = null) {
    $array = array(
        "status" => $status,
        "msg" => $data,
        "data" => $url
    );
    return $array;
}

/**
 * array_column函数兼容方法
 * @param type $input
 * @param type $columnKey
 * @param type $indexKey
 * @return type
 */
function i_array_column($input, $columnKey, $indexKey = null) {
    if (!function_exists('array_column')) {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? true : false;
        $indexKeyIsNull = (is_null($indexKey)) ? true : false;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? true : false;
        $result = array();
        foreach ((array) $input as $key => $row) {
            if ($columnKeyIsNumber) {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : null;
            } else {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : null;
            }
            if (!$indexKeyIsNull) {
                if ($indexKeyIsNumber) {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key)) ? current($key) : null;
                    $key = is_null($key) ? 0 : $key;
                } else {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    } else {
        return array_column($input, $columnKey, $indexKey);
    }
}

/**
 * CURL扩展方法
 * @param type $url
 * @param type $params
 * @return type
 */
function poCurl($url, $params) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $output = curl_exec($ch);
    $outerr = curl_errno($ch);
    curl_close($ch);
    return $output;
}

/**
 * 微信证书CURL扩展方法
 * @param type $url
 * @param type $params
 * @return type
 */
function wcPoCurl($url, $params) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
    curl_setopt($ch, CURLOPT_SSLCERT, getcwd() . '/Public/cert/apiclient_cert.pem');
    curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
    curl_setopt($ch, CURLOPT_SSLKEY, getcwd() . '/Public/cert/apiclient_key.pem');
    curl_setopt($ch, CURLOPT_CAINFO, 'PEM');
    curl_setopt($ch, CURLOPT_CAINFO, getcwd() . '/Public/cert/rootca.pem');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

/**
 * 上传文件
 * @param type $file
 * @return boolean
 */
function uploadFile($file,$fileContent) {
    $upload = new \Think\Upload();
    $upload->maxSize = 110485760;
    $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'm4a', 'mp4', 'aac', 'pdf', 'xls', "xlsx", 'csv', 'apk');
    $upload->rootPath = './././Public/uploads/' . $file . "/";
    $upload->savePath = '';
    $upload->autoSub = false;
    if($fileContent){
        $info = $upload->upload($fileContent);
    }else{
        $info = $upload->upload();
    }
    
    if (!$info) {//var_dump($upload->getError());die;
        return false;
    }
    return $info;
}

/**
 * 数据分页
 * @param type $db
 * @param type $where
 * @param type $order
 * @param type $limit
 * @return type
 */
function poPage($db, $where, $order = "id desc", $limit = 10) {
    $count = $db->where($where)->count();
    $Page = new \Think\Page($count, $limit);
    $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
    $data["show"] = $Page->show();
    $setLimit = $Page->firstRow . ',' . $Page->listRows;
    $data["list"] = $db->where($where)->order($order)->limit($setLimit)->select();
    return $data;
}

/**
 * 数据分页
 * @param type $db
 * @param type $where
 * @param type $order
 * @param type $limit
 * @return type
 */
function boPage($db, $where, $order = "id asc", $limit = 10) {
    $count = $db->where($where)->count();
    $Page = new \Think\PageBootstrap($count, $limit);
    $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
    $data["show"] = $Page->show();
    $setLimit = $Page->firstRow . ',' . $Page->listRows;
    $data["list"] = $db->where($where)->order($order)->limit($setLimit)->select();
    return $data;
}

/**
 * 数组分页
 * @param type $data
 * @param type $limit
 * @return type
 */
function arrPage($data, $limit = 10) {
    $count = count($data);
    $Page = new \Think\Page($count, $limit);
    $data["list"] = array_slice($data, $Page->firstRow, $Page->listRows);
    $data["show"] = $Page->show();
    return $data;
}

/**
 * dataTable数据分页
 * @param type $data
 * @return type
 */
function ongxData($data) {
    $ret = array();
    foreach ($data["columns"] as $key => $val) {
        if ($val["search"]["value"] != null && $val["data"] != "function") {
            $tmp = "%" . $val["search"]["value"] . "%";
            $ret["where"][$val["data"]] = array("like", $tmp);
        }
        if ($data["search"]["value"] != null && $val["data"] != "function") {
            $tol = "%" . $data["search"]["value"] . "%";
            $ret["where"][$val["data"]] = array("like", $tol);
        }
    }
    if ($ret["where"] != null) {
        $ret["where"]['_logic'] = 'or';
    }
    foreach ($data["order"] as $key => $val) {
        $tmp = $data["columns"][$val["column"]];
        $ret["order"] = $ret["order"] . "," . $tmp["data"] . " " . $val["dir"];
    }
    $ret["start"] = $data["start"] == 0 ? 1 : $data["start"] / $data["length"] + 1;
    $ret["order"] = trim($ret["order"], ",");
    $ret["limit"] = $data["length"];
    return $ret;
}

/**
 * XML转化为数组
 * @param type $xml
 * @return type
 */
function xmlToArray($xml) {
    libxml_disable_entity_loader(true);
    $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    $val = json_decode(json_encode($xmlstring), true);
    return $val;
}

/**
 * 互易无限
 * @param type $xml
 * @return type
 */
function xml_to_array($xml) {
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if (preg_match_all($reg, $xml, $matches)) {
        $count = count($matches[0]);
        for ($i = 0; $i < $count; $i++) {
            $subxml = $matches[2][$i];
            $key = $matches[1][$i];
            if (preg_match($reg, $subxml)) {
                $arr[$key] = xml_to_array($subxml);
            } else {
                $arr[$key] = $subxml;
            }
        }
    }
    return $arr;
}

/**
 * 转义汉字
 * @param type $str
 * @return type
 */
function url_encode($str) {
    if (is_array($str)) {
        foreach ($str as $key => $value) {
            $str[urlencode($key)] = url_encode($value);
        }
    } else {
        $str = urlencode($str);
    }
    return $str;
}

/**
 * 清除空格
 * @param type $str
 * @return type
 */
function trimall($str) {
    $qian = array(" ", "　", "\t", "\n", "\r");
    $hou = array("", "", "", "", "");
    return str_replace($qian, $hou, $str);
}

/**
 * 获取当前页面URL
 * @return type
 */
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

/**
 * 经纬度距离
 * @param type $lng       经度  104.066164
 * @param type $lat       纬度  30.650085
 * @param type $distance  该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
 * @return type           正方形的四个点的经纬度坐标
 */
function returnSquarePoint($lng, $lat, $distance = 10) {
    $dlng = 2 * asin(sin($distance / (2 * 6370)) / cos(deg2rad($lat)));
    $dlng = rad2deg($dlng);
    $dlat = $distance / 6370;
    $dlat = rad2deg($dlat);
    $res = array(
        'left-top' => array('lat' => $lat + $dlat, 'lng' => $lng - $dlng),
        'right-top' => array('lat' => $lat + $dlat, 'lng' => $lng + $dlng),
        'left-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng - $dlng),
        'right-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng + $dlng)
    );
    return $res;
}

/**
 * @desc 根据两点间的经纬度计算距离 
 * @param float $lat 纬度值 
 * @param float $lng 经度值 
 */
function getDistance($lat1, $lng1, $lat2, $lng2) {
    $earthRadius = 6367000;
    /*
      Convert these degrees to radians
      to work with the formula
     */
    $lat1 = ($lat1 * pi() ) / 180;
    $lng1 = ($lng1 * pi() ) / 180;
    $lat2 = ($lat2 * pi() ) / 180;
    $lng2 = ($lng2 * pi() ) / 180;
    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;
    return round($calculatedDistance);
}

/**
 * 计算经纬度
 * @param type $lat1
 * @param type $lng1
 * @param type $lat2
 * @param type $lng2
 * @return type
 */
function getDistancr($lat1, $lng1, $lat2, $lng2) {
    // 赤道半径(单位m)
    $earthRadius = 6378137;
    $lat1 = ($lat1 * pi() ) / 180;
    $lng1 = ($lng1 * pi() ) / 180;
    $lat2 = ($lat2 * pi() ) / 180;
    $lng2 = ($lng2 * pi() ) / 180;
    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;
    return abs(round($calculatedDistance / 1000, 2));
}

/**
 * 随机经纬度
 * @param type $min
 * @param type $max
 * @return type
 */
function randomFloat($min = 0, $max = 1) {
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}

/**
 * 获取时间编号
 */
function getTimerSN() {
    $mictime = microtime(true);
    $tmp = explode(".", $mictime);
    #
    $stpad = sprintf('%04d', $tmp[1]);
    return $tmp[0] . $stpad;
}

/**
 * 过滤微信昵称
 * @param type $str
 * @return string
 */
function jsonName($str) {
    if ($str) {
        $tmpStr = json_encode($str);
        $tmpStr2 = preg_replace_callback("#(\\\ud[0-9a-f]{3})#ie", "", $tmpStr);
        $return = json_decode($tmpStr2);
        if (!$return) {
            return jsonName($return);
        }
    } else {
        $return = 'wx_' . time();
    }
    return $return;
}

/**
 * 检测运行系统
 * @return boolean
 */
function is_mobile_request() {
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = '0';
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }
    if ((isset($_SERVER['HTTP_ACCEPT'])) and ( strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false)) {
        $mobile_browser++;
    }
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        $mobile_browser++;
    }
    if (isset($_SERVER['HTTP_PROFILE'])) {
        $mobile_browser++;
    }
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
    );
    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }
    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) {
        $mobile_browser++;
    }
    // Pre-final check to reset everything if the user is on Windows 
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) {
        $mobile_browser = 0;
    }
    // But WP7 is also Windows, with a slightly different characteristic 
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) {
        $mobile_browser++;
    }
    if ($mobile_browser > 0) {
        return true;
    }
    return false;
}

/**
 * 获取ip地址
 * @return type
 */
function getIP() {
    if ($_SERVER["HTTP_CLIENT_IP"] && strcasecmp($_SERVER["HTTP_CLIENT_IP"], "unknown")) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } else {
        if ($_SERVER["HTTP_X_FORWARDED_FOR"] && strcasecmp($_SERVER["HTTP_X_FORWARDED_FOR"], "unknown")) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            if ($_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")
                ) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = "unknown";
                }
            }
        }
    }
    return ($ip);
}

/**
 * base64图片
 * @param type $base64_image_content
 * @param type $path
 * @return boolean
 */
function base64_image_content($base64_image_content, $path) {
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        $file = uniqid() . "." . $type;
        $new_file = $path . $file;
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
            return $file;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * 获取参数
 */
function ionRequest() {
    $tmp = file_get_contents('php://input', true);
    $get = json_decode($tmp, true);
    return $get;
}

/**
 * 记录日志
 */
function logFile($type, $log) {
    $file = "./././Public/Logs/" . $type . "/";
    if (!file_exists($file)) {
        mkdir($file);
    }
    $filetxt = $file . date("Ymd") . ".txt";
    $stream = fopen($filetxt, "a+");
    fwrite($stream, date("Y-m-d H:i:s") . "=" . $log . "\r\n");
    fclose($stream);
}

/**
 * key=value转Array
 * @param type $data
 * @return type
 */
function keyToArray($data) {
    $temp = explode("&", $data);
    $arr = [];
    foreach ($temp as $k => $v) {
        $neTemp = explode("=", $v);
        $arr[$neTemp[0]] = urldecode($neTemp[1]);
    }
    return $arr;
}

/**
 * 转中文日期
 * @param type $date
 * @return string
 */
function toDateChinese($date) {
    $date_arr = explode('-', $date);
    $arr = [];
    foreach ($date_arr as $index => &$val) {
        if (mb_strlen($val) == 4) {
            $arr[] = preg_split('/(?<!^)(?!$)/u', $val);
        } else {
            if ($val > 10) {
                $v[] = 10;
                $v[] = $val % 10;
                $arr[] = $v;
                unset($v);
            } else {
                $arr[][] = $val;
            }
        }
    }
    $cn = array("一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "零");
    $num = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "0");
    $str_time = '';
    for ($i = 0; $i < count($arr); $i++) {
        foreach ($arr[$i] as $index => $item) {
            $str_time .= $cn[array_search($item, $num)];
        }
        if ($i == 0) {
            $str_time .= '年';
        } elseif ($i == 1) {
            $str_time .= '月';
        } elseif ($i == 2) {
            $str_time .= '日';
        }
    }
    return $str_time;
}

/**
 * 时间转换
 */
function timeCover($time) {
    $arr = explode(":", $time);
    #
    if (count($arr) > 2) {
        $h = $arr[0] * 3600;
        $m = $arr[1] * 60;
        $s = $arr[2];
        return $h + $m + $s;
    }
    $m = $arr[0] * 60;
    $s = $arr[1];
    return $m + $s;
}

/**
 * 时间转换
 */
function timeRover($seconds) {
    $seconds = (int) $seconds;
    if ($seconds > 3600) {
        if ($seconds > 24 * 3600) {
            $days = (int) ($seconds / 86400);
            $days_num = $days . "天";
            $seconds = $seconds % 86400; //取余
        }
        $hours = intval($seconds / 3600);
        $minutes = $seconds % 3600; //取余下秒数
        $time = $days_num . str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" . gmstrftime('%M:%S', $minutes);
    } else {
        $time = gmstrftime('%H:%M:%S', $seconds);
    }
    return $time;
}

function to_tree($data, $parent_id = 0, $pid = 'parent_id', $id = 'id')
{
    $list = [];

    foreach ($data as $v) {
        if ($v[$pid] == $parent_id) {

            $v['spread'] = false;
            
            $v['children'] = to_tree($data, $v[$id], $pid);
            
            $list[] = $v;
        }
    }
    return $list;
}

 function treeMenu(array $menu = [],  $parent = 0,  $parentKey = 'parent_id')
    {
        $tree = array();
        foreach ($menu as $v) {
            if ($v[$parentKey] == $parent) {
                $v['children'] = treeMenu($menu, $v['id'], $parentKey);
                if (empty($v['children'])) {
                    unset($v['children']);
                }
                $tree[] = $v;
            }
        }
        return $tree;
}
    function getTreeChildren(array $data, $pid = 0, $key = 'id', $contact_key = 'parent_id', $sonName = 'children')
    {
            $treeData = [];
            foreach ($data as &$item) {
                if ($item[$contact_key] == $pid) {
                    $item[$sonName] = getTreeChildren($data, $item[$key], $key, $contact_key, $sonName);
                    $treeData[] = $item;
                }
            }
            return $treeData;
    }
        
    function flattenTreeWithPrefix($tree, $prefix = '',$key="pid",$level = 1)
    {
        $result = [];
        $prefix = '';
        for($i=0;$i<=$level;$i++){
            $prefix .= '&nbsp;&nbsp;&nbsp;';
        }
        $star = $prefix;
        // 遍历树形结构
        foreach ($tree as $k=> $node) {
            $prefix = '';
            if($node[$key] != 0){
                // 为当前节点的名称添加前缀
                if($k == 0 && !isset($tree[$k+1])){
                    $prefix = $star.'└─ '.$prefix;
                }elseif(isset($tree[$k+1])){
                    $prefix = $star.'├─ '.$prefix;
                }else{
                    $prefix = $star.'└─ '.$prefix;
                }
            }
            
            $node['tree_label'] = $prefix;
            $result[] = $node;  // 将当前节点加入结果数组
    
            // 如果节点有子节点，递归处理
            if (!empty($node['children'])) {
                if($node[$key] == 0){
                    $level = 1;
                }
                // 在子级前增加一个前缀
                $level = $level +1;
                $result = array_merge($result, flattenTreeWithPrefix($node['children'], $prefix . '',$key,$level));
            }
        }
    
        return $result;
    }    

/**
 * 从 plate_conts_logs 一行数据里取出“产品规格”的值
 * key_0~key_7 是可自定义的列标签，不同商品/不同批次导入的顺序可能不一样，
 * “产品规格”不一定固定在 value_7，这里按标签文本找到实际所在列再取值
 * @param array $row plate_conts_logs 的一行（需包含 key_0..key_7 / value_0..value_7）
 * @return string|null 找不到对应标签时返回 null
 */
function plateContsLogSpec($row) {
    for ($i = 0; $i <= 7; $i++) {
        $keyField = 'key_' . $i;
        if (isset($row[$keyField]) && trim($row[$keyField]) === '产品规格') {
            $valField = 'value_' . $i;
            return isset($row[$valField]) ? trim($row[$valField]) : '';
        }
    }
    return null;
}

require "local.php";
require "trans.php";
