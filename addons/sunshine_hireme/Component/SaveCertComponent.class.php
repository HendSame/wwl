<?php 
class SaveCertComponent {
	static function save($settings_name, $url) {
		global $_W;
		if (!$_FILES) {
			exit("上传错误");
		}
		$path = dirname(dirname(dirname(preg_replace('@\(.*\(.*$@', '', __FILE__)))) . '/sunshine_hireme_cert/';
		if ($_FILES['file']['size'] <= 0) {
			exit("文件大小错误");
		}
		if (!is_dir($path)) {
			if (!mkdir($path)) {
				exit("创建目录失败");
			}
		}
		$filename = $_W['uniacid'] . '_' . $_FILES['file']['name'];
		$r = move_uploaded_file($_FILES['file']['tmp_name'], $path . $filename);
		if (!$r) {
			exit("移动文件失败");
		}
		$r = SettingsModel::addItem($settings_name, $path . $filename);
		if ($r) {
			header("location:" . $url);
		} else {
			exit('写入数据失败');
		}
	}
} 
?>