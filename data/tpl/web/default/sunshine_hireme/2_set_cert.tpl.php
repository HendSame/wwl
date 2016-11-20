<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
	<div class="container-fluid">
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;支付配置</h4>
		<div class="row">
			<div class="col-md-6">
				<label>开关</label>
				<?php  if($this->settings['redpack_key'] == 'open') { ?>
				<button class="form-control btn btn-sm btn-success" onclick="doSave('redpack_key','close')">已开启现金红包</button>
				<?php  } else { ?>
				<button class="form-control btn btn-sm btn-danger" onclick="doSave('redpack_key','open')">已关闭现金红包</button>
				<?php  } ?>
				<p class="help-block">控制是否开启红包,开启后请务必配置好下面设置项</p>
			</div>
		</div>
		<br>
		<!-- 支付时订单详情页的  商品名称 -->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;商品名称自定义</h4>
		<p class="help-block"></p>
		<div class="row">
			<div class="col-md-6">
				<label>订单支付页面 “商品名称”自定义</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['pay_center_goods_name']?>" id='pay_center_goods_name' placeholder=''>
				<p class="help-block">默认为“快租租金支付”</p>
				<button class="btn btn-sm btn-info" onclick="doSave('pay_center_goods_name')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<!-- 支付详情页 商家名称 -->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;商家名称自定义</h4>
		<p class="help-block"></p>
		<div class="row">
			<div class="col-md-6">
				<label>订单支付页面 “商家名称”自定义</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['pay_center_shop_name']?>" id='pay_center_shop_name' placeholder=''>
				<p class="help-block">默认为“<?php  echo $_W['account']['name']?>”</p>
				<button class="btn btn-sm btn-info" onclick="doSave('pay_center_shop_name')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<!-- cert 路径 -->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;证书配置</h4>
		<p class="help-block">上传证书</p>
		<div class="row">
			<div class="col-md-6">
				<label>appclient_cert.pem上传<?php  if($this->settings['appclient_cert_path']) { ?><span style="color:#449d44">（已上传）</span><?php  } ?></label>
				<form action="<?php  echo $this->createWebUrl('saveClientCert')?>" method="post" enctype="multipart/form-data">
					<input type="file" class="form-control" name="file" placeholder=''>
					<p class="help-block">请上传您的appclient_cert.pem文件</p>
					<input type="submit" class="btn btn-sm btn-info" value="上传">
				</form>
				<br>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<label>appclient_key.pem上传<?php  if($this->settings['appclient_key_path']) { ?><span style="color:#449d44">（已上传）</span><?php  } ?></label>
				<form action="<?php  echo $this->createWebUrl('saveclientkey')?>" method="post" enctype="multipart/form-data">
					<input type="file" class="form-control" name="file" placeholder=''>
					<p class="help-block">请上传您的appclient_key.pem文件</p>
					<input type="submit" class="btn btn-sm btn-info" value="上传">
				</form>
				<br>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<label>rootca.pem上传<?php  if($this->settings['rootca_path']) { ?><span style="color:#449d44">（已上传）</span><?php  } ?></label>
				<form action="<?php  echo $this->createWebUrl('saverootca')?>" method="post" enctype="multipart/form-data">
					<input type="file" class="form-control" name="file" placeholder=''>
					<p class="help-block">请上传您的rootca.pem文件</p>
					<input type="submit" class="btn btn-sm btn-info" value="上传">
				</form>
				<br>
			</div>
		</div>
		<br>
	</div>
	<script type="text/javascript">
	function doSave(type,val) {

		if(!type) {
			return false;
		}
		// 红包开关
		if(type == 'redpack_key') {
			var settings_name = 'redpack_key';
			var settings_value = val;
		}

		// 商户号码
		if(type == 'mch_id') {
			var settings_name = 'mch_id';
			var settings_value = $("#mch_id").val();
		}

		// 商品名称
		if(type == 'pay_center_goods_name') {
			var settings_name = 'pay_center_goods_name';
			var settings_value = $("#pay_center_goods_name").val();
		}
		// 商家名称
		if(type == 'pay_center_shop_name') {
			var settings_name = 'pay_center_shop_name';
			var settings_value = $("#pay_center_shop_name").val();
		}
		$.ajax({
			type:'post',
			data:{
				settings_name:settings_name,
				settings_value:settings_value
			},

			url:"<?php  echo $this->createWebUrl('settingform')?>",
			success:function(d) {
				if(d.res == '100') {
					alert('保存成功');
					window.location.href='';
				}else {
					alert(d.msg);
				}
			}
		})

	}
	</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>