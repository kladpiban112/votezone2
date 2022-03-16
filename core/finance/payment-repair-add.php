<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/resize-class.php";


$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);

$paymentdate = filter_input(INPUT_POST, 'paymentdate', FILTER_SANITIZE_STRING); // วันที่ชำระเงิน
$payment_date = date_saveto_db($paymentdate);
$payment_type = filter_input(INPUT_POST, 'payment_type', FILTER_SANITIZE_STRING); // ประเภทการชำระเงิน
$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING); // จำนวนเงิน
$payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING); // วิธีชำรเงิน
$payment_desc = filter_input(INPUT_POST, 'payment_desc', FILTER_SANITIZE_STRING);

$d_day = substr($paymentdate,0,2);
$d_month = substr($paymentdate,3,2);
$d_year = (substr($paymentdate,6,4)-543);
$period = $d_year.$d_month;

$flag = 1;
$now = date("Y-m-d H:i:s");
//$act_payment = '1'; // รับเงินเข้า
// รับเงินเข้า
if($payment_type == "SR"){ $act_payment = "-1"; } else{ $act_payment = "1"; }



$qRepair = getRepairPayment($repairid);
$cost = $qRepair["cost"]; // ค่าซ่อม
$cost_payment = $qRepair["cost_payment"]; // ชำระแล้ว
$cost_success = $qRepair["cost_success"]; // สถานะการชำระเงิน 0 = รอชำระ , 1= ชำระครบแล้ว
$payment_amount_now = $qRepair["cost"] - $qRepair["cost_payment"]; // ยอดรอชำระ


if($amount <= $payment_amount_now ){

$invoiceNumber = lastInvoiceNumber($payment_type,$period);

$query = "INSERT INTO ".DB_PREFIX."payment_trans (id,tranid,act,payment_no,payment_type,payment_date,payment_method,payment_desc,amount,flag,add_date,add_users) VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $repairid, PDO::PARAM_STR);
$stmt->bindParam(2, $act_payment, PDO::PARAM_STR);
$stmt->bindParam(3, $invoiceNumber, PDO::PARAM_STR);
$stmt->bindParam(4, $payment_type, PDO::PARAM_STR);
$stmt->bindParam(5, $payment_date, PDO::PARAM_STR);
$stmt->bindParam(6, $payment_method, PDO::PARAM_STR);
$stmt->bindParam(7, $payment_desc, PDO::PARAM_STR);
$stmt->bindParam(8, $amount, PDO::PARAM_STR);
$stmt->bindParam(9, $flag, PDO::PARAM_STR);
$stmt->bindParam(10, $now, PDO::PARAM_STR);
$stmt->bindParam(11, $logged_user_id, PDO::PARAM_STR);

$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID


// update student_course
if($payment_type == "HS" || $payment_type == "AI"){ 
	$sqlupstudent = "UPDATE ".DB_PREFIX."repair_payment SET cost_payment = cost_payment + ".$amount." WHERE repair_id = '".$repairid."' AND flag = '1'  ";
	$stmt = $conn->prepare($sqlupstudent);
	$stmt->execute();
}


$qRepair = getRepairPayment($repairid);
$cost = $qRepair["cost"]; // ค่าซ่อม
$cost_payment = $qRepair["cost_payment"]; // ชำระแล้ว
$cost_success = $qRepair["cost_success"]; // สถานะการชำระเงิน 0 = รอชำระ , 1= ชำระครบแล้ว
$payment_amount_now = $qRepair["cost"] - $qRepair["cost_payment"]; // ยอดรอชำระ

if($cost == $cost_payment){
    // ชำระครบจำนวน
	$sqlupstudent = "UPDATE ".DB_PREFIX."repair_payment SET cost_success = '1' WHERE repair_id = '".$repairid."' AND flag = '1'   ";
	$stmt = $conn->prepare($sqlupstudent);
	$stmt->execute();

}



// $receiveid_enc = base64_encode($receive_id);
$msg = "success";
$act_enc = base64_encode('edit');

$repair_oid_enc = base64_encode($repairid);
$person_oid_enc = base64_encode($personid);
echo json_encode(['code'=>200, 'msg'=>$msg,'personid'=>$person_oid_enc,'repairid'=>$repair_oid_enc,'act'=>$act_enc]);	
	
}else{
	$msg = "success";
	$act_enc = base64_encode('edit');
	
	$repair_oid_enc = base64_encode($repairid);
	$person_oid_enc = base64_encode($personid);
	echo json_encode(['code'=>201, 'msg'=>$msg,'personid'=>$person_oid_enc,'repairid'=>$repair_oid_enc,'act'=>$act_enc]);	

}
			
			
			
			?>


