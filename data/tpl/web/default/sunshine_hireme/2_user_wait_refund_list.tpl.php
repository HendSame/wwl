<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container-fluid">
	<a href="https://pay.weixin.qq.com" target="_blank">
		<button class="btn btn-sm btn-success">打开微信支付商户平台</button>
	</a>
	<label class="help-block">操作说明：</label>
	<label class="help-block">退款需要手动到商户平台进行退款，退款完成后，点击完成按钮</label>
	<!-- 列表开始 -->
	<table class="table table-hover ">
		<tr>
			<th width="40">#</th>
			<th width="70">用户</th>
			<th width="70">金额</th>
			<th width="300">退款理由</th>
			<th>退款申请时间</th>
			<th width="350">支付凭据</th>
			<th>操作</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
		<tr id="item_<?php  echo $item['id'];?>">
			<input type="hidden" id="openid_<?php  echo $item['id'];?>" value="<?php  echo $item['openid'];?>">
			<td><?php  echo $key +1+($page-1)*$pagesize?></td>
			<td title="<?php  echo $item['uinfo']['nickname']?>">
				<img style="width:48px;height:48px;" src="<?php  echo $item['uinfo']['headimgurl']?>">
			</td>
			<td><?php  echo $item['hire_money']?>元</td>
			<?php  if($item['refund_info']['operator'] == 'system') { ?>
			<td><span style="color:red">(系统发起)</span><?php  echo $item['refund_info']['reason']?></td>
			<?php  } else { ?>
			<td><?php  echo $item['refund_info']['reason']?></td>
			<?php  } ?>
			<td><?php  echo $item['refund_info']['add_time']?></td>
			<td title="双击复制内容">
				<div class="input-group">
				<span class="input-group-addon">商户单号</span>
				<input type='text' class="form-control input-sm" style="background-color:white;" value="<?php  echo $item['uniontid']?>" readonly='true'>
				</div>
				<div class="input-group">
				<span class="input-group-addon">支付单号</span>
				<input type='text' class="form-control input-sm" style="background-color:white;" value="<?php  echo $item['transaction_id']?>" readonly='true'>
				</div>
			</td>
			<td>
				<!-- 表单提交完成退款 -->
				<form action="<?php  echo $this->createWebUrl('ConfirmRefund')?>" method="post">
					<input type="hidden" name="orderid" value="<?php  echo $item['id'];?>">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
					<input type="hidden" name='backurl' value="<?php  echo $this->createWebUrl('UserWaitRefundManage',array('page'=>$page))?>">
					<input type="submit" name='submit' class="btn btn-sm btn-success" value="点击完成退款">
				</form>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo pagination($count,$page,$pagesize)?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>