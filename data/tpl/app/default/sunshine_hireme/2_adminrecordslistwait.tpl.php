<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
    <?php  if(is_array($list)) { foreach($list as $item) { ?>
    <a href="<?php  echo $this->createMobileUrl('adminrecordsdetail',array('rid'=>$item['id']))?>" class="weui_media_box weui_media_appmsg">
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
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('menu', TEMPLATE_INCLUDEPATH)) : (include template('menu', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>