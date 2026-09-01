<?php

namespace Home\Opera;

/**
 * 分类溢价(plate_premium) -> 商品设置(plate_conts_logs) 级联同步
 * 只处理 dratio_mode=1（公共模板模式）的规格行，按“产品规格”文本匹配
 * 注意：产品规格不固定存在 value_7，按 key_0~key_7 的标签文本动态定位（见 plateContsLogSpec()）
 */
class PremiumSyncOpera {

    public function runs($param) {
        $plateId = isset($param['plate_id']) ? (int) $param['plate_id'] : 0;
        if (!$plateId) return array('status' => 0, 'msg' => '缺少分类ID', 'data' => array('updated' => 0));

        // specs 不传代表该分类下全部规格都要重新同步一遍（用于导入覆盖后的场景）
        $specs = isset($param['specs']) && is_array($param['specs']) ? array_values(array_unique($param['specs'])) : null;
        if ($specs !== null && !$specs) return array('status' => 1, 'msg' => '无变更规格', 'data' => array('updated' => 0));

        $contsIds = M('plate_conts')->where(array('pid' => $plateId))->getField('id', true);
        if (!$contsIds) return array('status' => 1, 'msg' => '无关联商品', 'data' => array('updated' => 0));

        // 产品规格列位置不固定，这里不再靠 value_7 在SQL层过滤，取回 dratio_mode=1 的行后按标签逐行解析
        $logs = M('plate_conts_logs')->where(array('pid' => array('in', $contsIds), 'dratio_mode' => 1))->select();
        if (!$logs) return array('status' => 1, 'msg' => '无需同步', 'data' => array('updated' => 0));

        $premiumMap = array();
        $premiumRows = M('plate_premium')->where(array('plate_id' => $plateId))->select();
        foreach ($premiumRows as $p) {
            $premiumMap[$p['spec']] = $p['ratio'];
        }

        $logsModel = M('plate_conts_logs');
        $updated = 0;
        foreach ($logs as $row) {
            $spec = plateContsLogSpec($row);
            if ($spec === null || $spec === '') continue;
            if ($specs !== null && !in_array($spec, $specs, true)) continue;
            // 规格文本在公共模板里找不到对应值，保留原值不动，不中断其它行的同步
            if (!isset($premiumMap[$spec])) continue;
            $ratio  = $premiumMap[$spec];
            $market = round($row['price'] * $ratio, 2);
            $logsModel->where(array('id' => $row['id']))->save(array(
                'dratio'  => $ratio,
                'market'  => $market,
                'uptimes' => time(),
            ));
            $updated++;
        }
        return array('status' => 1, 'msg' => '同步完成', 'data' => array('updated' => $updated));
    }

}
