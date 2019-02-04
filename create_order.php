<?php
$appid = '20190120222807';
$token = '2AE2ED23B8604FB91B10FF7E50763DF4';
$total_fee = '0.01';
$order_id = time();
$trade_type = $_GET['type'];
$notify_url = 'http://'.$_SERVER['HTTP_HOST'].'/notify_back.php';
$return_url = 'http://'.$_SERVER['HTTP_HOST'].'/return_back.php';
$body = 'TestPay';
$is_auto_account = '1';
$attach = 'test';
$nonce_str = mt_rand(10000,99999);
$sign = md5("appid=".$appid ."&attach=".$attach ."&body=". $body. "&is_auto_account=". $is_auto_account."&nonce_str=". $nonce_str."&notify_url=". $notify_url ."&order_id=". $order_id ."&return_url=". $return_url ."&trade_type=" .$trade_type ."&token=" .$token ."&total_fee=" . $total_fee);
$sign = strtoupper($sign);
?>
<form action='http://pay.1f742.cn/pay/quickpay' method='get'>
<input name='appid' value='<?php echo $appid;?>'/>
<input name='total_fee' value='<?php echo $total_fee;?>'/>
<input name='order_id' value='<?php echo $order_id;?>'/>
<input name='trade_type' value='<?php echo $trade_type;?>'/>
<input name='notify_url' value='<?php echo $notify_url;?>'/>
<input name='return_url' value='<?php echo $return_url;?>'/>
<input name='body' value='<?php echo $body;?>'/>
<input name='attach' value='<?php echo $attach;?>'/>
<input name='is_auto_account' value='<?php echo $is_auto_account;?>'/>
<input name='nonce_str' value='<?php echo $nonce_str;?>'/>
<input name='sign' value='<?php echo $sign;?>'/>
<input type='submit' />
</form>

