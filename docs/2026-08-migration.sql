-- ============================================================
-- 8月数据库变更 SQL
-- 项目：yilan / 分支：feature/20260825-app-update
-- 整理日期：2026-08-26
-- ============================================================

-- ============================================================
-- 一、新增“分类溢价”（公共溢价率）表
-- 关联 plate.id（板块分类条），按产品规格存储溢价倍率
-- 用法：Goods/plate_infos 页面的“分类溢价”入口 -> Goods/premium_template
-- ============================================================

CREATE TABLE IF NOT EXISTS `plate_premium` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plate_id` int NOT NULL COMMENT '关联分类ID(plate.id)',
  `spec` varchar(64) NOT NULL DEFAULT '' COMMENT '产品规格',
  `ratio` decimal(10,3) NOT NULL DEFAULT '1.000' COMMENT '溢价倍率',
  `sorts` int NOT NULL DEFAULT '0' COMMENT '排序',
  `uptimes` bigint NOT NULL DEFAULT '0' COMMENT '更新时间',
  `times` bigint NOT NULL DEFAULT '0' COMMENT '记录时间',
  PRIMARY KEY (`id`),
  KEY `plate_id` (`plate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='分类溢价(公共溢价率)';

-- ============================================================
-- 二、plate 表新增“商品详情”富文本字段
-- 修复：plate_infos 页面“商品详情”按钮此前误链到 plate_conts_info（下一级表），
-- 现改为独立管理 plate 自身的商品详情内容
-- 用法：Goods/plate_infos 页面的“商品详情”入口 -> Goods/plate_desc
-- ============================================================

ALTER TABLE `plate` ADD COLUMN `g_desc` TEXT NULL COMMENT '商品详情' AFTER `source`;

-- ============================================================
-- 三、users_level 补齐“等级设置”弹窗已在用、但表里缺失的字段
-- 客服电话(tel)此前提交后被静默丢弃；标准1~标准10 新增独立的
-- type1~type10 字段（不复用/不改动现有 type_a~type_c，避免影响
-- Inter 模块 getUser() 现有的按数量限制逻辑）
-- ============================================================

ALTER TABLE `users_level`
  ADD COLUMN `tel`    varchar(20)  NOT NULL DEFAULT '' COMMENT '客服电话' AFTER `level`,
  ADD COLUMN `type1`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准1' AFTER `type_c`,
  ADD COLUMN `type2`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准2' AFTER `type1`,
  ADD COLUMN `type3`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准3' AFTER `type2`,
  ADD COLUMN `type4`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准4' AFTER `type3`,
  ADD COLUMN `type5`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准5' AFTER `type4`,
  ADD COLUMN `type6`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准6' AFTER `type5`,
  ADD COLUMN `type7`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准7' AFTER `type6`,
  ADD COLUMN `type8`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准8' AFTER `type7`,
  ADD COLUMN `type9`  tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准9' AFTER `type8`,
  ADD COLUMN `type10` tinyint(1)   NOT NULL DEFAULT 0   COMMENT '标准10' AFTER `type9`;

-- ============================================================
-- 四、修复“添加用户等级”报错：1364 Field 'up_a' doesn't have a default value
-- up_a/up_b(沪铜/沪铝主力，旧的期货联动字段)是 NOT NULL 且无默认值，
-- 但“添加用户等级”表单从未提交这两个字段，导致新增功能此前一直无法使用
-- ============================================================

ALTER TABLE `users_level`
  MODIFY COLUMN `up_a` tinyint NOT NULL DEFAULT 0 COMMENT '沪铜主力',
  MODIFY COLUMN `up_b` tinyint NOT NULL DEFAULT 0 COMMENT '沪铝主力';

-- type_a~type_c 同样是 NOT NULL 无默认值，且现在的“添加用户等级”表单已改绑
-- type1~type10、不再提交 type_a~type_c，同样会导致新增报 1364 错误
-- （仅补默认值，不改字段本身、不改 Inter 端逻辑）
ALTER TABLE `users_level`
  MODIFY COLUMN `type_a` tinyint(1) NOT NULL DEFAULT 0 COMMENT '标准1',
  MODIFY COLUMN `type_b` tinyint(1) NOT NULL DEFAULT 0 COMMENT '标准2',
  MODIFY COLUMN `type_c` tinyint(1) NOT NULL DEFAULT 0 COMMENT '标准3';

-- ============================================================
-- 五、users_cats 新增“公共比例设置”（管理界面先行，暂不接入报价计算）
-- 新增 type 字段区分比例类型：0=公共比例 1=等级比例
-- 约定 ac_level=0 专属“公共”，真实等级 id 从1开始自增不会冲突
-- 复用 Users/cats 页面与 cats_op/cats_op_form 接口，按 ac_level 是否为0 分流
-- ============================================================

ALTER TABLE `users_cats`
  ADD COLUMN `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '比例类型：0=公共比例 1=等级比例' AFTER `id`;

-- ============================================================
-- 六、plate_conts_list“商品设置”接入“分类溢价”公共模板
-- 新增 dratio_mode 区分某条规格的溢价率来源：0=自定义（原有行为，可编辑）
-- 1=公共模板（只读，跟随 Goods/premium_template 里设置的分类溢价实时同步）
-- 保存/导入分类溢价时（Goods/premium_save、premium_import）会级联把
-- dratio_mode=1 的规格行的 dratio/market 一并更新，不需要人工进商品设置页操作
-- ============================================================

ALTER TABLE `plate_conts_logs`
  ADD COLUMN `dratio_mode` tinyint(1) NOT NULL DEFAULT 0 COMMENT '溢价率来源：0=自定义 1=公共模板' AFTER `dratio`;

-- ============================================================
-- 七、NewCate 三级材料管理新增“公共模版”（依附于二级材料，每个二级最多3个）
-- 用法：NewCate/index.html 三级材料管理 header，“添加分类”前的“添加模版”入口
-- 本次只做模版本身的增删改查，不含“应用到具体三级材料”的动作
-- ============================================================

CREATE TABLE IF NOT EXISTS `new_cate_temp` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `new_cate_id` int NOT NULL DEFAULT '0' COMMENT '关联二级材料(new_cate.id)',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '模版名称',
  `sorts` int NOT NULL DEFAULT '0',
  `uptimes` bigint NOT NULL DEFAULT '0',
  `times` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `new_cate_id` (`new_cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='二级材料-公共模版(每个二级最多3个)';

CREATE TABLE IF NOT EXISTS `new_cate_temp_form` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `temp_id` int NOT NULL DEFAULT '0' COMMENT '关联 new_cate_temp.id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '规格',
  `weight` decimal(11,4) NOT NULL DEFAULT '0.0000' COMMENT '重量(kg)',
  `extra_ratio` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '工电费补偿',
  `sorts` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `temp_id` (`temp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='公共模版-规格明细';

-- ============================================================
-- 八、三级材料管理表格接入“公共模版”（引用后随模版实时联动）
-- new_cate 新增 form_mode(0=自定义 1=公共模板) + temp_id(关联 new_cate_temp.id)
-- 选定模版后 new_cate_form 整体镜像模版数据；模版数据变化时(temp_save/
-- temp_import)级联同步所有关联的三级材料；清空表格时自动解除关联回到自定义
-- ============================================================

ALTER TABLE `new_cate`
  ADD COLUMN `form_mode` tinyint(1) NOT NULL DEFAULT 0 COMMENT '规格来源：0=自定义 1=公共模板' AFTER `new_label_id`,
  ADD COLUMN `temp_id` int NOT NULL DEFAULT 0 COMMENT '关联 new_cate_temp.id（form_mode=1时生效）' AFTER `form_mode`;
