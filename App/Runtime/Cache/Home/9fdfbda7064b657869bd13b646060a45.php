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

                <div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>更新物流公司信息</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="javascript:window.history.back(-1);">物流公司</a></li>
                        <li class="active">更新物流公司信息</li>
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
                    <h4>更新物流公司信息</h4>
                </div>
                <div class="card-body">

                    <form>
                        <input type="hidden" name="ids" value="<?php echo ($id); ?>"/>
                        <input type="hidden" name="pid" value="<?php echo ($info["pid"]); ?>"/>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>物流公司名称</label>
                                    <input type="text" name="name" class="form-control input-sm" value="<?php echo ($info["name"]); ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>专线往返</label>
                                    <input type="text" name="line_trans" class="form-control input-sm" value="<?php echo ($info["line_trans"]); ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>线路关键词</label>
                                    <textarea name="line_keys" class="form-control input-sm" rows="5"><?php echo ($info["line_keys"]); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>代收发送</label>
                                    <input type="text" name="agent_save" class="form-control input-sm" value="<?php echo ($info["agent_save"]); ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>代收查询</label>
                                    <input type="text" name="agent_phone" class="form-control input-sm" value="<?php echo ($info["agent_phone"]); ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>总部电话</label>
                                    <input type="text" name="telephone" class="form-control input-sm" value="<?php echo ($info["telephone"]); ?>"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>公司地址</label>
                                    <input type="text" name="addr" class="form-control input-sm" value="<?php echo ($info["addr"]); ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>状态</label>
                                    <select name="status" class="form-control input-sm">
                                        <option value="1" <?php if($info['status'] == 1): ?>selected<?php endif; ?>>使用</option>
                                        <option value="0" <?php if($info['status'] == 0): ?>selected<?php endif; ?>>暂停</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </form>

                    <button type="button" class="btn btn-primary" onclick="addor()">更新</button>

                </div>
            </div>
        </div>

    </section>
</div>

<script>

    getRegion("<?php echo ($info["base_prov"]); ?>", 'base_city', "<?php echo ($info["base_city"]); ?>");
    getRegion("<?php echo ($info["base_city"]); ?>", 'base_label', "<?php echo ($info["base_label"]); ?>");

    getRegion("<?php echo ($info["line_prov"]); ?>", 'line_city', "<?php echo ($info["line_city"]); ?>");
    getRegion("<?php echo ($info["line_city"]); ?>", 'line_label', "<?php echo ($info["line_label"]); ?>");

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
                    var tmp = "<option value='" + res.data[i]["id"] + "'>" + res.data[i]["name"] + "</option>";
                    if (par == res.data[i]["id"]) {
                        tmp = "<option value='" + res.data[i]["id"] + "' selected>" + res.data[i]["name"] + "</option>";
                    }
                    html += tmp;
                }
                $("select[name='" + target + "']").html(html);
            },
            error: function () {

            },
        });
    }

    /**
     * 更新
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/edits','model=trans');?>";
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