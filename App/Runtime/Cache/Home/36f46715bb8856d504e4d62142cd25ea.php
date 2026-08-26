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
                <div class="container-fluid" ng-app="myApp" ng-controller="myCtrl" style="padding: 15px 20px; max-width: 1560px; margin: 0 auto;">
    <!-- 顶部主内容区 -->
    <section id="main-content" style="margin-top: 0;">

        <div class="row">
            <div class="col-lg-12" style="padding: 0;">
                <div class="card alert" style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04); border: 1px solid rgba(0, 0, 0, 0.04); padding: 24px; margin-bottom: 20px;">
                    
                    <!-- 头部标题与操作按钮 -->
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px;">
                        <h4 style="font-size: 15px; font-weight: 600; color: #1e293b; margin: 0; line-height: 1.5;">
                            注册用户管理中心 
                            <span style="font-size: 12px; font-weight: normal; color: #ef4444; margin-left: 6px;">（提示：红色昵称代表申请提升账户权限的用户）</span>
                        </h4>

                        <div class="card-header-right-icon">
                            <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 10px;">
                                <li class="doc-link" style="display: flex; gap: 10px;">
                                    <a class="btn btn-xs btn-warning" href="<?php echo U('Users/index_posi');?>" style="border-radius: 8px; padding: 10px 16px; font-weight: 500; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; background-color: #f59e0b; border-color: #f59e0b; color: #ffffff; transition: all 0.2s;"><i class="ti-location-pin"></i> 一键更新手机归属地</a>
                                    <a class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal" style="border-radius: 8px; padding: 10px 16px; font-weight: 500; font-size: 13px; background-color: #0066cc; border-color: #0066cc; color: #ffffff; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;"><i class="ti-plus"></i> 添加注册用户</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body" style="padding: 0;">

                        <!-- 搜索栏 -->
                        <form action="<?php echo U('Users/index');?>" class="form-inline" style="margin-bottom: 24px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                            <div class="form-group" style="margin: 0; flex: 1; min-width: 240px;">
                                <input type="text" name="phone" class="form-control input-sm" placeholder="请输入用户手机号码进行精准查找" style="border-radius: 8px; height: 42px; padding: 6px 14px; border: 1px solid #cbd5e1; width: 100%; font-size: 14px; background-color: #f8fafc; color: #1e293b;"/>
                            </div>
                            <button type="submit" class="btn btn-xs btn-info" style="border-radius: 8px; height: 42px; padding: 0 24px; background-color: #0066cc; border-color: #0066cc; font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; color: #ffffff; transition: all 0.2s;"><i class="ti-search"></i> 查找账号</button>
                        </form>

                        <!-- 表格与手机端响应式卡片包裹层 -->
                        <div class="table-responsive apple-table-container" style="border: none; overflow-x: auto;">
                            <table class="table apple-custom-table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                                <thead>
                                    <tr style="background-color: #f1f5f9; color: #334155; font-size: 13px;">
                                        <th style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">#ID</th>
                                        <th style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">注册账号</th>
                                        <th style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">昵称</th>
                                        <th style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">账号备注</th>
                                        <th style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">手机归属地</th>
                                        <th style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">权限级别</th>
                                        <th style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">是否签约</th>
                                        <th style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">状态</th>
                                        <th width="11%" style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">注册时间</th>
                                        <th width="11%" style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">最后登录</th>
                                        <th width="18%" style="padding: 14px 12px; border-bottom: 2px solid #e2e8f0; border-top: none; font-weight: 600;">管理操作</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="apple-data-row" style="transition: background-color 0.2s;">
                                        <th scope="row" style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04);" data-label="编号"><?php echo ($v["id"]); ?></th>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04); font-weight: 600;" data-label="注册账号"><?php echo ($v["phone"]); ?></td>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04);" data-label="昵称"><?php echo ($v["nickname"]); ?></td>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04);" data-label="账号备注"><?php echo ($v["tags"]); ?></td>
                                        <!-- 归属地字段对应数据库 users 表的 locate 字段 -->
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04); color: #0284c7; font-weight: 500;" data-label="手机归属地"><?php echo ($v["locate"]); ?></td>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04);" data-label="权限级别"><?php echo (getUsersLv($v['ac_level'],$ac_level)); ?></td>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04);" data-label="是否签约">
                                            <span style="padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 500; <?php echo ($v['ac_credit']>0?'background: #d1fae5; color: #065f46;':'background: #f3f4f6; color: #4b5563;'); ?>">
                                                <?php echo ($v['ac_credit']>0?'是':'否'); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04);" data-label="状态">
                                            <span style="padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 500; <?php echo ($v['status']>0?'background: #dbeafe; color: #1e40af;':'background: #fee2e2; color: #991b1b;'); ?>">
                                                <?php echo ($v['status']>0?'正常':'禁用'); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04); font-size: 12px; color: #64748b;" data-label="注册时间"><?php echo (date('Y/m/d H:i:s',$v["times"])); ?></td>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04); font-size: 12px; color: #64748b;" data-label="最后登录"><?php echo (date('Y/m/d H:i:s',$v["last"])); ?></td>
                                        <td style="padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.04);" data-label="管理操作">
                                            <div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
                                                <?php if(($v["is_report"]) == "0"): ?><a href="javascript:changeReport('<?php echo ($v["id"]); ?>', 1);" class="btn btn-success btn-xs" style="border-radius: 6px; padding: 6px 10px; font-size: 12px; min-height: 32px; display: inline-flex; align-items: center;">解除禁用报价</a><?php endif; ?>
                                                <?php if(($v["is_report"]) == "1"): ?><a href="javascript:changeReport('<?php echo ($v["id"]); ?>', 0);" class="btn btn-danger btn-xs" style="border-radius: 6px; padding: 6px 10px; font-size: 12px; min-height: 32px; display: inline-flex; align-items: center;">禁用报价</a><?php endif; ?>
                                                
                                                <a class="btn btn-info btn-xs" href="<?php echo U('Users/infos','id='.$v['id']);?>" style="border-radius: 6px; padding: 6px 10px; font-size: 12px; min-height: 32px; display: inline-flex; align-items: center;">查看</a>
                                                <a class="btn btn-info btn-xs" ng-click="updateInfo('<?php echo ($v["id"]); ?>')" style="border-radius: 6px; padding: 6px 10px; font-size: 12px; min-height: 32px; display: inline-flex; align-items: center; background-color: #0284c7; border-color: #0284c7;">编辑</a>
                                                <?php if(($v["status"]) == "0"): ?><a href="javascript:change('<?php echo ($v["id"]); ?>', 1);" class="btn btn-success btn-xs" style="border-radius: 6px; padding: 6px 10px; font-size: 12px; min-height: 32px; display: inline-flex; align-items: center;">启用</a><?php endif; ?>
                                                <?php if(($v["status"]) == "1"): ?><a href="javascript:change('<?php echo ($v["id"]); ?>', 0);" class="btn btn-danger btn-xs" style="border-radius: 6px; padding: 6px 10px; font-size: 12px; min-height: 32px; display: inline-flex; align-items: center;">禁用</a><?php endif; ?>
                                                <a ng-click="dels('<?php echo ($v["id"]); ?>')" class="btn btn-danger btn-xs" style="border-radius: 6px; padding: 6px 10px; font-size: 12px; min-height: 32px; display: inline-flex; align-items: center;">删除</a>
                                            </div>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>

                            <!-- 分页 -->
                            <nav aria-label="Page navigation" style="margin-top: 24px; display: flex; justify-content: center;">
                                <ul class="pagination"><?php echo ($list["show"]); ?></ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- Modal：添加注册用户 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 400px; max-width: 90%;">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: 600; color: #1e293b; font-size: 16px;">添加注册用户</h4>
                </div>
                <div class="modal-body" style="padding: 24px;">

                    <form name="addnew">
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">账户权限级别</label>
                            <select name="ac_level" class="form-control" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;">
                                <option value="">请选择权限级别</option>
                                <?php if(is_array($level)): $i = 0; $__LIST__ = $level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["level"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">是否签约商户</label>
                            <select name="ac_credit" class="form-control" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;">
                                <option value="0">否</option>
                                <option value="1">是</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">电话/登录账号</label>
                            <input type="text" name="phone" class="form-control" placeholder="请输入手机号" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;"/>
                        </div>
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">登录密码</label>
                            <input type="password" name="passwd" class="form-control" placeholder="请输入密码" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;"/>
                        </div>
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">账号备注名称</label>
                            <input type="text" name="tags" class="form-control" placeholder="例如：某某公司" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;"/>
                        </div>
                        <!-- 对应数据库 locate 字段 -->
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">手机归属地 (省份+城市)</label>
                            <input type="text" name="locate" class="form-control" placeholder="例如：广东深圳" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;"/>
                        </div>
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">账号状态</label>
                            <select name="status" class="form-control" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;">
                                <option value="1">正常使用</option>
                                <option value="0">暂停禁用</option>
                            </select>
                        </div>
                    </form>

                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 10px 20px; min-height: 40px;">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addor()" style="border-radius: 8px; padding: 10px 20px; background-color: #0066cc; border-color: #0066cc; min-height: 40px;">确认添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal：更新注册用户 -->
    <div class="modal fade" id="myEdits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 400px; max-width: 90%;">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: 600; color: #1e293b; font-size: 16px;">更新注册用户</h4>
                </div>
                <div class="modal-body" style="padding: 24px;">

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">账户权限级别</label>
                        <select name="ac_level" class="form-control" ng-model="info.ac_level" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;">
                            <option value="">请选择权限级别</option>
                            <?php if(is_array($level)): $i = 0; $__LIST__ = $level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["level"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">是否签约商户</label>
                        <select name="ac_credit" class="form-control" ng-model="info.ac_credit" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;">
                            <option value="0">否</option>
                            <option value="1">是</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">电话/登录账号</label>
                        <input type="text" name="phone" class="form-control" ng-model="info.phone" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;"/>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">账号备注名称</label>
                        <input type="text" name="tags" class="form-control" ng-model="info.tags" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;"/>
                    </div>
                    <!-- 对应数据库 locate 字段 -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">手机归属地 (省份+城市)</label>
                        <input type="text" name="locate" class="form-control" ng-model="info.locate" placeholder="例如：广东深圳" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;"/>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 500; color: #334155; margin-bottom: 6px; font-size: 13px;">账号状态</label>
                        <select name="status" class="form-control" ng-model="info.status" style="border-radius: 8px; height: 42px; border: 1px solid #cbd5e1;">
                            <option value="1">正常使用</option>
                            <option value="0">暂停禁用</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 10px 20px; min-height: 40px;">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateOp()" style="border-radius: 8px; padding: 10px 20px; background-color: #0066cc; border-color: #0066cc; min-height: 40px;">确认更新</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 苹果商务风高档视觉样式与多端自适应防崩塌处理 -->
<style>
    body {
        background-color: #f8fafc !important;
        color: #1e293b;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .container-fluid {
        max-width: 1600px !important;
    }

    /* 电脑端：奇偶行底色错开（斑马纹），让行与行之间视觉层次清晰分明 */
    .apple-custom-table tbody tr:nth-child(odd) {
        background-color: #ffffff !important;
        color: #1e293b;
    }
    .apple-custom-table tbody tr:nth-child(even) {
        background-color: #f8fafc !important;
        color: #334155;
    }

    /* 悬停微交互效果 */
    .apple-custom-table tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    /* 移动端智能响应式转卡片布局（绝对不挤压变形） */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
            padding-top: 10px !important;
        }
        .apple-custom-table thead {
            display: none;
        }
        .apple-custom-table, .apple-custom-table tbody, .apple-custom-table tr, .apple-custom-table td {
            display: block;
            width: 100%;
        }
        
        /* 手机端卡片奇偶底色错开 */
        .apple-custom-table tbody tr:nth-child(odd).apple-data-row {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
        }
        .apple-custom-table tbody tr:nth-child(even).apple-data-row {
            background: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
        }

        .apple-data-row {
            border-radius: 12px !important;
            margin-bottom: 12px !important;
            padding: 12px 14px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }
        .apple-custom-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
            padding: 6px 0 !important;
            border-bottom: 1px solid rgba(0,0,0,0.03) !important;
            font-size: 13px;
        }
        .apple-custom-table td:last-child {
            border-bottom: none !important;
            padding-top: 10px !important;
            margin-top: 6px;
            border-top: 1px dashed #e2e8f0;
            justify-content: flex-start;
        }
        .apple-custom-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            text-align: left;
            margin-right: 12px;
            flex-shrink: 0;
            font-size: 12px;
        }
        .apple-custom-table td [class*="btn"] {
            min-height: 36px;
            padding: 4px 10px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .modal-dialog {
            width: 94% !important;
            margin: 30px auto !important;
        }
    }
</style>

<script>
    /**
     * 添加注册用户
     */
    function addor() {
        var temp = $("form[name='addnew']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=users');?>";
        
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
                swal('提示', '网络请求失败，请稍后重试', "error");
            }
        });
    }

    /**
     * 更新账号状态
     */
    function change(id, st) {
        var data = {ids: id, status: st};
        
        $.ajax({
            url: "<?php echo U('Core/edits','model=users');?>",
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
                swal('提示', '网络请求失败，请稍后重试', "error");
            }
        });
    }
    
    /**
     * 更新报价权限状态
     */
    function changeReport(id, st) {
        var data = {ids: id, is_report: st};
        
        $.ajax({
            url: "<?php echo U('Core/edits','model=users');?>",
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
                swal('提示', '网络请求失败，请稍后重试', "error");
            }
        });
    }

    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

        $scope.info = {};

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

        $scope.updateInfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=users');?>", {ids: id}, function (res) {
                $scope.info = res.data;
                $("#myEdits").modal("show");
            });
        }

        $scope.updateOp = function () {
            var param = angular.copy($scope.info);
            param.ids = param.id;
            param.apply_check = 0;
            
            $.ajax({
                url: "<?php echo U('Core/edits','model=users');?>",
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
            $scope.commAjax("<?php echo U('Core/dels','model=users');?>", param, function (res) {
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