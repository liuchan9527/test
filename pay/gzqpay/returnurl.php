<?
include_once("./config.php");
$sErrorCode=$_GET['sErrorCode'];
$bType=$_GET['bType'];
$ForUserId=$_GET['ForUserId'];
$LinkID=$_GET['LinkID'];
$Moneys=$_GET['Moneys'];
$AssistStr=$_GET['AssistStr'];
$sign=$_GET['sign'];

$dqm="sErrorCode=".$sErrorCode."&bType=".$bType."&ForUserId=".$ForUserId."&LinkID=".$LinkID."&Moneys=".$Moneys."&AssistStr=".$AssistStr."&keyValue=".$key;
$dqm=strtolower($dqm);
$mysign=md5($dqm);
if($sign==$mysign){
	if($sErrorCode=="1"){
	
include '../../init.php';
$redis = RedisTool::getInstance();

$orderId = $LinkID;
//签名验证
$order = Db::getOne('select * from video_order where order_id = ?',array($orderId));
if(empty($order)){
 echo 'Invalid order';exit;
}


$vid = $order['vid'];
$ssid = $AssistStr;
$key = 'Play:'.$ssid.':'.$vid;
if($redis -> exists($key)){
        $order = json_decode($redis -> get($key),true);
        if($order['status'] == 1){
               header('Location:/box.html?vid='.$vid);
//print_r($order);
                return;
        }
}
$db = Db::getIns();
$sth = $db -> prepare('update video_order set status=1 where order_id=?');
if($sth -> execute(array($orderId))){
        $json['vid'] = $vid;
        $json['status'] = 1;
        $redis -> setex($key,60*60*2,json_encode($json,JSON_UNESCAPED_UNICODE));
        header('Location:/box.html?vid='.$vid);
//print_r($order);
//echo 'a';
}else{
        echo 'pay failed';
}
	
	}

}
?>
