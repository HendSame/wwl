<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
    <div class="hd">
        <h1 class="page_title">预览</h1>
        <p class="page_desc">预览界面效果等同于对外展示页面</p>
    </div>
	<div class="bd">
	<!-- 幻灯片 -->
	<div class="weui_cells" style="margin:0px 0px 20px 0px">
        <div class="weui_cell" style="background-color:rgb(10,10,10);color:white">
            <div class="swiper-container  gallery-top" style="width:100%;height:200px;">
                <div class="swiper-wrapper">
                    <?php  if(is_array($record['albums'])) { foreach($record['albums'] as $item) { ?>
                    <div class="swiper-slide" style="text-align:center">
                        <img style="max-height:200px;max-width:100%" src="<?php  echo $item['img_url']?>">
                    </div>
                    <?php  } } ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div style="padding:10px;overflow:hidden;">
            <div>
                <div>
                    <span style="white-space: nowrap;text-overflow:ellipsis;display:inline-block;max-width:100px;"><?php  echo $record['uinfo']['nickname']?></span>
                    <?php  if($record['uinfo']['sex'] == '1') { ?>
                    <span class="fa fa-mars" style="color:#10AEFF"></span>
                    <?php  } else { ?>
                    <span class="fa fa-venus" style="color:#F00096"></span>
                    <?php  } ?>
                </div>
                <div>
                    <span class="fa fa-map-marker" style="color:#10AEFF"></span><?php  echo $record['uinfo']['province']?><?php  echo $record['uinfo']['city']?><?php  echo $record['uinfo']['district']?>
                    &nbsp;
                    <span class="fa fa-rmb" style="color:#10AEFF"></span>
                    每小时<?php  echo $record['salary']?>元
                    &nbsp;
                    <span class="fa fa-graduation-cap" style="color:#10AEFF"></span>
                    <?php  echo $record['uinfo']['work']?>
                </div>
                <div>
                    <?php  $hire_range_arr = explode('，',$record['hire_range'])?>
                    <?php  if(is_array($hire_range_arr)) { foreach($hire_range_arr as $key => $range) { ?>
                    <label class="sun-label sun-label-<?php  echo $key+1?>"><?php  echo $range;?></label>
                    <?php  } } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- info begin -->
    <div class="weui_cells_title">
    我可以陪你
    </div>
    <div class="weui_cells weui_cells_checkbox" id="hire_range_all">
        <?php  $hire_range_arr = explode('，',$record['hire_range'])?>
        <?php  if(is_array($hire_range_arr)) { foreach($hire_range_arr as $item) { ?>
        <label class="weui_cell weui_check_label" for='s11'>
            <div class="weui_cell_hd">
                <input type="checkbox" class="weui_check" name="hire_range" id="s11" value="" checked="" disabled="">
                <i class="weui_icon_checked"></i>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <p><?php  echo $item;?></p>
            </div>
        </label>
        <?php  } } ?>
     </div>
    <div class="weui_cells_title">
    我的出租价格（时薪）
    </div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" placeholder="0-100必填" id="salary" value="<?php  echo $record['salary']?>" disabled="">
            </div>
        </div>
    </div>
    <div class="weui_cells_title">
    我的空闲时间
    </div>
     <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">从</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type='text' value="<?php  echo $record['freetime_begin']?>" disabled="">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">到</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type='text' value="<?php  echo $record['freetime_end']?>" disabled="">
            </div>
        </div>
    </div>
    <div class="weui_cells_title">
    我的职业
    </div>
    <div class="weui_cells weui_cells_form">
    <div class="weui_cell">
        <div class="weui_cell_bd weui_cell_primary">
        <input disabled="" class="weui_input" type="text" placeholder="必填" id="work" value="<?php  echo $record['uinfo']['work']?>">
        </div>
    </div>
    </div>
    <div class="weui_cells_title">
    我的位置
    </div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
               <input type='text' class="weui_input" disabled="" value="<?php  echo $record['uinfo']['province']?>&nbsp;&nbsp;<?php  echo $record['uinfo']['city']?>">
            </div>
        </div>
    </div>
    <div class="weui_cells_title">
    自我介绍
    </div>
    <div class="weui_cells weui_cells_form">
     <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <textarea class="weui_textarea" placeholder="必填" id="self_intro" disabled="" rows="3"><?php  echo $record['uinfo']['self_intro']?></textarea>
            </div>
        </div>
    </div>
    <div class="weui_cells_title">
    我的联系方式
    </div>
    <?php  if(OrderComponent::isPayed(self::$openid,$rid) == 'payed') { ?>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">手机</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="mobile" value="<?php  echo $record['uinfo']['mobile']?>">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">微信</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="wx_number" value="<?php  echo $record['uinfo']['wx_number']?>">
            </div>
        </div>
    </div>
    <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userqrcodedetail',array('openid'=>$record['openid']))?>">
            <div class="weui_cell_bd weui_cell_primary">
                <p>微信二维码</p>
            </div>
            <div class="weui_cell_ft"><span style="color:red">点击查看</span></div>
        </a>
    </div>
    <?php  } else { ?>
    <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="javascript:;">
            <div class="weui_cell_bd weui_cell_primary">
                <p style="color:red">下单后可以查看</p>
            </div>
            <div class="weui_cell_ft"><span style="color:red"></span></div>
        </a>
    </div>
    <?php  } ?>
    <!-- info end -->
    </div>
    </div>
	<div style="height:100px;">
	</div>
    <div class="weui_tabbar">
    <a href="<?php  echo $this->createMobileUrl('userrecordsorderlist',array('rid'=>$rid))?>" class="weui_tabbar_item">
        <div class="weui_tabbar_icon">
            <img src="<?php  echo $_W['siteroot'];?>addons/sunshine_hireme/common/img/icon_nav_button.png" alt="">
        </div>
        <p class="weui_tabbar_label">查看收到的订单</p>
    </a>
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
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>