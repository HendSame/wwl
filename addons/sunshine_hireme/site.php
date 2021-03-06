<?php 

defined('IN_IA') or exit('Access Denied');
 require_once dirname(__FILE__).'/Exception/Function.php'; 
 require_once dirname(__FILE__).'/Exception/S.class.php'; 
 require_once dirname(__FILE__).'/Component/AdminComponent.class.php';
 require_once dirname(__FILE__).'/Component/DrawLogComponent.class.php'; 
 require_once dirname(__FILE__).'/Component/NoticeComponent.class.php'; 
 require_once dirname(__FILE__).'/Component/OrderComponent.class.php'; 
 require_once dirname(__FILE__).'/Component/RecordsComponent.class.php';
 require_once dirname(__FILE__).'/Component/RefundComponent.class.php';
 require_once dirname(__FILE__).'/Component/MembersComponent.class.php';
 require_once dirname(__FILE__).'/Component/PayComponent.class.php'; 
 require_once dirname(__FILE__).'/Component/RedPackComponent.class.php'; 
 require_once dirname(__FILE__).'/Component/SaveCertComponent.class.php';
 require_once dirname(__FILE__).'/Component/SmsComponent.class.php'; 
 require_once dirname(__FILE__).'/Business/NoticeBusiness.class.php'; 
 require_once dirname(__FILE__).'/Model/AdminModel.class.php'; 
 require_once dirname(__FILE__).'/Model/AlbumModel.class.php';
 require_once dirname(__FILE__).'/Model/MembersModel.class.php'; 
 require_once dirname(__FILE__).'/Model/RecordsModel.class.php'; 
 require_once dirname(__FILE__).'/Model/SettingsModel.class.php';
 require_once dirname(__FILE__).'/Model/OrderModel.class.php'; 
 require_once dirname(__FILE__).'/Model/RefundModel.class.php'; 
 require_once dirname(__FILE__).'/Model/CommentModel.class.php';
 require_once dirname(__FILE__).'/Model/DrawLogModel.class.php';
 require_once dirname(__FILE__).'/Model/WalletModel.class.php'; 
 require_once dirname(__FILE__).'/Model/RecordsClassModel.class.php';
 class sunshine_hiremeModuleSite extends WeModuleSite { 
	public $settings; 
	public static $openid; 
	public static $userinfo; 
	public static $_SET; 
	public function __construct() { 
		global $_W,$_GPC; 
		if(!$_W['username']) { 
	 load()->model('mc'); 
	 $userinfo = mc_oauth_userinfo($_W['account']['acid']); 
	 self::$openid = $userinfo['openid']; 
	 $model_userinfo = MembersModel::info(self::$openid); 
	 self::$userinfo = $model_userinfo; 
	 if(!$_COOKIE['refresh_uinfo_key_hireme'] || $_COOKIE['refresh_uinfo_key_hireme'] != $userinfo['openid'] || !$model_userinfo ) { 
		if($userinfo['openid']) { 
			MembersModel::appMember($userinfo); 
			@setcookie("refresh_uinfo_key_hireme",$userinfo['openid'],time() + 3600*1); 
		} 
	  } 
	} 
	$this->settings = SettingsModel::all(); 
	self::$_SET = $this->settings; 
 } 
 public function doMobileIndex() { 
   global $_GPC,$_W; 
   $this->super_title = "出租大厅"; 
   $sex = $_GPC['sex']; 
   $page = $_GPC['page'] > 0 ? $_GPC['page'] : 1; 
   $pagesize = 10; 
   $begin = ($page-1) * $pagesize;
   $list = RecordsModel::getListByStatus('allow',$begin,$pagesize,$sex,self::$openid); 
   $list = MembersComponent::listJoin($list); 
   $list = AlbumModel::listJoin($list); 
   foreach($list as $key=>&$value) { 
	$time_diff = S::timeDiff(time() - strtotime($value['add_time']));
	$value['time_diff'] = $time_diff['str'].$time_diff['unit']; 
  } 
  include $this->template('list_album'); 
  } 
  public function doMobileLoadListMore() { 
    global $_W,$_GPC; 
	$sex = $_GPC['sex']; 
	$page = $_GPC['page'] > 0 ? $_GPC['page'] : 1; 
	$pagesize = 10; $begin = ($page-1) * $pagesize; 
	$list = RecordsModel::getListByStatus('allow',$begin,$pagesize,$sex,self::$openid); $list = MembersComponent::listJoin($list); 
	$list = AlbumModel::listJoin($list);
	foreach($list as $key=>&$value) {
		$time_diff = S::timeDiff(time() - strtotime($value['add_time']));
		$value['time_diff'] = $time_diff['str'].$time_diff['unit']; 
	} 
	if(!$list) { 
	  echoJson(array('res'=>'102','msg'=>'list is empty')); 
	 } 
	 echoJson(array('res'=>'100','msg'=>'success','list'=>$list)); 
	} 
	public function doMobileGrab() { 
	global $_GPC,$_W; 
	$this->super_title = "低价抢单"; 
	$sex = $_GPC['sex']; 
	$page = $_GPC['page'] > 0 ? $_GPC['page'] : 1; 
	$pagesize = 10; 
	$begin = ($page-1) * $pagesize; 
	$list = RecordsModel::getGrabListByStatus('allow',$begin,$pagesize,$sex,self::$openid); $list = MembersComponent::listJoin($list); 
	$list = AlbumModel::listJoin($list); 
	foreach($list as $key=>&$value) { 
		$time_diff = S::timeDiff(time() - strtotime($value['add_time'])); 
		$value['time_diff'] = $time_diff['str'].$time_diff['unit']; 
	} 
	include $this->template('list_grab'); 
 } 
 public function doMobileLoadGrabListMore() { 
	global $_W,$_GPC;
	$sex = $_GPC['sex'];
	$page = $_GPC['page'] > 0 ? $_GPC['page'] : 1; 
	$pagesize = 10; 
	$begin = ($page-1) * $pagesize; 
	$list = RecordsModel::getGrabListByStatus('allow',$begin,$pagesize,$sex,self::$openid); $list = MembersComponent::listJoin($list); 
	$list = AlbumModel::listJoin($list); 
	foreach($list as $key=>&$value) { 
		$time_diff = S::timeDiff(time() - strtotime($value['add_time'])); 
		$value['time_diff'] = $time_diff['str'].$time_diff['unit']; 
	} 
	if(!$list) { 
		echoJson(array('res'=>'102','msg'=>'list is empty')); 
	 } 
		echoJson(array('res'=>'100','msg'=>'success','list'=>$list)); 
  } 
  public function doMobileVicinity() { 
  global $_GPC,$_W; 
  $hire_class= $_GPC['hire_class'] ? $_GPC['hire_class'] : ''; 
  if($hire_class) { 
	$hire_class_info = RecordsClassModel::info($hire_class); 
	$this->super_title = "附近{$hire_class_info['class_name']}"; 
	}else { 
	$this->super_title = "附近出租"; 
	} 
	$sex = $_GPC['sex']; 
	$page = $_GPC['page'] > 0 ? $_GPC['page'] : 1; 
	$pagesize = 10; 
	$begin = ($page-1) * $pagesize; 
	$info = MembersModel::info(self::$openid); 
	$list = RecordsModel::getVicinityList($begin,$pagesize,self::$openid,$hire_class); 
	$list = RecordsComponent::listJoin($list); 
	$list = AlbumModel::listJoin($list);
	foreach($list as $key=>&$value) { 
		$time_diff = S::timeDiff(time() - strtotime($value['rinfo']['add_time'])); 
		$value['time_diff'] = $time_diff['str'].$time_diff['unit']; 
		$distance = S::ConvertDistance(S::GetShortDistance($value['lng'],$value['lat'],$info['lng'],$info['lat'])); 
		$value['distance'] = $distance['distance'].$distance['unit']; 
	} 
	include $this->template('list_vicinity'); 
 } 
 public function doMobileLoadVicinityListMore() { 
	global $_W,$_GPC; 
	$sex = $_GPC['sex']; 
	$page = $_GPC['page'] > 0 ? $_GPC['page'] : 1; 
	$pagesize = 10; 
	$begin = ($page-1) * $pagesize; 
	$hire_class= $_GPC['hire_class'] ? $_GPC['hire_class'] : ''; 
	$list = RecordsModel::getVicinityList($begin,$pagesize,self::$openid,$hire_class); 
	$list = RecordsComponent::listJoin($list); 
	$list = AlbumModel::listJoin($list); 
	$info = MembersModel::info(self::$openid); 
	foreach($list as $key=>&$value) { 
		$time_diff = S::timeDiff(time() - strtotime($value['rinfo']['add_time'])); 
		$value['time_diff'] = $time_diff['str'].$time_diff['unit'];
		$distance = S::ConvertDistance(S::GetShortDistance($value['lng'],$value['lat'],$info['lng'],$info['lat'])); 
		$value['distance'] = $distance['distance'].$distance['unit']; 
	} 
	if(!$list) { 
		echoJson(
			array('res'=>'102','msg'=>'list is empty')); 
		} 
		echoJson(
			array('res'=>'100','msg'=>'success','list'=>$list)); 
		} 
 public function doMobileHireOut() { 
	global $_GPC,$_W; 
	$this->super_title = "发布出租";
	$info = MembersModel::info(self::$openid); 
	include $this->template('hireout'); 
	} 
	public function doMobileConfirmHireOut() { 
		global $_W,$_GPC;
		$salary = $_GPC['salary']; 
		$freetime_begin = $_GPC['freetime_begin']; 
		$freetime_end = $_GPC['freetime_end'];
		$hire_range_all = $_GPC['hire_range_all']; 
		$hire_class = $_GPC['hire_class']; 
			if(!RecordsComponent::isCanSend(self::$openid)) { 
				echoJson(
					array('res'=>'101','msg'=>'当前有出租中的记录，请完成后再发布新信息')); } 
			if(MembersComponent::isVerifyOk(self::$openid) === false) { 
			echoJson(
				array('res'=>'101','msg'=>'个人资料不完整')); 
			} 
			if($salary < 1 || $salary > 100) { 
			echoJson(
			array('res'=>'101','msg'=>'时薪范围1-100')); 
			}
			if(!$freetime_begin || !$freetime_end ) { 
			echoJson(
			array('res'=>'101','msg'=>'档期时间必填')); 
			} 
			if(!$hire_range_all) { 
			echoJson(array('res'=>'101','msg'=>'填写出租范围')); 
			} 
			$data = array(); 
			$data['openid'] = self::$openid;
			$data['uniacid'] = $_W['uniacid']; 
			$data['salary'] = $salary;
			$data['freetime_begin'] = $freetime_begin; 
			$data['freetime_end'] = $freetime_end;
			$data['hire_class'] = $hire_class; 
			$data['hire_range'] = $hire_range_all; 
			$data['add_time'] = date("Y-m-d H:i:s");
			$data['status'] = 'wait';
			$rid = RecordsModel::submitApprove($data); 
			if(!$rid) { 
				echoJson(
					array('res'=>'101','msg'=>'写入数据库失败，进度1')); 
					} 
			$media_ids = $_GPC['media_ids'];
			$files = S::downloadFromWxServer($media_ids,$this->settings);
			foreach ($files as $key => $file) {
				$data = array(); 
				$data['rid'] = $rid;
				$data['uniacid'] = $_W['uniacid'];
				$data['openid'] = self::$openid; 
				$data['img_url'] = $file['name']; 
				$data['upload_way'] = $file['type']; 
				$data['add_time'] = date("Y-m-d H:i:s");
				$data['type'] = 'record';
				$res = AlbumModel::addItem($data);
				if($res === false) {
					echoJson(
						array("res"=>'101','msg'=>'添加图片出错')); 
					} 
			} 
			NoticeBusiness::sendToAdmin4NewSubmit(self::$userinfo,$_W['siteroot'].'app/'.$this->createMobileUrl('AdminRecordsListWait')); 
			echoJson(
			array("res"=>'100','msg'=>'成功')); 
			} 
	public function doMobileUserCenter() { 
		global $_W,$_GPC; 
		$this->super_title="个人中心"; 
		$info = MembersModel::info(self::$openid);
		$success_order = OrderModel::getSuccessOrder(self::$openid); 
		include $this->template('usercenter'); 
	} 
  public function doMobileUserEdit() {
	  global $_W,$_GPC;
	  $this->super_title="个人资料";
	  $info = MembersModel::info(self::$openid);
	  include $this->template('useredit'); 
	} 
	public function doMobileSaveUserInfo() {
		global $_GPC,$_W; 
		$nickname = $_GPC['nickname'];
		$sex = $_GPC['sex'];
		$age = $_GPC['age'];
		$work = $_GPC['work']; 
		$self_intro = $_GPC['self_intro']; 
		$province = $_GPC['province']; 
		$city = $_GPC['city'];
		$district = $_GPC['district'];
		$wx_number = $_GPC['wx_number']; 
		if(!$nickname) {
			echoJson(
			array('res'=>'101','msg'=>'nickname不能为空')); 
			} 
			if(!$sex) { 
			echoJson(
			array('res'=>'101','msg'=>'sex不能为空')); 
			} 
			if(!$age) {
				echoJson(
				array('res'=>'101','msg'=>'age不能为空')); 
				}				
			if(!$work) { 
			echoJson(array('res'=>'101','msg'=>'work不能为空')); 
			} 
			if(!$self_intro) {
				echoJson(array('res'=>'101','msg'=>'self_intro不能为空')); 
				} 
			if(!$province || $province == '省份') { 
			echoJson(
			array('res'=>'101','msg'=>'province不能为空')); 
			} 
			if(!$city || $city == '地级市') {
				echoJson(
				array('res'=>'101','msg'=>'city不能为空')); 
				} 
			if(!$district || $district == '市、县级市') {
				echoJson(
				array('res'=>'101','msg'=>'district不能为空')); 
			}
			if(!$wx_number) { 
				echoJson(
				array('res'=>'101','msg'=>'wx_number不能为空')); 
				} 
			$userinfo['nickname'] = $nickname; 
			$userinfo['sex'] = $sex; 
			$userinfo['age'] = $age;
			$userinfo['work'] = $work; 
			$userinfo['self_intro'] = $self_intro;
			$userinfo['province'] = $province; 
			$userinfo['city'] = $city; 
			$userinfo['district'] = $district;
			$userinfo['wx_number'] = $wx_number; 
			$res = MembersModel::updateUserInfo(self::$openid,$userinfo); 
			if($res) { 
			echoJson(
			array('res'=>'100')); 
			}else { 
			echoJson(
			array('res'=>'101','msg'=>'更新数据失败')); 
			} 
  } 
 public function doMobileUserQrcode() {
	global $_W,$_GPC; 
	$this->super_title = '微信二维码管理'; 
	$info = MembersModel::info(self::$openid);
	include $this->template('userqrcode'); 
	} 
public function doMobileSaveUserQrcode() {
	global $_GPC,$_W; 
	$media_ids = $_GPC['media_ids'];
	$file = S::downloadFromWxServer($media_ids,$this->settings);
	if($file) { 
		$filename = $file[0]['name']; 
		$upload_way = $file[0]['type'];
		$user_qrcode = $filename; MembersModel::updateUserInfo(self::$openid,array('user_qrcode'=>$user_qrcode));
	if($res === false) { 
	echoJson(
		array("res"=>'101','msg'=>'update headimgurl error')); 
	}else{ 
		echoJson(
		array("res"=>'100','msg'=>'success')); 
	} 
   }else{
	   echoJson(
	    array("res"=>'101','msg'=>'error')); 
	 } 
  } 
 public function doMobileHireDetail() {
	 global $_W,$_GPC; 
	 $this->super_title = "出租详情";
	 $rid = $_GPC['rid']; 
	 $record = RecordsModel::info($rid);
	 $record['albums'] = AlbumModel::getList($rid); 
	 $record['uinfo'] = MembersModel::info($record['openid']);
	 include $this->template('hiredetail'); 
 } 
 public function doMobileHireOrder() {
	 global $_W,$_GPC; 
	 $this->super_title="订单确认"; 
	 $rid = $_GPC['rid']; 
	 $record = RecordsModel::info($rid);
	 $record['albums'] = AlbumModel::getList($rid);
	 $record['uinfo'] = MembersModel::info($record['openid']); 
	 include $this->template('hireorder'); 
	 }
public function doMobileHireOrderCreate() { 
	global $_W,$_GPC;
	$this->super_title = "支付租金"; 
	$rid = $_GPC['rid'];
	$hire_money = $_GPC['hire_money'];
	$hire_hour = $_GPC['hire_hour'];
	$hire_range = $_GPC['hire_range']; 
	$hire_remark = $_GPC['hire_remark'];
		if(OrderComponent::isPayed(self::$openid,$rid) == 'payed') {
			$err[]= array('res'=>'101','msg'=>'重复下单'); 
		} 
	$_GPC['submit'] = 1;
	if(!checksubmit()) {
		$err[]= array('res'=>'101','msg'=>'参数错误，非法访问1'); 
	} 
	if(MembersComponent::isVerifyOk(self::$openid) === false) { 
		$err[] = array('res'=>'101','msg'=>'个人资料不完整'); 
	} 
	if(!$rid || !$hire_hour || !$hire_money || !$hire_remark || !$hire_range) { 
		$err[] = array('res'=>'101','msg'=>'参数错误，非法访问2'); 
	} 
	$record = RecordsModel::info($rid); 
	$userinfo = MembersModel::info($record['openid']);
	if(!$record) { 
		$err[] = array('res'=>'101','msg'=>'该条出租记录不存在'); 
	} 
	if(!$userinfo) {
		$err[] = array('res'=>'101','msg'=>'无该用户'); 
	} 
	$sum_salary = $hire_hour * $record['salary']; 
	if($sum_salary != $hire_money) {
		$err[] = array('res'=>'101','msg'=>'租金非法'); 
	} 
	if($err) {
		include $this->template('hireordercreate'); 
	exit; 
  } 
  if(OrderComponent::isPayed(self::$openid,$rid) === false) {
	  $data = array(); 
	  $data['uniacid'] = $_W['uniacid'];
	  $data['rid'] = $rid;
	  $data['r_openid'] = $userinfo['openid'];
	  $data['openid'] = self::$openid;
	  $data['hire_hour'] = $hire_hour; 
	  $data['hire_money'] = $hire_money; 
	  $data['hire_range'] = $hire_range;
	  $data['salary'] = $record['salary'];
	  $data['hire_remark'] = $hire_remark;
	  $data['add_time'] = date("Y-m-d H:i:s");
	  $data['status'] = 'wait'; 
	  $order_id = OrderModel::addItem($data); 
	  if(!$order_id) {
		  $err[] = array('res'=>'101','msg'=>'订单创建失败'); 
	  } 
	  if($err) { 
	  include $this->template('hireordercreate'); 
	  exit; 
	 } 
   }else { 
   $orderinfo = OrderModel::getOrderInfoByOpenidAndRid(self::$openid,$rid); 
   $order_id = $orderinfo['id']; 
   }
   $hire_money = $hire_money;
   $this->myPay($hire_money,$order_id); 
   } 
  function myPay($fee,$order_id) { 
	global $_W,$_GPC; 
	if($fee <= 0) 
	{
		message('支付错误, 金额小于0'); 
	} 
	$tid = time().rand(1000000,9999999);
	$params = array(
		'tid' => $tid.'-'.$order_id,
		'ordersn' => $tid, 
		'title' => '快租租金支付',
		'fee' => $fee, 
		'user' => $_W['member']['uid'], 
	); 
	$this->pay($params); 
 }
 public function payResult($params) {
	 global $_W;
	 $order_id = substr($params['tid'],strpos($params['tid'],'-')+1); 
	 if ($params['result'] == 'success' && $params['from'] == 'notify') { 
		$r = OrderModel::orderPayed($order_id,$params); 
		if(!$r) {
			exit('更新支付日志失败'); 
		}else {
			$orderinfo = OrderModel::info($order_id); 
			NoticeBusiness::sendToUser4NewPayedOrder($orderinfo['r_openid'],$orderinfo['openid'],$params['tid'],$_W['siteroot'].'app/'.$this->createMobileUrl('usercenter')); 
		} 
   } if($params['result'] == 'success' && $params['from'] == 'return') { 
	header("location:".$_W['siteroot'].'app/'.$this->createMobileUrl('usercenter')); 
	} 
 } 
 public function doMobileUserRecordsList() {
	 global $_W,$_GPC;
	 $this->super_title = "出租记录";
	 $status = $_GPC['status'] ? $_GPC['status'] : 'wait';
	 $list = RecordsModel::getListByOpenid(self::$openid,$status,0,20);
	 $list = AlbumModel::listJoin($list); 
	 include $this->template('userrecordslist'); 
 }
 public function doMobileRecordsListAjax() { 
  global $_W,$_GPC;
  $status = $_GPC['status'] ? $_GPC['status'] : 'wait';
  $page = $_GPC['page'] ? $_GPC['page'] : 1; $pagesize = 20; 
  $begin = ($page-1)*$pagesize;
  $list = RecordsModel::getListByOpenid(self::$openid,$status,$begin,$pagesize);
  $list = AlbumModel::listJoin($list); 
  if($list) {
	  echoJson(array('res'=>'100','msg'=>'success','list'=>$list)); 
  }else { 
  echoJson(array('res'=>'102','msg'=>'success','list'=>$list)); 
  } 
 } 
 public function doMobileUserRecordsDetail() { 
	global $_W,$_GPC;
	$this->super_title = "详情预览"; 
	$rid = $_GPC['rid'];
	$record = RecordsModel::info($rid);
	$record['albums'] = AlbumModel::getList($rid);
	$record['uinfo'] = MembersModel::info($record['openid']);
	include $this->template('userrecordsdetail'); 
 }
 public function doMobileUserOrderList() {
	 global $_W,$_GPC;
	 $status = $_GPC['status'] ? $_GPC['status'] : 'wait'; switch($status) {
		 case 'wait':
			$this->super_title = "未支付订单"; 
			break;
		case 'cancel':
			$this->super_title = "已被取消的订单";
			break; 
		case 'payed': 
			$this->super_title = "已支付订单"; 
			break; 
		case 'success': 
			$this->super_title = "进行中订单";
			break; 
		case 'wait_refund':
			$this->super_title = "退款中订单";
			break;
		case 'refund': 
			$this->super_title = "已退款订单"; 
			break; 
		case 'done':
			$this->super_title = "已完成订单";
			break; 
			default: exit('错误'); 
			break; 
   } 
   $list = OrderModel::getListByOpenidAndStatus(self::$openid,$status,0,20); 
   $list = AlbumModel::listJoin($list,'rid');
   include $this->template('userorderlist');
   }
 public function doMobileUserOrderListAjax() { 
	global $_W,$_GPC;
	$status = $_GPC['status'] ? $_GPC['status'] : 'wait';
	$page = $_GPC['page'] ? $_GPC['page'] : 1; $pagesize = 20; 
	$begin = ($page-1)*$pagesize; 
	$list = OrderModel::getListByOpenidAndStatus(self::$openid,$status,$begin,$pagesize); $list = AlbumModel::listJoin($list,'rid'); 
	if($list) { 
		echoJson(array('res'=>'100','msg'=>'success','list'=>$list)); 
	}else {
		echoJson(array('res'=>'102','msg'=>'success','list'=>$list)); 
	} 
 } 
 public function doMobileUserOrderDetail() {
	 global $_W,$_GPC;
	 $this->super_title="出租详情"; 
	 $oid = $_GPC['orderid']; 
	 $order = OrderModel::info($oid);
	 if($order['openid'] !== self::$openid) {
		 exit("非法访问"); 
	 } 
	 $rid = $order['rid'];
	 $record = RecordsModel::info($rid); 
	 $record['albums'] = AlbumModel::getList($rid); 
	 $record['uinfo'] = MembersModel::info($order['openid']);
	 include $this->template('userorderdetail'); 
 } 
 public function doMobileUserGetOrderList() { 
	global $_W,$_GPC;
	$list = OrderModel::getListByROpenidAndStatus(self::$openid,$status,0,20); 
	include $this->template('usergetorderlist'); 
 } 
 public function doMobileUserRecordsOrderList() { 
	global $_W,$_GPC;
	$this->super_title = "收到的下单"; 
	$rid = $_GPC['rid']; 
	if(!$rid) { 
		$record = RecordsModel::getLastOne(self::$openid);
		$rid = $record['id'];
	}else { 
		$record = RecordsModel::info($rid); 
	}
	$record['albums'] = AlbumModel::getList($rid);
	$record['uinfo'] = MembersModel::info(self::$openid);
	$list = OrderModel::getListByRidAndStatus($rid); 
	$list = MembersComponent::listJoin($list); 
	include $this->template('userrecordsorderlist'); 
 } 
 public function doMobileUserRecordsOrderDetail() {
	 global $_W,$_GPC; 
	 $this->super_title = "详情预览";
	 $oid = $_GPC['orderid'];
	 $order = OrderModel::info($oid);
	 if($order['r_openid'] !== self::$openid) {
		 exit("非法访问"); 
	} 
	$rid = $order['rid'];
	$record = RecordsModel::info($rid);
	$record['albums'] = AlbumModel::getList($rid); 
	$record['uinfo'] = MembersModel::info($order['openid']);
	$this->super_title = "详情预览"; 
	include $this->template('userrecordsorderdetail'); 
	} 
  public function doMobileUserOrderSuccessDetail() {
	  global $_W,$_GPC; 
	  $oid = $_GPC['orderid']; 
	  $order = OrderModel::info($oid); 
	  if($order['r_openid'] !== self::$openid) {
		  exit("非法访问"); 
	  } 
	  $rid = $order['rid']; 
	  $record = RecordsModel::info($rid); 
	  $record['albums'] = AlbumModel::getList($rid);
	  $record['uinfo'] = MembersModel::info($order['openid']);
	  include $this->template('userordersuccessdetail'); 
 } 
 public function doMobileUserDetail() {
	 global $_W,$_GPC; 
	 $openid = $_GPC['openid'];
	 $info = MembersModel::info($openid);
	 $iscansee = OrderComponent::isCanSee($openid,self::$openid);
	 include $this->template('userdetail'); 
 } 
 public function doMobileUserConfirmOrder() {
	 global $_W,$_GPC; 
	 $_GPC['submit'] = 1;
	 if(!checksubmit()) {
		 exit("非法提交"); 
	} 
	$oid = $_GPC['orderid'];
	if(!$oid) { 
		$err[] = '参数错误'; 
	} 
	$order = OrderModel::info($oid); 
	if(!$order) { 
		$err[] = '该订单不存在';
	}
	if($order['status'] != 'payed') {
		$err[] = '订单状态错误'.$order['status']; 
	} 
	if($order['r_openid'] !== self::$openid) { 
		$err[] = '非法访问，用户错误'; 
	} 
	if(!$order['hire_money']) { 
		$err[] = "金额错误"; 
	} 
	if(!$err) {
		pdo_begin(); 
		$r = RecordsModel::changeStatus($order['rid'],'begin'); 
		if(!$r) {
			$err[] = "修改记录状态失败";
			pdo_rollback();
		}else {
			$r = OrderComponent::orderSuccess($oid); 
			  if(!$r) { 
				$err[] = "修改订单状态失败"; 
				pdo_rollback(); 
			  }else {
				  $r = OrderComponent::makeOthersWaitRefund($oid,$order['rid'],$_W['siteroot'].'app/'.$this->createMobileUrl('usercenter')); 
				  if(!$r) { 
					$err[] = "重置其他订单信息为退款中失败"; 
					pdo_rollback(); 
					}else {
						pdo_commit(); 
						} 
					  } 
					} 
		} 
  include $this->template("userconfirmorderresult"); 
 } 
 public function doMobileAdmin() {
	 global $_W; 
	 $this->super_title = "超级管理后台";
	 if(!AdminComponent::isAdmin(self::$openid)) {
		 exit("非法访问，您不是管理员身份！"); 
	 } 
	 $info = MembersModel::info(self::$openid); 
	 include $this->template('admin'); 
 } 
 public function doMobileAdminRecordsListWait() { 
	global $_GPC,$_W;
	$this->super_title = "待审核管理";
	$list = RecordsModel::getListByStatus('wait',0,50); 
	$list = AlbumModel::listJoin($list);
	include $this->template('adminrecordslistwait'); 
 } 
 public function doMobileAdminRecordsDetail() {
	 global $_GPC,$_W;
	 $rid = $_GPC['rid']; 
	 $record = RecordsModel::info($rid);
	 $record['albums'] = AlbumModel::getList($rid);
	 $record['uinfo'] = MembersModel::info($record['openid']);
	include $this->template('adminrecordsdetail'); 
 }
 public function doMobileAdminRecordsVerify() { 
	global $_GPC,$_W; 
	$rid = $_GPC['rid'];
	$status = $_GPC['status']; 
	if(!$rid) { 
		echoJson(array('res'=>'101','msg'=>'参数错误'));
	} 
	if($status != 'allow' && $status != 'deny') {
		echoJson(array('res'=>'101','msg'=>'非法参数')); 
	} 
	$info = RecordsModel::info($rid); 
	if(!$info) { 
		echoJson(array('res'=>'101','msg'=>'记录不存在')); 
	} 
	if($info['status'] != 'wait') {
		echoJson(array('res'=>'101','msg'=>'记录状态不是待审核')); 
	} 
	$r = RecordsModel::changeStatus($rid,$status); 
	if($r) { 
	if($status=='allow') { 
		NoticeBusiness::sendHireApplyAllowNotice($rid,$_W['siteroot'].'app/'.$this->createMobileUrl('usercenter')); 
	}elseif($status='deny'){
		NoticeBusiness::sendHireApplyDenyNotice($rid,$_W['siteroot'].'app/'.$this->createMobileUrl('usercenter')); 
	} 
	echoJson(array('res'=>'100','msg'=>'success')); 
  } 
  echoJson(array('res'=>'101','msg'=>'更新状态失败')); 
 } 
 public function doMobileUserCheckMobile() {
	 global $_GPC,$_W;
	 $info = MembersModel::info(self::$openid);
	 if($info['mobile_status'] == 'y') {
		 exit("禁止访问"); 
	} 
	include $this->template('usercheckmobile');
 } 
 public function doMobileUserCheckMobileSendCaptcha() { 
	global $_GPC,$_W; 
	$info = MembersModel::info(self::$openid);
	$mobile = $_GPC['mobile'];
	if(!$mobile) { 
		echoJson(array('res'=>'101','msg'=>'请填写手机号')); 
	} 
	if($info['mobile_status'] == 'y') {
		echoJson(array('res'=>'101','msg'=>'手机号已验证无需重复验证')); 
	} 
	if($info['mobile_captcha_send_time'] && (time() - strtotime($info['mobile_captcha_send_time']) < 60) ) {
		echoJson(array('res'=>'101','msg'=>'您请求的太频繁了，请稍后重试')); 
	} 
	$captcha = mt_rand(100000,999999); 
	$r = MembersComponent::updateCaptcha(self::$openid,$mobile,$captcha); 
	if(!$r) {
		echoJson(array('res'=>'101','msg'=>'发送验证码失败，写入失败')); 
	} 
	$r = SmsComponent::sendCaptcha($mobile,$captcha,self::$openid); 
	if(!$r) {
		echoJson(array('res'=>'101','msg'=>'发送验证码失败')); 
	}
	echoJson(array('res'=>'100','msg'=>'success')); 
 } 
 public function doMobileUserCheckMobileVerifyCaptcha() {
	 global $_W,$_GPC;
	 $mobile = $_GPC['mobile'];
	 $captcha = $_GPC['captcha'];
	 if(!$mobile) { 
		echoJson(array('res'=>'101','msg'=>'请填写手机号')); 
	} 
	if(!$captcha) {
		echoJson(array('res'=>'101','msg'=>'请填写验证码')); 
	} 
	$info = MembersModel::info(self::$openid);
	if($info['mobile_captcha'] != $captcha) {
		echoJson(array('res'=>'101','msg'=>'验证码错误')); 
	} 
	$r = MembersComponent::captchaOk(self::$openid);
	if($r) { 
		echoJson(array('res'=>'100','msg'=>'认证成功')); 
	} 
	echoJson(
		array('res'=>'101','msg'=>'身份验证失败，请重试')); 
 } 
 public function doMobileHireDone() {
	 global $_W,$_GPC;
	 $oid = $_GPC['oid'];
	 $info = OrderModel::info($oid);
	 if(self::$openid != $info['openid']) {
		 exit("非法访问"); 
	} 
	include $this->template('hiredone'); 
 } 
 public function doMobileHireDoneForm() { 
	global $_W,$_GPC;
	if(!checksubmit()) {
		exit("非法提交"); 
	} 
	$comment = $_GPC['comment'];
	$oid = $_GPC['orderid'];
	$info = OrderModel::info($oid);
	if(self::$openid != $info['openid']) {
		exit("非法访问"); 
	} 
	pdo_begin();
	if(!$comment) {
		$err[] = '请添加评价内容'; 
		pdo_rollback(); 
	}else { 
		$r = CommentModel::addItem(self::$openid,$oid,$comment);
	if(!$r) { 
		$err[] = '添加评价内容失败'; 
		pdo_rollback(); 
	}else { 
		$r = RecordsModel::changeStatus($info['rid'],'end');
	if(!$r) { 
		$err[] = '修改发布记录状态为end失败'; 
		pdo_rollback(); 
	}else { 
		$r = OrderComponent::setStatusDone($oid);
	if(!$r) {
		$err[] = '确认订单状态失败'; 
		pdo_rollback(); 
	}else {
	$r = MembersComponent::unFrozenMoney($info['r_openid'],$info['hire_money']);
	if(!$r) { 
		$err[] = '资金解冻失败'; 
		pdo_rollback(); 
	}else {
		$r = WalletModel::addItem($info['r_openid'],$info['hire_money'],$oid);
	if(!$r) { 
			$err[] = '日志记录失败';
			pdo_rollback(); 
	} 
	pdo_commit(); 
	 } 
    } 
   } 
  } 
 } 
 include $this->template('hiredoneresult'); 
 } 
 public function doMobileUserWallet() {
	 global $_W,$_GPC;
	 $info = MembersModel::info(self::$openid); 
	 include $this->template('userwallet'); 
 } 
 public function doMobileUserDrawMoney() {
	 global $_W,$_GPC; 
	 $info = MembersModel::info(self::$openid);
	 $drawinfo = DrawLogModel::getLastDrawLog(self::$openid);
	 $cold_time_arr = DrawLogComponent::getColdTime(self::$openid);
	 $cold_time = $cold_time_arr['str'].$cold_time_arr['unit']; 
	 include $this->template('userdrawmoney'); 
 } 
 public function doMobileConfirmDrawMoney() {
	 global $_W,$_GPC;
	 if(!checksubmit()) {
		 exit("非法访问"); 
	 } 
	 $info = MembersModel::info(self::$openid); 
	 if(!$info) { 
	 exit("非法访问"); 
	 } 
	 $money = $_GPC['money'];
	 if(!is_numeric($money)) {
		 exit("错误参数"); 
	 } 
	 if( $money < 1 || $money >1000) {
		 exit("错误的额度范围"); 
	 } 
	 if($money > $info['avaliable_money']) {
		 exit("错误的提现额度"); 
	 } 
	 if(DrawLogComponent::isCanDraw(self::$openid) === false) {
		 exit('冷却中，禁止禁止提现'); 
	 } 
	 $commision = ceil($money*0.2);
	 pdo_begin(); 
	 $r = DrawLogModel::addItem(self::$openid,$money,$commision); 
	 if(!$r) { 
		$err[] = "写入日志表失败"; 
		pdo_rollback(); 
		}else {
			$r = MembersComponent::applyDrawMoney(self::$openid,$money); 
			if(!$r) {
				$err[] = "更新资金失败"; 
				pdo_rollback(); 
				}else {
					NoticeBusiness::sendApplyDrawNotice(self::$openid,$money,$commision,$_W['siteroot'].'app/'.$this->createMobileUrl('admin')); 
					pdo_commit(); 
					} 
		} 
		include $this->template('userdrawmoneyresult'); 
  } 
  public function doMobileUserDrawLogList() {
	  global $_GPC,$_W;
	  $this->super_title = "提现记录";
	  $list = DrawLogModel::getListByOpenid(self::$openid);
	  include $this->template('userdrawloglist'); 
 }
 public function doMobileUserWalletLog() {
	 global $_W,$_GPC; 
	 $this->super_title = "收入记录"; 
	 $list = WalletModel::getListByOpenid(self::$openid); 
	 $list = OrderComponent::listJoin($list,'oid'); 
	 include $this->template('userwalletlog'); 
 } 
 public function doMobileUserGps() {
	 global $_W,$_GPC;
	 if(!$_GPC['lng'] || !$_GPC['lat']) {
		 echoJson(array('res'=>'101','msg'=>'can not get your position,please retry!'.$_GPC['lng'].$_GPC['lat'])); 
	 } 
	 $data = array(); 
	 $data['lng'] = $_GPC['lng'];
	 $data['lat'] = $_GPC['lat'];
	 $r = MembersModel::update($data,array('openid'=>self::$openid,'uniacid'=>$_W['uniacid']));
	 if($r === false) {
		 echoJson(array('res'=>'101','msg'=>'update error')); 
	 } 
	 echoJson(array('res'=>'100','msg'=>'success')); 
  } 
  public function doMobileUserQrcodeDetail() {
	  global $_GPC,$_W;
	  $this->super_title = 'TA的二维码';
	  $openid = $_GPC['openid']; 
	  $info = MembersModel::info($openid);
	  include $this->template('userqrcodedetail'); 
 } 
 public function doWebManage() {
	 global $_W,$_GPC; 
	 $dog = new WatchDogComponent($this->module);
	 $dog -> spy(); 
	 include $this->template('manage'); 
 } 
 public function doWebSetNotice() {
	 global $_W,$_GPC; 
	 include $this->template('set_notice'); 
 } 
 public function doWebSetSms() {
	 global $_W,$_GPC;
	 include $this->template('set_alidayu'); 
 } 
 public function doWebSetAdmin() {
	 global $_GPC,$_W; 
	 $list = AdminModel::getList();
	 foreach ($list as $key => $value) {
		 $list[$key]['uinfo'] = MembersModel::info($value['openid']); 
	 } 
	 $token = md5(time());
	 $set['uniacid'] = $_W['uniacid'];
	 $set['name'] = 'bind_admin_qrcode_token'; 
	 $set['value'] = $token; 
	 pdo_insert('sunshine_hireme_settings',$set,true); 
	 $qrcodeUrl = createQrcode($_W['siteroot'].'app/'.$this->createMobileUrl('bindadmin',array('qrcodetoken'=>$token)));
	 include $this->template('set_admin'); 
 } 
 public function doMobilebindadmin() {
	 global $_GPC,$_W;
	 if(!self::$openid) {
		 $err_msg = array();
		 $err_msg['res'] = '101'; $err_msg['msg'] = '非法访问'; 
	 } 
	 elseif($_GPC['qrcodetoken'] != $this->settings['bind_admin_qrcode_token']) {
		 $err_msg = array();
		 $err_msg['res'] = '101'; 
		 $err_msg['msg'] = '该二维码已失效'; 
	} elseif(AdminComponent::isAdmin(self::$openid)) {
		$err_msg = array();
		$err_msg['res'] = '101'; 
		$err_msg['msg'] = '你已经是管理员身份，请勿重复添加'; 
	} else {
		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = self::$openid; 
		$data['add_time'] = date("Y-m-d H:i:s");
		pdo_insert('sunshine_hireme_admin',$data); 
		pdo_update('sunshine_hireme_settings',array('value'=>md5(time())),array('name'=>'bind_admin_qrcode_token','uniacid'=>$_W['uniacid']));
		$err_msg = array(); 
		$err_msg['res'] = '100';
		$err_msg['msg'] = '管理员绑定成功'; 
	} 
	$uinfo = MembersModel::info(self::$openid); 
	$this->super_title="管理员绑定"; 
	include $this->template('bindadmin'); 
 }
 public function doWebRemoveAdmin() { 
	global $_W,$_GPC;
	$openid = $_GPC['openid']; 
	if(!$openid) {
		echoJson(array('res'=>'101','msg'=>'参数错误')); 
	} 
	pdo_update('sunshine_hireme_admin',array('is_del'=>'y'),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
	echoJson(array('res'=>'100','msg'=>'移除成功')); 
 }
 public function doWebUserManageList() {
	 if(checksubmit('keyword',true)) {
		 } 
	global $_W,$_GPC; 
	$pagesize = 30;
	$keyword = $_GPC['keyword']; 
	$page = $_GPC['page'] ? $_GPC['page'] : 1; $begin = ($page-1)*$pagesize;
	$sex = $_GPC['sex'];
	$cond = array();
	if($sex === '1' or $sex ==='2') {
		$cond['sex'] = $sex; 
	}
	$mobile_status = $_GPC['mobile_status'];
	if($mobile_status === 'y' or $mobile_status ==='n') { 
		$cond['mobile_status'] = $mobile_status; 
	} 
	$list = MembersModel::searchList($keyword,$cond,$begin,$pagesize);
	$count = MembersModel::searchListCounts($keyword,$cond,$begin,$pagesize);
	include $this->template('user_manage_list'); 
 } 
 public function doWebUserWaitRefundManage() {
	 global $_W,$_GPC; 
	 $page = $_GPC['page'] ? $_GPC['page'] : 1; $pagesize = 20;
	 $begin = ($page-1)*$pagesize; 
	 $count = OrderModel::getWaitRefundOrdersCount(); $list = OrderModel::getWaitRefundOrders($begin,$pagesize);
	 $list = MembersComponent::listJoin($list);
	 $list = RefundComponent::listJoin($list); include $this->template('user_wait_refund_list'); 
  }
  public function doWebConfirmRefund() {
	  global $_W,$_GPC;
	  $oid = $_GPC['orderid'];
	  if(!checksubmit()) {
		  exit("报错咯~"); 
	 } 
	 $orderinfo = OrderModel::info($oid); 
	 if($orderinfo['status'] != 'wait_refund') {
		 exit("出错了，状态不对"); 
	 } 
	 $r = OrderComponent::setStatusRefund($oid); 
	 if(!$r) {
		 exit("更新记录状态错误"); 
		 } 
	NoticeBusiness::sendConfirmRefundNotice($oid,$_W['siteroot'].'app/'.$this->createMobileUrl('usercenter')); 
	header("location:".$_GPC['backurl']); 
	} 
	public function doWebUserRefundManage() {
		global $_W,$_GPC;
		$page = $_GPC['page'] ? $_GPC['page'] : 1;
		$pagesize = 20;
		$begin = ($page-1)*$pagesize;
		$count = OrderModel::getRefundOrdersCount(); 
		$list = OrderModel::getRefundOrders($begin,$pagesize); 
		$list = MembersComponent::listJoin($list); 
		$list = RefundComponent::listJoin($list); 
		include $this->template('user_refund_list'); 
  }
  public function doWebHireWaitManage() {
	  global $_W,$_GPC;
	  $page = $_GPC['page'] ? $_GPC['page'] : 1; $pagesize = 20;
	  $begin = ($page-1)*$pagesize;
	  $list = RecordsModel::getListByStatus('wait',$begin,$pagesize); 
	  $list = AlbumModel::listJoin($list);
	  $list = MembersComponent::listJoin($list); 
	  $count = RecordsModel::getListByStatusCount('wait'); 
	  include $this->template('hire_wait_manage'); 
  } 
  public function doWebHireApplyHandle() { 
	global $_W,$_GPC;
	if(!checksubmit()) {
		exit("非法提交"); 
	}
	
	$rid = $_GPC['rid']; 
	$status = $_GPC['status'];
	if($status != 'allow' && $status != 'deny') {
		exit("参数错误");
	}
	
	$r = RecordsModel::changeStatus($rid,$status);
	
	if($r) {
		if($status == 'allow') {
			NoticeBusiness::sendHireApplyAllowNotice($rid,$_W['siteroot'].'app/'.$this->createMobileUrl('usercenter')); 
			//print_r($mk);exit;
			}elseif($status == 'deny') {
				NoticeBusiness::sendHireApplyDenyNotice($rid,$_W['siteroot'].'app/'.$this->createMobileUrl('usercenter')); 
				} 
			} 
	header("location:".$_GPC['backurl']); 
  } 
  public function doWebHireAllowManage() {
	  global $_W,$_GPC;
	  $page = $_GPC['page'] ? $_GPC['page'] : 1; 
	  $pagesize = 20; $begin = ($page-1)*$pagesize;
	  $list = RecordsModel::getListByStatus('allow',$begin,$pagesize);
	  $list = AlbumModel::listJoin($list);
	  $list = MembersComponent::listJoin($list);
	  $count = RecordsModel::getListByStatusCount('allow');
	  include $this->template('hire_allow_manage'); 
  } 
  public function doWebHireItemDelete() {
	  global $_W,$_GPC;
	  $rid = $_GPC['rid']; 
	  if(!$rid) {
		  echoJson(array('res'=>'101','msg'=>'参数错误')); 
	  } 
	  $r = RecordsModel::changeStatus($rid,'deny'); 
	  if($r) { 
		echoJson(array('res'=>'100','msg'=>'置为拒绝成功')); 
	  }else { 
		echoJson(array('res'=>'101','msg'=>'置为拒绝失败')); 
	  } 
   } 
  public function doWebHireDenyManage() { 
	global $_W,$_GPC;
	$page = $_GPC['page'] ? $_GPC['page'] : 1;
	$pagesize = 20;
	$begin = ($page-1)*$pagesize; 
	$list = RecordsModel::getListByStatus('deny',$begin,$pagesize); 
	$list = AlbumModel::listJoin($list);
	$list = MembersComponent::listJoin($list);
	$count = RecordsModel::getListByStatusCount('deny');
	include $this->template('hire_deny_manage'); 
  } 
  public function doWebSetCert() {
	  global $_W,$_GPC; 
	  include $this->template('set_cert'); 
  } 
  public function doWebSaveClientCert() {
	  SaveCertComponent::save('appclient_cert_path',$this->createWebUrl('setcert')); 
  } 
  public function doWebSaveClientKey() {
	  SaveCertComponent::save('appclient_key_path',$this->createWebUrl('setcert')); 
 }
 public function doWebSaveRootCa() {
	 SaveCertComponent::save('rootca_path',$this->createWebUrl('setcert')); 
 } 
 public function doWebUserDrawManage() {
	 global $_W,$_GPC;
	 $page = $_GPC['page'] ? $_GPC['page'] : 1; $pagesize = 20; 
	 $begin = ($page-1)*$pagesize; 
	 $list = DrawLogModel::getList('wait',$begin,$pagesize); 
	 $list = MembersComponent::listJoin($list);
	 $count = DrawLogModel::getListCount('wait');
	 include $this->template('user_draw_manage'); 
  } 
 public function doWebUserDrawManageHistory() {
	 global $_W,$_GPC;
	 $page = $_GPC['page'] ? $_GPC['page'] : 1; $pagesize = 20;
	 $begin = ($page-1)*$pagesize;
	 $list = DrawLogModel::getList('handle',$begin,$pagesize);
	 $list = MembersComponent::listJoin($list);
	 $count = DrawLogModel::getListCount('handle');
	 include $this->template('user_draw_manage_history'); 
  } 
  public function doWebUserDrawConfirm() {
	  global $_W,$_GPC;
	  $draw_id = $_GPC['draw_id'];
	  if(!$draw_id) { 
		echoJson(array('res'=>'101','msg'=>'错误参数')); 
	  } 
	  if(!checksubmit()) {
		  echoJson(array('res'=>'101','msg'=>'非法提交')); 
	  } 
	  if($this->settings['redpack_key'] !== 'open') {
		  echoJson(array('res'=>'101','msg'=>'尚未开启现金红包开关，请到支付设置中进行配置')); 
		} 
		$drawinfo = DrawLogModel::info($draw_id);
		if($drawinfo['status'] !== 'wait') {
			echoJson(array('res'=>'101','msg'=>'非法状态')); 
		} 
		pdo_begin();
		$r = DrawLogModel::setHandle($draw_id);
		if(!$r) {
			pdo_rollback();
			echoJson(array('res'=>'101','msg'=>'更改日志状态失败')); 
		} 
		$redPack = new RedPackComponent($this->settings); 
		$r = $redPack -> sendRedPack($drawinfo['act_draw'],$drawinfo['openid']);
		if($r){ 
			pdo_commit(); 
			echoJson(array('res'=>'100','msg'=>'提现成功')); 
		} 
		pdo_rollback(); 
		echoJson(array('res'=>'101','msg'=>'提现失败')); 
  } 
  public function doWebSetDisclaimer() {
	  global $_W,$_GPC;
	  include $this->template("set_disclaimer"); 
  } 
  public function doWebManageRecordsClass() {
	  global $_W,$_GPC; 
	  $list = RecordsClassModel::getAll();
	  include $this->template("manage_records_class"); 
  } 
  public function doWebManageRecordsClassAdd() {
	  global $_W,$_GPC;
	  $data['uniacid'] = $_W['uniacid'];
	  $data['class_name'] = $_GPC['class_name'];
	  $data['class_logo'] = tomedia($_GPC['class_logo']);
	  $data['sort_id'] = $_GPC['sort_id'];
	  $data['add_time'] = date("Y-m-d H:i:s"); 
	  if(!$data['class_name'] ) {
		  echoJson(array('res'=>'101','msg'=>'请填写完整')); 
	 } 
	 if(RecordsClassModel::isNameRepeat($data['class_name'])) {
		 echoJson(array('res'=>'101','msg'=>'名称重复')); 
	 } 
	 $r = RecordsClassModel::addItem($data);
	 if($r) { 
	 echoJson(array('res'=>'100','msg'=>'success')); 
	 } 
	 echoJson(array('res'=>'101','msg'=>'写入数据失败')); 
	 } 
  public function doWebManageRecordsClassEdit() {
	  global $_W,$_GPC;
	  $id = $_GPC['id'];
	  $info = RecordsClassModel::info($id);
	  include $this->template("manage_records_class_edit"); 
  } 
  public function doWebManageRecordsClassEditAjax() {
	  global $_W,$_GPC; 
	  $id = $_GPC['class_id'];
	  $data['class_name'] = $_GPC['class_name'];
	  $data['class_logo'] = tomedia($_GPC['class_logo']);
	  $data['sort_id'] = $_GPC['sort_id'];
	  if(!$id || !$data['class_name'] ) {
			echoJson(array('res'=>'101','msg'=>'请填写完整')); 
		} 
		$r = RecordsClassModel::updateItem($id,$data); 
	  if($r) { 
		echoJson(array('res'=>'100','msg'=>'success')); 
	  } 
	  echoJson(array('res'=>'101','msg'=>'写入数据失败')); 
 }
 public function doWebManageRecordsClassDelete() {
	 global $_W,$_GPC;
	 $id = $_GPC['class_id'];
	 if(!$id) {
		 echoJson(array('res'=>'101','msg'=>'参数错误')); 
	 } 
	 $data['status'] = 'n';
	 $r = RecordsClassModel::updateItem($id,$data);
	 if($r) { 
		echoJson(array('res'=>'100','msg'=>'success')); 
	 } 
	 echoJson(array('res'=>'101','msg'=>'写入数据失败')); 
	 }
  protected function pay($params = array(), $mine = array()) {
	  global $_W;
	  if(!$this->inMobile)
		  {
			  message('支付功能只能在手机上使用'); 
		  }
		  $params['module'] = $this->module['name']; 
		  $pars = array(); 
		  $pars[':uniacid'] = $_W['uniacid'];
		  $pars[':module'] = $params['module'];
		  $pars[':tid'] = $params['tid'];
		  if($params['fee'] <= 0) {
			  $pars['from'] = 'return';
			  $pars['result'] = 'success';
			  $pars['type'] = ''; 
			  $pars['tid'] = $params['tid'];
			  $site = WeUtility::createModuleSite($pars[':module']);
			  $method = 'payResult'; 
			  if (method_exists($site, $method)) {
				  exit($site->$method($pars)); 
			  } 
		 } 
	$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid'; 
	$log = pdo_fetch($sql, $pars);
	if (empty($log)) { 
	$log = array(
	'uniacid' => $_W['uniacid'],
	'acid' => $_W['acid'],
	'openid' => $_W['member']['uid'],
	'module' => $this->module['name'],
	'tid' => $params['tid'],
	'fee' => $params['fee'],
	'card_fee' => $params['fee'],
	'status' => '0',
	'is_usecard' => '0',
	); 
	pdo_insert('core_paylog', $log); 
	} 
	if($log['status'] == '1') {
		message('这个订单已经支付成功, 不需要重复支付.'); 
	} 
	$setting = uni_setting($_W['uniacid'],
	array('payment', 'creditbehaviors')); 
	if(!is_array($setting['payment'])) {
		message('没有有效的支付方式, 请联系网站管理员.'); 
	} 
	$pay = $setting['payment'];
	if (empty($_W['member']['uid'])) {
		$pay['credit']['switch'] = false; 
	} 
	if (!empty($pay['credit']['switch'])) {
		$credtis = mc_credit_fetch($_W['member']['uid']);
	} 
	$you = 0; 
	if($pay['card']['switch'] == 2 && !empty($_W['openid'])) {
		if($_W['card_permission'] == 1 && !empty($params['module'])) {
			$cards = pdo_fetchall('SELECT a.id,a.card_id,a.cid,b.type,b.title,b.extra,b.is_display,b.status,b.date_info FROM ' . tablename('coupon_modules') . ' AS a LEFT JOIN ' . tablename('coupon') . ' AS b ON a.cid = b.id WHERE a.acid = :acid AND a.module = :modu AND b.is_display = 1 AND b.status = 3 ORDER BY a.id DESC', array(':acid' => $_W['acid'], ':modu' => $params['module']));
			$flag = 0; if(!empty($cards)) {
				foreach($cards as $temp) {
					$temp['date_info'] = iunserializer($temp['date_info']);
					if($temp['date_info']['time_type'] == 1) { 
						$starttime = strtotime($temp['date_info']['time_limit_start']); $endtime = strtotime($temp['date_info']['time_limit_end']); 
						if(TIMESTAMP < $starttime || TIMESTAMP > $endtime) {
							continue; 
						} else {
							$param = array(
							':acid' => $_W['acid'],
							':openid' => $_W['openid'],
							':card_id' => $temp['card_id']);
							$num = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('coupon_record') . ' WHERE acid = :acid AND openid = :openid AND card_id = :card_id AND status = 1', $param);
							if($num <= 0) { continue; } else { $flag = 1; $card = $temp; break; 
							} 
						 } 
					   } else {
						   $deadline = intval($temp['date_info']['deadline']);
						   $limit = intval($temp['date_info']['limit']);
						   $param = array(
						   ':acid' => $_W['acid'], 
						   ':openid' => $_W['openid'],
						   ':card_id' => $temp['card_id']);
						   $record = pdo_fetchall('SELECT addtime,id,code FROM ' . tablename('coupon_record') . ' WHERE acid = :acid AND openid = :openid AND card_id = :card_id AND status = 1', $param); 
						   if(!empty($record)) {
							   foreach($record as $li) {
								   $time = strtotime(date('Y-m-d', $li['addtime'])); $starttime = $time + $deadline * 86400;
								   $endtime = $time + $deadline * 86400 + $limit * 86400; if(TIMESTAMP < $starttime || TIMESTAMP > $endtime) { continue; 
								   } else {
									   $flag = 1; 
									   $card = $temp; 
									   break; 
									} 
								} 
							} 
							if($flag) {
								break; 
							} 
						} 
					} 
				} 
				if($flag) {
					if($card['type'] == 'discount') {
						$you = 1; $card['fee'] = sprintf("%.2f", ($params['fee'] * ($card['extra'] / 100))); 
					} 
					elseif($card['type'] == 'cash') {
						$cash = iunserializer($card['extra']); 
						if($params['fee'] >= $cash['least_cost']) {
							$you = 1; $card['fee'] = sprintf("%.2f", ($params['fee'] - $cash['reduce_cost'])); 
						} 
					} 
					load()->classs('coupon'); 
					$acc = new coupon($_W['acid']);
					$card_id = $card['card_id'];
					$time = TIMESTAMP;
					$randstr = random(8);
					$sign = array($card_id, $time, $randstr, $acc->account['key']); $signature = $acc->SignatureCard($sign);
					if(is_error($signature)) {
						$you = 0; 
					} 
				} 
			} 
		} 
		if($pay['card']['switch'] == 3 && $_W['member']['uid']) { 
			$cards = array();
			if(!empty($params['module'])) {
				$cards = pdo_fetchall('SELECT a.id,a.couponid,b.type,b.title,b.discount,b.condition,b.starttime,b.endtime FROM ' . tablename('activity_coupon_modules') . ' AS a LEFT JOIN ' . tablename('activity_coupon') . ' AS b ON a.couponid = b.couponid WHERE a.uniacid = :uniacid AND a.module = :modu AND b.condition <= :condition AND b.starttime <= :time AND b.endtime >= :time  ORDER BY a.id DESC', array(':uniacid' => $_W['uniacid'], ':modu' => $params['module'], ':time' => TIMESTAMP, ':condition' => $params['fee']), 'couponid'); 
				if(!empty($cards)) {
					foreach($cards as $key => &$card) {
						$has = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('activity_coupon_record') . ' WHERE uid = :uid AND uniacid = :aid AND couponid = :cid AND status = 1' . $condition, array(':uid' => $_W['member']['uid'], ':aid' => $_W['uniacid'], ':cid' => $card['couponid'])); 
						if($has > 0){ if($card['type'] == '1') {
							$card['fee'] = sprintf("%.2f", ($params['fee'] * $card['discount']));
							$card['discount_cn'] = sprintf("%.2f", $params['fee'] * (1 - $card['discount'])); 
						} elseif($card['type'] == '2') {
							$card['fee'] = sprintf("%.2f", ($params['fee'] - $card['discount'])); 
							$card['discount_cn'] = $card['discount']; 
						} 
					} else {
						unset($cards[$key]); 
						} 
					} 
				 } 
			} 
			if(!empty($cards)) {
				$cards_str = json_encode($cards); 
			} 
	} 
	include $this->template('paycenter'); 
  } 
 }

?>