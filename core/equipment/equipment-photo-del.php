<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

//echo $id;

$stmt2 = $conn->prepare("UPDATE equipment_files SET file_status = '0' WHERE file_id = ?  LIMIT 1");
$chk = $stmt2->execute([$id]);

if ($chk) {
    $msg = 'success';
    echo json_encode([
    'code' => 200,
    'msg' => $msg,
  ]);
} else {
    $msg = 'unsuccess';
    echo json_encode(['code' => 404, 'msg' => $msg]);
}
			
			
			
			?>


