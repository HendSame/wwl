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
        <div class="weui_cells_tips">
        声明：请保证自己提交的信息准确无误，一旦提交后，将无法修改。
        </div>
        <div class="weui_cells_title">
        展示图片（最多9张）
        </div>
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <div class="weiui_uploader_bd">
                        <ul class="weui_uploader_files" id="uploader_files">
                        </ul>
                    </div>
                    <div class="weui_uploader_input_wrp" id="uploader_files_btn">
                        <button class="weui_uploader_input" onclick="doSelect()"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="weui_cells_tips">
        点击可以移除已选中图片
        </div>
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label for="" class="weui_label">时薪</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" placeholder="1-100必填，只能填写数字" id="salary" value="">
                </div>
            </div>
        </div>
        <div class="weui_cells_title">
        档期时间段（仅用作参考时间范围）
        </div>
          <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label for="" class="weui_label">起始</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="datetime-local" placeholder="" id="freetime_begin" value="">
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label for="" class="weui_label">结束</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="datetime-local" placeholder="" id="freetime_end" value="">
                </div>
            </div>
        </div>
        <div class="weui_cells_title">
        主要出租项目
        </div>
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell weui_cell_select">
                <div class="weui_cell_bd weui_cell_primary">
                    <select class="weui_select" id="hire_class">
                        <?php  if(is_array(RecordsClassModel::getAll())) { foreach(RecordsClassModel::getAll() as $item) { ?>
                        <option value="<?php  echo $item['id']?>" ><?php  echo $item['class_name'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="weui_cells_title">
        出租范围
        </div>
        <div class="weui_cells weui_cells_checkbox" id="hire_range_all">
            <label class="weui_cell weui_check_label" for='s11'>
                <div class="weui_cell_hd">
                    <input type="checkbox" class="weui_check" name="hire_range" id="s11" value="看电影">
                    <i class="weui_icon_checked"></i>
                </div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>看电影</p>
                </div>
            </label>
            <label class="weui_cell weui_check_label" for='s12'>
                <div class="weui_cell_hd">
                    <input type="checkbox" class="weui_check" name="hire_range" id="s12" value="吃饭">
                    <i class="weui_icon_checked"></i>
                </div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>吃饭</p>
                </div>
            </label>
             <label class="weui_cell weui_check_label" for='s13'>
                <div class="weui_cell_hd">
                    <input type="checkbox" class="weui_check" name="hire_range" id="s13" value="逛街">
                    <i class="weui_icon_checked"></i>
                </div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>逛街</p>
                </div>
            </label>
            <label class="weui_cell weui_check_label" for='s14'>
                <div class="weui_cell_hd">
                    <input type="checkbox" class="weui_check" name="hire_range" id="s14" value="参加聚会">
                    <i class="weui_icon_checked"></i>
                </div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>参加聚会</p>
                </div>
            </label>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label for="" class="weui_label">其他</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" placeholder="跳舞，约会，网聊，视频..." id="hire_range_more">
                </div>
            </div>
        </div>
        <div class="weui_cells_tips">
        其他范围请使用逗号隔开
        </div>
        <div class="weui_cells_title">
        *以下信息如需修改请到个人资料中进行调整
        </div>
        <div class="weui_cells_title">
        个人信息
        </div>
        <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">昵称</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="nickname" value="<?php  echo $info['nickname']?>">
            </div>
        </div>
        <div class="weui_cell weui_cell_select">
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="select1" id="sex" disabled="">
                    <option value="2" <?php  if($info['sex'] == 2) { ?>selected<?php  } ?>>女</option>
                    <option value="1" <?php  if($info['sex'] == 1) { ?>selected<?php  } ?>>男</option>
                </select>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">年龄</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="age" value="<?php  echo $info['age']?>">
            </div>
        </div>
          <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">职业</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="work" value="<?php  echo $info['work']?>">
            </div>
        </div>
    </div>
    <div class="weui_cells_title">
    个人介绍
    </div>
    <div class="weui_cells weui_cells_form">
     <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <textarea class="weui_textarea" placeholder="必填" id="self_intro" disabled="" rows="3"><?php  echo $info['self_intro']?></textarea>
            </div>
        </div>
    </div>
     <div class="weui_cells_title">
    位置信息
    </div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">省</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="province" value="<?php  echo $info['province']?>" placeholder="">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">市</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="city" value="<?php  echo $info['city']?>" placeholder="">
            </div>
        </div>
    </div>
    <div class="weui_cells_title">
    认证信息
    </div>
     <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">手机</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="mobile" value="<?php  echo $info['mobile']?>">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label for="" class="weui_label">微信</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled="" class="weui_input" type="text" placeholder="必填" id="wx_number" value="<?php  echo $info['wx_number']?>">
            </div>
        </div>
    </div>
    <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="javascript:;">
            <div class="weui_cell_bd weui_cell_primary">
                <p>微信二维码</p>
            </div>
            <div class="weui_cell_ft"><?php  if(!$info['user_qrcode']) { ?><span style="color:red">（尚未添加）</span><?php  } ?>已添加</div>
        </a>
    </div>
    <div class="weui_cells_tips">
        点击按钮发布该条出租消息
    </div>
    <div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href="javascript:void(0)" onclick="doUpload()">发布</a>
    </div>
    </div>
    </div>
    <!-- 是否允许发布 -->
    <?php  if(!RecordsComponent::isCanSend(self::$openid)) { ?>
    <div class="weui_dialog_alert">
    <div class="weui_mask" id="weui_mask_layer"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">提示</strong></div>
        <div class="weui_dialog_bd">您现在有正在出租中的记录，请等待该记录完成后再发布新信息</div>
        <div class="weui_dialog_ft">
            <a href="<?php  echo $this->createMobileUrl('usercenter')?>" class="weui_btn_dialog primary">返回个人中心查看</a>
        </div>
    </div>
    <script type="text/javascript">
        $("#weui_mask_layer").on('touchmove',function(event) {
            event.preventDefault();
            return false;
        });
    </script>
    <?php  } else { ?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('disclaimer', TEMPLATE_INCLUDEPATH)) : (include template('disclaimer', TEMPLATE_INCLUDEPATH));?>
    <?php  } ?>
</div>
<script type="text/javascript">
    $("#weui_mask_layer").on('touchmove',function(event) {
        event.preventDefault();
        return false;
    });
</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('confirmlayer', TEMPLATE_INCLUDEPATH)) : (include template('confirmlayer', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
    var images = {
        localId: [],
        serverId: [],
        count:9
    };
    function doSelect () {
        // 判断图片数量
        if($('#uploader_files li').size() > 9)
        {
            alert("最多上传9张照片");
            return;
        }

        wx.chooseImage({
            count: images.count, // 默认9
            sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {

                for(var i in res.localIds) {
                    images.localId.push(res.localIds[i]);
                    addImg(res.localIds[i]);
                }
                images.count -= res.localIds.length;
                if(!images.count)
                {
                    $("#uploader_files_btn").hide();
                }
            }
        });
    };
    // 添加上传图片
    function addImg(localId) {
        var html = "";
        html += "<li class='weui_uploader_file' onclick='doDelete(this,\""+localId+"\")'>";
        html += "<a><img src='"+localId+"'></a>";
        html +="</li>";
        $("#uploader_files").append(html);
    }

    function doDelete(obj,localId) {
        if(!confirm('确认删除？')) {
            return false;
        }
        // remove
        images.localId.splice(images.localId.indexOf(localId),1);
        images.count++;

        $(obj).remove();
    }

    // 5.3 上传图片
    function doUpload () {
        $("#save_btn").attr('disabled',true);
        if (images.localId.length == 0) {
            doSave(0);
        }else {
            var i = 0, length = images.localId.length;
            images.serverId = [];
            function upload() {
                wx.uploadImage({
                    localId: images.localId[i],
                    success: function (res) {
                        i++;
                        images.serverId.push(res.serverId);
                        if (i < length) {
                            upload();
                        }else{
                            var media_ids = images.serverId.join(',')
                            doSave(media_ids);
                        }
                    },
                    fail: function (res) {
                        alert(JSON.stringify(res));
                    }
                });
            }
            upload();
        }
    };

    function doSave(media_ids) {
        // 校验参数
        var salary = $("#salary").val();
        var freetime_begin = $("#freetime_begin").val();
        var freetime_end = $("#freetime_end").val();
        var hire_range_more = $("#hire_range_more").val();
        var hire_class = $("#hire_class").val();

        var hire_range_all = [];
        $("#hire_range_all input:checked").each(function(d,s) {
            hire_range_all.push($(this).val());
        })
        hire_range_all = hire_range_all.join('，')+hire_range_more;

        if(salary < 1 || salary > 100) {
            alert("请填写1-100时薪");    
            return;
        }
        if(!freetime_begin || !freetime_end) {
            alert("请填写档期时间");
            return;
        }

        if(!hire_class) {
            alert("请选择主要出租项目");
            return;
        }

        if(!hire_range_all) { 
            alert("请填写出租范围");
            return;
        }

        if(images.localId.length == 0) {
            alert("请上传图片");
            return;
        }

        $("#save_btn").html("请稍等发布中...");
        $.ajax({
            type:'post',
            url:"<?php  echo $this->createMobileUrl('confirmhireout')?>",
            data:{
                media_ids:media_ids,
                salary:salary,
                freetime_begin:freetime_begin,
                freetime_end:freetime_end,
                hire_class:hire_class,
                hire_range_more:hire_range_more,
                hire_range_all:hire_range_all
            },
            success:function(d,s) {
                if(d.res == '100') {
                    $("#save_btn").html("发布成功");
                    window.location.href="<?php  echo $this->createMobileUrl('userrecordslist')?>";    
                }else {
                    $("#save_btn").attr('disabled','');
                    $("#save_btn").html("发布");
                    alert(d.msg);
                }
                
            }
        });
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>