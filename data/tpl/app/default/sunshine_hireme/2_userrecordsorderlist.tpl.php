<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php  if(!$record['id']) { ?>
<div class="msg">
<div class="weui_msg">
    <div class="weui_icon_area"><i class="weui_icon_msg weui_icon_warn"></i></div>
    <div class="weui_text_area">
        <h2 class="weui_msg_title">您当前无出租中订单</h2>
        <p class="weui_msg_desc">可以立即发布您的出租消息</p>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="<?php  echo $this->createMobileUrl('hireout')?>" class="weui_btn weui_btn_primary">立即发布</a>
        </p>
    </div>
    <div class="weui_extra_area">
        <a href=""><?php  echo date('Y-m-d H:i:s')?></a>
    </div>
</div>
</div>
<?php  } else { ?>
<div class="container">
    <div class="cell">
        <div class="bd">
        <div id="list_container">
        <?php  if(is_array($list)) { foreach($list as $item) { ?>
        <a href="<?php  echo $this->createMobileUrl('userrecordsorderdetail',array('orderid'=>$item['id']))?>" class="weui_media_box weui_media_appmsg">
            <div class="weui_media_hd">
                <img class="weui_media_appmsg_thumb" src="<?php  echo $item['uinfo']['headimgurl']?>" alt="">
            </div>
            <div class="weui_media_bd">
                <h4 class="weui_media_title"><?php  echo $item['uinfo']['nickname']?></h4>
                <p class="weui_media_desc">年龄：￥<?php  echo $item['uinfo']['age']?> &nbsp;&nbsp; 性别：<?php  echo $item['uinfo']['sex']?></p>
                <p class="weui_media_desc">租时：<?php  echo $item['hire_hour']?>&nbsp;&nbsp;总租金：￥<?php  echo $item['hire_money']?></p>
            </div>
        </a>
        <?php  } } ?>
    	</div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>/addons/sunshine_hireme/common/swiper/swiper-3.3.1.min.css">
<script type="text/javascript" src="<?php  echo $_W['siteroot'];?>/addons/sunshine_hireme/common/swiper/swiper-3.3.1.min.js"></script>
<script>
  var mySwiper = new Swiper ('.swiper-container', {
    // 如果需要分页器
    pagination: '.swiper-pagination'
  })

 
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>