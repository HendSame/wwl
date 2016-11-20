<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container-fluid">
	<table class="table">
		<tr>
			<th width="40">#</th>
			<th width="70">头像</th>
			<th width="70">用户</th>
			<th width="70">时薪</th>
			<th>范围</th>
			<th>时间</th>
			<th>操作</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
		<tr id="item_<?php  echo $item['id'];?>">
			<td><?php  echo $key +1+($page-1)*$pagesize?></td>
			<td>
				<img style="width:48px;height:48px;" src="<?php  echo $item['uinfo']['headimgurl']?>">
			</td>
			<td><?php  echo $item['uinfo']['nickname']?></td>
			<td><?php  echo $item['salary']?></td>
			<td><?php  echo $item['hire_range']?></td>
			<td><?php  echo $item['add_time'];?></td>
			<td>
				<button class="btn btn-sm btn-info" onclick="showDetail('<?php  echo $item['id'];?>')">查看图片</button>
			</td>
			<?php  if(is_array($item['albums'])) { foreach($item['albums'] as $a => $b) { ?>
			<input type="hidden" id="image_<?php  echo $item['id'];?>_<?php  echo $a;?>" value="<?php  echo $b['img_url'];?>">
			<?php  } } ?>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo pagination($count,$page,$pagesize)?>
</div>
<!-- 模态框 -->
<div class="modal fade bs-example-modal-sm"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="moment_detail_layer">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function showDetail(id) {
		var images = $("input[id^=image_"+id+"]");
		var html = "";
		images.each(function(i,elem) {
			html += "<img style='width:100%' src='"+$(elem).val()+"'>";
		})
		$("#moment_detail_layer .modal-body").html(html);
		$("#moment_detail_layer").modal('show');
	}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>