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
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);

$qtdate = filter_input(INPUT_POST, 'qtdate', FILTER_SANITIZE_STRING); // 
$qtdate = date_saveto_db($qtdate);

$qtusers = filter_input(INPUT_POST, 'qtusers', FILTER_SANITIZE_STRING); // 
$qtnote = filter_input(INPUT_POST, 'qtnote', FILTER_SANITIZE_STRING); // 
$qtprice = filter_input(INPUT_POST, 'qtprice', FILTER_SANITIZE_STRING); // ค่าซ่อมก่อนรวม vat
$qtvat = filter_input(INPUT_POST, 'qtvat', FILTER_SANITIZE_STRING); // จำนวน VAT
$qtvatprice = ($qtprice*$qtvat)/100; // ราคา vat
$qtpricetotal = $qtprice+$qtvatprice; // ราคาสุทธิ
$qtdayexp = filter_input(INPUT_POST, 'qtdayexp', FILTER_SANITIZE_STRING); // จำนวนวันใบเสนอราคา

$qt_status = 1;

$d_day = substr($qtdate,0,2);
$d_month = substr($qtdate,3,2);
$d_year = (is_numeric(substr($qtdate,6,4))-543);
$period = $d_year.$d_month;

$flag = 1;
$now = date("Y-m-d H:i:s");



if($repairid != "" ){

// ยกเลิกใบเสนอราคาเดิม
$sql_qt = "UPDATE ".DB_PREFIX."repair_quotation SET qt_status = '0' WHERE repair_id = '".$repairid."' AND flag = '1'   ";
$stmt = $conn->prepare($sql_qt);
$stmt->execute();

// สร้างเลขที่ใบเสนอราคา
$QuotationNumber = getQuotation($org_id,$qtdate);

$query = "INSERT INTO ".DB_PREFIX."repair_quotation (oid,repair_id,qt_code,qt_price,qt_vat,qt_vatprice,qt_pricetotal,qt_date,qt_note,qt_users,qt_status,flag,add_date,add_users,qt_dayexp) VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $repairid, PDO::PARAM_STR);
$stmt->bindParam(2, $QuotationNumber, PDO::PARAM_STR);
$stmt->bindParam(3, $qtprice, PDO::PARAM_STR);
$stmt->bindParam(4, $qtvat, PDO::PARAM_STR);
$stmt->bindParam(5, $qtvatprice, PDO::PARAM_STR);
$stmt->bindParam(6, $qtpricetotal, PDO::PARAM_STR);
$stmt->bindParam(7, $qtdate, PDO::PARAM_STR);
$stmt->bindParam(8, $qtnote, PDO::PARAM_STR);
$stmt->bindParam(9, $qtusers, PDO::PARAM_STR);
$stmt->bindParam(10, $qt_status, PDO::PARAM_STR);
$stmt->bindParam(11, $flag, PDO::PARAM_STR);
$stmt->bindParam(12, $now, PDO::PARAM_STR);
$stmt->bindParam(13, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(14, $qtdayexp, PDO::PARAM_STR);
$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID


// ลบการเงิน Payment
$sql_qt = "UPDATE ".DB_PREFIX."repair_payment SET flag = '0' WHERE repair_id = '".$repairid."' AND flag = '1'   ";
$stmt = $conn->prepare($sql_qt);
$stmt->execute();

// สร้างการเงิน Payment ใหม่
$cost_success = '0';
$query = "INSERT INTO ".DB_PREFIX."repair_payment (oid,repair_id,cost,cost_success,flag,add_date,add_users) VALUES (NULL, ?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $repairid, PDO::PARAM_STR);
$stmt->bindParam(2, $qtpricetotal, PDO::PARAM_STR);
$stmt->bindParam(3, $cost_success, PDO::PARAM_STR);
$stmt->bindParam(4, $flag, PDO::PARAM_STR);
$stmt->bindParam(5, $now, PDO::PARAM_STR);
$stmt->bindParam(6, $logged_user_id, PDO::PARAM_STR);
$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID


  // อupdate สถานะใบแจ้งซ่อมใหม่
  $sql_qt = "UPDATE ".DB_PREFIX."repair_main SET qt_status = '$qt_status' WHERE repair_id = '".$repairid."' AND flag = '1'   ";
  $stmt = $conn->prepare($sql_qt);
  $stmt->execute();



// $receiveid_enc = base64_encode($receive_id);
$msg = "success";
$act_enc = base64_encode('edit');

$repair_oid_enc = base64_encode($repairid);
$person_oid_enc = base64_encode($personid);
echo json_encode(['code'=>200, 'msg'=>$msg,'personid'=>$person_oid_enc,'repairid'=>$repair_oid_enc,'act'=>$act_enc]);	
	
}else{

	echo json_encode(['code'=>201, 'msg'=>$msg,'personid'=>$person_oid_enc,'repairid'=>$repair_oid_enc,'act'=>$act_enc]);	

}
			
			
			
			?>


