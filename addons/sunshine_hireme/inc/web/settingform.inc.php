<?php
global $_GPC, $_W;
$data = array();
$data['uniacid'] = $_W['uniacid'];
$data['name'] = $_GPC['settings_name'];
$data['value'] = $_GPC['settings_value'];
$data['add_time'] = date("Y-m-d H:i:s");
$save_type = $_GPC['save_type'];
if ($save_type === 'file') {
	$path = dirname(dirname(dirname(preg_replace('@\(.*\(.*$@', '', __FILE__))));
	$dirpath = $path . "/configs/{$_W['uniacid']}/";
	if (!is_dir($dirpath)) {
		mkdir($dirpath, 0777, true);
	}
	$fh = fopen($dirpath . '/' . $data['name'], 'w+');
	fwrite($fh, $data['value']);
	echoJson(array('res' => '100', 'msg' => 'success'));
} else {
	pdo_insert('sunshine_hireme_settings', $data, true);
	echoJson(array('res' => '100', 'msg' => 'success'));
} /*黑锐源码社区*/
