<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$flag = '0';

$query = "UPDATE ".DB_PREFIX."repair_spare SET flag = ? WHERE oid = ? LIMIT 1"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $flag, PDO::PARAM_STR);
$stmt->bindParam(2, $id, PDO::PARAM_STR);
$stmt->execute();

$stmt = $conn->prepare ("SELECT u.* FROM ".DB_PREFIX."repair_spare  u WHERE u.oid = ? ");
		$stmt->execute([$id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$spare_id = $row['spare_id'];
		$spare_quantity = $row['spare_quantity'];
		$spare_unit = $row['spare_unit'];
// update stock spare
$act = "add";
addSpareReceive($act, $spare_id,$spare_quantity,$spare_unit);




			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg,'oid'=>$id]);
		  
	//}	
			
	
	
//}
			
?>


