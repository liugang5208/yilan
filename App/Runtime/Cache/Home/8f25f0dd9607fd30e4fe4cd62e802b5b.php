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
                    <h1>分类</h1>
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
                <div class="card alert" style="width:100%">
                    <div class="card-header">
                        <h4>分类</h4>
                        <div class="card-header-right-icon">
                            <ul>
                                <li class="doc-link">
                                    <a class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal">添加</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                             <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div style="">
                                     <div class="line-1" style="height:30px;display:flex;justify-content:space-between" >
                                        <div>
                                             <?php echo ($v["name"]); ?>
                                        </div>
                                            
                                        <div>     
                                          <a ng-click="updateinfo('<?php echo ($v["id"]); ?>')" class="btn btn-info btn-xs">编辑</a>
                                          <a ng-click="updateinfo2('<?php echo ($v["id"]); ?>')" class="btn btn-info btn-xs">添加导体</a>
                                          <a class="btn btn-danger btn-xs" ng-click="dels('<?php echo ($v["id"]); ?>')">删除</a>
                                        </div>
                                         
                                     </div>

                                     <div class="line-2" style="display:flex;flex-wrap:wrap;align-content: space-around;width:100%;flex-direction: row;margin-top:-10px">
                                         <?php if(is_array($v["children"])): $i = 0; $__LIST__ = $v["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><div style="width:16%;display:flex;margin-top:5px">
                                                 <div style="width:120px;display:flex;">
                                                         <div style="color: <?php echo ($v2['pid'] > 0) ? 'blue' : 'inherit'; ?>;"><?php echo ($v2["name"]); ?>:</div>
                                                    <div style="margin-left:5px"> <?php echo ($v2["price"]); ?></div>
                                                 </div>
                                             
                                             
                                             <a style="margin-left:5px;height:22px" ng-click="updateinfo3('<?php echo ($v2["id"]); ?>')" class="btn btn-info btn-xs">调价</a>
                                             <a style="margin-left:5px;height:22px" class="btn btn-danger btn-xs" ng-click="dels('<?php echo ($v2["id"]); ?>')">删除</a>
                                             </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                     </div>
                                
                                 </div>
                                 <hr><?php endforeach; endif; else: echo "" ;endif; ?>        
                            
                            
                            <!--<table class="table">-->
                            <!--    <thead>-->
                            <!--        <tr>-->
                            <!--            <th width="50px">#</th>-->
                            <!--            <th >名称</th>-->
                            <!--            <th >执行价格</th>-->
                                        <!--<th width="50px">状态</th>-->
                            <!--            <th width="20%">记录时间</th>-->
                            <!--            <th width="20%">管理</th>-->
                            <!--        </tr>-->
                            <!--    </thead>-->
                            <!--    <tbody>-->

                            <!--    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>-->
                            <!--        <tr>-->
                            <!--            <th scope="row"><?php echo ($v["id"]); ?></th>-->
                            <!--            <td><?php echo ($v["tree_label"]); echo ($v["name"]); ?></td>-->
                            <!--            <td>-->
                            <!--                 <?php if($v["cate_label_id"] == 0 ): ?>-->
                            <!--<?php endif; ?>-->
                            <!--                  <?php if($v["cate_label_id"] != 0 ): ?>-->
                            <!--                      <?php echo ($v["price"]); ?>-->
                            <!--<?php endif; ?> -->
                            <!--            </td>-->
                                        <!--<td><?php echo ($v['status']>0?'正常':'暂停使用'); ?></td>-->
                            <!--            <td><?php echo (date('Y/m/d H:i:s',$v["add_time"])); ?></td>-->
                            <!--            <td>-->
                            <!--            <?php if($v["cate_label_id"] == 0 ): ?>-->
                            <!--                <a ng-click="updateinfo('<?php echo ($v["id"]); ?>')" class="btn btn-info btn-xs">编辑</a>-->
                            <!--                <a ng-click="updateinfo2('<?php echo ($v["id"]); ?>')" class="btn btn-info btn-xs">添加导体</a>-->
                            <!--<?php endif; ?>    -->
                            <!--            <?php if($v["cate_label_id"] != 0 ): ?>-->
                            <!--                <a ng-click="updateinfo3('<?php echo ($v["id"]); ?>')" class="btn btn-info btn-xs">调价</a>-->
                            <!--<?php endif; ?>  -->
                            <!--                <a class="btn btn-danger btn-xs" ng-click="dels('<?php echo ($v["id"]); ?>')">删除</a>-->
                            <!--            </td>-->
                            <!--        </tr>-->
                            <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->

                            <!--    </tbody>-->
                            <!--</table>-->

                            <!--<nav aria-label="Page navigation">-->
                            <!--    <ul class="pagination"><?php echo ($list["show"]); ?></ul>-->
                            <!--</nav>-->

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
                    <h4 class="modal-title" id="myModalLabel">添加</h4>
                </div>
                <div class="modal-body">

                    <form name="ador">
                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control"/>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label>状态</label>-->
                        <!--    <select name="status" class="form-control">-->
                        <!--        <option value="1">使用</option>-->
                        <!--        <option value="0">暂停</option>-->
                        <!--    </select>-->
                        <!--</div>-->
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
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更新</h4>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control" ng-model="infos.name"/>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label>状态</label>-->
                        <!--    <select name="status" class="form-control" ng-model="infos.status">-->
                        <!--        <option value="1">使用</option>-->
                        <!--        <option value="0">暂停</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="updateCats()">更新</button>
                </div>
            </div>
        </div>
    </div>
    
        <!-- Modal 添加下级 -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加导体</h4>
                </div>
                <div class="modal-body">

                    <form name="ador2">
                          
                          <input ng-hide="true" name="cate_label_id" class="form-control" ng-model="infos.cate_label_id"/>
                        
                        <div class="form-group">
                            <label>材料名称</label>
                            <input type="text" name="name" class="form-control"/>
                        </div>
                        
                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                 <label>材料一名称</label>
                                <select name="pid" ng-model="infos.pid" class="form-control">
                                    <option value="0">暂不选择</option>
                                     <option  value="{{v.id}}" ng-repeat="v in infos.cate_list">{{v.name}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>关联比例</label>
                                <input type="number" name="ratio" ng-change="onChangeRatio()" ng-model="infos.ratio" class="form-control"/>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                 <label>材料二名称</label>
                                <select name="pid2" ng-model="infos.pid2" class="form-control">
                                    <option value="0">暂不选择</option>
                                     <option  value="{{v.id}}" ng-repeat="v in infos.cate_list">{{v.name}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>关联比例</label>
                                <input type="number" name="ratio2" ng-change="onChangeRatio()" ng-model="infos.ratio2" class="form-control"/>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                 <label>材料三名称</label>
                                <select name="pid3" ng-model="infos.pid3" class="form-control">
                                    <option value="0">暂不选择</option>
                                     <option  value="{{v.id}}" ng-repeat="v in infos.cate_list">{{v.name}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>关联比例</label>
                                <input type="number" name="ratio3" ng-change="onChangeRatio()" ng-model="infos.ratio3" class="form-control"/>
                            </div>
                        </div>
                        
                    </div>    
                    
                     <div class="form-group">
                            <label>组合工费比例</label>
                            <input type="number" name="end_ratio" ng-change="onChangeRatio2()" ng-model="infos.end_ratio" class="form-control"/>
                    </div>
                        
                        <div class="form-group">
                            <label>执行价格</label>
                            <input type="text" name="price" ng-model="infos.price" class="form-control chang_price"/>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label>状态</label>-->
                        <!--    <select name="status" class="form-control">-->
                        <!--        <option value="1">使用</option>-->
                        <!--        <option value="0">暂停</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="addor2()">添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myEdit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">调价</h4>
                </div>
                <div class="modal-body">

                    <form>
                        <input ng-hide="true" name="cate_label_id" class="form-control" ng-model="infos.cate_label_id"/>
                        
                        <div class="form-group">
                            <label>名称</label>
                            <input type="text" name="name" class="form-control" ng-model="infos.name"/>
                        </div>
                        
                <div class="row">
                        
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>材料一名称</label>
                            <select ng-model="infos.pid" ng-change="onSelectChange()" class="form-control">
                                <option value="0">暂不选择</option>
                                 <option  value="{{v.id}}" ng-repeat="v in infos.cate_list">{{v.name}}</option>
                            </select>
                        </div>
                        
                         <div class="form-group">
                            <label>关联比例</label>
                            <input type="number" ng-change="onChangeRatio()" name="ratio" ng-model="infos.ratio" class="form-control"/>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>材料二名称</label>
                            <select ng-model="infos.pid2" ng-change="onSelectChange()" class="form-control">
                                <option value="0">暂不选择</option>
                                 <option  value="{{v.id}}" ng-repeat="v in infos.cate_list">{{v.name}}</option>
                            </select>
                        </div>
                        
                         <div class="form-group">
                            <label>关联比例</label>
                            <input type="number" ng-change="onChangeRatio()" name="ratio2" ng-model="infos.ratio2" class="form-control"/>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>材料三名称</label>
                            <select ng-model="infos.pid3" ng-change="onSelectChange()" class="form-control">
                                <option value="0">暂不选择</option>
                                 <option  value="{{v.id}}" ng-repeat="v in infos.cate_list">{{v.name}}</option>
                            </select>
                        </div>
                        
                         <div class="form-group">
                            <label>关联比例</label>
                            <input type="number" ng-change="onChangeRatio()" name="ratio3" ng-model="infos.ratio3" class="form-control"/>
                        </div>
                    </div> 
                </div>
                         <div class="form-group">
                            <label>组合工费比例</label>
                            <input type="number" name="end_ratio" ng-change="onChangeRatio2()" ng-model="infos.end_ratio" class="form-control"/>
                    </div>
                        
                        
                        <div class="form-group">
                            <label>执行价格</label>
                            <input type="text" name="price" class="form-control chang_price" ng-model="infos.price"/>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label>状态</label>-->
                        <!--    <select name="status" class="form-control" ng-model="infos.status">-->
                        <!--        <option value="1">使用</option>-->
                        <!--        <option value="0">暂停</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <!--<button type="button" class="btn btn-primary" ng-click="edit()">更新</button>-->
                    <button type="button" class="btn btn-primary" ng-click="edit()" ng-disabled="isRequesting">
                        <span ng-if="isRequesting" class="spinner"></span>
                        <span ng-if="!isRequesting">更新</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>


<style>
    
    .btn-primary.disabled,
.btn-primary[disabled] {
    
    cursor: not-allowed; /* 禁止点击的鼠标样式 */
}

.spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid #ccc; /* 外圈颜色 */
    border-top-color: #333; /* 顶部颜色，形成转圈圈效果 */
    border-radius: 50%;
    animation: spin 1s linear infinite; /* 动画效果 */
    margin-right: 8px; /* 与文本之间的间距 */
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>

<script>
  function changePid(){
      
  }
  
 function addor2() {
        var temp = $("form[name='ador2']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('NewLabel/add','model=new_label');?>";
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
     * 添加
     * @returns {undefined}
     */
    function addor() {
        var temp = $("form[name='ador']").serializeArray();
        var data = objToArray(temp);
        var baseurl = "<?php echo U('NewLabel/add','model=new_label');?>";
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

    var app = angular.module('myApp', []);
    app.controller('myCtrl', function ($scope, $http) {
        $scope.isRequesting = false;
        $scope.infos;
    
    $scope.onChangeRatio = function(){
        if($scope.infos.pid > 0 || $scope.infos.pid2 > 0 || $scope.infos.pid3 > 0){
                var cate = '';
            $scope.infos.cate_list.forEach(function(item) {
                
                if(item.id == $scope.infos.pid){
                    cate = item;
                }
            });
            
            var cate2 = '';
            $scope.infos.cate_list.forEach(function(item) {
                
                if(item.id == $scope.infos.pid2){
                    cate2 = item;
                }
            });
            var cate3 = '';
            $scope.infos.cate_list.forEach(function(item) {
                
                if(item.id == $scope.infos.pid3){
                    cate3 = item;
                }
            });
             
            if(cate || cate2 || cate3){
                
                $(".chang_price").attr("disabled", "disabled");
           
    
                var price = 0;
                
                if (cate) {
                    price = (price * 100 + (cate.price * $scope.infos.ratio)) / 100;
                }
                if (cate2) {
                    price = (price * 100 + (cate2.price * $scope.infos.ratio2)) / 100;
                }
                if (cate3) {
                    price = (price * 100 + (cate3.price * $scope.infos.ratio3)) / 100;
                }
                
                if(price > 0 && $scope.infos.end_ratio > 0){
                     price = (price * $scope.infos.end_ratio) / 100;
                }
                
                price = Math.round((price + Number.EPSILON) * 100) / 100; // 最终结果保留两位小数
                
                $scope.infos.price = price;
            }else{
                $(".chang_price").removeAttr("disabled");
            }
        }else{
            $(".chang_price").removeAttr("disabled");
        }
               
        
    };
    
    $scope.onChangeRatio2 = function(){
        console.log(1777771);
         var price = $scope.infos.price;
         
         if($scope.infos.pid > 0 || $scope.infos.pid2 > 0 || $scope.infos.pid3 > 0){
                var cate = '';
            $scope.infos.cate_list.forEach(function(item) {
                
                if(item.id == $scope.infos.pid){
                    cate = item;
                }
            });
            
            var cate2 = '';
            $scope.infos.cate_list.forEach(function(item) {
                
                if(item.id == $scope.infos.pid2){
                    cate2 = item;
                }
            });
            var cate3 = '';
            $scope.infos.cate_list.forEach(function(item) {
                
                if(item.id == $scope.infos.pid3){
                    cate3 = item;
                }
            });
             
            if(cate || cate2 || cate3){
                
                $(".chang_price").attr("disabled", "disabled");
           
    
                var price = 0;
                
                if (cate) {
                    price = (price * 100 + (cate.price * $scope.infos.ratio)) / 100;
                }
                if (cate2) {
                    price = (price * 100 + (cate2.price * $scope.infos.ratio2)) / 100;
                }
                if (cate3) {
                    price = (price * 100 + (cate3.price * $scope.infos.ratio3)) / 100;
                }
                
                if(price > 0 && $scope.infos.end_ratio > 0){
                     price = (price * $scope.infos.end_ratio) / 100;
                }
                
                price = Math.round((price + Number.EPSILON) * 100) / 100; // 最终结果保留两位小数
                
    
                
                    $scope.infos.price = price;
            }else{
                $(".chang_price").removeAttr("disabled");
            }
        }
         
         
        
    };
    
    

// this.$scope.onChangeRatio();
 // 假设你想要Item2不可编辑
//   $scope.$watch('infos.pid', function(newVal,oldVal) {console.log(2233);console.log(newVal);
//           if(newVal != 'undefined' && newVal > 0){
//           $(".chang_price").attr("disabled", "disabled");
//         }else{
//             $(".chang_price").removeAttr("disabled");

//         }
   
//     if(newVal != 'undefined' && newVal > 0){
//         var cate = '';
//         $scope.infos.cate_list.forEach(function(item) {
//             console.log(newVal);
//              console.log(item.id == newVal);
//             if(item.id == newVal){
//                 cate = item;
//             }
//         });
        
//         if(newVal != oldVal){
//             if($scope.infos.ratio == 'undefined'){
//                 $scope.infos.ratio = 100;
//             }
             
//              var price = 0;
//              var price = parseFloat(((cate.price * $scope.infos.ratio) / 100).toFixed(2));
//              const factor = Math.pow(10, 0);
//               var price =  Math.trunc($price * factor) / factor;
//             $scope.infos.price = price;
//              console.log(555555); console.log( $scope.infos.price);
//         }
       
//         console.log(cate);
//     }
    
//   });
        ////////////////////////////////////////////////////////////////////////

        // $scope.onSelectChange = function() {
        //     console.log(556);
        //      console.log($scope.infos.pid);
        //      $(".chang_price").attr("disabled", "disabled");
        // }
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
            $scope.commAjax("<?php echo U('NewLabel/editGet','model=new_label');?>", {id: id}, function (res) {
                $scope.infos = res.data;
                $("#myEdit").modal("show");
            });
        }

        $scope.updateCats = function () {
            var param = $scope.infos;
            param.ids = param.id;
            /////////
            $.ajax({
                url: "<?php echo U('Core/edits','model=new_label');?>",
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
        
        $scope.updateinfo2 = function (id) {
            $scope.commAjax("<?php echo U('NewLabel/addGet','model=new_label');?>", {cate_label_id: id}, function (res) {
                
                $scope.infos = res.data;
                console.log(11);
                console.log(res.data);
                $("#myModal2").modal("show");
            });
        }
        
        $scope.updateinfo3 = function (id) {
            $scope.commAjax("<?php echo U('NewLabel/editGet','model=new_label');?>", {id: id}, function (res) {
                $scope.infos = res.data;
                console.log(111);
                console.log(id);
                console.log(res.data);
                $("#myEdit2").modal("show");
                    $scope.onChangeRatio();
            });
        }
        
        $scope.edit = function () {
            var param = $scope.infos;
            param.ids = param.id;
            $scope.isRequesting = true;
            /////////
            $.ajax({
                url: "<?php echo U('NewLabel/edit','model=new_label');?>",
                type: "post",
                dataType: 'json',
                data: param,
                // timeout: 10000, // 设置超时时间为5000毫秒（5秒）
                success: function (data) {
                    if (data.status !== 1) {
                        return swal("错误", data.msg, "error");
                    }
                     $scope.isRequesting = false;
                    window.location.reload();
                },
                error: function (data) {
                     $scope.isRequesting = false;
                    console.log(data);
                }
            });
        }

        $scope.dels = function (ids) {
            swal({
                title: '确认删除',
                text: "确定要删除吗？",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
           }).then((willDelete) => {
                if (willDelete) {
                    var param = {id: ids};
                    $scope.commAjax("<?php echo U('Core/dels','model=new_label');?>", param, function (res) {
                        if (res.status !== 1) {
                            return swal("错误", res.msg, "error");
                        }
                        window.location.reload();
                    });
                }else{
                    
                }
            
            })   
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