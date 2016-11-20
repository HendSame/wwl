<?php defined('IN_IA') or exit('Access Denied');?><?php  if(OrderComponent::isPayed(self::$openid,$rid) == 'payed') { ?>
<!-- 判断该记录是否已经存在对应的订单，只能对同一条租赁下一次订单 -->
<div class="weui_dialog_alert">
    <div class="weui_mask" id="weui_mask_layer"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">提示</strong></div>
        <div class="weui_dialog_bd">您已经下过订单了，无需重复</div>
        <div class="weui_dialog_ft">
            <a href="<?php  echo $this->createMobileUrl('index')?>" class="weui_btn_dialog primary">确认</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#weui_mask_layer").on('touchmove',function(event) {
        event.preventDefault();
        return false;
    });
</script>
<?php  } ?>