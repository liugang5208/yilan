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
                <div class="container-fluid" style="width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 15px 24px !important; box-sizing: border-box;" ng-app="myApp" ng-controller="myCtrl">
    
    <!-- 主内容卡片区域：实现从方屏、常规屏到超宽带鱼屏的 100% 全屏无极铺开 -->
    <section id="main-content" style="width: 100% !important; margin: 0 !important;">
        <div class="row" style="margin-left: 0; margin-right: 0;">
            <div class="col-lg-12" style="padding-left: 0; padding-right: 0;">
                <div class="card alert" style="background: #ffffff; border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.04); box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04); padding: 24px; margin-bottom: 30px; width: 100%; box-sizing: border-box;">
                    
                    <!-- 卡片头部标题 -->
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid #f3f4f6; padding: 0 0 16px 0; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="font-size: 18px; font-weight: 600; color: #1d1d1f; margin: 0;">材料分类价格执行列表</h4>
                    </div>

                    <!-- 数据展示主体区域 -->
                    <div class="card-body" style="padding: 0; width: 100%;">
                        
                        <!-- 电脑端标准高清表格视图：全屏无极展开、奇偶行交替色、无过宽空白 -->
                        <div class="table-responsive desktop-table-view" style="border: none; overflow-x: visible; width: 100%;">
                            <table class="table desktop-search-table" style="width: 100%; margin-bottom: 15px; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                                        <th style="padding: 12px 16px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase;">#</th>
                                        <th style="padding: 12px 16px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase;">名称</th>
                                        <th style="padding: 12px 16px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase;">状态</th>
                                        <th style="padding: 12px 16px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase;">进度(%)</th>
                                        <th width="20%" style="padding: 12px 16px; font-weight: 600; color: #4b5563; font-size: 12px; text-transform: uppercase;">创建时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr style="border-bottom: 1px solid #f3f4f6; transition: background-color 0.15s ease;">
                                        <th scope="row" style="padding: 14px 16px; font-weight: 500; color: #6b7280; vertical-align: middle;"><?php echo ($v["id"]); ?></th>
                                        <td style="padding: 14px 16px; font-weight: 600; color: #0071e3; vertical-align: middle;"><?php echo ($v["title"]); ?></td>
                                        <td style="padding: 14px 16px; color: #4b5563; vertical-align: middle;">
                                            <span style="background: #f1f5f9; padding: 3px 8px; border-radius: 4px; font-size: 12px; color: #334155;"><?php echo ($v["status_title"]); ?></span>
                                        </td>
                                        <td style="padding: 14px 16px; color: #4b5563; vertical-align: middle;">
                                            <span style="font-weight: 600; color: #111827;"><?php echo ($v["ratio"]); ?></span>
                                        </td>
                                        <td style="padding: 14px 16px; color: #6b7280; vertical-align: middle; font-size: 12.5px;"><?php echo (date('Y-m-d H:i:s',$v["add_time"])); ?></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- 手机端专属卡片堆叠视图（严格左对齐、主标题高亮、零信息丢失） -->
                        <div class="mobile-card-view">
                            <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="search-record-card">
                                    <!-- 卡片头部：精选科技蓝色高亮的名称与ID -->
                                    <div class="card-line-primary">
                                        <div class="user-phone">
                                            <i class="ti-file" style="color: #0071e3;"></i> 
                                            <span><?php echo ($v["title"]); ?></span>
                                        </div>
                                        <div class="record-id">ID: <?php echo ($v["id"]); ?></div>
                                    </div>

                                    <!-- 卡片核心参数网格：左侧固定标题，右侧靠左内容对齐，杜绝错行 -->
                                    <div class="card-line-grid">
                                        <div class="grid-row">
                                            <span class="grid-label">当前状态：</span>
                                            <span class="grid-value">
                                                <span style="background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-size: 12px; color: #334155;"><?php echo ($v["status_title"]); ?></span>
                                            </span>
                                        </div>
                                        <div class="grid-row">
                                            <span class="grid-label">执行进度：</span>
                                            <span class="grid-value" style="font-weight: 600; color: #0071e3;"><?php echo ($v["ratio"]); ?>%</span>
                                        </div>
                                    </div>

                                    <!-- 卡片底部：创建时间 -->
                                    <div class="card-line-footer">
                                        <div class="record-time">
                                            <i class="ti-time"></i> <?php echo (date('Y-m-d H:i:s',$v["add_time"])); ?>
                                        </div>
                                    </div>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>

                        <!-- 完美包裹在容器内部、支持平滑横向滑动的现代化分页导航 -->
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

    <!-- 弹窗: 添加 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 35%; max-width: 500px; min-width: 300px; margin: 30px auto;">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f3f4f6; padding: 20px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 2px;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: 600; color: #1d1d1f;">添加材料分类价格</h4>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <form name="ador">
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #4b5563; margin-bottom: 6px; display: block;">名称</label>
                            <input type="text" name="name" class="form-control" style="border-radius: 8px; border: 1px solid #d2d2d7; padding: 10px 12px; height: 42px; width: 100%;"/>
                        </div>
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #4b5563; margin-bottom: 6px; display: block;">增值税普通发票</label>
                            <input type="text" name="normal_tax" class="form-control" style="border-radius: 8px; border: 1px solid #d2d2d7; padding: 10px 12px; height: 42px; width: 100%;"/>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="font-weight: 500; color: #4b5563; margin-bottom: 6px; display: block;">增值税专用发票</label>
                            <input type="text" name="special_tax" class="form-control" style="border-radius: 8px; border: 1px solid #d2d2d7; padding: 10px 12px; height: 42px; width: 100%;"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 16px 20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 8px 16px; height: 40px;">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addor()" style="border-radius: 8px; padding: 8px 20px; height: 40px; background-color: #0071e3; border: none;">添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 弹窗: 更新 -->
    <div class="modal fade" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 35%; max-width: 500px; min-width: 300px; margin: 30px auto;">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f3f4f6; padding: 20px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 2px;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="font-weight: 600; color: #1d1d1f;">更新材料分类价格</h4>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <form>
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #4b5563; margin-bottom: 6px; display: block;">名称</label>
                            <input type="text" name="name" class="form-control" ng-model="infos.name" style="border-radius: 8px; border: 1px solid #d2d2d7; padding: 10px 12px; height: 42px; width: 100%;"/>
                        </div>
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 500; color: #4b5563; margin-bottom: 6px; display: block;">增值税普通发票</label>
                            <input type="text" name="normal_tax" ng-model="infos.normal_tax" class="form-control" style="border-radius: 8px; border: 1px solid #d2d2d7; padding: 10px 12px; height: 42px; width: 100%;"/>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="font-weight: 500; color: #4b5563; margin-bottom: 6px; display: block;">增值税专用发票</label>
                            <input type="text" name="special_tax" ng-model="infos.special_tax" class="form-control" style="border-radius: 8px; border: 1px solid #d2d2d7; padding: 10px 12px; height: 42px; width: 100%;"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 16px 20px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 8px 16px; height: 40px;">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateCats()" style="border-radius: 8px; padding: 8px 20px; height: 40px; background-color: #0071e3; border: none;">更新</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 响应式与苹果极简商务风样式控制 -->
<style>
    /* 默认隐藏手机端卡片容器 */
    .mobile-card-view {
        display: none;
    }

    /* 输入框焦点状态 */
    .form-control:focus {
        border-color: #0071e3 !important;
        box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.12) !important;
        outline: none;
    }

    /* 电脑端奇偶行交叉底色与悬停反馈 */
    .desktop-search-table tbody tr:nth-child(odd) {
        background-color: #fafbfc;
    }
    .desktop-search-table tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    /* 分页导航安全容器（居中且完美包裹在卡片内） */
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
        background-color: #0071e3 !important;
        border-color: #0071e3 !important;
        color: #ffffff !important;
    }

    /* 手机端响应式断点切换（屏幕宽度小于等于 992px 时触发） */
    @media (max-width: 992px) {
        .desktop-table-view {
            display: none !important;
        }
        .mobile-card-view {
            display: flex !important;
            flex-direction: column;
            gap: 12px;
        }
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        /* 手机端单张独立卡片外观（苹果风圆角、细腻微阴影） */
        .search-record-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* 卡片头部：名称高亮与ID */
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
            color: #0071e3;
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

        /* 核心修正：严格左右对齐的网格行，彻底消除错行和跑偏问题 */
        .card-line-grid {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 13px;
            padding: 2px 0;
        }
        .grid-row {
            display: flex;
            align-items: flex-start;
            width: 100%;
        }
        .grid-label {
            width: 84px;
            flex-shrink: 0;
            color: #64748b;
            font-size: 12.5px;
            font-weight: 400;
        }
        .grid-value {
            flex-grow: 1;
            color: #1e293b;
            font-weight: 500;
            text-align: left;
            word-break: break-all;
        }

        /* 卡片底部时间区域 */
        .card-line-footer {
            border-top: 1px solid #f1f5f9;
            padding-top: 8px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .record-time {
            font-size: 12px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* 手机端分页容器左对齐支持横向滚动 */
        .pagination-wrapper-box {
            justify-content: flex-start;
            padding-bottom: 6px;
        }

        /* 弹窗宽度自适应手机屏幕 */
        .modal-dialog {
            width: 90% !important;
            margin: 20px auto !important;
        }
    }
</style>

<script>
    /**
     * 添加
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form[name='ador']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=new_tax');?>";
        
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

        $scope.updateinfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=new_tax');?>", {ids: id}, function (res) {
                $scope.infos = res.data;
                $("#myEdit").modal("show");
            });
        }

        $scope.updateCats = function () {
            var param = $scope.infos;
            param.ids = param.id;
            
            $.ajax({
                url: "<?php echo U('newTax/edits');?>",
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
            $scope.commAjax("<?php echo U('Core/dels','model=new_tax');?>", param, function (res) {
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