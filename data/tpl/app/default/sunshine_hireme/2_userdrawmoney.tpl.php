<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
        <div class="hd">
            <h1 class="page_title">红包提现</h1>
            <p class="page_desc">防护盾安全保障</p>
            <?php  if(DrawLogComponent::isCanDraw(self::$openid) === false) { ?>
            <p class="page_desc" style="color:red">提现冷却中，请等待：<?php  echo $cold_time?></p>
            <?php  } ?>
            <?php  if($drawinfo) { ?>
            <p class="page_desc">上次提现时间：<?php  echo $drawinfo['add_time']?></p>
            <?php  } ?>
        </div>
    	<div class="bd">
            <form action="<?php  echo $this->createMobileUrl('confirmdrawmoney')?>" method="post">
            <div class="weui_cells weui_cells_form">
                <div class="weui_cell">
                    <input class="weui_input" type="number" name="money" pattern="[0-9]*" onkeyup="checkInput(this)" placeholder="请输入提现金额">
                </div>
            </div>
            <div class="weui_cells_tips" style="color:red" id="inputError">
            </div>
            <div class="weui_cells_tips">
            当前可用提现额度：<?php  echo $info['avaliable_money']?> 元
            </div>
            <div class="weui_cells_title">
                提现说明：提现冷却时间为7天，满20元可提现，单次提现上限1000元
            </div>
            <div class="weui_cells_title">
                佣金说明：平台收取20%佣金。计算公式：实际提现金额=提现金额x(1-0.2)
            </div>
            <div style="height:80px">
            </div>
            <div class="weui_btn_area">
                <?php  if(DrawLogComponent::isCanDraw(self::$openid) === true) { ?>
                <input type="submit" name="submit" class="weui_btn weui_btn_primary" value="提现">
                <?php  } else { ?>
                <input type="submit" name="submit" class="weui_btn weui_btn_primary" disabled="" value="提现">
                <?php  } ?>
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function checkInput(obj) {
        var money = $(obj).val();
        var error_obj = $('#inputError');
        if (money < 20 || money > 1000) {
            error_obj.html("提现额度在20-1000之间");
        }else if( money > <?php  echo $info['avaliable_money']?>) {
            error_obj.html("当前可提现额度不足");   
        }else {
            error_obj.html('');
        }
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>