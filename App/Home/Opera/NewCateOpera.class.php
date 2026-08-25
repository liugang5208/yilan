<?php

namespace Home\Opera;
use Think\Log;
/**
 * Description of BlwaresOpera
 * 更新板块商品
 * @author Administrator
 */
class NewCateOpera {

    private $param;

    private $lists;

    /**
     * 入口
     */
    public function runs($param) {
        $this->param = $param;
       return $this->setListGoods();
    }



    /**
     * 列表商品
     */
    public function setListGoods() {
        $new_cate_id = (int)$this->param['new_cate_id'];
        if (!$new_cate_id) return true;

        $db = M();

        // 1. 受影响的 blank_id 列表（一次查询）
        $affectedBlanks = $db->query(
            "SELECT DISTINCT blank_id FROM plate_conts_price
             WHERE new_cate_three_id = {$new_cate_id} AND is_del = 1"
        );
        if (empty($affectedBlanks)) return true;
        $blankIdStr = implode(',', array_column($affectedBlanks, 'blank_id'));

        // 2. 这些 blank 的全部价格配置（一次查询）
        $allPrices = $db->query(
            "SELECT blank_id, new_cate_three_id, ratio FROM plate_conts_price
             WHERE blank_id IN ({$blankIdStr}) AND is_del = 1"
        );
        $priceMap = [];
        $cateIds  = [];
        foreach ($allPrices as $p) {
            $bid = (int)$p['blank_id'];
            $priceMap[$bid][] = ['cate_id' => (int)$p['new_cate_three_id'], 'ratio' => (float)$p['ratio']];
            $cateIds[$p['new_cate_three_id']] = 1;
        }

        // 3. 所有需要的 new_cate_form 数据（一次查询）
        $cateIdStr = implode(',', array_keys($cateIds));
        $forms     = $db->query(
            "SELECT new_cate_id, number, end_price, weight FROM new_cate_form
             WHERE new_cate_id IN ({$cateIdStr})"
        );
        $formMap = [];
        foreach ($forms as $f) {
            $formMap[(int)$f['new_cate_id']][(int)$f['number']] = [
                'end_price' => (float)$f['end_price'],
                'weight'    => (float)$f['weight'],
            ];
        }

        // 4. 分批取 logs，PHP 计算，CASE WHEN 批量 UPDATE
        $batchSize = 500;
        $lastId    = 0;
        $now       = time();
        do {
            $logs = $db->query(
                "SELECT id, blank_id, number, dratio FROM plate_conts_logs
                 WHERE blank_id IN ({$blankIdStr}) AND id > {$lastId}
                 ORDER BY id ASC LIMIT {$batchSize}"
            );
            if (empty($logs)) break;

            $casePrice = $caseMarket = $caseWeight = '';
            $ids = [];
            foreach ($logs as $log) {
                $bid    = (int)$log['blank_id'];
                $num    = (int)$log['number'];
                $dratio = (float)$log['dratio'];
                $lid    = (int)$log['id'];
                $ids[]  = $lid;
                $lastId = $lid;

                $price = $weight = 0.0;
                if (isset($priceMap[$bid])) {
                    foreach ($priceMap[$bid] as $pc) {
                        $form = isset($formMap[$pc['cate_id']][$num])
                            ? $formMap[$pc['cate_id']][$num] : null;
                        if ($form) {
                            $price  += $form['end_price'] * $pc['ratio'] / 100;
                            $weight += $form['weight']    * $pc['ratio'] / 100;
                        }
                    }
                }
                $market = round($price * $dratio, 2);
                $price  = round($price,  4);
                $weight = round($weight, 4);

                $casePrice  .= "WHEN {$lid} THEN {$price} ";
                $caseMarket .= "WHEN {$lid} THEN {$market} ";
                $caseWeight .= "WHEN {$lid} THEN {$weight} ";
            }

            $idStr = implode(',', $ids);
            $db->execute(
                "UPDATE plate_conts_logs
                 SET price   = CASE id {$casePrice}  END,
                     market  = CASE id {$caseMarket} END,
                     weight  = CASE id {$caseWeight} END,
                     uptimes = {$now}
                 WHERE id IN ({$idStr})"
            );
        } while (count($logs) === $batchSize);
        return true;
    }


  

}
