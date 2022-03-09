<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);

$cost = filter_input(INPUT_POST, 'cost', FILTER_SANITIZE_STRING);
$cost_note = filter_input(INPUT_POST, 'cost_note', FILTER_SANITIZE_STRING);
$flag = 1;
$now = date("Y-m-d H:i:s");
//$status_out = 'I';
$receive_id = '';

// check for duplicate 
$stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."repair_payment WHERE repair_id = ? AND flag = '1' ");
$stmt->execute([$repairid]);
$exist_data = $stmt->rowCount();
//$exist_data = $stmt->fetchColumn();


if($exist_data == 0){


$query = "INSERT INTO ".DB_PREFIX."repair_payment (oid,repair_id,cost_note,cost,flag,add_date,add_users) VALUES (NULL, ?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $repairid, PDO::PARAM_STR);
$stmt->bindParam(2, $cost_note, PDO::PARAM_STR);
$stmt->bindParam(3, $cost, PDO::PARAM_STR);
$stmt->bindParam(4, $flag, PDO::PARAM_STR);
$stmt->bindParam(5, $now, PDO::PARAM_STR);
$stmt->bindParam(6, $logged_user_id, PDO::PARAM_STR);

$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID


$receiveid_enc = base64_encode($receive_id);
$msg = "success";
$act_enc = base64_encode('edit');
echo json_encode(['code'=>200, 'msg'=>$msg]);

}else{
	$msg = "dup";
	echo json_encode(['code'=>401, 'msg'=>$msg]);
}
	

			
			
			
			?>


