<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>/addons/sunshine_hireme/common/weui/weui.min.css">
	<link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>/addons/sunshine_hireme/common/weui/example.css">
	<link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>/addons/sunshine_hireme/common/css/common.css">
	<link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>/addons/sunshine_hireme/common/awesome/css/font-awesome.min.css">
	<title><?php  echo $this->super_title?></title>
	<?php  register_jssdk()?>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="<?php  echo $_W['siteroot'];?>/addons/sunshine_hireme/common/js/zepto.min.js"></script>
	<script type="text/javascript">
		// 分享相关
		wx.ready(function() {
			if("{$this->share_img}") {
				imgUrl = "<?php  echo $this->share_img?>";
			}else {
				imgUrl = '<?php  echo $_W['siteroot']?>/addons/sunshine_hireme/common/img/share_img.jpg';
			}

			if("{php echo $this->share_title") {
				share_title = "<?php  echo $this->share_title?>";
			}
			else
			{
				share_title = '快来租我';
			}
			sharedata = {
				title: share_title,
				desc: "<?php  echo $this->share_content?>",
				link: window.location.href,
				imgUrl: imgUrl,
				success: function(){
					
				},
				cancel: function(){
					
				}
			};

			wx.onMenuShareAppMessage(sharedata);
			wx.onMenuShareTimeline(sharedata);
			wx.onMenuShareQQ(sharedata);
			wx.onMenuShareWeibo(sharedata);

			wx.hideMenuItems({
			    menuList: [
			    	'menuItem:share:qq',
			    	'menuItem:share:weiboApp',
			    	'menuItem:share:facebook',
			    	'menuItem:share:QZone',
			    	'menuItem:copyUrl',
			    	'menuItem:readMode',
			    	'menuItem:openWithSafari',
			    	'menuItem:openWithQQBrowser'
			    ] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
			});
		})
	</script>

</head>
<body>