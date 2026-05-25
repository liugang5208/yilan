<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>易缆报价</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            html,body{
                padding:0px;
                margin: 0px;
                width: 100%;
            }
            .goods_line {
                display: flex;
            }
            .goods {
                border-top: 1px solid #eeeeee;
            }
            .goods_line_item {
                border-right: 1px solid #eeeeee;
                border-bottom: 1px solid #eeeeee;
                box-sizing: border-box;
                font-size: 0.65rem;
                flex: 1;
                min-height: 2.8rem;
                line-height: 2.8rem;
                text-align: center;
            }
            .goods_line_item.title {
                font-size: 0.85rem;
            }
            .goods_line_item.mrleft {
                margin-left: 0px;
            }
            .goods_line_item.nobor {
                border-right: 0px;
            }
            .goods_line_imsr {
                border-right: 1px solid #eeeeee;
                border-bottom: 1px solid #eeeeee;
                box-sizing: border-box;
                flex: 4;
                font-size: 0.5rem;
                min-height: 2.8rem;
                line-height: 1.4rem;
                padding-left: 2px;
                text-align: center;
            }
            .goods_line_imsr.size {
                line-height: 2.8rem;
                text-align: center;
            }
            .goods_line_imse {
                border-bottom: 1px solid #eeeeee;
                box-sizing: border-box;
                flex: 2;
                font-size: 0.65rem;
                min-height: 2.8rem;
                line-height: 2.8rem;
                text-align: center;
            }
            .totals {
                background: #fffad8;
                padding: 0.4rem 1.2rem 1.2rem;
            }
            .totals p {
                font-size: 0.75rem;
                margin: 0rem;
                padding-top: 0.8rem;
            }
            .totals p span {
                color: #d0021b;
            }
            .rep_tags {
                background: #4a90e2;
                box-sizing: border-box;
                color: white;
                font-size: 0.75rem;
                height: 1.8rem;
                line-height: 1.8rem;
                margin-top: 1.2rem;
                padding: 0rem 1.2rem;
            }
            ion-list {
                background: #f8f8f8;
            }
            ion-item{
                border-bottom: 0.125rem solid #eeeeee;
                display:flex;
                height: 2.4rem;
                line-height: 2.4rem;
                font-size:0.65rem
            }
            ion-label{
                flex: 2;
                padding: 0rem 0.5rem
            }

            ion-input{
                flex:4;
                text-align: right;
                padding-right:0.5rem;
            }

            .footer_bg {
                background: #f8f8f8;
                height: 2.4rem;
            }
            .footer {
                padding: 1.6rem 1.2rem;
                text-align: center;
            }
            .footer img {
                width: 70%;
            }
            .footer button {
                background: #c20f22;
                border-radius: 0.2rem;
                display: block;
                font-size: 1.8rem;
                color: white;
                height: 4.4rem;
                line-height: 4.4rem;
                width: 100%;
            }
            .footer button:last-child {
                background: white;
                border: 1px solid #c20f22;
                color: #c20f22;
                margin-top: 1.6rem;
            }
        </style>
    </head>
    <body>
        
        <div class="logo" style="display: flex;justify-content: center;align-items: center;width: 100vw;height:200rpx">
            
            <?php echo ($logo); ?>
        </div>

        <div class="goods">
            <div class="goods_line">
                <div class="goods_line_item title mrleft">质量标准：<?php echo ($infos["trans_bids"]); ?></div>
                <div class="goods_line_item title nobor">
                    是否含税：
                    <?php echo ($ratio<1?'不含税票':''); ?>
                    <?php echo ($ratio>0 && $ratio<7?'含普通发票':''); ?>
                    <?php echo ($ratio>7?'含专用发票':''); ?>
                </div>
            </div>

            <div class="goods_line">
                <div class="goods_line_item">序号</div>
                <div class="goods_line_imsr size">型号规格</div>
                <div class="goods_line_item">单位</div>
                <div class="goods_line_item">数量</div>
                <div class="goods_line_item">单价</div>
                <div class="goods_line_imse">合计</div>
            </div>

            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="goods_line">
                    <div class="goods_line_item"><?php echo ($i); ?></div>
                    <div class="goods_line_imsr"><?php echo ($item["attr1"]); ?><br /><?php echo ($item["attr2"]); ?><br /><?php echo ($item["attr3"]); ?></div>
                    <div class="goods_line_item"><?php echo ($item["unit"]); ?></div>
                    <div class="goods_line_item"><?php echo ($item["nums"]); ?></div>
                    <div class="goods_line_item"><?php echo ($item["price"]); ?></div>
                    <div class="goods_line_imse"><?php echo ($item["total"]); ?></div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>

        </div>
        
        <div class="rep_tags">报价单备注信息</div>

    <ion-list lines="full" class="ion-no-margin">

        <ion-item>
            <ion-label >付款方式:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["check_type"]); ?></ion-input>
        </ion-item>
        <ion-item>
            <ion-label>运输方式:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["trans_type"]); ?></ion-input>
        </ion-item>
        <ion-item>
            <ion-label>运输费用:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["fees_out"]); ?></ion-input>
        </ion-item>
        <ion-item>
            <ion-label>包装选项:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["pack_recyle"]); ?></ion-input>
        </ion-item>
        
        <ion-item>
            <ion-label>报价单位:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["rep_comp"]); ?></ion-input>
        </ion-item>
        
        <ion-item>
            <ion-label>询价单位:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["question_comp"]); ?></ion-input>
        </ion-item>
        
        <ion-item>
            <ion-label>项目名称:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["project_comp"]); ?></ion-input>
        </ion-item>
        
        
        
        
        <!--<ion-item>-->
        <!--    <ion-label>使用单位（选填）</ion-label>-->
        <!--    <ion-input disabled="true" value=""><?php echo ($infos["use_comp"]); ?></ion-input>-->
        <!--</ion-item>-->
        <!--<ion-item>-->
        <!--    <ion-label>生产周期（选填）</ion-label>-->
        <!--    <ion-input disabled="true" value=""><?php echo ($infos["pro_time"]); ?></ion-input>-->
        <!--</ion-item>-->
        <ion-item>
            <ion-label>报价人员:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["rep_user"]); ?></ion-input>
        </ion-item>
        <ion-item>
            <ion-label>联系方式:</ion-label>
            <ion-input disabled="true" value="" style="color: blue;"><?php echo ($infos["rep_phone"]); ?></ion-input>
        </ion-item>
        <!--<ion-item>-->
        <!--    <ion-label>报价日期</ion-label>-->
        <!--    <ion-input disabled="true" value=""><?php echo ($infos["rep_date"]); ?></ion-input>-->
        <!--</ion-item>-->
        <ion-item style="height: 130px;" >
            <div style="min-width:50px;margin-left:10px;"> 报价备注:</div>
            <textarea style="height: 95%; width: 100%; overflow: auto;color: blue;border-color: transparent;" readonly><?php echo ($infos["tags"]); ?></textarea>
            <!--<ion-textarea style="overflow: auto;"  disabled="true" value="" style="color: blue;"><?php echo ($infos["tags"]); ?></ion-textarea>-->
        </ion-item>

    </ion-list>
    <div class="totals">
            <p>商品总条数：<?php echo ($kid_num); ?>    <span style="color:black;margin-left:10px">合计数量：<?php echo ($goods_num); ?></span></p>
            <p>合计：<span><?php echo ($total); ?></span>元</p>
            <p>订单合计大写金额：<?php echo ($total_n); ?></p>
            <p>订单税率标识：<?php echo ($ticket_title); ?></p>
        </div>

    <div class="footer">
        <img src="/Public/assets/images/login_footer2.png" />
    </div>


</body>
</html>