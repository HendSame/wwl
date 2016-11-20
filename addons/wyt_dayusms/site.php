<?php
defined('IN_IA') or exit('Access Denied');
class Wyt_dayusmsModuleSite extends WeModuleSite
{
    public function doMobileIndex()
    {
        global $_GPC, $_W;
        $result = sms_dayu_smsnumsend('18653220030', '1234', '大资源', 0);
        print_r($result);
    }
    public function doMobileflowgrade()
    {
        $result = sms_dayu_flowgrade();
        print_r($result);
    }
    public function doWebAccountlist()
    {
        global $_GPC, $_W;
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 10;
        $total  = pdo_fetchcolumn("SELECT COUNT(*)  FROM " . tablename('uni_account') . " a , " . tablename('account') . " b  WHERE a.uniacid =b.uniacid AND a.default_acid <> 0 AND b.isdeleted <> 1");
        $list   = pdo_fetchall("SELECT * FROM " . tablename('uni_account') . " a , " . tablename('account') . " b  WHERE a.uniacid =b.acid AND a.default_acid <> 0 AND b.isdeleted <> 1  LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
        $pager  = pagination($total, $pindex, $psize);
        $num    = 0;
        foreach ($list as $item) {
            $row                     = pdo_get('uni_settings', array(
                'uniacid' => $item['uniacid']
            ), array(
                'notify'
            ));
            $row['notify']           = @iunserializer($row['notify']);
            $config                  = $row['notify']['sms'];
            $balance                 = intval($config['balance']);
            $signature               = $config['signature'];
            $list[$num]['balance']   = $balance;
            $list[$num]['signature'] = $signature;
            $num++;
        }
        if (checksubmit('submit')) {
            foreach ($_GPC['balance'] as $key => $val) {
                $notify                   = array();
                $notify['sms']['balance'] = intval($val);
                $notify                   = iserializer($notify);
                $updatedata['notify']     = $notify;
                $result                   = pdo_update('uni_settings', $updatedata, array(
                    'uniacid' => intval($key)
                ));
                cache_delete("unisetting:{$_W['uniacid']}");
            }
            message('修改短信余额成功！', $this->createWebUrl('accountlist'), 'success');
        }
        include $this->template('accountlist');
    }
    public function doWebSet()
    {
        global $_GPC, $_W;
        $op = $_GPC['op'] ? $_GPC['op'] : 'setlist';
        if ($op == 'setlist') {
            $pindex = max(1, intval($_GPC['page']));
            $psize  = 50;
            $total  = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('wyt_dayusms_base') . " WHERE `weid` = :weid", array(
                ':weid' => $_W['uniacid']
            ));
            $list   = pdo_fetchall("SELECT * FROM " . tablename('wyt_dayusms_base') . " WHERE `weid` = :weid  ORDER BY `id` DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(
                ':weid' => $_W['uniacid']
            ));
            $pager  = pagination($total, $pindex, $psize);
            include $this->template('smslist');
        }
        if ($op == 'setdel') {
            $id = intval($_GPC['id']);
            pdo_delete("wyt_dayusms_base", array(
                "weid" => $_W['uniacid'],
                'id' => $id
            ));
            message('删除数据成功！', $this->createWebUrl('set', array(
                'op' => 'setlist'
            )), 'success');
        }
        if ($op == 'setpost') {
            $id = intval($_GPC['id']);
            if ($id > 0) {
                $settings = pdo_fetch('SELECT * FROM ' . tablename('wyt_dayusms_base') . " WHERE  weid = :weid  AND id = :id", array(
                    ':weid' => $_W['uniacid'],
                    ':id' => $id
                ));
            } else {
                $settings = array(
                    'status' => 1,
                    'style' => 1
                );
            }
            if (checksubmit('submit')) {
                $appkey        = !empty($_GPC['appkey']) ? trim($_GPC['appkey']) : message('请填写appkey');
                $secretKey     = !empty($_GPC['secretKey']) ? trim($_GPC['secretKey']) : message('请填写secretKey');
                $freesignname  = !empty($_GPC['freesignname']) ? trim($_GPC['freesignname']) : message('请填写短信签名');
                $templatecode  = !empty($_GPC['templatecode']) ? trim($_GPC['templatecode']) : message('请填写模板编号');
                $x_code        = !empty($_GPC['x_code']) ? trim($_GPC['x_code']) : message('请填写验证码变量名（变量一）');
                $x_product     = !empty($_GPC['x_product']) ? trim($_GPC['x_product']) : message('请填写产品名称变量名（变量二）');
                $safetycode    = !empty($_GPC['safetycode']) ? trim($_GPC['safetycode']) : message('请填写安全码');
                $calledshownum = $_GPC['calledshownum'];
                $ttscode       = $_GPC['ttscode'];
                $style         = intval($_GPC['style']);
                $status        = intval($_GPC['status']);
                $data          = array(
                    'weid' => $_W['uniacid'],
                    'appkey' => $appkey,
                    'secretKey' => $secretKey,
                    'x_product' => $x_product,
                    'x_code' => $x_code,
                    'freesignname' => $freesignname,
                    'templatecode' => $templatecode,
                    'safetycode' => $safetycode,
                    'style' => $style,
                    'calledshownum' => $calledshownum,
                    'ttscode' => $ttscode,
                    'status' => $status,
                    'createtime' => TIMESTAMP
                );
                if (empty($id)) {
                    pdo_insert('wyt_dayusms_base', $data);
                    !pdo_insertid() ? message('保存短信通道数据失败, 请稍后重试.', 'error') : '';
                } else {
                    if (pdo_update('wyt_dayusms_base', $data, array(
                        'id' => $id
                    )) === false) {
                        message('更新短信通道数据失败, 请稍后重试.', 'error');
                    }
                }
                message('更新短信通道数据成功！', $this->createWebUrl('Set', array(
                    'op' => 'setlist'
                )), 'success');
            }
            include $this->template('smsadd');
        }
        if ($op == 'setting') {
            $check = $_W['isfounder'];
            if ($check != 1) {
                message('你不是站长，您没有权限操作！');
                exit();
            }
            $settings = pdo_fetch('SELECT * FROM ' . tablename('wyt_dayusms_setting'));
            if (checksubmit('submit')) {
                $appkey        = !empty($_GPC['appkey']) ? trim($_GPC['appkey']) : message('请填写appkey');
                $secretKey     = !empty($_GPC['secretKey']) ? trim($_GPC['secretKey']) : message('请填写secretKey');
                $freesignname  = !empty($_GPC['freesignname']) ? trim($_GPC['freesignname']) : message('请填写短信签名');
                $templatecode  = !empty($_GPC['templatecode']) ? trim($_GPC['templatecode']) : message('请填写模板编号');
                $x_code        = !empty($_GPC['x_code']) ? trim($_GPC['x_code']) : message('请填写验证码变量名（变量一）');
                $x_product     = !empty($_GPC['x_product']) ? trim($_GPC['x_product']) : message('请填写产品名称变量名（变量二）');
                $calledshownum = $_GPC['calledshownum'];
                $ttscode       = $_GPC['ttscode'];
                $style         = intval($_GPC['style']);
                if ($_GPC['file'] == 1) {
                    load()->func('file');
                    file_copy(IA_ROOT . '/addons/wyt_dayusms/inc/function', IA_ROOT . '/framework/function', array(
                        'txt'
                    ));
                    $content  = file_get_contents('source/utility/verifycode.ctrl.php');
                    $str_file = "load()->func('sms');
			\$result = sms_dayusend(\$receiver,\$code,\$uniacid_arr['name'],0);";
                    $content  = str_replace('$result = cloud_sms_send($receiver, $content);', $str_file, $content);
                    file_put_contents('source/utility/verifycode.ctrl.php', $content);
                }
                $data = array(
                    'appkey' => $appkey,
                    'secretKey' => $secretKey,
                    'x_product' => $x_product,
                    'x_code' => $x_code,
                    'freesignname' => $freesignname,
                    'templatecode' => $templatecode,
                    'style' => $style,
                    'calledshownum' => $calledshownum,
                    'ttscode' => $ttscode
                );
                if (!empty($settings)) {
                    $temp = pdo_update('wyt_dayusms_setting', $data, array(
                        'id' => $settings['id']
                    ));
                } else {
                    $temp = pdo_insert('wyt_dayusms_setting', $data);
                }
                if ($temp === false) {
                    message('更新短信参数失败！', '', 'error');
                } else {
                    message('更新短信参数成功！', '', 'success');
                }
            }
            include $this->template('setting');
        }
        if ($op == 'log') {
            $pindex = max(1, intval($_GPC['page']));
            $psize  = 10;
            $total  = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('wyt_dayusms_log') . " WHERE `weid` = :weid", array(
                ':weid' => $_W['uniacid']
            ));
            $list   = pdo_fetchall("SELECT * FROM " . tablename('wyt_dayusms_log') . " WHERE `weid` = :weid  ORDER BY `createtime` DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(
                ':weid' => $_W['uniacid']
            ));
            $pager  = pagination($total, $pindex, $psize);
            include $this->template('loglist');
        }
        if ($op == 'logdel') {
            $id = intval($_GPC['id']);
            pdo_delete("wyt_dayusms_log", array(
                "weid" => $_W['uniacid'],
                'id' => $id
            ));
            message('删除数据成功！', $this->createWebUrl('set', array(
                'op' => 'log'
            )), 'success');
        }
    }
}
