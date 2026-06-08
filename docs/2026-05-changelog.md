# 2026-05 功能更新说明

## 目录

- [一、功能概述](#一功能概述)
- [二、数据库变更](#二数据库变更)
- [三、后端变更](#三后端变更)
- [四、前端变更](#四前端变更)
- [五、期货价格同步模块](#五期货价格同步模块)

---

## 一、功能概述

本次更新主要涉及以下四个方向：

1. **分类管理重构**：`NewLabel` 分类新增 `cate_type` 字段，将基础材料和衍生材料拆分为独立 section 管理，添加入口和展示逻辑分离
2. **价格精度提升**：所有比例字段和价格字段精度从 2 位提升至 4 位，支持 `0.0011` 这样的微小换算比例
3. **级联计算公式变更**：`end_ratio`（组合工费）改为加法追加，而非原来的乘法倍率
4. **期货价格同步**：新增独立的期货价格同步管理模块，对接东方财富期货行情 API，支持手动/自动同步并级联更新衍生材料价格

---

## 二、数据库变更

### 2.1 `new_label` 表字段变更

```sql
-- 新增：分类类型字段（区分基础材料分类和衍生材料分类）
ALTER TABLE `new_label`
  ADD COLUMN `cate_type` tinyint(1) NOT NULL DEFAULT 0
  COMMENT '0=基础材料分类 1=衍生材料分类' AFTER `name`;

-- 精度提升：关联比例和组合工费字段
ALTER TABLE `new_label`
  MODIFY COLUMN `ratio`     decimal(14,4) NOT NULL DEFAULT 100.0000,
  MODIFY COLUMN `ratio2`    decimal(14,4) NOT NULL DEFAULT 100.0000,
  MODIFY COLUMN `ratio3`    decimal(14,4) NOT NULL DEFAULT 100.0000,
  MODIFY COLUMN `end_ratio` decimal(14,4) NOT NULL DEFAULT 0.0000;

-- 精度提升：执行价格字段
ALTER TABLE `new_label`
  MODIFY COLUMN `price` decimal(14,4) NOT NULL DEFAULT 0.0000;

-- 新增：期货同步记录字段（记录最近一次同步时的期货现价、比例和时间）
ALTER TABLE `new_label`
  ADD COLUMN `last_futures_price` decimal(14,4) NOT NULL DEFAULT 0.0000   COMMENT '最近一次同步时的期货现价' AFTER `price`,
  ADD COLUMN `last_sync_ratio`    decimal(16,6) NOT NULL DEFAULT 0.000000 COMMENT '最近一次同步时使用的换算比例%' AFTER `last_futures_price`,
  ADD COLUMN `last_sync_time`     int           NOT NULL DEFAULT 0         COMMENT '最近一次同步时间戳' AFTER `last_sync_ratio`;

-- 精度提升：关联比例和组合工费支持 6 位小数输入
ALTER TABLE `new_label`
  MODIFY COLUMN `ratio`     decimal(16,6) NOT NULL DEFAULT 100.000000,
  MODIFY COLUMN `ratio2`    decimal(16,6) NOT NULL DEFAULT 100.000000,
  MODIFY COLUMN `ratio3`    decimal(16,6) NOT NULL DEFAULT 100.000000,
  MODIFY COLUMN `end_ratio` decimal(16,6) NOT NULL DEFAULT 0.000000;
```

### 2.2 `new_cate` 表字段变更

```sql
ALTER TABLE `new_cate`
  MODIFY COLUMN `price` decimal(14,4) NOT NULL DEFAULT 0.0000;
```

### 2.3 `new_cate_form` 表字段变更

```sql
ALTER TABLE `new_cate_form`
  MODIFY COLUMN `price` decimal(14,4) NOT NULL DEFAULT 0.0000;
```

### 2.4 新建表：`price_sync_config`（期货同步配置）

```sql
CREATE TABLE `price_sync_config` (
  `id`           int unsigned  NOT NULL AUTO_INCREMENT,
  `futures_code` varchar(20)   NOT NULL                 COMMENT '期货合约代码，如 cum',
  `futures_name` varchar(50)   NOT NULL                 COMMENT '期货名称，如 沪铜主连',
  `exchange`     varchar(10)   NOT NULL DEFAULT 'shfe'  COMMENT '交易所代码 shfe/dce/czce/gfex',
  `new_label_id` int           NOT NULL                 COMMENT '对应的 new_label.id',
  `label_name`   varchar(100)  NOT NULL DEFAULT ''      COMMENT '材料名称缓存',
  `ratio`        decimal(14,4) NOT NULL DEFAULT 100.0000 COMMENT '换算比例（%）：100=100%，材料价格 = 期货价格 × ratio / 100',
  `auto_sync`    tinyint(1)    NOT NULL DEFAULT 0       COMMENT '0=停用 1=自动同步',
  `status`       tinyint(1)    NOT NULL DEFAULT 1       COMMENT '1=正常 0=已删除',
  `add_time`     int           NOT NULL DEFAULT 0,
  `up_time`      int           NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='期货价格同步配置';
```

### 2.5 新建表：`price_sync_log`（期货同步日志）

```sql
CREATE TABLE `price_sync_log` (
  `id`            int unsigned  NOT NULL AUTO_INCREMENT,
  `config_id`     int           NOT NULL DEFAULT 0      COMMENT '关联 price_sync_config.id',
  `futures_code`  varchar(20)   NOT NULL DEFAULT '',
  `futures_name`  varchar(50)   NOT NULL DEFAULT '',
  `new_label_id`  int           NOT NULL DEFAULT 0,
  `label_name`    varchar(100)  NOT NULL DEFAULT '',
  `futures_price` decimal(14,4) NOT NULL DEFAULT 0.0000 COMMENT '抓取到的期货最新价',
  `old_price`     decimal(14,4) NOT NULL DEFAULT 0.0000 COMMENT '同步前材料价格',
  `new_price`     decimal(14,4) NOT NULL DEFAULT 0.0000 COMMENT '同步后材料价格',
  `sync_type`     tinyint(1)    NOT NULL DEFAULT 1      COMMENT '1=手动 2=自动定时',
  `status`        tinyint(1)    NOT NULL DEFAULT 1      COMMENT '1=成功 0=失败',
  `remark`        varchar(200)  NOT NULL DEFAULT ''     COMMENT '备注/错误信息',
  `add_time`      int           NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_config_id` (`config_id`),
  KEY `idx_add_time`  (`add_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='期货价格同步日志';
```

---

## 三、后端变更

### 3.1 `NewLabelController.class.php`

**`index()` 方法**

- 原来只 assign 一个 `$list`
- 现在构建完整树后按 `cate_type` 拆分，分别 assign：
  - `$baseList`：基础材料分类（cate_type=0）
  - `$derivedList`：衍生材料分类（cate_type=1）
  - `$allTree`：全量树（供前端行情下拉和级联颜色判断使用）

**`add()` 方法**

- 接收 `cate_type` 字段，写入数据库

**`edit()` 方法 — Bug 修复**

修复了三处原有 Bug：

| Bug | 描述 | 修复方式 |
|-----|------|----------|
| `$up` 不重置 | 跨循环字段残留导致写入脏数据 | 每次迭代 `$up = []` |
| `$orgChildList2` 价格计算错误 | 用 pid2 的价格乘以 ratio1 | 统一用 `$calcPrice` 闭包计算三路贡献 |
| `$orgChildList3` 价格计算错误 | 同上 | 同上 |

**`end_ratio` 公式变更**

```
// 旧：乘法倍率
price = total × end_ratio / 100

// 新：加法追加（组合工费作为固定值叠加）
price = total + end_ratio
```

**`addGet()` / `editGet()` 方法**

- `cate_list` 改为查全库所有 `cate_label_id > 0` 的材料（不再局限于同一分类）
- `editGet()` 返回 `price` 时用 `number_format(..., 4)` 格式化为 4 位小数
- `editGet()` 新增返回字段：

| 字段 | 说明 |
|------|------|
| `last_futures_price` | 最近一次同步时的期货现价（4位小数格式化） |
| `last_sync_ratio` | 最近一次同步时使用的换算比例（%） |
| `has_auto_sync` | 是否配置了自动同步（0/1）：查询 `price_sync_config` 中是否存在 `new_label_id=当前材料 AND auto_sync=1 AND status=1` |
| `sync_config_id` | 对应的同步配置 id（`has_auto_sync=1` 时有值） |

---

### 3.2 `NewCateController.class.php`

**`cate_form()` 方法**

- 大类筛选：只取 `cate_type=1`（衍生材料）的根节点
- 过滤已删除分类：先查根节点建 `id=>name` 索引，子材料的 `cate_label_id` 必须在有效 id 列表内
- 附加 `cat_name` 字段，不再依赖 `_name.split('-')[0]` 截取（避免大类名含 `-` 时截断错误）
- 返回 `list` 时格式化 `price`/`calc_base_price`/`end_price` 为 4 位小数
- 返回 `info.price` 时格式化为 4 位小数

---

### 3.3 新建 `PriceSyncController.class.php`

路径：`App/Home/Controller/PriceSyncController.class.php`

| 方法 | 类型 | 功能说明 |
|------|------|----------|
| `index()` | GET | 渲染期货价格同步管理页面 |
| `getQuotes()` | POST | 代理东方财富期货行情 API，返回指定交易所主连合约列表 |
| `getMaterials()` | POST | 返回**基础材料分类（cate_type=0）**下 pid=0 的材料，携带 cat_name，供下拉选择 |
| `getConfigList()` | POST | 查询所有有效同步配置，附带当前材料实时价格 |
| `saveConfig()` | POST | 新增或编辑同步配置 |
| `delConfig()` | POST | 软删除同步配置（status=0） |
| `toggleAutoSync()` | POST | 切换自动同步开关 |
| `syncOne()` | POST | 执行单条同步：拉行情 → 按百分比计算 → 更新材料 → 级联 → 记日志 → 写同步记录到 new_label |
| `batchSync()` | POST | 批量同步多条配置 |
| `syncAuto()` | POST | 定时自动同步入口：查所有 auto_sync=1 的配置逐一执行，sync_type=2 |
| `getSyncLog()` | POST | 查指定配置最近 50 条同步日志 |
| `_fetchPrice()` | private | curl 抓取东方财富单个合约最新价 |
| `_recalcCascade()` | private | 级联更新下游衍生材料价格，并触发 NewCate Opera 联动 |

**行情 API 信息**

```
URL:     https://futsseapi.eastmoney.com/list/main/risk/{exchange}
参数:    orderBy=&sort=&pageSize=999&pageIndex=0&specificContract=false&platform=zbPC&field=name,p,zdf,zde,zjsj,dm
Headers: Referer: https://qhweb.eastmoney.com/
         User-Agent: Mozilla/5.0 ...Chrome/124.0.0.0 Safari/537.36
支持交易所: shfe（上期所）/ dce（大商所）/ czce（郑商所）/ gfex（广期所）
```

**价格级联逻辑**（`_recalcCascade`）

```
当基础材料价格变更时：
1. 查找所有 pid_str  包含该 id 的衍生材料 → 重新计算价格
2. 查找所有 pid2_str 包含该 id 的衍生材料 → 重新计算价格
3. 查找所有 pid3_str 包含该 id 的衍生材料 → 重新计算价格
4. 调用 NewLabelOpera::runs() 触发 new_cate/new_cate_form 价格联动

价格公式：
price = (pid1.price × ratio/100) + (pid2.price × ratio2/100) + (pid3.price × ratio3/100) + end_ratio
```

---

## 四、前端变更

### 4.1 `NewLabel/index.html`

**分类展示重构**

- 拆分为两个独立 section：
  - `#section-base`：基础材料管理（展示 `baseList`，`cate_type=0`）
  - `#section-derived`：衍生材料管理（展示 `derivedList`，`cate_type=1`）
- 每个 section 有独立的标题栏和添加入口按钮
- 基础材料 section 标题栏增加"⇄ 期货价格同步"入口

**添加分类入口**

- 原来：单一"添加新的分类"按钮
- 现在：`+ 添加基础材料分类`（深色）和`+ 添加衍生材料分类`（蓝色）分别触发，通过 `openAddCate(0/1)` 传入不同 `cate_type`

**添加材料弹窗（基础/衍生区分）**

- 通过 `infos.isBase` 标记区分当前操作的分类类型
- 基础材料分类：隐藏材料关联选择框和组合工费比例，只填名称和执行价格
- 衍生材料分类：完整显示三路材料选择和比例配置

**材料选择下拉过滤**

- 切换大类时，材料子列表根据大类的 `cate_type` 过滤：
  - 基础分类 → 只显示 `pid=0` 的材料
  - 衍生分类 → 只显示 `pid>0` 的材料

**衍生材料添加校验**

- 衍生分类下添加材料时，必须至少选择一个材料（pid/pid2/pid3 其一 > 0），否则弹出提示阻止提交

**比例输入框精度**

- 所有 ratio/ratio2/ratio3/end_ratio 输入框加 `step="0.0001"`，支持 4 位小数输入

**价格展示精度**

- 前端 JS 计算结果：`Math.round(* 10000) / 10000`，`toFixed(4)`
- 后端 `editGet` 返回 price 时 `number_format(..., 4)`

**基础材料卡片——期货现价展示**

- 当材料的 `last_futures_price > 0`（即已通过期货同步过价格），在材料卡片价格行左侧额外展示期货现价
- 期货现价与执行价格**同行显示**，蓝色背景（`#eaf3fd`）+ 蓝色边框区分
- 无期货同步记录时，仅显示正常的执行价格

```
有同步记录：  [期货现价（蓝）] [执行价格（白）] [编辑]
无同步记录：  [执行价格（白）]                  [编辑]
```

**调价弹窗（`#myEdit2`）——自动同步锁**

当 `infos.has_auto_sync == 1`（该材料在 `price_sync_config` 中存在启用的自动同步配置）时：

- 隐藏可编辑的执行价格输入框
- 改为只读展示三个字段（横排）：

| 字段 | 样式 |
|------|------|
| 期货现价 | 灰色只读框，显示 `last_futures_price` |
| 同步比例 | 灰色只读框，显示 `last_sync_ratio%` |
| 执行价格 | 蓝色只读框，显示当前 `price` |

- 顶部显示橙色警告条：「⚠ 该材料已配置期货自动同步，价格不可手动修改」
- "更新"按钮禁用，文字改为「价格同步中（不可修改）」

当 `has_auto_sync == 0` 时，弹窗保持正常可编辑状态。

---

### 4.2 `NewCate/index.html`

- 大类筛选框中的材料下拉：只展示 `pid > 0` 的衍生材料
- 价格展示（`cate_form.infos.price`）加 `| number:4` filter，显示 4 位小数
- `buildLabelGroups`：使用后端返回的 `cat_name` 字段直接作为大类名（不再用 `_name.split('-')[0]`，避免含 `-` 的大类名被截断）

---

### 4.3 新建 `PriceSync/index.html`

路径：`App/Home/View/PriceSync/index.html`

页面访问：`http://localhost:8088/Home/PriceSync/index`

**页面布局**

```
┌────────────────────────────────────────────────────────────┐
│  东方财富期货                                   [返回分类管理] │
├──────────────────────┬─────────────────────────────────────┤
│  期货实时行情（左栏）  │  同步配置（右栏）                    │
│  ┌─────────────────┐  │  [批量同步] [+ 新增配置]             │
│  │上期所│大商所│...│  │  ┌──────────────────────────────┐  │
│  └─────────────────┘  │  │期货 │材料 │比例│自动│操作    │  │
│  搜索框               │  │沪铜 │铜价 │1   │启用│同步/编辑│  │
│  ┌───────────────┐    │  └──────────────────────────────┘  │
│  │合约 │代码│价格│    │                                      │
│  │沪铜 │cum │...│    │                                      │
│  └───────────────┘    │                                      │
└──────────────────────┴─────────────────────────────────────┘
```

**功能列表**

| 功能 | 说明 |
|------|------|
| 四交易所 tab | 上期所/大商所/郑商所/广期所，切换时从后端拉取实时行情 |
| 行情刷新 | 真实调用东方财富 API，带本地缓存避免重复请求 |
| 行情搜索 | 前端过滤合约名称 |
| + 配置按钮 | 点击行情表格行可预填期货合约 |
| 新增/编辑配置 | 二级联动下拉（先选大类，再选材料），实时显示预计同步价格（按 ratio/100 计算） |
| 单条同步 | 拉取当前行情 → 计算 → 更新材料价格 → 级联更新衍生材料 → 记日志 |
| 批量同步 | 勾选多行后一键批量同步 |
| 自动同步开关 | 标记是否参与定时自动同步 |
| 同步日志 | 弹窗展示最近 50 条同步记录，含期货价、同步前后价格、触发方式 |

---

## 五、期货价格同步模块

### 5.1 同步价格公式

换算比例 `ratio` 以**百分比**表示，`100` 代表 100%：

```
同步后材料价格 = futures_price × ratio / 100

示例：
  期货现价 104430，ratio = 100   → 材料价格 = 104430.0000
  期货现价 104430，ratio = 90    → 材料价格 = 93987.0000
  期货现价 104430，ratio = 0.09  → 材料价格 = 94.0000（元/kg 换算）
```

### 5.2 手动同步流程

```
用户点击"同步"按钮
    ↓
前端获取行情缓存中该合约的最新价（若无则由后端主动拉取）
    ↓
POST /Home/PriceSync/syncOne { config_id, futures_price }
    ↓
后端：new_price = futures_price × ratio / 100
    ↓
UPDATE new_label SET
  price              = new_price,
  last_futures_price = futures_price,   ← 记录本次期货现价
  last_sync_ratio    = ratio,           ← 记录本次换算比例
  last_sync_time     = now()            ← 记录同步时间
    ↓
_recalcCascade(new_label_id)：更新所有引用该材料的衍生材料价格
    ↓
NewLabelOpera::runs()：更新 new_cate/new_cate_form 相关记录
    ↓
INSERT price_sync_log（记录本次同步完整详情）
    ↓
返回新价格给前端，前端更新 current_price 显示
```

### 5.3 定时自动同步

`syncAuto` 接口已实现，逻辑为查询所有 `auto_sync=1` 的配置逐一执行同步，日志中 `sync_type=2` 标记为定时触发。

在服务器配置 cron 定期调用：

```bash
# 每天早上 10 点执行一次
0 10 * * * /usr/bin/curl -s http://localhost:8088/Home/PriceSync/syncAuto > /dev/null 2>&1
```

### 5.4 衍生材料价格公式（级联计算）

```
材料执行价格 = (pid1.price × ratio/100)
             + (pid2.price × ratio2/100)
             + (pid3.price × ratio3/100)
             + end_ratio（组合工费，固定值加法）
```

> `end_ratio` 为固定金额追加，例如 `end_ratio = 5` 表示在材料综合价基础上追加 5 元工费。

---

## 六、文件变更清单

| 文件 | 变更类型 | 说明 |
|------|----------|------|
| `App/Home/Controller/NewLabelController.class.php` | 修改 | index 分组、edit bug修复、end_ratio公式、addGet/editGet 全量查询 |
| `App/Home/Controller/NewCateController.class.php` | 修改 | cate_form 过滤衍生分类、cat_name字段、价格格式化 |
| `App/Home/Controller/PriceSyncController.class.php` | **新建** | 期货价格同步全套接口，含 syncAuto 定时同步接口 |
| `App/Home/View/NewLabel/index.html` | 修改 | 双section布局、分类入口、材料过滤、精度、期货同步入口 |
| `App/Home/View/NewCate/index.html` | 修改 | 材料下拉过滤、价格格式化、cat_name展示 |
| `App/Home/View/PriceSync/index.html` | **新建** | 期货价格同步管理完整页面，换算比例改为百分比展示 |
| `database/` | SQL | 见第二节，所有 ALTER TABLE 和 CREATE TABLE 语句 |
