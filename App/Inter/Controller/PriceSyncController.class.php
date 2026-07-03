<?php

namespace Inter\Controller;

class PriceSyncController extends CommController {

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

        $list1 = $db->where("FIND_IN_SET($id, pid_str)")->order('level asc, id asc')->select();
        foreach ($list1 as $v) {
            $newPrice = $calcPrice($v);
            $db->where(array('id' => $v['id']))->save(array('price' => $newPrice, 'up_time' => time()));
        }
        $list2 = $db->where("FIND_IN_SET($id, pid2_str)")->order('level2 asc, id asc')->select();
        foreach ($list2 as $v) {
            $newPrice = $calcPrice($v);
            $db->where(array('id' => $v['id']))->save(array('price' => $newPrice, 'up_time' => time()));
        }
        $list3 = $db->where("FIND_IN_SET($id, pid3_str)")->order('level3 asc, id asc')->select();
        foreach ($list3 as $v) {
            $newPrice = $calcPrice($v);
            $db->where(array('id' => $v['id']))->save(array('price' => $newPrice, 'up_time' => time()));
        }

        $labelIds = array_values(array_unique(array_merge(
            array($id),
            array_column($list1, 'id'),
            array_column($list2, 'id'),
            array_column($list3, 'id')
        )));

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

        $opera = D('Home/NewLabel', 'Opera');
        foreach ($labelIds as $lid) {
            $opera->runs(array('new_label_id' => $lid), $taskId, false);
        }
        // 所有 task_log 写完后，一次 curl 触发 RespsController::task() 消费全部
        $opera->triggerAsync();

        // 若本次没有产生任何 task_log（关联 new_cate 为空），直接标记 task 完成，避免永久卡在 status=1
        $taskLogCount = M('task_log')->where(array('task_id' => $taskId))->count();
        if (!$taskLogCount) {
            M('task')->where(array('id' => $taskId))->save(array('status' => 3, 'ratio' => 100));
        }
    }

}
