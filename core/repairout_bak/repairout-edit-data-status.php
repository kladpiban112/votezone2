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
$statusid = filter_input(INPUT_POST, 'statusid', FILTER_SANITIZE_STRING);

$status_id = filter_input(INPUT_POST, 'status_id', FILTER_SANITIZE_STRING);
$statusdate = filter_input(INPUT_POST, 'statusdate', FILTER_SANITIZE_STRING);
$statusdate = date_saveto_db($statusdate);
$status_desc = filter_input(INPUT_POST, 'status_desc', FILTER_SANITIZE_STRING);
$staff_id = filter_input(INPUT_POST, 'staff_id', FILTER_SANITIZE_STRING);
$flag = 1;
$now = date("Y-m-d H:i:s");



$query = "UPDATE ".DB_PREFIX."repair_status SET status_date = ?,status_id = ?,status_desc = ?,  edit_date = ?,edit_users = ? WHERE oid = ?"; 
$stmt = $conn->prepare($query);

$stmt->bindParam(1, $statusdate, PDO::PARAM_STR);
$stmt->bindParam(2, $status_id, PDO::PARAM_STR);
$stmt->bindParam(3, $status_desc, PDO::PARAM_STR);
$stmt->bindParam(4, $now, PDO::PARAM_STR);
$stmt->bindParam(5, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(6, $statusid, PDO::PARAM_STR);

$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID


	$query = "DELETE FROM  ".DB_PREFIX."repair_staff WHERE status_id = ? "; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $statusid, PDO::PARAM_STR);
	$stmt->execute();

	// เพิ่มประเภทผู้ช่วยนักกาย
		if(!empty($_POST['staffs'])) {
			foreach($_POST['staffs'] as $check) {			 
			$query = "INSERT INTO ".DB_PREFIX."repair_staff (service_id,status_id,staff_id,add_date,add_users) VALUES (?,?,?,?,?)"; 
			$stmt = $conn->prepare($query);
			$stmt->bindParam(1, $repairid, PDO::PARAM_STR);
			$stmt->bindParam(2, $statusid, PDO::PARAM_STR);
			$stmt->bindParam(3, $check, PDO::PARAM_STR);
			$stmt->bindParam(4, $now, PDO::PARAM_STR);
			$stmt->bindParam(5, $logged_user_id, PDO::PARAM_STR);
			$stmt->execute();
			}
		}



addRepairStatus($repairid);



$receiveid_enc = base64_encode($receive_id);
$msg = "success";
$act_enc = base64_encode('edit');
$repair_oid_enc = base64_encode($repairid);
$person_oid_enc = base64_encode($personid);
//echo json_encode(['code'=>200, 'msg'=>$msg,'statusid'=>$statusid,'statusdesc'=>$status_desc]);
echo json_encode(['code'=>200, 'msg'=>$msg,'personid'=>$person_oid_enc,'repairid'=>$repair_oid_enc,'act'=>$act_enc]);	

			
			
			
			?>


