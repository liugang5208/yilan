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
                        <li>
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
                        <li><a href="<?php echo U('Goods/cats_exc');?>"><i class="ti-harddrives"></i> 材料标签</a></li>
                        <li><a href="<?php echo U('Goods/cats');?>"><i class="ti-harddrives"></i> 商品调价</a></li>
                        <!--li><a href="<?php echo U('Goods/tmps');?>"><i class="ti-harddrives"></i> 商品模板</a></li-->
                        <li><a href="<?php echo U('Goods/liner');?>"><i class="ti-harddrives"></i> 线缆板块</a></li>
                        <li><a href="<?php echo U('Goods/peita');?>"><i class="ti-harddrives"></i> 配套板块</a></li>
                        <li><a href="<?php echo U('Shops/index');?>"><i class="ti-harddrives"></i> 店铺管理</a></li>
                        <li><a href="<?php echo U('Order/index');?>"><i class="ti-harddrives"></i> 订单管理</a></li>
                        <!--li><a href="<?php echo U('Shops/buyer');?>"><i class="ti-harddrives"></i> 采购管理</a></li>
                        <li><a href="<?php echo U('Shops/recyle');?>"><i class="ti-harddrives"></i> 回收管理</a></li-->
                        <li><a href="<?php echo U('Trans/citys');?>"><i class="ti-harddrives"></i> 物流板块</a></li>
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
                        <li><a href="<?php echo U('Sysc/index');?>"><i class="ti-harddrives"></i> 系统版本</a></li>
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
                    <h1>商品模板详情</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="<?php echo U('Goods/tmps');?>">商品模板</a></li>
                        <li class="active">商品模板详情</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->
    <section id="main-content">


        <div class="col-lg-12">
            <div class="card alert">
                <div class="card-header">
                    <h4>商品模板详情</h4>
                    <div class="card-header-right-icon">
                        <ul>
                            <li class="doc-link">
                                <a class="btn btn-xs btn-info" ng-click="addor()">添加商品模板记录</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th ng-if="typer < 2">规格分类名称</th>
                                    <th ng-if="typer > 1">关键词</th>
                                    <th ng-if="typer > 1">值</th>
                                    <th ng-if="typer > 1">关键词1</th>
                                    <th ng-if="typer > 1">值1</th>
                                    <th ng-if="typer > 1">关键词2</th>
                                    <th ng-if="typer > 1">值2</th>
                                    <th>价格</th>
                                    <th ng-if="typer > 1">发货时间</th>
                                    <th width="20%">管理</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php if(is_array($list["list"])): $k = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><form name="list_<?php echo ($v["id"]); ?>">
                                    <tr>
                                        <th scope="row"><?php echo ($k); ?></th>
                                        <td class="<?php echo ($info['types']<2?'':'none'); ?>"><input type="text" class="form-control input-sm" name="name" value="<?php echo ($v["name"]); ?>"/></td>
                                        <td class="<?php echo ($info['types']>1?'':'none'); ?>"><input type="text" class="form-control input-sm" name="key_0" value="<?php echo ($v["key_0"]); ?>"/></td>
                                        <td class="<?php echo ($info['types']>1?'':'none'); ?>"><input type="text" class="form-control input-sm" name="value_0" value="<?php echo ($v["value_0"]); ?>"/></td>
                                        <td class="<?php echo ($info['types']>1?'':'none'); ?>"><input type="text" class="form-control input-sm" name="key_1" value="<?php echo ($v["key_1"]); ?>"/></td>
                                        <td class="<?php echo ($info['types']>1?'':'none'); ?>"><input type="text" class="form-control input-sm" name="value_1" value="<?php echo ($v["value_1"]); ?>"/></td>
                                        <td class="<?php echo ($info['types']>1?'':'none'); ?>"><input type="text" class="form-control input-sm" name="key_2" value="<?php echo ($v["key_2"]); ?>"/></td>
                                        <td class="<?php echo ($info['types']>1?'':'none'); ?>"><input type="text" class="form-control input-sm" name="value_2" value="<?php echo ($v["value_2"]); ?>"/></td>
                                        <td><input type="text" name="price" class="form-control input-sm" value="<?php echo ($v["price"]); ?>"/></td>
                                        <td class="<?php echo ($info['types']>1?'':'none'); ?>"><input type="text" class="form-control input-sm" name="trans" value="<?php echo ($v["trans"]); ?>"/></td>
                                        <td>
                                            <a class="btn btn-info btn-xs" ng-click="updatr('<?php echo ($v["id"]); ?>')">更新</a>
                                            <a ng-click="dels('<?php echo ($v["id"]); ?>')" class="btn btn-danger btn-xs">删除</a>
                                        </td>
                                    </tr>
                                </form><?php endforeach; endif; else: echo "" ;endif; ?>

                            </tbody>
                        </table>

                        <nav aria-label="Page navigation">
                            <ul class="pagination"><?php echo ($list["show"]); ?></ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>


    </section>

</div>

<script>

    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {

        $scope.typer = "<?php echo ($info["types"]); ?>";

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

        /**
         * 添加
         * @param {type} id
         * @returns {undefined}
         */
        $scope.addor = function () {
            $scope.commAjax("<?php echo U('Goods/tmps_log_add');?>", {id: "<?php echo ($info["id"]); ?>"}, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

        /**
         * 更新
         * @param {type} id
         * @returns {undefined}
         */
        $scope.updatr = function (id) {
            var temp = $("form[name='list_" + id + "']").serializeArray();
            var data = objToArray(temp);
            data.ids = id;
            /////////
            $scope.commAjax("<?php echo U('Core/edits','model=sys_tmps_logs');?>", data, function (res) {
                if (res.status !== 1) {
                    return swal("错误", res.msg, "error");
                }
                window.location.reload();
            });
        }

        $scope.dels = function (ids) {
            var param = {id: ids};
            $scope.commAjax("<?php echo U('Core/dels','model=sys_tmps_logs');?>", param, function (res) {
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