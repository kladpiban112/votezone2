<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";


$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$stores_id = filter_input(INPUT_POST, 'stores_id', FILTER_SANITIZE_STRING);
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);
$stores_name = filter_input(INPUT_POST, 'stores_name', FILTER_SANITIZE_STRING);
$stores_detail = filter_input(INPUT_POST, 'stores_detail');
$telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$changwat = filter_input(INPUT_POST, 'changwat', FILTER_SANITIZE_STRING);
$ampur = filter_input(INPUT_POST, 'ampur', FILTER_SANITIZE_STRING);
$tambon = filter_input(INPUT_POST, 'tambon', FILTER_SANITIZE_STRING);

$flag = filter_input(INPUT_POST, 'flag', FILTER_SANITIZE_STRING);
$now = date("Y-m-d H:i:s");

if($act == 'add'){



$query = "INSERT INTO ".DB_PREFIX."stores_main (stores_id,org_id,stores_name,stores_detail,telephone,email,address,tambon,ampur,changwat, flag,add_date,add_users) VALUES (NULL, ?, ?, ?, ?,?,?,?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $org_id, PDO::PARAM_STR);
$stmt->bindParam(2, $stores_name, PDO::PARAM_STR);
$stmt->bindParam(3, $stores_detail);
$stmt->bindParam(4, $telephone, PDO::PARAM_STR);
$stmt->bindParam(5, $email, PDO::PARAM_STR);
$stmt->bindParam(6, $address, PDO::PARAM_STR);
$stmt->bindParam(7, $tambon, PDO::PARAM_STR);
$stmt->bindParam(8, $ampur, PDO::PARAM_STR);
$stmt->bindParam(9, $changwat, PDO::PARAM_STR);
$stmt->bindParam(10, $flag, PDO::PARAM_STR);
$stmt->bindParam(11, $now, PDO::PARAM_STR);
$stmt->bindParam(12, $logged_user_id, PDO::PARAM_STR);
$stmt->execute();
$stores_id = $conn->lastInsertId(); // last inserted ID


$msg = "success";
echo json_encode(['code'=>200, 'msg'=>$msg]);
	
}else if($act == 'edit'){



	$query = "UPDATE  ".DB_PREFIX."stores_main SET  org_id = ?,stores_name = ?,stores_detail=?,telephone=?,email=?,address=?,tambon=?,ampur=?,changwat=?, flag = ?,edit_date = ? ,edit_users = ? WHERE stores_id = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $org_id, PDO::PARAM_STR);
	$stmt->bindParam(2, $stores_name, PDO::PARAM_STR);
	$stmt->bindParam(3, $stores_detail);
	$stmt->bindParam(4, $telephone, PDO::PARAM_STR);
	$stmt->bindParam(5, $email, PDO::PARAM_STR);
	$stmt->bindParam(6, $address, PDO::PARAM_STR);
	$stmt->bindParam(7, $tambon, PDO::PARAM_STR);
	$stmt->bindParam(8, $ampur, PDO::PARAM_STR);
	$stmt->bindParam(9, $changwat, PDO::PARAM_STR);
	$stmt->bindParam(10, $flag, PDO::PARAM_STR);
	$stmt->bindParam(11, $now, PDO::PARAM_INT);
	$stmt->bindParam(12, $logged_user_id, PDO::PARAM_STR);
	$stmt->bindParam(13, $stores_id, PDO::PARAM_STR);

	$stmt->execute();

	$msg = "success";
	echo json_encode(['code'=>200, 'msg'=>$msg]);



}
			
			
			
			?>


