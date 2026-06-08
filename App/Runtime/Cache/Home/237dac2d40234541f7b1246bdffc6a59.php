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
    .form-group{ margin-bottom:8px;}
    .modal-body label{ margin-bottom:5px;}
    .btn-martop{ margin-top:-4px;}
</style>

<div class="container-fluid" ng-app="myApp" ng-controller="myCtrl">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>商品分类</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <!--ol class="breadcrumb text-right">
                        <li><a href="#">Dashboard</a></li>
                        <li class="active">UI-Blank</li>
                    </ol-->
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
                        <h4>商品分类</h4>
                        <div class="card-header-right-icon">
                            <ul>
                                <li class="doc-link">
                                    <a class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal">添加商品分类</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">

                        <!--<form name="piont" class="form-inline m-t-5 m-b-5">-->

                        <!--    <?php if(is_array($cats)): $k = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>-->
                        <!--        <div class="form-group <?php echo ($k==1?'':'m-l-10'); ?>">-->
                        <!--            <label><?php echo ($v["name"]); ?></label>-->
                        <!--            <input type="text" name="<?php echo ($v["id"]); ?>" class="form-control input-sm" value="<?php echo ($v["value"]); ?>">-->
                        <!--        </div>-->
                        <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                        <!--    <button type="button" class="btn btn-danger btn-sm btn-martop" onclick="syncs()">立即同步数据</button>-->
                        <!--</form>-->

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>分类名称</th>
                                        <!--<th>上调比例</th>-->
                                        <!--<th>下降比例</th>-->
                                        <!--<th>调整方式</th>-->
                                        <!--<th>调整基准数</th>-->
                                        <!--<th>浮动参考分类</th>-->
                                        <!--<th>上调触发值</th>-->
                                        <!--<th>上调比率</th>-->
                                        <!--<th>下调触发值</th>-->
                                        <!--<th>下调比率</th>-->
                                        <!--<th>自动调整</th>-->
                                       
                                        <th>排序</th>
                                         <th>状态</th>
                                        <th width="15%">记录时间</th>
                                        <th width="10%">管理</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                        <th scope="row"><?php echo ($v["id"]); ?></th>
                                        <td><?php echo ($v["name"]); ?></td>
                                        <!--<td><?php echo ($v["up"]); ?></td>-->
                                        <!--<td><?php echo ($v["down"]); ?></td>-->
                                        <!--<td><?php echo ($v['mode']>0?'手动调整':'自动调整'); ?></td>-->
                                        <!--<td><?php echo ($v["datum"]); ?></td>-->
                                        <!--<td><?php echo (getExcName($v['float_cat'],'name',$name)); ?></td>-->
                                        <!--<td><?php echo ($v["up_size"]); ?></td>-->
                                        <!--<td><?php echo ($v["up_ratio"]); ?></td>-->
                                        <!--<td><?php echo ($v["down_size"]); ?></td>-->
                                        <!--<td><?php echo ($v["down_ratio"]); ?></td>-->
                                        <!--<td><?php echo ($v['fix_on']>0?'开启':'<font color=red>关闭</font>'); ?></td>-->
                                        <td><?php echo ($v["sort"]); ?></td>
                                        <td><?php echo ($v['status']>0?'正常':'暂停使用'); ?></td>
                                        <td><?php echo (date('Y/m/d H:i:s',$v["times"])); ?></td>
                                        <td>
                                            <a ng-click="updateinfo('<?php echo ($v["id"]); ?>')" class="btn btn-info btn-xs">编辑</a>
                                            <a class="btn btn-danger btn-xs" ng-click="dels('<?php echo ($v["id"]); ?>')">删除</a>
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
        <div class="modal-dialog" role="document" style="width:40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加商品调价</h4>
                </div>
                <div class="modal-body">

                    <form name="ador" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>分类名称</label>
                                <input type="text" name="name" class="form-control input-sm"/>
                            </div>
                            <!--<div class="form-group">-->
                            <!--    <label>上调比例</label>-->
                            <!--    <input type="number" name="up" class="form-control input-sm" value="0"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>下降比例</label>-->
                            <!--    <input type="number" name="down" class="form-control input-sm" value="0"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>调整方式</label>-->
                            <!--    <select name="mode" class="form-control input-sm">-->
                            <!--        <option value="0">自动调整</option>-->
                            <!--        <option value="1">手动调整</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <div class="form-group">
                                <label>分类排序</label>
                                <input type="number" name="sort" class="form-control input-sm" value="0"/>
                            </div>
                            <!--<div class="form-group">-->
                            <!--    <label>自动跟随调整</label>-->
                            <!--    <select name="fix_on" class="form-control input-sm">-->
                            <!--        <option value="1">开启</option>-->
                            <!--        <option value="0">关闭</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <div class="form-group">
                                <label>状态</label>
                                <select name="status" class="form-control input-sm">
                                    <option value="1">使用</option>
                                    <option value="0">暂停</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <!--<div class="form-group">-->
                            <!--    <label>调整基准数</label>-->
                            <!--    <input type="number" name="datum" class="form-control input-sm" value="0"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>浮动参考分类</label>-->
                            <!--    <select name="float_cat" class="form-control input-sm">-->
                            <!--        <option value="">请选择</option>-->
                            <!--        <?php if(is_array($cats)): $k = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>-->
                            <!--            <option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option>-->
                            <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>上调触发值</label>-->
                            <!--    <input type="number" name="up_size" class="form-control input-sm" value="0"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>上调比率</label>-->
                            <!--    <input type="number" name="up_ratio" class="form-control input-sm" value="0"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>下调触发值</label>-->
                            <!--    <input type="number" name="down_size" class="form-control input-sm" value="0"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>下调比率</label>-->
                            <!--    <input type="number" name="down_ratio" class="form-control input-sm" value="0"/>-->
                            <!--</div>-->

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
    <div class="modal fade" id="myEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新商品分类</h4>
                </div>
                <div class="modal-body">

                    <form class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>分类名称</label>
                                <input type="text" name="name" class="form-control input-sm" ng-model="infos.name"/>
                            </div>
                            <!--<div class="form-group">-->
                            <!--    <label>上调比例</label>-->
                            <!--    <input type="text" name="up" class="form-control input-sm" ng-model="infos.up"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>下降比例</label>-->
                            <!--    <input type="text" name="down" class="form-control input-sm" ng-model="infos.down"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>调整方式</label>-->
                            <!--    <select name="mode" class="form-control input-sm" ng-model="infos.mode">-->
                            <!--        <option value="0">自动调整</option>-->
                            <!--        <option value="1">手动调整</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <div class="form-group">
                                <label>分类排序</label>
                                <input type="text" name="sort" class="form-control input-sm" ng-model="infos.sort"/>
                            </div>
                            <!--<div class="form-group">-->
                            <!--    <label>自动跟随调整</label>-->
                            <!--    <select name="fix_on" class="form-control input-sm" ng-model="infos.fix_on">-->
                            <!--        <option value="1">开启</option>-->
                            <!--        <option value="0">关闭</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <div class="form-group">
                                <label>状态</label>
                                <select name="status" class="form-control input-sm" ng-model="infos.status">
                                    <option value="1">使用</option>
                                    <option value="0">暂停</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <!--<div class="form-group">-->
                            <!--    <label>调整基准数</label>-->
                            <!--    <input type="text" name="datum" class="form-control input-sm" ng-model="infos.datum"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>浮动参考分类</label>-->
                            <!--    <select name="float_cat" class="form-control input-sm" ng-model="infos.float_cat">-->
                            <!--        <option value="">请选择</option>-->
                            <!--        <?php if(is_array($cats)): $k = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>-->
                            <!--            <option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option>-->
                            <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>上调触发值</label>-->
                            <!--    <input type="text" name="up_size" class="form-control input-sm" ng-model="infos.up_size"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>上调比率</label>-->
                            <!--    <input type="text" name="up_ratio" class="form-control input-sm" ng-model="infos.up_ratio"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>下调触发值</label>-->
                            <!--    <input type="text" name="down_size" class="form-control input-sm" ng-model="infos.down_size"/>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                            <!--    <label>下调比率</label>-->
                            <!--    <input type="text" name="down_ratio" class="form-control input-sm" ng-model="infos.down_ratio"/>-->
                            <!--</div>-->

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateCats()">保存</button>
                </div>
            </div>
        </div>
    </div>

</div>




<script>


    /**
     * 添加
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form[name='ador']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=plate_cats');?>";
        //////
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
    /**
     * 同步分类信息
     * @returns {undefined}
     */
    function syncs() {
        var temp = $("form[name='piont']").serializeArray();
        var data = objToArray(temp);
        //////
        layer.load(2);
        $.ajax({
            url: "<?php echo U('Goods/cats_sync');?>",
            type: "post",
            data: data,
            dataType: "json",
            success: function (res) {
                layer.closeAll();
                if (res.status != 1) {
                    return swal('提示', res.msg, "error");
                }
                window.location.reload();
            },
            error: function () {
                layer.closeAll();
                return swal('提示', "修改失败，请检查分类基础参数是否正确", "error");
            },
        });
    }


    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

        $scope.infos;

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

        $scope.updateinfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=plate_cats');?>", {ids: id}, function (res) {
                $scope.infos = res.data;
                $("#myEdit").modal("show");
            });
        }

        $scope.updateCats = function () {
            var param = $scope.infos;
            param.ids = param.id;
            /////////
            $.ajax({
                url: "<?php echo U('Goods/cats_edit');?>",
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
            $scope.commAjax("<?php echo U('Core/dels','model=plate_cats');?>", param, function (res) {
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