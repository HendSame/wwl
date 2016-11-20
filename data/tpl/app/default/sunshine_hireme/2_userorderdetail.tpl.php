<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
    <div class="hd">
        <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
            <div class="weui_media_hd">
                <img class="weui_media_appmsg_thumb" src="<?php  echo $record['uinfo']['headimgurl']?>" alt="">
            </div>
            <div class="weui_media_bd">
                <h4 class="weui_media_title"><?php  echo $record['uinfo']['nickname']?></h4>
                <p class="weui_media_desc"><?php  echo $record['uinfo']['self_intro']?></p>
            </div>
        </a>
    </div>
	<div class="bd">
	<!-- info begin -->
	<div class="weui_cells_title">
    我的租时
    </div>
    <div class="weui_cells weui_cells_radio" id="hire_order_radio">
        <label class="weui_cell weui_check_label" for="x11">
            <div class="weui_cell_bd weui_cell_primary">
                <p><?php  echo $order['hire_hour']?>小时</p>
            </div>
            <div class="weui_cell_ft">
                <input type="radio" value='1' class="weui_check" name="radio1" id="x11" checked="" disabled="">
                <span class="weui_icon_checked"></span>
            </div>
        </label>
    </div>
    <div class="weui_cells_title">
    支付租金
    </div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
            <p id="hire_money"><?php  echo $order['hire_money']?></p>
            </div>
        </div>
    </div>
    <div class="weui_cells_title">
    活动范围
    </div>
    <div class="weui_cells weui_cells_checkbox" id="hire_range_all">
        <?php  $hire_range_arr = explode('，',$order['hire_range'])?>
        <?php  if(is_array($hire_range_arr)) { foreach($hire_range_arr as $item) { ?>
        <label class="weui_cell weui_check_label">
            <div class="weui_cell_hd">
                <input type="checkbox" class="weui_check" name="hire_range" value="<?php  echo $item;?>" disabled="" checked="">
                <i class="weui_icon_checked"></i>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <p><?php  echo $item;?></p>
            </div>
        </label>
        <?php  } } ?>
     </div>
    <div class="weui_cells_title">
    我的留言
    </div>
    <div class="weui_cells weui_cells_form">
     <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <textarea class="weui_textarea" placeholder="必填" id="hire_remark" rows="5" disabled=""><?php  echo $order['hire_remark']?></textarea>
            </div>
        </div>
    </div>
	<!-- info end -->
	</div>
	</div>
	<div style="height:100px;">
	</div>
    <div class="weui_tabbar">
    <a href="<?php  echo $this->createMobileUrl('hiredetail',array('rid'=>$rid))?>" class="weui_tabbar_item weui_bar_item_on">
        <div class="weui_tabbar_icon">
            <img src="<?php  echo $_W['siteroot'];?>addons/sunshine_hireme/common/img/icon_nav_msg.png" alt="">
        </div>
        <p class="weui_tabbar_label">查看TA的出租信息</p>
    </a>
    <?php  if(OrderComponent::isOrderSuccess($oid)) { ?>
    <!-- 申请退款 -->
    <a href="<?php  echo $this->createMobileUrl('hiredetail',array('rid'=>$rid))?>" class="weui_tabbar_item weui_bar_item_on">
        <div class="weui_tabbar_icon">
            <img src="<?php  echo $_W['siteroot'];?>addons/sunshine_hireme/common/img/icon_nav_msg.png" alt="">
        </div>
        <p class="weui_tabbar_label">申请退款</p>
    </a>
    <!-- 确认租赁完成 -->
    <a href="<?php  echo $this->createMobileUrl('hiredone',array('oid'=>$oid))?>" class="weui_tabbar_item weui_bar_item_on">
        <div class="weui_tabbar_icon">
            <img src="<?php  echo $_W['siteroot'];?>addons/sunshine_hireme/common/img/icon_nav_msg.png" alt="">
        </div>
        <p class="weui_tabbar_label">确认结束</p>
    </a>
    <?php  } ?>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
