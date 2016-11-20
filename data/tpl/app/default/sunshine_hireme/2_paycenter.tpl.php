<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.weui_cell_ft {
		color:black;
	}
</style>
<div class="container">
	<div class="cell">
		<div class="hd">
	        <h1 class="page_title">微信支付</h1>
	        <p class="page_desc"></p>
	    </div>
		<div class="bd">
			<div class="weui_cells">
				<div class="weui_cell">
					<div class="weui_cell_bd weui_cell_primary">
					<p>商品名称</p>
					</div>
					<div class="weui_cell_ft"><?php echo $this->settings['pay_center_goods_name'] ? $this->settings['pay_center_goods_name'] : $params['title']?></div>
				</div>
				<div class="weui_cell">
					<div class="weui_cell_bd weui_cell_primary">
					<p>订单编号</p>
					</div>
					<div class="weui_cell_ft"><?php  echo $params['ordersn'];?></div>
				</div>
				<div class="weui_cell">
					<div class="weui_cell_bd weui_cell_primary">
					<p>商家名称</p>
					</div>
					<div class="weui_cell_ft"><?php echo $this->settings['pay_center_shop_name'] ? $this->settings['pay_center_shop_name'] : $_W['account']['name']?></div>
				</div>
				<div class="weui_cell">
					<div class="weui_cell_bd weui_cell_primary">
					<p>支付金额</p>
					</div>
					<div class="weui_cell_ft">￥<?php  echo sprintf('%.2f', $params['fee']);?> 元</div>
				</div>
			</div>
		</div>
		<div class="bd spacing">
			<!-- 按钮 -->
			<?php  if(!empty($pay['wechat']['switch'])) { ?>
			<form action="<?php  echo url('mc/cash/wechat');?>" method="post">
				<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
				<input type="hidden" name="encrypt_code" value="" />
				<input type="hidden" name="card_id" value="<?php  echo base64_encode($card_id);?>" />
				<input type="hidden" name="coupon_id" value="" />
				<button class="weui_btn weui_btn_primary" disabled="disabled" type="submit" id="wBtn" value="wechat">微信支付(必须使用微信内置浏览器)</button>
			</form>
			<script type="text/javascript">

				document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {

					$('#wBtn').removeAttr('disabled');

					$('#wBtn').html('微信支付');

				});
			</script>
			<?php  } ?>
			<!-- <?php  if(!empty($pay['alipay']['switch'])) { ?>
			<form action="<?php  echo url('mc/cash/alipay');?>" method="post">
				<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
				<input type="hidden" name="encrypt_code" value="" />
				<input type="hidden" name="card_id" value="<?php  echo base64_encode($card_id);?>" />
				<input type="hidden" name="coupon_id" value="" />
				<button class="weui_btn weui_btn_primary" type="submit" name="alipay">支付宝支付</button>
			</form>
			<?php  } ?>
			<?php  if($pay['unionpay']['switch']) { ?>
			<form action="<?php  echo url('mc/cash/unionpay');?>" method="post">
				<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
				<input type="hidden" name="encrypt_code" value="" />
				<input type="hidden" name="card_id" value="<?php  echo base64_encode($card_id);?>" />
				<input type="hidden" name="coupon_id" value="" />
				<button class="weui_btn weui_btn_primary" type="submit" name="unionpay">银联支付</button>
			</form>
			<?php  } ?>
			<?php  if($pay['baifubao']['switch']) { ?>
			<form action="<?php  echo url('mc/cash/baifubao');?>" method="post">
				<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
				<input type="hidden" name="encrypt_code" value="" />
				<input type="hidden" name="card_id" value="<?php  echo base64_encode($card_id);?>" />
				<input type="hidden" name="coupon_id" value="" />
				<button class="btn btn-danger btn-block col-sm-12" type="submit" name="baifubao">百度钱包支付</button>
			</form>
			<?php  } ?>
			<?php  if(!empty($pay['credit']['switch'])) { ?>
			<form action="<?php  echo url('mc/cash/credit');?>" method="post">
				<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
				<input type="hidden" name="encrypt_code" value="" />
				<input type="hidden" name="card_id" value="<?php  echo base64_encode($card_id);?>" />
				<input type="hidden" name="coupon_id" value="" />
				<button class="btn btn-primary btn-block col-sm-12" type="submit" value="credit">余额支付 （余额支付当前 <?php  echo sprintf('%.2f', $credtis[$setting['creditbehaviors']['currency']]);?>元)</button>
			</form>
			<?php  } ?> -->

		</div>
	</div>
</div>
<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>