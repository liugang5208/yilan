<?php

namespace Home\Controller;

#use Think\Controller;

class NewCateController extends CommController {

    public function index() {
        $model = M("new_cate");
        #
        // $list = boPage($model, $where, "id asc");
        // $list = $model->order('id asc')->select();
        // $list = getTreeChildren($list,0,'id','pid');
        // $list = flattenTreeWithPrefix($list,'','pid');
        // $this->assign("list", $list);
        // $cate_list = $model->where(['pid'=>0])->order('id asc')->select();
        // $this->assign("cate_list", $cate_list);
        $this->display();
    }
    
      public function ajaxCateFirst2(){

        $pid = I("post.id");
        $db = D('new_cate');
        $cate_list = $db->where(['pid'=>$pid])->order('id asc')->select();
        $pinfo = $db->where(['id'=>$pid])->find();
        foreach ($cate_list as $k=>$v){
            $cate_list[$k]['p_name'] = $pinfo['name'];

        }
        $data['cate_list']= $cate_list;
        // 二级材料对应的公共模版（最多3个），随三级列表一起加载，避免多一次请求
        $data['temp_list'] = M('new_cate_temp')->where(['new_cate_id'=>$pid])->order('sorts asc,id asc')->select();
        return get_op_put(1, "成功",$data);
    }
    
    public function ajaxCateFirst(){
         
        
        $db = D('new_cate');
        $cate_list = $db->where(['pid'=>0])->order('id asc')->select();
        $data['cate_list']= $cate_list;
        return get_op_put(1, "成功",$data);
    }
    
    public function ajaxCate(){
         
        $id = I("post.id");
        
        $db = D('new_cate');
        $info = $db->where(['id'=>$id])->find();
        $cate_list_p = $db->where(['pid'=>$id])->order('id asc')->select();
        $data['info']= $info;
        $data['cate_list_p']= $cate_list_p;
        return get_op_put(1, "成功",$data);
    }
    
    public function add() {
        $db = D('new_cate');
        $data = I("post.");
        
       
        if($data['pid'] > 0){
            $pinfo = $db->where(['id'=>$data['pid']])->find();
            if(!$pinfo){
                 return get_op_put(0, '上级不存在');
            }//var_dump($data['pid']);var_dump($pinfo);
            $pid_str = '';
            $pid_str = $pinfo['pid_str'];
            if($pid_str){
                 $pid_str = $pid_str.','.$pinfo['id'];
            }else{
                $pid_str = $pinfo['id'];
            }
           
            $data['pid_str'] = $pid_str;//var_dump($pid_str);
            $data['level'] = $pinfo['level']+1;;
        }
        #
        if (!$db->create($data, 1)) {
            return get_op_put(0, $db->getError());
        }
        $id = $db->add();
        if (!$id) {
            return get_op_put(0, "添加失败");
        }
        
        
        #
        return get_op_put(1, "添加成功");
    }
    
    public function edit() {
        $db = D('new_cate');
        $data = I("post.");
        $id = I("post.id");
        $info = $db->where(['id'=>$id])->find();
        $orgPid = $info['pid'];
        
        if($data['pid'] > 0){
            $pinfo = $db->where(['id'=>$data['pid']])->find();
            if(!$pinfo){
                 return get_op_put(0, '上级不存在');
            }
            $pid_str = '';
            $pid_str = $pinfo['pid_str'];
            if($pid_str){
                 $pid_str = $pid_str.','.$pinfo['id'];
            }else{
                $pid_str = $pinfo['id'];
            }
           
            $data['pid_str'] = $pid_str;
            $data['level'] = $pinfo['level']+1;;
        }else{
            $data['pid_str'] = '';
            $data['level'] = 1;
        }
        #
        $db->where(['id'=>$info['id']])->save($data);
         
        return get_op_put(1, "修改成功");
    }
    
    public function addGet(){
        $data = I("post.");
        $cate_label_id = $data['cate_label_id'];
        $data['cate_list'] = M('new_cate')->where(['cate_label_id'=>$cate_label_id])->select();
        $data['pid'] = 0;
        //  $data['ratio'] = 100;
        return get_op_put(1, "修改成功",$data);
    }
     public function editGet(){
        $param = I("post.");
        $data =M('new_cate')->where(['id'=>$param['id']])->find();
        $cate_label_id = $data['cate_label_id'];
        $where['id']  = array('neq',$data['id']);
        $data['cate_list'] = M('new_cate')->where($where)->where(['cate_label_id'=>$cate_label_id])->select();
        $data['ratio'] = (int)$data['ratio'];
        return get_op_put(1, "修改成功",$data);
    }
    
    public function cate_form(){
        $id = I("post.id");
        $info = M('new_cate')->where(['id'=>$id])->find();
        $list = M('new_cate_form')->where(['new_cate_id'=>$id])->order('id asc')->select();

        // 一级：衍生材料目录（cate_type=2）
        $directories = M('new_label')->where(['cate_type' => 2])->order('id asc')->select();
        $dir_map = [];
        foreach ($directories as $d) { $dir_map[$d['id']] = $d['name']; }

        // 二级：衍生材料分类（cate_type=1，挂在目录下）
        $categories = empty($dir_map) ? [] :
            M('new_label')->where(['cate_type' => 1, 'cate_label_id' => array('in', array_keys($dir_map))])->select();
        $cat_map = [];
        foreach ($categories as $c) {
            $cat_map[$c['id']] = ['name' => $c['name'], 'dir_id' => (int)$c['cate_label_id']];
        }

        // 兼容旧结构（cate_type=1, cate_label_id=0）
        $legacy_roots = M('new_label')->where(['cate_label_id' => 0, 'cate_type' => 1])->select();
        foreach ($legacy_roots as $r) {
            $cat_map[$r['id']] = ['name' => $r['name'], 'dir_id' => 0];
        }

        // 三级：材料（cate_label_id 指向分类）
        $valid_cat_ids = array_keys($cat_map);
        if (empty($valid_cat_ids)) {
            $label_list = [];
        } else {
            $label_list = M('new_label')
                ->where(['cate_label_id' => array('in', $valid_cat_ids)])
                ->order('cate_label_id asc, id asc')
                ->select();
            foreach ($label_list as $k => $v) {
                $cat   = $cat_map[$v['cate_label_id']];
                $label_list[$k]['cat_name'] = $cat['name'];
                $label_list[$k]['dir_id']   = $cat['dir_id'];
                $label_list[$k]['price']    = number_format((float)$v['price'], 2, '.', '');
                $label_list[$k]['_name']    = $cat['name'] . '-' . $v['name'] . '-' . $label_list[$k]['price'];
            }
        }
        $data['directories'] = $directories;

        foreach ($list as $k => $row) {
            $list[$k]['price']           = number_format((float)$row['price'],           2, '.', '');
            $list[$k]['calc_base_price'] = number_format((float)$row['calc_base_price'], 2, '.', '');
            $list[$k]['end_price']       = number_format((float)$row['end_price'],       2, '.', '');
        }
        $data['list'] = $list;
        $data['info'] = $info;
        $data['info']['price'] = number_format((float)$info['price'], 2, '.', '');
        $data['label_list'] = $label_list;
        return get_op_put(1, "获取成功",$data);
    }
    //切换分类
    public function cate_update(){
        $param = I("post.");
        $id = $param['id'];
        $new_label_id = $param['new_label_id'];
        $org = M('new_cate')->where(['id'=>$id])->find();
        $label = M('new_label')->where(['id'=>$new_label_id])->find();
        $price = $label['price'];
        $info = M('new_cate')->where(['id'=>$id])->save(['new_label_id'=>$new_label_id,'price'=>$price]);
        $db = M('new_cate_form');
        if($org['price'] != $price){
            $form = M('new_cate_form')->where(['new_cate_id'=>$id])->select();
            foreach ($form as $k=>$v){
                $temp['price'] = $price;
                $temp['calc_base_price'] = bcmul((string)$v['weight'],(string)$price,4);
                
                // $end_price = bcmul((string)$temp["calc_base_price"],(string)$v['extra_ratio'],4);
                $end_price = bcadd($temp["calc_base_price"],(string)$v['extra_ratio'],4);
                $temp['end_price'] = $end_price;
                $db->where(['id'=>$v['id']])->save($temp);
            }
        }
        
        return get_op_put(1, "获取成功",$data);
    }
    
    public function checkContsLog($new_cate_id){
        $blwares = D("Home/NewCate", "Opera");//var_dump($new_cate_id);
        $blwares->runs(['new_cate_id'=>$new_cate_id]);
        return true;
    }

    /**
     * 把公共模版(new_cate_temp_form)的规格明细整体镜像进某个三级材料的管理表格(new_cate_form)
     * 规格/重量/工电费补偿照抄模版，单价用该三级材料自己的单价重新算基础价/执行价
     */
    private function mirrorTempToCate($new_cate_id, $temp_id) {
        $cate = M('new_cate')->where(['id' => $new_cate_id])->find();
        if (!$cate) return false;
        $price = $cate['price'];
        $rows  = M('new_cate_temp_form')->where(['temp_id' => $temp_id])->order('sorts asc,id asc')->select();
        #
        $insert = array();
        foreach ($rows as $k => $r) {
            $calc_base_price = bcmul((string) $r['weight'], (string) $price, 4);
            $end_price       = bcadd($calc_base_price, (string) $r['extra_ratio'], 4);
            $insert[] = array(
                'new_cate_id'     => $new_cate_id,
                'number'          => $k + 1,
                'name'            => $r['name'],
                'weight'          => $r['weight'],
                'price'           => $price,
                'calc_base_price' => $calc_base_price,
                'extra_ratio'     => $r['extra_ratio'],
                'end_price'       => $end_price,
            );
        }
        M('new_cate_form')->where(['new_cate_id' => $new_cate_id])->delete();
        if ($insert) M('new_cate_form')->addAll($insert);
        return true;
    }

    /**
     * 三级材料-选择公共模版（应用后 new_cate_form 整体镜像该模版数据）
     */
    public function cate_form_use_temp() {
        $post = I("post.");
        $new_cate_id = (int) $post['id'];
        $temp_id     = (int) $post['temp_id'];
        if (!$new_cate_id) return get_op_put(0, "缺少三级材料ID");
        #
        // temp_id=0：切回自定义，只解除关联，保留当前表格数据不清空（跟“清空表格”不一样）
        if (!$temp_id) {
            M('new_cate')->where(['id' => $new_cate_id])->save(array('form_mode' => 0, 'temp_id' => 0));
            return get_op_put(1, "已切换为自定义");
        }
        $temp = M('new_cate_temp')->where(['id' => $temp_id])->find();
        if (!$temp) return get_op_put(0, "模版不存在");
        #
        M('new_cate')->where(['id' => $new_cate_id])->save(array('form_mode' => 1, 'temp_id' => $temp_id));
        $this->mirrorTempToCate($new_cate_id, $temp_id);
        $this->checkContsLog($new_cate_id);
        #
        return get_op_put(1, "已应用模版");
    }

    public function cate_form_import(){
        $post = I("post.");
        #
        // 公共模板模式：不使用上传的文件内容，直接从关联模版重新同步
        $cate = M('new_cate')->where(['id' => $post['id']])->find();
        if ($cate && (int) $cate['form_mode'] === 1) {
            $this->mirrorTempToCate($post['id'], $cate['temp_id']);
            $this->checkContsLog($post['id']);
            return get_op_put(1, "已按公共模板同步最新数据");
        }
        #
        vendor("PHPExcel.PHPExcel");
        #
        #导入数据
        $file = uploadFile("tmps", isset($_FILES['file']) ? array('file' => $_FILES['file']) : null);
        $objPHPExcel = \PHPExcel_IOFactory::load("./././Public/uploads/tmps/" . $file["file"]["savename"]);
        $sheetSelected = 0;
        $objPHPExcel->setActiveSheetIndex($sheetSelected);
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
        $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
        $dataArr = array();
        for ($row = 2; $row <= $rowCount; $row++) {
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $cell = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                if (is_object($cell)) {
                    $cell = $cell->__toString();
                }
                $dataArr[$row][] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $cell);
            }
        }
        unlink("./././Public/uploads/tmps/" . $file["file"]["savename"]);
        if (count($dataArr) < 1) {
            return get_op_put(0, "没有导入数据");
        }
        $list = array_reverse($dataArr);
        $list = array_reverse($list);
        $info = M('new_cate')->where(['id'=>$post['id']])->find();
        $price = $info['price'];
        $data = [];
        foreach ($list as $k=>$v){
            // v[0]=材料名称（跳过），v[1]=规格，v[2]=重量，v[3]=工电费补偿
            $data[$k]['new_cate_id'] = $info['id'];
            $data[$k]['number'] = $k+1;
            $data[$k]['name'] = isset($v[1]) ? $v[1] : '';
            $data[$k]['weight'] = isset($v[2]) ? $v[2] : 0;
            $data[$k]['extra_ratio'] = (isset($v[3]) && $v[3] !== '') ? round($v[3], 2) : 0;
            $data[$k]['price'] = $price;
            $data[$k]['calc_base_price'] = bcmul((string)$data[$k]['weight'], (string)$price, 4);
            $end_price = bcadd($data[$k]['calc_base_price'], (string)$data[$k]['extra_ratio'], 4);
            $data[$k]['end_price'] = $end_price;
                
        }
        if($data){
            M('new_cate_form')->where(['new_cate_id'=>$info['id']])->delete();
            M('new_cate_form')->addAll($data);
        }
        return get_op_put(1, "获取成功",$data);
    }
    //提交更新数据
    public function cate_form_update(){
        $post = I("post.");
        $info = $post['info'];
        $form = $post['form'];
        $info = json_decode(htmlspecialchars_decode($info), true);
        $form = json_decode(htmlspecialchars_decode($form), true);
        $new_cate_form = M('new_cate_form');
        $new_cate_id = $info['id'];
        #
        // 公共模板模式：不使用页面提交的表格内容（本就只读），直接从关联模版重新同步
        $cate = M('new_cate')->where(['id' => $new_cate_id])->find();
        if ($cate && (int) $cate['form_mode'] === 1) {
            $this->mirrorTempToCate($new_cate_id, $cate['temp_id']);
            $this->checkContsLog($new_cate_id);
            return get_op_put(1, "已按公共模板同步最新数据", array('info' => $info));
        }
        #
        foreach ($form as $k=>$v){
            $where["id"] = $v["id"];
            unset($v["id"]);
            $v["up_time"] = time();
            #
            $save = $v;
            $save["calc_base_price"] =bcmul((string)$v['weight'],(string)$v['price'],4);
            
            // $temp = bcmul((string)$save["calc_base_price"],(string)$v['extra_ratio'],4);
            $end_price = bcadd($save["calc_base_price"],(string)$v['extra_ratio'],4);
            $save['end_price'] = $end_price;
            // var_dump($save);
            $result = $new_cate_form->where($where)->save($save);
            // var_dump($result);
            if (!$result) {
                //修改更新商品价格
                // return get_op_put(0, "没有修改[SR]");
            }
        }
        $this->checkContsLog($new_cate_id);
        
        return get_op_put(1, "操作成功",['info'=>$info,'form'=>$form]);
    }
    
     public function cate_form_del(){
        $post = I("post.");

        M('new_cate_form')->where(['new_cate_id'=>$post['id']])->delete();
        // 清空表格同时解除公共模板关联，回到自定义模式（不然模版一联动数据又会被重新填回来）
        M('new_cate')->where(['id'=>$post['id']])->save(array('form_mode'=>0, 'temp_id'=>0));
        return get_op_put(1, "操作成功");
    }
    
    public function cate_del(){
        $post = I("post.");
        
        $count = M('new_cate')->where(['pid'=>$post['id']])->count();
        if($count > 0){
             return get_op_put(0, "请先删除下级");
        }
        
        $count = M('new_cate_form')->where(['new_cate_id'=>$post['id']])->count();
        if($count > 0){
             return get_op_put(0, "管理表格存在数据不能删除");
        }
        
        M('new_cate')->where(['id'=>$post['id']])->delete();
        //  M('new_cate')->where(['new_cate_id'=>$post['id']])->delete();
        return get_op_put(1, "操作成功");
    }

    ////////////////////////////////////////////////////////////////////////////
    // 公共模版（依附于二级材料，每个二级最多3个）

    /**
     * 模版编辑页（新增模版后/点“编辑”都进这个页面）
     */
    public function temp_form($id) {
        $temp = M('new_cate_temp')->find($id);
        $list = M('new_cate_temp_form')->where(['temp_id' => $id])->order('sorts asc,id asc')->select();
        #
        $this->assign("id", $id);
        $this->assign("info", $temp);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 新增模版（只传名称，超过3个直接拒绝）
     */
    public function temp_add() {
        $post = I("post.");
        $new_cate_id = (int) $post['new_cate_id'];
        $name = trim($post['name']);
        if (!$new_cate_id) return get_op_put(0, "缺少二级材料ID");
        if ($name === '') return get_op_put(0, "请填写模版名称");
        #
        $count = M('new_cate_temp')->where(['new_cate_id' => $new_cate_id])->count();
        if ($count >= 3) return get_op_put(0, "每个二级材料最多添加3个模版");
        #
        $id = M('new_cate_temp')->add(array(
            'new_cate_id' => $new_cate_id,
            'name'        => $name,
            'sorts'       => $count,
            'uptimes'     => time(),
            'times'       => time(),
        ));
        if (!$id) return get_op_put(0, "添加失败");
        return get_op_put(1, "添加成功", array('id' => $id));
    }

    /**
     * 模版详情 + 规格明细（编辑页用）
     */
    public function temp_info() {
        $id = I("post.id");
        $info = M('new_cate_temp')->where(['id' => $id])->find();
        if (!$info) return get_op_put(0, "模版不存在");
        $list = M('new_cate_temp_form')->where(['temp_id' => $id])->order('sorts asc,id asc')->select();
        return get_op_put(1, "获取成功", array('info' => $info, 'list' => $list));
    }

    /**
     * 模版-表格导入（本地Excel，覆盖当前模版的规格数据）
     * Excel格式：A规格 B重量(kg) C工电费补偿（参考 docs/cailiao-common.xlsx）
     */
    public function temp_import() {
        vendor("PHPExcel.PHPExcel");
        $post = I("post.");
        #
        if (empty($post["id"])) return get_op_put(0, "缺少模版ID");
        $info = M('new_cate_temp')->where(['id' => $post['id']])->find();
        if (!$info) return get_op_put(0, "模版不存在");
        #
        $file = uploadFile("tmps", isset($_FILES['file']) ? array('file' => $_FILES['file']) : null);
        if (!$file) return get_op_put(0, "文件上传失败");
        $filePath = "./././Public/uploads/tmps/" . $file["file"]["savename"];
        $objPHPExcel = \PHPExcel_IOFactory::load($filePath);
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
        $colCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
        $dataArr = array();
        for ($row = 1; $row <= $rowCount; $row++) {
            $rowData = array();
            for ($column = 'A'; $column <= $colCount; $column++) {
                $cell = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                if (is_object($cell)) $cell = $cell->__toString();
                $rowData[] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $cell);
            }
            // 跳过表头（第1行：规格 / 重量(kg) / 工电费补偿）及全空行
            if ($row > 1 && strlen(implode('', $rowData)) > 0) {
                $dataArr[] = $rowData;
            }
        }
        unlink($filePath);
        if (count($dataArr) < 1) return get_op_put(0, "没有导入数据");
        #
        $insert = array();
        foreach ($dataArr as $k => $v) {
            $spec = isset($v[0]) ? trim($v[0]) : '';
            if ($spec === '') continue;
            $insert[] = array(
                "temp_id"     => $post["id"],
                "name"        => $spec,
                "weight"      => round((float) (isset($v[1]) ? $v[1] : 0), 4),
                "extra_ratio" => round((float) (isset($v[2]) ? $v[2] : 0), 2),
                "sorts"       => $k,
            );
        }
        if (count($insert) < 1) return get_op_put(0, "没有导入数据");
        #
        M('new_cate_temp_form')->where(['temp_id' => $post['id']])->delete();
        M('new_cate_temp_form')->addAll($insert);
        M('new_cate_temp')->where(['id' => $post['id']])->save(array('uptimes' => time()));
        #
        // 级联同步所有已应用该模版的三级材料，不需要人工进材料管理页操作
        $this->syncLinkedCates($post['id']);
        #
        return get_op_put(1, "导入成功，共导入" . count($insert) . "条");
    }

    /**
     * 把某个模版当前的数据级联同步到所有已应用该模版(form_mode=1)的三级材料
     */
    private function syncLinkedCates($temp_id) {
        $linked = M('new_cate')->where(array('form_mode' => 1, 'temp_id' => $temp_id))->select();
        foreach ($linked as $c) {
            $this->mirrorTempToCate($c['id'], $temp_id);
            $this->checkContsLog($c['id']);
        }
    }

    /**
     * 模版-保存（名称 + 逐行规格明细一起提交）
     */
    public function temp_save() {
        $post = I("post.");
        $id = (int) $post['id'];
        $info = M('new_cate_temp')->where(['id' => $id])->find();
        if (!$info) return get_op_put(0, "模版不存在");
        #
        $name = trim($post['name']);
        if ($name === '') return get_op_put(0, "请填写模版名称");
        M('new_cate_temp')->where(['id' => $id])->save(array('name' => $name, 'uptimes' => time()));
        #
        $form = isset($post['form']) ? json_decode(htmlspecialchars_decode($post['form']), true) : array();
        if (is_array($form)) {
            foreach ($form as $v) {
                if (empty($v['id'])) continue;
                M('new_cate_temp_form')->where(['id' => $v['id'], 'temp_id' => $id])->save(array(
                    'name'        => $v['name'],
                    'weight'      => round((float) $v['weight'], 4),
                    'extra_ratio' => round((float) $v['extra_ratio'], 2),
                ));
            }
        }
        // 级联同步所有已应用该模版的三级材料
        $this->syncLinkedCates($id);
        return get_op_put(1, "保存成功");
    }

    /**
     * 删除模版（含规格明细），前端需二次确认
     */
    public function temp_del() {
        $post = I("post.");
        $id = (int) $post['id'];
        if (!$id) return get_op_put(0, "缺少模版ID");
        #
        // 已应用该模版的三级材料解除关联、回到自定义模式，避免残留一个已删除模版的引用
        // 表格数据保留最后一次同步的镜像内容，不清空
        M('new_cate')->where(array('form_mode' => 1, 'temp_id' => $id))->save(array('form_mode' => 0, 'temp_id' => 0));
        M('new_cate_temp_form')->where(['temp_id' => $id])->delete();
        M('new_cate_temp')->where(['id' => $id])->delete();
        return get_op_put(1, "删除成功");
    }

}
