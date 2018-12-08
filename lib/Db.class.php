<?php 
class Db
{
	protected $data = null;
	protected static $ins = null;
	protected $res = null;
	final protected function __construct(){
		$this -> connect(Config::$dbhost,Config::$dbuser,Config::$dbpwd);
	}
	protected function connect($h,$u,$p){
		try{
			$dsn = 'mysql:dbname='.Config::$dbname.';charset=utf8;host='.$h;
			$this -> res = new PDO($dsn,$u,$p);
		}catch(Exception $e){
			echo $e->getMessage();
			echo 'DB error';
			exit;
		}
	}
	public static function getIns(){
		if(self::$ins instanceof self){
			return self::$ins->res;
		}else{
			self::$ins = new self;
			return self::$ins->res;
		}
	}
	public static function query($sql){
		$sth = self::getIns() -> prepare($sql);
		$sth -> execute();
		return $sth -> fetchAll(PDO::FETCH_ASSOC);
	}
    public static function getOne($sql,$params = ''){
        $sth = self::getIns() -> prepare($sql);
        if(!empty($params)){
			$sth -> execute($params);
		}else{
			$sth -> execute();
		}

        /*print_r($sth -> debugDumpParams());
        print_r($sth -> errorInfo());*/
        return $sth -> fetch(PDO::FETCH_ASSOC);
    }
}