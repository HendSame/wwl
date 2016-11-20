<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="msg">
<div class="weui_msg">
	<?php  if($err) { ?>
    <div class="weui_icon_area"><i class="weui_icon_msg weui_icon_warn"></i></div>
    <div class="weui_text_area">
        <h2 class="weui_msg_title">确认订单失败</h2>
        <?php  if(is_array($err)) { foreach($err as $item) { ?>
        <p class="weui_msg_desc"><?php  echo  $item?></p>
        <?php  } } ?>
    </div>
    <?php  } else { ?>
    <div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
    <div class="weui_text_area">
        <h2 class="weui_msg_title">确认订单成功</h2>
        <p class="weui_msg_desc">请到个人中心中查看订单详情</p>
    </div>
    <?php  } ?>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="<?php  echo $this->createMobileUrl('usercenter')?>" class="weui_btn weui_btn_primary">返回个人中心</a>
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