<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/PasswordHash.php";
require_once ABSPATH."/resize-class.php";

$aid = filter_input(INPUT_POST, 'aid', FILTER_SANITIZE_STRING);
$oid = filter_input(INPUT_POST, 'level_a', FILTER_SANITIZE_STRING);
$details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_STRING);

$stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."mapping_person WHERE aid = ? AND oid_map = ?   ");
$stmt->execute([$aid,$oid]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//$exist_person = $stmt->fetchColumn();
$exist_person = $stmt->rowCount();
if($exist_person == "0"){
	$query = "INSERT INTO ".DB_PREFIX."mapping_person (aid, oid_map, detail) VALUES (?, ?, ?)"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $aid, PDO::PARAM_STR);
	$stmt->bindParam(2, $oid, PDO::PARAM_STR);
	$stmt->bindParam(3, $details, PDO::PARAM_STR);
	$stmt->execute();

	$msg = "success";
	echo json_encode(['code'=>200, 'msg'=>$msg]);
}else{
	$msg = "faile";
	echo json_encode(['code'=>300, 'msg'=>$msg]);

}
		
	?>