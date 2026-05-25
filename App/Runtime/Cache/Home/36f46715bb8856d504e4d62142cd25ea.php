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
                    <h1>注册用户</h1>
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
                        <h4>注册用户（注：红色昵称的都是申请提升账户权限的用户）</h4>

                        <div class="card-header-right-icon">
                            <ul>
                                <li class="doc-link">
                                    <a class="btn btn-xs btn-warning" href="<?php echo U('Users/index_posi');?>" target="_blank">更新手机归属地</a>
                                    <a class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal">添加注册用户</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">

                        <form action="<?php echo U('Users/index');?>" class="form-inline">
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control input-sm" placeholder="请输入用户手机号码"/>
                            </div>
                            <button type="submit" class="btn btn-xs btn-info">查找账号</button>
                        </form>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>注册账号</th>
                                        <th>呢称</th>
                                        <th>账号备注</th>
                                        <th>归属地</th>
                                        <th>权限级别</th>
                                        <th>是否签约</th>
                                        <th>状态</th>
                                        <th width="12%">注册时间</th>
                                        <th width="12%">最后登录时间</th>
                                        <th width="20%">管理</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                        <th scope="row"><?php echo ($v["id"]); ?></th>
                                        <td><?php echo ($v["phone"]); ?></td>
                                         <td><?php echo ($v["nickname"]); ?></td>
                                         <td><?php echo ($v["tags"]); ?></td>
                                        <td><?php echo ($v["locate"]); ?></td>
                                        <td><?php echo (getUsersLv($v['ac_level'],$ac_level)); ?></td>
                                        <td><?php echo ($v['ac_credit']>0?'是':'否'); ?></td>
                                        <td><?php echo ($v['status']>0?'正常':'禁用'); ?></td>
                                        <td><?php echo (date('Y/m/d H:i:s',$v["times"])); ?></td>
                                        <td><?php echo (date('Y/m/d H:i:s',$v["last"])); ?></td>
                                        <td>
                                            <?php if(($v["is_report"]) == "0"): ?><a href="javascript:changeReport('<?php echo ($v["id"]); ?>', 1);" class="btn btn-success btn-xs">解除禁用报价单</a><?php endif; ?>
                                            <?php if(($v["is_report"]) == "1"): ?><a href="javascript:changeReport('<?php echo ($v["id"]); ?>', 0);" class="btn btn-danger btn-xs">禁用报价单</a><?php endif; ?>
                                            
                                            <a class="btn btn-info btn-xs" href="<?php echo U('Users/infos','id='.$v['id']);?>">查看</a>
                                            <a class="btn btn-info btn-xs" ng-click="updateInfo('<?php echo ($v["id"]); ?>')">编辑</a>
                                            <?php if(($v["status"]) == "0"): ?><a href="javascript:change('<?php echo ($v["id"]); ?>', 1);" class="btn btn-success btn-xs">解除禁用</a><?php endif; ?>
                                            <?php if(($v["status"]) == "1"): ?><a href="javascript:change('<?php echo ($v["id"]); ?>', 0);" class="btn btn-danger btn-xs">禁用</a><?php endif; ?>
                                            <a ng-click="dels('<?php echo ($v["id"]); ?>')" class="btn btn-danger btn-xs">删除</a>
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
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加注册用户</h4>
                </div>
                <div class="modal-body">

                    <form name="addnew">
                        <div class="form-group">
                            <label>账户权限级别</label>
                            <select name="ac_level" class="form-control">
                                <option value="">请选择</option>
                                <?php if(is_array($level)): $i = 0; $__LIST__ = $level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["level"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>是否签约商户</label>
                            <select name="ac_credit" class="form-control">
                                <option value="0">否</option>
                                <option value="1">是</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>电话</label>
                            <input type="text" name="phone" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>密码</label>
                            <input type="password" name="passwd" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>账号备注名称</label>
                            <input type="text" name="tags" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>状态</label>
                            <select name="status" class="form-control">
                                <option value="1">使用</option>
                                <option value="0">暂停</option>
                            </select>
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
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新注册用户</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>账户权限级别</label>
                        <select name="ac_level" class="form-control" ng-model="info.ac_level">
                            <option value="">请选择</option>
                            <?php if(is_array($level)): $i = 0; $__LIST__ = $level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["level"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>是否签约商户</label>
                        <select name="ac_credit" class="form-control" ng-model="info.ac_credit">
                            <option value="0">否</option>
                            <option value="1">是</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>电话</label>
                        <input type="text" name="phone" class="form-control" ng-model="info.phone"/>
                    </div>
                    <div class="form-group">
                        <label>账号备注名称</label>
                        <input type="text" name="tags" class="form-control" ng-model="info.tags"/>
                    </div>
                    <div class="form-group">
                        <label>状态</label>
                        <select name="status" class="form-control" ng-model="info.status">
                            <option value="1">使用</option>
                            <option value="0">暂停</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateOp()">更新</button>
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
        var temp = $("form[name='addnew']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=users');?>";
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
     * 更新信息
     * @returns {undefined}
     */
    function change(id, st) {
        var data = {ids: id, status: st};
        //////
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

            },
        });
    }
    
    function changeReport(id, st) {
        var data = {ids: id, is_report: st};
        //////
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

            },
        });
    }

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

        $scope.updateInfo = function (id) {
            $scope.commAjax("<?php echo U('Core/infos','model=users');?>", {ids: id}, function (res) {
                $scope.info = res.data;
                $("#myEdits").modal("show");
            });
        }

        $scope.updateOp = function () {
            var param = $scope.info;
            param.ids = param.id;
            param.apply_check = 0;
            /////////
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
        <!-- nano scroller -->
        <script src="/Public/assets/js/lib/menubar/sidebar.js"></script>
        <script src="/Public/assets/js/lib/preloader/pace.min.js"></script>
        <!-- scripit init-->
        <script type="text/javascript" src="/Public/assets/js/scripts.js"></script>
    </body>

</html>