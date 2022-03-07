<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";


$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$eq_typeid = filter_input(INPUT_POST, 'eq_typeid', FILTER_SANITIZE_STRING);
$eq_typename = filter_input(INPUT_POST, 'eq_typename', FILTER_SANITIZE_STRING);
$flag = filter_input(INPUT_POST, 'flag', FILTER_SANITIZE_STRING);
$now = date("Y-m-d H:i:s");

if($act == 'add'){



$query = "INSERT INTO ".DB_PREFIX."equipment_type (eq_typeid, eq_typename, flag,add_date,add_users) VALUES (NULL, ?, ?, ?, ?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $eq_typename, PDO::PARAM_STR);
$stmt->bindParam(2, $flag, PDO::PARAM_STR);
$stmt->bindParam(3, $now, PDO::PARAM_STR);
$stmt->bindParam(4, $logged_user_id, PDO::PARAM_STR);
$stmt->execute();
$user_id = $conn->lastInsertId(); // last inserted ID

$msg = "success";
echo json_encode(['code'=>200, 'msg'=>$msg]);
	
}else if($act == 'edit'){



	$query = "UPDATE  ".DB_PREFIX."equipment_type SET  eq_typename = ?, flag = ?,edit_date = ? ,edit_users = ? WHERE eq_typeid = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $eq_typename, PDO::PARAM_STR);
	$stmt->bindParam(2, $flag, PDO::PARAM_STR);
	$stmt->bindParam(3, $now, PDO::PARAM_INT);
	$stmt->bindParam(4, $logged_user_id, PDO::PARAM_STR);
	$stmt->bindParam(5, $eq_typeid, PDO::PARAM_STR);

	$stmt->execute();




	$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg]);



}
			
			
			
			?>


