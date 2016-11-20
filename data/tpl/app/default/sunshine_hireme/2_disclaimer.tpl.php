<?php defined('IN_IA') or exit('Access Denied');?><?php  if(readFileConfig('public_disclaimer')) { ?>
<div class="weui_dialog_alert" id="disclaimer_layer">
    <div class="weui_mask"></div>
    <div class="weui_dialog" style="width:90%;">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">免责声明</strong></div>
        <div class="weui_dialog_bd"
        style="max-height:300px;overflow-y:scroll;text-align:left;"><?php  echo readFileConfig('public_disclaimer')?></div>
        <div class="weui_dialog_ft">
        <a href="javascript:;" id="disclaimer_layer_a" style="color:rgb(200,200,200)" class="weui_btn_dialog primary" onclick="disclaimer_close()">我同意并且接受该声明<span id="count_down">(10秒)</span></a>
        </div>
    </div>
</div>
<script>
$(".weui_dialog").on('touchmove',function(e) {
	e.stopPropagation();
})

$(".weui_mask").on('touchmove',function(e) {
	e.preventDefault();
	return false;
})
var disclaimer_i = 10;
var disclaimer_key = false;

var disclaimer_intv = setInterval(function() {
	if(disclaimer_i <= 0) {
		clearInterval(disclaimer_intv);
		disclaimer_key = true;
		$("#disclaimer_layer_a").css('color','#3cc51f');
	}
	$("#count_down").html("("+disclaimer_i+'秒)');
	disclaimer_i--;
},1000);

function disclaimer_close() {
	if(disclaimer_key) {
		$('#disclaimer_layer').hide();	
	}
}

</script>
<?php  } ?>