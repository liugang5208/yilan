<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>易缆通APP后台管理中心</title>
        <link rel="shortcut icon" href="/Public/assets/images/app_logo.png" type="image/png">
        <link href="/Public/assets/css/lib/font-awesome.min.css" rel="stylesheet">
        <link href="/Public/assets/css/lib/themify-icons.css" rel="stylesheet">
        <link href="/Public/assets/css/lib/bootstrap.min.css" rel="stylesheet">
        <link href="/Public/assets/css/style.css" rel="stylesheet">
        <script src="/Public/assets/js/lib/jquery.min.js"></script>
        <script src="/Public/assets/js/lib/bootstrap.min.js"></script>
        <script src="/Public/libs/angular/angular.min.js"></script>
        <link href="/Public/libs/sweet-alert2/sweetalert2.min.css" rel="stylesheet">
        <script src="/Public/libs/sweet-alert2/sweetalert2.min.js"></script>
        <link href="/Public/libs/swiper/css/swiper.min.css" rel="stylesheet">
        <script src="/Public/libs/swiper/js/swiper.min.js"></script>
        <script src="/Public/libs/layer/layer.js"></script>
        <script src="/Public/libs/common.js"></script>
        <script src="/Public/libs/ajaxfileupload.js?v=3"></script>
        <style>
            html, body {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background-color: #f7f9fc !important;
                color: #1e293b;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            }

            /* 优化：适当加深顶部导航背景色，使其与整体页面不再显得过度割裂，呈现更好的现代工业质感 */
            .top-navbar-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background-color: #e8ecf2;
                border-bottom: 2px solid #cbd5e1;
                z-index: 1000;
                padding: 10px 15px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            }

            /* 修复：移动端适配，解除导航对内容的强行遮挡 */
            @media (max-width: 768px) {
                .top-navbar-wrapper {
                    position: relative;
                }
                .content-wrap {
                    margin-top: 10px !important;
                }
            }

            .navbar-container {
                display: flex;
                flex-direction: column;
                gap: 8px;
                max-width: 1920px;
                margin: 0 auto;
            }

            .navbar-row-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-bottom: 6px;
                border-bottom: 1px solid #cbd5e1;
            }

            /* 右上角管理员菜单及下拉样式：修复修改密码与退出登录未显示的缺陷 */
            .admin-menu-dropdown {
                position: relative;
                display: inline-block;
            }

            .user-profile-btn {
                display: flex;
                align-items: center;
                gap: 6px;
                background: #ffffff;
                border: 1px solid #cbd5e1;
                padding: 5px 12px;
                border-radius: 6px;
                font-size: 13px;
                font-weight: 600;
                color: #334155;
                cursor: pointer;
                transition: all 0.2s ease;
                box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            }

            .user-profile-btn:hover {
                background: #f8fafc;
                border-color: #94a3b8;
            }

            .admin-dropdown-menu {
                display: none;
                position: absolute;
                right: 0;
                top: 100%;
                margin-top: 6px;
                background: #ffffff;
                min-width: 150px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                z-index: 1100;
                overflow: hidden;
            }

            .admin-dropdown-menu a {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                font-size: 13px;
                color: #475569;
                text-decoration: none;
                transition: background 0.15s ease;
            }

            .admin-dropdown-menu a:hover {
                background: #f1f5f9;
                color: #0f172a;
                text-decoration: none;
            }

            .admin-menu-dropdown:hover .admin-dropdown-menu {
                display: block;
            }

            .navbar-sub-row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                width: 100%;
            }

            .nav-group-card {
                background: #ffffff;
                border-radius: 6px;
                padding: 6px 10px;
                border: 1px solid #cbd5e1;
                display: flex;
                align-items: center;
                gap: 8px;
                flex: 0 1 auto; 
                box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            }

            .nav-group-card.ai-group {
                border: 1px solid #0066cc;
                background: #eff6ff;
            }

            .nav-group-title {
                font-size: 11px;
                font-weight: 700;
                color: #475569;
                border-right: 1px solid #cbd5e1;
                padding-right: 8px;
                white-space: nowrap;
            }

            .capsule-list {
                display: flex;
                align-items: center;
                gap: 6px;
                flex-wrap: wrap;
            }

            .nav-capsule {
                padding: 4px 10px;
                background-color: #f8fafc;
                color: #475569;
                font-size: 12px;
                text-decoration: none;
                border-radius: 4px;
                border: 1px solid #cbd5e1;
                white-space: nowrap;
                transition: all 0.2s ease;
            }

            .nav-capsule:hover {
                background-color: #e2e8f0;
                color: #1e293b;
                text-decoration: none;
            }

            .nav-capsule.active {
                background-color: #0066cc !important;
                color: #ffffff !important;
                border-color: #0066cc !important;
            }

            .content-wrap {
                margin-top: 155px !important;
                padding: 15px;
            }

            .main {
                background: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
        </style>
    </head>

    <body>

        <div class="top-navbar-wrapper">
            <div class="navbar-container">
                <div class="navbar-row-top">
                    <div class="top-logo">
                        <a href="<?php echo U('Bords/index');?>" style="font-weight:700; color:#1e293b; text-decoration:none; display:flex; align-items:center; gap:8px;">
                            <img src="/Public/assets/images/app_logo.png" alt="易缆通Logo" style="height:22px; width:auto; border-radius:3px; object-fit:contain;">
                            <span>易缆管理中心</span>
                        </a>
                    </div>
                    <div class="top-user-area">
                        <!-- 修复：补全管理员账号下拉菜单，显式提供修改密码与安全退出功能入口 -->
                        <div class="admin-menu-dropdown">
                            <div class="user-profile-btn">
                                <i class="ti-user"></i> 管理员 <i class="ti-angle-down"></i>
                            </div>
                            <div class="admin-dropdown-menu">
                                <a href="<?php echo U('Login/update_pwd');?>"><i class="ti-key"></i> 修改密码</a>
                                <a href="<?php echo U('Login/logout');?>" style="color: #dc2626;"><i class="ti-power-off"></i> 退出登录</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="navbar-row-bottom">
                    <div class="navbar-sub-row">
                        <div class="nav-group-card">
                            <div class="nav-group-title">用户管理</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Users/index');?>" class="nav-capsule"><i class="ti-user"></i> 用户管理</a>
                                <a href="<?php echo U('Users/logrs');?>" class="nav-capsule"><i class="ti-stats-alt"></i> 登录统计</a>
                                <a href="<?php echo U('Users/search');?>" class="nav-capsule"><i class="ti-search"></i> 搜索记录</a>
                                <a href="<?php echo U('Users/levels');?>" class="nav-capsule"><i class="ti-medall"></i> 用户等级</a>
                            </div>
                        </div>

                        <div class="nav-group-card">
                            <div class="nav-group-title">计算配置</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Task/index');?>" class="nav-capsule"><i class="ti-reload"></i> 价格任务</a>
                                <a href="<?php echo U('NewLabel/index');?>" class="nav-capsule"><i class="ti-layout-grid2"></i> 材料分类</a>
                                <a href="<?php echo U('NewCate/index');?>" class="nav-capsule"><i class="ti-calculator"></i> 公式计算</a>
                                <a href="<?php echo U('NewTax/index');?>" class="nav-capsule"><i class="ti-receipt"></i> 税率标签</a>
                            </div>
                        </div>

                        <div class="nav-group-card">
                            <div class="nav-group-title">商品管理</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Goods/cats');?>" class="nav-capsule"><i class="ti-folder"></i> 商品分类</a>
                                <a href="<?php echo U('Goods/liner');?>" class="nav-capsule"><i class="ti-plug"></i> 线缆板块</a>
                                <a href="<?php echo U('Goods/peita');?>" class="nav-capsule"><i class="ti-package"></i> 配套板块</a>
                            </div>
                        </div>
                    </div>

                    <div class="navbar-sub-row" style="margin-top: 6px;">
                        <div class="nav-group-card">
                            <div class="nav-group-title">交易管理</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Shops/index');?>" class="nav-capsule"><i class="ti-shopping-cart"></i> 店铺管理</a>
                                <a href="<?php echo U('Order/index');?>" class="nav-capsule"><i class="ti-receipt"></i> 订单管理</a>
                                <a href="<?php echo U('ReportInfo/index');?>" class="nav-capsule"><i class="ti-files"></i> 报价单</a>
                            </div>
                        </div>

                        <div class="nav-group-card">
                            <div class="nav-group-title">系统配置</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Know/advs');?>" class="nav-capsule"> 广告管理</a>
                                <a href="<?php echo U('Know/helps');?>" class="nav-capsule"> 帮助中心</a>
                                <a href="<?php echo U('Know/sysc');?>" class="nav-capsule"> 系统文本</a>
                                <a href="<?php echo U('Sysc/banks');?>" class="nav-capsule"> 银行卡号</a>
                                <a href="<?php echo U('Version/index');?>" class="nav-capsule"> 系统版本</a>
                                <a href="<?php echo U('Bar/index');?>" class="nav-capsule"> Tab栏控制</a>
                                <a href="<?php echo U('Config/customer_config');?>" class="nav-capsule"> 客服配置</a>
                            </div>
                        </div>

                        <div class="nav-group-card ai-group">
                            <div class="nav-group-title" style="color:#0066cc;">AI智能中心</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Ai/index');?>" class="nav-capsule"><i class="ti-settings"></i> AI助手设置</a>
                                <a href="<?php echo U('Ai/knowledge');?>" class="nav-capsule"><i class="ti-book"></i> 纪律模版管理</a>
                                <a href="<?php echo U('Ai/searchWords');?>" class="nav-capsule"><i class="ti-search"></i> 搜索词管理</a>
                                <a href="<?php echo U('Ai/historyList');?>" class="nav-capsule"><i class="ti-list"></i> AI历史报价</a>
                                <a href="<?php echo U('Ai/print_quote');?>" class="nav-capsule"><i class="ti-file"></i> 报价单样式</a>
                                <a href="<?php echo U('Ai/testConnect');?>" class="nav-capsule" style="background:#e0f2fe; color:#0369a1; border-color:#bae6fd;"><i class="ti-pulse"></i> 测试专区</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid apple-admin-container" ng-app="myApp" ng-controller="myCtrl">

    <!-- 顶部标题区域 -->
    <div class="row align-items-center mb-4">
        <div class="col-lg-8 col-md-8 col-sm-12 title-margin-right">
            <div class="page-header border-0 m-0 p-0">
                <div class="page-title">
                    <h1 class="text-dark fw-bold m-0" style="font-size: 24px; letter-spacing: -0.5px;">配套板块管理</h1>
                    <p class="text-muted text-secondary mt-1 mb-0" style="font-size: 13px;">管理商城系统核心配套板块，支持广告配置、商品关联及排序调整。</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 text-end mt-3 mt-md-0">
            <button type="button" class="btn btn-apple-primary shadow-sm" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus me-1"></i> 添加配套板块
            </button>
        </div>
    </div>

    <!-- 主体内容区域 -->
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card apple-card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        
                        <!-- 电脑端现代响应式表格 / 手机端自动适配 -->
                        <div class="table-responsive apple-table-responsive">
                            <table class="table apple-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 60px;">#</th>
                                        <th>名称</th>
                                        <th>排序</th>
                                        <th>状态</th>
                                        <th style="width: 180px;">记录时间</th>
                                        <th class="pe-4 text-end" style="width: 380px;">管理操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list["list"])): $k = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr class="apple-table-row">
                                        <td class="ps-4 fw-semibold text-secondary" data-label="序号"><?php echo ($k); ?></td>
                                        <td data-label="名称">
                                            <span class="fw-bold text-dark font-name"><?php echo ($v["name"]); ?></span>
                                        </td>
                                        <td data-label="排序">
                                            <span class="badge bg-light text-dark border px-2 py-1"><?php echo ($v["sorts"]); ?></span>
                                        </td>
                                        <td data-label="状态">
                                            <?php if($v['status'] > 0): ?><span class="badge apple-badge-success">正常使用</span>
                                            <?php else: ?>
                                                <span class="badge apple-badge-warning">暂停使用</span><?php endif; ?>
                                        </td>
                                        <td data-label="记录时间" class="text-muted" style="font-size: 13px;">
                                            <?php echo (date('Y/m/d H:i:s',$v["times"])); ?>
                                        </td>
                                        <td class="pe-4 text-end apple-action-td" data-label="管理操作">
                                            <div class="btn-group-action">
                                                <a href="<?php echo U('Goods/plate_banner','id='.$v['id']);?>" class="btn btn-apple-action btn-sm" title="广告管理">广告</a>
                                                <a href="<?php echo U('Goods/plate_infos','id='.$v['id']);?>" class="btn btn-apple-action btn-sm" title="商品管理">商品</a>
                                                <a ng-click="changeid('<?php echo ($v["id"]); ?>', 1)" class="btn btn-apple-action btn-sm" title="上调顺序">上移</a>
                                                <a ng-click="changeid('<?php echo ($v["id"]); ?>', 0)" class="btn btn-apple-action btn-sm" title="下调顺序">下移</a>
                                                <a ng-click="updateInfo('<?php echo ($v["id"]); ?>')" class="btn btn-apple-primary-subtle btn-sm" title="编辑">编辑</a>
                                                <a ng-click="dels('<?php echo ($v["id"]); ?>')" class="btn btn-apple-danger-subtle btn-sm" title="删除">删除</a>
                                            </div>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- 分页组件容器 -->
                        <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-between align-items-center flex-wrap">
                            <div class="text-muted mb-2 mb-sm-0" style="font-size: 13px;">
                                <span>展示当前所有配套板块数据明细</span>
                            </div>
                            <nav aria-label="Page navigation" class="apple-pagination-nav">
                                <ul class="pagination m-0"><?php echo ($list["show"]); ?></ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 添加弹窗 -->
    <div class="modal fade apple-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h4 class="modal-title fw-bold text-dark" id="myModalLabel" style="font-size: 18px;">添加配套板块</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <input type="hidden" name="types" value="2"/>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 13px;">板块名称</label>
                            <input type="text" name="name" class="form-control apple-input" placeholder="请输入板块名称，例如：高压电缆配套"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 13px;">显示排序</label>
                            <input type="number" name="sorts" class="form-control apple-input" value="0"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 13px;">板块状态</label>
                            <select name="status" class="form-select apple-input">
                                <option value="1">正常使用</option>
                                <option value="0">暂停使用</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light apple-btn-secondary px-4" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-apple-primary px-4" ng-click="addor()">确认添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 修改弹窗 -->
    <div class="modal fade apple-modal" id="myEdits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h4 class="modal-title fw-bold text-dark" id="myModalLabel" style="font-size: 18px;">修改配套板块</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form name="edit">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 13px;">板块名称</label>
                            <input type="text" name="name" class="form-control apple-input" ng-model="lininfo.name"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 13px;">显示排序</label>
                            <input type="text" name="sorts" class="form-control apple-input" ng-model="lininfo.sorts"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold" style="font-size: 13px;">板块状态</label>
                            <select name="status" class="form-select apple-input" ng-model="lininfo.status">
                                <option value="1">正常使用</option>
                                <option value="0">暂停使用</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light apple-btn-secondary px-4" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-apple-primary px-4" ng-click="updateOp()">保存更新</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 苹果极简商务风格样式与移动端自适应重构 -->
<style>
    /* 全局容器与背景铺满优化：实现超宽带鱼屏完美铺开、零左右留空、边缘微缝隙呼吸感 */
    .apple-admin-container {
        padding: 24px 32px;
        background-color: #f5f5f7;
        min-height: 100vh;
        font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Icons", "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: #1d1d1f;
        box-sizing: border-box;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* 卡片高级灰白质感与柔和阴影 */
    .apple-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    /* 表格现代排版与奇偶行底色区分 */
    .apple-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .apple-table th {
        background-color: #fafafc;
        color: #86868b;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 12px;
        border-bottom: 1px solid #e5e5ea;
    }

    .apple-table td {
        padding: 16px 12px;
        color: #1d1d1f;
        font-size: 14px;
        border-bottom: 1px solid #f2f2f7;
        vertical-align: middle;
    }

    /* 奇偶行交叉底色让分辨更清晰 */
    .apple-table tbody tr:nth-child(even) {
        background-color: #fbfbfd;
    }

    .apple-table tbody tr:hover {
        background-color: #f5f5f7;
        transition: background-color 0.2s ease;
    }

    /* 状态徽章设计 */
    .apple-badge-success {
        background-color: rgba(52, 199, 89, 0.12);
        color: #248a3d;
        font-weight: 500;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
    }

    .apple-badge-warning {
        background-color: rgba(255, 149, 0, 0.12);
        color: #b25000;
        font-weight: 500;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
    }

    /* 苹果级胶囊与微型圆角按钮 */
    .btn-apple-primary {
        background-color: #0071e3;
        color: #ffffff;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 400;
        font-size: 14px;
        border: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0, 113, 227, 0.2);
    }

    .btn-apple-primary:hover {
        background-color: #0077ed;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-apple-action {
        background-color: #f2f2f7;
        color: #1d1d1f;
        border: none;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
        margin-right: 4px;
        transition: all 0.2s ease;
    }

    .btn-apple-action:hover {
        background-color: #e5e5ea;
        color: #0071e3;
    }

    .btn-apple-primary-subtle {
        background-color: rgba(0, 113, 227, 0.1);
        color: #0071e3;
        border: none;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
        margin-right: 4px;
        transition: all 0.2s ease;
    }

    .btn-apple-primary-subtle:hover {
        background-color: #0071e3;
        color: #ffffff;
    }

    .btn-apple-danger-subtle {
        background-color: rgba(255, 59, 48, 0.1);
        color: #ff3b30;
        border: none;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-apple-danger-subtle:hover {
        background-color: #ff3b30;
        color: #ffffff;
    }

    /* 弹窗样式优化 */
    .apple-modal .modal-content {
        border-radius: 16px;
        background-color: #ffffff;
    }

    .apple-input {
        border-radius: 8px;
        border: 1px solid #d2d2d7;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .apple-input:focus {
        border-color: #0071e3;
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
    }

    .apple-btn-secondary {
        border-radius: 8px;
        background-color: #f2f2f7;
        border: none;
        color: #3a3a3c;
        font-weight: 500;
    }

    .apple-btn-secondary:hover {
        background-color: #e5e5ea;
    }

    /* ========================================================
       手机端防崩塌与卡片式折叠降级策略（核心实现）
       当屏幕宽度小于等于 768px 时自动生效，杜绝横向挤压滚动
       ======================================================== */
    @media screen and (max-width: 768px) {
        .apple-admin-container {
            padding: 12px !important;
        }

        .apple-table, .apple-table thead, .apple-table tbody, .apple-table tr, .apple-table th, .apple-table td {
            display: block;
            width: 100% !important;
        }

        .apple-table thead {
            display: none; /* 隐藏传统表头 */
        }

        .apple-table tbody tr {
            margin-bottom: 16px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            border: 1px solid #e5e5ea;
            padding: 12px 16px;
        }

        .apple-table tbody tr:nth-child(even) {
            background-color: #ffffff; /* 手机端每张卡片保持纯白干净背景 */
        }

        .apple-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
            padding: 10px 0;
            border-bottom: 1px solid #f2f2f7;
            font-size: 14px;
        }

        .apple-table td:last-child {
            border-bottom: none;
            padding-top: 14px;
        }

        /* 伪元素自动生成左侧字段说明，实现零丢失与完美视觉动线 */
        .apple-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #86868b;
            text-align: left;
            font-size: 13px;
        }

        /* 名称主字段首显加粗放大 */
        .apple-table td [data-label="名称"], .font-name {
            font-size: 16px !important;
            color: #0071e3;
        }

        /* 手机端操作按钮区容器全宽铺开、放大热区防止误触 */
        .apple-action-td {
            display: block !important;
            text-align: center !important;
        }

        .apple-action-td::before {
            display: none !important; /* 隐藏管理操作四个字的标签，让按钮直接通栏展示 */
        }

        .btn-group-action {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 6px;
        }

        .apple-action-td .btn {
            flex: 1;
            min-width: 70px;
            height: 40px; /* 严格符合大拇指触控热区规范，不低于40px-44px */
            line-height: 28px;
            font-size: 13px;
        }
    }
</style>

<script>
    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope,$http) {

        $scope.lininfo;

        ////////////////////////////////////////////////////////////////////////

        /**
         * 通讯操作
         * @param {type} url
         * @param {type} data
         * @returns {undefined}
         */
        $scope.commAjax = function (url, data, success) {
            $http({
                method: "POST",
                url: url,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                transformRequest: function (obj) {
                    var str = [];
                    for (var p in obj) {
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    }
                    return str.join("&");
                }
            }).success(function (response) {
                success(response);
            });
        };

        ////////////////////////////////////////////////////////////////////////

        $scope.addor = function () {
            var temp = $("form").serializeArray();
            var data = objToArray(temp);
            /////////
            $.ajaxFileUpload({
                url: "<?php echo U('Core/addon','model=plate_types');?>",
                secureuri: false,
                fileElementId: "file",
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status !== 1) {
                        return swal("错误", data.msg, "error");
                    }
                    window.location.reload();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        $scope.updateInfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=plate_types');?>", {ids: id}, function (res) {
                $scope.lininfo = res.data;
                $("#myEdits").modal("show");
            });
        }

        $scope.updateOp = function () {
            var param = $scope.lininfo;
            param.ids = param.id;
            /////
            $scope.commAjax("<?php echo U('Core/edits','model=plate_types');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }
        
        $scope.dels = function (ids) {
            var param = {id: ids};
            $scope.commAjax("<?php echo U('Core/dels','model=plate_types');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

        ////////////////////////////////////////////////////////////////////////

        $scope.changeid = function (id, type) {
            var param = {id: id, redi: type};
            $scope.commAjax("<?php echo U('Core/uptypes');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

    });
</script>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var currentUrl = window.location.href.toLowerCase();
                var currentPath = window.location.pathname.toLowerCase();
                
                $('.nav-capsule').removeClass('active');
                
                var matched = false;
                $('.nav-capsule').each(function() {
                    var hrefVal = $(this).attr('href');
                    if (hrefVal) {
                        var cleanHref = hrefVal.toLowerCase().replace(/['"()]/g, '');
                        var segments = cleanHref.split('/');
                        var lastSegment = segments[segments.length - 1]; 
                        var secondLast = segments.length > 1 ? segments[segments.length - 2] : ''; 
                        var compositeKey = secondLast && lastSegment ? (secondLast + '/' + lastSegment) : '';

                        if (compositeKey && (currentUrl.indexOf(compositeKey) !== -1 || currentPath.indexOf(compositeKey) !== -1)) {
                            $(this).addClass('active');
                            matched = true;
                            return false; 
                        }
                    }
                });

                if (!matched) {
                    var $capsules = $('.nav-capsule').toArray();
                    $capsules.sort(function(a, b) {
                        return $(b).attr('href').length - $(a).attr('href').length;
                    });

                    for (var i = 0; i < $capsules.length; i++) {
                        var $item = $($capsules[i]);
                        var hrefVal = $item.attr('href');
                        if (hrefVal) {
                            var cleanHref = hrefVal.toLowerCase().replace(/['"()]/g, '');
                            var segments = cleanHref.split('/');
                            var lastSegment = segments[segments.length - 1];
                            
                            if (lastSegment && lastSegment.length > 2) {
                                if (currentUrl.indexOf('/' + lastSegment) !== -1 || currentPath.indexOf('/' + lastSegment) !== -1 || currentUrl.endsWith(lastSegment)) {
                                    $item.addClass('active');
                                    matched = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </body>
</html>