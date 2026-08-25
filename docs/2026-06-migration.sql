-- ============================================================
-- 本次需求变更 SQL 汇总
-- 项目：yilan / 分支：feature/20260531-price-auto-update
-- 最终整理日期：2026-06-17
-- 执行顺序：DDL（建表/改表）→ DML（数据迁移）→ 初始化数据
-- ============================================================


-- ============================================================
-- 一、DDL：表结构变更
-- ============================================================

-- 1. 新建表：plate_conts_blank_group（标准选项分组）
CREATE TABLE IF NOT EXISTS `plate_conts_blank_group` (
  `id`       int unsigned  NOT NULL AUTO_INCREMENT,
  `pid`      int           NOT NULL DEFAULT 0    COMMENT '对应 plate_conts.id（商品 id），per-pid 独立分组',
  `name`     varchar(100)  NOT NULL DEFAULT ''   COMMENT '选项卡名称',
  `ratio`    decimal(14,6) NOT NULL DEFAULT 100.000000 COMMENT '标准选项比例（百分比，100=100%实际值）',
  `sort`     int           NOT NULL DEFAULT 0    COMMENT '排序',
  `add_time` int           NOT NULL DEFAULT 0,
  `up_time`  int           NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='属性分类商品标准选项分组';

-- 2. plate_conts_blank 加 group_id 字段
ALTER TABLE `plate_conts_blank`
  ADD COLUMN `group_id` int NOT NULL DEFAULT 0
  COMMENT '关联 plate_conts_blank_group.id' AFTER `catname`;

-- 3. plate_conts_price 加 blank_id 字段及索引（合并为一条）
ALTER TABLE `plate_conts_price`
  ADD COLUMN `blank_id` int NOT NULL DEFAULT 0
    COMMENT '关联 plate_conts_blank.id' AFTER `cat_index`,
  ADD KEY `idx_blank_id` (`blank_id`);

-- 4. plate_conts_logs 加所有新字段及索引（合并为一条）
ALTER TABLE `plate_conts_logs`
  ADD COLUMN `blank_id` int NOT NULL DEFAULT 0
    COMMENT '关联 plate_conts_blank.id' AFTER `cat_index`,
  ADD KEY   `idx_blank_id` (`blank_id`),
  ADD COLUMN `key_6`   varchar(50)  DEFAULT NULL AFTER `value_5`,
  ADD COLUMN `value_6` varchar(100) DEFAULT NULL AFTER `key_6`,
  ADD COLUMN `key_7`   varchar(50)  DEFAULT NULL AFTER `value_6`,
  ADD COLUMN `value_7` varchar(100) DEFAULT NULL AFTER `key_7`,
  ADD COLUMN `key_8`   varchar(50)  DEFAULT NULL AFTER `value_7`,
  ADD COLUMN `value_8` varchar(100) DEFAULT NULL AFTER `key_8`,
  ADD COLUMN `weight`  decimal(10,4) NOT NULL DEFAULT 0.0000
    COMMENT '参考重量(kg)' AFTER `market`;

-- 5. plate_conts_logsr 加参考重量字段
ALTER TABLE `plate_conts_logsr`
  ADD COLUMN `weight` decimal(10,4) NOT NULL DEFAULT 0.0000
  COMMENT '参考重量(kg)' AFTER `market`;


-- ============================================================
-- 二、DML：数据迁移
-- ============================================================

-- 6. plate_conts_price：根据 plate_conts_id+cat_index 补填 blank_id
UPDATE `plate_conts_price` p
  INNER JOIN `plate_conts_blank` b
    ON b.pid = p.plate_conts_id AND b.cat_index = p.cat_index
SET p.blank_id = b.id
WHERE p.blank_id = 0;

-- 7. plate_conts_price：修复 blank 重建后 blank_id 错位的记录
UPDATE `plate_conts_price` p
  INNER JOIN `plate_conts_blank` b
    ON b.pid = p.plate_conts_id AND b.cat_index = p.cat_index
SET p.blank_id = b.id
WHERE p.is_del = 1
  AND p.blank_id != b.id;

-- 8. plate_conts_logs：根据 pid+cat_index 补填 blank_id
UPDATE `plate_conts_logs` l
  INNER JOIN `plate_conts_blank` b
    ON b.pid = l.pid AND b.cat_index = l.cat_index
SET l.blank_id = b.id
WHERE l.blank_id = 0;

-- 9. plate_conts_price：ratio 从直接倍数格式迁移为百分比格式（1.0 → 100，即 100%）
-- 执行后前端展示 ratio=100 表示 100%（实际值不变），CxmarkOpera 计算时除以 100
UPDATE `plate_conts_price` SET ratio = ratio * 100;


-- ============================================================
-- 三、初始化数据：per-pid 标准选项分组
-- ============================================================

-- 9. 清空所有旧分组（执行前确认无需保留历史分组数据）
DELETE FROM plate_conts_blank_group;

-- 10. 为每个有效 pid 批量生成 10 个独立分组（ratio=100 表示 100%）
INSERT INTO plate_conts_blank_group (pid, name, ratio, sort, add_time, up_time)
SELECT b.pid, CONCAT('标准选项卡', n.n), 100.000000, n.n, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()
FROM (SELECT DISTINCT pid FROM plate_conts_blank WHERE status = 1 AND pid > 0) b
CROSS JOIN (
    SELECT 1 n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
    UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
) n;

-- 11. 将所有 blank 关联到各自 pid 的 sort=1 分组（标准选项卡1）
-- ⚠️ 必须用 sort=1 精确匹配，不能用 MIN(id)（CROSS JOIN 导致 id 顺序与 sort 相反）
UPDATE plate_conts_blank b
INNER JOIN plate_conts_blank_group g ON g.pid = b.pid AND g.sort = 1
SET b.group_id = g.id
WHERE b.status = 1 AND b.pid > 0;
