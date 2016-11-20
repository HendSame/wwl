<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
		<div class="bd">
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<div class="weui_media_box weui_media_text">
                <h4 class="weui_media_title" style="color:#3cc51f">+<?php  echo $item['money'];?>元</h4>
                <p class="weui_media_desc">客户：<?php  echo $item['uinfo']['nickname'];?></p>
                <p class="weui_media_desc">时间：<?php  echo $item['add_time'];?></p>
            </div>
            <?php  } } ?>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>