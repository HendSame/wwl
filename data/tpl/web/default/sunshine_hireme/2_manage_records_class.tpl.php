<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2">
			<label>排序</label>
			<input type="text" class="form-control" id="sort_id" placeholder="1-100"/>
		</div>
		<div class="col-sm-4">
			<label>分类名称</label>
			<input type="text" class="form-control" id="class_name"/>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-6">
			<label>图片上传</label>
			<script type="text/javascript">
			function showImageDialog(elm, opts, options) {
				require(["util"], function(util){
				var btn = $(elm);
				var ipt = btn.parent().prev();
				var val = ipt.val();
				var img = ipt.parent().next().children();
				options = {'width':400,'extras':{'text':'ng-model=\'entry.thumb\''},'global':false,'class_extra':'','direct':true,'multiple':false};
				util.image(val, function(url){
				if(url.url){
				if(img.length > 0){
				img.get(0).src = url.url;
				}
				ipt.val(url.attachment);
				ipt.attr("filename",url.filename);
				ipt.attr("url",url.url);
				}
				if(url.media_id){
				if(img.length > 0){
				img.get(0).src = "";
				}
				ipt.val(url.media_id);
				}
				}, null, options);
				});
			}
			function deleteImage(elm){
				require(["jquery"], function($){
				$(elm).prev().attr("src", "./resource/images/nopic.jpg");
				$(elm).parent().prev().find("input").val("");
				});
			}
			</script>
			<div class="input-group ">
			<input type="text" name="thumb" value="" id='class_logo' class="form-control ng-pristine ng-untouched ng-valid" autocomplete="off" disabled="disabled">
			<span class="input-group-btn">
			<button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>
			</span>
			</div>
			<div class="input-group " style="margin-top:.5em;">
			<img src="" onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150"> <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
			</div>
			<p class="help-block">图片建议正方形，不要过大，否则影响页面加载速度</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<button class="btn btn-success form-control" onclick="addRecordsClass()">添加新分类</button>
		</div>
	</div>
	<!-- 分类列表开始 -->
	<h4>列表</h4>
	<table class="table">
		<tr>
			<th style="width:20px;">#</th>
			<th style="width:20px;">排序</th>
			<th style="width:50px;">分类名称</th>
			<th style="width:100px;">图片</th>
			<th style="width:100px;">操作</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
		<tr>
			<td><?php  echo $key+1?></td>
			<td><?php  echo $item['sort_id']?></td>
			<td><?php  echo $item['class_name']?></td>
			<td>
				<img src="<?php  echo $item['class_logo']?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" style="max-width:100px;"> 
			</td>
			<td>
				<button class="btn btn-sm btn-info" onclick="window.location.href='<?php  echo $this->createWebUrl('managerecordsclassedit',array('id'=>$item['id']))?>'">修改</button>
				<button class="btn btn-sm btn-danger" onclick="deleteClass('<?php  echo $item['id']?>')">删除</button>
			</td>
		</tr>
		<?php  } } ?>
	</table>
</div>
<script type="text/javascript">
	function addRecordsClass() {
		var class_name = $("#class_name").val();
		var class_logo = $("#class_logo").val();
		var sort_id = $("#sort_id").val();

		if(!class_name || !class_logo || !sort_id) {
			alert("请填写内容");
			return false;
		}

		$.ajax({
			type:'post',
			data:{class_name:class_name,class_logo:class_logo,sort_id:sort_id},
			url:"<?php  echo $this->createWebUrl('managerecordsclassadd')?>",
			success:function(d,s) {
				if(d.res == '100') {
					window.location.href='';
				}else {
					alert(d.msg);
				}
			}
		})

	}

	function deleteClass(id) {
		if(!id) {
			alert("参数错误");
			return false;
		}

		if(!confirm("确认删除该条记录？")) {
			return false;
		}

		$.ajax({
			type:'post',
			data:{class_id:id},
			url:"<?php  echo $this->createWebUrl('managerecordsclassdelete')?>",
			success:function(d,s) {
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