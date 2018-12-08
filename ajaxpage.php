<?php
include('init.php');
$page = $_GET['page'];
echo json_encode(Video::getVideoPage($page,8,true));