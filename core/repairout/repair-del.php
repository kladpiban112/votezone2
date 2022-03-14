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

			$query = "UPDATE ".DB_PREFIX."repair_main SET flag = ?,edit_date = ? ,edit_users = ? WHERE repair_id = ? LIMIT 1"; 
			$stmt = $conn->prepare($query);
			$stmt->bindParam(1, $flag, PDO::PARAM_STR);
			$stmt->bindParam(2, $now, PDO::PARAM_STR);
			$stmt->bindParam(3, $logged_user_id, PDO::PARAM_STR);
			$stmt->bindParam(4, $id, PDO::PARAM_STR);
			
			$stmt->execute();

			$stmt = $conn->prepare ("SELECT u.repair_refid FROM ".DB_PREFIX."repair_main u WHERE u.repair_id = ? ");
			$stmt->execute([$id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
	        $repairid = $row['repair_refid'];

			$query = "UPDATE ".DB_PREFIX."repair_main SET flag_out = '0' WHERE repair_id = ? LIMIT 1"; 
			$stmt = $conn->prepare($query);
			$stmt->bindParam(1, $repairid, PDO::PARAM_STR);
			$stmt->execute();
			// $stmt = $conn->prepare ("SELECT u.repair_id FROM ".DB_PREFIX."repair_status  u WHERE u.oid = ? ");
			// $stmt->execute([$id]);
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
	        // $repairid = $row['repair_id'];


			//$addRepairStatus = addRepairStatus($repairid);

			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg,'oid'=>$id]);
		  
	//}	
			
	
	
//}
			
?>


