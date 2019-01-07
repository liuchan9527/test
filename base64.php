<?php
ob_start();
include 'play.php';
$contents = ob_get_contents();
ob_end_clean();
echo base64_encode($contents);

