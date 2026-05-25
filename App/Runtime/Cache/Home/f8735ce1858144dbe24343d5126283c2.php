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

                <style>
    .disflex{ text-align:center;}
    .disitem img{ width:40%;}
    .disblok p{ margin:0px; min-height:25px; line-height:25px}
    .disitemright{ text-align: center;}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>物流公司</h1>
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
                        <h4>物流公司</h4>
                        <div class="card-header-right-icon">
                            <ul>
                                <li class="doc-link">
                                    <a class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal">添加物流公司</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>

                                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                        <td class="disflex" width="20%">
                                            <div class="disitem">
                                                <div id="namekey">搜索图</div>
                                                <img src="/Public/uploads/trans/<?php echo ($v["search"]); ?>"/>
                                            </div>
                                        </td>
                                        <td class="disflex" width="20%">
                                            <div class="disitem">
                                                <div id="namekey">详情图</div>
                                                <img src="/Public/uploads/trans/<?php echo ($v["source"]); ?>"/>
                                            </div>
                                        </td>
                                        <td class="disblok" width="30%">
                                            <p>物流名称：<?php echo ($v["name"]); ?></p>
                                            <p>始发地点：<?php echo ($v["base_addr"]); ?></p>
                                            <p>专线往返：<?php echo ($v["line_trans"]); ?></p>
                                            <p>代收发放时间：<?php echo ($v["agent_save"]); ?></p>
                                            <p>代收查询电话：<?php echo ($v["agent_phone"]); ?></p>
                                            <p>路线关键词：<?php echo ($v["line_keys"]); ?></p>
                                            <!--p>名称关键词：<?php echo (showType($v['show_type'],$show_type)); ?></p-->
                                        </td>
                                        <td>
                                            <div class="disitemright">
                                                <br/><br/>
                                                <a href="javascript:addSearchImg('<?php echo ($v["id"]); ?>');" class="btn btn-info btn-xs">搜索图片</a>
                                                <a href="javascript:addShowImg('<?php echo ($v["id"]); ?>');" class="btn btn-info btn-xs">详情图片</a>
                                                <a href="<?php echo U('Trans/index_edits','id='.$v['id']);?>" class="btn btn-info btn-xs">编辑信息</a>
                                                <a href="<?php echo U('Trans/index_logs','id='.$v['id'].'&pid='.$id);?>" class="btn btn-info btn-xs">站点管理</a>
                                                <a href="javascript:dels('<?php echo ($v["id"]); ?>');" class="btn btn-danger btn-xs">删除</a>
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
                    <h4 class="modal-title" id="myModalLabel">添加物流公司</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="pid" value="<?php echo ($id); ?>"/>
                        <input type="hidden" name="trans_type" value="2"/>
                        <input type="hidden" name="line_prov" value="0"/>
                        <input type="hidden" name="line_city" value="0"/>
                        <input type="hidden" name="line_label" value="0"/>

                        <div class="row">
                            <div class="col-md-4">

                                <!--div class="form-group">
                                    <label>发货类型</label>
                                    <select name="trans_type" class="form-control input-sm">
                                        <option value="">请选择</option>
                                        <option value="0">发货商店</option>
                                        <option value="1">取货商店</option>
                                        <option value="2">又发又收</option>
                                    </select>
                                </div-->
                                <div class="form-group">
                                    <label>物流公司名称</label>
                                    <input type="text" name="name" class="form-control input-sm"/>
                                </div>
                                <div class="form-group">
                                    <label>专线往返</label>
                                    <input type="text" name="line_trans" class="form-control input-sm"/>
                                </div>
                                <div class="form-group">
                                    <label>线路关键词</label>
                                    <input type="text" name="line_keys" class="form-control input-sm"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>代收发送</label>
                                    <input type="text" name="agent_save" class="form-control input-sm"/>
                                </div>
                                <div class="form-group">
                                    <label>代收查询</label>
                                    <input type="text" name="agent_phone" class="form-control input-sm"/>
                                </div>
                                <div class="form-group">
                                    <label>总部电话</label>
                                    <input type="text" name="telephone" class="form-control input-sm"/>
                                </div>
                            </div>
                            <div class="col-md-4">


                                <div class="form-group">
                                    <label>公司地址</label>
                                    <input type="text" name="addr" class="form-control input-sm"/>
                                </div>
                                <div class="form-group">
                                    <label>状态</label>
                                    <select name="status" class="form-control input-sm">
                                        <option value="1">使用</option>
                                        <option value="0">暂停</option>
                                    </select>
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
    <div class="modal fade" id="searchmoel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:25%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新物流搜索图</h4>
                </div>
                <div class="modal-body">

                    <form name="search">
                        <input type="hidden" name="ids" value="0" id="searchID"/>
                        <div class="form-group">
                            <label>搜索图</label>
                            <input type="file" name="search" id="searchr" class="form-control input-sm"/>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addSearch()">添加</button>
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
                    <h4 class="modal-title" id="myModalLabel">更新物流详情图片</h4>
                </div>
                <div class="modal-body">

                    <form name="source">
                        <input type="hidden" name="ids" value="0" id="showID"/>
                        <div class="form-group">
                            <label>详情图</label>
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

</div>


<script>

    /**
     * 获取城市区域
     * @param {type} id
     * @param {type} target
     * @param {type} par
     * @returns {undefined}
     */
    function getRegion(id, target, par) {
        var data = {pid: id};
        $.ajax({
            url: "<?php echo U('Comm/region');?>",
            type: "post",
            data: data,
            dataType: "json",
            success: function (res) {
                if (res.status != 1) {
                    return swal('提示', res.msg, "error");
                }
                ///////
                var html = "<option value=''>请选择</option>";
                for (var i = 0; i < res.data.length; i++) {
                    html += "<option value='" + res.data[i]["id"] + "'>" + res.data[i]["name"] + "</option>";
                }
                $("select[name='" + target + "']").html(html);
            },
            error: function () {

            },
        });
    }

    /**
     * 添加
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=trans');?>";
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
     * 删除
     * @returns {undefined}
     */
    function dels(id) {
        var data = {id: id};
        var baseurl = "<?php echo U('Core/dels','model=trans');?>";
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

    ////////////////////////////////////////////////////////////////////////////

    function addSearchImg(id) {
        $("#searchID").val(id);
        $("#searchmoel").modal("show");
    }

    function addSearch() {
        var temp = $("form[name='search']").serializeArray();
        var data = objToArray(temp);
        /////////
        $.ajaxFileUpload({
            url: "<?php echo U('Trans/index_upsearch');?>",
            secureuri: false,
            fileElementId: "searchr",
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

    function addShowImg(id) {
        $("#showID").val(id);
        $("#shows").modal("show");
    }

    function addImg() {
        var temp = $("form[name='source']").serializeArray();
        var data = objToArray(temp);
        /////////
        $.ajaxFileUpload({
            url: "<?php echo U('Trans/index_upfile');?>",
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