<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>易缆管理中心</title>
        <!-- ================= Favicon ================== -->
        <!-- Styles -->
        <link href="/Public/assets/css/lib/font-awesome.min.css" rel="stylesheet">
        <link href="/Public/assets/css/lib/themify-icons.css" rel="stylesheet">
        <link href="/Public/assets/css/lib/menubar/sidebar.css" rel="stylesheet">
        <link href="/Public/assets/css/lib/bootstrap.min.css" rel="stylesheet">
        <link href="/Public/assets/css/lib/unix.css" rel="stylesheet">
        <link href="/Public/assets/css/style.css" rel="stylesheet">
        <!-- jquery vendor -->
        <script src="/Public/assets/js/lib/jquery.min.js"></script>
        <script src="/Public/assets/js/lib/jquery.nanoscroller.min.js"></script>
        <script src="/Public/assets/js/lib/bootstrap.min.js"></script>
        <!-- Angularjs -->
        <script src="/Public/libs/angular/angular.min.js"></script>

        <!-- sweetalert -->
        <link href="/Public/libs/sweet-alert2/sweetalert2.min.css" rel="stylesheet">
        <script src="/Public/libs/sweet-alert2/sweetalert2.min.js"></script>

        <!----->
        <link href="/Public/libs/swiper/css/swiper.min.css" rel="stylesheet">
        <script src="/Public/libs/swiper/js/swiper.min.js"></script>

        <script src="/Public/libs/layer/layer.js"></script>
        <script src="/Public/libs/common.js"></script>
        <script src="/Public/libs/ajaxfileupload.js?v=3"></script>
        <style>
            .table{
                font-size:12px;
            }
            .none{
                display:none!important;
            }
            .sidebar .nano-content > ul li > a{
                padding: 8px 20px;
            }
        </style>
    </head>

    <body>

        <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                    <ul>
                        <li class="label">管理功能</li>
                        <li><a href="<?php echo U('Bords/index');?>"><i class="ti-home"></i> 概览</a></li>
                        <li class="active open">
                            <a class="sidebar-sub-toggle">
                                <i class="ti-harddrives"></i> 用户管理 <span class="sidebar-collapse-icon ti-angle-down"></span>
                            </a>
                            <ul>
                                <li><a href="<?php echo U('Users/index');?>">注册用户</a></li>
                                <li><a href="<?php echo U('Users/logrs');?>">登录统计</a></li>
                                <li><a href="<?php echo U('Users/search');?>">搜索记录</a></li>
                                <!--li><a href="<?php echo U('Users/label');?>">禁止区域</a></li-->
                                <li><a href="<?php echo U('Users/levels');?>">用户等级</a></li>
                                <!--li><a href="<?php echo U('Users/cnlogs');?>">账户操作记录</a></li-->
                                <li><a href="<?php echo U('Users/mess');?>">消息管理</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo U('Task/index');?>"><i class="ti-harddrives"></i> 材料价格任务执行更新</a></li>
                        <li><a href="<?php echo U('NewLabel/index');?>"><i class="ti-harddrives"></i> 材料价格分类</a></li>
                        <li><a href="<?php echo U('NewCate/index');?>"><i class="ti-harddrives"></i> 公式计算</a></li>
                        <li><a href="<?php echo U('NewTax/index');?>"><i class="ti-harddrives"></i> 税率标签</a></li>
                        <!--<li><a href="<?php echo U('Goods/cats_exc');?>"><i class="ti-harddrives"></i> 材料标签</a></li>-->
                        <li><a href="<?php echo U('Goods/cats');?>"><i class="ti-harddrives"></i> 商品分类</a></li>
                        <!--li><a href="<?php echo U('Goods/tmps');?>"><i class="ti-harddrives"></i> 商品模板</a></li-->
                        <li><a href="<?php echo U('Goods/liner');?>"><i class="ti-harddrives"></i> 线缆板块</a></li>
                        <li><a href="<?php echo U('Goods/peita');?>"><i class="ti-harddrives"></i> 配套板块</a></li>
                        <li><a href="<?php echo U('Shops/index');?>"><i class="ti-harddrives"></i> 店铺管理</a></li>
                        <li><a href="<?php echo U('Order/index');?>"><i class="ti-harddrives"></i> 订单管理</a></li>
                        <!--li><a href="<?php echo U('Shops/buyer');?>"><i class="ti-harddrives"></i> 采购管理</a></li>
                        <li><a href="<?php echo U('Shops/recyle');?>"><i class="ti-harddrives"></i> 回收管理</a></li-->
                        <!--<li><a href="<?php echo U('Trans/citys');?>"><i class="ti-harddrives"></i> 物流板块</a></li>-->
                        <!--li>
                            <a class="sidebar-sub-toggle">
                                <i class="ti-harddrives"></i> 知识板块 <span class="sidebar-collapse-icon ti-angle-down"></span>
                            </a>
                            <ul>
                                <li><a href="<?php echo U('Know/cats');?>">知识分类</a></li>
                                <li><a href="<?php echo U('Know/index');?>">知识文章</a></li>
                            </ul>
                        </li-->
                        <li><a href="<?php echo U('Know/advs');?>"><i class="ti-harddrives"></i> 广告管理</a></li>
                        <li><a href="<?php echo U('Know/helps');?>"><i class="ti-harddrives"></i> 帮助中心</a></li>
                        <li><a href="<?php echo U('Know/sysc');?>"><i class="ti-harddrives"></i> 系统文本</a></li>
                        <li><a href="<?php echo U('Sysc/banks');?>"><i class="ti-harddrives"></i> 银行卡号</a></li>
                        <li><a href="<?php echo U('Version/index');?>"><i class="ti-harddrives"></i> 系统版本</a></li>
                        <li><a href="<?php echo U('Bar/index');?>"><i class="ti-harddrives"></i> tab栏控制</a></li>
                         <li><a href="<?php echo U('ReportInfo/index');?>"><i class="ti-harddrives"></i>报价单管理</a></li>
                         <!--<li><a href="<?php echo U('Config/customer_config');?>"><i class="ti-harddrives"></i>客服配置</a></li>-->

                        <li><a href="<?php echo U('Index/index');?>"><i class="ti-close"></i> 退出登录</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /# sidebar -->

        <div class="header">
            <div class="pull-left">
                <div class="logo"><a href="<?php echo U('Bords/index');?>"><span>易缆管理中心</span></a></div>
            </div>

            <div class="pull-right p-r-15">
                <ul>

                    <li class="header-icon dib">
                        <img class="avatar-img" src="/Public/assets/images/avatar/1.jpg" alt="" />
                        <span class="user-avatar">管理员 <i class="ti-angle-down f-s-10"></i></span>

                        <div class="drop-down dropdown-profile">
                            <div class="dropdown-content-body">
                                <ul>
                                    <li><a href="javascript:;"><i class="ti-user"></i> <span>密码管理</span></a></li>
                                    <li><a href="<?php echo U('Index/index');?>"><i class="ti-power-off"></i> <span>退出登录</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>




        <div class="content-wrap">
            <div class="main">

                <div class="container-fluid" ng-app="myApp" ng-controller="myCtrl">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>公式计算</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <!--<div class="col-lg-4 p-l-0 title-margin-left">-->
        <!--    <div class="page-header">-->
        <!--        <div class="page-title">-->
                    
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!-- /# column -->
    </div>
    <!-- /# row -->
    <section id="main-content">

        <!-- ===== 一级材料管理 ===== -->
        <div class="row" style="margin-bottom:14px;">
            <div class="col-lg-12">
                <div class="card alert" style="width:100%;margin-bottom:0;">
                    <div class="section-header" style="background:#2c3e50;">
                        <span class="section-title">一级材料管理</span>
                        <a class="btn btn-xs section-add-btn" ng-click="addForm(0, 0)">+ 添加分类</a>
                    </div>
                    <div class="card-body" style="padding:12px 16px;">
                        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:8px 8px;row-gap:20px;">
                            <div ng-repeat="v in cate_list"
                                 ng-class="{'cate-level1-active': selectedL1 == v.id}"
                                 ng-click="selectLevel1(v.id)"
                                 style="display:flex;align-items:center;gap:8px;padding:6px 12px;border-radius:4px;border:1px solid #dce3ea;background:#f8f9fa;cursor:pointer;user-select:none;min-width:0;">
                                <span style="font-size:11px;color:#aaa;flex-shrink:0;min-width:16px;" ng-bind="$index+1"></span>
                                <span style="font-size:13px;font-weight:bold;color:#333;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{v.name}}</span>
                                <a ng-click="updateinfo(v.id);$event.stopPropagation()" class="btn btn-info btn-xs" style="flex-shrink:0;">编辑</a>
                                <a ng-click="dels(v.id);$event.stopPropagation()" class="btn btn-danger btn-xs" style="flex-shrink:0;">删除</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== 二级材料管理 ===== -->
        <div class="row" style="margin-bottom:14px;" ng-show="cate_list_p.length > 0 || selectedL1 > 0">
            <div class="col-lg-12">
                <div class="card alert" style="width:100%;margin-bottom:0;">
                    <div class="section-header" style="background:#2980b9;">
                        <span class="section-title">二级材料管理
                            <span ng-if="cate_curr.name" style="font-size:12px;font-weight:normal;opacity:0.8;margin-left:8px;">— {{cate_curr.name}}</span>
                        </span>
                        <a ng-click="addForm(cate_curr.id, 1)" class="btn btn-xs section-add-btn">+ 添加分类</a>
                    </div>
                    <div class="card-body" style="padding:12px 16px;">
                        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:8px 8px;row-gap:20px;">
                            <div ng-repeat="v in cate_list_p"
                                 ng-class="{'cate-level2-active': selectedL2 == v.id}"
                                 ng-click="selectLevel2(v.id)"
                                 style="display:flex;align-items:center;gap:8px;padding:6px 12px;border-radius:4px;border:1px solid #dce3ea;background:#f8f9fa;cursor:pointer;user-select:none;min-width:0;">
                                <span style="font-size:11px;color:#aaa;flex-shrink:0;min-width:16px;" ng-bind="$index+1"></span>
                                <span style="font-size:13px;font-weight:bold;color:#333;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{v.name}}</span>
                                <a ng-click="updateinfo(v.id);$event.stopPropagation()" class="btn btn-info btn-xs" style="flex-shrink:0;">编辑</a>

                                <a ng-click="dels(v.id);$event.stopPropagation()" class="btn btn-danger btn-xs" style="flex-shrink:0;">删除</a>
                            </div>
                            <div ng-if="cate_list_p.length === 0" style="color:#aaa;font-size:12px;padding:4px;">暂无下级，点击「+ 添加下级」</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== 三级材料管理 ===== -->
        <div class="row" style="margin-bottom:14px;" ng-show="cate_list_pp.length > 0 || selectedL2 > 0">
            <div class="col-lg-12">
                <div class="card alert" style="width:100%;margin-bottom:0;">
                    <div class="section-header" style="background:#7f8c8d;">
                        <span class="section-title">三级材料管理
                            <span ng-if="selectedL2Name" style="font-size:12px;font-weight:normal;opacity:0.8;margin-left:8px;">— {{selectedL2Name}}</span>
                        </span>
                        <a ng-click="addForm(selectedL2, 2)" class="btn btn-xs section-add-btn">+ 添加分类</a>
                    </div>
                    <div class="card-body" style="padding:12px 16px;">
                        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:8px 8px;row-gap:20px;">
                            <div ng-repeat="v in cate_list_pp" id="row-{{v.id}}"
                                 ng-class="{'cate-level3-active': cate_form.id == v.id}"
                                 ng-click="changeShow(v.id)"
                                 style="display:flex;align-items:center;gap:6px;padding:6px 8px;border:1px solid #dce3ea;border-radius:4px;background:#f8f9fa;cursor:pointer;min-width:0;">
                                <span style="font-size:11px;color:#aaa;flex-shrink:0;min-width:16px;" ng-bind="$index+1"></span>
                                <span style="font-size:13px;font-weight:bold;color:#333;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{v.name}}</span>
                                <a ng-click="updateinfo(v.id);$event.stopPropagation()" class="btn btn-info btn-xs" style="flex-shrink:0;">编辑</a>
                                <a ng-click="dels(v.id);$event.stopPropagation()" class="btn btn-danger btn-xs" style="flex-shrink:0;">删除</a>
                            </div>
                            <div ng-if="cate_list_pp.length === 0" style="color:#aaa;font-size:12px;padding:4px;grid-column:1/-1;">暂无三级分类</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== 管理表格 ===== -->
        <div class="row" ng-show="cate_form_visible">
            <div class="col-lg-12">
                <div class="card alert" style="width:100%;margin-bottom:0;" id="cate_form_new">
                               
                    <div class="modal-content">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                    <h4 class="modal-title" id="cateFormName">{{cate_form.cateFormName}}</h4>
                </div>
                  <input type="hidden" name="id" ng-model="cate_form.id" id="id" class="form-control" />
                <div class="modal-body">
                    
                     <h5 class="p-b-5" style="display:flex;justify-content:space-between">
                         <div style="display:flex;align-items:center">
                            <a style="display:flex;align-items:center;gap:8px;">
                               
                                <div style="width:150px;">
                                    <select ng-change="onLabelDirChange()" class="form-control" ng-model="cate_form.label_dir">
                                        <option value="">选择目录</option>
                                        <option value="{{d.id}}" ng-repeat="d in cate_form.directories">{{d.name}}</option>
                                    </select>
                                </div>
                                <div style="width:150px;">
                                    <select ng-change="onLabelCatChange()" class="form-control" ng-model="cate_form.label_cat">
                                        <option value="">选择分类</option>
                                        <option value="{{g.cate_label_id}}" ng-repeat="g in cate_form.label_groups">{{g.cat_name}}</option>
                                    </select>
                                </div>
                                <div style="width:200px;">
                                    <select ng-change="onChangeLabel()" class="form-control" ng-model="cate_form.infos.new_label_id">
                                        <option value="">选择材料</option>
                                        <option value="{{v.id}}" ng-repeat="v in cate_form.label_sub_list">{{v.name}} - {{v.price}}</option>
                                    </select>
                                </div>
                            </a>
                         <div style="margin-left:20px;display:flex;">{{cate_form.infos.price}}</div>
                         
                        </div>
                        
                          <div style="display:flex;align-items:center;">
                              
                              <a class="btn btn-info btn-xs m-l-6 pull-right" data-toggle="modal" data-target="#myImport">导入数据</a>
                              <a ng-click="cateFormUpdate()" class="m-l-6 btn btn-info btn-xs pull-right">更新数据</a>
                              <a ng-click="cateFormDel()" class="btn btn-danger btn-xs m-l-10 pull-right">清空表格</a>
                            
                            <!--<a ng-click="addGoodsPre()" class="btn btn-info btn-xs pull-right m-r-10">添加商品</a>-->
                            
                          </div>
                            
                
                        </h5>

                   <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td width="50">#序号</td>
                                    <td>材料名称</td>
                                    <td>规格</td>
                                    <td>重量(kg)</td>
                                    <td>单价</td>
                                    <td>基础价</td>
                                    <td>工费电费补偿值</td>
                                    <td>执行价</td>
                            
                                </tr>
                            </thead>
                            <tbody>

                                <tr ng-repeat=" x in cate_form.list">
                                    <td>{{x.number}}</td>
                                    <td><input type="text" class="form-control input-sm" value="{{cate_form.cateFormName}}" disabled/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.name"/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.weight"/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.price" disabled/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.calc_base_price" disabled/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.extra_ratio"/></td>
                                    <td><input type="text" class="form-control input-sm" value="{{x.end_price}}" disabled/></td>
                                 
                                    
                                </tr>

                            </tbody>
                        </table>

                    

                </div>
            </div>
                </div><!-- /.card.alert -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加</h4>
                </div>
                <div class="modal-body">

                    <form name="ador">
                          <!--<input type="" name="pid" id="pid" class="form-control" />-->
                           <input type="hidden" name="pid" id="pid" class="form-control" />
                          
                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control"/>
                        </div>
                       
                        <!--<div class="form-group">-->
                        <!--    <label>状态</label>-->
                        <!--    <select name="status" class="form-control">-->
                        <!--        <option value="1">使用</option>-->
                        <!--        <option value="0">暂停</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="addor()">添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新</h4>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control" ng-model="infos.name"/>
                        </div>
                        
                        <!--<div class="form-group">-->
                        <!--    <label>状态</label>-->
                        <!--    <select name="status" class="form-control" ng-model="infos.status">-->
                        <!--        <option value="1">使用</option>-->
                        <!--        <option value="0">暂停</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateCats()">更新</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="cateForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:70%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="cateFormName">{{cate_form.cateFormName}}</h4>
                </div>
                  <input type="hidden" name="id" ng-model="cate_form.id" id="id" class="form-control" />
                <div class="modal-body">
                    
                     <h5 class="p-b-5" style="display:flex;justify-content:space-between">
                         <div style="display:flex;align-items:center">
                            <a style="display:flex;align-items:center;gap:8px;">
                                <div style="width:150px;">
                                    <div style="width:150px;">
                                        <select ng-change="onLabelDirChange()" class="form-control" ng-model="cate_form.label_dir">
                                            <option value="">选择目录</option>
                                            <option value="{{d.id}}" ng-repeat="d in cate_form.directories">{{d.name}}</option>
                                        </select>
                                    </div>
                                    <div style="width:150px;">
                                        <select ng-change="onLabelCatChange()" class="form-control" ng-model="cate_form.label_cat">
                                            <option value="">选择分类</option>
                                            <option value="{{g.cate_label_id}}" ng-repeat="g in cate_form.label_groups">{{g.cat_name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="width:200px;">
                                    <select ng-change="onChangeLabel()" class="form-control" ng-model="cate_form.infos.new_label_id">
                                        <option value="">选择材料</option>
                                        <option value="{{v.id}}" ng-repeat="v in cate_form.label_sub_list">{{v.name}} - {{v.price}}</option>
                                    </select>
                                </div>
                            </a>
                         <div style="margin-left:20px;display:flex;">{{cate_form.infos.price}}</div>
                         
                        </div>
                        
                          <div style="display:flex;align-items:center;">
                              
                              <a class="btn btn-info btn-xs m-l-6 pull-right" data-toggle="modal" data-target="#myImport">导入数据</a>
                              <a ng-click="cateFormUpdate()" class="m-l-6 btn btn-info btn-xs pull-right">更新数据</a>
                              <a ng-click="cateFormDel()" class="btn btn-danger btn-xs m-l-10 pull-right">清空表格</a>
                            
                            <!--<a ng-click="addGoodsPre()" class="btn btn-info btn-xs pull-right m-r-10">添加商品</a>-->
                            
                          </div>
                            
                
                        </h5>

                   <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td width="50">#序号</td>
                                    <td>材料名称</td>
                                    <td>规格</td>
                                    <td>重量(kg)</td>
                                    <td>单价</td>
                                    <td>基础价</td>
                                    <td>工费电费补偿值</td>
                                    <td>执行价</td>
                            
                                </tr>
                            </thead>
                            <tbody>

                                <tr ng-repeat=" x in cate_form.list">
                                    <td>{{x.number}}</td>
                                    <td><input type="text" class="form-control input-sm" value="{{cate_form.cateFormName}}" disabled/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.name"/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.weight"/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.price" disabled/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.calc_base_price" disabled/></td>
                                    <td><input type="text" class="form-control input-sm" ng-model="x.extra_ratio"/></td>
                                    <td><input type="text" class="form-control input-sm" value="{{x.end_price}}" disabled/></td>
                                 
                                    
                                </tr>

                            </tbody>
                        </table>

                    

                </div>
                
            </div>
        </div>
    </div>
    
    <!-- 导入商品-->
    <div class="modal fade" id="myImport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">导入商品数据</h4>
                </div>
                <div class="modal-body">


                    <div class="form-group">
                        <label>文件</label>
                        <input type="file" name="file" id='file' class="form-control"/>
                    </div>
                    <div class="form-group">
                        <!--<label>下载模板</label>-->
                        <a href="//app.elccc.cn/Public/file/计算公式模板.xlsx?v=1">点击下载模板</a>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="cateFormImport()">保存</button>
                </div>
            </div>
        </div>
    </div>
    
    

</div>

<style>
    .highlight { background-color: yellow; }

    /* ===== section 样式（同 NewLabel）===== */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #333;
        color: #fff;
        padding: 8px 14px;
        border-radius: 3px 3px 0 0;
    }
    .section-title {
        font-size: 14px;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .section-add-btn {
        font-size: 12px !important;
        padding: 3px 10px !important;
        height: auto !important;
        border: 1px solid rgba(255,255,255,0.4) !important;
        background: rgba(255,255,255,0.15) !important;
        color: #fff !important;
    }
    .section-add-btn:hover { background: rgba(255,255,255,0.28) !important; }
    .section-add-btn-danger {
        background: rgba(220,53,69,0.7) !important;
        border-color: rgba(220,53,69,0.9) !important;
    }

    /* 三级选中高亮 */
    .cate-level1-active {
        background: #2c3e50 !important;
        border-color: #2c3e50 !important;
    }
    .cate-level1-active span { color: #fff !important; }

    .cate-level2-active {
        background: #2980b9 !important;
        border-color: #2980b9 !important;
    }
    .cate-level2-active span { color: #fff !important; }

    .cate-level3-active {
        background: #eaf3fd !important;
        border-color: #2980b9 !important;
        box-shadow: 0 0 0 2px rgba(41,128,185,0.2);
    }
</style>



<script>
 
// $(document).on('show.bs.modal', '#cateForm', function (event) {
//     console.log(111);
//   // 获取触发元素，即打开模态框的按钮
//   var button = $(event.relatedTarget);
//   // 获取传递的自定义参数
//   var id = button.data('id');
//   var name = button.data('name');
//   console.log(id);
//   console.log(name);
//   // 设置模态框内容
//   var modal = $(this);

//   modal.find('#id').val(id);
//   modal.find('#cateFormName').text(name);
// });

// $(document).on('show.bs.modal', '#myModal', function (event) {
//     console.log(32);
//   // 获取触发元素，即打开模态框的按钮
//   var button = $(event.relatedTarget);
//   // 获取传递的自定义参数
//   var param = button.data('my-pid');
//   // 设置模态框内容
//   var modal = $(this);
//   console.log(param);
//   modal.find('#pid').val(param);
//   $scope.init();
// });


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
        ////////////////////////////////////////////////////////////////////////
        
            /**
     * 添加
     * @returns {undefined}
     */
    $scope.addor = function() {
        var temp = $("form[name='ador']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('NewCate/add','model=new_cate');?>";
        // data.pid =  $scope.cate.pid;
        //////
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
                        $scope.changeCateFirst();          // 刷新一级列表
                    } else if (level === 1) {
                        $scope.changeCate();               // 刷新二级列表
                    } else {
                        $scope.changeCateFirst2($scope.selectedL2);  // 刷新三级列表
                    }
                    $scope.$apply();
                }
                // alert(33);
                // window.location.reload();
            },
            error: function () {

            },
        });
    }

// $(document).on('show.bs.modal', '#myModal', function (event) {
//     console.log(32);
//   // 获取触发元素，即打开模态框的按钮
//   var button = $(event.relatedTarget);
//   // 获取传递的自定义参数
//   var param = button.data('my-pid');
//   // 设置模态框内容
//   var modal = $(this);
//   console.log(param);
//   modal.find('#pid').val(param);
//   $scope.init();
// });

$scope._addLevel = 0;  // 0=一级 1=二级 2=三级
$scope.addForm = function(id, level) {
    $scope._addLevel = level || 0;
    $("form[name='ador']")[0].reset();
    $('#pid').val(id);
    $("#myModal").modal("show");
}
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
        $scope.changeCateFirst = function () {
            var param = {id: 0};
            $scope.commAjax("<?php echo U('NewCate/ajaxCateFirst');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                if (res.data.cate_list != null && res.data.cate_list.length > 0) {
                    $scope.cate_list = res.data.cate_list;
                    // 首次自动选中第一个
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
            //////
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
        
        // 从 label_list 按 cate_label_id 分组，提取分类列表（可按 dir_id 过滤）
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

        // 一级：目录切换时过滤分类列表
        $scope.onLabelDirChange = function() {
            var dirId = $scope.cate_form.label_dir;
            $scope.cate_form.label_groups    = $scope.buildLabelGroups($scope.cate_form.label_list, dirId);
            $scope.cate_form.label_cat       = '';
            $scope.cate_form.label_sub_list  = [];
            $scope.cate_form.infos.new_label_id = '';
        };

        // 二级：分类切换时过滤材料列表
        $scope.onLabelCatChange = function() {
            var catId = $scope.cate_form.label_cat;
            $scope.cate_form.label_sub_list = ($scope.cate_form.label_list || []).filter(function(item) {
                return String(item.cate_label_id) === String(catId);
            });
            $scope.cate_form.infos.new_label_id = '';
        };

        // 编辑回显：根据 new_label_id 反查并恢复目录→分类→材料三级联动
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
            //////
            $scope.commAjax("<?php echo U('NewCate/cate_form');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.cate_form.infos = res.data.info;
                $scope.cate_form.label_list = res.data.label_list || [];
                $scope.cate_form.directories = res.data.directories || [];
                $scope.cate_form.label_dir   = '';
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
        
        //切换更新
        $scope.cateUpate = function () {
            var param = $scope.cate_form.infos;
            //////
            $scope.commAjax("<?php echo U('NewCate/cate_update');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
            });
        };
        //导入更新
        $scope.cateFormImport = function () {
            var param = $scope.cate_form.infos;
          
            layer.load(2);
            /////////
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
        //点击提交更新
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
                //return swal("提示", "更新成功", "success");
            });
            
            
        };
        //删除
        $scope.cateFormDel = function () {
            var param = $scope.cate_form.infos;
            //////
            $scope.commAjax("<?php echo U('NewCate/cate_form_del');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
            });
        };
        
        //监听切换
    $scope.$watch('cate_form.infos.new_label_id', function(newVal,oldVal) {
        console.log(2233);
         console.log(oldVal);
        console.log(newVal);

      if(newVal != oldVal && newVal > 0){
            
          $scope.cateUpate();
        }
    
  });
  
        // $scope.onChangeLabel = function() {
        //     var newVal = $scope.cate_form.infos.new_label_id;
        //     if (newVal && newVal != 0) {
        //         $scope.cateUpate();
        //     }
        // };
 

        ////////////////////////////////////////////////////////////////////////

        $scope.updateinfo = function (id) {
            $scope.commAjax("<?php echo U('NewCate/editGet','model=new_cate');?>", {id: id}, function (res) {
                $scope.infos = res.data;
                $("#myEdit").modal("show");
            });
        }

        $scope.updateCats = function () {
            var param = $scope.infos;
            param.ids = param.id;
            /////////
            $.ajax({
                url: "<?php echo U('NewCate/edit','model=new_cate');?>",
                type: "post",
                dataType: 'json',
                data: param,
                success: function (data) {
                    if (data.status !== 1) {
                        return swal("错误", data.msg, "error");
                    }else{
                    $("#myEdit").modal("hide");
                      $scope.changeCateFirst2($scope.three_cate_curr_id);
                    $scope.changeCate(); 
                }
                    
                    // window.location.reload();
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
                }else{
                    $("#myModal").modal("hide");
                 $scope.changeCateFirst2($scope.three_cate_curr_id);
                    $scope.changeCate(); 
                }
                // window.location.reload();
            });
        }

        // 页面初始化：加载一级并自动选中第一个
        $scope.changeCateFirst();

    });

</script>




            </div>
        </div>
        <!-- nano scroller -->
        <script src="/Public/assets/js/lib/menubar/sidebar.js"></script>
        <script src="/Public/assets/js/lib/preloader/pace.min.js"></script>
        <!-- scripit init-->
        <script type="text/javascript" src="/Public/assets/js/scripts.js"></script>
    </body>

</html>