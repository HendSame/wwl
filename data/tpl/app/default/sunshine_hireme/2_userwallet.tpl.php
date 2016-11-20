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
			<div class="weui_cells_title">收入冻结资金</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label for="" class="weui_label">金额</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" placeholder="必填" id="nickname" value="<?php  echo $info['frozen_money']?>元" disabled="">
                    </div>
                </div>
            </div>
            <div class="weui_cells_title">可提现资金</div>
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label for="" class="weui_label">金额</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" placeholder="必填" id="nickname" value="<?php  echo $info['avaliable_money']?>元" disabled="">
                    </div>
                </div>
            </div>
            <div class="weui_cells_tips">
            提现说明：每周提现1次，满20元可提现，单次提现上限1000元，平台收取20%佣金。计算公式：实际提现金额=提现金额x(1-0.2)
            </div>
            <div class="weui_cells_title">
            历史记录
            </div>
            <div class="weui_cells weui_cells_access">
                 <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userdrawloglist')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>提现记录</p>
                    </div>
                    <div class="weui_cell_ft">查看</div>
                </a>
                 <a class="weui_cell" href="<?php  echo $this->createMobileUrl('userwalletlog')?>">
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>收入记录</p>
                    </div>
                    <div class="weui_cell_ft">查看</div>
                </a>
            </div>
		</div>
        <div style="height:100px;">
        </div>
        <div class="weui_tabbar">
            <a href="<?php  echo $this->createMobileUrl('userdrawmoney')?>" class="weui_tabbar_item">
                <div class="weui_tabbar_icon">
                    <img src="<?php  echo $_W['siteroot'];?>addons/sunshine_hireme/common/img/icon_nav_button.png" alt="">
                </div>
                <p class="weui_tabbar_label">我要提现</p>
            </a>
        </div>
	</div>
</div>