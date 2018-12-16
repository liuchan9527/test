<?php 
require_once 'config/config.php';
require_once 'lib/Db.class.php';
require_once 'lib/Video.class.php';
require_once 'lib/RedisTool.php';
define('ROOT', str_replace('\\', '/', dirname(__FILE__)).'/');
date_default_timezone_set('PRC');
session_start();
if(!Config::$debug){
	error_reporting(0);
	ini_set('display_errors',false);
}else{
	error_reporting(E_ALL);
	ini_set('display_errors',true);
}

header('Content-type:text/html;charset:utf-8');



function errorHandler($errno,$errstr,$errfile,$errline)
{
    echo 'asdsad';
	$str = '<script>';
	$str .= 'console.log(\''.$errno.'\n'.$errstr.'\n'.addslashes($errfile).':'.$errline.'\')';
	$str .= '</script>';
	echo $str;
}
