<?php 
class RedPackComponent {
	private $url;
	private $settings;
	function __construct($settings) {
		$this->url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		$this->settings = $settings;
		load()->model('account');
		$r = uni_setting_load(array('payment'), $_W['uniacid']);
		$this->mch_id = $r['payment']['wechat']['mchid'];
		$this->apikey = $r['payment']['wechat']['apikey'];
	}
	function sendRedPack($money, $openid) {
		$paramArr = $this->createParam($money, $openid);
		$paramArr['sign'] = $this->createSign($paramArr);
		$paramXml = array2xml($paramArr);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $paramXml);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_CAINFO, $this->settings['rootca_path']);
		curl_setopt($ch, CURLOPT_SSLCERT, $this->settings['appclient_cert_path']);
		curl_setopt($ch, CURLOPT_SSLKEY, $this->settings['appclient_key_path']);
		$return = curl_exec($ch);
		curl_close($ch);
		return $this->handleXml($return);
	}
	function createParam($money, $openid) {
		global $_W;
		$p['nonce_str'] = md5(rand(10000, 99999));
		$p['mch_billno'] = $this->mch_id . date("Ymd") . substr(md5($openid), 0, 4) . date("His");
		$p['mch_id'] = $this->mch_id;
		$p['wxappid'] = $_W['account']['key'];
		$p['send_name'] = $_W['account']['name'];
		$p['re_openid'] = $openid;
		$p['total_amount'] = $money * 100;
		$p['total_num'] = 1;
		$p['wishing'] = "快租服务提现成功$money元";
		$p['client_ip'] = $_W['clientip'];
		$p['act_name'] = "快租提现";
		$p['remark'] = "本次提现$money";
		ksort($p, SORT_STRING);
		return $p;
	}
	function createSign($paramArr) {
		foreach ($paramArr as $k => $v) {
			$paramStr[] = $k . '=' . $v;
		}
		$sign = strtoupper(md5(join($paramStr, '&') . "&key=" . $this->apikey));
		return $sign;
	}
	public function handleXml($xml) {
		$xml = "<?xml version='1.0' encoding='utf-8'?>" . $xml;
		$obj = simplexml_load_string($xml);
		if ((string)$obj->return_code == 'SUCCESS') {
			if ((string)$obj->result_code == 'SUCCESS') {
				return true;
			}
		}
		return false;
	}
} 
?>