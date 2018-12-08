<?php 
require_once 'config/config.php';
require_once 'lib/Db.class.php';
require_once 'lib/Video.class.php';
define('ROOT', str_replace('\\', '/', dirname(__FILE__)).'/');
date_default_timezone_set('PRC');

if(!Config::getIns()->debug){
	error_reporting(0);
}else{
	set_error_handler('errorHandler',E_ALL);
	error_reporting(E_ALL);
}



function errorHandler($errno,$errstr,$errfile,$errline)
{
    echo 'asdsad';
	$str = '<script>';
	$str .= 'console.log(\''.$errno.'\n'.$errstr.'\n'.addslashes($errfile).':'.$errline.'\')';
	$str .= '</script>';
	echo $str;
}