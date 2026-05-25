<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 获取规格详细信息
 * @param type $id
 */
function getSpecInfo($id) {
    $goods_spec = M("goods_spec");
    $goods_attr = M("goods_attr");
    $goods = M("goods");
    #
    $where["id"] = $id;
    $res["info"] = $goods_spec->where($where)->find();
    if ($res["info"] == NULL) {
        return [];
    }
    #
    $res["ginfo"] = $goods->find($res["info"]["g_id"]);
    #
    $cond = ["g_id" => $res["info"]["g_id"], "sn" => $res["info"]["sn"]];
    $res["gattr"] = $goods_attr->where($cond)->find();
    #
    return $res;
}

////////////////////////////////////////////////////////////////////////////////

/**
 * 用户地址
 */
function usrAddr($id) {
    $users_addr = M("users_addr");
    #
    $where["uid"] = $id;
    $adlist = $users_addr->where($where)->order("def desc,id desc")->select();
    foreach ($adlist as $k => $v) {
        $adlist[$k]["p_name"] = getRegionName($v["prov"]);
        $adlist[$k]["c_name"] = getRegionName($v["city"]);
        $adlist[$k]["l_name"] = getRegionName($v["label"]);
    }
    return $adlist;
}

/**
 * 获取用户默认地址
 */
function usrDefAddr($id) {
    $users_addr = M("users_addr");
    #
    $where["uid"] = $id;
    $adlist = $users_addr->where($where)->order("def desc,id desc")->select();
    foreach ($adlist as $k => $v) {
        if ($v["def"] > 0) {
            return $k;
        }
    }
    #
    return -1;
}

////////////////////////////////////////////////////////////////////////////////
