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
$receivedate = filter_input(INPUT_POST, 'receivedate', FILTER_SANITIZE_STRING);
$receivedate = date_saveto_db($receivedate);
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);
$spare_id = filter_input(INPUT_POST, 'spare_id', FILTER_SANITIZE_STRING);
$spare_num = filter_input(INPUT_POST, 'spare_num', FILTER_SANITIZE_STRING);
$spare_unit = filter_input(INPUT_POST, 'spare_unit', FILTER_SANITIZE_STRING);
$stores_id = filter_input(INPUT_POST, 'stores_id', FILTER_SANITIZE_STRING);
$receive_desc = filter_input(INPUT_POST, 'receive_desc');

$flag = 1;
$now = date("Y-m-d H:i:s");

if($act == 'add'){



$query = "INSERT INTO ".DB_PREFIX."spare_receive (receive_id,org_id,receive_date,stores_id,receive_desc, flag,add_date,add_users) VALUES (NULL, ?,?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $org_id, PDO::PARAM_STR);
$stmt->bindParam(2, $receivedate, PDO::PARAM_STR);
$stmt->bindParam(3, $stores_id, PDO::PARAM_STR);
$stmt->bindParam(4, $receive_desc);
$stmt->bindParam(5, $flag, PDO::PARAM_STR);
$stmt->bindParam(6, $now, PDO::PARAM_STR);
$stmt->bindParam(7, $logged_user_id, PDO::PARAM_STR);
$stmt->execute();
$receive_id = $conn->lastInsertId(); // last inserted ID

$receiveid_enc = base64_encode($receive_id);
$msg = "success";
$act_enc = base64_encode('edit');
echo json_encode(['code'=>200, 'msg'=>$msg, 'receiveid'=>$receiveid_enc, 'act'=> $act_enc]);
	
}else if($act == 'edit'){



	$query = "UPDATE  ".DB_PREFIX."spare_receive SET  org_id = ?,receive_date = ?,stores_id=?,receive_desc=?, flag = ?,edit_date = ? ,edit_users = ? WHERE receive_id = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $org_id, PDO::PARAM_STR);
	$stmt->bindParam(2, $receivedate, PDO::PARAM_STR);
	$stmt->bindParam(3, $stores_id, PDO::PARAM_STR);
	$stmt->bindParam(4, $receive_desc);
	$stmt->bindParam(5, $flag, PDO::PARAM_STR);
	$stmt->bindParam(6, $now, PDO::PARAM_INT);
	$stmt->bindParam(7, $logged_user_id, PDO::PARAM_STR);
	$stmt->bindParam(8, $receive_id, PDO::PARAM_STR);

	$stmt->execute();


	$act_enc = base64_encode('');
	$msg = "success";
	echo json_encode(['code'=>200, 'msg'=>$msg, 'receiveid'=>$receiveid_enc, 'act'=> $act_enc]);



}
			
			
			
			?>


