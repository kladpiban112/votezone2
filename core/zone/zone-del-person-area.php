<?php
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/PasswordHash.php";
require_once ABSPATH."/resize-class.php";
require_once ABSPATH."/BarcodeQR.php";


$oid = filter_input(INPUT_POST, 'oid', FILTER_SANITIZE_STRING);
$aid = filter_input(INPUT_POST, 'aid', FILTER_SANITIZE_STRING);


$query = "DELETE FROM ".DB_PREFIX."mapping_person WHERE oid_map = '$oid' AND aid = '$aid' LIMIT 1"; 
$stmt = $conn->prepare($query);
$stmt->execute();

    $msg = "success";
    echo json_encode(['code'=>200, 'msg'=>$msg]);
// echo json_encode($query);
			
?>