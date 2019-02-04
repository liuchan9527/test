<?
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/13
 * Time: 16:50
 */
include '../../init.php';
$order['vid'] = $_REQUEST['vid'];
$time = explode(' ', microtime());
$order['order_id'] = 'PT'. date('YmdHis') . str_pad(ceil($time[0]*1000), 4, "0", STR_PAD_LEFT);
//插入订单
$db = Db::getIns();
$channel = isset($_REQUEST['channel']) ? $_REQUEST['channel'] : 'wx';
$sql = 'insert into video_order(vid,order_id,client_ip,create_time,status,channel) values(?,?,?,?,?,?)';
$stmt = $db -> prepare($sql);
$stmt -> execute(array(
        $order['vid'],
        $order['order_id'],
        $_SERVER['REMOTE_ADDR'],
        time(),
        0,
	$channel
));

$video = Video::getVideoById($order['vid']);
include_once("config.php");
//判断来源调用支付
$channelId = '7772';
if($channel == 'wx'){
	$channelId = '7772';
}
if($channel == 'zfb'){
	$channelId = '999';
}
if($channel == 'qq'){
	$channelId = '555';
}
$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
if($channel == 'wx' && strpos($agent,'micromessenger') !== false){
//微信
$channelId = '7771';
}

$d['LinkID']=$order['order_id'];
$d['ForUserId']=$partnery;
$d['Channelid']=$channelId;//其他通道请查看文档
$d['Moneys']=$video['video_price'];
$d['AssistStr']=session_id();
$d['ReturnUrl']=$returnurl;
$d['NotifyUrl']=$notifyurl;
$dqm="LinkID=".$d['LinkID']."&ForUserId=".$d['ForUserId']."&Channelid=".$d['Channelid']."&Moneys=".$d['Moneys']."&AssistStr=".$d['AssistStr']."&ReturnUrl=".$d['ReturnUrl']."&Key=".$key;
//iconv("GBK","UTF-8",$dqm);
$d['Sign']=md5($dqm);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>在线充值</title>
<meta name="keywords" content="{$Think.config.site.keyword}">
<meta name="description" content="{$Think.config.site.description}">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<link rel="icon" href="favicon.png" type="image/x-icon">
<link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>
<body>
<form action="<?=$url?>" method="post" name="orderForm">
    <input type='hidden' name='LinkID' value='<?=$d["LinkID"]?>'>
    <input type='hidden' name='ForUserId' value='<?=$d["ForUserId"]?>'>
    <input type='hidden' name='Channelid' value='<?=$d["Channelid"]?>'>
    <input type='hidden' name='Moneys' value='<?=$d["Moneys"]?>'>
    <input type='hidden' name='AssistStr' value='<?=$d["AssistStr"]?>'>
    <input type='hidden' name='ReturnUrl' value='<?=$d["ReturnUrl"]?>'>
    <input type='hidden' name='NotifyUrl' value='<?=$d["NotifyUrl"]?>'>
    <input type='hidden' name='Sign' value='<?=$d["Sign"]?>'>
</form>

<script type="text/javascript">

  document.orderForm.submit();

</script>
</body>
</html>
