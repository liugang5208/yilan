# 2026-08 功能更新说明

> 分支：`feature/20260825-app-update`
> 整理日期：2026-08-30
> 对应数据库变更：见 [`2026-08-migration.sql`](./2026-08-migration.sql)

## 目录

- [一、功能概述](#一功能概述)
- [二、PHP8 兼容性修复](#二php8-兼容性修复)
- [三、新增功能：分类溢价（公共溢价率）](#三新增功能分类溢价公共溢价率)
- [四、新增功能：板块分类条-商品详情](#四新增功能板块分类条-商品详情)
- [五、用户等级管理修复与增强](#五用户等级管理修复与增强)
- [六、分类比例设置（Users/cats）问题修复](#六分类比例设置userscats问题修复)
- [七、新增功能：三级材料公共模版](#七新增功能三级材料公共模版)
- [八、文件上传通用问题修复](#八文件上传通用问题修复)
- [九、文件变更清单](#九文件变更清单)
- [十、已知问题 / 待确认事项](#十已知问题--待确认事项)

---

## 一、功能概述

本次更新起因是项目从旧版 PHP 迁移到 **PHP 8.5** 后暴露出大量 ThinkPHP 3.2.3 遗留的兼容性问题，过程中顺带排查并修复了多个功能页面的既有 bug，同时新增/完善了几个后台管理功能：

1. **PHP8 兼容性修复**：修复了两处会导致页面整体崩溃/花屏的框架级/通用控制器级问题
2. **分类溢价**：`Goods/plate_infos` 页面新增"分类溢价"管理页，支持 Excel 批量导入 + 单条修改 + 批量百分比通调，并接入"商品设置"实现实时联动
3. **板块分类条-商品详情**：修正了此前误链到下一级表的"商品详情"入口，改为独立管理
4. **用户等级管理**：补齐表单已有、但数据库缺失的字段（客服电话、标准1~10），修复了新增/编辑等级时的多个报错，新增"公共比例设置"
5. **分类比例设置**：修复了整数校验误判、表单重复字段导致的报错
6. **三级材料公共模版**：新增模版库管理，并接入"管理表格"实现选用+实时联动+底色区分
7. **文件上传通用 bug**：修复了本次新增的两个上传页面漏写 `name="file"` 导致上传必现失败的问题

---

## 二、PHP8 兼容性修复

### 2.1 ThinkPHP 启动引导阶段崩溃：`Call to undefined function Think\C()`

**现象**：偶发性地整站崩溃，报错 `Call to undefined function Think\C()`。

**根因**：PHP 8.5 新增了"非规范类型转换"（`(boolean)`/`(integer)`/`(double)`/`(binary)`）的废弃提示，这类提示在**编译期**触发。`ThinkPHP/Common/functions.php` 的 `I()` 函数里有一处 `(boolean) $data`，当该文件被 `include` 编译时立刻触发 `E_DEPRECATED`，此时该文件自身尚未执行完、全局函数 `C()` 还不可用，而 ThinkPHP 的错误处理器又要调用 `C()`，于是级联崩溃。

**修复**：`ThinkPHP/Common/functions.php:397` `(boolean)` → `(bool)`。

### 2.2 通用编辑接口崩溃：`time() expects exactly 0 arguments, 1 given`

**现象**：任意一个"取整条记录回填表单 → 原样提交保存"模式的编辑弹窗，点保存必现报错。

**根因**：ThinkPHP 的 `_auto` 自动填充规则 `array('uptimes', 'time', 3, 'function')` 有个特性——若提交数据里已经带了该字段的值，会把这个值当参数传给填充函数。前端把 `Core/infos` 取回的整条记录（含 `uptimes` 旧值）原样提交给 `Core/edits`，导致框架实际执行了 `time($旧时间戳)`。PHP 8 下 `time()` 是零参数函数，传参直接报错（旧版 PHP 只是静默忽略多余参数）。全项目 **20+ 个 Model** 都用了同样的自动填充写法，都有同样风险。

**修复**：`App/Home/Controller/CoreController.class.php` 的 `edits($model)` 方法里，在调用 `create()` 之前统一剔除提交数据中的 `uptimes`/`times`，交由 `_auto` 规则在服务端重新生成。一处改动，全站同类编辑弹窗一起修复（`Core/change` 走的是直接 `save()`，不受影响）。

---

## 三、新增功能：分类溢价（公共溢价率）

**入口**：`Goods/plate_infos` 页面每条"板块分类条"的"分类溢价"按钮 → `Goods/premium_template`

**数据表**：新增 `plate_premium`（`plate_id` 关联 `plate.id`，`spec` 产品规格，`ratio` 溢价倍率 `decimal(10,3)`）

**功能**：
- 本地 Excel 上传导入（格式参考 `docs/common-temp.xlsx`：产品规格 + 溢价率两列），导入会整体覆盖该分类原有数据
- 单条规格溢价率可直接在表格里修改
- 批量通调：输入调整百分比，以表格当前显示值为基准整体加/减，支持小数点后三位；调整量在每行数值后跟随显示，正值（上调）红色、负值（下调）绿色；提供"重置"撤销未保存的预览
- 统一"保存修改"入口，单条修改和批量通调的结果一起提交保存

**新增文件**：
- `App/Home/Controller/GoodsController.class.php`：`premium_template()` / `premium_import()` / `premium_save()`
- `App/Home/View/Goods/premium_template.html`

### 3.1 接入"商品设置"，实现实时联动

**入口**：`Goods/plate_conts_list` 页面"商品设置"区域，"更新商品"按钮前新增"自定义溢价率／公共模板溢价率"切换。

**数据表**：`plate_conts_logs` 新增 `dratio_mode`（0=自定义 1=公共模板）。

**联动机制**（"推"而非"拉"，改公共模板后不需要人工进商品设置页操作）：
- 新增 `App/Home/Opera/PremiumSyncOpera.class.php`：给定 `plate_id`（+可选规格列表），找出该分类下所有商品里 `dratio_mode=1` 的规格行，按"产品规格"文本匹配公共模板，重新计算 `dratio`/`market` 并存库
- `Goods/premium_save()` / `premium_import()` 保存分类溢价后立即调用该同步类
- `Home/BlwaresOpera.class.php`（"更新商品"按钮的保存逻辑）里，公共模板模式下忽略前端提交的溢价率，现查一次模板当前值再计算，用于兜底"刚切到公共模板、还没被联动同步过"的情况

**踩坑记录**：最初实现时把"产品规格"这一信息硬编码为固定在 `value_7` 列（照搬 Excel 导入 `plate_conts_import` 的 A~J 固定列映射假设），导致联动完全匹配不上、看起来毫无效果。实测发现"产品规格"标签在不同商品/不同批次导入的数据里，实际存储列位置是**不固定的**（比如某批数据里存在 `key_2`/`value_2`，而非 `key_7`/`value_7`）。修复：新增全局函数 `plateContsLogSpec($row)`（`App/Common/Common/function.php`），按 `key_0`~`key_7` 的标签文本动态定位"产品规格"实际所在列，而不是假设固定位置，`PremiumSyncOpera` 和 `BlwaresOpera` 都改成调用这个函数。

**其它**：`Goods/plate_conts.html` 里的"商品详情"入口按要求临时下线（HTML 注释，未删代码，随时可恢复）。

---

## 四、新增功能：板块分类条-商品详情

**问题**：`Goods/plate_infos` 页面的"商品详情"按钮此前直接照抄了下一级 `plate_conts.html` 的按钮代码，误用了 `plate.id` 去查 `plate_conts` 表，实际打开的是"随缘对上号"的另一条无关商品记录。

**修复**：新增 `plate.g_desc`（TEXT）字段，独立管理 `plate` 自身的商品详情内容，不再借用下一级表。

**新增/修改文件**：
- `App/Home/Controller/GoodsController.class.php`：新增 `plate_desc($id, $tar='g_desc')`
- `App/Home/View/Goods/plate_desc.html`（复用 `plate_conts_info.html` 的 KindEditor + `Core/change` 保存机制，返回链接改用真实的 `pid` 而不是行自身 id）
- `App/Home/View/Goods/plate_infos.html`："商品详情"按钮链接改为 `Goods/plate_desc`

---

## 五、用户等级管理修复与增强

### 5.1 补齐表单已在用、但数据库缺失的字段

`Users/levels.html` 的"添加/等级设置"弹窗早就有客服电话（`tel`）和"标准1~标准10"（`type_a`~`type_j`）的输入项，但 `users_level` 表里长期缺这些列，提交后被 ThinkPHP 按实际表结构静默过滤掉，数据从未真正落库。

**处理方式**（按要求不改动/不复用现有 `type_a`/`type_b`/`type_c`，避免影响 `Inter` 模块 `getUser()` 现有的按数量限制逻辑）：
- 新增 `tel` 字段
- 新增独立的 `type1`~`type10` 十个字段，`Users/levels.html` 全部（列表展示 + 新增/编辑弹窗，共20+处引用）改绑到新字段，`type_a`/`type_b`/`type_c` 原样保留、未做任何改动

### 5.2 修复"添加用户等级"报错 `1364 Field 'xxx' doesn't have a default value`

`up_a`/`up_b`（旧的期货联动字段）和 `type_a`/`type_b`/`type_c` 都是 `NOT NULL` 且无默认值，但当前表单已不再提交这几个字段，导致新增功能此前完全无法使用。修复：给这5个字段补上默认值 `0`（不改字段本身，不影响已有数据）。

### 5.3 页面渲染错误：`Cannot access offset of type string on string`

**现象**："等级设置"弹窗内容渲染到了列表下方、点按钮不弹窗。

**根因**：`Users/levels.html` 里有个从未被任何按钮触发的废弃"分类比例设定"弹窗（`#myEditsCats`），内部 `<volist name="list" id="v">` 误用了跟主列表分页结构同名的 `list` 变量，导致对字符串做数组下标访问，PHP8 下直接致命错误。错误页 HTML 被硬插入当前页面中间，破坏了页面 DOM 结构，导致后续 Bootstrap 弹窗渲染异常。

**修复**：确认该弹窗及关联的 `updateInfoCats` JS 函数完全没有入口触发，直接删除死代码。

---

## 六、分类比例设置（Users/cats）问题修复

**入口**：`Users/levels.html` → "比例设定" → `Users/cats/id/{等级id}.html`

### 6.1 `filter_var(..., FILTER_VALIDATE_INT)` 误判带前导0的合法整数

`"05"`、`"08"` 这类带前导0的整数字符串会被 `FILTER_VALIDATE_INT` 判定为非法（这是 PHP 一直以来的行为，不是 PHP8 新增的），点进一个默认值为"0"的输入框、不清空直接输入就很容易触发。改用正则 `/^[-+]?\d+$/` 做宽松校验，同时修复了 `cats_op_form()` 里一处报错文案字面量拼写错误（原本会显示乱码文案）。

### 6.2 表单重复字段导致 `trim(): Argument #1 must be of type string, array given`

`cats.html` 的桌面表格视图和手机卡片视图**同时存在于 DOM 中**（只是靠媒体查询切换 `display`），两边都各有一个同名的 `form_data[k][cats_up]` 输入框。点"立即保存"整表提交时，jQuery 把两份同名值合并成了数组，后端拿到的 `cats_up` 不是字符串而是数组，`trim()`/`preg_match()` 直接崩溃。

**修复**：手机端输入框去掉 `name` 属性（不再参与表单提交），改为两边输入框实时 `oninput` 互相同步值，保证不管在桌面还是手机视图下修改，提交时唯一带 `name` 的桌面输入框永远是最新值。同时在后端加了一道防御：万一 `cats_up` 仍是数组，返回干净的错误提示而不是致命报错。

### 6.3 补充"返回"入口

`cats.html` 页头新增"← 返回等级列表"链接，回到 `Users/levels.html`。

### 6.4 新增"公共比例设置"（管理界面，暂不接入报价计算）

**入口**：`Users/levels.html`"添加用户等级"按钮前新增"公共比例设置" → `Users/cats/id/0.html`

**设计**：不新建表/新建页面，复用现有的 `users_cats` 表和 `Users/cats` 页面/接口。新增 `type` 字段区分比例类型（`0`=公共比例 `1`=等级比例），并约定 `ac_level=0` 专属"公共"（真实等级 id 从1开始自增，不会冲突）。`cats()`/`cats_op()`/`cats_op_form()` 根据提交的 `ac_level` 是否为0 自动分流查询/写入 `type=0` 还是 `type=1`，页面标题也据此显示"公共比例设置"或"分类比例设置"。

```sql
ALTER TABLE `users_cats`
  ADD COLUMN `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '比例类型：0=公共比例 1=等级比例' AFTER `id`;
```

**明确暂不做的部分**：`Inter/GoodsController::getUser()` 的报价公式没有改动，"公共比例"现在只是能存能改的后台数据，不会影响任何实际报价。

---

## 七、新增功能：三级材料公共模版

**背景**：`NewCate/index.html`"三级材料管理"下方"管理表格"（`new_cate_form`：规格/重量(kg)/工电费补偿）此前每个三级材料都要单独手工维护或单独 Excel 导入。新增"公共模版"机制，允许把常用的一套规格数据做成模版，多个三级材料复用同一份，改模版自动联动到所有引用它的材料。

### 7.1 模版库管理（依附于二级材料，每个二级最多3个）

**入口**：`NewCate/index.html` 三级材料管理 header，"添加分类"前的"添加模版"入口；已添加的模版以标签形式展示，各带"编辑"/"删除"。

**数据表**：
```sql
CREATE TABLE `new_cate_temp` (
  id, new_cate_id(关联二级材料), name(模版名称), sorts, uptimes, times
);
CREATE TABLE `new_cate_temp_form` (
  id, temp_id(关联模版), name(规格), weight(重量kg), extra_ratio(工电费补偿), sorts
);
```

**功能**：
- 新增模版（只填名称，超过3个直接拒绝）→ 跳转到编辑页
- 编辑页：模版名称可改、Excel 上传导入覆盖（格式参考 `docs/cailiao-common.xlsx`：规格/重量(kg)/工电费补偿），规格明细表格可逐行编辑，统一"保存修改"
- 删除模版需 `swal` 二次确认弹窗，删除时同步清空规格明细

**新增/修改文件**：
- `App/Home/Controller/NewCateController.class.php`：`temp_form()`（编辑页渲染）/ `temp_add()` / `temp_info()` / `temp_import()` / `temp_save()` / `temp_del()`；`ajaxCateFirst2()` 顺带把二级材料对应的模版列表一起返回
- `App/Home/View/NewCate/temp_form.html`（新增/编辑复用同一个页面）
- `App/Home/View/NewCate/index.html`：header 新增模版标签展示、"添加模版"入口、添加模版弹窗

### 7.2 管理表格接入公共模版，实时联动 + 底色区分

**入口**：三级材料"管理表格与参数配置"模块，"导入数据"按钮前新增"选择模版"下拉（自定义 + 当前二级下最多3个模版）。

**数据表**：`new_cate` 新增 `form_mode`（0=自定义 1=公共模板）+ `temp_id`（关联的模版）。

**选定模版后**：
- 该三级材料标记为 `form_mode=1`，`new_cate_form` 整体镜像模版的规格明细（规格/重量/工电费补偿照抄模版，单价用该材料自己的单价重新计算基础价/执行价），并按原有机制联动下游商品报价（`checkContsLog`）
- 管理表格的"规格/重量/工电费补偿"输入框变只读
- 三级材料列表方块按 `form_mode` 加浅紫色底色区分（跟"分类溢价"已用过的紫色 `#5856D6` 呼应），并在名称后加"公共模版"小标签

**模版数据变化时自动联动**：`temp_save()`/`temp_import()` 保存完模版数据后，级联把所有 `form_mode=1` 且关联该模版的三级材料重新镜像一遍，不需要人工进材料管理页操作。

**"导入数据"/"更新数据"/"清空表格"三个按钮在公共模板模式下的行为**（应用户要求，按钮保留可点，只是数据来源变了）：
- "导入数据"：不使用你上传的 Excel 内容，点击后直接从关联模版重新拉取最新数据覆盖表格
- "更新数据"：不使用页面上的输入值（反正只读），直接从模版重新取值计算保存——这两个按钮在此模式下效果等价，都是"手动触发一次同步"，作为自动联动的兜底
- "清空表格"：仍是真清空，同时自动把该材料切回"自定义"模式（否则清空后立刻被联动逻辑重新填回去）

**模版被删除时**：已应用该模版的三级材料自动解除关联回到自定义，规格数据保留最后一次同步的内容，不清空。

**新增/修改文件**：
- `App/Home/Controller/NewCateController.class.php`：新增 `cate_form_use_temp()`、私有方法 `mirrorTempToCate()`/`syncLinkedCates()`；`cate_form_import()`/`cate_form_update()`/`cate_form_del()` 按 `form_mode` 分流
- `App/Home/View/NewCate/index.html`：管理表格工具栏新增"选择模版"下拉、输入框只读判断、三级材料方块底色

---

## 八、文件上传通用问题修复

**现象**：本次会话新增的两个 Excel 上传页面（分类溢价 `premium_template.html`、公共模版 `temp_form.html`）点"上传导入"必现"文件上传失败"。

**根因**：项目用的是老式 `ajaxFileUpload`（隐藏 iframe 表单上传），它会把选中的 `<input type="file">` 原样移到一个动态表单里再提交——**浏览器只提交带 `name` 属性的表单字段**，没有 `name` 的 input 根本不会出现在提交数据里，服务端自然拿不到文件。这两个页面的文件框都只写了 `id`，漏了 `name="file"`（对比项目里其它6处正常能用的上传功能，全都带着 `name="file"`）。之前验证这两个上传接口时用 curl 直接指定了 `-F "file=@..."`，绕开了真实的浏览器/JS 这一层，所以没测出来。

**修复**：`premium_template.html`、`temp_form.html` 的文件输入框都补上 `name="file"`。

---

## 九、文件变更清单

| 文件 | 变更类型 | 说明 |
|------|----------|------|
| `ThinkPHP/Common/functions.php` | 修改 | `(boolean)` → `(bool)`，修复 PHP8 启动崩溃 |
| `App/Common/Common/function.php` | 修改 | 新增全局函数 `plateContsLogSpec()`，动态定位"产品规格"实际列位置 |
| `App/Home/Controller/CoreController.class.php` | 修改 | `edits()` 剔除 `uptimes`/`times`，修复 PHP8 通用编辑崩溃 |
| `App/Home/Controller/GoodsController.class.php` | 修改 | 新增 `premium_template`/`premium_import`/`premium_save`、`plate_desc` |
| `App/Home/Controller/UsersController.class.php` | 修改 | `cats`/`cats_op`/`cats_op_form` 整数校验修复、防御数组输入、报错文案修复、`type`字段公共/等级分流 |
| `App/Home/Controller/NewCateController.class.php` | 修改 | 公共模版 CRUD（`temp_*`）+ 管理表格接入模版（`cate_form_use_temp`/`mirrorTempToCate`/`syncLinkedCates`，`cate_form_import`/`update`/`del` 按模式分流） |
| `App/Home/Opera/PremiumSyncOpera.class.php` | 新增 | 分类溢价 → 商品设置 级联同步 |
| `App/Home/Opera/BlwaresOpera.class.php` | 修改 | 公共模板模式下现查溢价率覆盖，兜底联动 |
| `App/Home/View/Goods/premium_template.html` | 新增 | 分类溢价管理页 |
| `App/Home/View/Goods/plate_desc.html` | 新增 | 板块分类条-商品详情编辑页 |
| `App/Home/View/Goods/plate_infos.html` | 修改 | "商品详情"链接修正 |
| `App/Home/View/Goods/plate_conts.html` | 修改 | "商品详情"入口临时下线（注释） |
| `App/Home/View/Goods/plate_conts_list.html` | 修改 | "商品设置"接入公共模板：自定义/公共模板溢价率切换、只读输入框 |
| `App/Home/View/Users/levels.html` | 修改 | 移除废弃弹窗死代码；`type_a~type_j` 改绑 `type1~type10`；新增"公共比例设置"入口 |
| `App/Home/View/Users/cats.html` | 修改 | 修复重复字段提交 bug；新增返回入口；公共/等级标题条件显示 |
| `App/Home/View/NewCate/index.html` | 修改 | 公共模版 header 展示/入口；管理表格接入模版选择、只读、底色区分 |
| `App/Home/View/NewCate/temp_form.html` | 新增 | 三级材料公共模版编辑页 |
| `docs/2026-08-migration.sql` | 新增 | 本次所有数据库变更 SQL |

---

## 十、已知问题 / 待确认事项

以下问题在排查过程中被发现，但按讨论结果**本次未处理**，记录以备后续跟进：

1. **`Inter` 模块商品详情接口尚未按"标准选项卡"精确控制可见性**：`Users/levels.html` 新增的 `type1~type10` 目前只是数据库字段和后台表单，客户端（`App/Inter/Controller/GoodsController.class.php`）的 `getUser()` 依然是按旧的 `type_a+type_b+type_c` 数量求和逻辑控制可见标准数（未使用新字段，也未改造成按 `plate_conts_blank_group.sort` 精确匹配）。本次讨论已明确"标准选项卡"实际对应 `plate_conts_blank_group`（每个商品固定10个，`sort`=1~10）而非 `plate_conts_blank.cat_index`，但消费端改造被明确要求本次暂不处理。
2. **`plate_conts_info.html` 返回链接使用了错误的 id**：返回链接把当前记录自身的 id 当成父级 id 传给 `Goods/plate_conts`，只是因为两级 id 经常凑巧对上所以没被发现，未修复。
3. **`users_level.up_a`/`up_b`（沪铜/沪铝主力）无管理界面可编辑**：现在固定为默认值0，仅在 `plate_cats.float_cat != 0` 时才会生效；当前全部50个分类 `float_cat` 均为0，暂未实际触发，如果以后启用会导致对应等级的基准比例被清零。
4. **`Goods/plate_conts.html`"商品详情"入口临时下线**：目前是 HTML 注释隐藏，后端接口 `plate_conts_info` 本身未删除，如需恢复直接取消注释即可。
