<?php
use Think\Log;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 转化HTML-WEBURL
 */
function replaceHtml($txt) {
    $temp = htmlspecialchars_decode($txt);
    #
    $res = str_replace("/Public/", C("WEBURL") . "Public/", $temp);
    return $res;
}

/**
 * 图片转base64
 * @param type $img_file
 * @return string
 */
function imgToBase64($img_file) {
    $img_base64 = '';
    if (file_exists($img_file)) {
        $app_img_file = $img_file; // 图片路径
        $img_info = getimagesize($app_img_file); // 取得图片的大小，类型等
        //echo '<pre>' . print_r($img_info, true) . '</pre><br>';
        $fp = fopen($app_img_file, "r"); // 图片是否可读权限
        if ($fp) {
            $filesize = filesize($app_img_file);
            $content = fread($fp, $filesize);
            $file_content = chunk_split(base64_encode($content)); // base64编码
            switch ($img_info[2]) {           //判读图片类型
                case 1: $img_type = "gif";
                    break;
                case 2: $img_type = "jpg";
                    break;
                case 3: $img_type = "png";
                    break;
            }
            $img_base64 = 'data:image/' . $img_type . ';base64,' . $file_content; //合成图片的base64编码
        }
        fclose($fp);
    }
    return $img_base64; //返回图片的base64
}

/**
 * 获取区域名称
 * @param type $id
 */
function getRegionName($id) {
    $sysregion = M("sysregion");
    #
    $where["id"] = $id;
    $info = $sysregion->where($where)->find();
    #
    return $info["name"];
}

function convertToTree($flatData) {
    // 按类型分组：1=省，2=市，3=区
    $provinces = [];
    $cities = [];
    $districts = [];
    
    foreach ($flatData as $item) {
        if ($item['type'] == '1') {
            $provinces[$item['id']] = [
                'text' => $item['name'],
                'value' => $item['id'],
                'children' => []
            ];
        } elseif ($item['type'] == '2') {
            $cities[$item['id']] = [
                'text' => $item['name'],
                'value' => $item['id'],
                'children' => []
            ];
        } elseif ($item['type'] == '3') {
            $districts[$item['id']] = [
                'text' => $item['name'],
                'value' => $item['id']
            ];
        }
    }
    
    // 处理区级数据：挂载到市级
    foreach ($districts as $id => $district) {
        $cityId = $flatData[$id]['parent'] ? $flatData[$id]['parent'] : null;
        if ($cityId && isset($cities[$cityId])) {
            $cities[$cityId]['children'][] = $district;
        }
    }
    
    // 处理市级数据：挂载到省级
    foreach ($cities as $id => $city) {
        $provinceId = $flatData[$id]['parent'] ? $flatData[$id]['parent'] : null;
        if ($provinceId && isset($provinces[$provinceId])) {
            $provinces[$provinceId]['children'][] = $city;
        }
    }
    
    // 处理直辖市：合并省市级
    $tree = [];
    foreach ($provinces as $id => $province) {
        // 如果是直辖市（如北京），需要合并省市级
        // if (in_array($province['text'], ['北京', '天津', '上海', '重庆'])) {
        //     if (!empty($province['children'])) {
        //         // 取出第一个市级（北京只有一个"北京市"）
        //         $city = reset($province['children']);
        //         // 合并为：省名 = 市名
        //         $province['children'] = [
        //             [
        //                 'text' => $city['text'],
        //                 'value' => $city['value'],
        //                 'children' => $city['children']
        //             ]
        //         ];
        //     }
        // }
        
        $tree[] = $province;
    }
    
    return array_values($tree);
}

/**
 * 获取区域名称
 * @param type $name
 */
function getRegionID($name) {
    $sysregion = M("sysregion");
    #
    $where["name"] = array("like", "%" . $name . "%");
    $info = $sysregion->where($where)->find();
    #
    return $info["id"];
}

/**
 * 获取分类名称
 * @param type $id
 */
function getKCatsName($id) {
    $know_cat = M("know_cat");
    #
    $where["id"] = $id;
    $info = $know_cat->where($where)->find();
    #
    return $info["name"];
}

////////////////////////////////////////////////////////////////////////////////

/**
 * 获取期所名称
 * @param type $id
 */
function getExcName($id, $alt = null) {
    $plate_cats_exc = M("plate_cats_exc");
    #
    $where["id"] = $id;
    $info = $plate_cats_exc->where($where)->find();
    if ($info == null) {
        return null;
    }
    if ($alt != null) {
        return $info[$alt];
    }
    #
    return $info;
}

/**
 * 获取分类名称
 * @param type $id
 */
function getCatsName($id, $alt = null) {
    $plate_cats = M("plate_cats");
    #
    $where["id"] = $id;
    $info = $plate_cats->where($where)->find();
    if ($info == null) {
        return null;
    }
    if ($alt != null) {
        return $info[$alt];
    }
    #
    return $info;
}

/**
 * 获取虚拟构建商品信息
 */
function getplateConts($id) {
    $plate_conts = M("plate_conts");
    #
    $where["id"] = $id;
    $info = $plate_conts->where($where)->find();
    #
    return $info;
}

/**
 * 获取内容分类
 * @param type $id
 */
function getplateBlank($id, $index, $alt = null) {
    $plate_conts_blank = M("plate_conts_blank");
    #
    $where["pid"] = $id;
    $where["cat_index"] = $index;
    $info = $plate_conts_blank->where($where)->find();
    if ($info == null) {
        return null;
    }
    if ($alt != null) {
        return $info[$alt];
    }
    #
    return $info;
}

/**
 * 商品-A
 * @return type
 */
function getplateContslogs($id) {
    $plate_conts_logs = M("plate_conts_logs");
    #
    $where["id"] = $id;
    $info = $plate_conts_logs->where($where)->find();
    if ($info == null) {
        return null;
    }
    $blank = getplateBlank($info["pid"], $info["cat_index"]);
    $conts = getplateConts($blank["pid"]);
    $cats = getCatsName($conts["catid"]);
    $info["catid"] = $conts["catid"];
    $info["ratio"] = setRatio($blank, $cats);
    $info["_cate"] = $cats;
    #$info["market"] = round($info["ratio"] * $info["price"], 2);
    #
    return $info;
}

/**
 * 商品-B
 * @return type
 */
function getplateContslogsr($id) {
    $plate_conts_logsr = M("plate_conts_logsr");
    #
    $where["id"] = $id;
    $info = $plate_conts_logsr->where($where)->find();
    if ($info == null) {
        return null;
    }
    $logs = getplateContslogs($info["pid"]);
    $blank = getplateBlank($logs["pid"], $logs["cat_index"]);
    $conts = getplateConts($blank["pid"]);
    $cats = getCatsName($conts["catid"]);
    $info["catid"] = $conts["catid"];
    $info["catname"] = $blank["catname"];
    $info["ratio"] = setRatio($blank, $cats);
    #$info["market"] = round($info["ratio"] * $info["price"], 2);
    #
    return $info;
}

////////////////////////////////////////////////////////////////////////////////

/**
 * 获取银行卡号
 */
function getBankList($type) {
    $sys_banks = M("sys_banks");
    #
    $where["types"] = $type;
    $where["status"] = 1;
    $list = $sys_banks->where($where)->select();
    if ($type > 0) {
        $where["check"] = 1;
        $res["tic_1"] = $sys_banks->where($where)->find();
        $where["check"] = 2;
        $res["tic_2"] = $sys_banks->where($where)->find();
        return $res;
    }
    #
    return $list;
}

/**
 * 获取订单地址信息
 * @param type $id
 */
function getAddrName($id) {
    $users_addr = M("users_addr");
    #
    $where["id"] = $id;
    $info = $users_addr->where($where)->find();
    if ($info != NULL) {
        $info["p_name"] = getRegionName($info["prov"]);
        $info["c_name"] = getRegionName($info["city"]);
        $info["l_name"] = getRegionName($info["label"]);
    }
    #
    return $info;
}

/**
 * 获取物流信息
 * @param type $id
 */
function getTransName($id) {
    $trans = M("trans");
    #
    $where["id"] = $id;
    $info = $trans->where($where)->find();
    #
    return $info["name"];
}

/**
 * 获取用户信息
 * @param type $id
 */
function getUsersName($id, $alt = NULL) {
    $users = M("users");
    #
    $where["id"] = $id;
    $info = $users->where($where)->find();
    if ($info == null) {
        return "";
    }
    if ($alt != NULL) {
        return $info[$alt];
    }
    #
    return $info;
}

/**
 * 获取用户等级
 * @param type $id
 */
function getUsersLv($id) {
    $users_level = M("users_level");
    #
    $where["id"] = $id;
    $info = $users_level->where($where)->find();
    #
    return $info["level"];
}

/**
 * 获取公司信息
 * @param type $id
 */
function getTicketComp($id, $alt = null) {
    $users_ticket = M("users_ticket");
    #
    $where["id"] = $id;
    $info = $users_ticket->where($where)->find();
    if ($info == null) {
        return "";
    }
    if ($alt != null) {
        return $info[$alt];
    }
    #
    return $info;
}

/**
 * 获取手机地址
 */
function getPhoneArea($phone) {
    $url = "https://www.baifubao.com/callback?cmd=1059&callback=json&phone=" . $phone;
    $temp = file_get_contents($url);
    $decd = explode("json(", $temp);
    $trim = trim($decd[1], ")");
    $res = json_decode($trim, true);
    #
    return $res["data"]["area_operator"];
}

////////////////////////////////////////////////////////////////////////////////

/**
 * 保存图片到指定位置
 */
function saveImageToFile2($pre, $base64_image_content, $file) {
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        // Log::record($type, 'DEBUG');
        // 创建 PNG 图片资源
            if($type == 'png'){
                $image = imagecreatefrompng('data://'.$base64_image_content);
                if(!$image){
                     $image = imagecreatefromjpeg('data://'.$base64_image_content);
                }
            }elseif($type == 'jpg' || $type = 'jpeg'){
                $image = imagecreatefromjpeg('data://'.$base64_image_content);
                if(!$image){
                    $image = imagecreatefrompng('data://'.$base64_image_content);
                }
            }
            
            // 创建 JPG 文件路径
            $new_file = "./././Public/uploads/" . $file . "/";
            if (!file_exists($new_file)) {
                mkdir($new_file, 0777, true); // 创建多级目录
            }
            $file_name = $pre . uniqid(true) . ".jpg";
            $new_file = $new_file . $file_name;
            // // Log::record([22232323234667], 'DEBUG');
            //  Log::record($new_file, 'DEBUG');
            // 将 PNG 图片保存为 JPG 格式
            if (imagejpeg($image, $new_file, 100)) { // 第三个参数表示 JPG 质量，范围从 0（最差）到 100（最佳）
                imagedestroy($image); // 释放内存
                return "/" . $file . "/" . $file_name;
            } else {
                return false;
            }
    }
    return false;
}
function saveImageToFile($pre, $base64_image_content, $file) {
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        $new_file = "./././Public/uploads/" . $file . "/";
        if (!file_exists($new_file)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        #
        $file_name = $pre . uniqid(true) . ".{$type}";
        $new_file = $new_file . $file_name;
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
            return "/" . $file . "/" . $file_name;
        }
        return false;
    }
    return false;
}

/**
 * 单个商品
 */
function lists_sigl($v, $up) {
    $plate_conts = M("plate_conts");
    $plate_conts_logs = M("plate_conts_logs");
    $plate_conts_blank = M("plate_conts_blank");
    #
    $conts = $plate_conts->find($v["cont_id"]);
    $logs = $plate_conts_logs->find($v["logs_id"]);
    $blank = $plate_conts_blank->where(["pid" => $logs["pid"], "cat_index" => $logs["cat_index"]])->find();
    $temp = getplateContslogs($v["logs_id"]);
    #
    $res = array(
        "name" => $blank["gnames"],
        "imgs" => C("WEBIMG") . "goods/" . $blank["gimage"],
        "attr1" => $logs["key_0"] . "：<span>" . $logs["value_0"] . "</span>",
        "attr2" => $logs["key_1"] . "：<span>" . $logs["value_1"] . "</span>",
        "attr3" => $logs["key_2"] . "：<span>" . $logs["value_2"] . "</span>",
        "catname" => $blank["catname"],
        "unit" => $conts["g_unit"],
        "market" => round($temp["market"] * $up * $v["ticket_fee"], 2),
        "nums" => $v["nums"],
    );
    return $res;
}

/**
 * 多个商品
 * @param type $v
 * @return type
 */
function lists_more($v, $up) {
    $plate_conts = M("plate_conts");
    $plate_conts_logs = M("plate_conts_logs");
    $orders_goods_logs = M("orders_goods_logs");
    #
    $conts = $plate_conts->find($v["cont_id"]);
    $logs = $plate_conts_logs->find($v["logs_id"]);
    #
    $cond = ["oid" => $v["oid"], "cont_id" => $v["cont_id"], "logs_id" => $v["logs_id"]];
    $list = $orders_goods_logs->where($cond)->select();
    $total = 0;
    foreach ($list as $m => $s) {
        $temp = getplateContslogsr($s["g_id"]);
        $temp["market"] = round($s["market"] * $up * $v["ticket_fee"], 2);
        #
        $list[$m]["info"] = $temp;
        $total = $total + $s["nums"];
    }
    #
    $res = array(
        "name" => $logs["gnames"],
        "imgs" => C("WEBIMG") . "goods/" . $logs["source"],
        "attr1" => $logs["key_0"] . "<span>：" . $logs["value_0"] . "</span>",
        "attr2" => $logs["key_1"] . "<span>：" . $logs["value_1"] . "</span>",
        "attr3" => $logs["key_2"] . "<span>：" . $logs["value_2"] . "</span>",
        "unit" => $conts["g_unit"],
        "child" => $list,
        "nums" => $total,
    );
    return $res;
}

function listCover($list) {
    $length = count($list);
    $res = array();
    #
    for ($i = 0; $i < $length; $i = $i + 2) {
        $res[] = array(
            $list[$i],
            $list[$i + 1],
        );
    }
    return $res;
}

/**
 * 数字金额转换成中文大写金额的函数
 * String Int $num 要转换的小写数字或小写字符串
 * return 大写字母
 * 小数位为两位
 * */
function num_to_rmb($num) {
    $c1 = "零壹贰叁肆伍陆柒捌玖";
    $c2 = "分角元拾佰仟万拾佰仟亿";
    //精确到分后面就不要了，所以只留两个小数位
    $num = round($num, 2);
    //将数字转化为整数
    $num = $num * 100;
    if (strlen($num) > 10) {
        return "金额太大，请检查";
    }
    $i = 0;
    $c = "";
    while (1) {
        if ($i == 0) {
            //获取最后一位数字
            $n = substr($num, strlen($num) - 1, 1);
        } else {
            $n = $num % 10;
        }
        //每次将最后一位数字转化为中文
        $p1 = substr($c1, 3 * $n, 3);
        $p2 = substr($c2, 3 * $i, 3);
        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
            $c = $p1 . $p2 . $c;
        } else {
            $c = $p1 . $c;
        }
        $i = $i + 1;
        //去掉数字最后一位了
        $num = $num / 10;
        $num = (int) $num;
        //结束循环
        if ($num == 0) {
            break;
        }
    }
    $j = 0;
    $slen = strlen($c);
    while ($j < $slen) {
        //utf8一个汉字相当3个字符
        $m = substr($c, $j, 6);
        //处理数字中很多0的情况,每次循环去掉一个汉字“零”
        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
            $left = substr($c, 0, $j);
            $right = substr($c, $j + 3);
            $c = $left . $right;
            $j = $j - 3;
            $slen = $slen - 3;
        }
        $j = $j + 3;
    }
    //这个是为了去掉类似23.0中最后一个“零”字
    if (substr($c, strlen($c) - 3, 3) == '零') {
        $c = substr($c, 0, strlen($c) - 3);
    }
    //将处理的汉字加上“整”
    if (empty($c)) {
        return "零元整";
    } else {
        return $c . "整";
    }
}

/**
 * 设置费率
 */
function setRatio($v, $cat) {
    $baseRatio = 100;
    #
    $firstRatio = $baseRatio * (1 + $v["up_a"] / 100) * (1 - $v["down_a"] / 100);
    $secondRatio = $firstRatio * (1 + $v["up_b"] / 100) * (1 - $v["down_b"] / 100);
    $thirdRatio = $secondRatio * (1 + $v["up_c"] / 100) * (1 - $v["down_c"] / 100);
    $forthRatio = $thirdRatio * (1 + $v["up_d"] / 100) * (1 - $v["down_d"] / 100);
    $fiveRatio = $forthRatio * (1 + $v["up_e"] / 100) * (1 - $v["down_e"] / 100);
    $sixRatio = $fiveRatio * (1 + $v["up_f"] / 100) * (1 - $v["down_f"] / 100);
    $sevenRatio = $sixRatio * (1 + $cat["up"] / 100) * (1 - $cat["down"] / 100);
    #
    return $sevenRatio / 100;
}

/**
 * 设置费率-分类
 */
function setCatRatio($cats) {
    $baseRatio = 100;
    if ($cats == NULL) {
        return 0;
    }
    #
    $firstRatio = $baseRatio * (1 + $cats["up"] / 100) * (1 - $cats["down"] / 100);
    return $firstRatio / 100;
}

/**
 * 设置费率-板块
 */
function setBlankRatio($blank) {
    $baseRatio = 100;
    if ($blank == NULL) {
        return $baseRatio / 100;
    }
    #
    $firstRatio = $baseRatio * (1 + $blank["up_a"] / 100) * (1 - $blank["down_a"] / 100);
    $secondRatio = $firstRatio * (1 + $blank["up_b"] / 100) * (1 - $blank["down_b"] / 100);
    $thirdRatio = $secondRatio * (1 + $blank["up_c"] / 100) * (1 - $blank["down_c"] / 100);
    $forthRatio = $thirdRatio * (1 + $blank["up_d"] / 100) * (1 - $blank["down_d"] / 100);
    $fiveRatio = $forthRatio * (1 + $blank["up_e"] / 100) * (1 - $blank["down_e"] / 100);
    $sixRatio = $fiveRatio * (1 + $blank["up_f"] / 100) * (1 - $blank["down_f"] / 100);
    #
    return $sixRatio / 100;
}

/**
 * 登录
 */
function ipLogin($uid) {
    $ip = getIP();
    $url = "http://ip-api.com/json/" . $ip . "?lang=zh-CN";
    #
    $temp = poCurl($url, []);
    $data = json_decode($temp, true);
    if ($data["status"] != "success") {
        return false;
    }
    #
    $puts["uid"] = $uid;
    $puts["ip"] = $ip;
    $puts["prov"] = getRegionID(str_replace("省", "", $data["regionName"]));
    $puts["city"] = getRegionID($data["city"]);
    $puts["label"] = 0;
    $puts["timr"] = 0;
    $puts["times"] = time();
    $puts['prov_name'] = $data["regionName"];
    $puts['city_name'] = $data["city"];
    #
    return M("users_logs")->add($puts);
}

/**
         * 金额转中文大写
         *
         * @param  mixed  $amount
         * @return string
         */
        function rmb_capital($amount)
        {
            $capitalNumbers = [
                '零', '壹', '贰', '參', '肆', '伍', '陸', '柒', '捌', '玖',
            ];
    
            $integerUnits = ['', '拾', '佰', '仟',];
    
            $placeUnits = ['', '万', '亿', '兆',];
    
            $decimalUnits = ['角', '分', '厘', '毫',];
    
            $result = [];
    
            $arr = explode('.', $amount);
    
            $integer = trim($arr[0] ? $arr[0]: '', '-');
            $decimal = $arr[1] ?$arr[1]: '';
    
            if (!((int) $decimal)) {
                $decimal = '';
            }
    
            // 转换整数部分
            // 从个位开始
    
            $integerNumbers = $integer ? array_reverse(str_split($integer)) : [];
    
            $last = null;
            foreach (array_chunk($integerNumbers, 4) as $chunkKey => $chunk) {
                if (!((int) implode('', $chunk))) {
                    // 全是 0 则直接跳过
                    continue;
                }
    
                array_unshift($result, $placeUnits[$chunkKey]);
    
                foreach ($chunk as $key => $number) {
                    // 去除重复 零，以及第一位的 零，类似：1002、110
                    if (!$number && (!$last || $key === 0)) {
                        $last = $number;
                        continue;
                    }
                    $last = $number;
    
                    // 类似 1022，中间的 0 是不需要 佰 的
                    if ($number) {
                        array_unshift($result, $integerUnits[$key]);
                    }
    
                    array_unshift($result, $capitalNumbers[$number]);
                }
            }
    
            if (!$result) {
                array_push($result, $capitalNumbers[0]);
            }
    
            array_push($result, '元');
    
            if (!$decimal) {
                array_push($result, '整');
            }
    
            // 转换小数位
            $decimalNumbers = $decimal ? str_split($decimal) : [];
            foreach ($decimalNumbers as $key => $number) {
                array_push($result, $capitalNumbers[$number]);
                array_push($result, $decimalUnits[$key]);
            }
    
            if (strpos((string) $amount, '-') === 0) {
                array_unshift($result, '负');
            }
    
            return implode('', $result);
        }

