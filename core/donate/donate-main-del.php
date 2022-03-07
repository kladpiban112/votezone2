<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$now = date("Y-m-d H:i:s");
$flag = "0"; // ลบข้อมูล

$stmt2 = $conn->prepare("UPDATE donate_main SET flag = '0' , edit_date = NOW() WHERE service_id = ?  LIMIT 1");
$chk = $stmt2->execute([$id]);


$query = "UPDATE ".DB_PREFIX."donate_data SET flag = ? , edit_date = ? , edit_users = ? WHERE service_id = ? LIMIT 1 "; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $flag, PDO::PARAM_STR);
$stmt->bindParam(2, $now, PDO::PARAM_STR);
$stmt->bindParam(3, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(4, $id, PDO::PARAM_STR);
$stmt->execute();


$stmt = $conn->prepare("SELECT eq_id FROM ".DB_PREFIX."donate_data WHERE service_id = '$id'  ");
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
$eqid = $row['eq_id'];


$query = "UPDATE ".DB_PREFIX."equipment_main SET flag = ? WHERE oid = ? LIMIT 1"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $flag, PDO::PARAM_STR);
$stmt->bindParam(2, $eqid, PDO::PARAM_STR);
$stmt->execute();

}



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


