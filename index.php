<?php
//检查来源
$refer = $_SERVER['HTTP_REFERER'];
$allow = array(
    'a8waw.xyz'
);
$referCan = false;
foreach ($allow as $a)
{
    if(($aa = strpos($refer,$a)) !== false)
    {
        $referCan = true;
        break;
    }
}
//检查header头
$header = $_SERVER['HTTP_USER_AGENT'];
$allowHeaderss = array(
    'MicroMessenger'
);
echo $header;
$headerCan = false;
foreach($allowHeaderss as $h)
{
    if(strpos($h,$header) !== false){
        $headerCan = true;
        break;
    }
}
if(!$referCan){
    echo 'source failed';
    exit;
}
if(!$headerCan){
    echo 'You must from wechat!';
    exit;
}
header("location:list.php");
