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
$aid = filter_input(INPUT_POST, 'aid', FILTER_SANITIZE_STRING);
$area_number = filter_input(INPUT_POST, 'area_number', FILTER_SANITIZE_STRING);
$changwat = filter_input(INPUT_POST, 'changwat', FILTER_SANITIZE_STRING);
$ampur = filter_input(INPUT_POST, 'ampur', FILTER_SANITIZE_STRING);
$tambon = filter_input(INPUT_POST, 'tambon', FILTER_SANITIZE_STRING);
$village = filter_input(INPUT_POST, 'village', FILTER_SANITIZE_STRING);
$zone_number = filter_input(INPUT_POST, 'zone_number', FILTER_SANITIZE_STRING);
$zone_name = filter_input(INPUT_POST, 'zone_name', FILTER_SANITIZE_STRING);
// $latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_STRING);
// $longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_STRING);
$details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_STRING);
$area_color = filter_input(INPUT_POST, 'area_color', FILTER_SANITIZE_STRING);


if($act == 'add'){

	$query = "INSERT INTO ".DB_PREFIX."area (area_number, changwat, ampur, tambon,village, zone_number, zone_name,  details, area_color) VALUES (?, ?, ?, ?, ?, ?,  ?, ?, ?)"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $area_number, PDO::PARAM_STR);
	$stmt->bindParam(2, $changwat, PDO::PARAM_STR);
	$stmt->bindParam(3, $ampur, PDO::PARAM_STR);
	$stmt->bindParam(4, $tambon, PDO::PARAM_STR);
	$stmt->bindParam(5, $village, PDO::PARAM_STR);
	$stmt->bindParam(6, $zone_number, PDO::PARAM_INT);
	$stmt->bindParam(7, $zone_name, PDO::PARAM_INT);
	$stmt->bindParam(8, $details, PDO::PARAM_STR);
	$stmt->bindParam(9, $area_color, PDO::PARAM_STR);
	$stmt->execute();

	$msg = "success";
	echo json_encode(['code'=>200, 'msg'=>$msg]);
		  
}else if($act == 'edit'){

	$query = "UPDATE  ".DB_PREFIX."area SET  area_number = ?, changwat = ?, ampur = ?,tambon = ?,village = ?,zone_number = ?,zone_name = ?  ,details = ?,area_color = ? WHERE aid = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $area_number, PDO::PARAM_STR);
	$stmt->bindParam(2, $changwat, PDO::PARAM_STR);
	$stmt->bindParam(3, $ampur, PDO::PARAM_STR);
	$stmt->bindParam(4, $tambon, PDO::PARAM_STR);
	$stmt->bindParam(5, $village, PDO::PARAM_STR);
	$stmt->bindParam(6, $zone_number, PDO::PARAM_INT);
	$stmt->bindParam(7, $zone_name, PDO::PARAM_INT);
	$stmt->bindParam(8, $details, PDO::PARAM_STR);
	$stmt->bindParam(9, $area_color, PDO::PARAM_STR);
	$stmt->bindParam(10,$aid, PDO::PARAM_STR);
	$stmt->execute();

	$msg = "success";
	echo json_encode(['code'=>200, 'msg'=>$msg]);

}		
	?>