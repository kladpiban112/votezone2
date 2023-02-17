<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING);


// check for duplicate email
$stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."person_onerecord  WHERE cid = ?");
$stmt->execute([$cid]);
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