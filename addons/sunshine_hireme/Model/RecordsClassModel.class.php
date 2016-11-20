<?php
class RecordsClassModel {
	static function addItem($data) {
		return pdo_insert("sunshine_hireme_records_class", $data);
	}
	static function setStatus($id, $status) {
		global $_W;
		$where['id'] = $id;
		$where['uniacid'] = $_W['uniacid'];
		$data['status'] = $status;
		return pdo_update('sunshine_hireme_records_class', $data, $where);
	}
	static function getAll() {
		global $_W;
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_records_class') . " where uniacid='{$_W['uniacid']}' and status='y' order by sort_id asc,add_time desc");
	}
	static function isNameRepeat($class_name) {
		global $_W;
		$r = pdo_fetch("select * from " . tablename('sunshine_hireme_records_class') . " where uniacid='{$_W['uniacid']}' and class_name='$class_name'");
		if ($r) {
			return true;
		}
		return false;
	}
	static function info($id) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_records_class') . " where uniacid='{$_W['uniacid']}' and id='$id'");
	}
	static function updateItem($id, $data) {
		global $_W;
		$where['id'] = $id;
		$where['uniacid'] = $_W['uniacid'];
		return pdo_update('sunshine_hireme_records_class', $data, $where);
	}
} /*黑锐源码社区*/
