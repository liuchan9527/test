<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/13
 * Time: 17:37
 */
include 'init.php';
$redis = RedisTool::getInstance();
$vid = $_REQUEST['vid'];
$ssid = $_REQUEST['ssid'];
$key = 'Play:'.$ssid.':'.$vid;
if($redis -> exists($key)){
	$order = json_decode($redis -> get($key),true);
	if($order['status'] == 1){
		header('Location:box.html?vid='.$order['vid']);
		return;
	}
}
$orderId = $_REQUEST['order_id'];
//签名验证
$order = Db::getOne('select * from video_order where order_id = ?',array($orderId));
if(empty($order)){
 echo 'Invalid order';exit;
}
$db = Db::getIns();
$sth = $db -> prepare('update video_order set status=1 where order_id=?');
if($sth -> execute(array($orderId))){
	$json['vid'] = $vid;
	$json['status'] = 1;
	$redis -> setex($key,60*60*2,json_encode($json,JSON_UNESCAPED_UNICODE));
	header('Location:box.html?vid='.$vid);
}else{
	echo 'pay failed';
}

