<?php

namespace Home\Controller;

class PriceSyncController extends CommController {

    public function index() {
        $this->display();
    }

    // ==================== 行情代理 ====================

    public function getQuotes() {
        $exchange = I('post.exchange', 'shfe');
        $allowed  = array('shfe', 'dce', 'czce', 'gfex', 'ine', 'cffex', 'global');
        if (!in_array($exchange, $allowed)) {
            return get_op_put(0, '非法交易所代码');
        }
        // 国际期货使用独立接口
        if ($exchange === 'global') {
            $url = "https://futsseapi.eastmoney.com/list/trans/block/mk0792"
                 . "?orderBy=&sort=&pageSize=999&pageIndex=0"
                 . "&specificContract=false&platform=zbPC"
                 . "&field=name,p,zdf,zde,zjsj,dm";
        } else {
            $url = "https://futsseapi.eastmoney.com/list/main/risk/{$exchange}"
                 . "?orderBy=&sort=&pageSize=999&pageIndex=0"
                 . "&specificContract=false&platform=zbPC"
                 . "&field=name,p,zdf,zde,zjsj,dm";
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTPHEADER     => array(
                'Referer: https://qhweb.eastmoney.com/',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
            ),
        ));
        $result = curl_exec($ch);
        $errno  = curl_errno($ch);
        curl_close($ch);
        if ($errno || !$result) return get_op_put(0, '行情接口请求失败');
        $data = json_decode($result, true);
        if (!isset($data['list'])) return get_op_put(0, '行情数据解析失败');

        $list = $data['list'];

        // 中金所：只保留名称含"主连"的真实主力合约，过滤掉当季/下季/隔季连续
        if ($exchange === 'cffex') {
            $list = array_values(array_filter($list, function($item) {
                return mb_strpos($item['name'], '主连') !== false;
            }));
        }

        // 过滤掉价格无效的合约（p 为 "-" 或非数值），国际期货全量展示不过滤
        if ($exchange !== 'global') {
            $list = array_values(array_filter($list, function($item) {
                return isset($item['p']) && is_numeric($item['p']);
            }));
        }

        return get_op_put(1, '获取成功', $list);
    }

    // ==================== 基础材料列表（供下拉选择） ====================

    public function getMaterials() {
        // 只取 cate_type=0（基础材料分类）的根节点，构建 id=>name 索引
        $roots = M('new_label')->where(array('cate_label_id' => 0, 'cate_type' => 0))->field('id,name')->select();
        if (!$roots) return get_op_put(1, '获取成功', array());

        $rootMap = array();
        foreach ($roots as $r) $rootMap[$r['id']] = $r['name'];
        $rootIds = array_keys($rootMap);

        // 只取这些基础分类下 pid=0 的直属材料
        $list = M('new_label')
            ->where(array('cate_label_id' => array('in', $rootIds), 'pid' => 0))
            ->order('cate_label_id asc, id asc')
            ->select();

        foreach ($list as &$item) {
            $item['cat_name'] = isset($rootMap[$item['cate_label_id']]) ? $rootMap[$item['cate_label_id']] : '';
            $item['price']    = number_format((float)$item['price'], 2, '.', '');
        }
        return get_op_put(1, '获取成功', $list);
    }

    // ==================== 同步配置 CRUD ====================

    public function getConfigList() {
        $configs = M('price_sync_config')->where(array('status' => 1))->order('id asc')->select();

        // 批量查最后一次同步时间（从 price_sync_log 取 MAX add_time）
        $configIds   = array_column($configs, 'id');
        $lastSyncMap = array();
        if ($configIds) {
            $logs = M('price_sync_log')
                ->where(array('config_id' => array('in', $configIds)))
                ->field('config_id, MAX(add_time) as last_sync_at')
                ->group('config_id')
                ->select();
            foreach ($logs as $log) {
                $lastSyncMap[$log['config_id']] = $log['last_sync_at'];
            }
        }

        foreach ($configs as &$c) {
            $label = M('new_label')->where(array('id' => $c['new_label_id']))->field('price')->find();
            $c['current_price'] = $label ? number_format((float)$label['price'], 2, '.', '') : '0.00';
            $lastAt = isset($lastSyncMap[$c['id']]) ? (int)$lastSyncMap[$c['id']] : 0;
            $c['last_sync_at'] = $lastAt > 0 ? date('Y-m-d H:i:s', $lastAt) : '-';
        }
        return get_op_put(1, '获取成功', $configs);
    }

    public function saveConfig() {
        $data       = I('post.');
        $newLabelId = (int)$data['new_label_id'];
        if (!$data['futures_code']) return get_op_put(0, '请选择期货合约');
        if ($newLabelId <= 0)       return get_op_put(0, '请选择材料');
        if (!isset($data['ratio']) || $data['ratio'] == '') return get_op_put(0, '请填写换算比例');

        $db   = M('price_sync_config');
        $save = array(
            'futures_code' => $data['futures_code'],
            'futures_name' => isset($data['futures_name']) ? $data['futures_name'] : '',
            'exchange'     => isset($data['exchange'])     ? $data['exchange']     : 'shfe',
            'new_label_id' => $newLabelId,
            'label_name'   => isset($data['label_name'])   ? $data['label_name']  : '',
            'ratio'        => $data['ratio'],
            'auto_sync'    => isset($data['auto_sync']) && $data['auto_sync'] ? 1 : 0,
            'up_time'      => time(),
        );

        if (!empty($data['id'])) {
            $db->where(array('id' => $data['id']))->save($save);
            return get_op_put(1, '更新成功');
        } else {
            $save['status']   = 1;
            $save['add_time'] = time();
            $id = $db->add($save);
            if (!$id) return get_op_put(0, '添加失败');
            return get_op_put(1, '添加成功', array('id' => $id));
        }
    }

    public function delConfig() {
        $id = I('post.id');
        if (!$id) return get_op_put(0, '参数错误');
        M('price_sync_config')->where(array('id' => $id))->save(array('status' => 0, 'up_time' => time()));
        return get_op_put(1, '删除成功');
    }

    public function toggleAutoSync() {
        $id       = I('post.id');
        $autoSync = I('post.auto_sync') ? 1 : 0;
        if (!$id) return get_op_put(0, '参数错误');
        M('price_sync_config')->where(array('id' => $id))->save(array('auto_sync' => $autoSync, 'up_time' => time()));
        return get_op_put(1, '更新成功');
    }

    // ==================== 同步执行 ====================

    public function syncOne() {
        $configId     = I('post.config_id');
        $syncType     = (int)I('post.sync_type', 1);
        $futuresPrice = (float)I('post.futures_price', 0);

        $config = M('price_sync_config')->where(array('id' => $configId, 'status' => 1))->find();
        if (!$config) return get_op_put(0, '配置不存在');

        if ($futuresPrice <= 0) {
            $res = $this->_fetchPrice($config['exchange'], $config['futures_code']);
            if (!$res['ok']) return get_op_put(0, $res['msg']);
            $futuresPrice = $res['price'];
        }

        // 换算比例为百分比：new_price = futures_price × ratio / 100
        $newPrice = bcdiv(bcmul((string)$futuresPrice, (string)$config['ratio'], 6), '100', 4);

        $label = M('new_label')->where(array('id' => $config['new_label_id']))->find();
        if (!$label) return get_op_put(0, '材料记录不存在');
        $oldPrice = $label['price'];

        // 更新材料价格，同时记录本次同步的期货现价和比例
        M('new_label')->where(array('id' => $config['new_label_id']))->save(array(
            'price'              => $newPrice,
            'last_futures_price' => $futuresPrice,
            'last_sync_ratio'    => $config['ratio'],
            'last_sync_time'     => time(),
            'up_time'            => time(),
        ));

        $this->_recalcCascade($config['new_label_id']);

        M('price_sync_log')->add(array(
            'config_id'     => $configId,
            'futures_code'  => $config['futures_code'],
            'futures_name'  => $config['futures_name'],
            'new_label_id'  => $config['new_label_id'],
            'label_name'    => $config['label_name'],
            'futures_price' => $futuresPrice,
            'old_price'     => $oldPrice,
            'new_price'     => $newPrice,
            'sync_type'     => $syncType,
            'status'        => 1,
            'add_time'      => time(),
        ));

        return get_op_put(1, '同步成功', array(
            'new_price'     => $newPrice,
            'futures_price' => $futuresPrice,
        ));
    }

    public function batchSync() {
        $ids      = I('post.ids');
        $syncType = (int)I('post.sync_type', 1);
        if (!$ids) return get_op_put(0, '请选择配置');
        $idArr   = is_array($ids) ? $ids : explode(',', $ids);
        $results = array('success' => 0, 'fail' => 0, 'details' => array());

        foreach ($idArr as $configId) {
            $config = M('price_sync_config')->where(array('id' => $configId, 'status' => 1))->find();
            if (!$config) { $results['fail']++; continue; }

            $res = $this->_fetchPrice($config['exchange'], $config['futures_code']);
            if (!$res['ok']) {
                $results['fail']++;
                $results['details'][] = $config['futures_name'] . '：' . $res['msg'];
                continue;
            }

            $futuresPrice = $res['price'];
            $newPrice     = bcdiv(bcmul((string)$futuresPrice, (string)$config['ratio'], 6), '100', 4);
            $label        = M('new_label')->where(array('id' => $config['new_label_id']))->find();
            if (!$label) { $results['fail']++; continue; }
            $oldPrice = $label['price'];

            M('new_label')->where(array('id' => $config['new_label_id']))->save(array(
                'price'              => $newPrice,
                'last_futures_price' => $futuresPrice,
                'last_sync_ratio'    => $config['ratio'],
                'last_sync_time'     => time(),
                'up_time'            => time(),
            ));
            $this->_recalcCascade($config['new_label_id']);

            M('price_sync_log')->add(array(
                'config_id'     => $configId,
                'futures_code'  => $config['futures_code'],
                'futures_name'  => $config['futures_name'],
                'new_label_id'  => $config['new_label_id'],
                'label_name'    => $config['label_name'],
                'futures_price' => $futuresPrice,
                'old_price'     => $oldPrice,
                'new_price'     => $newPrice,
                'sync_type'     => $syncType,
                'status'        => 1,
                'add_time'      => time(),
            ));
            $results['success']++;
        }

        return get_op_put(1, "完成：成功 {$results['success']} 条，失败 {$results['fail']} 条", $results);
    }

    // 定时自动同步（cron 每天早上10点调用一次，同步所有 auto_sync=1 的配置）
    public function syncAuto() {
        $configs = M('price_sync_config')->where(array('auto_sync' => 1, 'status' => 1))->select();
        if (!$configs) return get_op_put(1, '无需同步的配置');

        $results = array('success' => 0, 'fail' => 0);
        foreach ($configs as $config) {
            $res = $this->_fetchPrice($config['exchange'], $config['futures_code']);
            if (!$res['ok']) { $results['fail']++; continue; }

            $futuresPrice = $res['price'];
            $newPrice     = bcdiv(bcmul((string)$futuresPrice, (string)$config['ratio'], 6), '100', 4);
            $label        = M('new_label')->where(array('id' => $config['new_label_id']))->find();
            if (!$label) { $results['fail']++; continue; }
            $oldPrice = $label['price'];

            M('new_label')->where(array('id' => $config['new_label_id']))->save(array(
                'price'              => $newPrice,
                'last_futures_price' => $futuresPrice,
                'last_sync_ratio'    => $config['ratio'],
                'last_sync_time'     => time(),
                'up_time'            => time(),
            ));
            $this->_recalcCascade($config['new_label_id']);

            M('price_sync_log')->add(array(
                'config_id'     => $config['id'],
                'futures_code'  => $config['futures_code'],
                'futures_name'  => $config['futures_name'],
                'new_label_id'  => $config['new_label_id'],
                'label_name'    => $config['label_name'],
                'futures_price' => $futuresPrice,
                'old_price'     => $oldPrice,
                'new_price'     => $newPrice,
                'sync_type'     => 2,
                'status'        => 1,
                'add_time'      => time(),
            ));
            $results['success']++;
        }

        return get_op_put(1, "定时同步完成：成功 {$results['success']} 条，失败 {$results['fail']} 条", $results);
    }

    // ==================== 同步日志 ====================

    public function getSyncLog() {
        $configId = I('post.config_id');
        if (!$configId) return get_op_put(0, '参数错误');
        $list = M('price_sync_log')
            ->where(array('config_id' => $configId))
            ->order('id desc')
            ->limit(50)
            ->select();
        foreach ($list as &$row) {
            $row['add_time_str'] = date('Y-m-d H:i:s', $row['add_time']);
            $row['type_str']     = $row['sync_type'] == 2 ? '定时' : '手动';
        }
        return get_op_put(1, '获取成功', $list);
    }

    // ==================== 私有辅助方法 ====================

    private function _fetchPrice($exchange, $code) {
        $allowed = array('shfe', 'dce', 'czce', 'gfex', 'ine', 'cffex', 'global');
        if (!in_array($exchange, $allowed)) return array('ok' => false, 'msg' => '非法交易所');
        if ($exchange === 'global') {
            $url = "https://futsseapi.eastmoney.com/list/trans/block/mk0792"
                 . "?orderBy=&sort=&pageSize=999&pageIndex=0"
                 . "&specificContract=false&platform=zbPC"
                 . "&field=name,p,dm";
        } else {
            $url = "https://futsseapi.eastmoney.com/list/main/risk/{$exchange}"
                 . "?orderBy=&sort=&pageSize=999&pageIndex=0"
                 . "&specificContract=false&platform=zbPC"
                 . "&field=name,p,dm";
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTPHEADER     => array(
                'Referer: https://qhweb.eastmoney.com/',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
            ),
        ));
        $result = curl_exec($ch);
        $errno  = curl_errno($ch);
        curl_close($ch);
        if ($errno || !$result) return array('ok' => false, 'msg' => '行情请求失败');
        $data = json_decode($result, true);
        if (!isset($data['list'])) return array('ok' => false, 'msg' => '行情数据解析失败');
        foreach ($data['list'] as $item) {
            if ($item['dm'] === $code) return array('ok' => true, 'price' => (float)$item['p']);
        }
        return array('ok' => false, 'msg' => "未找到合约 {$code}");
    }

    private function _recalcCascade($id) {
        $db = M('new_label');

        $calcPrice = function($v) use ($db) {
            $price = 0;
            if ($v['pid'] > 0) {
                $p1    = $db->where(array('id' => $v['pid']))->find();
                $price = bcdiv(bcmul($p1['price'], $v['ratio'], 6), 100, 4);
            }
            $price2 = 0;
            if ($v['pid2'] > 0) {
                $p2     = $db->where(array('id' => $v['pid2']))->find();
                $price2 = bcdiv(bcmul($p2['price'], $v['ratio2'], 6), 100, 4);
            }
            $price3 = 0;
            if ($v['pid3'] > 0) {
                $p3     = $db->where(array('id' => $v['pid3']))->find();
                $price3 = bcdiv(bcmul($p3['price'], $v['ratio3'], 6), 100, 4);
            }
            $total = bcadd(bcadd($price, $price2, 4), $price3, 4);
            return bcadd($total, $v['end_ratio'], 4);
        };

        // pid_str 链
        $list1 = $db->where("FIND_IN_SET($id, pid_str)")->order('level asc, id asc')->select();
        foreach ($list1 as $v) {
            $newPrice = $calcPrice($v);
            $db->where(array('id' => $v['id']))->save(array('price' => $newPrice, 'up_time' => time()));
        }
        // pid2_str 链
        $list2 = $db->where("FIND_IN_SET($id, pid2_str)")->order('level2 asc, id asc')->select();
        foreach ($list2 as $v) {
            $newPrice = $calcPrice($v);
            $db->where(array('id' => $v['id']))->save(array('price' => $newPrice, 'up_time' => time()));
        }
        // pid3_str 链
        $list3 = $db->where("FIND_IN_SET($id, pid3_str)")->order('level3 asc, id asc')->select();
        foreach ($list3 as $v) {
            $newPrice = $calcPrice($v);
            $db->where(array('id' => $v['id']))->save(array('price' => $newPrice, 'up_time' => time()));
        }

        // 收集所有受影响的 new_label_id
        $labelIds = array_values(array_unique(array_merge(
            array($id),
            array_column($list1, 'id'),
            array_column($list2, 'id'),
            array_column($list3, 'id')
        )));

        // 创建任务记录（与 NewLabelController::edit() 逻辑一致）
        $info  = $db->where(array('id' => $id))->find();
        $title = '期货同步更新' . ($info ? $info['name'] : $id);
        $task  = M('task');
        $task->where(array('type' => 1, 'item_id' => $id))->where('status=1 OR status=2')->save(array('status' => 4));
        $taskId = $task->add(array(
            'type'     => 1,
            'item_id'  => $id,
            'title'    => $title,
            'status'   => 1,
            'add_time' => time(),
            'up_time'  => time(),
        ));

        // 触发 NewCate 价格联动（通过 Opera）
        $opera = D('Home/NewLabel', 'Opera');
        foreach ($labelIds as $lid) {
            $opera->runs(array('new_label_id' => $lid), $taskId);
        }
    }

}
