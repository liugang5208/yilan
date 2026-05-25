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
            .table{ font-size:12px;}
            .none{ display:none!important;}
            .sidebar .nano-content > ul li > a{ padding: 8px 20px;}
        </style>
    </head>

    <body>

        <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                    <ul>
                        <li class="label">管理功能</li>
                        <li><a href="<?php echo U('Bords/index');?>"><i class="ti-home"></i> 概览</a></li>
                        <li class="open">
                            <a class="sidebar-sub-toggle">
                                <i class="ti-harddrives"></i> 用户管理 <span class="sidebar-collapse-icon ti-angle-down"></span>
                            </a>
                            <ul style="display: block;">
                                <li><a href="<?php echo U('Users/index');?>">注册用户</a></li>
                                <li><a href="<?php echo U('Users/logrs');?>">登录统计</a></li>
                                <li><a href="<?php echo U('Users/search');?>">搜索记录</a></li>
                                <!--li><a href="<?php echo U('Users/label');?>">禁止区域</a></li-->
                                <li><a href="<?php echo U('Users/levels');?>">用户等级</a></li>
                                <!--li><a href="<?php echo U('Users/cnlogs');?>">账户操作记录</a></li-->
                                <li><a href="<?php echo U('Users/mess');?>">消息管理</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo U('Goods/cats');?>"><i class="ti-harddrives"></i> 商品分类</a></li>
                        <li><a href="<?php echo U('Goods/tmps');?>"><i class="ti-harddrives"></i> 商品模板</a></li>
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

                <script type="text/javascript" src="https://webapi.amap.com/maps?v=2.0&key=e3ced48c225defa79bea43d039a00ea0&plugin=AMap.AutoComplete"></script>
<script type="text/javascript" src="https://cache.amap.com/lbs/static/addToolbar.js"></script>
<style>

    .info {
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border-radius: .25rem;
        position: absolute;
        top: 2rem;
        background-color: white;
        width: auto;
        min-width: 22rem;
        border-width: 0;
        right: 4rem;
        box-shadow: 0 2px 6px 0 rgba(114, 124, 245, .5);
        z-index: 100;
    }

    .input-item {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-align: center;
        align-items: center;
        width: 100%;
        height: 3rem;
    }

    .input-item:last-child {
        margin-bottom: 0;
    }

    .input-item>select, .input-item>input[type=text], .input-item>input[type=date] {
        position: relative;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0;
    }

    .input-item>select:not(:last-child), .input-item>input[type=text]:not(:last-child), .input-item>input[type=date]:not(:last-child) {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0
    }

    .input-item>select:not(:first-child), .input-item>input[type=text]:not(:first-child), .input-item>input[type=date]:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0
    }

    .input-item-prepend {
        margin-right: -1px;
    }

    .input-item-text, input[type=text],input[type=date], select {
        height: calc(2.2rem + 2px);
    }

    .input-item-text {
        width: 6rem;
        text-align: justify;
        padding: 0.4rem 0.7rem;
        display: inline-block;
        text-justify: distribute-all-lines;
        /*ie6-8*/
        text-align-last: justify;
        /* ie9*/
        -moz-text-align-last: justify;
        /*ff*/
        -webkit-text-align-last: justify;
        /*chrome 20+*/
        -ms-flex-align: center;
        align-items: center;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
    }

    .input-item-text input[type=checkbox], .input-item-text input[type=radio] {
        margin-top: 0
    }

    #tipinput{ border: 1px solid #ced4da;}
    .amap-sug-result{ z-index: 1100;}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>更新物流站点信息</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="javascript:window.history.back(-1);">物流站点</a></li>
                        <li class="active">更新物流站点信息</li>
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
                    <h4>更新物流站点信息</h4>
                </div>
                <div class="card-body">

                    <form>
                        <input type="hidden" name="ids" value="<?php echo ($info["id"]); ?>"/>
                        <input type="hidden" name="lng" value='<?php echo ($info["lng"]); ?>'/>
                        <input type="hidden" name="lat" value='<?php echo ($info["lat"]); ?>'/>

                        <div class="row">
                            <div class="col-md-4">

                                <!--div class="form-group">
                                    <label>发货类型</label>
                                    <select name="from_type" class="form-control input-sm">
                                        <option value="">请选择</option>
                                        <option value="0" <?php echo ($info['from_type']==0?'selected':''); ?>>发货商店</option>
                                        <option value="1" <?php echo ($info['from_type']==1?'selected':''); ?>>取货商店</option>
                                        <option value="2" <?php echo ($info['from_type']==2?'selected':''); ?>>又发又收</option>
                                    </select>
                                </div-->
                                <div class="form-group">
                                    <label>站点名称</label>
                                    <input type="text" name="name" class="form-control input-sm" value='<?php echo ($info["name"]); ?>'/>
                                </div>
                                <div class="form-group">
                                    <label>站点电话</label>
                                    <input type="text" name="phone" class="form-control input-sm" value='<?php echo ($info["phone"]); ?>'/>
                                </div>
                                <div class="form-group">
                                    <label>站点地址</label>
                                    <input type="text" name="site_addr" id="addr" class="form-control input-sm" value='<?php echo ($info["site_addr"]); ?>'/>
                                </div>
                                <div class="form-group">
                                    <label>经纬度</label>
                                    <input type="text" id="loc" class="form-control input-sm" value='<?php echo ($info["lng"]); ?>,<?php echo ($info["lat"]); ?>'/>
                                </div>

                            </div>
                            <div class="col-md-8" style="position:relative;">
                                <div class="info">
                                    <div class="input-item">
                                        <div class="input-item-prepend">
                                            <span class="input-item-text" style="width:8rem;">请输入关键字</span>
                                        </div>
                                        <input id='tipinput' type="text">
                                    </div>
                                </div>
                                <div id="container" style="height:380px;"></div>
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

    var map = new AMap.Map("container", {
        resizeEnable: true, //是否监控地图容器尺寸变化
        zoom: 14, //初始地图级别
    });
    ////
    var mapPoint = new AMap.LngLat("<?php echo ($info["lng"]); ?>", "<?php echo ($info["lat"]); ?>");
    var marker = new AMap.Marker({position: mapPoint, title: "<?php echo ($info["site_addr"]); ?>"});
    map.add(marker);
    map.setCenter(mapPoint);

    ////
    var auto = new AMap.AutoComplete({input: "tipinput"});
    auto.on('select', function (e) {
        var poi = e.poi;
        var marker = new AMap.Marker({
            position: new AMap.LngLat(poi.location.lng, poi.location.lat),
            title: poi.name
        });
        map.clearMap();
        map.add(marker);
        map.setCenter(new AMap.LngLat(poi.location.lng, poi.location.lat));
        marker.on("click", function (e) {
            console.log(e);
            var param = {lng: e.lnglat.lng, lat: e.lnglat.lat};
            return setAddress(param);
        });
    });
    //为地图注册click事件获取鼠标点击出的经纬度坐标
    map.on('click', function (e) {
        var param = {lng: e.lnglat.getLng(), lat: e.lnglat.getLat()};
        return setAddress(param);
    });

    /**
     * 解析地图地址
     * @param {type} param
     * @returns {undefined}
     */
    function setAddress(param) {
        $.ajax({
            url: "<?php echo U('Shops/getAddr');?>",
            type: "post",
            data: param,
            dataType: "json",
            success: function (res) {
                if (res.status != 1) {
                    return layer.msg(res.msg);
                }
                $("#addr").val(res.data.full);
                $("#loc").val(param.lng + "," + param.lat);
                $("input[name='lng']").val(param.lng);
                $("input[name='lat']").val(param.lat);
            },
            error: function () {
                console.log(0);
            }
        });
    }

    /**
     * 更新
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/edits','model=trans_log');?>";
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