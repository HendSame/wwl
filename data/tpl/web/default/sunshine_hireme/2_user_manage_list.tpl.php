<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container-fluid">
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<?php  if($sex === '1') { ?>男<?php  } else if($sex === '2') { ?>女<?php  } else { ?>全部性别<?php  } ?>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="javascript:void(0);" onclick="Search.searchSex('1')">男</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="Search.searchSex('2')">女</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="Search.searchSex('all')">全部</a>
						</li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<?php  if($mobile_status === 'y') { ?>已认证<?php  } else if($mobile_status === 'n') { ?>未认证<?php  } else { ?>全部认证状态<?php  } ?>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="javascript:void(0);" onclick="Search.searchMobileStatus('y')">已认证</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="Search.searchMobileStatus('n')">未认证</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="Search.searchMobileStatus('all')">全部认证状态</a>
						</li>
					</ul>
				</li>
			</ul>
			
			<div class="navbar-form navbar-left" role="search">
				<input type="hidden" id="sex" name="sex">
				<input type="hidden" id="vip_level" name="vip_level">
				<div class="form-group">
					<input type="text" id="keyword" name="keyword" class="form-control" placeholder="输入姓名进行模糊搜索" value="<?php  echo $keyword;?>"></div>
				<button type="button" class="btn btn-default" onclick="Search.searchKeyWord()">搜索</button>
				<button type="button" class="btn btn-default" onclick="Search.resetSearch()">重置</button>
			</div>
			
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>
<script type="text/javascript">
	var Search = (function() {
		var sex_val = '<?php  echo $sex;?>'||'all';
		var sex_val = '<?php  echo $mobile_status;?>'||'all';
		var keyword = '<?php  echo $keyword;?>'||'';


		var searchSex = function(val) {
			sex_val = val;
			search();
		}
		var searchKeyWord = function() {
			keyword = $("#keyword").val();
			search();
		}

		var searchMobileStatus = function(val) {
			mobile_status_val = val;
			search();
		}

		var search = function() {
			var url = '';
			url = '&sex='+sex_val+'&keyword='+keyword+'&mobile_status='+mobile_status_val;
			window.location.href="<?php  echo $this->createWebUrl('usermanagelist')?>"+url;
		}

		var resetSearch = function() {
			window.location.href="<?php  echo $this->createWebUrl('usermanagelist')?>";	
		}



		return {
			searchSex:searchSex,
			searchKeyWord:searchKeyWord,
			resetSearch:resetSearch,
			searchMobileStatus:searchMobileStatus
		}
	}())

	window.onkeydown = function(e) {
		if(e.keyCode == 13) {
			Search.searchKeyWord();
		}
	}
</script>
	<table class="table">
		<tr>
			<th width="40">#</th>
			<th width="70">头像</th>
			<th width="150">用户</th>
			<th width="70">性别</th>
			<th>电话认证</th>
			<th>最后在线时间</th>
			<th>注册时间</th>
			<th>操作</th>
		</tr>
		<?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
		<tr id="item_<?php  echo $item['id'];?>">
			<input type="hidden" id="openid_<?php  echo $item['id'];?>" value="<?php  echo $item['openid'];?>">
			<td><?php  echo $key +1+($page-1)*$pagesize?></td>
			<td>
				<img style="width:48px;height:48px;" src="<?php  echo $item['headimgurl']?>">
			</td>
			<td><?php  echo $item['nickname']?></td>
			<td><?php  if($item['sex'] == 1) { ?>男<?php  } else { ?>女<?php  } ?></td>
			<td><?php  echo $item['mobile'];?><?php  if($item['mobile_status'] == 'y') { ?><span style="color:green">已验证</span><?php  } else { ?><span style="color:red">未验证</span><?php  } ?></td>
			<td>
			<?php  echo $item['update_time'];?>
			</td>
			<td>
			<?php  echo $item['add_time'];?>
			</td>
			<td>
			暂无
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<?php  echo pagination($count,$page,$pagesize)?>
</div>
<!-- 踢出模态框 -->
<div class="modal fade bs-example-modal-sm"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="moment_detail_layer">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function openVip(id) {
		$("#openvip_layer .modal-footer").find('button').eq(1).data('user_id',id);
		var nickname = $("#item_"+id).find('td').eq(2).html();
		var sex = $("#item_"+id).find('td').eq(3).html();
		if(sex == '1') {
			sex = '男';
		}else {
			sex = '女';
		}
		var html = '';
		html += "<p>用户名："+nickname+"</p>";
		html += "<p>性&nbsp;别："+sex+"</p>";
		$("#openvip_layer .modal-body").html(html);
		$("#openvip_layer").modal('show');
	}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>