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
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$flag = '0';


//if($act == 'add'){

// check for duplicate email
//$stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."service_data WHERE eq_id = ? AND service_id = ?  AND flag = '1'  ");
//$stmt->execute([$eqid,$serviceid]);
//$exist_email = $stmt->fetchColumn();

//if($exist_email!=0){
		//$msg = "dup";
		//echo json_encode(['code'=>404, 'msg'=>$msg]);
//}else{

$stmt = $conn->prepare("SELECT eq_id FROM ".DB_PREFIX."donate_data WHERE s_oid = '$id' LIMIT 1  ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$eqid = $row['eq_id'];

$now = date("Y-m-d H:i:s");

$query = "UPDATE ".DB_PREFIX."donate_data SET flag = ? , edit_date = ? , edit_users = ? WHERE s_oid = ? LIMIT 1 "; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $flag, PDO::PARAM_STR);
$stmt->bindParam(2, $now, PDO::PARAM_STR);
$stmt->bindParam(3, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(4, $id, PDO::PARAM_STR);
$stmt->execute();


// $flag = "0"; // ลบข้อมูล
// $query = "UPDATE ".DB_PREFIX."equipment_main SET flag = ? WHERE oid = ? LIMIT 1"; 
// $stmt = $conn->prepare($query);
// $stmt->bindParam(1, $flag, PDO::PARAM_STR);
// $stmt->bindParam(2, $eqid, PDO::PARAM_STR);
// $stmt->execute();



			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg,'oid'=>$query]);
		  
	//}	
			
	
	
//}
			
?>


