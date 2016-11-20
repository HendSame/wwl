<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
	<div class="container-fluid">
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;总消息模板开关</h4>
		<div class="row">
			<div class="col-md-6">
				<label>开关</label>
				<?php  if($this->settings['notice_key'] == 'open') { ?>
				<button class="form-control btn btn-sm btn-success" onclick="doSave('notice_key','close')">已开启模板消息</button>
				<?php  } else { ?>
				<button class="form-control btn btn-sm btn-danger" onclick="doSave('notice_key','open')">已关闭模板消息</button>
				<?php  } ?>
				<p class="help-block">控制是否开启模板消息,开启后请务必配置好下面设置项</p>
			</div>
		</div>
		<br>
		<!-- 审核模板消息配置 -->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;审核消息模板配置</h4>
		<p class="help-block">用于各种审核操作的消息提醒</p>
		<div class="row">
			<div class="col-md-6">
				<label>模板ID</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['approve_tpl_id']?>" id='approve_tpl_id' placeholder=''>
				<p class="help-block">请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”审核状态通知“，编号为：“OPENTM207508435”的模板。</p>
				<p class="help-block">该模板不需要自定义，内容由程序决定</p>
				<button class="btn btn-sm btn-info" onclick="doSave('approve_tpl_id')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<!-- 用户订单支付消息提醒 -->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;订单支付消息模板配置</h4>
		<p class="help-block">用户A下单租赁B给 A/均发送推送消息</p>
		<div class="row">
			<div class="col-md-6">
				<label>模板ID</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['order_tpl_id']?>" id='order_tpl_id' placeholder=''>
				<p class="help-block">请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”订单支付提醒“，编号为：“OPENTM202115196”的模板。</p>
				<p class="help-block">该模板不需要自定义，内容由程序决定</p>
				<button class="btn btn-sm btn-info" onclick="doSave('order_tpl_id')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<!-- 退款通知 -->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;退款通知消息模板设置</h4>
		<p class="help-block">用于发起退款申请的提醒通知</p>
		<div class="row">
			<div class="col-md-6">
				<label>模板ID</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['refund_tpl_id']?>" id='refund_tpl_id' placeholder=''>
				<p class="help-block">请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”退款通知“，编号为：“TM00004”的模板。</p>
				<p class="help-block">该模板不需要自定义，内容由程序决定</p>
				<button class="btn btn-sm btn-info" onclick="doSave('refund_tpl_id')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<!-- 提现通知 -->
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;提现消息模板设置</h4>
		<p class="help-block">用于发起提现申请提醒通知</p>
		<div class="row">
			<div class="col-md-6">
				<label>模板ID</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['draw_wait_tpl_id']?>" id='draw_wait_tpl_id' placeholder=''>
				<p class="help-block">请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”提现通知“，编号为：“OPENTM207422808”的模板。</p>
				<p class="help-block">该模板不需要自定义，内容由程序决定</p>
				<button class="btn btn-sm btn-info" onclick="doSave('draw_wait_tpl_id')">保存</button>
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
		// 模板消息开关
		if(type == 'notice_key') {
			var settings_name = 'notice_key';
			var settings_value = val;
		}
		// 审核模板的ID
		if(type == 'approve_tpl_id') {
			var settings_name = 'approve_tpl_id';
			var settings_value = $("#approve_tpl_id").val();
		}

		// 订单支付成功的消息模板
		if(type == 'order_tpl_id') {
			var settings_name = 'order_tpl_id';
			var settings_value = $("#order_tpl_id").val();
		}
		// 退款通知
		if(type == 'refund_tpl_id') {
			var settings_name = 'refund_tpl_id';
			var settings_value = $("#refund_tpl_id").val();
		}
		// 提现通知
		if(type == 'draw_wait_tpl_id') {
			var settings_name = 'draw_wait_tpl_id';
			var settings_value = $("#draw_wait_tpl_id").val();
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