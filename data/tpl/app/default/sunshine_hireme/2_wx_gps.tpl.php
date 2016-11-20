<?php defined('IN_IA') or exit('Access Denied');?><div class="weui_dialog_confirm" id="loading_gps_layer" style="display:none">
    <div class="weui_mask"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">定位失败</strong></div>
        <div class="weui_dialog_bd">请确保开启GPS定位并且允许应用获取您的地理位置授权，否则不能正常使用附近功能</div>
        <div class="weui_dialog_ft">
            <a href="javascript:;" class="weui_btn_dialog default" onclick="window.location.href=''">重试</a>
            <a href="javascript:;" class="weui_btn_dialog primary" onclick="$('#loading_gps_layer').hide()">关闭</a>
        </div>
    </div>
</div>
<script type="text/javascript">
	//2011-7-25
	var wx_gps_res = {}; // 结果

    wx.ready(function () {
	    // 在这里调用 API
		wx.getLocation({
			type: 'gcj02',
		    success: function (res) {
		        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
		        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
		        var speed = res.speed; // 速度，以米/每秒计
		        var accuracy = res.accuracy; // 位置精度

		        wx_gps_res.x = longitude;
		        wx_gps_res.y = latitude;

		        // 更新用户坐标为实时坐标
				doSynclnglat(wx_gps_res);
		    },
		    fail:function() {
		    	$("#loading_gps_layer").show();
		    }
		});
	});

	// 获取当前用户的坐标直接更新到数据表
	function doSynclnglat(wx_gps_res) {
		$.ajax({
		 	async:true,
		 	type:'post',
		 	data:{'lat':wx_gps_res.y,'lng':wx_gps_res.x},
		 	url:"<?php  echo $this->createMobileUrl('UserGps')?>",
		 	success:function(d) {
		 		if(d.res == '100') {
		 			//
		 		}else {
		 			alert(d.msg);
		 		}
		 	}
		})
	}
</script>