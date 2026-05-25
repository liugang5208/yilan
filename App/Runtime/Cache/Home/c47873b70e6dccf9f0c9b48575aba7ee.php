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
    .contact-information h4, .basic-information h4{ margin-bottom:0px; font-weight:bold;}
    .contact-title{ font-size:12px; padding-bottom:5px;}
    .mail-address{ font-size:12px;}

    .recent-comment .media-left img{ border-radius:0px; vertical-align:middle; width:100%;}
    .media-left{ overflow:hidden; width:30%;}
    .media-body{ font-size:12px;}
    .list-goods{ font-size:12px;}
</style>

<div class="container-fluid" ng-app="myApp" ng-controller="myCtrl">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>详情</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="<?php echo U('ReportInfo/index');?>">列表</a></li>
                        <li class="active">详情</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->
    <section id="main-content">

        <div class="card alert">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-5">
                        <div class="basic-information">
                            <h4>基本信息</h4>
                            <div class="birthday-content">
                                <span class="contact-title">logo:</span>
                                
                                <span class="mail-address">
                                    <?php if($info.logo): ?><img class="media-object" src="<?php echo ($info["logo"]); ?>" ><?php endif; ?>
                                </span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">用户:</span>
                                <span class="mail-address"><?php echo (getUsersName($info['uid'],'nickname',$user)); ?>(<?php echo (getUsersName($info['uid'],'phone',$user)); ?>)</span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">报价单(价格)调整比例:</span>
                                <span class="mail-address"><?php echo ($info["ratio"]); ?></span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">是否含票:</span>
                                <span class="mail-address">
                                    <?php echo ($info['ticket']==0?'不含税票':''); ?>
                                    <?php echo ($info['ticket']==1?'增值税普通税票':''); ?>
                                    <?php echo ($info['ticket']==2?'增值税专用税票':''); ?>
                                </span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">总金额:</span>
                                <span class="mail-address"><?php echo ($info["money"]); ?></span>
                            </div>


                        </div>
                        <div class="basic-information">
                            <h4>报价单备注信息</h4>
                            <div class="birthday-content">
                                <span class="contact-title">结算方式:</span>
                                <span class="mail-address"><?php echo ($info["check_type"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">运输方式:</span>
                                <span class="mail-address"><?php echo ($info["trans_type"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">运输费用:</span>
                                <span class="mail-address"><?php echo ($info["fees_out"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">包装选项:</span>
                                <span class="mail-address"><?php echo ($info["pack_recyle"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">询价单位:</span>
                                <span class="mail-address"><?php echo ($info["question_comp"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">项目名称:</span>
                                <span class="mail-address"><?php echo ($info["project_comp"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">报价单位:</span>
                                <span class="mail-address"><?php echo ($info["rep_comp"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">使用单位:</span>
                                <span class="mail-address"><?php echo ($info["use_comp"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">生产周期:</span>
                                <span class="mail-address"><?php echo ($info["pro_time"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">报价人员:</span>
                                <span class="mail-address"><?php echo ($info["rep_user"]); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">报价日期:</span>
                                <span class="mail-address"><?php echo ($info["rep_date"]); ?></span>
                            </div>
                           
                            
                            <div class="gender-content">
                                <span class="contact-title">备注:</span>
                                <span class="mail-address"><?php echo ($info["tags"]); ?></span>
                            </div>
                            
                            
                        </div>

                        


                    </div>
                    <div class="col-md-6">
                        <div class="basic-information">
                            <h4>商品</h4>

                            <div class="recent-comment m-t-15">
                                <?php if(is_array($goods["list"])): $i = 0; $__LIST__ = $goods["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="media">
                                        <!--<h4 class="media-heading color-primary"><?php echo ($v["name"]); ?></h4>-->
                                       
                                        <?php if($v["types"] == 0): ?><div class="media-body">
                                                <p><?php echo ($v["attr1"]); ?></p>
                                                <p><?php echo ($v["attr2"]); ?></p>
                                                <p><?php echo ($v["attr3"]); ?></p>
                                                <p>计量单位：<?php echo ($v["unit"]); ?></p>
                                                <p>标准名称：<?php echo ($v["catname"]); ?></p>
                                            </div>
                                            <br/>
                                            <div class="row text-center list-goods">
                                                <div class="col-md-6">购买数量</div>
                                                <div class="col-md-6">单品价格</div>
                                            </div>
                                            <div class="row text-center list-goods">
                                                <div class="col-md-6"><?php echo ($v["nums"]); ?></div>
                                                <div class="col-md-6"><?php echo ($v["market"]); ?></div>
                                            </div><?php endif; ?>
                                        <?php if($v["types"] == 1): ?><div class="media-body">
                                                <p><?php echo ($v["attr1"]); ?></p>
                                                <p><?php echo ($v["attr2"]); ?></p>
                                                <p><?php echo ($v["attr3"]); ?></p>
                                                <p>计量单位：<?php echo ($v["unit"]); ?></p>
                                            </div>
                                            <br/>
                                            <div class="row text-center list-goods">
                                                <div class="col-md-3">标准名称</div>
                                                <div class="col-md-3">规格名称</div>
                                                <div class="col-md-3">购买数量</div>
                                                <div class="col-md-3">单品价格</div>
                                            </div>
                                            <?php if(is_array($v["child"])): $i = 0; $__LIST__ = $v["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><div class="row text-center list-goods">
                                                    <div class="col-md-3"><?php echo ($s["catname"]); ?></div>
                                                    <div class="col-md-3"><?php echo ($s["info"]["name"]); ?></div>
                                                    <div class="col-md-3"><?php echo ($s["nums"]); ?></div>
                                                    <div class="col-md-3"><?php echo ($s["info"]["market"]); ?></div>
                                                </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
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