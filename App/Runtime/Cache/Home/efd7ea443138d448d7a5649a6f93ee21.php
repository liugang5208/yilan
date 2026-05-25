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
                    <h1>订单详情</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="<?php echo U('Order/index');?>">订单列表</a></li>
                        <li class="active">订单详情</li>
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
                                <span class="contact-title">订单号:</span>
                                <span class="mail-address"><?php echo ($info["sn"]); ?></span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">下单用户:</span>
                                <span class="mail-address"><?php echo (getUsersName($info['uid'],'nickname',$user)); ?>(<?php echo (getUsersName($info['uid'],'phone',$user)); ?>)</span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">订单金额:</span>
                                <span class="mail-address"><?php echo ($info["ori_money"]); ?></span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">支付金额:</span>
                                <span class="mail-address"><?php echo ($info["money"]); ?></span>
                            </div>

                            <?php if($info["paymode"] == 3): ?><div class="gender-content">
                                    <span class="contact-title">支付凭据:</span>
                                    <span class="mail-address">
                                        <a href="/Public/uploads<?php echo ($info["save_imgs"]); ?>" class="btn btn-link btn-xs">查看</a>
                                    </span>
                                </div><?php endif; ?>

                        </div>
                        <div class="basic-information">
                            <h4>其它信息</h4>
                            <div class="birthday-content">
                                <span class="contact-title">创建时间:</span>
                                <span class="mail-address"><?php echo (date('Y-m-d H:i:s',$info["times"])); ?></span>
                            </div>
                            <div class="birthday-content">
                                <span class="contact-title">支付方式:</span>
                                <span class="mail-address"><?php echo (acPay($info['paymode'],$paymode)); ?></span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">支付时间:</span>
                                <span class="mail-address"><?php echo (fromDate($info['paytime'],$info["paytime"])); ?></span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">是否附带销售清单:</span>
                                <span class="mail-address">
                                    <?php echo ($info['needlist']==0?'否':''); ?>
                                    <?php echo ($info['needlist']==1?'是':''); ?>
                                </span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">买家留言:</span>
                                <span class="mail-address"><?php echo ($info["tags"]); ?></span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">是否含票:</span>
                                <span class="mail-address">
                                    <?php echo ($info['ticket']==0?'不含税票':''); ?>
                                    <?php echo ($info['ticket']==1?'普通发票':''); ?>
                                    <?php echo ($info['ticket']==2?'专用发票':''); ?>
                                </span>
                            </div>
                            <div class="gender-content">
                                <span class="contact-title">是否含运费:</span>
                                <span class="mail-address">
                                    <?php echo ($info['trans']==0?'否':''); ?>
                                    <?php echo ($info['trans']==1?'是':''); ?>
                                </span>
                            </div>
                        </div>

                        <?php if($info["ticket"] > 0): ?><div class="contact-information">
                                <h4>开票信息</h4>
                                <div class="phone-content">
                                    <span class="contact-title">开票公司:</span>
                                    <span class="mail-address"><?php echo (getTicketComp($info['ticket_comp'],'comp_name',$ticket_comp)); ?></span>
                                </div>
                                <div class="phone-content">
                                    <span class="contact-title">公司税号:</span>
                                    <span class="mail-address"><?php echo (getTicketComp($info['ticket_comp'],'comp_tex',$ticket_comp)); ?></span>
                                </div>
                                <div class="phone-content">
                                    <span class="contact-title">公司地址:</span>
                                    <span class="mail-address"><?php echo (getTicketComp($info['ticket_comp'],'comp_addr',$ticket_comp)); ?></span>
                                </div>
                                <div class="phone-content">
                                    <span class="contact-title">公司电话:</span>
                                    <span class="mail-address"><?php echo (getTicketComp($info['ticket_comp'],'comp_tele',$ticket_comp)); ?></span>
                                </div>
                                <div class="phone-content">
                                    <span class="contact-title">开户行:</span>
                                    <span class="mail-address"><?php echo (getTicketComp($info['ticket_comp'],'comp_bank',$ticket_comp)); ?></span>
                                </div>
                                <div class="phone-content">
                                    <span class="contact-title">银行账户:</span>
                                    <span class="mail-address"><?php echo (getTicketComp($info['ticket_comp'],'bank_id',$ticket_comp)); ?></span>
                                </div>
                                <div class="phone-content">
                                    <span class="contact-title">开户行号:</span>
                                    <span class="mail-address"><?php echo (getTicketComp($info['ticket_comp'],'bank_sn',$ticket_comp)); ?></span>
                                </div>
                                <div class="address-content">
                                    <span class="contact-title">发票备注:</span>
                                    <span class="mail-address"><?php echo ($info["ticket_tag"]); ?></span>
                                </div>
                                <div class="email-content">
                                    <span class="contact-title">配送地址:</span>
                                    <span class="mail-address">
                                        <?php echo ($ticaddr["name"]); ?>(<?php echo ($ticaddr["phone"]); ?>)&nbsp;
                                        <?php echo ($ticaddr["p_name"]); echo ($ticaddr["c_name"]); echo ($ticaddr["l_name"]); echo ($ticaddr["street"]); ?>
                                    </span>
                                </div>
                            </div><?php endif; ?>

                        <div class="contact-information">
                            <h4>下单地址</h4>
                            <div class="phone-content">
                                <span class="contact-title">收件人:</span>
                                <span class="mail-address"><?php echo ($addr["name"]); ?></span>
                            </div>
                            <div class="address-content">
                                <span class="contact-title">收件人电话:</span>
                                <span class="mail-address"><?php echo ($addr["phone"]); ?></span>
                            </div>
                            <div class="email-content">
                                <span class="contact-title">收件人地址:</span>
                                <span class="mail-address"><?php echo ($addr["p_name"]); echo ($addr["c_name"]); echo ($addr["l_name"]); echo ($addr["street"]); ?></span>
                            </div>
                        </div>

                        <?php if($info["paymode"] == 2): ?><div class="contact-information">
                                <h4>代发货地址</h4>
                                <div class="phone-content">
                                    <span class="contact-title">收件人:</span>
                                    <span class="mail-address"><?php echo ($info["save_name"]); ?></span>
                                </div>
                                <div class="address-content">
                                    <span class="contact-title">收件人电话:</span>
                                    <span class="mail-address"><?php echo ($info["save_phone"]); ?></span>
                                </div>
                                <div class="email-content">
                                    <span class="contact-title">收件人地址:</span>
                                    <span class="mail-address"><?php echo ($info["save_addr"]); ?></span>
                                </div>
                            </div><?php endif; ?>

                    </div>
                    <div class="col-md-4">
                        <div class="basic-information">
                            <h4>订单商品</h4>

                            <div class="recent-comment m-t-15">
                                <?php if(is_array($goods["list"])): $i = 0; $__LIST__ = $goods["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="media">
                                        <h4 class="media-heading color-primary"><?php echo ($v["name"]); ?></h4>
                                        <div class="media-left">
                                            <img class="media-object" src="<?php echo ($v["imgs"]); ?>">
                                        </div>
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
                    <div class="col-md-3">
                        <div class="basic-information">
                            <h4>订单物流</h4>

                            <?php if($info["status"] > 1): ?><div class="birthday-content">
                                    <span class="contact-title">到货区域:</span>
                                    <span class="mail-address"><?php echo ($trans["label"]); ?></span>
                                </div>
                                <div class="gender-content">
                                    <span class="contact-title">承运物流:</span>
                                    <span class="mail-address"><?php echo ($trans["trans"]); ?></span>
                                </div>
                                <div class="birthday-content">
                                    <span class="contact-title">物流单号:</span>
                                    <span class="mail-address"><?php echo ($trans["trans_sn"]); ?></span>
                                </div>
                                <div class="gender-content">
                                    <span class="contact-title">货物编号:</span>
                                    <span class="mail-address"><?php echo ($trans["trade_sn"]); ?></span>
                                </div>
                                <div class="gender-content">
                                    <span class="contact-title">收货人员:</span>
                                    <span class="mail-address"><?php echo ($trans["save_name"]); ?></span>
                                </div>

                                <div class="gender-content">
                                    <span class="contact-title">收货电话:</span>
                                    <span class="mail-address"><?php echo ($trans["save_phone"]); ?></span>
                                </div>
                                <div class="gender-content">
                                    <span class="contact-title">代收货款:</span>
                                    <span class="mail-address"><?php echo ($trans["agent_money"]); ?></span>
                                </div>
                                <div class="gender-content">
                                    <span class="contact-title">物流运费:</span>
                                    <span class="mail-address"><?php echo ($trans["trans_fee"]); ?></span>
                                </div>
                                <div class="gender-content">
                                    <span class="contact-title">物流电话:</span>
                                    <span class="mail-address"><?php echo ($trans["trans_phone"]); ?></span>
                                </div>
                                <div class="gender-content">
                                    <span class="contact-title">取货地址:</span>
                                    <span class="mail-address"><?php echo ($trans["get_addr"]); ?></span>
                                </div>
                                <div class="gender-content">
                                    <span class="contact-title">发货回执:</span>
                                    <span class="mail-address">
                                        <a href="/Public/uploads/trans_tik/<?php echo ($trans["trans_imgs"]); ?>" class="btn btn-link btn-xs" target="_blank">查看</a>
                                    </span>
                                </div><?php endif; ?>
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