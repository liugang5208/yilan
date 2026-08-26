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
                <div class="container-fluid" ng-app="myApp" ng-controller="myCtrl">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="apple-header-bar">
                <div class="page-title">
                    <h1>帮助信息管理</h1>
                    <span class="apple-subtitle">系统帮助文档与分类内容的综合管理中心</span>
                </div>
                <div class="apple-header-actions">
                    <button type="button" class="btn btn-apple-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus"></i> 添加帮助信息
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 主体内容区 -->
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="card alert apple-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table apple-table">
                                <thead>
                                    <tr>
                                        <th># 编号</th>
                                        <th>帮助名称</th>
                                        <th>运行状态</th>
                                        <th width="18%">记录时间</th>
                                        <th width="22%" style="text-align: right;">管理操作</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                        <td scope="row" data-label="编号">#<?php echo ($v["id"]); ?></td>
                                        <td data-label="帮助名称" class="font-weight-medium"><?php echo ($v["title"]); ?></td>
                                        <td data-label="状态">
                                            <span class="status-badge <?php echo ($v['status']>0?'status-normal':'status-pause'); ?>">
                                                <?php echo ($v['status']>0?'正常运行':'暂停使用'); ?>
                                            </span>
                                        </td>
                                        <td data-label="记录时间" class="text-secondary"><?php echo (date('Y/m/d H:i:s',$v["times"])); ?></td>
                                        <td data-label="管理" class="action-buttons-cell">
                                            <div class="btn-group-custom">
                                                <a href="<?php echo U('Know/helps_list','id='.$v['id']);?>" class="btn btn-apple-info btn-xs">文章列表</a>
                                                <a ng-click="updateinfo('<?php echo ($v["id"]); ?>')" class="btn btn-apple-warning btn-xs">编辑</a>
                                                <a class="btn btn-apple-danger btn-xs" ng-click="dels('<?php echo ($v["id"]); ?>')">删除</a>
                                            </div>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>

                            <nav aria-label="Page navigation" class="apple-pagination-container">
                                <ul class="pagination"><?php echo ($list["show"]); ?></ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 添加帮助信息弹窗 -->
    <div class="modal fade apple-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加帮助信息</h4>
                </div>
                <div class="modal-body">
                    <form name="ador">
                        <div class="form-group apple-form-group">
                            <label>帮助名称</label>
                            <input type="text" name="title" class="form-control apple-input" placeholder="请输入帮助信息标题名称..."/>
                        </div>
                        <div class="form-group apple-form-group">
                            <label>运行状态</label>
                            <select name="status" class="form-control apple-input">
                                <option value="1">使用</option>
                                <option value="0">暂停</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-cancel" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary apple-btn-submit" onclick="addor()">确认添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 更新帮助信息弹窗 -->
    <div class="modal fade apple-modal" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新帮助信息</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group apple-form-group">
                            <label>帮助名称</label>
                            <input type="text" name="title" class="form-control apple-input" ng-model="infos.title"/>
                        </div>
                        <div class="form-group apple-form-group">
                            <label>运行状态</label>
                            <select name="status" class="form-control apple-input" ng-model="infos.status">
                                <option value="1">使用</option>
                                <option value="0">暂停</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-cancel" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary apple-btn-submit" ng-click="updateCats()">保存更新</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* 苹果极简商务风核心美化与响应式全屏铺开样式 */
    :root {
        --apple-bg: #f5f5f7;
        --apple-card-bg: #ffffff;
        --apple-text-main: #1d1d1f;
        --apple-text-secondary: #86868b;
        --apple-border: #d2d2d7;
        --apple-primary: #0071e3;
        --apple-primary-hover: #0077ed;
        --apple-danger: #ff3b30;
        --apple-warning: #ff9f0a;
        --apple-success: #34c759;
        --apple-radius-sm: 8px;
        --apple-radius-md: 12px;
        --apple-radius-lg: 16px;
        --apple-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
    }

    .container-fluid {
        background-color: var(--apple-bg);
        min-height: 100vh;
        padding: 24px !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* 顶部标题栏重构：全屏铺开，拒绝左右多余留空 */
    .apple-header-bar {
        background: var(--apple-card-bg);
        padding: 24px 32px;
        border-radius: var(--apple-radius-lg);
        box-shadow: var(--apple-shadow);
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid rgba(0, 0, 0, 0.02);
    }

    .apple-header-bar .page-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: var(--apple-text-main);
        margin: 0 0 6px 0;
        letter-spacing: -0.5px;
    }

    .apple-subtitle {
        font-size: 13px;
        color: var(--apple-text-secondary);
    }

    /* 主内容卡片铺满 */
    .apple-card {
        background: var(--apple-card-bg) !important;
        border: none !important;
        border-radius: var(--apple-radius-lg) !important;
        box-shadow: var(--apple-shadow) !important;
        margin-bottom: 0 !important;
    }

    .card-body {
        padding: 28px !important;
    }

    /* 苹果按钮组件 */
    .btn-apple-primary {
        background-color: var(--apple-primary);
        color: #ffffff;
        border: none;
        border-radius: var(--apple-radius-sm);
        padding: 10px 20px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 113, 227, 0.25);
    }

    .btn-apple-primary:hover {
        background-color: var(--apple-primary-hover);
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* 表格样式现代美化 */
    .apple-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        color: var(--apple-text-main);
    }

    .apple-table th {
        border-bottom: 2px solid var(--apple-border) !important;
        color: var(--apple-text-secondary);
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 18px !important;
        background: rgba(0,0,0,0.01);
    }

    .apple-table td {
        padding: 18px !important;
        vertical-align: middle !important;
        border-top: 1px solid rgba(0, 0, 0, 0.04) !important;
        font-size: 14px;
    }

    .apple-table tbody tr:nth-child(even) {
        background-color: rgba(0, 0, 0, 0.012);
    }

    .apple-table tbody tr:hover {
        background-color: rgba(0, 113, 227, 0.025);
    }

    .font-weight-medium {
        font-weight: 500;
        color: var(--apple-text-main);
    }

    /* 状态徽章 */
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-normal {
        background: rgba(52, 199, 89, 0.12);
        color: var(--apple-success);
    }

    .status-pause {
        background: rgba(255, 159, 10, 0.12);
        color: var(--apple-warning);
    }

    /* 管理操作按钮组 */
    .action-buttons-cell {
        text-align: right;
    }

    .btn-group-custom {
        display: inline-flex;
        gap: 6px;
    }

    .btn-apple-info {
        background-color: rgba(0, 113, 227, 0.1);
        color: var(--apple-primary);
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-weight: 500;
        font-size: 12px;
        transition: all 0.2s;
        min-height: 32px;
        display: inline-flex;
        align-items: center;
    }

    .btn-apple-info:hover {
        background-color: var(--apple-primary);
        color: #fff;
    }

    .btn-apple-warning {
        background-color: rgba(255, 159, 10, 0.1);
        color: #d97706;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-weight: 500;
        font-size: 12px;
        transition: all 0.2s;
        min-height: 32px;
        display: inline-flex;
        align-items: center;
    }

    .btn-apple-warning:hover {
        background-color: var(--apple-warning);
        color: #fff;
    }

    .btn-apple-danger {
        background-color: rgba(255, 59, 48, 0.1);
        color: var(--apple-danger);
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-weight: 500;
        font-size: 12px;
        transition: all 0.2s;
        min-height: 32px;
        display: inline-flex;
        align-items: center;
    }

    .btn-apple-danger:hover {
        background-color: var(--apple-danger);
        color: #fff;
    }

    /* 弹窗设计 */
    .apple-modal .modal-dialog {
        width: 420px !important;
        margin: 60px auto;
    }

    .apple-modal .modal-content {
        border: none;
        border-radius: var(--apple-radius-lg);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        overflow: hidden;
    }

    .apple-modal .modal-header {
        background: #fafafa;
        border-bottom: 1px solid var(--apple-border);
        padding: 20px 24px;
    }

    .apple-modal .modal-title {
        font-weight: 600;
        font-size: 16px;
        color: var(--apple-text-main);
    }

    .apple-modal .modal-body {
        padding: 24px;
    }

    .apple-form-group {
        margin-bottom: 18px !important;
    }

    .apple-form-group label {
        font-weight: 500;
        font-size: 13px;
        color: var(--apple-text-main);
        margin-bottom: 8px;
        display: block;
    }

    .apple-input {
        border-radius: var(--apple-radius-sm) !important;
        border: 1px solid var(--apple-border) !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        height: auto !important;
        box-shadow: none !important;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .apple-input:focus {
        border-color: var(--apple-primary) !important;
        box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.12) !important;
    }

    .apple-modal .modal-footer {
        background: #fafafa;
        border-top: 1px solid var(--apple-border);
        padding: 16px 24px;
    }

    .apple-btn-cancel {
        border-radius: var(--apple-radius-sm) !important;
        padding: 8px 16px !important;
        font-size: 13px !important;
    }

    .apple-btn-submit {
        background-color: var(--apple-primary) !important;
        border: none !important;
        border-radius: var(--apple-radius-sm) !important;
        padding: 8px 20px !important;
        font-size: 13px !important;
    }

    /* 移动端自适应与卡片式折叠降级策略（防崩塌核心） */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 12px !important;
        }

        .apple-header-bar {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            padding: 20px 16px;
        }

        .apple-header-actions, .apple-header-actions .btn {
            width: 100%;
        }

        .apple-header-actions .btn {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-body {
            padding: 12px !important;
        }

        /* 隐藏传统表格头 */
        .apple-table thead {
            display: none !important;
        }

        .apple-table, .apple-table tbody, .apple-table tr, .apple-table td {
            display: block !important;
            width: 100% !important;
        }

        /* 每行转化为独立整洁卡片 */
        .apple-table tr {
            background: #ffffff !important;
            margin-bottom: 16px !important;
            border-radius: var(--apple-radius-md) !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04) !important;
            padding: 16px !important;
            border: 1px solid rgba(0,0,0,0.04) !important;
        }

        .apple-table td {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 10px 0 !important;
            border-top: none !important;
            border-bottom: 1px solid rgba(0,0,0,0.03) !important;
            text-align: right !important;
        }

        .apple-table td:last-child {
            border-bottom: none !important;
            padding-top: 14px !important;
        }

        /* 自动生成字段标签指引 */
        .apple-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--apple-text-secondary);
            font-size: 13px;
            text-align: left;
        }

        .action-buttons-cell {
            text-align: right !important;
        }

        .btn-group-custom {
            width: 100%;
            display: flex;
            gap: 8px;
        }

        .btn-group-custom .btn {
            flex: 1;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .apple-modal .modal-dialog {
            width: 92% !important;
            margin: 20px auto !important;
        }
    }
</style>

<script>
    /**
     * 添加帮助信息异步提交方法
     * 完全保留原有参数、接口与提示逻辑
     */
    function addor() {
        var temp = $("form[name='ador']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=sys_help');?>";
        
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
                swal('提示', "网络请求失败，请稍后再试", "error");
            }
        });
    }

    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

        $scope.infos;

        /**
         * 通讯操作保持不变
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
            $scope.commAjax("<?php echo U('Core/infos','model=sys_help');?>", {ids: id}, function (res) {
                $scope.infos = res.data;
                $("#myEdit").modal("show");
            });
        }

        $scope.updateCats = function () {
            var param = $scope.infos;
            param.ids = param.id;
            
            $.ajax({
                url: "<?php echo U('Core/edits','model=sys_help');?>",
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
            $scope.commAjax("<?php echo U('Core/dels','model=sys_help');?>", param, function (res) {
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