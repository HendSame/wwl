<?php
class CommentModel {
	static function addItem($openid, $orderid, $comment) {
		global $_W;
		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $openid;
		$data['comment'] = $comment;
		$data['oid'] = $orderid;
		$data['add_time'] = date("Y-m-d H:i:s");
		return pdo_insert('sunshine_hireme_comment', $data);
	}
} /*黑锐源码社区*/
