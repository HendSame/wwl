<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('wx_gps', TEMPLATE_INCLUDEPATH)) : (include template('wx_gps', TEMPLATE_INCLUDEPATH));?>
<?php  if($this->settings['public_notice']) { ?>
	<marquee direction="left" style="background:#3cc51f;color:white;position:fixed;top:0px;"><span class="fa fa-volume-up"></span><?php  echo $this->settings['public_notice']?></marquee>
<?php  } ?>
<div class="container">
	<!-- 分类 -->
	<?php  if(RecordsClassModel::getAll()) { ?>
	<div style="height:40px;"></div>
	<ul style="list-style:none;clear:both;overflow:hidden;">
		<?php  if(is_array(RecordsClassModel::getAll())) { foreach(RecordsClassModel::getAll() as $key => $item) { ?>
		<?php  if($key == 4) { ?>
	</ul>
	<ul style="list-style:none;clear:both;overflow:hidden;">
		<?php  } ?>
		<li style="float:left;width:25%;text-align:center;" onclick="window.location.href='<?php  echo $this->createMobileUrl('vicinity',array('hire_class'=>$item['id']))?>'">
			<div>
				<img src="<?php  echo $item['class_logo']?>" style="width:50px;">
			</div>
			<p><?php  echo $item['class_name']?></p>
		</li>
		<?php  } } ?>
	</ul>
	<div style="height:20px;"></div>
	<?php  } ?>
	<!-- 列表 -->
	<div id="list_container">
	<?php  if(is_array($list)) { foreach($list as $item) { ?>
	<div style="margin-bottom:20px;background-color:white" class="sun-border-b">
		<div  style="max-height:300px;overflow:hidden">
			<a href="<?php  echo $this->createMobileUrl('hiredetail',array('rid'=>$item['id']))?>">
				<img src="<?php  echo $item['albums'][0]['img_url']?>" style="width:100%;">
			</a>
		</div>
		<div style="padding:10px;overflow:hidden;">
			<div>
				<div>
					<span style="white-space: nowrap;text-overflow:ellipsis;display:inline-block;max-width:100px;"><?php  echo $item['uinfo']['nickname']?></span>
					<?php  if($item['uinfo']['sex'] == '1') { ?>
					<span class="fa fa-mars" style="color:#10AEFF"></span>
					<?php  } else { ?>
					<span class="fa fa-venus" style="color:#F00096"></span>
					<?php  } ?>
					<span style="color:rgb(90,90,90);float:right;"><?php  echo $item['time_diff']?>前发布</span>
				</div>
				<div>
					<span class="fa fa-map-marker" style="color:#10AEFF"></span><?php  echo $item['uinfo']['province']?><?php  echo $item['uinfo']['city']?><?php  echo $item['uinfo']['district']?>
					&nbsp;
					<span class="fa fa-rmb" style="color:#10AEFF"></span>
					每小时<?php  echo $item['salary']?>元
					&nbsp;
					<span class="fa fa-graduation-cap" style="color:#10AEFF"></span>
					<?php  echo $item['uinfo']['work']?>
				</div>
				<div>
					<?php  $hire_range_arr = explode('，',$item['hire_range'])?>
					<?php  if(is_array($hire_range_arr)) { foreach($hire_range_arr as $key => $range) { ?>
					<label class="sun-label sun-label-<?php  echo $key+1?>"><?php  echo $range;?></label>
					<?php  } } ?>
				</div>
			</div>
		</div>
		</div>
	<?php  } } ?>
	</div>
	<!-- bottom -->
	<div style="text-align:center;" id="listload_more">
		<p>上拉加载更多</p>
	</div>
	<!-- loading -->
	<div id="loading_more_layer" style="display:none;text-align:center;">
	    <p>加载中...</p>
	    <i class="ui-loading"></i>
	</div>
	<div id="loading_over" style="display:none;text-align:center;">
	    <p>已全部加载完毕</p>
	</div>
	<div style="height:100px;" id="bottom_sign">
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('menu', TEMPLATE_INCLUDEPATH)) : (include template('menu', TEMPLATE_INCLUDEPATH));?>

<!-- hide -->
<script type="text/javascript">
// init page
var page = 2;
var load_key = true;

window.onscroll = function() {
	var div_top = $("#bottom_sign").offset().top;
	var scroll_top = $("body").scrollTop();
	var window_height = $(window).height();

	if(div_top - scroll_top <= window_height && load_key)
	{
		listload();
	}
}

function listload() {
	load_key = false;
	var _self = $('#listload_more');
	
	_self.hide();
	$("#loading_more_layer").show();

	$.ajax({
		type:'post',
		data:{'page':page},
		url : "<?php  echo $this->createMobileUrl('LoadListMore')?>",
		success :function(d) {
			if(d.res == '100') {
				var html = '';
				for (var i in d.list) {
					var info = d.list[i];
					html += '<div style="margin-bottom:20px;background-color:white" class="sun-border-b">';
					html += '<div  style="max-height:240px;overflow:hidden">';
					html += '<a href="<?php  echo $this->createMobileUrl('hiredetail')?>&rid='+info.id+'">';
					html += '<img src="'+info.albums[0].img_url+'" style="width:100%;">';
					html += '</a>';
					html += '</div>';
					html += '<div style="padding:10px;overflow:hidden;">';
					html += '<div>';
					html += '<div>';
					html += '<span style="white-space: nowrap;text-overflow:ellipsis;display:inline-block;max-width:100px;">';
					html += info.uinfo.nickname;
					html += '</span>';
					if(info.uinfo.sex == '1') {
						html += '<span class="fa fa-mars" style="color:#10AEFF"></span>';
					}else {
						html += '<span class="fa fa-venus" style="color:#F00096"></span>';	
					}
					html += '<span style="color:rgb(90,90,90);float:right;">'+info.time_diff+'前发布</span>';
					html += '</div>';
					html += '<div>';
					html += '<span class="fa fa-map-marker" style="color:#10AEFF"></span>';
					html += info.uinfo.province+info.uinfo.city+info.uinfo.district;
					html += '&nbsp;<span class="fa fa-rmb" style="color:#10AEFF"></span>';
					html += "每小时"+info.salary+"元";
					html += '&nbsp;<span class="fa fa-graduation-cap" style="color:#10AEFF"></span>';
					html += info.uinfo.work;
					html += '</div>';
					html += '<div>';
					
					var hire_range_arr = info.hire_range.split('，');
					for(var i in hire_range_arr) {
						var num = parseInt(i)+1;
						html += '<label class="sun-label sun-label-'+num+'">'+hire_range_arr[i];
						html += '</label>';	
					}
					
					html += '</div>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
				}
				$("#list_container").append(html);
				page ++;
				load_key = true;
				// loading 
				$("#loading_more_layer").hide();
				_self.show();
			}else if(d.res=='102') {
				$("#loading_more_layer").hide();
				$("#loading_over").show();
			}
		}
	})
}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>