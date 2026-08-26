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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>客服配置管理</title>
    <style>
        /* 苹果极简商务风与全端自适应全局样式 */
        :root {
            --apple-bg: #f5f5f7;
            --apple-card-bg: #ffffff;
            --apple-text-main: #1d1d1f;
            --apple-text-sub: #86868b;
            --apple-border: #d2d2d7;
            --apple-primary: #0071e3;
            --apple-primary-hover: #0077ed;
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

        .col-lg-12 {
            position: relative;
            width: 100%;
            padding-right: 12px;
            padding-left: 12px;
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* 顶部标题栏 */
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

        /* 苹果高档质感卡片 */
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
            margin: 0;
        }

        .card-body {
            padding: 32px 24px;
        }

        /* 表单网格与布局优化 */
        .form-horizontal .form-group {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 24px;
            align-items: flex-start;
        }

        .control-label {
            text-align: right;
            padding-top: 10px;
            font-weight: 500;
            font-size: 14px;
            color: var(--apple-text-sub);
        }

        @media (min-width: 768px) {
            .control-label {
                flex: 0 0 16.66667%;
                max-width: 16.66667%;
                padding-right: 16px;
            }
            .form-field-wrapper {
                flex: 0 0 66.66667%;
                max-width: 66.66667%;
            }
            .form-actions-wrapper {
                margin-left: 16.66667%;
                flex: 0 0 66.66667%;
                max-width: 66.66667%;
            }
        }

        @media (max-width: 767px) {
            .control-label {
                text-align: left;
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 8px;
                padding-top: 0;
            }
            .form-field-wrapper {
                flex: 0 0 100%;
                max-width: 100%;
            }
            .form-actions-wrapper {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        /* 表单控件美化 */
        .form-control {
            display: block;
            width: 100%;
            padding: 12px 16px;
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

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* 图片预览与上传区 */
        .config-image-container {
            margin-top: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .config-preview-img {
            max-width: 120px;
            max-height: 120px;
            border-radius: var(--apple-radius-sm);
            border: 1px solid var(--apple-border);
            cursor: pointer;
            object-fit: cover;
            transition: var(--apple-transition);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .config-preview-img:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border-color: var(--apple-primary);
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
            padding: 12px 28px;
            font-size: 15px;
            border-radius: var(--apple-radius-sm);
            transition: var(--apple-transition);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--apple-primary);
            color: #ffffff;
            border-color: var(--apple-primary);
            width: 100%;
        }

        @media (min-width: 768px) {
            .btn-primary {
                width: auto;
                min-width: 160px;
            }
        }

        .btn-primary:hover {
            background-color: var(--apple-primary-hover);
        }

        /* 点击看大图全局模态框弹窗样式 */
        .image-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .image-modal-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            border-radius: var(--apple-radius);
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            animation: modalZoomIn 0.25s ease;
        }

        .image-modal-content img {
            display: block;
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
            margin: 0 auto;
        }

        .image-modal-close {
            position: absolute;
            top: 12px;
            right: 16px;
            background: rgba(0, 0, 0, 0.5);
            color: #ffffff;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--apple-transition);
        }

        .image-modal-close:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        @keyframes modalZoomIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        /* 手机端深度触控适配 */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 12px 16px !important;
            }
            .card-body {
                padding: 20px 16px;
            }
            .form-control {
                height: 44px;
                font-size: 16px; /* 防止 iOS 自动放大 */
            }
            textarea.form-control {
                height: auto;
            }
            .btn {
                height: 46px;
                width: 100%;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid" ng-app="myApp" ng-controller="myCtrl">

    <!-- 标题 -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="page-title">
                    <h1>客服配置管理</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- 主内容 -->
    <section id="main-content">

        <div class="row">
            <div class="col-lg-12">

                <div class="card alert">

                    <!-- 头部 -->
                    <div class="card-header">
                        <h4>配置项</h4>
                    </div>

                    <!-- 内容 -->
                    <div class="card-body">

                        <form class="form-horizontal">

                            <!-- 动态表单 -->
                            <div class="form-group" ng-repeat="item in configList">

                                <label class="control-label">
                                    {{item.title}}
                                </label>

                                <div class="form-field-wrapper">

                                    <!-- 输入框 -->
                                    <input 
                                        ng-if="item.type == 1"
                                        type="text"
                                        class="form-control"
                                        ng-model="formData[item.name]"
                                    />

                                    <!-- 图片地址与上传/弹窗看大图 -->
                                    <div ng-if="item.type == 2">
                                        <input 
                                            type="file"
                                            class="form-control"
                                            onchange="angular.element(this).scope().uploadFile(this, this.getAttribute('data-name'))"
                                            data-name="{{item.name}}"
                                            style="padding: 8px;"
                                        />
                                    
                                        <!-- 有值才显示图片，支持点击弹窗查看大图 -->
                                        <div class="config-image-container" ng-if="formData[item.name]">
                                            <img 
                                                ng-src="{{formData[item.name]}}" 
                                                class="config-preview-img"
                                                ng-click="showBigImage(formData[item.name])"
                                                title="点击查看大图"
                                            >
                                            <span style="font-size: 12px; color: var(--apple-text-sub);">点击图片可预览大图</span>
                                        </div>
                                    </div>

                                    <!-- 多行文本 -->
                                    <textarea 
                                        ng-if="item.type == 3"
                                        class="form-control"
                                        rows="3"
                                        ng-model="formData[item.name]"
                                    ></textarea>

                                </div>

                            </div>

                            <!-- 提交按钮 -->
                            <div class="form-group" style="margin-top: 32px; margin-bottom: 0;">
                                <div class="form-actions-wrapper">
                                    <button type="button" class="btn btn-primary" ng-click="saveConfig()">
                                        保存配置
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </section>

    <!-- 全局点击看大图模态框 -->
    <div class="image-modal-overlay" id="bigImageModal" ng-click="closeBigImage()">
        <div class="image-modal-content" ng-click="$event.stopPropagation()">
            <button class="image-modal-close" ng-click="closeBigImage()">&times;</button>
            <img ng-src="{{modalImageUrl}}" alt="大图预览">
        </div>
    </div>

</div>

<script>

var app = angular.module('myApp', []);

app.controller('myCtrl', function ($scope, $http) {

    $scope.configList = [];
    $scope.formData = {};
    $scope.modalImageUrl = '';

    /**
     * 打开大图弹窗
     */
    $scope.showBigImage = function(imgUrl) {
        if(!imgUrl) return;
        $scope.modalImageUrl = imgUrl;
        document.getElementById('bigImageModal').style.display = 'flex';
    };

    /**
     * 关闭大图弹窗
     */
    $scope.closeBigImage = function() {
        document.getElementById('bigImageModal').style.display = 'none';
        $scope.modalImageUrl = '';
    };

    /**
     * 通用POST
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
        }).then(function (res) {
            success(res.data);
        });
    };

    /**
     * 获取配置
     */
    $scope.getConfig = function () {
       
        $scope.commAjax("<?php echo U('config/customer_config_ajax');?>", {}, function (res) {
            if (res.status !== 1) {
                alert(res.msg);
                return;
            }

            $scope.configList = res.data;

            // 初始化数据
            angular.forEach(res.data, function (item) {
                $scope.formData[item.name] = item.value;
            });

        });
    };

    /**
     * 保存
     */
    $scope.saveConfig = function () {

        $.ajax({
            url: "<?php echo U('config/saveCustomerConfig');?>",
            type: "post",
            data: $scope.formData,
            dataType: "json",
            success: function (res) {
                if (res.status !== 1) {
                    return alert(res.msg);
                }
                alert("保存成功");
            },
            error: function () {
                alert("请求失败");
            }
        });

    };

    // 页面加载自动执行
    $scope.getConfig();
    
    $scope.uploadFile = function (obj, fieldName) {
        var file = obj.files[0];
        if (!file) return;

        var formData = new FormData();
        formData.append("file", file);

        $.ajax({
            url: "<?php echo U('config/upload');?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (res) {
                if (res.status != 1) {
                    alert(res.msg);
                    return;
                }

                $scope.$apply(function () {
                    $scope.formData[fieldName] = res.data.path_url;
                });
            }
        });
    };

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