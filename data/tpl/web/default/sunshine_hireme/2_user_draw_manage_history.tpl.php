<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container-fluid">
	<a href="https://pay.weixin.qq.com" target="_blank">
		<button class="btn btn-sm btn-success">打开微信支付商户平台</button>
	</a>

	<!-- 列表开始 -->
	<table class="table table-hover">
		<tr>
			<th width="40">#</th>
			<th width="70">用户</th>
			<th>提现总金额</th>
			<th>平台佣金</th>
			<th>实际提现金额</th>
			<th>申请时间</th>
			<th>确认时间</th>
			<th>操作</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
		<tr id="item_<?php  echo $item['id'];?>">
			<input type="hidden" id="openid_<?php  echo $item['id'];?>" value="<?php  echo $item['openid'];?>">
			<td><?php  echo $key +1+($page-1)*$pagesize?></td>
			<td title="<?php  echo $item['uinfo']['nickname']?>">
				<img style="width:48px;height:48px;" src="<?php  echo $item['uinfo']['headimgurl']?>">
			</td>
			<td><?php  echo $item['money']?>元</td>
			<td><?php  echo $item['commision']?>元</td>
			<td><?php  echo $item['act_draw']?>元</td>
			<td><?php  echo $item['add_time']?></td>
			<td><?php  echo $item['update_time']?></td>
			<td>
				提现成功
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo pagination($count,$page,$pagesize)?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
