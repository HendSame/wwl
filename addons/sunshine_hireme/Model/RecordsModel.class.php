<?php
class RecordsModel {
	static function info($id) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_records') . " where id='{$id}' and uniacid='{$_W['uniacid']}'");
	}
	static function getList($begin = 1, $offset = 20, $sex = '') {
		global $_W, $_GPC;
		$sex_sql = $sex ? " and sex='$sex' " : '';
		$list = pdo_fetchall("select * from " . tablename('sunshine_hireme_records') . " where uniacid='{$_W['uniacid']}' $sex_sql order by add_time desc limit $begin,$offset");
		return $list;
	}
	static function getListByStatus($status = 'allow', $begin = 1, $offset = 20, $sex = '', $openid = '') {
		global $_W, $_GPC;
		$sex_sql = $sex ? " and sex='$sex' " : '';
		$list = pdo_fetchall("select * from " . tablename('sunshine_hireme_records') . " where uniacid='{$_W['uniacid']}' and status='$status' $sex_sql $openid_sql order by add_time desc limit $begin,$offset");
		return $list;
	}
	static function getListByStatusCount($status = 'allow', $sex = '', $openid = '') {
		global $_W, $_GPC;
		$r = pdo_fetch("select count(*) as num from " . tablename('sunshine_hireme_records') . " where uniacid='{$_W['uniacid']}' and status='$status' $sex_sql $openid_sql");
		if ($r['num']) {
			return $r['num'];
		}
		return 0;
	}
	static function getListByOpenid($openid, $status = 'wait', $begin = 0, $offset = 20) {
		global $_W, $_GPC;
		$list = pdo_fetchall("select * from " . tablename('sunshine_hireme_records') . " where uniacid='{$_W['uniacid']}' and status='$status' and openid='$openid' order by add_time desc limit $begin,$offset");
		return $list;
	}
	static function submitApprove($data) {
		global $_W;
		$r = pdo_insert("sunshine_hireme_records", $data);
		if ($r) {
			return pdo_insertid();
		} else {
			return false;
		}
	}
	static function changeStatus($rid, $status) {
		global $_W;
		return pdo_update('sunshine_hireme_records', array('status' => $status), array('id' => $rid));
	}
	static function getLastOne($openid) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_records') . " where openid='$openid' and uniacid='{$_W['uniacid']}' and status='allow' order by add_time desc limit 1");
	}
	static function getAllowOrWaitRecordsList($openid) {
		global $_W;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_records') . " where openid='$openid' and uniacid='{$_W['uniacid']}' and (status='allow' or status='wait' or status='begin') order by add_time desc limit 1");
	}
	static function getGrabListByStatus($status = 'allow', $begin = 1, $offset = 20, $sex = '', $openid = '') {
		global $_W, $_GPC;
		$sex_sql = $sex ? " and sex='$sex' " : '';
		$list = pdo_fetchall("select * from " . tablename('sunshine_hireme_records') . " where uniacid='{$_W['uniacid']}' and status='$status' $sex_sql $openid_sql order by salary asc limit $begin,$offset");
		return $list;
	}
	static function getGrabListByStatusCount($status = 'allow', $sex = '', $openid = '') {
		global $_W, $_GPC;
		$sex_sql = $sex ? " and sex='$sex' " : '';
		$r = pdo_fetch("select count(*) as num from " . tablename('sunshine_hireme_records') . " where uniacid='{$_W['uniacid']}' and status='$status' $sex_sql $openid_sql");
		if ($r['num']) {
			return $r['num'];
		}
		return 0;
	}
	static function getVicinityList($begin, $offset, $openid, $hire_class) {
		global $_W;
		if ($hire_class) {
			$hire_class_sql = " and hire_class='$hire_class'";
		} else {
			$hire_class_sql = '';
		}
		$info = MembersModel::info($openid);
		$list = pdo_fetchall("select *,ABS({$info['lng']}-m.lng) as lng_d,ABS({$info['lat']}-m.lat) as lat_d from " . tablename('sunshine_hireme_members') . " as m inner join " . tablename("sunshine_hireme_records") . " as r where r.openid=m.openid and r.status='allow' and m.openid<>'$openid'  and lat<>'' and lng<>'' and m.uniacid='{$_W['uniacid']}'  and r.uniacid={$_W['uniacid']} $hire_class_sql order by lng_d+lat_d asc limit $begin,$offset");
		return $list;
	}
} /*黑锐源码社区*/
