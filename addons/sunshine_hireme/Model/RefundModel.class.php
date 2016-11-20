<?php
class RefundModel {
	static function getList() {
		global $_W;
	}
	static function info($id) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_refund') . " where uniacid='{$_W['uniacid']}' and id=$id");
	}
	static function setStatus($id, $status) {
		global $_W;
		$data['status'] = $status;
		$where['uniacid'] = $_W['uniacid'];
		$where['id'] = $id;
		return pdo_update('sunshine_hireme_refund', $data, $where);
	}
	static function addItem($data) {
		global $_W;
		$data['uniacid'] = $_W['uniacid'];
		return pdo_insert('sunshine_hireme_refund', $data);
	}
	static function setStatusByOid($oid, $status) {
		global $_W;
		$data['status'] = $status;
		$where['uniacid'] = $_W['uniacid'];
		$where['oid'] = $oid;
		return pdo_update('sunshine_hireme_refund', $data, $where);
	}
} /*黑锐源码社区*/
