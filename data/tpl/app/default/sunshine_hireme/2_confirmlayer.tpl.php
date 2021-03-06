<?php defined('IN_IA') or exit('Access Denied');?><?php  if(MembersComponent::isVerifyOk(self::$openid) === false ) { ?>
<!-- 监测用户的个人资料是否验证完成 -->
<div class="weui_dialog_alert">
    <div class="weui_mask" id="weui_mask_layer"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">个人资料认证</strong></div>
        <div class="weui_dialog_bd">您的个人信息不完整，请到个人资料中进行补充完整</div>
        <div class="weui_dialog_ft">
            <a href="<?php  echo $this->createMobileUrl('useredit')?>" class="weui_btn_dialog primary">完善资料</a>
        </div>
    </div>
</div>
<script type="text/javascript">
	$("#weui_mask_layer").on('touchmove',function(event) {
	    event.preventDefault();
	    return false;
	});
</script>
<?php  } else if(MembersComponent::isVerifyMobile(self::$openid) === false) { ?>
<!-- 监测手机是否已经认证 -->
<div class="weui_dialog_alert">
    <div class="weui_mask" id="weui_mask_layer"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">手机号认证</strong></div>
        <div class="weui_dialog_bd">您的手机号尚未认证，请到个人中心中进行认证</div>
        <div class="weui_dialog_ft">
            <a href="<?php  echo $this->createMobileUrl('usercheckmobile')?>" class="weui_btn_dialog primary">认证</a>
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
