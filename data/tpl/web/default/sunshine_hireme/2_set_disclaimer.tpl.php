<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
	<div class="container-fluid">
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;温馨提示</h4>
		<div class="row">
			<div class="col-md-6">
				<label class="help-block">将会在列表页进行滚动提示</label>
				<input type="text" class="form-control" value="<?php  echo $this->settings['public_notice']?>" id='public_notice' placeholder=''>
				<p class="help-block"></p>
				<button class="btn btn-sm btn-info" onclick="doSave('public_notice')">保存</button>
				<br>
			</div>
		</div>
		<br>
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;免责提醒</h4>
		<div class="row">
			<div class="col-md-6">
				<label class="help-block">将会在发布/招租的时候进行弹窗提醒</label>
				<script>
				var editor;
				require(['jquery','util'], function($, util){
					$(function(){
						editor = util.editor($('#public_disclaimer')[0]);
					});
				});
				</script>
				<textarea  class="form-control" id='public_disclaimer' placeholder='' rows="30">
				<?php  echo readFileConfig('public_disclaimer')?>
				</textarea>
				<p class="help-block"></p>
				<button class="btn btn-sm btn-info" onclick="doSave('public_disclaimer')">保存</button>
				<br>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	function doSave(type,val) {
		var save_type = '';
		if(!type) {
			return false;
		}
		if(type == 'public_notice') {
			var settings_name = 'public_notice';
			var settings_value = $("#public_notice").val();
		}
		if(type == 'public_disclaimer') {
			var settings_name = 'public_disclaimer';
			var settings_value = editor.getContent();
			save_type = 'file';
		}



		$.ajax({
			type:'post',
			data:{
				save_type:save_type,
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