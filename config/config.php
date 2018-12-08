<?php 
define('DIR', str_replace('\\', '/', dirname(__FILE__)).'/');

class Config
{
	public static $host = 'http://cl6688.phpbool.com/';
	
	public static $dbuser = 'root';
	public static $dbpwd = 'root';
	public static $dbname = 'video_store';
	public static $dbhost = '127.0.0.1';
	
	public static $debug = true;
	
	public static $payment = 'Agpay';//Agpay
	public static $weixinpay = false;
	public static $alipay = true;
	
	private static $ins = null;
	public static function getIns()
	{
		if(self::$ins == null)
		{
			self::$ins = new self();
		}
		return self::$ins;
	}
	
	public function __get($name)
	{
		$db = Db::getIns();
		$sth = $db -> prepare('select * from config where name=?');
		$sth -> execute(array($name));
		$c = $sth -> fetch(PDO::FETCH_OBJ);
		if($c)
		{
			return $c->value;
		}else{
			return '';
		}
	}
}
