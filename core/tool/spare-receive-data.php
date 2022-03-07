<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/resize-class.php";


$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$receive_id = filter_input(INPUT_POST, 'receive_id', FILTER_SANITIZE_STRING);

$spare_id = filter_input(INPUT_POST, 'spare_id', FILTER_SANITIZE_STRING);
$spare_quantity = filter_input(INPUT_POST, 'spare_quantity', FILTER_SANITIZE_STRING);
$spare_unit = filter_input(INPUT_POST, 'spare_unit', FILTER_SANITIZE_STRING);
$spare_price = filter_input(INPUT_POST, 'spare_price', FILTER_SANITIZE_STRING);
$flag = 1;
$now = date("Y-m-d H:i:s");



$query = "INSERT INTO ".DB_PREFIX."spare_receive_data (oid,receive_id,spare_id,spare_quantity,spare_unit, flag,add_date,add_users,spare_price) VALUES (NULL, ?,?,?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $receive_id, PDO::PARAM_STR);
$stmt->bindParam(2, $spare_id, PDO::PARAM_STR);
$stmt->bindParam(3, $spare_quantity, PDO::PARAM_STR);
$stmt->bindParam(4, $spare_unit, PDO::PARAM_STR);
$stmt->bindParam(5, $flag, PDO::PARAM_STR);
$stmt->bindParam(6, $now, PDO::PARAM_STR);
$stmt->bindParam(7, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(8, $spare_price, PDO::PARAM_STR);
$stmt->execute();
$receive_id = $conn->lastInsertId(); // last inserted ID

$act = "add";
addSpareReceive($act, $spare_id,$spare_quantity,$spare_unit);

$receiveid_enc = base64_encode($receive_id);
$msg = "success";
$act_enc = base64_encode('edit');
echo json_encode(['code'=>200, 'msg'=>$msg]);
	

			
			
			
			?>


