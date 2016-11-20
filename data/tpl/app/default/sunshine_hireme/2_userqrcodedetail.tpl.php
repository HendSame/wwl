<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div id="user_qrcode" style="text-align:center;">
	<?php  if($info['user_qrcode']) { ?>
	<img src="<?php  echo $info['user_qrcode'];?>" style="margin:0px auto;width:200px;">
	<?php  } ?>
	</div>
</div>