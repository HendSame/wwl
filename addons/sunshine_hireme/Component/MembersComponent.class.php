<?php
class MembersComponent {
	static function listJoin($list, $openid_name = 'openid') {
		global $_W;
		foreach ($list as & $item) {
			$item['uinfo'] = MembersModel::info($item[$openid_name]);
		}
		return $list;
	}
	static function updateCaptcha($openid, $mobile, $captcha) {
		global $_W, $_GPC;
		if (!$captcha || !$openid) {
			return false;
		}
		$userinfo = array();
		$userinfo['mobile'] = $mobile;
		$userinfo['mobile_captcha'] = $captcha;
		$userinfo['mobile_captcha_send_time'] = date("Y-m-d H:i:s");
		return MembersModel::updateUserInfo($openid, $userinfo);
	}
	static function captchaOk($openid) {
		global $_W;
		$userinfo = array();
		$userinfo['mobile_status'] = 'y';
		return MembersModel::updateUserInfo($openid, $userinfo);
	}
	static function isVerifyMobile($openid) {
		global $_W;
		$info = MembersModel::info($openid);
		if (!$info) {
			return false;
		}
		if ($info['mobile_status'] == 'n') {
			return false;
		}
		return true;
	}
	static function isVerifyOk($openid) {
		global $_W;
		$info = MembersModel::info($openid);
		$v['nickname'] = $info['nickname'];
		$v['sex'] = $info['sex'];
		$v['age'] = $info['age'];
		$v['work'] = $info['work'];
		$v['self_intro'] = $info['self_intro'];
		$v['province'] = $info['province'];
		$v['city'] = $info['city'];
		$v['country'] = $info['country'];
		$v['wx_number'] = $info['wx_number'];
		$v['user_qrcode'] = $info['user_qrcode'];
		foreach ($v as $k => $item) {
			if (!$item) {
				return false;
			}
		}
		return true;
	}
	static function unFrozenMoney($openid, $money) {
		global $_W;
		$user = MembersModel::info($openid);
		$frozen_money = $user['frozen_money'] - $money;
		$avaliable_money = $user['avaliable_money'] + $money;
		$userinfo = array();
		$userinfo['frozen_money'] = $frozen_money >= 0 ? $frozen_money : 0;
		$userinfo['avaliable_money'] = $avaliable_money >= 0 ? $avaliable_money : 0;
		return MembersModel::updateUserInfo($openid, $userinfo);
	}
	static function applyDrawMoney($openid, $money) {
		$user = MembersModel::info($openid);
		$avaliable_money = $user['avaliable_money'] - $money;
		$draw_money = $user['draw_money'] + $money;
		$userinfo = array();
		$userinfo['avaliable_money'] = $avaliable_money >= 0 ? $avaliable_money : 0;
		$userinfo['draw_money'] = $draw_money >= 0 ? $draw_money : 0;
		return MembersModel::updateUserInfo($openid, $userinfo);
	}
} /*黑锐源码社区*/
