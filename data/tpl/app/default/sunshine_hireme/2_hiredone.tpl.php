<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
		<div class="hd">
			<h1 class="page_title">完成订单</h1>
		</div>
		<div class="bd">
			<form action="<?php  echo $this->createMobileUrl('hiredoneform')?>" method="post">
			<div class="weui_cells_title">
			您对本次出租服务还满意么，给TA评价一下吧 ^^ ~
			</div>
			<!-- <div class="weui_cells weui_cells_radio" id="hire_order_radio">
		        <label class="weui_cell weui_check_label" >
		            <div class="weui_cell_bd weui_cell_primary">
		                <p>好评</p>
		            </div>
		            <div class="weui_cell_ft">
		                <input type="radio" value='1' class="weui_check" name="radio1">
		                <span class="weui_icon_checked"></span>
		            </div>
		        </label>
		         <label class="weui_cell weui_check_label" >
		            <div class="weui_cell_bd weui_cell_primary">
		                <p>中评</p>
		            </div>
		            <div class="weui_cell_ft">
		                <input type="radio" value='2' class="weui_check" name="radio1">
		                <span class="weui_icon_checked"></span>
		            </div>
		        </label>
		         <label class="weui_cell weui_check_label" >
		            <div class="weui_cell_bd weui_cell_primary">
		                <p>差评</p>
		            </div>
		            <div class="weui_cell_ft">
		                <input type="radio" value='3' class="weui_check" name="radio1">
		                <span class="weui_icon_checked"></span>
		            </div>
		        </label>
		    </div>
	        <div class="weui_cells_title">
			来自内心的评价~
			</div> -->
			<div class="weui_cells weui_cells_form">
				<div class="weui_cell">
					<div class="weui_cell_bd weui_cell_primary">
						<input type="hidden" name="orderid" value="<?php  echo $oid?>">
						<input type="hidden" name="token" value="<?php  echo $_W['token']?>">
						<textarea class="weui_textarea" name="comment" placeholder="请输入评价内容" rows="5"></textarea>
					</div>
				</div>
			</div>
			<div class="weui_btn_area">
				<input type="submit" name="submit" class="weui_btn weui_btn_primary" value="确认完成订单">
			</div>
			<div class="weui_cells_tips">
			确认完成订单后，已冻结的支付租金将自动转入对方可提现资金池，此操作不可取消
			</div>
			</form>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>