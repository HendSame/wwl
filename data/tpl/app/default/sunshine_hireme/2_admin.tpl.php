<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
        <div class="hd">
            <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
                <div class="weui_media_hd">
                    <img class="weui_media_appmsg_thumb" src="<?php  echo $info['headimgurl']?>" alt="">
                </div>
                <div class="weui_media_bd">
                    <h4 class="weui_media_title" style="color:red">尊敬的管理员：<?php  echo $info['nickname']?></h4>
                    <p class="weui_media_desc"><?php  echo $info['self_intro']?></p>
                </div>
            </a>
        </div>
        <div class="bd">
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('AdminRecordsListWait')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>待审核出租</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
               <!--  <a class="weui_cell" href="<?php  echo $this->createMobileUrl('recordslist')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>最新上架</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('orderlist')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>最新下单</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a>
                <a class="weui_cell" href="<?php  echo $this->createMobileUrl('hireoutlist')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>HOT排行</p>
                    </div>
                    <div class="weui_cell_ft"></div>
                </a> -->
            </div>
	   </div>
    </div>
</div>
<script type="text/javascript">   
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>