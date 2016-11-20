<?php
class OrderModel {
	static function info($id) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_order') . " where id='$id' and uniacid='{$_W['uniacid']}'");
	}
	static function getListByOpenidAndStatus($openid, $status = '', $begin = 0, $offset = 20) {
		global $_W;
		$status_sql = $status ? " and status='$status' " : '';
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_order') . " where openid='$openid' $status_sql and uniacid='{$_W['uniacid']}' order by add_time desc limit $begin,$offset");
	}
	static function getListByROpenid($openid, $status = '', $begin = 0, $offset = 20) {
		global $_W;
		$status_sql = $status ? " and status='$status' " : '';
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_order') . " where r_openid='$openid' and uniacid='{$_W['uniacid']}' order by add_time desc limit $begin,$offset");
	}
	static function getListByRidAndStatus($rid, $status = 'payed') {
		global $_W;
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_order') . " where rid='$rid' and uniacid='{$_W['uniacid']}' and status='$status' order by add_time desc");
	}
	static function addItem($data) {
		global $_W;
		$res = pdo_insert('sunshine_hireme_order', $data);
		if ($res) {
			return pdo_insertid();
		} else {
			return false;
		}
	}
	static function orderPayed($orderid, $params) {
		global $_W;
		$data = array();
		$data['status'] = 'payed';
		$data['tid'] = $params['tid'];
		$data['uniontid'] = $params['uniontid'];
		$data['transaction_id'] = $params['transaction_id'];
		$where = array();
		$where['id'] = $orderid;
		$where['uniacid'] = $_W['uniacid'];
		return pdo_update('sunshine_hireme_order', $data, $where);
	}
	static function setStatus($orderid, $status) {
		if (!$status) {
			return false;
		}
		global $_W;
		$data = array();
		$data['status'] = $status;
		$where = array();
		$where['id'] = $orderid;
		$where['uniacid'] = $_W['uniacid'];
		return pdo_update('sunshine_hireme_order', $data, $where);
	}
	static function setWaitRefundAll($oid, $rid) {
		global $_W;
		$res = pdo_query("update " . tablename('sunshine_hireme_order') . " set status='wait_refund' where rid='$rid' and id<>$oid and uniacid='{$_W['uniacid']}'");
		if (!$res) {
			return false;
		}
		return true;
	}
	static function getWaitRefundOrdersByRid($rid) {
		global $_W;
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_order') . " where status='wait_refund' and rid='$rid' and uniacid='{$_W['uniacid']}'");
	}
	static function getOrderInfoByOpenidAndRid($openid, $rid) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_order') . " where openid='$openid' and rid='$rid' and uniacid='{$_W['uniacid']}'");
	}
	static function getSuccessOrder($openid) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_order') . " where openid='$openid' and status='success' and uniacid='{$_W['uniacid']}'");
	}
	static function getRelative($openid, $r_openid) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_order') . " where (status='payed' or status='success' or status='end') and openid='$openid' and r_openid='$r_openid' and uniacid='{$_W['uniacid']}'");
	}
	static function getWaitRefundOrders($begin = 0, $offset = 20) {
		global $_W;
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_order') . " where status='wait_refund' and uniacid='{$_W['uniacid']}' limit $begin,$offset");
	}
	static function getWaitRefundOrdersCount() {
		global $_W;
		$r = pdo_fetch("select count(*) as num from " . tablename('sunshine_hireme_order') . " where status='wait_refund' and uniacid='{$_W['uniacid']}'");
		if ($r['num']) {
			return $r['num'];
		}
		return 0;
	}
	static function getRefundOrders($begin = 0, $offset = 20) {
		global $_W;
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_order') . " where status='refund' and uniacid='{$_W['uniacid']}' limit $begin,$offset");
	}
	static function getRefundOrdersCount() {
		global $_W;
		$r = pdo_fetch("select count(*) as num from " . tablename('sunshine_hireme_order') . " where status='refund' and uniacid='{$_W['uniacid']}'");
		if ($r['num']) {
			return $r['num'];
		}
		return 0;
	}
} /*黑锐源码社区*/
