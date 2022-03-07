<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/PasswordHash.php";
require_once ABSPATH."/resize-class.php";

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$serviceid = filter_input(INPUT_POST, 'serviceid', FILTER_SANITIZE_STRING);
$eqid = filter_input(INPUT_POST, 'eqid', FILTER_SANITIZE_STRING);
$flag = '1';


if($act == 'add'){

// check for duplicate email
$stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."donate_data WHERE eq_id = ? AND service_id = ?  AND flag = '1'  ");
$stmt->execute([$eqid,$serviceid]);
$exist_email = $stmt->fetchColumn();

if($exist_email!=0){
		$msg = "dup";
		echo json_encode(['code'=>404, 'msg'=>$msg]);
}else{



$now = date("Y-m-d H:i:s");

$query = "INSERT INTO ".DB_PREFIX."donate_data (s_oid, eq_id, service_id,flag,add_date,add_users) VALUES (NULL, ?, ?, ?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $eqid, PDO::PARAM_STR);
$stmt->bindParam(2, $serviceid, PDO::PARAM_STR);
$stmt->bindParam(3, $flag, PDO::PARAM_STR);
$stmt->bindParam(4, $now, PDO::PARAM_STR);
$stmt->bindParam(5, $logged_user_id, PDO::PARAM_STR);
$stmt->execute();

//$person_oid = $conn->lastInsertId(); // last inserted ID
//$person_oid_enc = base64_encode($person_oid);


// $flag = "5"; // ยืมใช้งาน
// $query = "UPDATE ".DB_PREFIX."equipment_main SET flag = ? WHERE oid = ? LIMIT 1"; 
// $stmt = $conn->prepare($query);
// $stmt->bindParam(1, $flag, PDO::PARAM_STR);
// $stmt->bindParam(2, $eqid, PDO::PARAM_STR);
// $stmt->execute();




			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc]);
		  
	}	
			
	
	
}
			
?>


