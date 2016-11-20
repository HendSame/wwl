<?php
class WalletModel {
	static function addItem($openid, $money, $orderid) {
		global $_W;
		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $openid;
		$data['money'] = $money;
		$data['oid'] = $orderid;
		$data['add_time'] = date("Y-m-d H:i:s");
		return pdo_insert('sunshine_hireme_wallet', $data);
	}
	static function getListByOpenid($openid) {
		global $_W;
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_wallet') . " where openid='$openid' and uniacid='{$_W['uniacid']}' order by add_time desc");
	}
} /*黑锐源码社区*/
