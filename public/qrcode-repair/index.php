<?php

$serviceid = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$serviceid = base64_decode($serviceid);
echo "รหัสแจ้งซ่อม : ".$serviceid;
?>