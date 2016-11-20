<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
	<div class="container-fluid">
		<h4><span class='glyphicon glyphicon-circle-arrow-right'></span>&nbsp;&nbsp;管理员设置</h4>
		<div class="row">
			<div class="col-md-6">
				<label>微信扫描下面二维码，绑定为超级粉丝社区管理员</label>
				<img src="<?php  echo $qrcodeUrl?>"/>
				<p class="help-block">该二维码只当次有效，扫描一次后立即失效</p>
			</div>
		</div>
		<br>
		<div class="row">
		<div class="col-sm-12">
			<label>管理员列表</label>
			<table class="table table-hover" style="width:100%;z-index:-10;" cellspacing="0" cellpadding="0">
			<thead class="navbar-inner">
				<tr>
					<th style="width:50px;"></th>
					<th style="width:90px;">头像</th>
					<th style="width:150px;">昵称</th>
					<th style="width:180px;">添加时间</th>
					<th style="min-width:70px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
					<tr>
						<td><?php  echo $key+1?></td>
						<td><img src="<?php  echo $item['uinfo']['headimgurl'];?>" width="48" height="48" style="border-radius:5px;"></td>
						<td><?php  echo $item['uinfo']['nickname'];?></td>
						<td><?php  echo $item['add_time'];?></td>
						<td><button class="btn btn-sm btn-danger" onclick="doRemove('<?php  echo $item['openid']?>')">移除</button></td>
					</tr>
				<?php  } } ?>
			</tbody>
		</table>
		</div>
	</div>
	</div>
	<script type="text/javascript">
	function doRemove(openid) {
		if(!confirm('确认移除该管理员身份？')) {
			return;
		}
		$.ajax({
			type:'post',
			url:'<?php  echo $this->createWebUrl('removeadmin')?>',
			data:{openid:openid},
			success:function(d) {
				if(d.res == '100') {
					window.location.href='';
				}else {
					alert(d.msg);
				}
			}
		})
	}
	</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>