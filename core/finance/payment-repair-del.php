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

			$stmt = $conn->prepare ("SELECT tranid,amount FROM ".DB_PREFIX."payment_trans WHERE id = ? LIMIT 1 ");
			$stmt->execute([$id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$repairid = $row['tranid']; // รหัสซ่อมที่ยกเลิก
			$amount = $row['amount']; // จำนวนเงินที่ยกเลิก
			

			$query = "UPDATE ".DB_PREFIX."payment_trans SET flag = ? WHERE id = ? LIMIT 1"; 
			$stmt = $conn->prepare($query);
			$stmt->bindParam(1, $flag, PDO::PARAM_STR);
			$stmt->bindParam(2, $id, PDO::PARAM_STR);
			$stmt->execute();


			$qRepair = getRepairPayment($repairid);
			// $cost = $qRepair["cost"]; // ค่าซ่อม
			 $cost_payment = $qRepair["cost_payment"]; // ชำระแล้ว
			// $cost_success = $qRepair["cost_success"]; // สถานะการชำระเงิน 0 = รอชำระ , 1= ชำระครบแล้ว
			 $payment_amount_now = $qRepair["cost_payment"] - $amount; // ยอดรอชำระ

			//if($cost == $cost_payment){
				// ชำระครบจำนวน
				$sqlupstudent = "UPDATE ".DB_PREFIX."repair_payment SET cost_payment = '$payment_amount_now' ,cost_success = '0' WHERE repair_id = '".$repairid."' AND flag = '1'   ";
				$stmt = $conn->prepare($sqlupstudent);
				$stmt->execute();

			//}


			


			

			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg,'oid'=>$id]);
		  
	//}	
			
	
	
//}
			
?>


