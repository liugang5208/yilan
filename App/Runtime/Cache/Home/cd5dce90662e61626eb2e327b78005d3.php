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
                <div class="container-fluid" style="max-width: 100%; margin: 0 auto; padding-top: 10px; padding-left: 0; padding-right: 0;" ng-app="myApp" ng-controller="myCtrl">
    
    <!-- 主内容卡片区域：左右彻底铺开，边缘零多余留白 -->
    <section id="main-content">
        <div class="row" style="margin: 0;">
            <div class="col-lg-12" style="padding: 0;">
                <div class="card alert" style="background: #ffffff; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.04); box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04); padding: 20px; margin-bottom: 20px;">
                    
                    <!-- 卡片头部：页面大标题与添加按钮 -->
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid #f3f4f6; padding: 0 0 15px 0; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <h4 style="font-size: 16px; font-weight: 600; color: #111827; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="ti-medall" style="color: #0066cc;"></i> 用户等级管理
                        </h4>
                        <div class="card-header-right-icon">
                            <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" style="background-color: #0066cc; border-color: #0066cc; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 500; color: #ffffff; display: flex; align-items: center; gap: 6px; text-decoration: none; cursor: pointer;">
                                <i class="ti-plus"></i> 添加用户等级
                            </a>
                        </div>
                    </div>

                    <!-- 数据展示主体区域 -->
                    <div class="card-body" style="padding: 0;">
                        
                        <!-- 电脑端标准超宽表格视图 -->
                        <div class="table-responsive desktop-table-view" style="border: none; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table class="table desktop-search-table" style="width: 100%; min-width: 1450px; margin-bottom: 15px; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                                        <th style="padding: 12px 12px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase; white-space: nowrap;">序号</th>
                                        <th style="padding: 12px 12px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase; white-space: nowrap;">等级名称</th>
                                        <th style="padding: 12px 12px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase; white-space: nowrap;">客服电话</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准1</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准2</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准3</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准4</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准5</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准6</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准7</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准8</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准9</th>
                                        <th style="padding: 12px 10px; font-weight: 600; color: #4b5563; font-size: 12px; text-align: center; white-space: nowrap;">标准10</th>
                                        <th style="padding: 12px 12px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase; white-space: nowrap;">运费标识</th>
                                        <th style="padding: 12px 12px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase; white-space: nowrap;">通调比例</th>
                                        <th width="18%" style="padding: 12px 12px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase; white-space: nowrap;">操作管理</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr style="border-bottom: 1px solid #f3f4f6; transition: background-color 0.15s ease;">
                                        <th scope="row" style="padding: 14px 12px; font-weight: 500; color: #6b7280; vertical-align: middle;"><?php echo ($v["id"]); ?></th>
                                        <td style="padding: 14px 12px; font-weight: 600; color: #0066cc; vertical-align: middle; white-space: nowrap;"><?php echo ($v["level"]); ?></td>
                                        <!-- 新增客服电话展示列 -->
                                        <td style="padding: 14px 12px; color: #374151; vertical-align: middle; white-space: nowrap; font-weight: 500;"><?php echo ($v["tel"]); ?></td>
                                        
                                        <!-- 标准1至标准10 状态单元格 -->
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_a']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_a']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_a']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_b']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_b']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_b']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_c']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_c']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_c']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_d']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_d']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_d']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_e']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_e']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_e']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_f']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_f']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_f']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_g']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_g']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_g']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_h']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_h']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_h']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_i']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_i']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_i']>0?'展示':'隐藏'); ?></span></td>
                                        <td style="padding: 14px 10px; text-align: center; vertical-align: middle;"><span style="background: <?php echo ($v['type_j']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_j']>0?'#15803d':'#64748b'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;"><?php echo ($v['type_j']>0?'展示':'隐藏'); ?></span></td>

                                        <td style="padding: 14px 12px; color: #4b5563; vertical-align: middle; white-space: nowrap;">
                                            <span style="background: <?php echo ($v['trans']>0?'#ecfdf5':'#fef2f2'); ?>; color: <?php echo ($v['trans']>0?'#059669':'#dc2626'); ?>; padding: 3px 8px; border-radius: 4px; font-size: 12px;"><?php echo ($v['trans']>0?'包含运费':'不含运费'); ?></span>
                                        </td>
                                        <td style="padding: 14px 12px; font-weight: 600; color: #0284c7; vertical-align: middle; white-space: nowrap;"><?php echo ($v["up"]); ?>%</td>
                                        <td style="padding: 14px 12px; vertical-align: middle; white-space: nowrap;">
                                            <div style="display: flex; gap: 6px; align-items: center;">
                                                <a class="btn btn-info btn-xs" href="<?php echo U('Users/cats','id='.$v['id']);?>" style="background-color: #0ea5e9; border-color: #0ea5e9; border-radius: 4px; padding: 4px 10px; color: #fff; font-size: 12px; text-decoration: none;">比例设定</a>
                                                <!-- 更新按钮已按要求改为“等级设置” -->
                                                <a class="btn btn-info btn-xs" ng-click="updateInfo('<?php echo ($v["id"]); ?>')" style="background-color: #3b82f6; border-color: #3b82f6; border-radius: 4px; padding: 4px 10px; color: #fff; font-size: 12px; cursor: pointer;">等级设置</a>
                                                <a class="btn btn-danger btn-xs" ng-click="dels('<?php echo ($v["id"]); ?>')" style="background-color: #ef4444; border-color: #ef4444; border-radius: 4px; padding: 4px 10px; color: #fff; font-size: 12px; cursor: pointer;">删除等级</a>
                                            </div>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- 手机端专属卡片堆叠视图 -->
                        <div class="mobile-card-view">
                            <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="search-record-card">
                                    <!-- 卡片头部 -->
                                    <div class="card-line-primary">
                                        <div class="user-phone">
                                            <i class="ti-medall" style="color: #0066cc;"></i> 
                                            <span><?php echo ($v["level"]); ?></span>
                                        </div>
                                        <div class="record-id">序号: <span style="color: #0066cc; font-weight: 600;"><?php echo ($v["id"]); ?></span></div>
                                    </div>

                                    <!-- 卡片核心参数 -->
                                    <div class="card-line-grid">
                                        <div class="grid-row">
                                            <span class="grid-label">客服电话：</span>
                                            <span class="grid-value" style="font-weight: 600; color: #1e293b;"><?php echo ($v["tel"]); ?></span>
                                        </div>
                                        <div class="grid-row">
                                            <span class="grid-label">通调比例：</span>
                                            <span class="grid-value" style="font-weight: 600; color: #0284c7;"><?php echo ($v["up"]); ?>%</span>
                                        </div>
                                        <div class="grid-row">
                                            <span class="grid-label">运费标识：</span>
                                            <span class="grid-value"><?php echo ($v['trans']>0?'包含运费':'不含运费'); ?></span>
                                        </div>
                                        
                                        <!-- 标准状态概览 -->
                                        <div class="grid-row" style="flex-direction: column; gap: 8px; margin-top: 4px;">
                                            <span class="grid-label" style="width: 100%; font-weight: 600; color: #1e293b;">标准状态概览 (1-10)：</span>
                                            
                                            <!-- 第一排：标准1 到 标准5 -->
                                            <div style="width: 100%;">
                                                <div style="font-size: 11px; color: #64748b; margin-bottom: 4px; font-weight: 500;">第一排 (标准1 - 标准5)</div>
                                                <div class="mobile-standards-row-grid">
                                                    <div class="standard-item">
                                                        <span class="std-name">标1</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_a']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_a']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_a']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                    <div class="standard-item">
                                                        <span class="std-name">标2</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_b']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_b']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_b']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                    <div class="standard-item">
                                                        <span class="std-name">标3</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_c']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_c']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_c']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                    <div class="standard-item">
                                                        <span class="std-name">标4</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_d']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_d']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_d']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                    <div class="standard-item">
                                                        <span class="std-name">标5</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_e']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_e']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_e']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 第二排：标准6 到 标准10 -->
                                            <div style="width: 100%;">
                                                <div style="font-size: 11px; color: #64748b; margin-bottom: 4px; font-weight: 500;">第二排 (标准6 - 标准10)</div>
                                                <div class="mobile-standards-row-grid">
                                                    <div class="standard-item">
                                                        <span class="std-name">标6</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_f']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_f']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_f']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                    <div class="standard-item">
                                                        <span class="std-name">标7</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_g']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_g']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_g']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                    <div class="standard-item">
                                                        <span class="std-name">标8</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_h']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_h']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_h']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                    <div class="standard-item">
                                                        <span class="std-name">标9</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_i']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_i']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_i']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                    <div class="standard-item">
                                                        <span class="std-name">标10</span>
                                                        <span class="std-val" style="background: <?php echo ($v['type_j']>0?'#dcfce7':'#f1f5f9'); ?>; color: <?php echo ($v['type_j']>0?'#15803d':'#64748b'); ?>;"><?php echo ($v['type_j']>0?'展示':'隐藏'); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- 卡片底部操作按钮 -->
                                    <div class="card-line-footer">
                                        <div class="record-time" style="font-size: 11.5px; color: #94a3b8;">
                                            <i class="ti-time"></i> 快捷操作
                                        </div>
                                        <div class="mobile-action-btns">
                                            <a class="btn btn-info btn-xs" href="<?php echo U('Users/cats','id='.$v['id']);?>" style="background-color: #0ea5e9; border: none; border-radius: 6px; padding: 8px 12px; color: #fff; font-size: 12px; text-decoration: none;">比例设定</a>
                                            <!-- 手机端操作按钮同步改为“等级设置” -->
                                            <a class="btn btn-info btn-xs" ng-click="updateInfo('<?php echo ($v["id"]); ?>')" style="background-color: #3b82f6; border: none; border-radius: 6px; padding: 8px 14px; color: #fff; font-size: 12px; cursor: pointer;">等级设置</a>
                                            <a class="btn btn-danger btn-xs" ng-click="dels('<?php echo ($v["id"]); ?>')" style="background-color: #ef4444; border: none; border-radius: 6px; padding: 8px 14px; color: #fff; font-size: 12px; cursor: pointer;">删除等级</a>
                                        </div>
                                    </div>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>

                        <!-- 现代化分页导航 -->
                        <div class="pagination-wrapper-box">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php echo ($list["show"]); ?>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal: 添加等级（已加入客服电话输入项） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="max-width: 720px; width: 96%; margin: 20px auto;">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 20px; font-weight: 300; opacity: 0.6;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: 600; color: #1e293b; font-size: 16px;">添加用户等级</h4>
                </div>
                <div class="modal-body" style="padding: 20px 24px; max-height: 75vh; overflow-y: auto;">
                    <form>
                        <!-- 第一部分：基本信息 -->
                        <div style="background: #f8fafc; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                            <div style="font-weight: 600; color: #334155; font-size: 13px; margin-bottom: 10px;">基本信息配置</div>
                            <div class="row" style="display: flex; flex-wrap: wrap; margin: 0 -6px;">
                                <div class="col-sm-3 col-xs-12" style="padding: 0 6px; margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 4px; display: block;">等级名称</label>
                                    <input type="text" name="level" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 13px; width: 100%;"/>
                                </div>
                                <div class="col-sm-3 col-xs-12" style="padding: 0 6px; margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 4px; display: block;">客服电话</label>
                                    <input type="text" name="tel" class="form-control" placeholder="请输入客服电话" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 13px; width: 100%;"/>
                                </div>
                                <div class="col-sm-3 col-xs-12" style="padding: 0 6px; margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 4px; display: block;">通调比率 (%)</label>
                                    <input type="text" name="up" class="form-control" placeholder="留空或填数字" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 13px; width: 100%;"/>
                                </div>
                                <div class="col-sm-3 col-xs-12" style="padding: 0 6px; margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 4px; display: block;">运费与状态</label>
                                    <div style="display: flex; gap: 6px;">
                                        <select name="trans" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 8px; font-size: 12px; width: 50%;">
                                            <option value="0">不含运费</option>
                                            <option value="1">包含运费</option>
                                        </select>
                                        <select name="status" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 8px; font-size: 12px; width: 50%;">
                                            <option value="1">使用</option>
                                            <option value="0">暂停</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 第二部分：标准1 - 标准5（第一排，五列横排） -->
                        <div style="background: #ffffff; padding: 12px 16px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #e2e8f0;">
                            <div style="font-weight: 600; color: #15803d; font-size: 13px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                                <span>第一排：标准1 ~ 标准5 状态设定</span>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px;">
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准1</label>
                                    <select name="type_a" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准2</label>
                                    <select name="type_b" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准3</label>
                                    <select name="type_c" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准4</label>
                                    <select name="type_d" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准5</label>
                                    <select name="type_e" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 第三部分：标准6 - 标准10（第二排，五列横排） -->
                        <div style="background: #ffffff; padding: 12px 16px; border-radius: 8px; margin-bottom: 0; border: 1px solid #e2e8f0;">
                            <div style="font-weight: 600; color: #15803d; font-size: 13px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                                <span>第二排：标准6 ~ 标准10 状态设定</span>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px;">
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准6</label>
                                    <select name="type_f" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准7</label>
                                    <select name="type_g" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准8</label>
                                    <select name="type_h" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准9</label>
                                    <select name="type_i" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准10</label>
                                    <select name="type_j" class="form-control" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 16px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 8px 18px; font-size: 13px;">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addor()" style="background-color: #0066cc; border-color: #0066cc; border-radius: 8px; padding: 8px 20px; font-size: 13px;">确认添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: 等级设置（原更新等级，增加客服电话绑定与文案优化） -->
    <div class="modal fade" id="myEdits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="max-width: 720px; width: 96%; margin: 20px auto;">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 20px; font-weight: 300; opacity: 0.6;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: 600; color: #1e293b; font-size: 16px;">等级设置</h4>
                </div>
                <div class="modal-body" style="padding: 20px 24px; max-height: 75vh; overflow-y: auto;">
                    <div>
                        <!-- 第一部分：基本信息 -->
                        <div style="background: #f8fafc; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                            <div style="font-weight: 600; color: #334155; font-size: 13px; margin-bottom: 10px;">基本信息配置</div>
                            <div class="row" style="display: flex; flex-wrap: wrap; margin: 0 -6px;">
                                <div class="col-sm-3 col-xs-12" style="padding: 0 6px; margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 4px; display: block;">等级名称</label>
                                    <input type="text" name="level" class="form-control" ng-model="info.level" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 13px; width: 100%;"/>
                                </div>
                                <div class="col-sm-3 col-xs-12" style="padding: 0 6px; margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 4px; display: block;">客服电话</label>
                                    <input type="text" name="tel" class="form-control" ng-model="info.tel" placeholder="请输入客服电话" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 13px; width: 100%;"/>
                                </div>
                                <div class="col-sm-3 col-xs-12" style="padding: 0 6px; margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 4px; display: block;">通调比率 (%)</label>
                                    <input type="text" name="up" class="form-control" ng-model="info.up" placeholder="留空或填数字" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 13px; width: 100%;"/>
                                </div>
                                <div class="col-sm-3 col-xs-12" style="padding: 0 6px; margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 4px; display: block;">运费与状态</label>
                                    <div style="display: flex; gap: 6px;">
                                        <select name="trans" class="form-control" ng-model="info.trans" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 8px; font-size: 12px; width: 50%;">
                                            <option value="0">不含运费</option>
                                            <option value="1">包含运费</option>
                                        </select>
                                        <select name="status" class="form-control" ng-model="info.status" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 8px; font-size: 12px; width: 50%;">
                                            <option value="1">使用</option>
                                            <option value="0">暂停</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 第二部分：标准1 - 标准5（第一排，五列横排） -->
                        <div style="background: #ffffff; padding: 12px 16px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #e2e8f0;">
                            <div style="font-weight: 600; color: #15803d; font-size: 13px; margin-bottom: 10px;">第一排：标准1 ~ 标准5 状态设定</div>
                            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px;">
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准1</label>
                                    <select name="type_a" class="form-control" ng-model="info.type_a" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准2</label>
                                    <select name="type_b" class="form-control" ng-model="info.type_b" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准3</label>
                                    <select name="type_c" class="form-control" ng-model="info.type_c" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准4</label>
                                    <select name="type_d" class="form-control" ng-model="info.type_d" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准5</label>
                                    <select name="type_e" class="form-control" ng-model="info.type_e" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 第三部分：标准6 - 标准10（第二排，五列横排） -->
                        <div style="background: #ffffff; padding: 12px 16px; border-radius: 8px; margin-bottom: 0; border: 1px solid #e2e8f0;">
                            <div style="font-weight: 600; color: #15803d; font-size: 13px; margin-bottom: 10px;">第二排：标准6 ~ 标准10 状态设定</div>
                            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px;">
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准6</label>
                                    <select name="type_f" class="form-control" ng-model="info.type_f" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准7</label>
                                    <select name="type_g" class="form-control" ng-model="info.type_g" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准8</label>
                                    <select name="type_h" class="form-control" ng-model="info.type_h" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准9</label>
                                    <select name="type_i" class="form-control" ng-model="info.type_i" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px; color: #64748b; margin-bottom: 2px; display: block;">标准10</label>
                                    <select name="type_j" class="form-control" ng-model="info.type_j" style="border-radius: 6px; border: 1px solid #cbd5e1; padding: 6px 4px; font-size: 12px; width: 100%;">
                                        <option value="1">展示</option>
                                        <option value="0">隐藏</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 16px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 8px 18px; font-size: 13px;">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateOp()" style="background-color: #0066cc; border-color: #0066cc; border-radius: 8px; padding: 8px 20px; font-size: 13px;">确认更新</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: 分类比例 -->
    <div class="modal fade" id="myEditsCats" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="max-width: 500px; width: 92%; margin: 30px auto;">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 20px; font-weight: 300; opacity: 0.6;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: 600; color: #1e293b; font-size: 16px;">分类比例设定</h4>
                </div>
                <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
                    <table class="table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 10px 12px; font-size: 12px; color: #4b5563;">ID</th>
                                <th style="padding: 10px 12px; font-size: 12px; color: #4b5563;">名称</th>
                                <th style="padding: 10px 12px; font-size: 12px; color: #4b5563;">调整比率</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr style="border-bottom: 1px solid #f3f4f6;">
                                <th scope="row" style="padding: 12px; color: #6b7280; font-weight: 500;"><?php echo ($v["id"]); ?></th>
                                <td style="padding: 12px; color: #1e293b; font-weight: 500;"><?php echo ($v["name"]); ?></td>
                                <td style="padding: 12px; color: #0284c7; font-weight: 600;"><?php echo ($v["up"]); ?>%</td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 响应式与苹果极简商务风美化样式 -->
<style>
    /* 默认隐藏手机端卡片容器 */
    .mobile-card-view {
        display: none;
    }

    /* 电脑端表格斑马纹与平滑悬停效果 */
    .desktop-search-table tbody tr:nth-child(odd) {
        background-color: #fafbfc;
    }
    .desktop-search-table tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    /* 分页导航容器包装 */
    .pagination-wrapper-box {
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: center;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .pagination-wrapper-box .pagination {
        display: flex;
        gap: 4px;
        padding-left: 0;
        list-style: none;
        margin: 0;
        white-space: nowrap;
    }
    .pagination-wrapper-box .pagination li a, 
    .pagination-wrapper-box .pagination li span {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .pagination-wrapper-box .pagination li.active span,
    .pagination-wrapper-box .pagination li a:hover {
        background-color: #0066cc !important;
        border-color: #0066cc !important;
        color: #ffffff !important;
    }

    /* 手机端标准五列横排网格样式 */
    .mobile-standards-row-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 4px;
        background: #f8fafc;
        padding: 6px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }
    .standard-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        padding: 4px 2px;
        border-radius: 4px;
        border: 1px solid #f1f5f9;
    }
    .std-name {
        font-size: 10px;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 2px;
    }
    .std-val {
        font-size: 10px;
        font-weight: 600;
        padding: 1px 4px;
        border-radius: 3px;
    }

    /* 响应式断点控制：当屏幕宽度小于等于 992px 时自动降级为手机卡片堆叠流式排版 */
    @media (max-width: 992px) {
        .desktop-table-view {
            display: none !important;
        }
        .mobile-card-view {
            display: flex !important;
            flex-direction: column;
            gap: 12px;
        }
        /* 手机端彻底铺开至左右两边，零边距 */
        .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .card.alert {
            padding: 12px 8px !important;
            border-radius: 8px !important;
        }

        /* 手机端独立卡片造型 */
        .search-record-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            margin: 0;
        }

        /* 卡片头部 */
        .card-line-primary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 8px;
        }
        .card-line-primary .user-phone {
            font-size: 15px;
            font-weight: 600;
            color: #0066cc;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .card-line-primary .record-id {
            font-size: 12px;
            color: #64748b;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
        }

        /* 严格左对齐的网格布局 */
        .card-line-grid {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 13px;
            padding: 2px 0;
        }
        .grid-row {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .grid-label {
            width: 85px;
            flex-shrink: 0;
            color: #64748b;
            font-size: 12px;
            font-weight: 400;
        }
        .grid-value {
            flex-grow: 1;
            color: #1e293b;
            font-weight: 500;
            text-align: left;
            word-break: break-all;
        }

        /* 卡片底部操作按钮与时间区 */
        .card-line-footer {
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .mobile-action-btns {
            display: flex;
            gap: 6px;
        }

        .pagination-wrapper-box {
            justify-content: flex-start;
            padding-bottom: 6px;
        }
    }
</style>

<!-- 数据处理与控制器脚本 -->
<script>
    /**
     * 添加等级异步请求
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=users_level');?>";
        
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

    ////////////////////////////////////////////////////////////////////////////

    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

        $scope.info;

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
        $scope.updateInfoCats = function (id) {
            $scope.commAjax("<?php echo U('Users/cats');?>", {id: id}, function (res) {
                $scope.info = res.data;
                $("#myEditsCats").modal("show");
            });
        }

        $scope.updateInfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=users_level');?>", {ids: id}, function (res) {
                $scope.info = res.data;
                $("#myEdits").modal("show");
            });
        }

        $scope.updateOp = function () {
            var param = $scope.info;
            param.ids = param.id;
            
            $.ajax({
                url: "<?php echo U('Core/edits','model=users_level');?>",
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
            $scope.commAjax("<?php echo U('Core/dels','model=users_level');?>", param, function (res) {
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