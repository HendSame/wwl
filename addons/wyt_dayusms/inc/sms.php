<?php
defined('IN_IA') or exit('Access Denied');
include "TopSdk.php";
function sms_dayu_smsnumsend($mobile, $code, $product, $sub)
{
    load()->model('module');
    load()->func('file');
    global $_W;
    $log           = array(
        'mobile' => $mobile,
        'code' => $code,
        'product' => $product,
        'result' => '',
        'templatecode' => '',
        'freesignname' => '',
        'weid' => $_W['uniacid'],
        'calledshownum' => '',
        'ttscode' => '',
        'createtime' => TIMESTAMP
    );
    $row           = pdo_get('uni_settings', array(
        'uniacid' => $_W['uniacid']
    ), array(
        'notify'
    ));
    $row['notify'] = @iunserializer($row['notify']);
    if (!empty($row['notify']) && !empty($row['notify']['sms'])) {
        $config  = $row['notify']['sms'];
        $balance = intval($config['balance']);
        if ($balance <= 0) {
            $log['result'] = '亲啊，钱不够了，请联系管理员充值！';
            pdo_insert('wyt_dayusms_log', $log);
            return error(-1, $log['result']);
        }
        date_default_timezone_set('Asia/Shanghai');
        if ($sub == 0) {
            $settings = pdo_fetch('SELECT * FROM ' . tablename('wyt_dayusms_setting'));
        } else {
            $settings = pdo_fetch('SELECT * FROM ' . tablename('wyt_dayusms_base') . " WHERE 'id'= :id and `weid` = :weid ", array(
                ':id' => $sub,
                ':weid' => $_W['uniacid']
            ));
        }
        $x_code       = $settings['x_code'];
        $x_product    = $settings['x_product'];
        $style        = $settings['style'];
        $temp         = array(
            $x_code => $code,
            $x_product => $product
        );
        $c            = new TopClient;
        $c->appkey    = $settings['appkey'];
        $c->secretKey = $settings['secretKey'];
        $c->format    = 'json';
        if ($style == 2) {
            $req = new AlibabaAliqinFcTtsNumSinglecallRequest;
            $req->setExtend($extend);
            $req->setTtsParam(json_encode($temp));
            $req->setCalledNum($mobile);
            $req->setCalledShowNum($settings['calledshownum']);
            $req->setTtsCode($settings['ttscode']);
            $log['calledshownum'] = $settings['calledshownum'];
            $log['ttscode']       = $settings['ttscode'];
        } else {
            $req = new AlibabaAliqinFcSmsNumSendRequest;
            $req->setSmsType("normal");
            $req->setSmsFreeSignName($settings['freesignname']);
            $req->setSmsParam(json_encode($temp));
            $req->setRecNum($mobile);
            $req->setSmsTemplateCode($settings['templatecode']);
            $log['templatecode'] = $settings['templatecode'];
        }
        $log['freesignname'] = $settings['freesignname'];
        $resp                = $c->execute($req);
        $res                 = object2array($resp);
        if ($res['result']['success'] == '1') {
            $log['result'] = '发送成功!';
            if ($sub == 0) {
                $notify['sms']['balance']   = $balance - count(explode(",", $mobile));
                $notify['sms']['signature'] = $sign;
                $notify                     = iserializer($notify);
                $updatedata['notify']       = $notify;
                $result                     = pdo_update('uni_settings', $updatedata, array(
                    'uniacid' => $_W['uniacid']
                ));
                cache_delete("unisetting:{$_W['uniacid']}");
            }
            pdo_insert('wyt_dayusms_log', $log);
        } else {
            $log['result'] = sms_error_code($res['sub_code']);
            pdo_insert('wyt_dayusms_log', $log);
        }
        return $res;
    }
    pdo_insert('wyt_dayusms_log', $log);
    return error(-1, '亲啊，钱不够了，请联系管理员充值！');
}
function cloud_sms_dysend($mobile, $ccc)
{
    $code    = '1234';
    $product = '微接口';
    $sub     = 0;
    load()->model('module');
    load()->func('file');
    global $_W;
    $log           = array(
        'mobile' => $mobile,
        'code' => $code,
        'product' => $product,
        'result' => '',
        'templatecode' => '',
        'freesignname' => '',
        'weid' => $_W['uniacid'],
        'calledshownum' => '',
        'ttscode' => '',
        'createtime' => TIMESTAMP
    );
    $row           = pdo_get('uni_settings', array(
        'uniacid' => $_W['uniacid']
    ), array(
        'notify'
    ));
    $row['notify'] = @iunserializer($row['notify']);
    if (!empty($row['notify']) && !empty($row['notify']['sms'])) {
        $config  = $row['notify']['sms'];
        $balance = intval($config['balance']);
        if ($balance <= 0) {
            $log['result'] = '发送短信失败, 请联系系统管理人员. 错误详情: 短信余额不足';
            pdo_insert('wyt_dayusms_log', $log);
            return error(-1, $log['result']);
        }
        date_default_timezone_set('Asia/Shanghai');
        if ($sub == 0) {
            $settings = pdo_fetch('SELECT * FROM ' . tablename('wyt_dayusms_setting'));
        } else {
            $settings = pdo_fetch('SELECT * FROM ' . tablename('wyt_dayusms_base') . " WHERE 'id'= :id and `weid` = :weid ", array(
                ':id' => $sub,
                ':weid' => $_W['uniacid']
            ));
        }
        $x_code       = $settings['x_code'];
        $x_product    = $settings['x_product'];
        $style        = $settings['style'];
        $temp         = array(
            $x_code => $code,
            $x_product => $product
        );
        $c            = new TopClient;
        $c->appkey    = $settings['appkey'];
        $c->secretKey = $settings['secretKey'];
        $c->format    = 'json';
        if ($style == 2) {
            $req = new AlibabaAliqinFcTtsNumSinglecallRequest;
            $req->setExtend($extend);
            $req->setTtsParam(json_encode($temp));
            $req->setCalledNum($mobile);
            $req->setCalledShowNum($settings['calledshownum']);
            $req->setTtsCode($settings['ttscode']);
            $log['calledshownum'] = $settings['calledshownum'];
            $log['ttscode']       = $settings['ttscode'];
        } else {
            $req = new AlibabaAliqinFcSmsNumSendRequest;
            $req->setSmsType("normal");
            $req->setSmsFreeSignName($settings['freesignname']);
            $req->setSmsParam(json_encode($temp));
            $req->setRecNum($mobile);
            $req->setSmsTemplateCode($settings['templatecode']);
            $log['templatecode'] = $settings['templatecode'];
        }
        $log['freesignname'] = $settings['freesignname'];
        $resp                = $c->execute($req);
        $res                 = object2array($resp);
        if ($res['result']['success'] == '1') {
            $log['result'] = '发送成功!';
            if ($sub == 0) {
                $notify['sms']['balance']   = $balance - count(explode(",", $mobile));
                $notify['sms']['signature'] = $sign;
                $notify                     = iserializer($notify);
                $updatedata['notify']       = $notify;
                $result                     = pdo_update('uni_settings', $updatedata, array(
                    'uniacid' => $_W['uniacid']
                ));
                cache_delete("unisetting:{$_W['uniacid']}");
            }
            pdo_insert('wyt_dayusms_log', $log);
            return $res;
        } else {
            $log['result'] = $res['sub_msg'];
            pdo_insert('wyt_dayusms_log', $log);
            return $res;
        }
    }
    pdo_insert('wyt_dayusms_log', $log);
    return error(-1, '发送短信失败, 请联系系统管理人员. 错误详情: 没有设置短信配额或参数');
}
function sms_dayu_doublecall($callernum, $callershownum, $callednum, $calledshownum, $timeout, $extend)
{
    $settings     = pdo_fetch('SELECT * FROM ' . tablename('wyt_dayusms_setting'));
    $c            = new TopClient;
    $c->appkey    = $settings['appkey'];
    $c->secretKey = $settings['secretKey'];
    $c->format    = 'json';
    $req          = new AlibabaAliqinFcVoiceNumDoublecallRequest;
    $req->setSessionTimeOut($timeout);
    $req->setExtend($extend);
    $req->setCallerNum($callernum);
    $req->setCallerShowNum($callershownum);
    $req->setCalledNum($callednum);
    $req->setCalledShowNum($calledshownum);
    $resp = $c->execute($req);
    return $resp;
}
function sms_dayu_singlecall($callernum, $callershownum, $VoiceCode, $extend)
{
    $c            = new TopClient;
    $c->appkey    = $settings['appkey'];
    $c->secretKey = $settings['secretKey'];
    $c->format    = 'json';
    $req          = new AlibabaAliqinFcVoiceNumSinglecallRequest;
    $req->setExtend($extend);
    $req->setCallerNum($callernum);
    $req->setCallerShowNum($callershownum);
    $req->setVoiceCode($VoiceCode);
    $resp = $c->execute($req);
    return $resp;
}
function sms_dayu_smsquery($bizid, $recnum, $querydate, $currentpage, $pagesize)
{
    $c            = new TopClient;
    $c->appkey    = $settings['appkey'];
    $c->secretKey = $settings['secretKey'];
    $c->format    = 'json';
    $req          = new AlibabaAliqinFcSmsNumQueryRequest;
    $req->setBizId($bizid);
    $req->setRecNum($recnum);
    $req->setQueryDate($querydate);
    $req->setCurrentPage($currentpage);
    $req->setPageSize($pagesize);
    $resp = $c->execute($req);
    return $resp;
}
function sms_dayu_flowquery($outid)
{
    $c            = new TopClient;
    $c->appkey    = $settings['appkey'];
    $c->secretKey = $settings['secretKey'];
    $c->format    = 'json';
    $req          = new AlibabaAliqinFcFlowQueryRequest;
    $req->setOutId($outid);
    $resp = $c->execute($req);
    return $resp;
}
function sms_dayu_flowcharge($phonenum, $reason, $grade, $outchargeid)
{
    $c            = new TopClient;
    $c->appkey    = $settings['appkey'];
    $c->secretKey = $settings['secretKey'];
    $c->format    = 'json';
    $req          = new AlibabaAliqinFcFlowChargeRequest;
    $req->setPhoneNum($phonenum);
    $req->setReason($reason);
    $req->setGrade($grade);
    $req->setOutRechargeId($outchargeid);
    $resp = $c->execute($req);
    return $resp;
}
function sms_dayu_flowgrade()
{
    $settings     = pdo_fetch('SELECT * FROM ' . tablename('wyt_dayusms_setting'));
    $c            = new TopClient;
    $c->appkey    = $settings['appkey'];
    $c->secretKey = $settings['secretKey'];
    $c->format    = 'json';
    $req          = new AlibabaAliqinFcFlowGradeRequest;
    $resp         = $c->execute($req);
    return $resp;
}
function sms_dayu_flowchargeprovince($phonenum, $reason, $grade, $outchargeid)
{
    $c            = new TopClient;
    $c->appkey    = $settings['appkey'];
    $c->secretKey = $settings['secretKey'];
    $c->format    = 'json';
    $req          = new AlibabaAliqinFcFlowChargeProvinceRequest;
    $req->setPhoneNum($phonenum);
    $req->setReason($reason);
    $req->setGrade($grade);
    $req->setOutRechargeId($outrechargeid);
    $resp = $c->execute($req);
    return $resp;
}
function object2array($object)
{
    $object = json_decode(json_encode($object), true);
    return $object;
}
function sms_error_code($code)
{
    $msgs = array(
        'isv.OUT_OF_SERVICE' => array(
            'msg' => '业务停机',
            'handle' => '登陆www.alidayu.com充值'
        ),
        'isv.permission-ip-whitelist-limit' => array(
            'msg' => '请求IP不在应用的IP白名单列表中',
            'handle' => '把当前请求IP配置到应用的IP白名单中去'
        ),
        'isv.PRODUCT_UNSUBSCRIBE' => array(
            'msg' => '产品服务未开通',
            'handle' => '登陆www.alidayu.com开通相应的产品服务'
        ),
        'isv.ACCOUNT_NOT_EXISTS' => array(
            'msg' => '账户信息不存在',
            'handle' => '登陆www.alidayu.com完成入驻'
        ),
        'isv.ACCOUNT_ABNORMAL' => array(
            'msg' => '账户信息异常',
            'handle' => '联系技术支持'
        ),
        'isv.SMS_TEMPLATE_ILLEGAL' => array(
            'msg' => '模板不合法',
            'handle' => '登陆www.alidayu.com查询审核通过短信模板使用'
        ),
        'isv.SMS_SIGNATURE_ILLEGAL' => array(
            'msg' => '签名不合法',
            'handle' => '登陆www.alidayu.com查询审核通过的签名使用'
        ),
        'isv.MOBILE_NUMBER_ILLEGAL' => array(
            'msg' => '手机号码格式错误',
            'handle' => '使用合法的手机号码'
        ),
        'isv.MOBILE_COUNT_OVER_LIMIT' => array(
            'msg' => '手机号码数量超过限制',
            'handle' => '批量发送，手机号码以英文逗号分隔，不超过200个号码'
        ),
        'isv.TEMPLATE_MISSING_PARAMETERS' => array(
            'msg' => '短信模板变量缺少参数',
            'handle' => '确认短信模板中变量个数，变量名，检查传参是否遗漏'
        ),
        'isv.INVALID_PARAMETERS' => array(
            'msg' => '参数异常',
            'handle' => '检查参数是否合法'
        ),
        'isv.BUSINESS_LIMIT_CONTROL' => array(
            'msg' => '触发业务流控限制',
            'handle' => '短信验证码，使用同一个签名，对同一个手机号码发送短信验证码，允许每分钟1条，累计每小时7条。 短信通知，使用同一签名、同一模板，对同一手机号发送短信通知，允许每天50条（自然日）'
        ),
        'isv.INVALID_JSON_PARAM' => array(
            'msg' => '触发业务流控限制',
            'handle' => 'JSON参数不合法	JSON参数接受字符串值'
        ),
        'isv.DISPLAY_NUMBER_ILLEGAL' => array(
            'msg' => '号显不合法',
            'handle' => '使用合法的号显'
        )
    );
    return $msgs[$code][handle];
}
