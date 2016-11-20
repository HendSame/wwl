<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
	<div class="cell">
        <div class="hd">
            <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
                <div class="weui_media_hd">
                    <img class="weui_media_appmsg_thumb" src="<?php  echo $info['headimgurl']?>" alt="">
                </div>
                <div class="weui_media_bd">
                    <h4 class="weui_media_title"><?php  echo $info['nickname']?></h4>
                    <p class="weui_media_desc"><?php  echo $info['self_intro']?></p>
                </div>
            </a>
        </div>
        <div class="bd">
            <div class="weui_cells_title">
            手机号验证
            </div>
             <div class="weui_cells weui_cells_form">
                <div class="weui_cell weui_vcode">
                    <div class="weui_cell_hd"><label for="" class="weui_label">手机</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="number" placeholder="必填" id="mobile">
                    </div>
                    <div class="weui_cell_ft" style="font-size:16px;border-left:1px solid #D9D9D9">
                        <div style="text-align:center;width:90px;height:44px;line-height:44px;margin-left:5px;background:" onclick="sendCaptcha(this)">获取验证码</div>
                    </div>
                </div>
                <div class="weui_cell weui_cell_warn">
                    <div class="weui_cell_hd"><label for="" class="weui_label">验证码</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" id="captcha" type="number" placeholder="请输入验证码">
                    </div>
                </div>
            </div>
            <div class="weui_cells_tips">
                点击按钮保存填写的信息
            </div>
            <div class="weui_btn_area">
                <a class="weui_btn weui_btn_primary" href="javascript:void(0)" onclick="submitCheck()">提交认证</a>
            </div>
    	</div>
    </div>
</div>
<script type="text/javascript">
    var sendCaptchaKey = true;
    var startTime = 60;
    function sendCaptcha(obj) {

        if(!sendCaptchaKey) {
            return false;
        }

        var mobile = $("#mobile").val();
        
        if(mobile.length != 11) {
            alert("请输入正确的手机号");
            return;
        }

        // 关闭触发开关
        sendCaptchaKey = false;

        // 发送验证码
        $.ajax({
            type:'post',
            data:{mobile:mobile},
            url:"<?php  echo $this->createMobileUrl('UserCheckMobileSendCaptcha')?>",
            success:function(d,s) {
                if(d.res == '100') {
                    // 倒计时开始
                    var intv = setInterval(function() {
                        $(obj).html(startTime+"s");
                        // 结束自动退出
                        if(!startTime) {
                            clearInterval(intv);
                            sendCaptchaKey = true;
                            $(obj).html("获取验证码");
                            return false;
                        }
                        startTime --;
                    },1000)
                }else {
                    alert(d.msg);
                    sendCaptchaKey = true;
                }
            }
        })
    }
    

    function submitCheck() {
        var captcha = $("#captcha").val();
        var mobile = $("#mobile").val();

        if(!mobile) {
            alert("请填写手机号");
            return;
        }
        if(!captcha) {
            alert("请填写验证码");
            return;
        }
        $.ajax({
             type:'post',
            data:{mobile:mobile,captcha:captcha},
            url:"<?php  echo $this->createMobileUrl('UserCheckMobileVerifyCaptcha')?>",
            success:function(d,s) {
                if(d.res == '100') {
                    alert("身份认证成功");
                    window.location.href="<?php  echo $this->createMobileUrl('useredit')?>";
                }else {
                    alert(d.msg);
                }
            }
        })

    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>