<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/13
 * Time: 16:50
 */
include 'init.php';
$order['vid'] = $_REQUEST['vid'];
$time = explode(' ', microtime());
$order['order_id'] = 'PT'. date('YmdHis') . str_pad(ceil($time[0]*1000), 4, "0", STR_PAD_LEFT);
$channel = isset($_REQUEST['channel']) ? $_REQUEST['channel'] : 'wx';

//插入订单
$db = Db::getIns();
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
//常见订单号

header('Location:/pay/gzqpay/pay.php?vid='.$order['vid'].'&ssid='.session_id().'&order_id='. $order['order_id']);
