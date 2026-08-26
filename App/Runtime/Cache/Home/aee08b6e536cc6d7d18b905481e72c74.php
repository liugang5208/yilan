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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>广告管理</title>
    <style>
        /* 苹果极简商务风全局与组件样式重构 */
        :root {
            --apple-bg: #f5f5f7;
            --apple-card-bg: #ffffff;
            --apple-text-main: #1d1d1f;
            --apple-text-secondary: #86868b;
            --apple-border: #d2d2d7;
            --apple-primary: #0071e3;
            --apple-primary-hover: #0077ed;
            --apple-danger: #ff3b30;
            --apple-radius-sm: 8px;
            --apple-radius-md: 12px;
            --apple-radius-lg: 16px;
            --apple-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
            --apple-shadow-hover: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--apple-bg);
            color: var(--apple-text-main);
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Icons", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .container-fluid {
            width: 100%;
            padding: 24px;
            margin: 0 auto;
        }

        /* 顶部标题栏重构：去除多余留空，将添加按钮融入标题栏右侧 */
        .apple-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            background: var(--apple-card-bg);
            padding: 20px 24px;
            border-radius: var(--apple-radius-md);
            box-shadow: var(--apple-shadow);
        }

        .apple-header-bar h1 {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
            color: var(--apple-text-main);
        }

        /* 卡片容器：全屏铺开、细腻阴影与大圆角 */
        .card.alert {
            background: var(--apple-card-bg);
            border: none;
            border-radius: var(--apple-radius-lg);
            box-shadow: var(--apple-shadow);
            margin-bottom: 0;
            transition: all 0.3s ease;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 20px 24px;
            font-size: 16px;
            font-weight: 600;
        }

        .card-body {
            padding: 24px;
        }

        /* 苹果风格按钮 */
        .btn-apple-primary {
            background-color: var(--apple-primary);
            color: #ffffff;
            border: none;
            border-radius: var(--apple-radius-sm);
            padding: 10px 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 113, 227, 0.3);
        }

        .btn-apple-primary:hover {
            background-color: var(--apple-primary-hover);
            color: #ffffff;
        }

        .btn-apple-danger {
            background-color: rgba(255, 59, 48, 0.1);
            color: var(--apple-danger);
            border: none;
            border-radius: var(--apple-radius-sm);
            padding: 6px 14px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s ease;
            min-height: 36px;
        }

        .btn-apple-danger:hover {
            background-color: var(--apple-danger);
            color: #ffffff;
        }

        /* 表格样式美化与奇偶行底色 */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: var(--apple-text-main);
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            border-bottom: 2px solid var(--apple-border);
            color: var(--apple-text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 12px 16px;
        }

        .table td {
            padding: 16px;
            vertical-align: middle;
            border-top: 1px solid rgba(0, 0, 0, 0.04);
            font-size: 14px;
        }

        .table tbody tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.015);
        }

        .table tbody tr:hover {
            background-color: rgba(0, 113, 227, 0.02);
        }

        /* 媒体预览缩略图（支持图片与视频图标提示） */
        .media-thumb-container {
            position: relative;
            width: 72px;
            height: 48px;
            border-radius: var(--apple-radius-sm);
            overflow: hidden;
            background: #000;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: inline-block;
        }

        .media-thumb-container img, .media-thumb-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .media-thumb-container:hover img, .media-thumb-container:hover video {
            transform: scale(1.05);
        }

        .media-badge {
            position: absolute;
            bottom: 2px;
            right: 2px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            font-size: 10px;
            padding: 1px 4px;
            border-radius: 4px;
        }

        /* 弹窗毛玻璃与圆角高档感 */
        .modal-content {
            border: none;
            border-radius: var(--apple-radius-lg);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .modal-header {
            background: #fafafa;
            border-bottom: 1px solid var(--apple-border);
            padding: 20px 24px;
        }

        .modal-title {
            font-weight: 600;
            font-size: 18px;
            color: var(--apple-text-main);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            background: #fafafa;
            border-top: 1px solid var(--apple-border);
            padding: 16px 24px;
        }

        .form-control {
            border-radius: var(--apple-radius-sm);
            border: 1px solid var(--apple-border);
            padding: 10px 14px;
            font-size: 14px;
            height: auto;
            box-shadow: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--apple-primary);
            box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.15);
        }

        /* 大图/大视频预览弹窗专属样式：尽量宽大展示实际内容 */
        #previewModal .modal-dialog {
            width: 80% !important;
            max-width: 1000px;
        }

        .preview-large-box {
            text-align: center;
            background: #000;
            border-radius: var(--apple-radius-md);
            overflow: hidden;
            max-height: 75vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-large-box img, .preview-large-box video {
            max-width: 100%;
            max-height: 75vh;
            object-fit: contain;
        }

        /* 手机端零溢出与卡片式折叠降级处理 (屏幕宽度小于 768px 时自动生效) */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 12px;
            }
            .apple-header-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 16px;
            }
            .apple-header-bar .btn-apple-primary {
                width: 100%;
                text-align: center;
                min-height: 44px; /* 符合移动端拇指点击高度 */
            }
            /* 隐藏传统表格头 */
            .table thead {
                display: none;
            }
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            /* 将每一行转为独立的高档卡片 */
            .table tr {
                background: var(--apple-card-bg) !important;
                margin-bottom: 16px;
                border-radius: var(--apple-radius-md);
                box-shadow: var(--apple-shadow);
                padding: 16px;
                border: 1px solid rgba(0,0,0,0.04);
            }
            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-top: none;
                border-bottom: 1px solid rgba(0,0,0,0.04);
                text-align: right;
            }
            .table td:last-child {
                border-bottom: none;
                padding-top: 14px;
            }
            /* 增加移动端字段标签显式引导 */
            .table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--apple-text-secondary);
                text-align: left;
                font-size: 13px;
            }
            .btn-apple-danger {
                width: 100%;
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            #previewModal .modal-dialog {
                width: 95% !important;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <!-- 顶部标题栏：去除多余留空，上传按钮直接内置在标题栏右侧 -->
    <div class="apple-header-bar">
        <h1>广告管理中心</h1>
        <button type="button" class="btn btn-apple-primary" data-toggle="modal" data-target="#myModal">
            + 添加广告内容
        </button>
    </div>

    <!-- 主内容卡片区域 -->
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card alert">
                    <div class="card-header">
                        <span>广告列表与实时状态</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th># 编号</th>
                                        <th style="text-align:center;">媒体预览 (支持图片/视频)</th>
                                        <th>运行状态</th>
                                        <th width="20%">记录时间</th>
                                        <th width="12%">管理操作</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                        <td scope="row" data-label="编号">#<?php echo ($v["id"]); ?></td>
                                        <td align="center" data-label="媒体预览">
                                            <!-- 点击图片或视频即可弹窗看大图/大视频，不写死类型 -->
                                            <div class="media-thumb-container" onclick="openLargePreview('/Public/uploads/ads/<?php echo ($v["imgurl"]); ?>')">
                                                <?php $ext = strtolower(pathinfo($v['imgurl'], PATHINFO_EXTENSION)); $isVideo = in_array($ext, ['mp4', 'webm', 'mov', 'ogg']); ?>
                                                <?php if($isVideo): ?><video src="/Public/uploads/ads/<?php echo ($v["imgurl"]); ?>" muted></video>
                                                    <span class="media-badge">视频</span>
                                                <?php else: ?>
                                                    <img src="/Public/uploads/ads/<?php echo ($v["imgurl"]); ?>" alt="广告媒体"/>
                                                    <span class="media-badge">图片</span><?php endif; ?>
                                            </div>
                                        </td>
                                        <td data-label="状态">
                                            <span style="font-weight: 500; color: <?php echo ($v['status']>0?'#34c759':'#ff9f0a'); ?>;">
                                                <?php echo ($v['status']>0?'● 正常运行':'● 暂停使用'); ?>
                                            </span>
                                        </td>
                                        <td data-label="记录时间"><?php echo (date('Y/m/d H:i:s',$v["times"])); ?></td>
                                        <td data-label="管理">
                                            <a href="javascript:dels('<?php echo ($v["id"]); ?>');" class="btn btn-apple-danger btn-xs">删除记录</a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>

                            <nav aria-label="Page navigation" style="margin-top: 20px;">
                                <ul class="pagination"><?php echo ($list["show"]); ?></ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- 添加广告弹窗 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加广告文件</h4>
            </div>
            <div class="modal-body">
                <form id="addAdForm">
                    <input type="hidden" name="types" value="1"/>
                    <input type="hidden" name="loc" value="1"/>
                    <input type="hidden" name="target_url" value="#"/>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="font-weight: 500; margin-bottom: 8px; display: block;">选择上传文件（支持图片或视频格式，不能写死）</label>
                        <!-- accept 属性放开图片与视频，不限制死 -->
                        <input type="file" name="file" id="file" class="form-control" accept="image/*,video/mp4,video/webm,video/ogg,video/quicktime"/>
                        <small style="color: var(--apple-text-secondary); margin-top: 6px; display: block;">提示：支持常见的图片及高清视频文件上传，请确保服务器已调大上传大小限制。</small>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px;">
                        <label style="font-weight: 500; margin-bottom: 8px; display: block;">运行状态</label>
                        <select name="status" class="form-control">
                            <option value="1">立即使用</option>
                            <option value="0">暂时停用</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">取消</button>
                <button type="button" class="btn btn-apple-primary" onclick="addor()">确认添加并上传</button>
            </div>
        </div>
    </div>
</div>

<!-- 大图/大视频弹窗预览组件：尽量宽大展示实际内容 -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="previewModalLabel">媒体大图与视频详细预览</h4>
            </div>
            <div class="modal-body">
                <div class="preview-large-box" id="previewContainer">
                    <!-- 动态嵌入大图或可播放的大视频 -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 8px 16px;">关闭预览</button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * 打开超大预览弹窗（自动识别图片或视频）
     */
    function openLargePreview(url) {
        var ext = url.split('.').pop().toLowerCase();
        var isVideo = ['mp4', 'webm', 'mov', 'ogg'].indexOf(ext) !== -1;
        var container = document.getElementById('previewContainer');
        
        if (isVideo) {
            container.innerHTML = '<video src="' + url + '" controls autoplay style="max-width:100%; max-height:75vh;"></video>';
        } else {
            container.innerHTML = '<img src="' + url + '" alt="高清大图预览" style="max-width:100%; max-height:75vh; object-fit:contain;">';
        }
        
        // 调用 Bootstrap 弹窗展示
        $('#previewModal').modal('show');
    }

    /**
     * 添加广告异步提交
     */
    function addor() {
        var temp = $("form#addAdForm").serializeArray();
        var data = objToArray(temp);
        
        $.ajaxFileUpload({
            url: "<?php echo U('Core/addon','model=sys_banner');?>",
            secureuri: false,
            fileElementId: "file",
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data.status !== 1) {
                    return swal("错误提示", data.msg, "error");
                }
                window.location.reload();
            },
            error: function (data) {
                console.log(data);
                swal("系统提示", "上传发生错误，请检查文件大小或网络连接", "error");
            }
        });
    }

    /**
     * 删除广告记录
     */
    function dels(id) {
        var data = {id: id};
        var baseurl = "<?php echo U('Core/dels','model=sys_banner');?>";
        
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
                swal('提示', '删除请求失败', "error");
            }
        });
    }
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