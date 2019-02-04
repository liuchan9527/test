<?
error_reporting(0); 
ini_set('date.timezone','Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
//支付网关
$url="http://www.gzqpay.com/API/Bank/";
$partnery="780744";//用户ID
$key="EIk5sFPn0QObWCKAtD9KoSjw5W2koIIb";//用户密钥
$returnurl="http://".$_SERVER['SERVER_NAME']."/pay/gzqpay/returnurl.php";//同步回调地址
$notifyurl="http://".$_SERVER['SERVER_NAME']."/pay/gzqpay/notifyurl.php";//异步回调地址

// 打印log
function log_result($file,$word) 
{
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,$word);
	flock($fp, LOCK_UN);
	fclose($fp);
}
?>
