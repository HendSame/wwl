<?php /*黑锐源码社区*/
class OrderComponent {
	static function orderSuccess($oid) {
		global $_W;
		$_GPC;
		return OrderModel::setStatus($oid, 'success');
	}
	static function makeOthersWaitRefund($oid, $rid, $url) {
		global $_W;
		if (!$oid) {
			return false;
		}
		$info = OrderModel::info($oid);
		if (!$info) {
			return false;
		}
		$r = OrderModel::setWaitRefundAll($oid, $rid);
		if ($r) {
			$list = OrderModel::getWaitRefundOrdersByRid($rid);
			foreach ($list as $key => $value) {
				RefundComponent::applyRefundBySystem($value['id']);
			}
			foreach ($list as $key => $item) {
				NoticeBusiness::sendRefundNotice($item['id'], $url);
			}
			return true;
		} else if ($r == array()) {
			return true;
		}
		return false;
	}
	static function isCanSee($openid, $r_openid) {
		$a = OrderModel::getRelative($openid, $r_openid);
		$b = OrderModel::getRelative($r_openid, $openid);
		if ($a || $b) {
			return true;
		}
		return false;
	}
	static function setStatusRefund($oid) {
		global $_W;
		return OrderModel::setStatus($oid, 'refund');
	}
	static function setStatusDone($oid) {
		global $_W;
		return OrderModel::setStatus($oid, 'done');
	}
	static function isPayed($openid, $rid) {
		$orderinfo = OrderModel::getOrderInfoByOpenidAndRid($openid, $rid);
		if (!$orderinfo) {
			return false;
		}
		if ($orderinfo['status'] == 'wait') {
			return 'wait';
		}
		return 'payed';
	}
	static function isOrderSuccess($oid) {
		$orderinfo = OrderModel::info($oid);
		if ($orderinfo['status'] == 'success') {
			return true;
		}
		return false;
	}
	static function listJoin($list, $id_name = 'orderid') {
		foreach ($list as $key => $item) {
			$orderinfo = OrderModel::info($item[$id_name]);
			$list[$key]['orderinfo'] = $orderinfo;
			$list[$key]['uinfo'] = MembersModel::info($orderinfo['openid']);
		}
		return $list;
	}
}
?>