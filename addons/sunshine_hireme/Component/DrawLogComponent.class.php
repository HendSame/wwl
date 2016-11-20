<?php
class DrawLogComponent {
	static function isCanDraw($openid) {
		$r = self::getColdTime($openid);
		if ($r === false) {
			return true;
		} else {
			return false;
		}
	}
	static function getColdTime($openid) {
		$info = DrawLogModel::getLastDrawLog($openid);
		$add_date = strtotime($info['add_time']);
		$now_date = time();
		$cold_time = 7 * 24 * 3600 - ($now_date - $add_date);
		if ($cold_time > 0) {
			return S::timeDiff($cold_time);
		} else {
			return false;
		}
	}
} /*黑锐源码社区*/