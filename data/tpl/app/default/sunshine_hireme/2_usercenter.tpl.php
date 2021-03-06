<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
        <div class="hd">
            <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
                <div class="weui_media_hd">
                    <img class="weui_media_appmsg_thumb" src="<?php  echo $info['headimgurl']?>" alt="">
                </div>
                <div class="weui_media_bd">
                    <h4 class="weui_media_title"><?php  echo $info['nickname']?></h4>
                    <p class="weui_media_desc"><?php  echo $info['self_intro']?></p>
                </div>
            </a>
        </div>
        <div class="bd">
            <?php  if(AdminComponent::isAdmin(self::$openid)) { ?>
            <div class="weui_cells_title" style="color:red">
            尊敬的管理员，下面是为您提供的快捷入口
            </div>
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('admin')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                    <p>管理员操作入口</p>
                    </div>
                    <div class="weui_cell_ft">欢迎使用</div>
                </a>
            </div>
            <?php  } ?>
            <div class="weui_cells_title">
                资金信息
            </div>
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userwallet')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>我的钱包</p>
                    </div>
                    <div class="weui_cell_ft">查看</div>
                </a>
            </div>
            <div class="weui_cells_title">
                个人资料
            </div>
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('useredit')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>个人资料</p>
                    </div>
                    <div class="weui_cell_ft">修改</div>
                </a>
            </div>
            <div class="weui_cells_title">
            出租管理
            </div>
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userrecordslist')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>我的出租记录</p>
                    </div>
                    <div class="weui_cell_ft">分类</div>
                </a>
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userrecordsorderlist')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>出租中的订单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
                <a class="weui_cell"  <?php  if($success_order) { ?>href="<?php  echo $this->createMobileUrl('userordersuccessdetail',array('orderid'=>$success_order['id']))?>"<?php  } else { ?>href="javascript:;" onclick="alert('没有进行中的订单')" <?php  } ?>>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>进行中的订单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
            </div>
             <div class="weui_cells_title">
            招租管理
            </div>
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userorderlist',array('status'=>'wait'))?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>未支付订单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userorderlist',array('status'=>'payed'))?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>已支付订单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userorderlist',array('status'=>'success'))?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>进行中订单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userorderlist',array('status'=>'wait_refund'))?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>退款中订单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userorderlist',array('status'=>'refund'))?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>已退款订单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userorderlist',array('status'=>'done'))?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>已完成订单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
            </div>
	   </div>
    </div>
    <div style="height:100px;">
    </div>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('menu', TEMPLATE_INCLUDEPATH)) : (include template('menu', TEMPLATE_INCLUDEPATH));?>
</div>
<script type="text/javascript">   
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>