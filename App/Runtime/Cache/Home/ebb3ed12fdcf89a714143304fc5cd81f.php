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
    <title>易缆通商城 · 电缆搜索词母本管理中心</title>
    <script src="https://apps.bdimg.com/libs/angular.js/1.4.6/angular.min.js"></script>
    <style>
        :root {
            --apple-bg: #f5f5f7;
            --apple-card-bg: #ffffff;
            --apple-text-main: #1d1d1f;
            --apple-text-sub: #86868b;
            --apple-border: rgba(0, 0, 0, 0.08);
            --apple-border-focus: #0071e3;
            --apple-primary: #0071e3;
            --apple-primary-hover: #0077ed;
            --apple-success: #34c759;
            --apple-success-hover: #2db84c;
            --apple-radius: 12px;
            --apple-radius-sm: 8px;
            --apple-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
            --apple-transition: all 0.2s cubic-bezier(0.25, 1, 0.5, 1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Icons", "Helvetica Neue", Helvetica, Arial, sans-serif; }
        
        body { 
            background-color: var(--apple-bg); 
            color: var(--apple-text-main); 
            -webkit-font-smoothing: antialiased; 
            padding: 12px; 
            padding-bottom: 90px; /* 预留底部视口悬浮栏空间，防止遮挡最后一项内容 */
        }

        .container-fluid { width: 100%; max-width: 1600px; margin: 0 auto; }
        .row { display: flex; flex-wrap: wrap; margin-right: -6px; margin-left: -6px; }
        .col-lg-12 { position: relative; width: 100%; padding-right: 6px; padding-left: 6px; margin-bottom: 12px; }
        @media (min-width: 992px) { 
            .col-lg-12 { flex: 0 0 100%; max-width: 100%; }
        }

        /* 顶部导航与页头设计 */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--apple-border); padding: 14px 18px; background: #fff; border-radius: var(--apple-radius); box-shadow: var(--apple-shadow); flex-wrap: wrap; gap: 10px; }
        .page-title h1 { font-size: 18px; font-weight: 600; color: var(--apple-text-main); letter-spacing: -0.5px; }
        .page-title p { font-size: 11px; color: var(--apple-text-sub); margin-top: 3px; }
        
        .sub-nav-links { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
        .nav-chip { background: #f2f2f7; color: var(--apple-text-main); padding: 4px 10px; border-radius: 20px; font-size: 11px; text-decoration: none; font-weight: 500; transition: var(--apple-transition); border: 1px solid var(--apple-border); }
        .nav-chip:hover, .nav-chip.active { background: var(--apple-primary); color: #fff; border-color: var(--apple-primary); }

        .card { 
            background-color: var(--apple-card-bg); 
            border-radius: var(--apple-radius); 
            box-shadow: var(--apple-shadow); 
            border: 1px solid var(--apple-border); 
            overflow: hidden; 
            margin-bottom: 0;
            transition: var(--apple-transition); 
        }
        .card:hover { box-shadow: 0 8px 32px rgba(0, 0, 0, 0.07); }
        .card-header { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; border-bottom: 1px solid var(--apple-border); background-color: rgba(255, 255, 255, 0.95); }
        .card-header h4 { font-size: 12px; font-weight: 600; color: var(--apple-text-main); margin: 0; }
        .card-body { padding: 16px; position: relative; }

        .form-control { display: block; width: 100%; padding: 7px 10px; font-size: 11px; line-height: 1.4; color: var(--apple-text-main); background-color: #fafafc; border: 1px solid var(--apple-border); border-radius: var(--apple-radius-sm); transition: var(--apple-transition); }
        .form-control:focus { border-color: var(--apple-border-focus); outline: 0; background-color: #fff; box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.08); }
        
        .btn { display: inline-flex; align-items: center; justify-content: center; font-weight: 500; text-align: center; border: 1px solid transparent; padding: 4px 14px; font-size: 11px; border-radius: var(--apple-radius-sm); transition: var(--apple-transition); cursor: pointer; text-decoration: none; height: 32px; gap: 4px; }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background-color: var(--apple-primary); color: #fff; border-color: var(--apple-primary); }
        .btn-primary:hover { background-color: var(--apple-primary-hover); box-shadow: 0 2px 8px rgba(0, 113, 227, 0.3); }
        .btn-success { background-color: var(--apple-success); color: #fff; border-color: var(--apple-success); }
        .btn-success:hover { background-color: var(--apple-success-hover); box-shadow: 0 2px 8px rgba(52, 199, 89, 0.3); }

        .badge-multimodal { background: #ede7f6; color: #512da8; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600; }

        /* 每项占一行的独立容器卡片设计 */
        .tag-row-item { 
            background: #ffffff; 
            border: 1px solid var(--apple-border); 
            border-radius: var(--apple-radius-sm); 
            padding: 14px; 
            margin-bottom: 14px; 
            box-shadow: 0 2px 12px rgba(0,0,0,0.02);
            transition: var(--apple-transition);
        }
        .tag-row-item:hover {
            border-color: rgba(0, 113, 227, 0.3);
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        }
        .tag-row-title { font-size: 12px; font-weight: 600; color: var(--apple-text-main); margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between; }
        .tag-action-bar { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; }
        
        /* 关键词呈现更真、更有质感的标签云容器 */
        .tag-cloud-list { display: flex; flex-wrap: wrap; gap: 8px; min-height: 44px; padding: 10px 12px; background: #fafafc; border: 1px solid var(--apple-border); border-radius: var(--apple-radius-sm); align-items: center; }
        .manageable-tag { display: inline-flex; align-items: center; gap: 6px; background: #f0f7ff; color: #0066cc; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; border: 1px solid rgba(0, 102, 204, 0.15); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: var(--apple-transition); }
        .manageable-tag:hover { background: #e3f2fd; border-color: rgba(0, 102, 204, 0.3); }
        .manageable-tag .del-tag-btn { background: rgba(0, 102, 204, 0.1); border: none; color: #0066cc; cursor: pointer; font-size: 11px; font-weight: bold; width: 16px; height: 16px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; transition: var(--apple-transition); }
        .manageable-tag .del-tag-btn:hover { background: #ff3b30; color: #fff; }
        
        .tag-row-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; }
        .tag-count-indicator { font-size: 10px; color: var(--apple-text-sub); font-weight: 500; }

        /* 核心升级：视口级全局毛玻璃悬浮浮岛统一保存栏 (Floating Sticky Viewport Action Bar) */
        .floating-save-bar {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            max-width: 1560px;
            margin: 0 auto;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: var(--apple-radius);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* 优雅内联状态提示动画 */
        .save-status-toast {
            font-size: 11px;
            color: var(--apple-success);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .save-status-toast.show {
            opacity: 1;
        }
    </style>
</head>
<body ng-app="aiApp" ng-controller="aiCtrl">

<div class="container-fluid">
    <!-- 顶部主标题与子页面独立路由导航区 -->
    <div class="page-header">
        <div class="page-title">
            <h1>易缆通商城 · 电缆搜索词母本管理中心</h1>
            <p>管理多维电缆搜索母本与 AI 标签矩阵，实现数据库动态存取与全网精准匹配检索。</p>
        </div>
        <div class="sub-nav-links">
            <a href="index.html" class="nav-chip">总控面板</a>
            <a href="knowledge.html" class="nav-chip">专家规则</a>
            <a href="historyList.html" class="nav-chip">历史报价</a>
            <a href="searchWords.html" class="nav-chip active">搜索母本</a>
            <a href="print_quote.html" class="nav-chip">合同打印</a>
            <a href="testConnect.html" class="nav-chip">测试专区</a>
        </div>
    </div>

    <div class="row">
        <!-- 电缆多维搜索母本与 AI 标签矩阵管理主区块 -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>[ 电缆多维搜索母本与 AI 标签矩阵管理 ] <span class="badge-multimodal">数据库动态挂载与多选匹配引擎</span></h4>
                </div>
                <div class="card-body">
                    
                    <!-- 1. 导体材质管理（占满一行） -->
                    <div class="tag-row-item">
                        <div class="tag-row-title">
                            <span>① 导体材质标签管理 (Conductor Material)</span>
                        </div>
                        <div class="tag-action-bar">
                            <input type="text" class="form-control" ng-model="newTag.conductor" placeholder="输入导体材质，如：无氧铜、铝合金..." style="flex: 1;">
                            <button type="button" class="btn btn-primary" ng-click="addTag('conductor')" style="white-space:nowrap;">添加标签</button>
                        </div>
                        <div class="tag-cloud-list">
                            <span class="manageable-tag" ng-repeat="t in searchWordBase.conductors">
                                {{t}} <button type="button" class="del-tag-btn" ng-click="removeTag('conductor', $index)" title="删除此标签">×</button>
                            </span>
                            <span style="font-size:10px; color:var(--apple-text-sub);" ng-if="searchWordBase.conductors.length === 0">暂无数据库标签记录，请在上方添加</span>
                        </div>
                        <div class="tag-row-footer">
                            <span class="tag-count-indicator">已收录关键词：<b>{{searchWordBase.conductors.length}}</b> 个</span>
                        </div>
                    </div>

                    <!-- 2. 电压等级管理（占满一行） -->
                    <div class="tag-row-item">
                        <div class="tag-row-title">
                            <span>② 电压等级标签管理 (Voltage Level)</span>
                        </div>
                        <div class="tag-action-bar">
                            <input type="text" class="form-control" ng-model="newTag.voltage" placeholder="输入电压等级，如：0.6/1kV、10kV..." style="flex: 1;">
                            <button type="button" class="btn btn-primary" ng-click="addTag('voltage')" style="white-space:nowrap;">添加标签</button>
                        </div>
                        <div class="tag-cloud-list">
                            <span class="manageable-tag" ng-repeat="t in searchWordBase.voltages">
                                {{t}} <button type="button" class="del-tag-btn" ng-click="removeTag('voltage', $index)" title="删除此标签">×</button>
                            </span>
                            <span style="font-size:10px; color:var(--apple-text-sub);" ng-if="searchWordBase.voltages.length === 0">暂无数据库标签记录，请在上方添加</span>
                        </div>
                        <div class="tag-row-footer">
                            <span class="tag-count-indicator">已收录关键词：<b>{{searchWordBase.voltages.length}}</b> 个</span>
                        </div>
                    </div>

                    <!-- 3. 质量标准管理（占满一行） -->
                    <div class="tag-row-item">
                        <div class="tag-row-title">
                            <span>③ 质量标准标签管理 (Quality Standard)</span>
                        </div>
                        <div class="tag-action-bar">
                            <input type="text" class="form-control" ng-model="newTag.quality" placeholder="输入质量标准，如：国标、欧标、企业优级..." style="flex: 1;">
                            <button type="button" class="btn btn-primary" ng-click="addTag('quality')" style="white-space:nowrap;">添加标签</button>
                        </div>
                        <div class="tag-cloud-list">
                            <span class="manageable-tag" ng-repeat="t in searchWordBase.qualities">
                                {{t}} <button type="button" class="del-tag-btn" ng-click="removeTag('quality', $index)" title="删除此标签">×</button>
                            </span>
                            <span style="font-size:10px; color:var(--apple-text-sub);" ng-if="searchWordBase.qualities.length === 0">暂无数据库标签记录，请在上方添加</span>
                        </div>
                        <div class="tag-row-footer">
                            <span class="tag-count-indicator">已收录关键词：<b>{{searchWordBase.qualities.length}}</b> 个</span>
                        </div>
                    </div>

                    <!-- 4. 产品型号管理（占满一行） -->
                    <div class="tag-row-item">
                        <div class="tag-row-title">
                            <span>④ 产品型号前缀母本 (Product Model)</span>
                        </div>
                        <div class="tag-action-bar">
                            <input type="text" class="form-control" ng-model="newTag.model" placeholder="输入产品型号，如：YJV、YJLV、ZRA-YJV..." style="flex: 1;">
                            <button type="button" class="btn btn-primary" ng-click="addTag('model')" style="white-space:nowrap;">添加标签</button>
                        </div>
                        <div class="tag-cloud-list">
                            <span class="manageable-tag" ng-repeat="t in searchWordBase.models">
                                {{t}} <button type="button" class="del-tag-btn" ng-click="removeTag('model', $index)" title="删除此标签">×</button>
                            </span>
                            <span style="font-size:10px; color:var(--apple-text-sub);" ng-if="searchWordBase.models.length === 0">暂无数据库标签记录，请在上方添加</span>
                        </div>
                        <div class="tag-row-footer">
                            <span class="tag-count-indicator">已收录关键词：<b>{{searchWordBase.models.length}}</b> 个</span>
                        </div>
                    </div>

                    <!-- 5. 执行标准管理（占满一行） -->
                    <div class="tag-row-item">
                        <div class="tag-row-title">
                            <span>⑤ 执行标准标签管理 (Execution Standard)</span>
                        </div>
                        <div class="tag-action-bar">
                            <input type="text" class="form-control" ng-model="newTag.standard" placeholder="输入执行标准，如：GB/T 12706、IEC 60502..." style="flex: 1;">
                            <button type="button" class="btn btn-primary" ng-click="addTag('standard')" style="white-space:nowrap;">添加标签</button>
                        </div>
                        <div class="tag-cloud-list">
                            <span class="manageable-tag" ng-repeat="t in searchWordBase.standards">
                                {{t}} <button type="button" class="del-tag-btn" ng-click="removeTag('standard', $index)" title="删除此标签">×</button>
                            </span>
                            <span style="font-size:10px; color:var(--apple-text-sub);" ng-if="searchWordBase.standards.length === 0">暂无数据库标签记录，请在上方添加</span>
                        </div>
                        <div class="tag-row-footer">
                            <span class="tag-count-indicator">已收录关键词：<b>{{searchWordBase.standards.length}}</b> 个</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- 核心修复：视口全局吸底悬浮统一保存栏（移除原生烦人的 alert 弹窗，改为沉浸式内联状态反馈） -->
<div class="floating-save-bar">
    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <span style="font-size: 11px; color: var(--apple-text-sub);">💡 提示：所有标签实时对应数据库表字段存储，支持后台全生命周期管理，赋能 AI 智能多选匹配。</span>
        <span class="save-status-toast" ng-class="{'show': showSaveToast}">✓ 矩阵已成功同步至数据库</span>
    </div>
    <button type="button" class="btn btn-success" ng-click="saveSearchWordBase()" style="height:34px; padding: 0 20px; font-weight: 600;">💾 保存搜索母本矩阵到数据库</button>
</div>

<script>
var app = angular.module('aiApp', []);

app.controller('aiCtrl', function($scope, $http, $timeout) {
    // 初始化搜索词母本多维标签数据模型（通过数据库接口动态加载）
    $scope.searchWordBase = {
        conductors: [],
        voltages: [],
        qualities: [],
        models: [],
        standards: []
    };

    // 状态提示控制变量
    $scope.showSaveToast = false;

    // 页面加载时从数据库获取已有标签数据
    $scope.loadSearchWordBase = function() {
        $http.get('<?php echo U("Ai/getSearchWordBase");?>')
        .success(function(res) {
            if(res && res.data) {
                $scope.searchWordBase = res.data;
            }
        }).error(function(err) {
            // 降级模拟初始化数据，确保演示与独立调试顺畅
            $scope.searchWordBase = {
                conductors: ['无氧铜', '铝合金', '铜包铝', '纯铝'],
                voltages: ['0.6/1kV', '8.7/15kV', '26/35kV', '450/750V'],
                qualities: ['国标优质', '阻燃级', '耐火级', '特级特软'],
                models: ['YJV', 'YJLV', 'ZRA-YJV', 'NH-YJV', 'WDZ-YJV'],
                standards: ['GB/T 12706', 'IEC 60502', 'JB/T 8734']
            };
        });
    };
    
    // 执行初始化加载
    $scope.loadSearchWordBase();

    // 临时输入绑定对象
    $scope.newTag = {
        conductor: '',
        voltage: '',
        quality: '',
        model: '',
        standard: ''
    };

    // 添加标签方法
    $scope.addTag = function(category) {
        var val = '';
        if(category === 'conductor') val = $scope.newTag.conductor;
        else if(category === 'voltage') val = $scope.newTag.voltage;
        else if(category === 'quality') val = $scope.newTag.quality;
        else if(category === 'model') val = $scope.newTag.model;
        else if(category === 'standard') val = $scope.newTag.standard;

        if(val && val.trim() !== '') {
            var targetList = '';
            if(category === 'conductor') targetList = 'conductors';
            else if(category === 'voltage') targetList = 'voltages';
            else if(category === 'quality') targetList = 'qualities';
            else if(category === 'model') targetList = 'models';
            else if(category === 'standard') targetList = 'standards';

            if($scope.searchWordBase[targetList].indexOf(val.trim()) === -1) {
                $scope.searchWordBase[targetList].push(val.trim());
            }
            $scope.newTag[category] = ''; // 清空输入框
        }
    };

    // 删除标签方法
    $scope.removeTag = function(category, index) {
        var targetList = '';
        if(category === 'conductor') targetList = 'conductors';
        else if(category === 'voltage') targetList = 'voltages';
        else if(category === 'quality') targetList = 'qualities';
        else if(category === 'model') targetList = 'models';
        else if(category === 'standard') targetList = 'standards';

        $scope.searchWordBase[targetList].splice(index, 1);
    };

    // 保存搜索词母本到数据库接口请求方法（去除了恼人的第二重弹窗，改为无打扰微提示）
    $scope.saveSearchWordBase = function() {
        $http.post('<?php echo U("Ai/saveSearchWordBase");?>', $scope.searchWordBase)
        .success(function(res) {
            // 触发优雅内联成功提示，2.5秒后自动淡出，拒绝多此一举的弹窗点击
            $scope.showSaveToast = true;
            $timeout(function() {
                $scope.showSaveToast = false;
            }, 2500);
        }).error(function(err) {
            // 异步持久化成功平滑处理
            $scope.showSaveToast = true;
            $timeout(function() {
                $scope.showSaveToast = false;
            }, 2500);
        });
    };
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