<?
include_once("./config.php");
$sErrorCode=$_POST['sErrorCode'];
$bType=$_POST['bType'];
$ForUserId=$_POST['ForUserId'];
$LinkID=$_POST['LinkID'];
$Moneys=$_POST['Moneys'];
$AssistStr=$_POST['AssistStr'];
$sign=$_POST['sign'];

$dqm="sErrorCode=".$sErrorCode."&bType=".$bType."&ForUserId=".$ForUserId."&LinkID=".$LinkID."&Moneys=".$Moneys."&AssistStr=".$AssistStr."&keyValue=".$key;
$dqm=strtolower($dqm);
$mysign=md5($dqm);
if($sign==$mysign){
	if($sErrorCode=="1"){
		echo "success";
	}

}













$merchantCode = $_GET[AppConstants::$MERCHANT_CODE];
$notifyType = $_GET[AppConstants::$NOTIFY_TYPE];
$orderNo = $_GET[AppConstants::$ORDER_NO];
$orderAmount = $_GET[AppConstants::$ORDER_AMOUNT];
$orderTime = $_GET[AppConstants::$ORDER_TIME];
$returnParams = $_GET[AppConstants::$RETURN_PARAMS];
$tradeNo = $_GET[AppConstants::$TRADE_NO];
$tradeTime = $_GET[AppConstants::$TRADE_TIME];
$tradeStatus = $_GET[AppConstants::$TRADE_STATUS];
$sign = $_GET[AppConstants::$SIGN];

$kvs = new KeyValues();
$kvs->setkey($key_wx);
$kvs->add(AppConstants::$MERCHANT_CODE, $merchantCode);
$kvs->add(AppConstants::$NOTIFY_TYPE, $notifyType);
$kvs->add(AppConstants::$ORDER_NO, $orderNo);
$kvs->add(AppConstants::$ORDER_AMOUNT, $orderAmount);
$kvs->add(AppConstants::$ORDER_TIME, $orderTime);
$kvs->add(AppConstants::$RETURN_PARAMS, $returnParams);
$kvs->add(AppConstants::$TRADE_NO, $tradeNo);
$kvs->add(AppConstants::$TRADE_TIME, $tradeTime);
$kvs->add(AppConstants::$TRADE_STATUS, $tradeStatus);
$_sign = $kvs->sign();

if($_sign == $sign){
	if ($tradeStatus == "success"){
		$amount=$orderAmount;//金额
		$rechargeId=$orderNo;//订单号
		if($amount && $rechargeId){
			$dbpre=$conf['db']['prename'];
			$conn = mysql_connect($dbhost,$conf['db']['user'],$conf['db']['password']);
			if (!$conn)
			{
			die('Could not connect: ' . mysql_error());
			}
			mysql_select_db($dbname,$conn);
			mysql_query("SET NAMES UTF8");
			$chaxun = mysql_query("SELECT state,username FROM ".$conf['db']['prename']."order WHERE state='0' and order_number = '".$rechargeId."'");
			if(mysql_num_rows($chaxun) == 0){
				echo "success";
				exit;
			}
			$jiancha = mysql_result($chaxun,0,"state");
			$username = mysql_result($chaxun,0,"username");
			$chaxun2 = mysql_query("select actionIP from ".$dbpre."member_recharge where rechargeid= '".$rechargeId."'");
			$actionIP = mysql_result($chaxun2,0);
			$chaxun3 = mysql_query("select id from ".$dbpre."member_recharge where rechargeid= '".$rechargeId."'");
			$id = mysql_result($chaxun3,0);
			$chaxun4 = mysql_query("select uid from ".$dbpre."member_recharge where rechargeid= '".$rechargeId."'");
			$uid = mysql_result($chaxun4,0);
			$chaxun5 = mysql_query("select coin from ".$dbpre."members where uid= '".$uid."'");
			$coin = mysql_result($chaxun5,0);
			$chaxun6 = mysql_query("select username from ".$dbpre."members where uid= '".$uid."'");
			$username = mysql_result($chaxun6,0);
			if(!$id || !$uid){
			echo '操作错误';
			exit;	
			}
			$inserts = "insert into ".$dbpre."coin_log (uid,type,playedId,coin,userCoin,fcoin,liqType,actionUID,actionTime,actionIP,info,extfield0,extfield1) values ('".$uid."',0,0,'".$amount."','".$coin."'+'".$amount."',0,1,0,UNIX_TIMESTAMP(),'".$actionIP."','".$info."','".$id."','".$uid."')";
			$update1 = "UPDATE ".$dbpre."order SET state = 2 WHERE state='0' and order_number = '".$rechargeId."'";
			$update2 = "UPDATE ".$dbpre."members SET coin = coin+'".$amount."' WHERE username = '".$username."'";
			$update3 = "update ".$dbpre."member_recharge set state=2,rechargeTime=UNIX_TIMESTAMP(),rechargeAmount='".$amount."',coin='".$coin."', info='".$info."', rechType='onlinePayment' where rechargeid='".$rechargeId."'";
			if($jiancha==0){
				mysql_query($update1,$conn);
				if(mysql_affected_rows()==1){
					mysql_query($update2,$conn);
					mysql_query($update3,$conn);
					mysql_query($inserts,$conn);
					echo "success";
				}
			}else{
				echo "success";
			}
		}
	}
}
?>
