# 属性价格计算公式重构 — 开发说明文档

> 分支：`feature/20260531-price-auto-update`  
> 完成日期：2026-06-12  
> 涉及模块：属性分类商品管理（板块商品价格）

---

## 目录

- [一、功能概述](#一功能概述)
- [二、数据库变更](#二数据库变更)
- [三、后端变更](#三后端变更)
- [四、前端变更](#四前端变更)
- [五、价格计算公式](#五价格计算公式)
- [六、文件变更清单](#六文件变更清单)

---

## 一、功能概述

本次更新对**属性分类商品管理**（`plate_conts_list` 页面）进行了全面重构，引入以下功能：

1. **标准选项分组管理**：新增 `plate_conts_blank_group` 表，每个商品（`pid`）可配置多个标准选项，每个选项带独立的比例（`ratio`），用于区分不同规格/标准下的价格倍率。

2. **属性价格配置管理**：`plate_conts_price` 表及 `GoodsPriceController` 原已存在，本次在原有基础上补全接口（`priceCopy`/`priceCopyFrom`），并将查询索引从 `pid + cat_index` 迁移到 `blank_id`。

3. **市场价计算公式升级**：在原来 `price × dratio` 的基础上，追加**商品属性费率**（blankRatio）和**标准选项比例**（groupRatio）的乘积，使市场价能反映属性费率和所属标准选项的综合定价。

4. **blank_id 统一索引**：将原来以 `pid + cat_index` 双字段定位商品属性的方式，迁移到以 `blank_id` 单字段直接定位，提升查询效率，减少关联层级。

---

## 二、数据库变更

### 2.1 新建表：`plate_conts_blank_group`（标准选项分组）

```sql
CREATE TABLE `plate_conts_blank_group` (
  `id`       int unsigned  NOT NULL AUTO_INCREMENT,
  `pid`      int           NOT NULL DEFAULT 0    COMMENT '对应 plate_conts.id（商品 id）',
  `name`     varchar(100)  NOT NULL DEFAULT ''   COMMENT '选项卡名称',
  `ratio`    decimal(14,6) NOT NULL DEFAULT 1.000000 COMMENT '标准选项比例，直接乘数（1 表示不调整，1.05 表示上浮 5%）',
  `sort`     int           NOT NULL DEFAULT 0    COMMENT '排序',
  `add_time` int           NOT NULL DEFAULT 0,
  `up_time`  int           NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='属性分类商品标准选项分组';
```

### 2.2 修改表：`plate_conts_price`（属性价格配置，原表已存在）

```sql
-- 新增：blank_id 直接定位商品属性，替代原来的 plate_conts_id + cat_index 双字段查找
ALTER TABLE `plate_conts_price`
  ADD COLUMN `blank_id` int NOT NULL DEFAULT 0
  COMMENT '关联 plate_conts_blank.id' AFTER `cat_index`;

ALTER TABLE `plate_conts_price`
  ADD KEY `idx_blank_id` (`blank_id`);

-- 数据迁移：根据 plate_conts_id+cat_index 反查 plate_conts_blank 补填 blank_id
-- 注意：若 plate_conts_blank 中对应记录已删除，该行 blank_id 将保持 0（孤立记录）
UPDATE `plate_conts_price` p
  INNER JOIN `plate_conts_blank` b
    ON b.pid = p.plate_conts_id AND b.cat_index = p.cat_index
SET p.blank_id = b.id
WHERE p.blank_id = 0;

-- 修复：blank 重建后 price 还指向旧 blank_id 的错位记录（blank_id 不为 0 但与实际不符）
UPDATE `plate_conts_price` p
  INNER JOIN `plate_conts_blank` b
    ON b.pid = p.plate_conts_id AND b.cat_index = p.cat_index
SET p.blank_id = b.id
WHERE p.is_del = 1
  AND p.blank_id != b.id;

-- ratio 格式迁移：从直接倍数（1.0=不变）改为百分比（100=100%=不变）
-- 执行后 CxmarkOpera 计算时 ratio 需除以 100，前端展示 100 即表示 100%
UPDATE `plate_conts_price` SET ratio = ratio * 100;
```

### 2.3 修改表：`plate_conts_blank`（商品属性）

```sql
-- 新增：标准选项分组关联字段
ALTER TABLE `plate_conts_blank`
  ADD COLUMN `group_id` int NOT NULL DEFAULT 0
  COMMENT '关联 plate_conts_blank_group.id，0=未分组' AFTER `catname`;
```

### 2.4 修改表：`plate_conts_logs`（主商品记录）

```sql
-- 新增：直接关联商品属性 id，加速查询
ALTER TABLE `plate_conts_logs`
  ADD COLUMN `blank_id` int NOT NULL DEFAULT 0
  COMMENT '关联 plate_conts_blank.id' AFTER `cat_index`;

ALTER TABLE `plate_conts_logs`
  ADD KEY `idx_blank_id` (`blank_id`);

-- 新增：扩展属性字段（key_6/value_6、key_7/value_7、key_8/value_8）
-- key_8/value_8 对应导入Excel中的第9列（发货时效），与 key_0~key_7 同结构
ALTER TABLE `plate_conts_logs`
  ADD COLUMN `key_6`   varchar(50)  DEFAULT NULL AFTER `value_5`,
  ADD COLUMN `value_6` varchar(100) DEFAULT NULL AFTER `key_6`,
  ADD COLUMN `key_7`   varchar(50)  DEFAULT NULL AFTER `value_6`,
  ADD COLUMN `value_7` varchar(100) DEFAULT NULL AFTER `key_7`,
  ADD COLUMN `key_8`   varchar(50)  DEFAULT NULL AFTER `value_7`,
  ADD COLUMN `value_8` varchar(100) DEFAULT NULL AFTER `key_8`;

-- 数据迁移：根据 pid+cat_index 反查 plate_conts_blank 补填 blank_id
UPDATE `plate_conts_logs` l
  INNER JOIN `plate_conts_blank` b
    ON b.pid = l.pid AND b.cat_index = l.cat_index
SET l.blank_id = b.id
WHERE l.blank_id = 0;

-- 新增：参考重量字段（由 CxmarkOpera 根据材料组成计算写入）
ALTER TABLE `plate_conts_logs`
  ADD COLUMN `weight` decimal(10,4) NOT NULL DEFAULT 0.0000
  COMMENT '参考重量，Σ(new_cate_form.weight × plate_conts_price.ratio)' AFTER `market`;
```

### 2.5 修改表：`plate_conts_logsr`（子规格记录）

```sql
-- 新增：参考重量字段
ALTER TABLE `plate_conts_logsr`
  ADD COLUMN `weight` decimal(10,4) NOT NULL DEFAULT 0.0000
  COMMENT '参考重量' AFTER `market`;
```

---

## 三、后端变更

### 3.1 `GoodsController.class.php` — 新增标准选项管理接口

| 新增方法 | 类型 | 功能说明 |
|----------|------|----------|
| `group_save()` | POST | 新增或编辑标准选项（`plate_conts_blank_group`），首次创建时自动将 pid 下所有 blank 关联到该分组 |
| `group_del()` | POST | 删除标准选项，同时清除 blank 的 `group_id` 关联 |
| `group_copy_from()` | POST | 将源分组下的 blank 配置复制到目标分组（按 cat_index 匹配） |
| `clear_group_content()` | POST | 清空指定分组下所有 blank 的配置、属性价格和规格数据 |

**其他变更：**

- `plate_conts_del()` 中删除 logs 和 logsr 时，优先按 `blank_id` 条件删除（兼容旧的 pid+cat_index 方式）
- `plate_conts_list()` 返回数据新增 `group_list` 字段（`plate_conts_blank_group` 全量）
- 导入商品时自动计算并写入 `blank_id`、`price` 字段

---

### 3.2 `GoodsPriceController.class.php` — 修改（原已存在）

路径：`App/Home/Controller/GoodsPriceController.class.php`

| 方法 | 类型 | 功能说明 |
|------|------|----------|
| `priceCateList()` | POST | 分级获取 new_cate 分类列表（联动下拉用） |
| `priceGet()` | POST | 获取指定 blank 下的价格配置列表 |
| `pricePost()` | POST | 新增属性价格配置，写入后立即调用 BlwaresOpera 刷新 market |
| `priceEditGet()` | POST | 获取单条价格配置详情 |
| `priceEditPost()` | POST | 编辑价格配置，保存后触发 BlwaresOpera 刷新 market |
| `priceDel()` | POST | 删除价格配置，删除后触发 BlwaresOpera 刷新 market |
| `priceCopy()` | POST | 将当前 blank 的价格配置复制到同 pid 下另一个 blank |
| `priceCopyFrom()` | POST | 将源 blank_id 的价格配置全量复制到目标 blank_id |

---

### 3.3 `BlwaresOpera.class.php` — 全量重写

**变更要点：**

1. **blank 查询方式升级**：优先通过 `blank_id` 直接定位，兼容旧的 `pid + cat_index` 组合查询。

2. **新增属性费率与分组比例**：加载 blank 后立即计算 `blankRatio` 和 `groupRatio`，供 `getMarket()` 使用：

```php
$this->blankRatio = $this->blank ? setBlankRatio($this->blank) : 1;
$groupId = ($this->blank && isset($this->blank['group_id'])) ? (int)$this->blank['group_id'] : 0;
if ($groupId > 0) {
    $group = M('plate_conts_blank_group')->where(array('id' => $groupId))->find();
    if ($group && $group['ratio'] > 0) {
        $this->groupRatio = $group['ratio'];
    }
}
```

3. **`getMarket()` 公式升级**（前后对比）：

```php
// 改动前
return bcmul((string)$v['price'], (string)$v["dratio"], 2);

// 改动后
return bcmul(
    bcmul(
        bcmul((string)$v['price'], (string)$v['dratio'], 6),
        (string)$this->blankRatio,
        6
    ),
    (string)$this->groupRatio,
    2
);
```

4. **logs 查询方式升级**：优先用 `blank_id` 查 `plate_conts_logs`，兼容旧方式。

---

### 3.4 `BlrenewOpera.class.php` — 更新板块费率时同步 market

**变更要点：**

在 `upBlankLog()` 中，循环刷新商品前先加载费率系数：

```php
$this->blankRatio = setBlankRatio($this->blank);
$groupId = isset($this->param['group_id']) ? (int)$this->param['group_id'] : 0;
if ($groupId > 0) {
    $group = M('plate_conts_blank_group')->where(['id' => $groupId])->find();
    if ($group && $group['ratio'] > 0) {
        $this->groupRatio = $group['ratio'];
    }
}
```

`getMarket()` 与 BlwaresOpera 完全一致，公式：`price × dratio × blankRatio × groupRatio`。

同时清除了已注释的旧公式代码，精简文件。

---

### 3.5 `CatioLogic.class.php` — 更新分类费率时同步 market

**变更要点：**

在 `upsetPrice()` 的 blank 循环内，查询并追加 `groupRatio`：

```php
$groupRatio = 1;
if (!empty($v['group_id'])) {
    $group = M('plate_conts_blank_group')->where(['id' => (int)$v['group_id']])->find();
    if ($group && $group['ratio'] > 0) {
        $groupRatio = (float)$group['ratio'];
    }
}
$cex = "(price*dratio*" . $catRatio . "-(price*dratio)+price)*" . $blankRatio . "*" . $groupRatio;
```

> 注：`blankRatio` 在本文件原本已通过 `setBlankRatio($v)` 计算，本次只补充了 `groupRatio`。

---

### 3.6 `NewCateOpera.class.php` — 价格联动改用 blank_id

```php
// 改动前
$run['pid']       = $v2['plate_conts_id'];
$run['cat_index'] = $v2['cat_index'];
$run['type']      = 0;

// 改动后
$run['blank_id'] = $v2['blank_id'];
$run['type']     = 0;
```

确保 new_cate 价格变更级联触发 BlwaresOpera 时，优先使用 `blank_id` 精准定位。

---

### 3.7 `CxmarkOpera.class.php` — 计算商品市场价（已在上一版本完成）

核心逻辑已升级为通过 `plate_conts_price` + `new_cate_form` 计算基础价格，再乘以 `dratio`：

```php
// 从 plate_conts_price 中找到与该 blank 绑定的所有分类配置
foreach ($price_list as $k => $v) {
    $form = $form_model->where(['new_cate_id' => $v['new_cate_three_id'], 'number' => $number])->find();
    if ($form) {
        $temp  = bcmul((string)$form['end_price'], (string)$v['ratio'], 2);
        $price = bcadd((string)$price, $temp, 2);
    }
}
$runPrice = bcmul((string)$price, (string)$dratio, 2);
```

---

## 四、前端变更

### 4.1 `plate_conts_list.html` — 全面重构

**页面结构**（三栏并列）：

```
┌─────────────────────────────────────────────────────┐
│  属性分类商品管理                                      │
├─────────────────┬──────────────────┬────────────────┤
│  标准选项管理    │  商品属性管理     │  属性价格管理   │
│  ┌───────────┐  │  ┌────────────┐  │  ┌──────────┐  │
│  │选项卡A    │  │  │属性1 up_a%│  │  │分类 ratio│  │
│  │比例：1.05 │  │  │属性2      │  │  │分类 ratio│  │
│  │选项卡B    │  │  │...        │  │  │...       │  │
│  └───────────┘  │  └────────────┘  │  └──────────┘  │
└─────────────────┴──────────────────┴────────────────┘
```

**新增功能：**

| 功能 | 说明 |
|------|------|
| 标准选项添加/编辑/删除 | 每个选项有 `name`、`ratio`、`sort` 三个字段 |
| 标准选项激活切换 | 点击选项卡自动切换当前分组下的商品属性列表 |
| 标准选项复制内容 | 将一个选项下的所有商品属性配置（blank）、属性价格（price）、规格数据（logsr）复制到另一个选项 |
| 标准选项清空内容 | 清除当前选项下所有关联数据（不可恢复） |
| 属性价格列表展示 | 展示当前 blank 绑定的所有分类价格配置，显示 `溢价率`（ratio） |
| 属性价格添加/编辑/删除 | 通过 `GoodsPriceController` 接口管理，保存后自动刷新 market |
| 属性价格复制 | 将当前 blank 的价格配置复制到指定 blank |
| 商品属性批量删除按钮 | 一键清空当前板块+分组下所有商品属性和规格 |

---

## 五、价格计算公式

### 5.1 完整公式

```
market = price × dratio × blankRatio × groupRatio
```

| 变量 | 来源 | 说明 |
|------|------|------|
| `price` | `plate_conts_price` + `new_cate_form` | 基础成本价：`Σ(form.end_price × price_config.ratio)` |
| `dratio` | `plate_conts_logs.dratio` / `plate_conts_logsr.dratio` | 商品属性溢价率（直接乘数） |
| `blankRatio` | `plate_conts_blank.up_a/down_a ~ up_f/down_f` | 商品属性综合费率，由 `setBlankRatio()` 六级复合计算 |
| `groupRatio` | `plate_conts_blank_group.ratio` | 标准选项比例（直接乘数，无分组时默认 1） |

### 5.2 blankRatio 计算方式（`setBlankRatio`）

```
blankRatio = 100
  × (1 + up_a/100) × (1 - down_a/100)
  × (1 + up_b/100) × (1 - down_b/100)
  × (1 + up_c/100) × (1 - down_c/100)
  × (1 + up_d/100) × (1 - down_d/100)
  × (1 + up_e/100) × (1 - down_e/100)
  × (1 + up_f/100) × (1 - down_f/100)
  ÷ 100
```

### 5.3 分类更新时的 SQL 公式（`CatioLogic`）

```sql
market = round(
  (price * dratio * catRatio - price * dratio + price) * blankRatio * groupRatio
, 2)
```

其中 `catRatio` = `setCatRatio(cats)` = 分类上下浮动费率。

### 5.4 示例

| price | dratio | blankRatio | groupRatio | market |
|-------|--------|------------|------------|--------|
| 1000  | 1.2    | 1.0        | 1.0        | 1200.00 |
| 1000  | 1.2    | 1.05       | 1.0        | 1260.00 |
| 1000  | 1.2    | 1.05       | 1.1        | 1386.00 |

### 5.5 各场景触发路径

| 触发场景 | 调用链 | 所有系数是否生效 |
|----------|--------|----------------|
| 手动编辑商品规格 | `BlwaresOpera::updateListMarket()` | ✅ price × dratio × blankRatio × groupRatio |
| 批量刷新 blank 下所有商品 | `BlwaresOpera::setListGoods()` → `CxmarkOpera` | ✅ 同上 |
| 更新商品属性费率（BlrenewOpera） | `BlrenewOpera::upBlankLog()` | ✅ 同上 |
| 更新分类费率（CatioLogic） | `CatioLogic::upsetPrice()` SQL | ✅ 含 catRatio |
| 属性价格配置变更 | `GoodsPriceController` → `BlwaresOpera` | ✅ 同上 |
| new_cate 价格联动 | `NewCateOpera` → `BlwaresOpera`（via blank_id） | ✅ 同上 |

---

## 六、文件变更清单

| 文件 | 变更类型 | 关键改动 |
|------|----------|----------|
| `App/Home/Controller/GoodsController.class.php` | 修改 | group_list 改全局、group_del 禁用、group_save 仅支持编辑；blank_id 支持；导入时写入 blank_id 和 price |
| `App/Home/Controller/GoodsPriceController.class.php` | 修改 | 原已存在；补全 priceCopy/priceCopyFrom 接口；查询索引从 pid+cat_index 迁移到 blank_id |
| `App/Home/Opera/BlwaresOpera.class.php` | 重写 | blank_id 优先定位；新增 blankRatio × groupRatio 乘法；精简旧死代码 |
| `App/Home/Opera/BlrenewOpera.class.php` | 修改 | upBlankLog 中加载 blankRatio/groupRatio；getMarket 三步 bcmul；清理注释代码 |
| `App/Home/Logic/CatioLogic.class.php` | 修改 | upsetPrice 循环内查询 groupRatio，追加到 SQL 公式 |
| `App/Home/Opera/NewCateOpera.class.php` | 修改 | 价格联动改用 blank_id 参数 |
| `App/Home/View/Goods/plate_conts_list.html` | 修改 | 移除分组添加/删除按钮；新增商品属性时传入 group_id |
| `App/Home/Opera/BlrenewOpera.class.php` | 修改 | 新增 blank 时自动关联默认分组（标准1选项卡） |
| `database/` | SQL | 见第二节 + 第七节：新建 `plate_conts_blank_group`；各表加字段；初始化10个全局分组 |

---

## 七、需求变更补充（2026-06-14）：标准选项改为全局固定分组

### 7.1 变更说明

| 变更点 | 变更前 | 变更后 |
|--------|--------|--------|
| 分组作用域 | 每个商品（pid）独立维护分组 | 全局共享 10 个固定分组，所有入口展示相同 |
| 分组数量 | 动态添加，无上限 | 固定 10 个，名称"标准1选项卡"至"标准10选项卡" |
| 添加入口 | 前端有"+ 添加"按钮 | 移除，不支持新增 |
| 删除功能 | 前端有"删除"按钮 | 移除，后端接口也返回禁止提示 |
| 新建商品属性默认分组 | group_id=0（未分组） | 自动关联标准1选项卡（sort/id 最小的全局分组） |

### 7.2 数据库初始化 SQL

```sql
-- ⚠️ 已由第八节「改回 per-pid 模式」的 SQL 替代，请执行第八节的 SQL
-- 以下为历史记录，不需重复执行
-- 原全局初始化（pid=0）已废弃
```

### 7.3 后端变更

**`GoodsController.class.php`**

| 方法 | 变更 |
|------|------|
| `plate_conts_blankr()` 中 group_list 查询 | `WHERE pid = $pid`（per-pid，每个商品独立10组）；若该 pid 无分组自动初始化 |
| `group_save()` | 仅保留编辑逻辑（需传 id），传 id 为空时返回错误 |
| `group_del()` | 直接返回禁止提示，不支持删除 |

**`BlrenewOpera.class.php`**

新增 blank 时，若 `group_id` 未传或为 0，自动查询该 pid 的第一个分组（`ORDER BY sort ASC, id ASC`）并写入。

### 7.4 前端变更

**`plate_conts_list.html`**

| 变更点 | 说明 |
|--------|------|
| 移除"+ 添加"按钮 | 标准选项管理区域顶部工具栏 |
| 移除每个选项卡的"删除"按钮 | 只保留"编辑"按钮 |
| 移除 `openAddGroup` 函数 | JS 层彻底删除 |
| 移除 `deleteGroup` 函数 | JS 层彻底删除 |
| 弹窗标题固定为"编辑选项" | 移除 `groupEditMode` 判断 |
| `openAddBlock` 传入当前选中 group_id | `group_id: $scope.active_group_id` 默认关联当前分组 |

---

## 八、需求变更补充（2026-06-17）：标准选项改回 per-pid 独立分组

### 8.1 变更说明

| 变更点 | 变更前（第七节） | 变更后 |
|--------|----------------|--------|
| 分组作用域 | 全局共享 10 组（pid=0） | 每个商品（pid）独立拥有 10 个分组 |
| 分组名称 | 标准1选项卡 ~ 标准10选项卡 | 标准选项卡1 ~ 标准选项卡10 |
| 分组比例默认值 | 1.000000（旧倍数格式） | 100.000000（百分比格式，100% = 实际值） |
| group_list 查询 | `WHERE pid = 0` | `WHERE pid = $pid` |
| 新 pid 首次访问 | 无自动初始化 | 自动生成 10 个分组 |

### 8.2 数据库迁移 SQL（执行顺序）

```sql
-- 1. 清空所有现有分组（含旧全局分组和旧 per-pid 分组）
DELETE FROM plate_conts_blank_group;

-- 2. 为每个有效 pid 批量生成 10 个独立分组（ratio=100 表示 100%）
INSERT INTO plate_conts_blank_group (pid, name, ratio, sort, add_time, up_time)
SELECT b.pid, CONCAT('标准选项卡', n.n), 100.000000, n.n, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()
FROM (SELECT DISTINCT pid FROM plate_conts_blank WHERE status = 1 AND pid > 0) b
CROSS JOIN (
    SELECT 1 n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
    UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
) n;

-- 3. 将所有 blank 关联到各自 pid 的 sort=1 分组（标准选项卡1）
-- 注意：用 sort=1 精确匹配，不能用 MIN(id)（CROSS JOIN 导致 id 顺序与 sort 相反）
UPDATE plate_conts_blank b
INNER JOIN plate_conts_blank_group g ON g.pid = b.pid AND g.sort = 1
SET b.group_id = g.id
WHERE b.status = 1 AND b.pid > 0;
```

> 本次共生成 **5940 个分组**（594 个 pid × 10），更新 **1624 条 blank** 关联。

### 8.3 后端变更

**`GoodsController.class.php`**

- `plate_conts_blankr()` 中 `group_list` 查询改为 `WHERE pid = $pid`
- 新增自动初始化：若该 pid 下无分组，自动调用 `addAll` 生成 10 个分组后返回

**`BlrenewOpera.class.php`**

新增 blank 时，自动查询该 pid 的第一个分组（`ORDER BY sort ASC, id ASC`）写入 `group_id`。

### 8.4 其他历史 SQL（本次执行过，供参考）

```sql
-- 旧 per-pid blank 迁移到全局分组（已被上述 SQL 覆盖，无需重复执行）
UPDATE plate_conts_blank SET group_id = (SELECT id FROM plate_conts_blank_group WHERE pid=0 ORDER BY sort,id LIMIT 1)
WHERE status=1 AND group_id > 0
  AND group_id NOT IN (SELECT id FROM plate_conts_blank_group WHERE pid=0);

-- 去重：同 pid+cat_index+group_id 下保留 id 最大的一条
DELETE b FROM plate_conts_blank b
INNER JOIN (
    SELECT pid, cat_index, group_id, MIN(id) AS min_id FROM plate_conts_blank
    WHERE status=1 GROUP BY pid, cat_index, group_id HAVING COUNT(*)>1
) dup ON b.pid=dup.pid AND b.cat_index=dup.cat_index AND b.group_id=dup.group_id AND b.id=dup.min_id;
```
