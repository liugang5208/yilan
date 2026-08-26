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
                <!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>APP版本管理 - 易缆通商城后台</title>

    <!-- 苹果极简商务风与响应式全局样式 -->
    <style>
        :root {
            --apple-bg: #f5f5f7;
            --apple-card-bg: #ffffff;
            --apple-text-main: #1d1d1f;
            --apple-text-sub: #86868b;
            --apple-border: #d2d2d7;
            --apple-primary: #0071e3;
            --apple-primary-hover: #0077ed;
            --apple-danger: #ff3b30;
            --apple-radius: 12px;
            --apple-radius-sm: 8px;
            --apple-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
            --apple-transition: all 0.2s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Icons", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        body {
            background-color: var(--apple-bg);
            color: var(--apple-text-main);
            -webkit-font-smoothing: antialiased;
        }

        /* 电脑端超宽带鱼屏全屏无极铺开，边缘微缝，绝无横向滚动条 */
        .container-fluid {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 32px !important;
            margin: 0 !important;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -12px;
            margin-left: -12px;
        }

        .col-lg-8, .col-lg-4, .col-lg-12, .col-md-6 {
            position: relative;
            width: 100%;
            padding-right: 12px;
            padding-left: 12px;
        }

        @media (min-width: 992px) {
            .col-lg-8 { flex: 0 0 66.66667%; max-width: 66.66667%; }
            .col-lg-4 { flex: 0 0 33.33333%; max-width: 33.33333%; }
            .col-lg-12 { flex: 0 0 100%; max-width: 100%; }
        }

        @media (min-width: 768px) {
            .col-md-6 { flex: 0 0 50%; max-width: 50%; }
        }

        /* 顶部标题与面包屑 */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding-bottom: 16px;
        }

        .page-title h1 {
            font-size: 24px;
            font-weight: 600;
            color: var(--apple-text-main);
            letter-spacing: -0.5px;
        }

        /* 苹果高档半透明质感卡片 */
        .card {
            background-color: var(--apple-card-bg);
            border-radius: var(--apple-radius);
            box-shadow: var(--apple-shadow);
            border: 1px solid rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .card-header h4 {
            font-size: 17px;
            font-weight: 600;
            color: var(--apple-text-main);
        }

        .card-body {
            padding: 24px;
        }

        /* 按钮与交互规范 */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 8px 18px;
            font-size: 14px;
            border-radius: var(--apple-radius-sm);
            transition: var(--apple-transition);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-info {
            background-color: var(--apple-primary);
            color: #ffffff;
            border-color: var(--apple-primary);
        }

        .btn-info:hover {
            background-color: var(--apple-primary-hover);
        }

        .btn-default {
            background-color: #e5e5ea;
            color: var(--apple-text-main);
            border-color: #e5e5ea;
        }

        .btn-default:hover {
            background-color: #d1d1d6;
        }

        .btn-primary {
            background-color: var(--apple-primary);
            color: #ffffff;
            border-color: var(--apple-primary);
        }

        .btn-primary:hover {
            background-color: var(--apple-primary-hover);
        }

        .btn-xs {
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 6px;
        }

        /* 电脑端大表格样式 */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .table th, .table td {
            padding: 16px 18px;
            font-size: 14px;
            color: var(--apple-text-main);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            vertical-align: middle;
        }

        .table th {
            font-weight: 600;
            color: var(--apple-text-sub);
            background-color: rgba(0, 0, 0, 0.01);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* 奇偶行交叉底色，让辨识度更高 */
        .table tbody tr:nth-child(odd) {
            background-color: rgba(245, 245, 247, 0.5);
        }

        .table tbody tr:hover {
            background-color: rgba(0, 113, 227, 0.02);
        }

        /* 表单控件优化 */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 13px;
            color: var(--apple-text-sub);
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            line-height: 1.5;
            color: var(--apple-text-main);
            background-color: #ffffff;
            border: 1px solid var(--apple-border);
            border-radius: var(--apple-radius-sm);
            transition: var(--apple-transition);
        }

        .form-control:focus {
            border-color: var(--apple-primary);
            outline: 0;
            box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
        }

        /* 手机端独立卡片流式容器（默认隐藏，小屏幕下自动启用） */
        .mobile-card-list {
            display: none;
        }

        /* 弹窗毛玻璃与圆角升级 */
        .modal-dialog {
            width: 90% !important;
            max-width: 600px !important;
            margin: 30px auto !important;
        }

        .modal-content {
            border: none;
            border-radius: var(--apple-radius);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            background-color: #ffffff;
            overflow: hidden;
        }

        .modal-header {
            background-color: rgba(245, 245, 247, 0.8);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-weight: 600;
            font-size: 17px;
            color: var(--apple-text-main);
            margin: 0;
        }

        .modal-header .close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--apple-text-sub);
            cursor: pointer;
        }

        .modal-body {
            padding: 24px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-footer {
            background-color: rgba(245, 245, 247, 0.5);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            padding: 16px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        /* 分页器样式 */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 24px 0 0 0;
            gap: 6px;
            justify-content: flex-end;
        }

        .pagination li a, .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            font-size: 14px;
            border-radius: var(--apple-radius-sm);
            background-color: #ffffff;
            border: 1px solid var(--apple-border);
            color: var(--apple-text-main);
            text-decoration: none;
            transition: var(--apple-transition);
        }

        .pagination li.active span {
            background-color: var(--apple-primary);
            border-color: var(--apple-primary);
            color: #ffffff;
        }

        .pagination li a:hover {
            background-color: rgba(0, 113, 227, 0.05);
            border-color: var(--apple-primary);
            color: var(--apple-primary);
        }

        /* ==================== 手机端响应式卡片折叠与触控防误触 ==================== */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 12px 16px !important;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            /* 隐藏传统横向大表格，防止手机端挤压变形 */
            .table-responsive {
                display: none;
            }

            /* 启用手机端纵向独立卡片折叠布局 */
            .mobile-card-list {
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            .m-card-item {
                background: #ffffff;
                border-radius: var(--apple-radius);
                padding: 16px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
                border: 1px solid rgba(0, 0, 0, 0.04);
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .m-card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                padding-bottom: 10px;
            }

            .m-card-title {
                font-size: 16px;
                font-weight: 600;
                color: var(--apple-text-main);
            }

            .m-card-id {
                font-size: 12px;
                color: var(--apple-text-sub);
                background: rgba(0, 0, 0, 0.04);
                padding: 2px 8px;
                border-radius: 4px;
            }

            .m-card-body {
                display: flex;
                flex-direction: column;
                gap: 8px;
                font-size: 14px;
            }

            .m-card-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .m-card-label {
                color: var(--apple-text-sub);
                font-size: 13px;
            }

            .m-card-value {
                color: var(--apple-text-main);
                font-weight: 500;
                text-align: right;
                word-break: break-all;
            }

            .m-card-footer {
                display: flex;
                gap: 12px;
                padding-top: 10px;
                border-top: 1px solid rgba(0, 0, 0, 0.04);
            }

            .m-card-footer .btn {
                flex: 1;
                height: 44px;
                font-size: 14px;
                border-radius: var(--apple-radius-sm);
            }

            .modal-dialog {
                width: 95% !important;
                margin: 10px auto !important;
            }
        }
    </style>
</head>
<body ng-app="myApp" ng-controller="myCtrl">

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>APP版本管理</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <!--ol class="breadcrumb text-right">
                        <li><a href="#">Dashboard</a></li>
                        <li class="active">UI-Blank</li>
                    </ol-->
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->
    <section id="main-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="card alert">
                    <div class="card-header">
                        <h4>版本信息列表</h4>
                        <div class="card-header-right-icon">
                            <ul>
                                <li class="doc-link" style="list-style: none;">
                                    <a class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal">添加版本</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- 电脑端常规大表格 -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>类型</th>
                                        <th>版本号</th>
                                        <th>版本序列号</th>
                                        <th>下载链接</th>
                                        <th width="10%">管理</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                        <th scope="row"><?php echo ($v["id"]); ?></th>
                                        <td><strong><?php echo ($v['system_title']); ?></strong></td>
                                        <td><span style="color: var(--apple-primary); font-weight: 600;"><?php echo ($v['version']); ?></span></td>
                                        <td><code><?php echo ($v['version_sort']); ?></code></td>
                                        <td><a href="<?php echo ($v['url']); ?>" target="_blank" style="color: var(--apple-primary); text-decoration: none;"><?php echo ($v['url']); ?></a></td>
                                        <td>
                                            <a ng-click="updateinfo('<?php echo ($v["id"]); ?>')" class="btn btn-info btn-xs">编辑</a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>
                        </div>

                        <!-- 手机端独立卡片式折叠降级布局（确保信息零丢失，排版井然有序） -->
                        <div class="mobile-card-list">
                            <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="m-card-item">
                                    <div class="m-card-header">
                                        <span class="m-card-title">版本号: <?php echo ($v['version']); ?></span>
                                        <span class="m-card-id">ID: <?php echo ($v["id"]); ?></span>
                                    </div>
                                    <div class="m-card-body">
                                        <div class="m-card-row">
                                            <span class="m-card-label">系统类型</span>
                                            <span class="m-card-value"><strong><?php echo ($v['system_title']); ?></strong></span>
                                        </div>
                                        <div class="m-card-row">
                                            <span class="m-card-label">版本序列号</span>
                                            <span class="m-card-value"><code><?php echo ($v['version_sort']); ?></code></span>
                                        </div>
                                        <div class="m-card-row" style="flex-direction: column; align-items: flex-start; gap: 4px;">
                                            <span class="m-card-label">下载链接</span>
                                            <span class="m-card-value" style="text-align: left; word-break: break-all; color: var(--apple-primary);"><?php echo ($v['url']); ?></span>
                                        </div>
                                    </div>
                                    <div class="m-card-footer">
                                        <a class="btn btn-info" ng-click="updateinfo('<?php echo ($v["id"]); ?>')">编辑版本</a>
                                    </div>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>

                        <nav aria-label="Page navigation" style="text-align: right;">
                            <ul class="pagination"><?php echo ($list["show"]); ?></ul>
                        </nav>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">添加版本信息</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <form name="ador">
                        <div class="form-group">
                            <label>类型</label>
                            <select name="system" class="form-control">
                                <option value="1">安卓</option>
                                <option value="2">ios</option>
                            </select>
                        </div>
                         <div class="form-group">
                            <label>版本号</label>
                            <input type="text" name="version" class="form-control" placeholder="请输入版本号，例如 1.0.0"/>
                        </div>
                        
                        <div class="form-group">
                            <label>版本序列号 (最新序列号一定要比之前大)</label>
                            <input type="text" name="version_sort" class="form-control" placeholder="请输入数字序列号"/>
                        </div>
                         <div class="form-group">
                            <label>下载链接</label>
                            <input type="text" name="url" class="form-control" placeholder="请输入完整的下载链接地址"/>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addor()">添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">更新版本信息</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label>系统类型</label>
                            <select name="system" class="form-control" ng-model="infos.system">
                                <option value="1">安卓</option>
                                <option value="2">ios</option>
                            </select>
                        </div>
                       
                         <div class="form-group">
                            <label>版本号</label>
                            <input type="text" name="version" ng-model="infos.version" class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label>版本序列号 (最新序列号一定要比之前大)</label>
                            <input type="text" name="version_sort" ng-model="infos.version_sort" class="form-control"/>
                        </div>
                         <div class="form-group">
                            <label>下载链接</label>
                            <input type="text" name="url" ng-model="infos.url" class="form-control"/>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateCats()">更新</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    function objToArray(arr) {
        var obj = {};
        for (var i = 0; i < arr.length; i++) {
            obj[arr[i].name] = arr[i].value;
        }
        return obj;
    }

    /**
     * 添加
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form[name='ador']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=version');?>";
        //////
        $.ajax({
            url: baseurl,
            type: "post",
            data: data,
            dataType: "json",
            success: function (res) {
                if (res.status != 1) {
                    return swal('提示', res.msg, "error");
                }
                window.location.reload();
            },
            error: function () {

            },
        });
    }

    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

        $scope.infos;

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

        $scope.updateinfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=version');?>", {ids: id}, function (res) {
                $scope.infos = res.data;
                $("#myEdit").modal("show");
            });
        }

        $scope.updateCats = function () {
            var param = $scope.infos;
            param.ids = param.id;
            /////////
            $.ajax({
                url: "<?php echo U('Core/edits','model=version');?>",
                type: "post",
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
            $scope.commAjax("<?php echo U('Core/dels','model=version');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

    });

</script>

</body>
</html>
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