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
                <style>
    /* ===== 苹果极简商务风：全局容器与排版样式 ===== */
    .apple-backend-container {
        background-color: #f5f5f7;
        padding: 24px 32px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: #1d1d1f;
        min-height: 100vh;
        width: 100%;
        box-sizing: border-box;
    }

    .apple-row {
        margin-bottom: 0;
        width: 100%;
    }

    /* ===== 苹果高档质感卡片 ===== */
    .apple-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.04);
        margin-bottom: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        width: 100%;
    }

    .apple-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #2c3e50;
        color: #fff;
        padding: 18px 24px;
        border-bottom: none;
    }

    .card-title-text {
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .apple-header-add-btn {
        font-size: 13px !important;
        padding: 7px 16px !important;
        height: auto !important;
        border-radius: 8px !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        background: rgba(255, 255, 255, 0.15) !important;
        color: #fff !important;
        transition: all 0.2s ease;
    }
    .apple-header-add-btn:hover {
        background: rgba(255, 255, 255, 0.3) !important;
    }

    .apple-card-body {
        padding: 24px;
    }

    /* ===== 表格样式优化（全屏铺开，四周留出舒适微缝） ===== */
    .apple-table-wrapper {
        border-radius: 12px;
        border: 1px solid #e5e5ea;
        overflow: hidden;
        background: #ffffff;
        width: 100%;
    }

    .apple-table {
        margin-bottom: 0 !important;
        background-color: #ffffff;
        width: 100%;
        table-layout: fixed; /* 固定列宽，结构清晰严谨 */
    }

    .apple-table th {
        background: #fafafc !important;
        color: #1d1d1f !important;
        font-weight: 600 !important;
        border-bottom: 1px solid #e5e5ea !important;
        padding: 16px 12px !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .apple-table td {
        padding: 14px 12px !important;
        vertical-align: middle !important;
        border-color: #f0f0f2 !important;
        color: #1d1d1f;
        word-break: break-all;
    }

    /* 奇偶行交叉底色，辨识度高 */
    .apple-table tbody tr:nth-of-type(odd) {
        background-color: #fbfbfd;
    }

    .apple-table tbody tr:hover {
        background-color: #f5f5f7;
    }

    .badge-number {
        font-weight: 600;
        color: #86868b;
        background: #f0f0f2;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 13px;
    }

    .text-bold-name {
        font-weight: 600;
        color: #1d1d1f;
        font-size: 14px;
    }

    .status-badge-normal {
        background: #eef6ed;
        color: #34c759;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
    }

    .status-badge-pause {
        background: #fdf2f2;
        color: #ff3b30;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
    }

    /* 广告图片展示框：拉长适配长条横幅 */
    .table-ads-img {
        height: 44px;
        max-width: 150px;
        width: 100%;
        border-radius: 6px;
        object-fit: contain;
        background: #f8f8fa;
        border: 1px solid #e5e5ea;
        cursor: pointer;
        transition: all 0.2s ease;
        display: block;
    }
    .table-ads-img:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-color: #0071e3;
    }

    /* ==========================================
       管理操作区：完美容纳所有功能按钮
       ========================================== */
    .table-action-group {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px; 
        width: 100%;
        padding: 0 4px;
        box-sizing: border-box;
        flex-wrap: nowrap;
    }

    .btn-action-base {
        border: none !important;
        border-radius: 6px !important;
        padding: 5px 6px !important;
        font-weight: 500 !important;
        color: #fff !important;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        transition: all 0.2s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-action-goods { background-color: #0071E3 !important; }
    .btn-action-up { background-color: #34C759 !important; }
    .btn-action-down { background-color: #FF9500 !important; }
    .btn-action-premium { background-color: #5856D6 !important; } /* 分类溢价专属功能按钮配色：苹果经典高级紫 */
    .btn-action-detail { background-color: #5AC8FA !important; } 
    .btn-action-edit { background-color: #8E8E93 !important; }
    .btn-action-del { background-color: #FF3B30 !important; }

    .btn-action-base:hover { opacity: 0.85; filter: brightness(1.05); }

    .apple-pagination-box {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
    }

    /* ===== 弹窗精细化控制 ===== */
    .apple-modal .modal-dialog {
        max-width: 480px;
        margin: 40px auto;
    }

    .apple-modal-image .modal-dialog {
        max-width: 650px;
        margin: 40px auto;
    }

    .apple-modal .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        background: #ffffff;
        overflow: hidden;
    }

    .apple-modal .modal-header {
        background: #fafafc;
        border-bottom: 1px solid #e5e5ea;
        padding: 16px 20px;
    }

    .apple-modal .modal-title {
        font-weight: 600;
        color: #1d1d1f;
        font-size: 16px;
    }

    .apple-modal .modal-body {
        padding: 24px 20px;
    }

    .apple-modal .form-group {
        margin-bottom: 16px;
    }

    .apple-modal .form-group label {
        font-weight: 600;
        color: #1d1d1f;
        font-size: 13px;
        margin-bottom: 6px;
        display: block;
    }

    .apple-input {
        border-radius: 8px !important;
        border: 1px solid #d2d2d7 !important;
        height: 40px !important;
        box-shadow: none !important;
        transition: all 0.2s;
    }
    .apple-input:focus {
        border-color: #0071e3 !important;
        box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.15) !important;
    }

    .apple-modal .modal-footer {
        background: #fafafc;
        border-top: 1px solid #e5e5ea;
        padding: 12px 20px;
        display: flex !important;
        align-items: center;
        justify-content: flex-end !important;
        gap: 10px;
    }

    .apple-btn-primary {
        background: #0071e3 !important;
        border: none !important;
        border-radius: 8px !important;
        padding: 8px 18px !important;
        font-weight: 500 !important;
        color: #fff !important;
        height: 38px;
    }
    .apple-btn-primary:hover { background: #0077ed !important; }

    .apple-btn-default {
        border-radius: 8px !important;
        border: 1px solid #d2d2d7 !important;
        background: #ffffff !important;
        color: #1d1d1f !important;
        padding: 8px 18px !important;
        height: 38px;
    }
    .apple-btn-default:hover {
        background: #f0f0f5 !important;
        border-color: #c7c7cc !important;
    }

    /* ==========================================
       移动端响应式降级：卡片式折叠布局
       ========================================== */
    @media (max-width: 768px) {
        .apple-backend-container {
            padding: 12px;
        }

        .apple-card-body {
            padding: 12px;
        }

        .apple-table, .apple-table thead, .apple-table tbody, .apple-table tr, .apple-table td {
            display: block;
            width: 100% !important;
        }

        .apple-table thead {
            display: none;
        }

        .apple-table tbody tr {
            background: #ffffff !important;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .apple-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0 !important;
            border: none !important;
            text-align: right;
        }

        .apple-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #86868b;
            text-align: left;
            font-size: 13px;
        }

        .table-ads-img {
            max-width: 180px;
            height: 40px;
        }

        .table-action-group {
            justify-content: flex-end;
            width: 100%;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #f0f0f2;
            padding-left: 0;
            padding-right: 0;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-action-base {
            padding: 6px 10px !important;
            height: 36px !important;
            flex: 1 1 30%;
            font-size: 12px;
        }

        .apple-modal .modal-dialog {
            width: 90% !important;
            margin: 20px auto !important;
        }
        
        .apple-modal-image .modal-dialog {
            width: 95% !important;
            margin: 20px auto !important;
        }
    }
</style>

<div class="container-fluid apple-backend-container" ng-app="myApp" ng-controller="myCtrl">
    <section id="main-content">
        <!-- 已按您的要求彻底删除多余的快捷导航栏 -->

        <div class="row apple-row">
            <div class="col-lg-12">
                <div class="apple-card">
                    <div class="card-header apple-card-header">
                        <span class="card-title-text">板块分类条管理</span>
                        <div class="card-header-right-icon">
                            <a class="btn btn-xs apple-header-add-btn" data-toggle="modal" data-target="#myModal">+ 添加板块分类条</a>
                        </div>
                    </div>
                    <div class="card-body apple-card-body">
                        <div class="table-responsive apple-table-wrapper">
                            <table class="table table-hover apple-table">
                                <!-- 列宽精密分配，确保行内操作区各按钮完美呈现 -->
                                <colgroup>
                                    <col style="width: 70px;">
                                    <col style="width: 15%;">
                                    <col style="width: 20%;">
                                    <col style="width: 70px;">
                                    <col style="width: 80px;">
                                    <col style="width: 150px;">
                                    <col style="width: 500px;">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>广告名称</th>
                                        <th>广告图片</th>
                                        <th>排序</th>
                                        <th>状态</th>
                                        <th>记录时间</th>
                                        <th style="text-align: center;">管理操作区</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                        <td data-label="序号">
                                            <span class="badge-number"><?php echo ($v["id"]); ?></span>
                                        </td>
                                        <td data-label="广告名称">
                                            <span class="text-bold-name"><?php echo ($v["name"]); ?></span>
                                        </td>
                                        <td data-label="广告图片">
                                            <!-- 点击图片触发高清预览弹窗 -->
                                            <img src="/Public/uploads/ads/<?php echo ($v["source"]); ?>" class="table-ads-img" ng-click="previewImage('/Public/uploads/ads/<?php echo ($v["source"]); ?>', '<?php echo ($v["name"]); ?>')" title="点击查看高清大图"/>
                                        </td>
                                        <td data-label="排序">
                                            <span class="badge-number"><?php echo ($v["sorts"]); ?></span>
                                        </td>
                                        <td data-label="状态">
                                            <?php if($v['status'] > 0): ?><span class="status-badge-normal">正常</span>
                                            <?php else: ?>
                                                <span class="status-badge-pause">暂停使用</span><?php endif; ?>
                                        </td>
                                        <td data-label="记录时间">
                                            <span style="color: #86868b; font-size: 13px;"><?php echo (date('Y/m/d H:i:s',$v["times"])); ?></span>
                                        </td>
                                        <td data-label="管理操作" style="text-align: center; padding: 14px 0;">
                                            <!-- 每一条独立内嵌：商品管理 -> 上调顺序 -> 下调顺序 -> 分类溢价 -> 商品详情 -> 修改名称 -> 删除 -->
                                            <div class="table-action-group">
                                                <a href="<?php echo U('Goods/plate_conts','id='.$v['id']);?>" class="btn btn-xs btn-action-base btn-action-goods">商品管理</a>
                                                <a ng-click="changeid('<?php echo ($v["id"]); ?>', 1)" class="btn btn-xs btn-action-base btn-action-up">上调顺序</a>
                                                <a ng-click="changeid('<?php echo ($v["id"]); ?>', 0)" class="btn btn-xs btn-action-base btn-action-down">下调顺序</a>
                                                <!-- 已按您的最新要求将字符改为“分类溢价” -->
                                                <a href="<?php echo U('Goods/premium_template','id='.$v['id']);?>" class="btn btn-xs btn-action-base btn-action-premium">分类溢价</a>
                                                <a href="<?php echo U('Goods/plate_conts_info','id='.$v['id'].'&tar=g_desc');?>" class="btn btn-xs btn-action-base btn-action-detail">商品详情</a>
                                                <a ng-click="updateInfo('<?php echo ($v["id"]); ?>')" class="btn btn-xs btn-action-base btn-action-edit">修改名称</a>
                                                <a ng-click="dels('<?php echo ($v["id"]); ?>')" class="btn btn-xs btn-action-base btn-action-del">删除</a>
                                            </div>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>

                            <div class="apple-pagination-box">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination"><?php echo ($list["show"]); ?></ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- Modal：添加板块分类条 -->
    <div class="modal fade apple-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加板块分类条</h4>
                </div>
                <div class="modal-body">

                    <form>
                        <input type="hidden" name="pid" value="<?php echo ($info["id"]); ?>"/>

                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control apple-input" placeholder="请输入分类条名称"/>
                        </div>
                        <div class="form-group">
                            <label>广告图片</label>
                            <input type="file" name="file" id="file" class="form-control apple-input" style="padding-top: 6px;"/>
                        </div>
                        <div class="form-group">
                            <label>排序</label>
                            <input type="number" name="sorts" class="form-control apple-input" value="0"/>
                        </div>
                        <div class="form-group">
                            <label>状态</label>
                            <select name="status" class="form-control apple-input">
                                <option value="1">使用</option>
                                <option value="0">暂停</option>
                            </select>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary apple-btn-primary" onclick="addor()">添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal：修改板块分类条 -->
    <div class="modal fade apple-modal" id="myEdits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改板块分类条</h4>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control apple-input" ng-model="lininfo.name"/>
                        </div>
                        <div class="form-group">
                            <label>广告图片</label>
                            <input type="file" name="file" id="filedit" class="form-control apple-input" style="padding-top: 6px;"/>
                            <p class="m-t-10" style="margin-top: 10px;">
                                <img ng-src="/Public/uploads/ads/{{lininfo.source}}" style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #e5e5ea; cursor: pointer;" ng-click="previewImage('/Public/uploads/ads/' + lininfo.source, lininfo.name)" title="点击查看高清大图"/>
                            </p>
                        </div>
                        <div class="form-group">
                            <label>排序</label>
                            <input type="text" name="sorts" class="form-control apple-input" ng-model="lininfo.sorts"/>
                        </div>
                        <div class="form-group">
                            <label>状态</label>
                            <select name="status" class="form-control apple-input" ng-model="lininfo.status">
                                <option value="1">使用</option>
                                <option value="0">暂停</option>
                            </select>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary apple-btn-primary" ng-click="updateOp()">更新</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal：点击图片放大预览弹窗 -->
    <div class="modal fade apple-modal apple-modal-image" id="myImageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="imageModalLabel">广告图片高清预览：{{previewImgTitle}}</h4>
                </div>
                <div class="modal-body" style="text-align: center; background: #fbfbfd; padding: 20px;">
                    <img ng-src="{{previewImgUrl}}" style="max-width: 100%; max-height: 70vh; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); object-fit: contain;" alt="高清预览图"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    function addor() {
        var temp = $("form").serializeArray();
        var data = objToArray(temp);
        /////////
        $.ajaxFileUpload({
            url: "<?php echo U('Core/addon','model=plate');?>",
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

    ////////////////////////////////////////////////////////////////////////////

    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

        $scope.lininfo;
        $scope.previewImgUrl = '';
        $scope.previewImgTitle = '';

        ////////////////////////////////////////////////////////////////////////

        /**
         * 点击图片弹出高清预览大图
         */
        $scope.previewImage = function (url, title) {
            $scope.previewImgUrl = url;
            $scope.previewImgTitle = title || '未命名广告';
            $("#myImageModal").modal("show");
        };

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

        $scope.updateInfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=plate');?>", {ids: id}, function (res) {
                $scope.lininfo = res.data;
                $("#myEdits").modal("show");
            });
        }

        $scope.updateOp = function () {
            var param = $scope.lininfo;
            param.ids = param.id;
            /////
            var temp = $("form").serializeArray();
            var data = objToArray(temp);
            /////////
            $.ajaxFileUpload({
                url: "<?php echo U('Core/edits','model=plate');?>",
                secureuri: false,
                fileElementId: "filedit",
                dataType: 'json',
                data: param,
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

        $scope.dels = function (ids) {
            var param = {id: ids};
            layer.load(2);
            $scope.commAjax("<?php echo U('Core/dels','model=plate');?>", param, function (res) {
                layer.closeAll('loading');
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

        $scope.changeid = function (id, type) {
            var param = {id: id, redi: type};
            $scope.commAjax("<?php echo U('Core/upplate');?>", param, function (res) {
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