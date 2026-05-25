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

                <style>
    .form-horizontal .control-label{ padding-top:5px;}
    .form-group{ margin-bottom:2px;}
    .border-dark{ border:1px solid #e7e7e7; padding:5px 0px;}
    label{ vertical-align:middle; margin-bottom:0px;}

    .form-block{ cursor:pointer; height:64px; line-height:64px;}
    .nav-tabs li{ cursor:pointer;}

    .table>thead>tr>td{ padding:4px; text-align:center;}
    .table>tbody>tr>td{ padding:4px; text-align:center;}
    .table>thead>tr>td .form-control{ text-align:center;}
    .table>tbody>tr>td .form-control{ text-align:center;}

    .form-width label{ display:inline-block; width:24%!important;}
    .form-width input{ display:inline-block; width:70%!important;}
</style>

<div class="container-fluid" ng-app="myApp" ng-controller="myCtrl">

    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>属性分类商品管理</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="<?php echo U('Goods/plate_conts','id='.$info['pid']);?>">细分商品</a></li>
                        <li class="active">属性分类商品管理</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card alert">
                    <div class="card-header">
                        <h4>属性分类商品管理</h4>
                    </div>
                    <div class="card-body p-t-10">

                        <h5>调整价格</h5>
                        <div class="row border-dark">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-2">

                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">上调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.up_a" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">下调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.down_a" value="0">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="col-md-2">

                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">上调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.up_b" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">下调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.down_b" value="0">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="col-md-2">

                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">上调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.up_c" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">下调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.down_c" value="0">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="col-md-2">

                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">上调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.up_d" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">下调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.down_d" value="0">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="col-md-2">

                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">上调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.up_e" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">下调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.down_e" value="0">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="col-md-2">

                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">上调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.up_f" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">下调</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm" ng-model="blank.down_f" value="0">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="bg-info form-block text-center" ng-click="changeBlank()">确认调整</div>
                            </div>
                        </div>

                        <h5>板块设置</h5>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="{{cat_index==1?'active':''}}" ng-click="changeType(1)"><a>板块一</a></li>
                            <li role="presentation" class="{{cat_index==2?'active':''}}" ng-click="changeType(2)"><a>板块二</a></li>
                            <li role="presentation" class="{{cat_index==3?'active':''}}" ng-click="changeType(3)"><a>板块三</a></li>
                        </ul>

                        <div class="row m-t-10" style="border-bottom: 1px solid #ddd; padding-bottom:10px;">
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#myBlank">设置板块图片</button>
                            </div>
                            <div class="col-md-11">
                                <form class="form-inline m-b-10 row">
                                    <div class="form-group col-md-2 form-width">
                                        <label>板块名称</label>
                                        <input type="text" class="form-control input-sm" ng-model="blank.catname">
                                    </div>
                                    <div class="form-group col-md-2 form-width">
                                        <label>普票费率</label>
                                        <input type="text" class="form-control input-sm" ng-model="blank.ticket_nor">
                                    </div>
                                    <div class="form-group col-md-2 form-width">
                                        <label>专票费率</label>
                                        <input type="text" class="form-control input-sm" ng-model="blank.ticket_person">
                                    </div>
                                    <div class="form-group col-md-6 form-width">
                                        <button type="button" class="btn btn-default btn-sm" ng-click="changeBlank()">更新板块内容</button>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myImport">导入商品</button>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">添加商品</button>
                                        <a class="btn btn-danger btn-sm" ng-click="addOpenMol()">添加模板数据</a>
                                        <a ng-click="blankClear()" class="btn btn-danger btn-sm m-l-10">清空板块数据</a>
                                        <a ng-click="goodsClear()" class="btn btn-danger btn-sm m-l-10">清空商品数据</a>
                                    </div>
                                </form>

                            </div>
                        </div>


                        <h5>商品设置</h5>

                        <div class="row m-b-20" style=" background:#eef1f6; padding:10px 0px;" ng-repeat="x in list">
                            <div class="col-md-1"><img src="/Public/uploads/goods/{{x.source}}" style=" width:100%;"/></div>
                            <div class="col-md-7">

                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td width="20%">商品名称</td>
                                            <td colspan="3">{{x.gnames}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">{{x.key_0}}</td>
                                            <td>{{x.value_0}}</td>
                                            <td width="20%">{{x.key_1}}</td>
                                            <td>{{x.value_1}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{x.key_2}}</td>
                                            <td>{{x.value_2}}</td>
                                            <td>发货时效</td>
                                            <td>{{x.trans}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-4 text-center">
                                <br/>
                                <br/>
                                <a ng-click="addOpenChild(x.id)" class="btn btn-info btn-xs">子商品管理</a>
                                <a ng-click="updateInfo(x.id)" class="btn btn-info btn-xs">编辑</a>
                                <a ng-click="changelogs(x.id, 1)" class="btn btn-info btn-xs">上调顺序</a>
                                <a ng-click="changelogs(x.id, 0)" class="btn btn-info btn-xs">下调顺序</a>
                                <a ng-click="dels(x.id)" class="btn btn-danger btn-xs">删除</a>
                            </div>
                            <div class="col-md-12 p-t-10">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>商品规格分类名称</td>
                                            <td>商品基础价格</td>
                                            <td>商品导体比例</td>
                                            <td>商品执行价格</td>
                                            <td width="30%">管理</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr ng-repeat=" r in x.child">
                                            <td>{{ $index + 1}}</td>
                                            <td>{{r.name}}</td>
                                            <td>{{r.price}}</td>
                                            <td>{{r.dratio}}</td>
                                            <td>{{r.market}}</td>
                                            <td>
                                                <a ng-click="updateChildinfo(r.id)" class="btn btn-info btn-xs">编辑</a>
                                                <a ng-click="changelogr(r.id, 1)" class="btn btn-info btn-xs">上调顺序</a>
                                                <a ng-click="changelogr(r.id, 0)" class="btn btn-info btn-xs">下调顺序</a>
                                                <a ng-click="dels2(r.id)" class="btn btn-danger btn-xs">删除</a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="myBlank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="top:30%; width:50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">设置商品板块轮播图</h4>
                </div>
                <div class="modal-body">

                    <form class="form-inline m-b-10 row">
                        <div class="form-group form-width col-md-4">
                            <label>板块图片</label>
                            <input type="file" id="file" class="form-control input-sm">
                        </div>
                        <button type="button" class="btn btn-default btn-sm" ng-click="changeImgs()">添加板块图片</button>
                    </form>

                    <table class="table">
                        <caption>板块图片</caption>
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>图片</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr  class="text-left" ng-repeat="x in blank.source">
                                <td>1</td>
                                <td><img src="/Public/uploads/banner/{{x}}" style=" width:50px;"/></td>
                                <td><a class="btn btn-xs btn-danger"  ng-click="deleteImgs($index)">删除</a></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- 添加商品 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加商品</h4>
                </div>
                <div class="modal-body">

                    <form class="row" name="goods">
                        <input type="hidden" name="pid" value="<?php echo ($id); ?>"/>
                        <input type="hidden" name="ptype" value="1"/>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>商品图片</label>
                                <input type="file" name="file" id="filer" class="form-control input-sm">
                            </div>
                            <div class="form-group">
                                <label>商品名称</label>
                                <input type="text" name="gnames" class="form-control input-sm">
                            </div>
                            <div class="form-group">
                                <label>参数名称1</label>
                                <input type="text" name="key_0" class="form-control input-sm">
                            </div>
                            <div class="form-group">
                                <label>参数名称1内容</label>
                                <input type="text" name="value_0" class="form-control input-sm">
                            </div>
                            <div class="form-group">
                                <label>参数名称2</label>
                                <input type="text" name="key_1" class="form-control input-sm">
                            </div>
                            <div class="form-group">
                                <label>参数名称2内容</label>
                                <input type="text" name="value_1" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>参数名称3</label>
                                <input type="text" name="key_2" class="form-control input-sm">
                            </div>
                            <div class="form-group">
                                <label>参数名称3内容</label>
                                <input type="text" name="value_2" class="form-control input-sm">
                            </div>
                            <div class="form-group">
                                <label>发货时间</label>
                                <input type="text" name="trans" class="form-control input-sm">
                            </div>
                        </div>

                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="addGoods()">保存</button>
                </div>
            </div>
        </div>
    </div>

    <!--导入商品-->
    <div class="modal fade" id="myImport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="top:30%; width:50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">导入商品</h4>
                </div>
                <div class="modal-body">

                    <form class="form-inline m-b-10 row">
                        <div class="form-group form-width col-md-6">
                            <label>商品模板文件</label>
                            <input type="file" id="excel" class="form-control input-sm" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"/>
                        </div>
                        <button type="button" class="btn btn-default btn-sm" ng-click="impGoods()">导入商品</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- 添加商品模板 -->
    <div class="modal fade" id="myTemp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加商品模板数据</h4>
                </div>
                <div class="modal-body">


                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>名称</th>
                                <th>模板类型</th>
                                <th>状态</th>
                                <th width="15%">添加时间</th>
                                <th width="30%">管理</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                                <th scope="row"><?php echo ($k); ?></th>
                                <td><?php echo ($v["name"]); ?></td>
                                <td><?php echo ($v['types']<2?'多商品模板':'单商品模板'); ?></td>
                                <td><?php echo ($v['status']>0?'正常':'暂停使用'); ?></td>
                                <td><?php echo (date('Y/m/d H:i:s',$v["times"])); ?></td>
                                <td>
                                    <a ng-click="addGoodsMol('<?php echo ($v["id"]); ?>')" class="btn btn-danger btn-xs">添加</a>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <!-- 更新商品 -->
    <div class="modal fade" id="myEdits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新商品</h4>
                </div>
                <div class="modal-body">

                    <form class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>商品图片</label>
                                <input type="file" name="file" id="filedit" class="form-control input-sm">
                                <p class="m-t-10">
                                    <img ng-src="/Public/uploads/banner/{{infos.source}}" height='100'/>
                                </p>
                            </div>
                            <div class="form-group">
                                <label>商品名称</label>
                                <input type="text" name="gnames" class="form-control input-sm" ng-model="infos.gnames">
                            </div>
                            <div class="form-group">
                                <label>参数名称1</label>
                                <input type="text" name="key_0" class="form-control input-sm" ng-model="infos.key_0">
                            </div>
                            <div class="form-group">
                                <label>参数名称1内容</label>
                                <input type="text" name="value_0" class="form-control input-sm" ng-model="infos.value_0">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>参数名称2</label>
                                <input type="text" name="key_1" class="form-control input-sm" ng-model="infos.key_1">
                            </div>
                            <div class="form-group">
                                <label>参数名称2内容</label>
                                <input type="text" name="value_1" class="form-control input-sm" ng-model="infos.value_1">
                            </div>
                            <div class="form-group">
                                <label>参数名称3</label>
                                <input type="text" name="key_2" class="form-control input-sm" ng-model="infos.key_2">
                            </div>
                            <div class="form-group">
                                <label>参数名称3内容</label>
                                <input type="text" name="value_2" class="form-control input-sm" ng-model="infos.value_2">
                            </div>
                            <div class="form-group">
                                <label>发货时间</label>
                                <input type="text" name="trans" class="form-control input-sm" ng-model="infos.trans">
                            </div>
                        </div>

                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateGoods()">保存</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加子商品 -->
    <div class="modal fade" id="myModalChild" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加子商品</h4>
                </div>
                <div class="modal-body">

                    <form name="gchilds">
                        <input type="hidden" name="pid" value="0" id="gchildsPid"/>

                        <div class="form-group">
                            <label>规格分类名称</label>
                            <input type="text" name="name" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label>价格</label>
                            <input type="text" name="price" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label>导体比例</label>
                            <input type="text" name="dratio" class="form-control input-sm">
                        </div>

                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="addGoodsChild()">保存</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 修改子商品 -->
    <div class="modal fade" id="myModalChildEdits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改子商品</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>规格分类名称</label>
                            <input type="text" name="name" class="form-control input-sm" ng-model="infoChild.name">
                        </div>
                        <div class="form-group">
                            <label>价格</label>
                            <input type="text" name="price" class="form-control input-sm" ng-model="infoChild.price">
                        </div>
                        <div class="form-group">
                            <label>导体比例</label>
                            <input type="text" name="dratio" class="form-control input-sm" ng-model="infoChild.dratio">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateChild()">保存</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    //轮播
    var swiper = new Swiper('.swiper-container', {slidesPerView: 3, spaceBetween: 10});
    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

        $scope.pid = "<?php echo ($id); ?>";
        $scope.cat_index = 1;
        $scope.blank = {
            catname: "", source: "", ticket_nor: 0, ticket_person: 0,
            up_a: 0, down_a: 0, up_b: 0, down_b: 0, up_c: 0, down_c: 0,
            up_d: 0, down_d: 0, up_e: 0, down_e: 0, up_f: 0, down_f: 0,
        };
        $scope.list = [];
        //
        $scope.childID = 0;
        $scope.infos;
        $scope.infoChild;
        ////////////////////////////////////////////////////////////////////////

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
        /**
         * 通讯操作
         * @param {type} url
         * @param {type} data
         * @returns {undefined}
         */
        $scope.commAjax2 = function (url, data, success) {
            $http({
                method: "POST",
                url: url,
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: angular.identity,
            }).success(function (response) {
                success(response);
            });
        };
        /**
         * 调整比例
         * @returns {undefined}
         */
        $scope.init = function () {
            var param = {pid: $scope.pid, cat_index: $scope.cat_index};
            //////
            $scope.commAjax("<?php echo U('Goods/plate_conts_blankr');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                if (res.data.info != null) {
                    $scope.blank = res.data.info;
                    $scope.list = res.data.list;
                } else {
                    $scope.blank = {
                        catname: "", source: "", ticket_nor: 0, ticket_person: 0,
                        up_a: 0, down_a: 0, up_b: 0, down_b: 0, up_c: 0, down_c: 0,
                        up_d: 0, down_d: 0, up_e: 0, down_e: 0, up_f: 0, down_f: 0
                    };
                    $scope.list = [];
                }
            });
        };
        $scope.init();
        ////////////////////////////////////////////////////////////////////////

        /**
         * 更换类型
         * @param {type} index
         * @returns {undefined}
         */
        $scope.changeType = function (index) {
            $scope.cat_index = index;
            $scope.init();
        };
        /**
         * 调整图片
         * @returns {undefined}
         */
        $scope.changeImgs = function () {
            var param = new FormData();
            param.append('file', document.getElementById("file").files[0]);
            param.append('pid', $scope.pid);
            param.append('cat_index', $scope.cat_index);
            //////
            $scope.commAjax2("<?php echo U('Goods/plate_conts_upload');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
                return swal("提示", res.msg, "success");
            });
        };
        /**
         * 删除板块图片
         * @returns {undefined}
         */
        $scope.deleteImgs = function (i) {
            var param = {pid: $scope.pid, cat_index: $scope.cat_index, index: i};
            $scope.commAjax("<?php echo U('Goods/plate_conts_del');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
            });
        }

        /**
         * 调整比例
         * @returns {undefined}
         */
        $scope.changeBlank = function () {
            var param = $scope.blank;
            param.pid = $scope.pid;
            param.cat_index = $scope.cat_index;
            //////
            $scope.commAjax("<?php echo U('Goods/plate_conts_blank');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
                return swal("提示", res.msg, "success");
            });
        };
        ////////////////////////////////////////////////////////////////////////

        /**
         * 导入商品
         * @returns {undefined}
         */
        $scope.impGoods = function () {
            var param = new FormData();
            param.append('file', document.getElementById("excel").files[0]);
            param.append('pid', $scope.pid);
            param.append('cat_index', $scope.cat_index);
            //////
            $scope.commAjax2("<?php echo U('Goods/plate_conts_more_im');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
                return swal("提示", res.msg, "success");
            });
        };
        /**
         * 添加商品
         * @returns {undefined}
         */
        $scope.addGoods = function () {
            var temp = $("form[name='goods']").serializeArray();
            var data = objToArray(temp);
            data.cat_index = $scope.cat_index;
            /////////
            $.ajaxFileUpload({
                url: "<?php echo U('Core/addon','model=plate_conts_logs');?>",
                secureuri: false,
                fileElementId: "filer",
                dataType: 'json',
                data: data,
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
        };
        /**
         * 子商品-添加模板参数
         * @param {type} id
         * @returns {undefined}
         */
        $scope.addOpenMol = function () {
            //$scope.childID = id;
            $("#myTemp").modal("show");
        }

        /**
         * 添加模板参数
         * @returns {undefined}
         */
        $scope.addGoodsMol = function (i) {
            var param = {pid: $scope.pid, cat_index: $scope.cat_index, ids: i};
            ///
            layer.load(2);
            $scope.commAjax("<?php echo U('Goods/plate_conts_more_temp');?>", param, function (res) {
                layer.closeAll();
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $("#myTemp").modal("hide");
                $scope.init();
            });
        }

        /**
         * 子商品
         * @param {type} id
         * @returns {undefined}
         */
        $scope.addOpenChild = function (id) {
            $("#gchildsPid").val(id);
            $("#myModalChild").modal("show");
        }

        /**
         * 子商品-添加
         * @returns {undefined}
         */
        $scope.addGoodsChild = function () {
            var temp = $("form[name='gchilds']").serializeArray();
            var data = objToArray(temp);
            data.market = data.price;
            data.cat_index = $scope.cat_index;
            //////
            $scope.commAjax("<?php echo U('Core/addon','model=plate_conts_logsr');?>", data, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $("#myModalChild").modal("hide");
                $scope.init();
                ////
                return swal("提示", res.msg, "success");
            });
        };
        ////////////////////////////////////////////////////////////////////////

        $scope.updateInfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=plate_conts_logs');?>", {ids: id}, function (res) {
                $scope.infos = res.data;
                $("#myEdits").modal("show");
            });
        }

        $scope.updateGoods = function () {
            var param = $scope.infos;
            param.ids = param.id;
            /////////
            $.ajaxFileUpload({
                url: "<?php echo U('Core/edits','model=plate_conts_logs');?>",
                secureuri: false,
                fileElementId: "filedit",
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

        $scope.updateChildinfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=plate_conts_logsr');?>", {ids: id}, function (res) {
                $scope.infoChild = res.data;
                $("#myModalChildEdits").modal("show");
            });
        }

        /**
         * 更新子商品
         * @returns {undefined}
         */
        $scope.updateChild = function () {
            var param = $scope.infoChild;
            param.type = 1;
            param.fpid = "<?php echo ($id); ?>";
            param.cat_index = $scope.cat_index
            /////////
            $scope.commAjax("<?php echo U('Goods/plate_conts_update');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

        $scope.dels = function (ids) {
            var param = {id: ids};
            layer.load(2);
            $scope.commAjax("<?php echo U('Core/dels','model=plate_conts_logs');?>", param, function (res) {
                layer.closeAll('loading');
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                return $scope.init();
            });
        }

        $scope.dels2 = function (ids) {
            var param = {id: ids};
            layer.load(2);
            $scope.commAjax("<?php echo U('Core/dels','model=plate_conts_logsr');?>", param, function (res) {
                layer.closeAll('loading');
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                return $scope.init();
            });
        }

        /**
         * 清空
         * @returns {undefined}
         */
        $scope.blankClear = function () {
            var param = {pid: $scope.pid, cat_index: $scope.cat_index, ptype: 1};
            layer.load(2);
            $scope.commAjax("<?php echo U('Goods/plate_conts_clearblank');?>", param, function (res) {
                layer.closeAll('loading');
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                return $scope.init();
            });
        }

        /**
         * 清空
         * @returns {undefined}
         */
        $scope.goodsClear = function () {
            var param = {pid: $scope.pid, cat_index: $scope.cat_index, ptype: 1};
            layer.load(2);
            $scope.commAjax("<?php echo U('Goods/plate_conts_clearlog');?>", param, function (res) {
                layer.closeAll('loading');
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                return $scope.init();
            });
        }

        ////////////////////////////////////////////////////////////////////////

        $scope.changelogs = function (id, type) {
            var param = {id: id, redi: type};
            $scope.commAjax("<?php echo U('Core/uplogs');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
            });
        }

        $scope.changelogr = function (id, type) {
            var param = {id: id, redi: type};
            $scope.commAjax("<?php echo U('Core/uplogr');?>", param, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                $scope.init();
            });
        }

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