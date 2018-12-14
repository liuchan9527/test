<?php
include('init.php');
$orderId = $_GET['order_id']+0;
if(!$orderId){
    header('Location:list.php');
}
//
$video = Video::getVideoById($id);
if(!$video){
    header('Location:list.php');
}