<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">

</style>
<div class="msg">
<div class="weui_msg">
	<?php  if($err_msg['res'] == '100') { ?>
    <div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
    <?php  } else { ?>
    <div class="weui_icon_area"><i class="weui_icon_safe weui_icon_safe_warn"></i></div>
    <?php  } ?>
    <div class="weui_text_area">
        <h2 class="weui_msg_title"><?php  echo $uinfo['nickname'];?></h2>
        <p class="weui_msg_desc"><?php  echo $err_msg['msg'];?></p>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="<?php  echo $this->createMobileUrl('index')?>" class="weui_btn weui_btn_primary">返回首页</a>
        </p>
    </div>
    <div class="weui_extra_area">
        <a href=""><?php  echo date('Y-m-d H:i:s')?></a>
    </div>
</div>
</div>
<script type="text/javascript">
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>