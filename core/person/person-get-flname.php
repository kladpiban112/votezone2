<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);



// check for duplicate email
$stmt = $conn->prepare("SELECT p.*,CONCAT(SUBSTR(p.birthdate,9,2),'/',SUBSTR(p.birthdate,6,2),'/',(SUBSTR(p.birthdate,1,4)+543)) As bdate FROM ".DB_PREFIX."person_onerecord p WHERE p.fname = ? AND p.lname = ?");
$stmt->execute([$fname,$lname]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$exist_person = $stmt->rowCount();

if($exist_person != 0){

	$msg = "success";
	echo json_encode(['code'=>200, 'data'=>$row]);
	
}else{
		$msg = "dup";
		echo json_encode(['code'=>404, 'data'=>$msg]);
	}

?>