<?php 
class AdminComponent {
	static function isAdmin($openid) {
		$info = AdminModel::info($openid);
		if ($info) {
			return true;
		} else {
			return false;
		}
	}
} /*黑锐源码社区*/
