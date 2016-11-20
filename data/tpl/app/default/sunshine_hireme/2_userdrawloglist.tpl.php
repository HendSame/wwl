<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
		<div class="bd">
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<?php  if($item['status'] == 'handle') { ?>
			<div class="weui_media_box weui_media_text">
                <h4 class="weui_media_title" style="color:#3cc51f">提现成功</h4>
                <p class="weui_media_desc">提现金额：<?php  echo $item['money'];?>元</p>
                <p class="weui_media_desc">扣除佣金：<?php  echo $item['commision'];?>元</p>
                <p class="weui_media_desc">实际提现：<?php  echo $item['act_draw'];?>元</p>
                <p class="weui_media_desc">提现时间：<?php  echo $item['add_time'];?></p>
                <p class="weui_media_desc">收款时间：<?php  echo $item['update_time'];?></p>
            </div>
            <?php  } else { ?>
            <div class="weui_media_box weui_media_text">
                <h4 class="weui_media_title" style="color:red">审核中</h4>
                 <p class="weui_media_desc">提现金额：<?php  echo $item['money'];?>元</p>
                <p class="weui_media_desc">扣除佣金：<?php  echo $item['commision'];?>元</p>
                <p class="weui_media_desc">实际提现：<?php  echo $item['act_draw'];?>元</p>
                <p class="weui_media_desc">提现时间：<?php  echo $item['add_time'];?></p>
            </div>
            <?php  } ?>
            <?php  } } ?>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>