<?php 
class RefundComponent {
	static function listJoin($list) {
		foreach ($list as & $item) {
			$item['refund_info'] = RefundModel::info($item['id']);
		}
		return $list;
	}
	static function applyRefundBySystem($oid) {
		global $_W;
		$data['oid'] = $oid;
		$data['operator'] = 'system';
		$data['reason'] = '未被接受采纳的租赁请求，系统自动提交退款申请';
		$data['add_time'] = date("Y-m-d H:i:s");
		RefundModel::addItem($data);
	}
} 
?>