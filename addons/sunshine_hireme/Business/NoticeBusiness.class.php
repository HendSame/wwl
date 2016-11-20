<?php

class NoticeBusiness {

	static function sendToAdmin4NewSubmit($userinfo,$url) {
		$notice = new NoticeComponent();

		$list = AdminModel::getList();
		$first = '【快租】用户"'.$userinfo['nickname'].'"提交了新的出租信息';

		foreach ($list as $key => $item) {
			$notice -> sendApproveTpl($item['openid'],$first,'待审核','点击审核',$url);
		}
	}
	/*
	下单成功过
	*/
	static function sendToUser4NewPayedOrder($r_openid,$openid,$oid,$url) {
		
		$r_userinfo = MembersModel::info($r_openid);
		$userinfo = MembersModel::info($openid);
		$orderinfo = OrderModel::info($oid);
		$record = RecordsModel::info($orderinfo['rid']);
		

		$notice = new NoticeComponent();
		// 发送给记录创建人
		$first = "快来租我-您有新的订单";

		$key_1 = $oid;
		$key_2 = "{$r_userinfo['nickname']}已下单：时薪￥{$record['salary']}，时长{$orderinfo['hire_hour']}，范围{$orderinfo['hire_range']}";
		$key_3 = $orderinfo['salary'];
		$remark = "请在60分钟内进行处理，点击查看详情";

		$notice->sendOrderTpl($r_userinfo['openid'],$first,$key_1,$key_2,$key_3,$remark,$url);
		// 发送给下单人
		$first = "快来租我-下单支付成功";

		$key_1 = $oid;
		$key_2 = "您已订购{$userinfo['nickname']}的订单：时薪￥{$record['salary']}，时长{$orderinfo['hire_hour']}，范围{$orderinfo['hire_range']}";
		$key_3 = $orderinfo['salary'];
		$remark = "订单已经支付成功，对方60分钟无应答，可以申请退款，点击查看详情";

		$notice->sendOrderTpl($r_userinfo['openid'],$first,$key_1,$key_2,$key_3,$remark,$url);
	}

	/*
	退款提醒
	*/
	static function sendRefundNotice($orderid,$url) {
		global $_W;

		$orderinfo = OrderModel::info($orderid);
		$userinfo = MembersModel::info($orderinfo['openid']);
		$r_userinfo = MembersModel::info($orderinfo['r_openid']);

		$notice = new NoticeComponent();
		$first = "您好，快租退款提醒";
		$key_1 = "用户“{$r_userinfo['nickname']}”没有接受您的求租意向，系统已自动提交退款申请至后台管理员，请等待管理员审核";
		$key_2 = $orderinfo['hire_money']."元";
		$remark = "管理员会在3个工作日内进行处理，点击进入个人中心查看详情";
		$notice->sendRefundTpl($userinfo['openid'],$first,$key_1,$key_2,$remark,$url);
	}

	/*
	确认退款成功
	*/
	static function sendConfirmRefundNotice($orderid,$url) {
		global $_W;

		$orderinfo = OrderModel::info($orderid);
		$userinfo = MembersModel::info($orderinfo['openid']);
		$r_userinfo = MembersModel::info($orderinfo['r_openid']);

		$notice = new NoticeComponent();
		$first = "您好，快租退款提醒";
		$key_1 = "管理员已经确认退款，退款单号:".$orderinfo['tid'];
		$key_2 = $orderinfo['hire_money']."元";
		$remark = "请注意查收来自公众号的退款明细，如未收到请及时联系管理员";
		$notice->sendRefundTpl($userinfo['openid'],$first,$key_1,$key_2,$remark,$url);
	}

	/*
	发布的出租消息审核通过
	*/
	static function sendHireApplyAllowNotice($rid,$url) {
		global $_W;
		
		$record = RecordsModel::info($rid);
		
		$notice = new NoticeComponent();
		$first = "您".$record['add_time']."提交的出租内容已审核";
		$notice -> sendApproveTpl($record['openid'],$first,'审核通过','点击查看',$url);
		print_r($notice);exit;
		
	}
	/*
	发布的出租消息审核未通过
	*/
	static function sendHireApplyDenyNotice($rid,$url) {
		global $_W;
		$record = RecordsModel::info($rid);
		$notice = new NoticeComponent();
		$first = "您".$record['add_time']."提交的出租内容审核未通过";
		$notice -> sendApproveTpl($record['openid'],$first,'审核未通过','点击查看',$url);
	}

	/*
	通知管理员有提现申请
	*/
	static function sendApplyDrawNotice($openid,$money,$commision,$url) {
		global $_W;
		$user = MembersModel::info($openid);
		$notice = new NoticeComponent();
		$first = "用户\"".$user['nickname']."\"发起了提现申请";
		$remark = "请及时到后台进行审核";

		$list = AdminModel::getList();
		foreach($list as $item) {
			$notice -> sendWaitDrawTpl($item['openid'],$first,$money,$commision,$money-$commision,'快租提现',$remark,$url);
		}
	}

}