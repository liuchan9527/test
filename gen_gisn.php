<?php
$params = array(
        'appid' => '20190120222807',
        'total_fee' => '0.01',
        'order_id' => time(),
        'trade_type' => 128,
        'notify_url' => 'http://'.$_SERVER['HTTP_HOST'].'/notify_back.php',
        'return_url' => 'http://'.$_SERVER['HTTP_HOST'].'/return_back.php',
        'body' => 'TestPay',
        'attach' => 'test',
        'is_auto_account' => '1',
        'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',
);
$tmp = $params;
$tmp['token'] = '2AE2ED23B8604FB91B10FF7E50763DF4';
ksort($tmp);
$str = '';
foreach($tmp as $k => $v)
{
        if(empty($str)){
                $str .= $k.'='.$v;
        }else{
                $str .= '&'.$k.'='.$v;
        }
}
$sign = strtoupper(md5($str));
$params['sign'] = $sign;
print_r($params);
echo http_build_query($params);

?>
<form action='http://pay.1f742.cn/pay/quickpay' method='post'>
<input name='appid' value='<?php echo $params['appid'];?>'/>
<input name='total_fee' value='<?php echo $params['total_fee'];?>'/>
<input name='order_id' value='<?php echo $params['order_id'];?>'/>
<input name='trade_type' value='<?php echo $params['trade_type'];?>'/>
<input name='notify_url' value='<?php echo $params['notify_url'];?>'/>
<input name='return_url' value='<?php echo $params['return_url'];?>'/>
<input name='body' value='<?php echo $params['body'];?>'/>
<input name='attach' value='<?php echo $params['attach'];?>'/>
<input name='is_auto_account' value='<?php echo $params['is_auto_account'];?>'/>
<input name='nonce_str' value='<?php echo $params['nonce_str'];?>'/>
<input name='sign' value='<?php echo $params['sign'];?>'/>
<input type='submit' />
</form>

