<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div id="user_qrcode" style="text-align:center;">
	<?php  if($info['user_qrcode']) { ?>
	<img src="<?php  echo $info['user_qrcode'];?>" style="margin:0px auto;width:200px;">
	<?php  } ?>
	</div>
	<div class="weui_btn_area" id="btn_select">
        <button class="weui_btn weui_btn_primary" id="save_btn" onclick="doSelect()">选择图片</button>
    </div>
	<div class="weui_btn_area" id="btn_use" style="display:none">
        <button class="weui_btn weui_btn_primary" id="save_btn" onclick="doUpload(this)">确定使用该二维码</button>
    </div>
</div>
<script type="text/javascript">
	var images = {
		localId: [],
		serverId: [],
		count:1
	};
	function doSelect () {
		wx.chooseImage({
			count: images.count, // 默认9
			sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			success: function (res) {
				// 按钮展示
				$("#btn_select").hide();
				$("#btn_use").show();
				images.localId = res.localIds;
				// alert('已选择 ' + res.localIds.length + ' 张图片');
				// doUpload();
				for(var i in res.localIds) {
					addImg(res.localIds[i]);
				}
				images.count -= res.localIds.length;
			}
		});
	};
	// 添加上传图片
	function addImg(localId) {
		$("#user_qrcode img").remove();
		var html = "";
		html += "<img src='"+localId+"' style='margin:0px auto;width:200px;'>";
		$("#user_qrcode").append(html);
	}

	// 5.3 上传图片
	function doUpload () {

		if(images.localId.length == 0) {
			alert("请填写内容或者上传图片");
			return;
		}
		$("#save_btn").attr('disabled',true);
		if (images.localId.length == 0) {
			doSave(0);
		}else {
			var i = 0, length = images.localId.length;
			images.serverId = [];
			function upload() {
				wx.uploadImage({
					localId: images.localId[i],
					success: function (res) {
						i++;
						images.serverId.push(res.serverId);
						if (i < length) {
							upload();
						}
						else
						{
							var media_ids = images.serverId.join(',')
							doSave(media_ids);
						}
					},
					fail: function (res) {
						alert(JSON.stringify(res));
					}
				});
			}
			upload();
		}
	};

	function doSave(media_ids) {
		$("#save_btn").html("发布中...");
		$.ajax({
			type:'post',
			url:"<?php  echo $this->createMobileUrl('saveuserqrcode')?>",
			data:{media_ids:media_ids},
			success:function(d,s) {
				if(d.res == '100') {
					$("#save_btn").html("发布成功");
					window.location.href='<?php  echo $this->createMobileUrl('useredit')?>';
				}else {
					$("#save_btn").attr('disabled','');
					$("#save_btn").html("发布");
					alert(d.msg);
				}
				
			}
		});
	}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>