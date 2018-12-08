<?php
class RedisTool{

	private static $_instance;		// 保存类实例的静态成员变量

	// private 标记的构造方法
	private function __construct(){}

	//创建__clone方法防止对象被复制克隆
	public function __clone(){
		die('Validator Clone is not allow!');
	}

	//单例方法,用于访问实例的公共的静态方法
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new \Redis();
			self::$_instance->pconnect('127.0.0.1', '6379',5) or die('Redis connect failed');
		}
		return self::$_instance;
	}
}