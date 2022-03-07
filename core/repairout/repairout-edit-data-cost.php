<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";




$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$costid = filter_input(INPUT_POST, 'costid', FILTER_SANITIZE_STRING);

$cost = filter_input(INPUT_POST, 'cost', FILTER_SANITIZE_STRING);
$cost_note = filter_input(INPUT_POST, 'cost_note', FILTER_SANITIZE_STRING);
$flag = 1;
$now = date("Y-m-d H:i:s");



$query = "UPDATE ".DB_PREFIX."repair_payment SET cost_note = ?,cost = ?,flag = ?,  edit_date = ?,edit_users = ? WHERE oid = ?"; 
$stmt = $conn->prepare($query);

$stmt->bindParam(1, $cost_note, PDO::PARAM_STR);
$stmt->bindParam(2, $cost, PDO::PARAM_STR);
$stmt->bindParam(3, $flag, PDO::PARAM_STR);
$stmt->bindParam(4, $now, PDO::PARAM_STR);
$stmt->bindParam(5, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(6, $costid, PDO::PARAM_STR);

$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID


$receiveid_enc = base64_encode($receive_id);
$msg = "success";
$act_enc = base64_encode('edit');
$repair_oid_enc = base64_encode($repairid);
$person_oid_enc = base64_encode($personid);
//echo json_encode(['code'=>200, 'msg'=>$msg,'statusid'=>$statusid,'statusdesc'=>$status_desc]);
echo json_encode(['code'=>200, 'msg'=>$msg,'personid'=>$person_oid_enc,'repairid'=>$repair_oid_enc,'act'=>$act_enc]);	

			
			
			
			?>


