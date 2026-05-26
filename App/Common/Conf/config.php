<?php

$domin = array("x", "localhost", "192.168.2.4",);
$status = array_search($_SERVER["SERVER_NAME"], $domin);
#
#$weburl = $status ? "http://localhost/yilan/" : "http://app.elccc.cn/";
$weburl = $status ? "http://localhost:8088/" : "http://app.elccc.cn/";
#$weburl = "http://app.elccc.cn/";
$webimg = $weburl . "Public/uploads/";

return array(
    'DB_TYPE' => 'mysql',
    // 线上阿里云 RDS
//     'DB_HOST' => $status ? "rm-2vc6829svs8ryr69h.mysql.cn-chengdu.rds.aliyuncs.com" : "rm-2vc6829svs8ryr69h.mysql.cn-chengdu.rds.aliyuncs.com",
//     'DB_NAME' => $status ? "online_elccc_cn" : "online_elccc_cn",
//     'DB_USER' => $status ? "elccc" : "elccc",
//     'DB_PWD' => $status ? "123qwe!!" : "123qwe!!",
    // 本地开发
    'DB_HOST' => "127.0.0.1",
    'DB_NAME' => "online_elccc_cn",
    'DB_USER' => "root",
    'DB_PWD' => "",
    'DB_PORT' => 3306,
    'DB_PREFIX' => '',
    'URL_MODEL' => 2,
    'APP_URL'   => $status ? 'http://localhost:8088' : '',
    'PAY_MODEL' => 0,
    "LAYOUT_ON" => true,
    "LAYOUT_NAME" => "layout",
    //WEB
    'WEBURL' => $weburl,
    'WEBIMG' => $webimg,
    'SOCKET' => "//",
    //LIBS
    "WEC_CONFIG" => array(
        #wechat account
        "APPID" => "wx7ddb338315641d37",
        "APPSECRET" => "",
        "TOKEN" => "",
        "MCHID" => "1559060311",
        "PAYKEY" => "75296326b349b2c2231b4e5f5c5a6cb0",
        "notifyUrl" => $weburl . "/Inter/Wcins/respay.html",
    ),
    "GD_WEB" => "ce78dc6e077e481f0d90115b54ffb0b7",
    "GD_CONF" => array(
        "WEBSR" => "ce78dc6e077e481f0d90115b54ffb0b7",
    ),
    'SMS_CONF' => array(
        "ACCOUNT" => "C99427622",
        "PASSWD" => "a9034e31128920f3b302fb062f288564"
    ),
    "ALI_CONFIG" => array(
        "APPID" => "2021002147614527",
        "AESKEY" => "uIEK6ktb56fug1VPPtMw6Q==",
    ),
);
