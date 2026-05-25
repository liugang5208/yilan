<?php
use Think\Log;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function priceType($id) {
    $ret = "";
    #
    $id == "1" ? $ret = "多属性商品" : null;
    $id == "2" ? $ret = "商品列表" : null;
    $id == "3" ? $ret = "店铺" : null;
    #
    return $ret;
}

function showType($id) {
    $ret = "";
    #
    $id == "1" ? $ret = "单一占位" : null;
    $id == "2" ? $ret = "两格占位" : null;
    $id == "3" ? $ret = "三格占位" : null;
    $id == "4" ? $ret = "四格占位" : null;
    #
    return $ret;
}

/**
 * 账户类别
 */
function acType($id) {
    $ret = "";
    #
    $id == "0" ? $ret = "个人用户" : null;
    $id == "1" ? $ret = "店铺经销" : null;
    $id == "2" ? $ret = "企业单位" : null;
    #
    return $ret;
}

/**
 * 发票
 */
function acTex($id) {
    $ret = "";
    #
    $id == "0" ? $ret = "不含发票" : null;
    $id == "1" ? $ret = "普通发票" : null;
    $id == "2" ? $ret = "专用发票" : null;
    #
    return $ret;
}

/**
 * 运费
 */
function acTrans($id) {
    $ret = "";
    #
    $id == "0" ? $ret = "不含运费" : null;
    $id == "1" ? $ret = "含运费" : null;
    #
    return $ret;
}

/**
 * 订单状态
 */
function acOrds($id) {
    $ret = "";
    #
    $id == "0" ? $ret = "待付款" : null;
    $id == "1" ? $ret = "待发货" : null;
    $id == "2" ? $ret = "待收货" : null;
    $id == "3" ? $ret = "已完成" : null;
    $id == "-1" ? $ret = "已取消" : null;
    #
    return $ret;
}

/**
 * 支付模式
 */
function acPay($id) {
    $ret = "";
    #
    $id == "0" ? $ret = "在线支付" : null;
    $id == "1" ? $ret = "货到付款" : null;
    $id == "2" ? $ret = "平台代发货" : null;
    $id == "3" ? $ret = "银行转账" : null;
    $id == "4" ? $ret = "签约商户" : null;
    #
    return $ret;
}

/**
 * 支付模式
 */
function acPaytrs($id, $mode) {
    $ret = "";
    #
    if ($mode < 3) {
        $id == "1" ? $ret = "微信端支付" : null;
        $id == "2" ? $ret = "支付宝支付" : null;
        return $ret;
    }
    $mode == "3" ? $ret = "银行卡转款" : null;
    $mode == "4" ? $ret = "赊销后付款" : null;
    #
    return $ret;
}

function fromDate($date){
    if($date){
        $date = date('Y-m-d H:i:s',$date);
    }else{
        $date = '';
    }
    return $date;
}
function cUrl($url, $params, $method = 'POST', $header = array())
{
    $opts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header
    );
    /* 根据请求类型设置特定参数 */
    switch (strtoupper($method)) {
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        case "DELETE":
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            break;
        case "PUT":
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    // if ($error)  return $data;
    if ($error) {
          Log::record(9999999999999999, 'DEBUG');
          Log::record('请求发生错误：' . $error, 'DEBUG');
    }
        // throw new Exception('请求发生错误：' . $error);
    return $data;
}
