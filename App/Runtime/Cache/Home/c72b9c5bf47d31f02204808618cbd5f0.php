<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>易缆通APP后台管理中心</title>
        <link rel="shortcut icon" href="/Public/assets/images/app_logo.png" type="image/png">
        <link href="/Public/assets/css/lib/font-awesome.min.css" rel="stylesheet">
        <link href="/Public/assets/css/lib/themify-icons.css" rel="stylesheet">
        <link href="/Public/assets/css/lib/bootstrap.min.css" rel="stylesheet">
        <link href="/Public/assets/css/style.css" rel="stylesheet">
        <script src="/Public/assets/js/lib/jquery.min.js"></script>
        <script src="/Public/assets/js/lib/bootstrap.min.js"></script>
        <script src="/Public/libs/angular/angular.min.js"></script>
        <link href="/Public/libs/sweet-alert2/sweetalert2.min.css" rel="stylesheet">
        <script src="/Public/libs/sweet-alert2/sweetalert2.min.js"></script>
        <link href="/Public/libs/swiper/css/swiper.min.css" rel="stylesheet">
        <script src="/Public/libs/swiper/js/swiper.min.js"></script>
        <script src="/Public/libs/layer/layer.js"></script>
        <script src="/Public/libs/common.js"></script>
        <script src="/Public/libs/ajaxfileupload.js?v=3"></script>
        <style>
            html, body {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background-color: #f7f9fc !important;
                color: #1e293b;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            }

            /* 优化：适当加深顶部导航背景色，使其与整体页面不再显得过度割裂，呈现更好的现代工业质感 */
            .top-navbar-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background-color: #e8ecf2;
                border-bottom: 2px solid #cbd5e1;
                z-index: 1000;
                padding: 10px 15px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            }

            /* 修复：移动端适配，解除导航对内容的强行遮挡 */
            @media (max-width: 768px) {
                .top-navbar-wrapper {
                    position: relative;
                }
                .content-wrap {
                    margin-top: 10px !important;
                }
            }

            .navbar-container {
                display: flex;
                flex-direction: column;
                gap: 8px;
                max-width: 1920px;
                margin: 0 auto;
            }

            .navbar-row-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-bottom: 6px;
                border-bottom: 1px solid #cbd5e1;
            }

            /* 右上角管理员菜单及下拉样式：修复修改密码与退出登录未显示的缺陷 */
            .admin-menu-dropdown {
                position: relative;
                display: inline-block;
            }

            .user-profile-btn {
                display: flex;
                align-items: center;
                gap: 6px;
                background: #ffffff;
                border: 1px solid #cbd5e1;
                padding: 5px 12px;
                border-radius: 6px;
                font-size: 13px;
                font-weight: 600;
                color: #334155;
                cursor: pointer;
                transition: all 0.2s ease;
                box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            }

            .user-profile-btn:hover {
                background: #f8fafc;
                border-color: #94a3b8;
            }

            .admin-dropdown-menu {
                display: none;
                position: absolute;
                right: 0;
                top: 100%;
                margin-top: 6px;
                background: #ffffff;
                min-width: 150px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                z-index: 1100;
                overflow: hidden;
            }

            .admin-dropdown-menu a {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                font-size: 13px;
                color: #475569;
                text-decoration: none;
                transition: background 0.15s ease;
            }

            .admin-dropdown-menu a:hover {
                background: #f1f5f9;
                color: #0f172a;
                text-decoration: none;
            }

            .admin-menu-dropdown:hover .admin-dropdown-menu {
                display: block;
            }

            .navbar-sub-row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                width: 100%;
            }

            .nav-group-card {
                background: #ffffff;
                border-radius: 6px;
                padding: 6px 10px;
                border: 1px solid #cbd5e1;
                display: flex;
                align-items: center;
                gap: 8px;
                flex: 0 1 auto; 
                box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            }

            .nav-group-card.ai-group {
                border: 1px solid #0066cc;
                background: #eff6ff;
            }

            .nav-group-title {
                font-size: 11px;
                font-weight: 700;
                color: #475569;
                border-right: 1px solid #cbd5e1;
                padding-right: 8px;
                white-space: nowrap;
            }

            .capsule-list {
                display: flex;
                align-items: center;
                gap: 6px;
                flex-wrap: wrap;
            }

            .nav-capsule {
                padding: 4px 10px;
                background-color: #f8fafc;
                color: #475569;
                font-size: 12px;
                text-decoration: none;
                border-radius: 4px;
                border: 1px solid #cbd5e1;
                white-space: nowrap;
                transition: all 0.2s ease;
            }

            .nav-capsule:hover {
                background-color: #e2e8f0;
                color: #1e293b;
                text-decoration: none;
            }

            .nav-capsule.active {
                background-color: #0066cc !important;
                color: #ffffff !important;
                border-color: #0066cc !important;
            }

            .content-wrap {
                margin-top: 155px !important;
                padding: 15px;
            }

            .main {
                background: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
        </style>
    </head>

    <body>

        <div class="top-navbar-wrapper">
            <div class="navbar-container">
                <div class="navbar-row-top">
                    <div class="top-logo">
                        <a href="<?php echo U('Bords/index');?>" style="font-weight:700; color:#1e293b; text-decoration:none; display:flex; align-items:center; gap:8px;">
                            <img src="/Public/assets/images/app_logo.png" alt="易缆通Logo" style="height:22px; width:auto; border-radius:3px; object-fit:contain;">
                            <span>易缆管理中心</span>
                        </a>
                    </div>
                    <div class="top-user-area">
                        <!-- 修复：补全管理员账号下拉菜单，显式提供修改密码与安全退出功能入口 -->
                        <div class="admin-menu-dropdown">
                            <div class="user-profile-btn">
                                <i class="ti-user"></i> 管理员 <i class="ti-angle-down"></i>
                            </div>
                            <div class="admin-dropdown-menu">
                                <a href="<?php echo U('Login/update_pwd');?>"><i class="ti-key"></i> 修改密码</a>
                                <a href="<?php echo U('Login/logout');?>" style="color: #dc2626;"><i class="ti-power-off"></i> 退出登录</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="navbar-row-bottom">
                    <div class="navbar-sub-row">
                        <div class="nav-group-card">
                            <div class="nav-group-title">用户管理</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Users/index');?>" class="nav-capsule"><i class="ti-user"></i> 用户管理</a>
                                <a href="<?php echo U('Users/logrs');?>" class="nav-capsule"><i class="ti-stats-alt"></i> 登录统计</a>
                                <a href="<?php echo U('Users/search');?>" class="nav-capsule"><i class="ti-search"></i> 搜索记录</a>
                                <a href="<?php echo U('Users/levels');?>" class="nav-capsule"><i class="ti-medall"></i> 用户等级</a>
                            </div>
                        </div>

                        <div class="nav-group-card">
                            <div class="nav-group-title">计算配置</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Task/index');?>" class="nav-capsule"><i class="ti-reload"></i> 价格任务</a>
                                <a href="<?php echo U('NewLabel/index');?>" class="nav-capsule"><i class="ti-layout-grid2"></i> 材料分类</a>
                                <a href="<?php echo U('NewCate/index');?>" class="nav-capsule"><i class="ti-calculator"></i> 公式计算</a>
                                <a href="<?php echo U('NewTax/index');?>" class="nav-capsule"><i class="ti-receipt"></i> 税率标签</a>
                            </div>
                        </div>

                        <div class="nav-group-card">
                            <div class="nav-group-title">商品管理</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Goods/cats');?>" class="nav-capsule"><i class="ti-folder"></i> 商品分类</a>
                                <a href="<?php echo U('Goods/liner');?>" class="nav-capsule"><i class="ti-plug"></i> 线缆板块</a>
                                <a href="<?php echo U('Goods/peita');?>" class="nav-capsule"><i class="ti-package"></i> 配套板块</a>
                            </div>
                        </div>
                    </div>

                    <div class="navbar-sub-row" style="margin-top: 6px;">
                        <div class="nav-group-card">
                            <div class="nav-group-title">交易管理</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Shops/index');?>" class="nav-capsule"><i class="ti-shopping-cart"></i> 店铺管理</a>
                                <a href="<?php echo U('Order/index');?>" class="nav-capsule"><i class="ti-receipt"></i> 订单管理</a>
                                <a href="<?php echo U('ReportInfo/index');?>" class="nav-capsule"><i class="ti-files"></i> 报价单</a>
                            </div>
                        </div>

                        <div class="nav-group-card">
                            <div class="nav-group-title">系统配置</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Know/advs');?>" class="nav-capsule"> 广告管理</a>
                                <a href="<?php echo U('Know/helps');?>" class="nav-capsule"> 帮助中心</a>
                                <a href="<?php echo U('Know/sysc');?>" class="nav-capsule"> 系统文本</a>
                                <a href="<?php echo U('Sysc/banks');?>" class="nav-capsule"> 银行卡号</a>
                                <a href="<?php echo U('Version/index');?>" class="nav-capsule"> 系统版本</a>
                                <a href="<?php echo U('Bar/index');?>" class="nav-capsule"> Tab栏控制</a>
                                <a href="<?php echo U('Config/customer_config');?>" class="nav-capsule"> 客服配置</a>
                            </div>
                        </div>

                        <div class="nav-group-card ai-group">
                            <div class="nav-group-title" style="color:#0066cc;">AI智能中心</div>
                            <div class="capsule-list">
                                <a href="<?php echo U('Ai/index');?>" class="nav-capsule"><i class="ti-settings"></i> AI助手设置</a>
                                <a href="<?php echo U('Ai/knowledge');?>" class="nav-capsule"><i class="ti-book"></i> 纪律模版管理</a>
                                <a href="<?php echo U('Ai/searchWords');?>" class="nav-capsule"><i class="ti-search"></i> 搜索词管理</a>
                                <a href="<?php echo U('Ai/historyList');?>" class="nav-capsule"><i class="ti-list"></i> AI历史报价</a>
                                <a href="<?php echo U('Ai/print_quote');?>" class="nav-capsule"><i class="ti-file"></i> 报价单样式</a>
                                <a href="<?php echo U('Ai/testConnect');?>" class="nav-capsule" style="background:#e0f2fe; color:#0369a1; border-color:#bae6fd;"><i class="ti-pulse"></i> 测试专区</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid" style="padding: 24px 20px; background-color: #f5f5f7; min-height: 100vh;">
    <!-- 引入苹果风格的居中收敛容器，防止超宽屏下内容过度拉伸铺满屏幕 -->
    <div style="max-width: 1280px; margin: 0 auto;">
        
        <section id="main-content">
            <div class="row">
                <div class="col-lg-12" style="padding: 0;">
                    
                    <!-- 苹果风格极简卡片：大圆角、轻量自然阴影、纯净背景 -->
                    <div class="card alert" style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04); border: 1px solid rgba(0,0,0,0.02); margin-bottom: 0;">
                        
                        <div class="card-header" style="background: transparent; border-bottom: 1px solid #f2f2f7; padding: 20px 24px;">
                            <h4 style="font-size: 17px; font-weight: 600; color: #1d1d1f; margin: 0; letter-spacing: -0.2px;">登录日志统计</h4>
                        </div>
                        
                        <div class="card-body" style="padding: 24px;">

                            <!-- 优化搜索表单：收窄输入框长度，不让其铺满全屏，采用优雅的苹果交互间距 -->
                            <form action="<?php echo U('Users/logrs');?>" class="form-inline" style="margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
                                <div class="form-group" style="margin-bottom: 0; width: 300px; max-width: 100%;">
                                    <input type="text" name="phone" class="form-control input-sm" placeholder="请输入用户手机号码" style="width: 100%; height: 38px; border-radius: 8px; border: 1px solid #d2d2d7; padding: 0 14px; font-size: 14px; box-shadow: none; transition: all 0.2s;"/>
                                </div>
                                <button type="submit" class="btn btn-sm btn-info" style="height: 38px; padding: 0 20px; border-radius: 8px; background-color: #0071e3; border-color: #0071e3; font-weight: 400; font-size: 14px; box-shadow: 0 2px 6px rgba(0, 113, 227, 0.2);">查找账号</button>
                            </form>

                            <!-- 表格响应式容器：保证手机端横向滑动流畅、不崩塌 -->
                            <div class="table-responsive" style="border: none; overflow-x: auto;">
                                <table class="table table-hover" style="margin-bottom: 20px; white-space: nowrap; vertical-align: middle;">
                                    <thead>
                                        <tr style="background-color: #fbfbfd; color: #86868b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                                            <th style="padding: 12px 16px; border-bottom: 1px solid #e5e5ea;">#</th>
                                            <th style="padding: 12px 16px; border-bottom: 1px solid #e5e5ea;">登录账户</th>
                                            <th style="padding: 12px 16px; border-bottom: 1px solid #e5e5ea;">账号备注</th>
                                            <th style="padding: 12px 16px; border-bottom: 1px solid #e5e5ea;">IP</th>
                                            <th style="padding: 12px 16px; border-bottom: 1px solid #e5e5ea;">省份</th>
                                            <th style="padding: 12px 16px; border-bottom: 1px solid #e5e5ea;">城市</th>
                                            <th style="padding: 12px 16px; border-bottom: 1px solid #e5e5ea;">地区</th>
                                            <th width="15%" style="padding: 12px 16px; border-bottom: 1px solid #e5e5ea;">记录时间</th>
                                            <!--th width="10%">管理</th-->
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr style="font-size: 13px; color: #1d1d1f; transition: background-color 0.15s;">
                                            <th scope="row" style="padding: 14px 16px; border-top: 1px solid #f2f2f7; color: #86868b; font-weight: 400;"><?php echo ($v["id"]); ?></th>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7; font-weight: 500;"><?php echo (getUsersName($v['uid'],'phone',$uid)); ?></td>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7; color: #515154;"><?php echo (getUsersName($v['uid'],'tags',$uid)); ?></td>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; color: #515154;"><?php echo ($v["ip"]); ?></td>
                                            <?php if($v['prov_name'] != ''): ?><td style="padding: 14px 16px; border-top: 1px solid #f2f2f7;"><?php echo ($v['prov_name']); ?></td>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7;"><?php echo ($v['city_name']); ?></td>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7;"><?php echo ($v['label_name']); ?></td>
                                            <?php else: ?>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7;"><?php echo (getRegionName($v['prov'],$prov)); ?></td>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7;"><?php echo (getRegionName($v['city'],$city)); ?></td>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7;"><?php echo (getRegionName($v['label'],$label)); ?></td><?php endif; ?>
                                            <td style="padding: 14px 16px; border-top: 1px solid #f2f2f7; color: #86868b;"><?php echo (date('Y/m/d H:i:s',$v["times"])); ?></td>
                                            <!--td style="padding: 14px 16px; border-top: 1px solid #f2f2f7;">
                                                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                                            </td-->
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                    </tbody>
                                </table>

                                <!-- 分页组件靠右优雅对齐 -->
                                <nav aria-label="Page navigation" style="text-align: right; margin-top: 20px;">
                                    <ul class="pagination" style="margin: 0;"><?php echo ($list["show"]); ?></ul>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        
    </div>
</div>

<script>

    /**
     * 添加
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('Core/addon','model=shops');?>";
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

        <script>
            $(document).ready(function() {
                var currentUrl = window.location.href.toLowerCase();
                var currentPath = window.location.pathname.toLowerCase();
                
                $('.nav-capsule').removeClass('active');
                
                var matched = false;
                $('.nav-capsule').each(function() {
                    var hrefVal = $(this).attr('href');
                    if (hrefVal) {
                        var cleanHref = hrefVal.toLowerCase().replace(/['"()]/g, '');
                        var segments = cleanHref.split('/');
                        var lastSegment = segments[segments.length - 1]; 
                        var secondLast = segments.length > 1 ? segments[segments.length - 2] : ''; 
                        var compositeKey = secondLast && lastSegment ? (secondLast + '/' + lastSegment) : '';

                        if (compositeKey && (currentUrl.indexOf(compositeKey) !== -1 || currentPath.indexOf(compositeKey) !== -1)) {
                            $(this).addClass('active');
                            matched = true;
                            return false; 
                        }
                    }
                });

                if (!matched) {
                    var $capsules = $('.nav-capsule').toArray();
                    $capsules.sort(function(a, b) {
                        return $(b).attr('href').length - $(a).attr('href').length;
                    });

                    for (var i = 0; i < $capsules.length; i++) {
                        var $item = $($capsules[i]);
                        var hrefVal = $item.attr('href');
                        if (hrefVal) {
                            var cleanHref = hrefVal.toLowerCase().replace(/['"()]/g, '');
                            var segments = cleanHref.split('/');
                            var lastSegment = segments[segments.length - 1];
                            
                            if (lastSegment && lastSegment.length > 2) {
                                if (currentUrl.indexOf('/' + lastSegment) !== -1 || currentPath.indexOf('/' + lastSegment) !== -1 || currentUrl.endsWith(lastSegment)) {
                                    $item.addClass('active');
                                    matched = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </body>
</html>