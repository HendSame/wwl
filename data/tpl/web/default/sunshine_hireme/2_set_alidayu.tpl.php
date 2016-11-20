<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
	<div class="container-fluid">
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;总消息模板开关</h4>
		<div class="row">
			<div class="col-md-6">
				<label>开关</label>
				<?php  if($this->settings['alidayu_key'] == 'open') { ?>
				<button class="form-control btn btn-sm btn-success" onclick="doSave('alidayu_key','close')">已开启短信发送</button>
				<?php  } else { ?>
				<button class="form-control btn btn-sm btn-danger" onclick="doSave('alidayu_key','open')">已关闭短信发送</button>
				<?php  } ?>
				<p class="help-block">控制是否开启短信发送,开启后请务必配置好下面设置项</p>
			</div>
		</div>
		<br>
		<!-- 短信配置-->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;短信配置</h4>
		<div class="row">
			<div class="col-md-6">
				<label>短信ak</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['alidayu_ak']?>" id='alidayu_ak' placeholder=''>
				<p class="help-block"></p>
				<button class="btn btn-sm btn-info" onclick="doSave('alidayu_ak')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<label>短信sk</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['alidayu_sk']?>" id='alidayu_sk' placeholder=''>
				<p class="help-block"></p>
				<button class="btn btn-sm btn-info" onclick="doSave('alidayu_sk')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<label>短信模板ID</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['alidayu_tpl_id']?>" id='alidayu_tpl_id' placeholder=''>
				<p class="help-block">请保证短信模板中的变量为${product}和${code}，其他变量将导致发送失败</p>
				<button class="btn btn-sm btn-info" onclick="doSave('alidayu_tpl_id')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<label>短信签名名称</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['alidayu_sign_name']?>" id='alidayu_sign_name' placeholder=''>
				<p class="help-block"></p>
				<button class="btn btn-sm btn-info" onclick="doSave('alidayu_sign_name')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<!-- 短信自定义部分 -->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;短信内容配置</h4>
		<div class="row">
			<div class="col-md-6">
				<label>短信主名称</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['alidayu_product']?>" id='alidayu_product' placeholder=''>
				<p class="help-block">将主动替换${product}变量，默认为“快来租我”</p>
				<button class="btn btn-sm btn-info" onclick="doSave('alidayu_product')">保存</button>
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
		// 短信发送开关
		if(type == 'alidayu_key') {
			var settings_name = 'alidayu_key';
			var settings_value = val;
		}
		// 模板的ID
		if(type == 'alidayu_tpl_id') {
			var settings_name = 'alidayu_tpl_id';
			var settings_value = $("#alidayu_tpl_id").val();
		}

		if(type == 'alidayu_sign_name') {
			var settings_name = 'alidayu_sign_name';
			var settings_value = $("#alidayu_sign_name").val();
		}
		if(type == 'alidayu_ak') {
			var settings_name = 'alidayu_ak';
			var settings_value = $("#alidayu_ak").val();
		}
		if(type == 'alidayu_sk') {
			var settings_name = 'alidayu_sk';
			var settings_value = $("#alidayu_sk").val();
		}

		if(type == 'alidayu_product') {
			var settings_name = 'alidayu_product';
			var settings_value = $("#alidayu_product").val();	
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