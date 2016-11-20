<?php
class MembersModel {
	static function info($openid) {
		global $_W, $_GPC;
		return pdo_fetch('select * from ' . tablename('sunshine_hireme_members') . " where openid='$openid' and uniacid='{$_W['uniacid']}'");
	}
	static function appMember($userinfo) {
		global $_W;
		if ($userinfo['sex'] === '0' || $userinfo['sex'] === 0) {
			$userinfo['sex'] = 2;
		}
		$data = array();
		$data['openid'] = $userinfo['openid'];
		$data['nickname'] = $userinfo['nickname'];
		$data['sex'] = $userinfo['sex'];
		$data['country'] = $userinfo['country'];
		$data['headimgurl'] = $userinfo['avatar'];
		$data['uniacid'] = $_W['uniacid'];
		$data['add_time'] = date("Y-m-d H:i:s");
		$data['age'] = '';
		$data['isvisible'] = 'open';
		$info = self::info($userinfo['openid']);
		if ($info) {
			$new_info = array();
			unset($data['headimgurl']);
			unset($data['isvisible']);
			unset($data['nickname']);
			unset($data['update_time']);
			unset($data['add_time']);
			unset($data['city']);
			unset($data['country']);
			unset($data['age']);
			$data['update_time'] = date("Y-m-d H:i:s");
			$r = self::update($data, array('openid' => $userinfo['openid'], 'uniacid' => $_W['uniacid']));
			if ($r === false) {
				exit('update error');
			}
		} else {
			$res = pdo_insert('sunshine_hireme_members', $data);
			if ($res === false) {
				exit(' insert error');
			}
		}
	}
	static function update($data, $where) {
		global $_W;
		$r = pdo_update('sunshine_hireme_members', $data, $where);
		return $r;
	}
	static function updateUserInfo($openid, $userinfo) {
		global $_W, $_GPC;
		return pdo_update('sunshine_hireme_members', $userinfo, array('openid' => $openid, 'uniacid' => $_W['uniacid']));
	}
	static function searchList($keyword = '', $cond = array(), $begin = 1, $offset = 20) {
		global $_W;
		$sql = '';
		if ($cond) {
			foreach ($cond as $k => $v) {
				$sql.= " and $k = '$v' ";
			}
		}
		if ($keyword) {
			$sql.= " and nickname like '%$keyword%' ";
		}
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_members') . " where 1=1 $sql and uniacid={$_W['uniacid']} order by add_time desc limit $begin,$offset");
	}
	static function searchListCounts($keyword = '', $cond = array(), $begin = 1, $offset = 20) {
		global $_W;
		$sql = '';
		if ($cond) {
			foreach ($cond as $k => $v) {
				$sql.= " and $k = '$v' ";
			}
		}
		if ($keyword) {
			$sql.= " and nickname like '%$keyword%' ";
		}
		$res = pdo_fetch("select count(*) as num from " . tablename('sunshine_hireme_members') . " where 1=1 $sql and uniacid={$_W['uniacid']}");
		return $res['num'];
	}
} /*黑锐源码社区*/
