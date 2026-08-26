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
                <div class="container-fluid apple-backend-container" ng-app="myApp" ng-controller="myCtrl">
    <!-- 页面头部 -->
    <div class="row">
        <div class="col-lg-12 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>公式计算列表；实时计算</h1>
                    <p class="page-subtitle">高效管理各级材料分类、规格参数及精准执行价计算工具</p>
                </div>
            </div>
        </div>
    </div>

    <section id="main-content">

        <!-- ===== 一级材料管理 ===== -->
        <div class="row apple-row">
            <div class="col-lg-12">
                <div class="apple-card">
                    <div class="section-header">
                        <span class="section-title">一级材料管理</span>
                        <a class="btn btn-xs section-add-btn" ng-click="addForm(0, 0)">+ 添加分类</a>
                    </div>
                    <div class="card-body">
                        <div class="apple-grid">
                            <div ng-repeat="v in cate_list"
                                 ng-class="{'cate-level1-active': selectedL1 == v.id}"
                                 ng-click="selectLevel1(v.id)"
                                 class="apple-cate-item">
                                <span class="cate-index" ng-bind="$index+1"></span>
                                <span class="cate-name" title="{{v.name}}">{{v.name}}</span>
                                <div class="cate-actions">
                                    <a ng-click="updateinfo(v.id);$event.stopPropagation()" class="btn btn-info btn-xs">编辑</a>
                                    <a ng-click="dels(v.id);$event.stopPropagation()" class="btn btn-danger btn-xs">删除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== 二级材料管理 ===== -->
        <div class="row apple-row" ng-show="cate_list_p.length > 0 || selectedL1 > 0">
            <div class="col-lg-12">
                <div class="apple-card">
                    <div class="section-header level-2-header">
                        <span class="section-title">二级材料管理
                            <span ng-if="cate_curr.name" class="sub-title-tag">— {{cate_curr.name}}</span>
                        </span>
                        <a ng-click="addForm(cate_curr.id, 1)" class="btn btn-xs section-add-btn">+ 添加分类</a>
                    </div>
                    <div class="card-body">
                        <div class="apple-grid">
                            <div ng-repeat="v in cate_list_p"
                                 ng-class="{'cate-level2-active': selectedL2 == v.id}"
                                 ng-click="selectLevel2(v.id)"
                                 class="apple-cate-item">
                                <span class="cate-index" ng-bind="$index+1"></span>
                                <span class="cate-name" title="{{v.name}}">{{v.name}}</span>
                                <div class="cate-actions">
                                    <a ng-click="updateinfo(v.id);$event.stopPropagation()" class="btn btn-info btn-xs">编辑</a>
                                    <a ng-click="dels(v.id);$event.stopPropagation()" class="btn btn-danger btn-xs">删除</a>
                                </div>
                            </div>
                            <div ng-if="cate_list_p.length === 0" class="empty-tip">暂无下级分类，点击上方「+ 添加分类」进行创建</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== 三级材料管理 ===== -->
        <div class="row apple-row" ng-show="cate_list_pp.length > 0 || selectedL2 > 0">
            <div class="col-lg-12">
                <div class="apple-card">
                    <div class="section-header level-3-header">
                        <span class="section-title">三级材料管理
                            <span ng-if="selectedL2Name" class="sub-title-tag">— {{selectedL2Name}}</span>
                        </span>
                        <a ng-click="addForm(selectedL2, 2)" class="btn btn-xs section-add-btn">+ 添加分类</a>
                    </div>
                    <div class="card-body">
                        <div class="apple-grid">
                            <div ng-repeat="v in cate_list_pp" id="row-{{v.id}}"
                                 ng-class="{'cate-level3-active': cate_form.id == v.id}"
                                 ng-click="changeShow(v.id)"
                                 class="apple-cate-item">
                                <span class="cate-index" ng-bind="$index+1"></span>
                                <span class="cate-name" title="{{v.name}}">{{v.name}}</span>
                                <div class="cate-actions">
                                    <a ng-click="updateinfo(v.id);$event.stopPropagation()" class="btn btn-info btn-xs">编辑</a>
                                    <a ng-click="dels(v.id);$event.stopPropagation()" class="btn btn-danger btn-xs">删除</a>
                                </div>
                            </div>
                            <div ng-if="cate_list_pp.length === 0" class="empty-tip" style="grid-column: 1 / -1;">暂无三级分类</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== 管理表格与参数配置 ===== -->
        <div class="row apple-row" ng-show="cate_form_visible">
            <div class="col-lg-12">
                <div class="apple-card" id="cate_form_new">
                    <div class="manager-title-banner">
                        <h4 class="manager-title-text" id="cateFormName">{{cate_form.cateFormName}}</h4>
                    </div>
                    <input type="hidden" name="id" ng-model="cate_form.id" id="id" class="form-control" />
                    <div class="modal-body" style="padding: 20px;">
                        
                        <!-- 顶部联动选择与操作按钮栏 -->
                        <div class="table-toolbar">
                            <div class="toolbar-selectors">
                                <div class="selector-item">
                                    <select ng-change="onLabelDirChange()" class="form-control" ng-model="cate_form.label_dir">
                                        <option value="">选择目录</option>
                                        <option value="{{d.id}}" ng-repeat="d in cate_form.directories">{{d.name}}</option>
                                    </select>
                                </div>
                                <div class="selector-item">
                                    <select ng-change="onLabelCatChange()" class="form-control" ng-model="cate_form.label_cat">
                                        <option value="">选择分类</option>
                                        <option value="{{g.cate_label_id}}" ng-repeat="g in cate_form.label_groups">{{g.cat_name}}</option>
                                    </select>
                                </div>
                                <div class="selector-item selector-wide">
                                    <select ng-change="onChangeLabel()" class="form-control" ng-model="cate_form.infos.new_label_id">
                                        <option value="">选择材料</option>
                                        <option value="{{v.id}}" ng-repeat="v in cate_form.label_sub_list">{{v.name}} - ￥{{v.price}}</option>
                                    </select>
                                </div>
                                <div class="price-display-tag" ng-if="cate_form.infos.price">单价: ￥{{cate_form.infos.price}}</div>
                            </div>
                            
                            <div class="toolbar-actions">
                                <a class="btn btn-info btn-xs m-l-6" data-toggle="modal" data-target="#myImport">导入数据</a>
                                <a ng-click="cateFormUpdate()" class="m-l-6 btn btn-info btn-xs">更新数据</a>
                                <a ng-click="cateFormDel()" class="btn btn-danger btn-xs m-l-10">清空表格</a>
                            </div>
                        </div>

                        <!-- 数据表格 -->
                        <div class="table-responsive apple-table-wrapper">
                            <table class="table table-bordered table-hover apple-table">
                                <thead>
                                    <tr>
                                        <th width="60">#序号</th>
                                        <th>材料名称</th>
                                        <th>规格</th>
                                        <th>重量(kg)</th>
                                        <th>单价</th>
                                        <th>基础价</th>
                                        <th>工费电费补偿值</th>
                                        <th>执行价</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="x in cate_form.list">
                                        <td data-label="序号"><span class="badge-number">{{x.number}}</span></td>
                                        <td data-label="材料名称"><input type="text" class="form-control input-sm" value="{{cate_form.cateFormName}}" disabled/></td>
                                        <td data-label="规格"><input type="text" class="form-control input-sm" ng-model="x.name"/></td>
                                        <td data-label="重量(kg)"><input type="text" class="form-control input-sm" ng-model="x.weight"/></td>
                                        <td data-label="单价"><input type="text" class="form-control input-sm" ng-model="x.price" disabled/></td>
                                        <td data-label="基础价"><input type="text" class="form-control input-sm" ng-model="x.calc_base_price" disabled/></td>
                                        <td data-label="工费电费补偿值"><input type="text" class="form-control input-sm highlight-input" ng-model="x.extra_ratio"/></td>
                                        <td data-label="执行价"><input type="text" class="form-control input-sm text-bold-price" value="{{x.end_price}}" disabled/></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- 添加分类弹窗 -->
    <div class="modal fade apple-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content apple-modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加分类</h4>
                </div>
                <div class="modal-body">
                    <form name="ador">
                        <input type="hidden" name="pid" id="pid" class="form-control" />
                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control apple-input" placeholder="请输入分类名称"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary apple-btn-primary" ng-click="addor()">确认添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 更新分类弹窗 -->
    <div class="modal fade apple-modal" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content apple-modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新分类名称</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control apple-input" ng-model="infos.name"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary apple-btn-primary" ng-click="updateCats()">确认更新</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 弹窗式表格备用 -->
    <div class="modal fade apple-modal" id="cateForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg-custom" role="document">
            <div class="modal-content apple-modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{cate_form.cateFormName}}</h4>
                </div>
                <input type="hidden" name="id" ng-model="cate_form.id" id="id" class="form-control" />
                <div class="modal-body">
                     <div class="table-toolbar">
                        <div class="toolbar-selectors">
                            <div class="selector-item">
                                <select ng-change="onLabelDirChange()" class="form-control" ng-model="cate_form.label_dir">
                                    <option value="">选择目录</option>
                                    <option value="{{d.id}}" ng-repeat="d in cate_form.directories">{{d.name}}</option>
                                </select>
                            </div>
                            <div class="selector-item">
                                <select ng-change="onLabelCatChange()" class="form-control" ng-model="cate_form.label_cat">
                                    <option value="">选择分类</option>
                                    <option value="{{g.cate_label_id}}" ng-repeat="g in cate_form.label_groups">{{g.cat_name}}</option>
                                </select>
                            </div>
                            <div class="selector-item selector-wide">
                                <select ng-change="onChangeLabel()" class="form-control" ng-model="cate_form.infos.new_label_id">
                                    <option value="">选择材料</option>
                                    <option value="{{v.id}}" ng-repeat="v in cate_form.label_sub_list">{{v.name}} - ￥{{v.price}}</option>
                                </select>
                            </div>
                            <div class="price-display-tag" ng-if="cate_form.infos.price">单价: ￥{{cate_form.infos.price}}</div>
                        </div>
                        <div class="toolbar-actions">
                            <a class="btn btn-info btn-xs m-l-6" data-toggle="modal" data-target="#myImport">导入数据</a>
                            <a ng-click="cateFormUpdate()" class="m-l-6 btn btn-info btn-xs">更新数据</a>
                            <a ng-click="cateFormDel()" class="btn btn-danger btn-xs m-l-10">清空表格</a>
                        </div>
                    </div>

                   <div class="table-responsive apple-table-wrapper">
                       <table class="table table-bordered table-hover apple-table">
                            <thead>
                                <tr>
                                    <th width="60">#序号</th>
                                    <th>材料名称</th>
                                    <th>规格</th>
                                    <th>重量(kg)</th>
                                    <th>单价</th>
                                    <th>基础价</th>
                                    <th>工费电费补偿值</th>
                                    <th>执行价</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="x in cate_form.list">
                                    <td data-label="序号"><span class="badge-number">{{x.number}}</span></td>
                                    <td data-label="材料名称"><input type="text" class="form-control input-sm" value="{{cate_form.cateFormName}}" disabled/></td>
                                    <td data-label="规格"><input type="text" class="form-control input-sm" ng-model="x.name"/></td>
                                    <td data-label="重量(kg)"><input type="text" class="form-control input-sm" ng-model="x.weight"/></td>
                                    <td data-label="单价"><input type="text" class="form-control input-sm" ng-model="x.price" disabled/></td>
                                    <td data-label="基础价"><input type="text" class="form-control input-sm" ng-model="x.calc_base_price" disabled/></td>
                                    <td data-label="工费电费补偿值"><input type="text" class="form-control input-sm highlight-input" ng-model="x.extra_ratio"/></td>
                                    <td data-label="执行价"><input type="text" class="form-control input-sm text-bold-price" value="{{x.end_price}}" disabled/></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary apple-btn-primary" data-dismiss="modal">确定</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 导入商品数据弹窗 -->
    <div class="modal fade apple-modal" id="myImport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content apple-modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">导入商品数据</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>选择文件</label>
                        <input type="file" name="file" id='file' class="form-control apple-file-input"/>
                    </div>
                    <div class="form-group template-download-box">
                        <a href="//app.elccc.cn/Public/file/计算公式模板.xlsx?v=1" target="_blank" class="template-link">点击下载 Excel 计算公式模板</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default apple-btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary apple-btn-primary" ng-click="cateFormImport()">确认保存并导入</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== 苹果极简商务风基础UI样式 ===== */
    .apple-backend-container {
        background-color: #f5f5f7;
        padding: 24px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: #1d1d1f;
        min-height: 100vh;
        width: 100%;
        box-sizing: border-box;
    }
    
    .page-header {
        margin-bottom: 20px;
    }
    
    .page-title h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1d1d1f;
        margin: 0 0 6px 0;
    }
    
    .page-subtitle {
        font-size: 13px;
        color: #86868b;
        margin: 0;
    }

    .apple-row {
        margin-bottom: 16px;
        width: 100%;
    }

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

    .manager-title-banner {
        background: #f0f4f8;
        border-bottom: 1px solid #e1e8ed;
        padding: 14px 20px;
    }
    .manager-title-text {
        font-size: 16px;
        font-weight: 700;
        color: #0071e3;
        margin: 0;
        letter-spacing: 0.3px;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #2c3e50;
        color: #fff;
        padding: 14px 20px;
        font-weight: 600;
    }
    .level-2-header { background: #2980b9; }
    .level-3-header { background: #57606f; }

    .section-title {
        font-size: 15px;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
    }

    .sub-title-tag {
        font-size: 13px;
        font-weight: normal;
        opacity: 0.85;
        margin-left: 8px;
    }

    .section-add-btn {
        font-size: 12px !important;
        padding: 5px 12px !important;
        height: auto !important;
        border-radius: 6px !important;
        border: 1px solid rgba(255,255,255,0.4) !important;
        background: rgba(255,255,255,0.15) !important;
        color: #fff !important;
        transition: all 0.2s ease;
    }
    .section-add-btn:hover { background: rgba(255,255,255,0.3) !important; }

    .card-body {
        padding: 16px 20px;
    }

    .apple-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 12px;
        width: 100%;
    }

    .apple-cate-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid #e5e5ea;
        background: #fafafc;
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .apple-cate-item:hover {
        background: #f0f0f5;
        border-color: #d1d1d6;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .cate-index {
        font-size: 12px;
        color: #86868b;
        flex-shrink: 0;
        min-width: 18px;
    }

    .cate-name {
        font-size: 13px;
        font-weight: 600;
        color: #1d1d1f;
        flex: 1;
        word-break: break-all;
        white-space: normal;
        line-height: 1.4;
    }

    .cate-actions {
        display: flex;
        gap: 4px;
        flex-shrink: 0;
    }

    .empty-tip {
        color: #86868b;
        font-size: 13px;
        padding: 12px 4px;
    }

    .cate-level1-active {
        background: #2c3e50 !important;
        border-color: #2c3e50 !important;
        box-shadow: 0 4px 12px rgba(44,62,80,0.2);
    }
    .cate-level1-active .cate-name, .cate-level1-active .cate-index { color: #fff !important; }

    .cate-level2-active {
        background: #2980b9 !important;
        border-color: #2980b9 !important;
        box-shadow: 0 4px 12px rgba(41,128,185,0.2);
    }
    .cate-level2-active .cate-name, .cate-level2-active .cate-index { color: #fff !important; }

    .cate-level3-active {
        background: #e1f5fe !important;
        border-color: #0288d1 !important;
        box-shadow: 0 0 0 2px rgba(2,136,209,0.15);
    }

    .table-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
        background: #fbfbfd;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #f0f0f2;
    }

    .toolbar-selectors {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        flex: 1;
    }

    .selector-item {
        width: 150px;
    }

    .selector-wide {
        width: 220px;
    }

    .price-display-tag {
        font-weight: 600;
        color: #0071e3;
        background: #e8f2fc;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
    }

    .toolbar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .apple-table-wrapper {
        border-radius: 12px;
        border: 1px solid #e5e5ea;
        overflow: hidden;
    }

    .apple-table {
        margin-bottom: 0 !important;
        background-color: #ffffff;
        width: 100%;
    }

    .apple-table th {
        background: #fafafc !important;
        color: #1d1d1f !important;
        font-weight: 600 !important;
        border-bottom: 1px solid #e5e5ea !important;
        padding: 12px 14px !important;
    }

    .apple-table td {
        padding: 10px 14px !important;
        vertical-align: middle !important;
        border-color: #f0f0f2 !important;
    }

    .apple-table tbody tr:nth-of-type(odd) {
        background-color: #fbfbfd;
    }

    .apple-table tbody tr:hover {
        background-color: #f5f5f7;
    }

    .form-control.input-sm {
        border-radius: 6px;
        border: 1px solid #d2d2d7;
        box-shadow: none;
        height: 34px;
        transition: all 0.2s;
    }
    .form-control.input-sm:focus {
        border-color: #0071e3;
        box-shadow: 0 0 0 3px rgba(0,113,227,0.15);
    }

    .highlight-input {
        background-color: #fff9e6 !important;
        font-weight: 600;
    }

    .text-bold-price {
        font-weight: 700;
        color: #d35400;
    }

    /* ==========================================
       弹窗专属精细化适配与取消按钮修复（核心）
       ========================================== */
    .apple-modal .modal-dialog {
        max-width: 500px; /* 适当减小弹窗默认最大宽度，解决拉得太长的问题 */
        margin: 30px auto;
    }

    .apple-modal .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        overflow: hidden;
        background: #ffffff;
    }

    .apple-modal .modal-header {
        background: #fafafc;
        border-bottom: 1px solid #e5e5ea;
        padding: 16px 20px;
        flex-shrink: 0;
    }

    .apple-modal .modal-title {
        font-weight: 600;
        color: #1d1d1f;
        font-size: 16px;
    }

    .apple-modal .modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
        max-height: 72vh;
    }

    /* 彻底修复取消按钮不显示、被挤压或溢出的问题 */
    .apple-modal .modal-footer {
        background: #fafafc;
        border-top: 1px solid #e5e5ea;
        padding: 12px 20px;
        flex-shrink: 0;
        display: flex !important;
        align-items: center;
        justify-content: flex-end !important;
        gap: 12px;
        clear: both;
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

    .modal-lg-custom {
        width: 75% !important;
        max-width: 1100px !important;
    }

    /* 移动端专属适配 */
    @media (max-width: 768px) {
        .apple-backend-container {
            padding: 12px;
        }
        
        .apple-grid {
            grid-template-columns: 1fr;
        }

        .apple-cate-item {
            width: 100%;
            box-sizing: border-box;
            padding: 14px 12px;
        }

        .table-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .toolbar-selectors {
            flex-direction: column;
            width: 100%;
        }

        .selector-item, .selector-wide {
            width: 100% !important;
        }

        .toolbar-actions {
            justify-content: flex-end;
        }

        .apple-table, .apple-table thead, .apple-table tbody, .apple-table tr, .apple-table td {
            display: block;
            width: 100%;
        }

        .apple-table thead {
            display: none;
        }

        .apple-table tbody tr {
            background: #ffffff !important;
            border: 1px solid #e5e5ea;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .apple-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0 !important;
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

        .apple-table tbody td input {
            width: 60% !important;
            text-align: right;
        }
        
        .modal-lg-custom {
            width: 95% !important;
            margin: 10px auto !important;
        }

        .apple-modal .modal-dialog {
            width: 90% !important;
            margin: 20px auto !important;
        }
    }
</style>

<script>
    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {
        $scope.cate_form = [];
        $scope.cate_form.infos;
        $scope.cate_form.list = [];
        $scope.cate_form.id = 0;
        $scope.cate_form.cateFormName = "";

        $scope.cate =[];
        $scope.cate.pid = 0;
        $scope.cate_list = [];

        $scope.cate_curr = [];
        $scope.cate_list_p = [];

        $scope.three_cate_curr_id = [];
        $scope.cate_list_pp = [];

        // 三级选中状态
        $scope.selectedL1 = 0;
        $scope.selectedL2 = 0;
        $scope.cate_form_visible = false;

        // 点击一级：加载二级，清空三级和管理表格
        $scope.selectLevel1 = function(id) {
            $scope.selectedL1 = id;
            $scope.selectedL2 = 0;
            $scope.cate_form_visible = false;
            $scope.cate_list_pp = [];
            $scope.cate.pid = id;
            $scope.changeCate();
        };

        // 点击二级：加载三级，清空管理表格
        $scope.selectedL2Name = '';
        $scope.selectLevel2 = function(id) {
            $scope.selectedL2 = id;
            $scope.cate_form_visible = false;
            var found = ($scope.cate_list_p || []).find(function(v){ return v.id == id; });
            $scope.selectedL2Name = found ? found.name : '';
            $scope.changeCateFirst2(id);
        };

        /**
         * 添加分类提交
         */
        $scope.addor = function() {
            var temp = $("form[name='ador']").serializeArray();
            var data = objToArray(temp);
            var baseurl = "<?php echo U('NewCate/add','model=new_cate');?>";
            
            $.ajax({
                url: baseurl,
                type: "post",
                data: data,
                dataType: "json",
                success: function (res) {
                    if (res.status != 1) {
                        return swal('提示', res.msg, "error");
                    } else {
                        $("#myModal").modal("hide");
                        var level = $scope._addLevel;
                        if (level === 0) {
                            $scope.changeCateFirst();
                        } else if (level === 1) {
                            $scope.changeCate();
                        } else {
                            $scope.changeCateFirst2($scope.selectedL2);
                        }
                        $scope.$apply();
                    }
                },
                error: function () {},
            });
        }

        $scope._addLevel = 0;
        $scope.addForm = function(id, level) {
            $scope._addLevel = level || 0;
            $("form[name='ador']")[0].reset();
            $('#pid').val(id);
            $("#myModal").modal("show");
        }

        /**
         * 通讯操作封装
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

        $scope.changeCateFirst = function () {
            var param = {id: 0};
            $scope.commAjax("<?php echo U('NewCate/ajaxCateFirst');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                if (res.data.cate_list != null && res.data.cate_list.length > 0) {
                    $scope.cate_list = res.data.cate_list;
                    $scope.selectLevel1($scope.cate_list[0].id);
                } else {
                    $scope.cate_list = [];
                }
            });
        };
        
        $scope.changeCateFirst2 = function (id) {
            $scope.three_cate_curr_id = id;
            var param = {id: $scope.three_cate_curr_id};
            $scope.commAjax("<?php echo U('NewCate/ajaxCateFirst2');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                if (res.data.cate_list != null) {
                    $scope.cate_list_pp = res.data.cate_list;
                    $scope.cate_form_visible = false;
                } 
            });
        };
         
        $scope.changeCate = function () {
            var param = {id: $scope.cate.pid};
            $scope.commAjax("<?php echo U('NewCate/ajaxCate');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                if (res.data.info != null) {
                    $scope.cate_curr = res.data.info;
                    $scope.cate_list_p = res.data.cate_list_p;
                } else {
                    $scope.cate_curr = [];
                    $scope.cate_list_p = [];
                }
            });
        };
         
        $scope.changeShow = function (index) {
            $scope.cate_form.id = index;
            $scope.cate_form_visible = true;
            $scope.init();
        };
        
        $scope.buildLabelGroups = function(labelList, dirId) {
            var seen = {}, groups = [];
            (labelList || []).forEach(function(item) {
                if (dirId && String(item.dir_id) !== String(dirId)) return;
                var catId = item.cate_label_id;
                if (!seen[catId]) {
                    seen[catId] = true;
                    groups.push({ cate_label_id: catId, cat_name: item.cat_name || ('分类' + catId) });
                }
            });
            return groups;
        };

        $scope.onLabelDirChange = function() {
            var dirId = $scope.cate_form.label_dir;
            $scope.cate_form.label_groups = $scope.buildLabelGroups($scope.cate_form.label_list, dirId);
            $scope.cate_form.label_cat = '';
            $scope.cate_form.label_sub_list = [];
            $scope.cate_form.infos.new_label_id = '';
        };

        $scope.onLabelCatChange = function() {
            var catId = $scope.cate_form.label_cat;
            $scope.cate_form.label_sub_list = ($scope.cate_form.label_list || []).filter(function(item) {
                return String(item.cate_label_id) === String(catId);
            });
            $scope.cate_form.infos.new_label_id = '';
        };

        $scope.restoreLabelCat = function() {
            var curId = $scope.cate_form.infos.new_label_id;
            if (!curId) return;
            var found = ($scope.cate_form.label_list || []).find(function(item) {
                return String(item.id) === String(curId);
            });
            if (found) {
                $scope.cate_form.label_dir = found.dir_id ? String(found.dir_id) : '';
                $scope.cate_form.label_groups = $scope.buildLabelGroups($scope.cate_form.label_list, found.dir_id);
                $scope.cate_form.label_cat = String(found.cate_label_id);
                $scope.cate_form.label_sub_list = ($scope.cate_form.label_list || []).filter(function(item) {
                    return String(item.cate_label_id) === String(found.cate_label_id);
                });
            }
        };

        $scope.init = function () {
            var param = {id: $scope.cate_form.id};
            $scope.commAjax("<?php echo U('NewCate/cate_form');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.cate_form.infos = res.data.info;
                $scope.cate_form.label_list = res.data.label_list || [];
                $scope.cate_form.directories = res.data.directories || [];
                $scope.cate_form.label_dir = '';
                $scope.cate_form.label_groups = [];
                $scope.cate_form.label_sub_list = [];
                $scope.cate_form.cateFormName = res.data.info.name;
                $scope.restoreLabelCat();
                if (res.data.info != null) {
                    $scope.cate_form.list = res.data.list;
                } else {
                    $scope.cate_form.list = [];
                }
            });
        };
        
        $scope.cateUpate = function () {
            var param = $scope.cate_form.infos;
            $scope.commAjax("<?php echo U('NewCate/cate_update');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
            });
        };

        $scope.cateFormImport = function () {
            var param = $scope.cate_form.infos;
            layer.load(2);
            $.ajaxFileUpload({
                url: "<?php echo U('NewCate/cate_form_import');?>",
                secureuri: false,
                fileElementId: "file",
                dataType: 'json',
                data: param,
                success: function (data) {
                    layer.closeAll();
                    if (data.status !== 1) {
                        return swal("错误", data.msg, "error");
                    }
                    $("#myImport").modal("hide");
                    $scope.init();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        };

        $scope.cateFormUpdate = function () {
            var info = $scope.cate_form.infos;
            layer.load(2);
            var param = {
                info: JSON.stringify(info),
                form: JSON.stringify($scope.cate_form.list),
            };
            $scope.commAjax("<?php echo U('NewCate/cate_form_update');?>", param, function (res) {
                layer.closeAll('loading');
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                return $scope.init();
            });
        };

        $scope.cateFormDel = function () {
            var param = $scope.cate_form.infos;
            $scope.commAjax("<?php echo U('NewCate/cate_form_del');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
            });
        };
        
        $scope.$watch('cate_form.infos.new_label_id', function(newVal, oldVal) {
            if(newVal != oldVal && newVal > 0){
                $scope.cateUpate();
            }
        });

        $scope.updateinfo = function (id) {
            $scope.commAjax("<?php echo U('NewCate/editGet','model=new_cate');?>", {id: id}, function (res) {
                $scope.infos = res.data;
                $("#myEdit").modal("show");
            });
        }

        $scope.updateCats = function () {
            var param = $scope.infos;
            param.ids = param.id;
            $.ajax({
                url: "<?php echo U('NewCate/edit','model=new_cate');?>",
                type: "post",
                dataType: 'json',
                data: param,
                success: function (data) {
                    if (data.status !== 1) {
                        return swal("错误", data.msg, "error");
                    } else {
                        $("#myEdit", "#cateForm").modal("hide");
                        $scope.changeCateFirst2($scope.three_cate_curr_id);
                        $scope.changeCate(); 
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        $scope.dels = function (ids) {
            var param = {id: ids};
            $scope.commAjax("<?php echo U('NewCate/cate_del');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                } else {
                    $("#myModal").modal("hide");
                    $scope.changeCateFirst2($scope.three_cate_curr_id);
                    $scope.changeCate(); 
                }
            });
        };

        $scope.changeCateFirst();
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