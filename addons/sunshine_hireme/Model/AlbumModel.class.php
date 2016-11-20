<?php
class AlbumModel {
	static function addItem($data) {
		global $_W;
		$r = pdo_insert('sunshine_hireme_album', $data);
		return $r;
	}
	static function listJoin($list, $id_name = 'id') {
		foreach ($list as $key => $item) {
			$list[$key]['albums'] = self::getList($item[$id_name]);
		}
		return $list;
	}
	static function getList($id) {
		global $_W;
		return pdo_fetchall('select * from ' . tablename('sunshine_hireme_album') . " where rid='$id' and uniacid='{$_W['uniacid']}'");
	}
} /*黑锐源码社区*/
