<?php /*黑锐源码社区*/
class RecordsComponent {
	static function isCanSend($openid) {
		global $_W;
		$info = RecordsModel::getAllowOrWaitRecordsList($openid);
		if ($info) {
			return false;
		}
		return true;
	}
	static function listJoin($list) {
		global $_W;
		foreach ($list as & $item) {
			$item['rinfo'] = RecordsModel::getLastOne($item['openid']);
		}
		return $list;
	}
} 
?>