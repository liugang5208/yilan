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

                <div class="container-fluid">
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
                    <ol class="breadcrumb text-right">
                        <li><a href="<?php echo U('Users/index');?>">注册用户</a></li>
                        <li class="active">注册用户</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->
    <section id="main-content">

        <div class="card alert">
            <div class="card-header">
                <h4>注册用户详情</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="user-photo m-b-10">
                                    <img class="img-responsive" src="/Public/uploads<?php echo ($info["headimgurl"]); ?>" alt="">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="user-profile-name"><?php echo ($info["nickname"]); ?></div>
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">个人信息</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="contact-information">
                                                <div class="phone-content">
                                                    <span class="contact-title">账户类别</span>
                                                    <span class="phone-number"><?php echo (acType($info['ac_type'],$ac_type)); ?></span>
                                                </div>
                                                <div class="phone-content">
                                                    <span class="contact-title">用户等级</span>
                                                    <span class="phone-number"><?php echo (getUsersLv($info['ac_level'],$ac_level)); ?></span>
                                                </div>
                                                <div class="website-content">
                                                    <span class="contact-title">签约用户</span>
                                                    <span class="contact-website"><?php echo ($info['ac_credit']>0?'是':'否'); ?></span>
                                                </div>
                                                <div class="skype-content">
                                                    <span class="contact-title">电话</span>
                                                    <span class="contact-skype"><?php echo ($info["phone"]); ?></span>
                                                </div>
                                                <div class="address-content">
                                                    <span class="contact-title">省份</span>
                                                    <span class="mail-address"><?php echo ($info["p_name"]); ?></span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">城市</span>
                                                    <span class="gender"><?php echo ($info["c_name"]); ?></span>
                                                </div>
                                                <div class="phone-content">
                                                    <span class="contact-title">地区</span>
                                                    <span class="phone-number"><?php echo ($info["l_name"]); ?></span>
                                                </div>
                                                <div class="phone-content">
                                                    <span class="contact-title">街道</span>
                                                    <span class="phone-number"><?php echo ($info["street"]); ?></span>
                                                </div>
                                                <div class="birthday-content">
                                                    <span class="contact-title">姓名</span>
                                                    <span class="birth-date"><?php echo ($info["name"]); ?></span>
                                                </div>
                                                <div class="phone-content">
                                                    <span class="contact-title">身份证号</span>
                                                    <span class="phone-number"><?php echo ($info["idcard"]); ?></span>
                                                </div>
                                                <div class="phone-content">
                                                    <span class="contact-title">联系人</span>
                                                    <span class="phone-number"><?php echo ($info["manager"]); ?></span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">联系电话</span>
                                                    <span class="contact-email"><?php echo ($info["maphone"]); ?></span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">微信</span>
                                                    <span class="contact-email"><?php echo ($info["wechat"]); ?></span>
                                                </div>
                                                <div class="address-content">
                                                    <span class="contact-title">邮箱</span>
                                                    <span class="mail-address"><?php echo ($info["email"]); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4>身份证正面</h4>
                                    </div>
                                    <div class="card-body">
                                        <img src="/Public/uploads<?php echo ($info["pic_id"]); ?>" class="img-rounded img-responsive" alt="身份证正面">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4>身份证反面</h4>
                                    </div>
                                    <div class="card-body">
                                        <img src="/Public/uploads<?php echo ($info["pic_back"]); ?>" class="img-rounded img-responsive" alt="身份证反面">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4>营业执照</h4>
                                    </div>
                                    <div class="card-body">
                                        <img src="/Public/uploads<?php echo ($info["pic_head"]); ?>" class="img-rounded img-responsive" alt="营业执照">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card alert">
                                    <div class="card-header">
                                        <h4>开户许可</h4>
                                    </div>
                                    <div class="card-body">
                                        <img src="/Public/uploads<?php echo ($info["pic_cont"]); ?>" class="img-rounded img-responsive" alt="开户许可">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

            </div>
        </div>
        <!-- nano scroller -->
        <script src="/Public/assets/js/lib/menubar/sidebar.js"></script>
        <script src="/Public/assets/js/lib/preloader/pace.min.js"></script>
        <!-- scripit init-->
        <script type="text/javascript" src="/Public/assets/js/scripts.js"></script>
    </body>

</html>