<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="weui_navbar">
        <div class="weui_navbar_item <?php  if($status=='wait') { ?>weui_bar_item_on<?php  } ?>" onclick="window.location.href='<?php  echo $this->createMobileUrl('userrecordsList',array('status'=>'wait'))?>'">
            待审核
        </div>
        <div class="weui_navbar_item <?php  if($status=='allow') { ?>weui_bar_item_on<?php  } ?>" onclick="window.location.href='<?php  echo $this->createMobileUrl('userrecordsList',array('status'=>'allow'))?>'"> 
            出租中
        </div>
        <div class="weui_navbar_item <?php  if($status=='end') { ?>weui_bar_item_on<?php  } ?>" onclick="window.location.href='<?php  echo $this->createMobileUrl('userrecordsList',array('status'=>'end'))?>'"> 
            已完成
        </div>
    </div>
    <div style="height:50px;">
    </div>
    <div id="list_container">
    <?php  if(is_array($list)) { foreach($list as $item) { ?>
    <a href="<?php  echo $this->createMobileUrl('userrecordsdetail',array('rid'=>$item['id']))?>" class="weui_media_box weui_media_appmsg">
        <div class="weui_media_hd">
            <img class="weui_media_appmsg_thumb" src="<?php  echo $item['albums'][0]['img_url']?>" alt="">
        </div>
        <div class="weui_media_bd">
            <h4 class="weui_media_title"><?php  echo $item['hire_range']?></h4>
            <p class="weui_media_desc">时薪：￥<?php  echo $item['salary']?></p>
        </div>
    </a>
    <?php  } } ?>
	</div>
	<!-- bottom -->
	<div style="text-align:center;" id="listload_more">
		<p>上拉加载</p>
	</div>
	<!-- loading -->
	<div id="loading_more_layer" style="display:none;text-align:center;">
	    <p>加载中</p>
	    <i class="ui-loading"></i>
	</div>
	<div id="loading_over" style="display:none;text-align:center;">
	    <p>没有更多了~</p>
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
		data:{'page':page,'status':<?php  echo $status?>},
		url : "<?php  echo $this->createMobileUrl('userrecordslistajax')?>",
		success :function(d) {
			if(d.res == '100') {
				var html = '';
				for (var i in d.list) {
					var info = d.list[i];
					html +='<a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">';
					html +='<div class="weui_media_hd">';
					html +='<img class="weui_media_appmsg_thumb" src="'+info.albums[0].img_url+'" alt="">';
					html +='</div>';
					html +='<div class="weui_media_bd">';
					html +='<h4 class="weui_media_title">'+info.hire_range+'</h4>';
					html +='<p class="weui_media_desc">时薪：￥'+info.salary+'</p>';
					html +='</div>';
					html +='</a>';
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