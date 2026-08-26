<?php

namespace Home\Controller;

class ReportInfoController extends CommController {

    public function index() {
        $orders = M("report_info");
        $post = I("get.");
        $where = array();
        
        // 1. SN单号模糊搜索
        if(isset($post["sn"]) && $post["sn"] != null) {
            $where["sn"] = array("like", "%" . trim($post["sn"]) . "%");
        }
        
        // 2. 手机号筛选（关联 users 表获取用户数据）
        if(isset($post["phone"]) && $post["phone"] != null) {
            $where["_string"] = "uid in (select id from users where phone like '%" . trim($post["phone"]) . "%')";
        }
        
        // 3. 项目名称搜索 (project_comp)
        if(isset($post["project_comp"]) && trim($post["project_comp"]) !== '') {
            $where["project_comp"] = array("like", "%" . trim($post["project_comp"]) . "%");
        }
        
        // 4. 报价单位搜索 (rep_comp)
        if(isset($post["rep_comp"]) && trim($post["rep_comp"]) !== '') {
            $where["rep_comp"] = array("like", "%" . trim($post["rep_comp"]) . "%");
        }
        
        // 5. 询价单位搜索 (question_comp)
        if(isset($post["question_comp"]) && trim($post["question_comp"]) !== '') {
            $where["question_comp"] = array("like", "%" . trim($post["question_comp"]) . "%");
        }
        
        // 6. 报价姓名搜索 (rep_user)
        if(isset($post["rep_user"]) && trim($post["rep_user"]) !== '') {
            $where["rep_user"] = array("like", "%" . trim($post["rep_user"]) . "%");
        }
        
        // 7. 发票状态筛选 (ticket)
        if(isset($post["ticket"]) && $post["ticket"] !== '') {
            $where["ticket"] = intval($post["ticket"]);
        }
        
        if(isset($post["status"]) && $post["status"] !== '') {
            $where["status"] = intval($post["status"]);
        } else {
            if(!isset($where["status"])) {
                $where["status"] = array("egt", 0);
            }
        }
        
        // ==========================================
        // 新增核心：精准计算全量统计数据（含筛选条件）
        // ==========================================
        // A. 计算当前筛选条件下的【全量总记录数】
        $total_count = $orders->where($where)->count();
        $total_count = $total_count ? $total_count : 0;

        // B. 计算当前筛选条件下的【全量总金额】
        $sum_money = $orders->where($where)->sum('money');
        $sum_money = $sum_money ? $sum_money : 0.00;

        // 8. 结合系统自带分页函数获取当前页列表数据
        $list = boPage($orders, $where, "id desc");
        
        // 9. 关联查询用户详细信息（对接 users 表）
        foreach ($list['list'] as $k => $v){
            $user_info = M('users')->where(array('id' => $v['uid']))->find();
            $list['list'][$k]['_user'] = $user_info ? $user_info : array('phone' => $v['rep_phone'], 'tags' => '-');
        }
        
        // 10. 将统计数据安全注入到数组和模板变量中，确保前端百分之百读到
        $list['count'] = $total_count;
        $list['sum_money'] = round($sum_money, 2);
        
        $this->assign("count", $total_count);
        $this->assign("sum_money", round($sum_money, 2));
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 订单详情（已完美修正：实时动态从数据库与分类配置中读取属性字段标题与内容）
     */
    public function infos($id) {
        $orders = M("report_info");
        $orders_trans = M("report_info_log");
        
        $where["id"] = $id;
        $info = $orders->where($where)->find();
        
        // 获取当前报价单关联的商品明细列表
        $goods_list = $orders_trans->where(array('repid' => $id))->select();
        
        // 核心优化：动态读取数据库后台分类或属性配置中的真实字段标题，彻底解决强制默认名字问题
        if(!empty($goods_list)){
            foreach($goods_list as $k => $v){
                
                // 1. 尝试从商品所属分类或关联表中动态读取后台设定的字段标题（如 电压等级、产品型号、产品规格 等）
                // 如果明细里自带了对应的标题字段，则直接读取；若数据库未记录，则通过分类ID动态向商城商品配置表或分类表检索
                $cat_id = isset($v['catid']) ? intval($v['catid']) : 0;
                $dynamic_titles = array();
                if($cat_id > 0) {
                    // 联查商城分类表获取后台管理员自定义的属性标题
                    $cat_info = M('category')->where(array('id' => $cat_id))->find();
                    if($cat_info) {
                        $dynamic_titles['title1'] = isset($cat_info['title1']) && !empty($cat_info['title1']) ? $cat_info['title1'] : '';
                        $dynamic_titles['title2'] = isset($cat_info['title2']) && !empty($cat_info['title2']) ? $cat_info['title2'] : '';
                        $dynamic_titles['title3'] = isset($cat_info['title3']) && !empty($cat_info['title3']) ? $cat_info['title3'] : '';
                    }
                }

                // 2. 将从数据库实时读取到的标题赋予当前明细项（若数据库查不到，则赋予空，交由前端做兜底降级）
                $v['title1'] = !empty($v['title1']) ? $v['title1'] : (isset($dynamic_titles['title1']) ? $dynamic_titles['title1'] : '');
                $v['title2'] = !empty($v['title2']) ? $v['title2'] : (isset($dynamic_titles['title2']) ? $dynamic_titles['title2'] : '');
                $v['title3'] = !empty($v['title3']) ? $v['title3'] : (isset($dynamic_titles['title3']) ? $dynamic_titles['title3'] : '');

                // 3. 严格清洗属性数值，去除多余的前缀污染，保持数据纯净
                if(isset($v['attr1']) && !empty($v['attr1'])) {
                    $v['attr1'] = trim(str_ireplace(array('电压等级:', '电压等级：'), '', $v['attr1']));
                }
                if(isset($v['attr2']) && !empty($v['attr2'])) {
                    $v['attr2'] = trim(str_ireplace(array('产品型号:', '产品型号：', '型号:', '型号：'), '', $v['attr2']));
                }
                if(isset($v['attr3']) && !empty($v['attr3'])) {
                    $v['attr3'] = trim(str_ireplace(array('产品规格:', '产品规格：', '规格:', '规格：'), '', $v['attr3']));
                }
                
                // 4. 子项多规格联动清洗与动态读取
                if(isset($v['child']) && is_array($v['child'])) {
                    foreach($v['child'] as $ck => $cv) {
                        if(isset($cv['attr1'])) {
                            $v['child'][$ck]['attr1'] = trim(str_ireplace(array('电压等级:', '电压等级：'), '', $cv['attr1']));
                        }
                    }
                }
                
                // 5. 将处理好的完整明细放回数组
                $goods_list[$k] = $v;
            }
        }
        
        $goods['list'] = $goods_list;
        
        $this->assign("info", $info);
        $this->assign("goods", $goods);
        $this->display();
    }

    /**
     * 全链条彻底删除报价单及关联明细（垃圾数据物理清理）
     */
    public function delete() {
        $id = I('get.id', 0, 'intval');
        if(!$id) {
            $this->error('参数错误，未找到指定的报价单！');
        }
        
        $orders = M("report_info");
        $orders_trans = M("report_info_log");
        
        // 1. 删除关联的明细记录
        $orders_trans->where(array('repid' => $id))->delete();
        
        // 2. 删除主表的报价单记录
        $res = $orders->where(array('id' => $id))->delete();
        
        if($res !== false) {
            $this->success('该报价单及相关明细已全链条彻底删除！', U('ReportInfo/index'));
        } else {
            $this->error('删除失败，请稍后重试！');
        }
    }

    /**
     * 订单详情-订单商品-订单购物车
     */
    private function index_logs($info) {
        $orders_goods = M("report_info");
        
        $where = array("oid" => $info["id"]);
        $list = $orders_goods->where($where)->select();
        
        $total = 0;
        foreach ($list as $k => $v) {
            $v["ticket_fee"] = $info["ticket_fee"];
            
            $tmp = $v["types"] > 0 ? lists_more($v, $info["user_up"]) : lists_sigl($v, $info["user_up"]);
            
            $tmp["types"] = $v["types"];
            $tmp["price"] = round($tmp["full"], 2);
            $tmp["total"] = round($tmp["price"] * $tmp["nums"], 2);
            
            $list[$k] = $tmp;
            $total = $total + $tmp["nums"];
        }
        
        return array("list" => $list, "total" => $total);
    }

    /**
     * 物流信息
     */
    public function trans_info() {
        $orders_trans = M("orders_trans");
        $post = I("post.");
        
        $where["oid"] = $post["ids"];
        $info = $orders_trans->where($where)->find();
        if ($info != NULL) {
            $info["ids"] = $info["id"];
            unset($info["id"]);
        }
        $info["oid"] = $post["ids"];
        
        return get_op_put(1, null, $info);
    }

    /**
     * 物流更新
     */
    public function trans_up() {
        $orders_trans = D("orders_trans");
        $orders = M("orders");
        $post = I("post.");
        
        $data = $orders_trans->create($post, 1);
        if (!$data) {
            return get_op_put(0, $orders_trans->getError());
        }
        $imgs = uploadFile("trans_tik");
        $imgs ? $data["trans_imgs"] = $imgs["trans_imgs"]["savename"] : null;
        
        if ($post["ids"] == NULL) {
            $data["times"] = time();
            if (!$orders_trans->add($data)) {
                return get_op_put(0, "更新失败");
            }
            $orders->where(array("id" => $post["oid"]))->save(array("status" => 2, "uptimes" => time()));
            return $this->trans_up_notify($data);
        }
        $data["uptimes"] = time();
        if (!$orders_trans->where(array("id" => $post["ids"]))->save($data)) {
            return get_op_put(0, "更新失败[0X]");
        }
        return $this->trans_up_notify($data);
    }

    /**
     * 物流通知
     */
    private function trans_up_notify($data) {
        $orders = M("orders");
        $users = M("users");
        $mess = D("Home/Mess", "Logic");
        
        $where["id"] = $data["oid"];
        $info = $orders->where($where)->find();
        if ($info == NULL) {
            return get_op_put(1, "更新成功", 404);
        }
        $uinf = $users->where(array("id" => $info["uid"]))->find();
        if ($uinf == NULL) {
            return get_op_put(1, "更新成功", 406);
        }
        $param["sn"] = $info["sn"];
        $param["phone"] = $uinf["phone"];
        $param["trans"] = $data["trans"];
        
        if (!$mess->runs($param, 1)) {
            return get_op_put(1, "更新成功", 4505);
        }
        return get_op_put(1, "更新成功", 200);
    }

}