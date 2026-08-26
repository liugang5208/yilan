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
    <title>易缆通商城 · AI专家规则与业务模板管理中心</title>
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
        }

        .container-fluid { width: 100%; max-width: 1600px; margin: 0 auto; }
        .row { display: flex; flex-wrap: wrap; margin-right: -6px; margin-left: -6px; }
        .col-lg-12 { position: relative; width: 100%; padding-right: 6px; padding-left: 6px; margin-bottom: 12px; }

        /* 顶部导航与页头设计：支持超宽屏自适应与子页面快速切换 */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--apple-border); padding: 14px 18px; background: #fff; border-radius: var(--apple-radius); box-shadow: var(--apple-shadow); flex-wrap: wrap; gap: 10px; }
        .page-title h1 { font-size: 18px; font-weight: 600; color: var(--apple-text-main); letter-spacing: -0.5px; }
        .page-title p { font-size: 11px; color: var(--apple-text-sub); margin-top: 3px; }
        
        /* 子页面快速导航栏样式 */
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
        @media (min-width: 992px) {
            .equal-height-card { min-height: 580px; }
        }
        .card:hover { box-shadow: 0 8px 32px rgba(0, 0, 0, 0.07); }
        .card-header { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; border-bottom: 1px solid var(--apple-border); background-color: rgba(255, 255, 255, 0.95); }
        .card-header h4 { font-size: 12px; font-weight: 600; color: var(--apple-text-main); margin: 0; }
        .card-body { padding: 14px; }

        .btn { display: inline-flex; align-items: center; justify-content: center; font-weight: 500; text-align: center; border: 1px solid transparent; padding: 4px 12px; font-size: 11px; border-radius: var(--apple-radius-sm); transition: var(--apple-transition); cursor: pointer; text-decoration: none; height: 30px; }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background-color: var(--apple-primary); color: #fff; border-color: var(--apple-primary); }
        .btn-primary:hover { background-color: var(--apple-primary-hover); box-shadow: 0 2px 8px rgba(0, 113, 227, 0.3); }
        
        .btn-danger { background-color: #ff3b30; color: #fff; border-color: #ff3b30; padding: 2px 8px; font-size: 10px; height: 22px; display: inline-block; margin-left: 4px; vertical-align: middle; }
        .btn-danger:hover { background-color: #e03228; }
        .btn-info { background-color: #5856d6; color: #fff; border-color: #5856d6; padding: 2px 8px; font-size: 10px; height: 22px; display: inline-block; vertical-align: middle; }
        .btn-info:hover { background-color: #4c4abf; }

        .sub-split-row { display: flex; flex-wrap: wrap; margin-right: -6px; margin-left: -6px; }
        .sub-split-col { position: relative; width: 100%; padding-right: 6px; padding-left: 6px; margin-bottom: 10px; }
        @media (min-width: 992px) { .sub-split-col { flex: 0 0 50%; max-width: 50%; } }

        .capsule-upload-btn {
            display: inline-flex;
            align-items: center;
            background-color: #f2f2f7;
            border: 1px dashed var(--apple-border);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 500;
            color: var(--apple-primary);
            cursor: pointer;
            position: relative;
            transition: var(--apple-transition);
            text-decoration: none;
        }
        .capsule-upload-btn:hover { background-color: rgba(0, 113, 227, 0.08); border-color: var(--apple-primary); }
        .capsule-upload-btn input[type="file"] { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
        .capsule-upload-btn.success-theme { color: #2e7d32; }

        .table-responsive { 
            width: 100%; 
            height: 400px;
            max-height: 400px;
            min-height: 400px;
            overflow-y: auto; 
            margin-top: 6px; 
            border: 1px solid var(--apple-border);
            border-radius: var(--apple-radius-sm);
            background: #fafafc;
        }
        .apple-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 11px; }
        .apple-table th { 
            position: sticky; 
            top: 0; 
            z-index: 10; 
            background-color: #f2f2f7; 
            color: var(--apple-text-sub); 
            font-weight: 600; 
            padding: 9px 12px; 
            border-bottom: 1px solid var(--apple-border); 
        }
        .apple-table td { padding: 10px 12px; border-bottom: 1px solid var(--apple-border); color: var(--apple-text-main); vertical-align: middle; background-color: #ffffff; }
        .apple-table tr:hover td { background-color: rgba(0, 113, 227, 0.02); }

        .badge-protected { background: #e8f5e9; color: #2e7d32; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 99999; }
        .modal-card { background: #fff; width: 90%; max-width: 620px; border-radius: var(--apple-radius); box-shadow: 0 10px 40px rgba(0,0,0,0.2); overflow: hidden; }
        .modal-header { padding: 12px 16px; border-bottom: 1px solid var(--apple-border); display: flex; justify-content: space-between; align-items: center; }
        .modal-body { padding: 16px; max-height: 55vh; overflow-y: auto; font-size: 11px; line-height: 1.5; word-break: break-all; }
        .modal-footer { padding: 10px 16px; border-top: 1px solid var(--apple-border); text-align: right; background: #f9f9fb; }
    </style>
</head>
<body ng-app="knowledgeApp" ng-controller="knowledgeCtrl">

<div class="container-fluid">
    <!-- 顶部主标题与子页面独立路由导航解耦区 -->
    <div class="page-header">
        <div class="page-title">
            <h1>易缆通商城 · AI专家规则与业务模板管理中心</h1>
            <p>独立专家知识库母本与购销合同母版深度管理区（严格执行 365天全链条垃圾自动清理保护）。</p>
        </div>
        <div class="sub-nav-links">
            <a href="index.html" class="nav-chip">总控面板</a>
            <a href="knowledge.html" class="nav-chip active">专家规则</a>
            <a href="historyList.html" class="nav-chip">历史报价</a>
            <a href="searchWords.html" class="nav-chip">搜索母本</a>
            <a href="print_quote.html" class="nav-chip">合同打印</a>
        </div>
    </div>

    <!-- 独立提取的专家规则与业务模板挂载大卡片 -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card equal-height-card">
                <div class="card-header">
                    <h4>[ 专家知识库与业务合同母版独立挂载中心 ] <span class="badge-protected">365天免清理特权保护</span></h4>
                </div>
                <div class="card-body">
                    <div class="sub-split-row">
                        
                        <!-- 左半边：专家知识规则母本区 -->
                        <div class="sub-split-col">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <span style="font-size: 12px; font-weight: 600; color: var(--apple-primary);">📂 1. 专家规则区（技术白皮书与执行纪律）</span>
                                <div class="capsule-upload-btn">
                                    <span>+ 上传规范</span>
                                    <input type="file" file-model="knowledgeFile" id="knowFile" onchange="angular.element(this).scope().uploadDirectFile(this, 'knowledge')">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="apple-table">
                                    <thead>
                                        <tr>
                                            <th>规则名称 / 文件路径</th>
                                            <th style="text-align:right; width:95px;">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in knowledgeList">
                                            <td>
                                                <strong style="display:block; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{item.title}}">{{item.title}}</strong>
                                                <small style="color:var(--apple-primary);">{{item.file_path}}</small>
                                            </td>
                                            <td style="text-align:right; white-space:nowrap;">
                                                <button type="button" class="btn btn-info" ng-click="previewKnowledge(item)">查看</button>
                                                <button type="button" class="btn btn-danger" ng-click="deleteKnowledge(item.id)">移除</button>
                                            </td>
                                        </tr>
                                        <tr ng-if="knowledgeList.length === 0">
                                            <td colspan="2" style="text-align:center; color:var(--apple-text-sub); padding:40px;">暂无挂载规则文件，请点击右上角上传规范</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 右半边：业务购销合同与报价单模板母本区 -->
                        <div class="sub-split-col">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <span style="font-size: 12px; font-weight: 600; color: #2e7d32;">📄 2. 业务合同母版（标准购销合同与范本）</span>
                                <div class="capsule-upload-btn success-theme">
                                    <span>+ 上传模板</span>
                                    <input type="file" file-model="contractTemplateFile" id="contractFile" onchange="angular.element(this).scope().uploadDirectFile(this, 'contract')">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="apple-table">
                                    <thead>
                                        <tr>
                                            <th>模板名称 / 文件路径</th>
                                            <th style="text-align:right; width:95px;">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in templateList">
                                            <td>
                                                <strong style="display:block; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{item.title}}">{{item.title}}</strong>
                                                <small style="color:#34c759;">{{item.file_path}}</small>
                                            </td>
                                            <td style="text-align:right; white-space:nowrap;">
                                                <button type="button" class="btn btn-info" ng-click="previewKnowledge(item)">查看</button>
                                                <button type="button" class="btn btn-danger" ng-click="deleteKnowledge(item.id)">移除</button>
                                            </td>
                                        </tr>
                                        <tr ng-if="templateList.length === 0">
                                            <td colspan="2" style="text-align:center; color:var(--apple-text-sub); padding:40px;">暂无挂载业务模板，请点击右上角上传模板</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 弹窗预览 Modal -->
<div class="modal-overlay" ng-if="showModal" ng-cloak ng-click="closeModal()">
    <div class="modal-card" ng-click="$event.stopPropagation()">
        <div class="modal-header">
            <h4>{{modalTitle}}</h4>
            <button type="button" class="btn" style="background:transparent; border:none; font-size:16px; cursor:pointer;" ng-click="closeModal()">✕</button>
        </div>
        <div class="modal-body">
            <div ng-if="modalType === 'knowledge'">
                <p style="font-weight:600; margin-bottom:6px; color:var(--apple-primary);">已解析并挂载的内容详情：</p>
                <div style="background:#f5f5f7; padding:10px; border-radius:6px; white-space:pre-wrap; font-family:monospace; max-height:280px; overflow-y:auto;">{{modalData.content}}</div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" ng-click="closeModal()" style="height:26px;">关闭窗口</button>
        </div>
    </div>
</div>

<script>
var app = angular.module('knowledgeApp', []);

app.directive('fileModel', ['$parse', function ($parse) {
    return {
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            element.bind('change', function () {
                scope.$apply(function () { modelSetter(scope, element[0].files[0]); });
            });
        }
    };
}]);

app.controller('knowledgeCtrl', function($scope, $http, $sce) {
    $scope.knowledgeList = [];  
    $scope.templateList = [];   
    $scope.knowledgeFile = null;
    $scope.contractTemplateFile = null;

    $scope.showModal = false;
    $scope.modalTitle = '';
    $scope.modalType = '';
    $scope.modalData = {};

    // 数据加载接口保持与原系统完全一致
    $scope.loadData = function() {
        $http.get('<?php echo U("Ai/getKnowledgeList");?>?type=knowledge')
        .success(function(res) {
            if(res.code == 200) $scope.knowledgeList = res.data || [];
        });

        $http.get('<?php echo U("Ai/getKnowledgeList");?>?type=contract')
        .success(function(res) {
            if(res.code == 200) $scope.templateList = res.data || [];
        });
    };

    $scope.loadData();

    $scope.uploadDirectFile = function(element, fileType) {
        var file = element.files[0];
        if(!file) return;

        var fd = new FormData();
        fd.append('file', file);
        fd.append('type', fileType);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo U("Ai/saveKnowledge");?>', true);
        xhr.onload = function() {
            var res = JSON.parse(xhr.responseText);
            alert(res.msg);
            if(res.code == 200) {
                $scope.$apply(function() {
                    if(fileType === 'knowledge') {
                        $scope.knowledgeFile = null;
                        document.getElementById('knowFile').value = '';
                    } else {
                        $scope.contractTemplateFile = null;
                        document.getElementById('contractFile').value = '';
                    }
                    $scope.loadData();
                });
            }
        };
        xhr.send(fd);
    };

    $scope.deleteKnowledge = function(id) {
        if(!confirm("确定要彻底移除该核心母本及服务器源文件吗？")) return;
        $http.get('<?php echo U("Ai/deleteKnowledge");?>&id=' + id)
        .success(function(res) {
            alert(res.msg);
            if(res.code == 200) $scope.loadData();
        });
    };

    $scope.previewKnowledge = function(item) {
        $scope.modalTitle = '母本文件内容预览: ' + item.title;
        $scope.modalType = 'knowledge';
        $scope.modalData = item;
        $scope.showModal = true;
    };

    $scope.closeModal = function() {
        $scope.showModal = false;
        $scope.modalTitle = '';
        $scope.modalType = '';
        $scope.modalData = {};
    };

    $scope.trustUrl = function(url) {
        return $sce.trustAsResourceUrl(url);
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