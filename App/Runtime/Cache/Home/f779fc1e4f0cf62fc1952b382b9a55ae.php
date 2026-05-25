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

                <style>
    .disitem{
        box-sizing:border-box;
        height:160px;
        line-height:160px;
        overflow:hidden;
        padding:5px;
        text-align:center;
    }
    .disitem img{ vertical-align:middle; height:100%;}

    .disitemright{
        box-sizing:border-box;
        flex:1;
        height:160px;
        line-height:30px;
        padding:60px 5px 5px;
        text-align:right;
    }
    .disblok p{ margin:0px;}
</style>

<div class="container-fluid" ng-app="myApp" ng-controller="myCtrl">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>细分商品</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="<?php echo U('Goods/plate_infos','id='.$info['pid'].'&type='.$info['type_id']);?>">板块分类条管理</a></li>
                        <li class="active">细分商品</li>
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
                        <h4>板块详情</h4>
                        <div class="card-header-right-icon">
                            <ul>
                                <li class="doc-link">
                                    <a class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal">添加细分商品</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-t-10">



                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%">展位图</th>
                                        <th width="10%">搜索图</th>
                                        <th width="30%">详情信息</th>
                                        <th>管理</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                        <td class="disflex">
                                            <div class="disitem"><img src="/Public/uploads/ads/<?php echo ($v["source"]); ?>"/></div>
                                        </td>
                                        <td class="disflex">
                                            <div class="disitem"><img src="/Public/uploads/ads/<?php echo ($v["source_display"]); ?>"/></div>
                                        </td>
                                        <td class="disblok">
                                            <p>商品分类：<?php echo (getCatsName($v['catid'],'name',$catid)); ?><font color='red'>[<?php echo ($v["id"]); ?>]</font></p>
                                            <p>商品名称：<?php echo ($v["g_name"]); ?></p>
                                            <p>型号内容：<?php echo ($v["g_qq"]); ?></p>
                                            <p>模块属性：<?php echo (priceType($v['price_type'],$v["price_type"])); ?></p>
                                            <p>占位比例：<?php echo (showType($v['show_type'],$show_type)); ?></p>
                                            <p>商品单位：<?php echo ($v["g_unit"]); ?></p>
                                            <p>关键词：<?php echo ($v["g_keys"]); ?></p>
                                            <p>客服电话：<?php echo ($v["g_phone"]); ?></p>
                                        </td>
                                        <td>
                                            <div class="disitemright">
                                                <a ng-click="changeid('<?php echo ($v["id"]); ?>', 1)" class="btn btn-info btn-xs">上调顺序</a>
                                                <a ng-click="changeid('<?php echo ($v["id"]); ?>', 0)" class="btn btn-info btn-xs">下调顺序</a>
                                                <?php if(($v["price_type"]) == "1"): ?><a href="<?php echo U('Goods/plate_conts_more','id='.$v['id']);?>" class="btn btn-info btn-xs">商品列表</a><?php endif; ?>
                                                <?php if(($v["price_type"]) == "2"): ?><a href="<?php echo U('Goods/plate_conts_list','id='.$v['id']);?>" class="btn btn-info btn-xs">商品列表</a><?php endif; ?>
                                                <?php if(($v["price_type"]) < "3"): ?><a href="<?php echo U('Goods/plate_conts_info','id='.$v['id'].'&tar=g_attr');?>" class="btn btn-info btn-xs">商品参数</a>
                                                <a href="<?php echo U('Goods/plate_conts_info','id='.$v['id'].'&tar=g_desc');?>" class="btn btn-info btn-xs">商品详情</a><?php endif; ?>
                                                <a href="javascript:addShowImg('<?php echo ($v["id"]); ?>');" class="btn btn-info btn-xs">占位图片</a>
                                                <a href="javascript:addShowSrImg('<?php echo ($v["id"]); ?>');" class="btn btn-info btn-xs">搜索图片</a>

                                                <a ng-click="updateInfo('<?php echo ($v["id"]); ?>')" class="btn btn-info btn-xs">编辑</a>
                                                <a ng-click="dels('<?php echo ($v["id"]); ?>')" class="btn btn-danger btn-xs">删除</a>
                                            </div>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>

                            <nav aria-label="Page navigation">
                                <ul class="pagination"><?php echo ($list["show"]); ?></ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加细分商品</h4>
                </div>
                <div class="modal-body">

                    <form name="item">
                        <input type="hidden" name="pid" value="<?php echo ($id); ?>"/>
                        <input type="hidden" name="sorts" value="0"/>

                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>商品分类</label>
                                    <select name="catid" class="form-control input-sm">
                                        <option value="0">暂不分类</option>
                                        <?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>名称</label>
                                    <input type="text" name="name" class="form-control input-sm"/>
                                </div>
                                <div class="form-group">
                                    <label>显示图</label>
                                    <input type="file" name="file" id="file" class="form-control input-sm"/>
                                </div>
                                <div class="form-group">
                                    <label>搜索图</label>
                                    <input type="file" name="search" id="searchr" class="form-control input-sm"/>
                                </div>
                                <!--div class="form-group">
                                    <label>排序</label>
                                    <input type="number" name="sorts" class="form-control input-sm" value="0"/>
                                </div-->
                            </div>
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>价格样式</label>
                                    <select name="price_type" class="form-control input-sm">
                                        <option value="1">多属性商品</option>
                                        <option value="2">商品列表</option>
                                        <option value="3">店铺</option>
                                    </select>
                                </div>
                                <div class="form-group none">
                                    <label>关联店铺</label>
                                    <select name="price_id" class="form-control input-sm">
                                        <option value="0">请选择</option>
                                        <?php if(is_array($shop)): $i = 0; $__LIST__ = $shop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>占位样式</label>
                                    <select name="show_type" class="form-control input-sm">
                                        <option value="1">三分之一占位</option>
                                        <option value="4">二分之一占位</option>
                                        <option value="2">三分之二占位</option>
                                        <option value="3">整块占位</option>
                                        <!--option value="4">四分之四占位</option-->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>商品单位</label>
                                    <input type="text" name="g_unit" class="form-control input-sm"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>商品关键词</label>
                                    <input type="text" name="g_keys" class="form-control input-sm"/>
                                </div>
                                <!--div class="form-group">
                                    <label>搜索商品名称</label>
                                    <input type="text" name="g_name" class="form-control input-sm"/>
                                </div-->
                                <div class="form-group">
                                    <label>型号内容</label>
                                    <input type="text" name="g_qq" class="form-control input-sm"/>
                                </div>
                                <div class="form-group">
                                    <label>电话</label>
                                    <input type="text" name="g_phone" class="form-control input-sm"/>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addor()">添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myEdits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改细分商品</h4>
                </div>
                <div class="modal-body">

                    <form name="edit">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>商品分类</label>
                                    <select name="catid" class="form-control input-sm" ng-model="lininfo.catid">
                                        <option value="0">暂不分类</option>
                                        <?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>名称</label>
                                    <input type="text" name="name" class="form-control input-sm" ng-model="lininfo.name"/>
                                </div>
                                <div class="form-group">
                                    <label>显示图</label>
                                    <input type="file" name="file" id="filedit" class="form-control input-sm"/>
                                    <p class="m-t-10">
                                        <img ng-src="/Public/uploads/ads/{{lininfo.source}}" height='50'/>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>搜索图</label>
                                    <input type="file" name="search" id="searchredit" class="form-control input-sm"/>
                                    <p class="m-t-10">
                                        <img ng-src="/Public/uploads/ads/{{lininfo.source_display}}" height='50'/>
                                    </p>
                                </div>
                                <!--div class="form-group">
                                    <label>排序</label>
                                    <input type="text" name="sorts" class="form-control input-sm" ng-model="lininfo.sorts"/>
                                </div-->
                            </div>
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>价格样式</label>
                                    <select name="price_type" class="form-control input-sm" ng-model="lininfo.price_type">
                                        <option value="1">多属性商品</option>
                                        <option value="2">商品列表</option>
                                        <option value="3">店铺</option>
                                    </select>
                                </div>
                                <div class="form-group none">
                                    <label>关联店铺</label>
                                    <select name="price_id" class="form-control input-sm" ng-model="lininfo.price_id">
                                        <option value="0">请选择</option>
                                        <?php if(is_array($shop)): $i = 0; $__LIST__ = $shop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>占位样式</label>
                                    <select name="show_type" class="form-control input-sm" ng-model="lininfo.show_type">
                                        <option value="1">三分之一占位</option>
                                        <option value="4">二分之一占位</option>
                                        <option value="2">三分之二占位</option>
                                        <option value="3">整块占位</option>
                                        <!--option value="4">四分之四占位</option-->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>商品单位</label>
                                    <input type="text" name="g_unit" class="form-control input-sm" ng-model="lininfo.g_unit"/>
                                </div>


                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>商品关键词</label>
                                    <input type="text" name="g_keys" class="form-control input-sm" ng-model="lininfo.g_keys"/>
                                </div>
                                <!--div class="form-group">
                                    <label>搜索商品名称</label>
                                    <input type="text" name="g_name" class="form-control input-sm" ng-model="lininfo.g_name"/>
                                </div-->
                                <div class="form-group">
                                    <label>型号内容</label>
                                    <input type="text" name="g_qq" class="form-control input-sm" ng-model="lininfo.g_qq"/>
                                </div>
                                <div class="form-group">
                                    <label>电话</label>
                                    <input type="text" name="g_phone" class="form-control input-sm" ng-model="lininfo.g_phone"/>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateOp()">更新</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="shows" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:25%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新板块展位图</h4>
                </div>
                <div class="modal-body">

                    <form name="source">
                        <input type="hidden" name="ids" value="0" id="showID"/>
                        <div class="form-group">
                            <label>展位图</label>
                            <input type="file" name="source" id="source" class="form-control input-sm"/>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addImg()">添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 搜索图 -->
    <div class="modal fade" id="showdis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:25%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新板块搜索图</h4>
                </div>
                <div class="modal-body">

                    <form name="source_display">
                        <input type="hidden" name="ids" value="0" id="showdisID"/>
                        <div class="form-group">
                            <label>搜索图</label>
                            <input type="file" name="source_display" id="source_display" class="form-control input-sm"/>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addImgSr()">添加</button>
                </div>
            </div>
        </div>
    </div>


</div>

<script>

    function addShowShop(id) {
        if (id == "3") {

        }
    }

    function addor() {
        var temp = $("form[name='item']").serializeArray();
        var data = objToArray(temp);
        data.g_name = data.name;
        /////////
        $.ajaxFileUpload({
            url: "<?php echo U('Core/addon','model=plate_conts');?>",
            secureuri: false,
            fileElementId: ["file", "searchr"],
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
    }

    function addShowImg(id) {
        $("#showID").val(id);
        $("#shows").modal("show");
    }

    function addImg() {
        var temp = $("form[name='source']").serializeArray();
        var data = objToArray(temp);
        /////////
        $.ajaxFileUpload({
            url: "<?php echo U('Goods/plate_conts_upfile');?>",
            secureuri: false,
            fileElementId: "source",
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
    }

    function addShowSrImg(id) {
        $("#showdisID").val(id);
        $("#showdis").modal("show");
    }

    function addImgSr() {
        var temp = $("form[name='source_display']").serializeArray();
        var data = objToArray(temp);
        /////////
        $.ajaxFileUpload({
            url: "<?php echo U('Goods/plate_conts_search');?>",
            secureuri: false,
            fileElementId: "source_display",
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
    }

    ////////////////////////////////////////////////////////////////////////////

    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

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

        ////////////////////////////////////////////////////////////////////////

        $scope.deleteimgs = function (id) {
            $scope.commAjax("<?php echo U('Core/dels','model=plate_conts_imgs');?>", {id: id}, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

        ////////////////////////////////////////////////////////////////////////

        $scope.updateInfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=plate_conts');?>", {ids: id}, function (res) {
                $scope.lininfo = res.data;
                $("#myEdits").modal("show");
            });
        }

        $scope.updateOp = function () {
            var param = $scope.lininfo;
            param.ids = param.id;
            param.g_name = param.name;
            /////////
            $.ajaxFileUpload({
                url: "<?php echo U('Core/edits','model=plate_conts');?>",
                secureuri: false,
                fileElementId: ["filedit", "searchredit"],
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
            layer.load(2);
            $scope.commAjax("<?php echo U('Core/dels','model=plate_conts');?>", param, function (res) {
                layer.closeAll('loading');
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

        $scope.changeid = function (id, type) {
            var param = {id: id, redi: type};
            $scope.commAjax("<?php echo U('Core/upconts');?>", param, function (res) {
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
        <!-- nano scroller -->
        <script src="/Public/assets/js/lib/menubar/sidebar.js"></script>
        <script src="/Public/assets/js/lib/preloader/pace.min.js"></script>
        <!-- scripit init-->
        <script type="text/javascript" src="/Public/assets/js/scripts.js"></script>
    </body>

</html>