<?php
class NoticeComponent {
	private $obj;
	
	function __construct() {
		global $_W;
		load()->classs('weixin.account');
		load()->model('account');
		$acid = uni_fetch($_W['uniacid']);
		$this->obj = WeiXinAccount::create($acid);
	}
	function sendApproveTpl($touser, $first, $key_1, $remark, $url) {
		
		$key = $this->settings['notice_key'];
		 print_r($key);exit;
		$tpl_id_short = $this->setting['approve_tpl_id'];
		
		return $tpl_id_short;
		if ($key != 'open') {
			return false;
		}
		$postdata['first'] = array('value' => $first, 'color' => '');
		$postdata['keyword1'] = array('value' => $key_1, 'color' => '#459ae9');
		$postdata['keyword2'] = array('value' => date("Y-m-d H:i:s"), 'color' => '#459ae9');
		$postdata['remark'] = array('value' => $remark, 'color' => '');
		$r = $this->obj->sendTplnotice($touser, $tpl_id_short, $postdata, $url);
	}
	function sendOrderTpl($touser, $first, $key_1, $key_2, $key_3, $remark, $url) {
		$tpl_id_short = $this->set['order_tpl_id'];
		$postdata['first'] = array('value' => $first, 'color' => '');
		$postdata['keyword1'] = array('value' => $key_1, 'color' => '#459ae9');
		$postdata['keyword2'] = array('value' => $key_2, 'color' => '#459ae9');
		$postdata['keyword3'] = array('value' => $key_3, 'color' => '#459ae9');
		$postdata['keyword4'] = array('value' => date("Y-m-d H:i:s"), 'color' => '#459ae9');
		$postdata['remark'] = array('value' => $remark, 'color' => '');
		$r = $this->obj->sendTplnotice($touser, $tpl_id_short, $postdata, $url);
	}
	function sendRefundTpl($touser, $first, $key_1, $key_2, $remark, $url) {
		$tpl_id_short = $this->set['refund_tpl_id'];
		$postdata['first'] = array('value' => $first, 'color' => '');
		$postdata['reason'] = array('value' => $key_1, 'color' => '#459ae9');
		$postdata['refund'] = array('value' => $key_2, 'color' => '#459ae9');
		$postdata['remark'] = array('value' => $remark, 'color' => '');
		$r = $this->obj->sendTplnotice($touser, $tpl_id_short, $postdata, $url);
	}
	function sendWaitDrawTpl($touser, $first, $key_1, $key_2, $key_3, $key_4, $remark, $url) {
		$tpl_id_short = $this->set['draw_wait_tpl_id'];
		$postdata['first'] = array('value' => $first, 'color' => '');
		$postdata['keyword1'] = array('value' => $key_1 . '元', 'color' => '#459ae9');
		$postdata['keyword2'] = array('value' => $key_2 . '元', 'color' => '#459ae9');
		$postdata['keyword3'] = array('value' => $key_3 . '元', 'color' => '#459ae9');
		$postdata['keyword4'] = array('value' => $key_4, 'color' => '#459ae9');
		$postdata['remark'] = array('value' => $remark, 'color' => '');
		$r = $this->obj->sendTplnotice($touser, $tpl_id_short, $postdata, $url);
	}
} /*黑锐源码社区*/
