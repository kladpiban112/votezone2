<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/PasswordHash.php";
require_once ABSPATH."/resize-class.php";
require_once ABSPATH."/BarcodeQR.php";

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$repair_inout = filter_input(INPUT_POST, 'repair_inout', FILTER_SANITIZE_STRING);

$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);
$cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING);
$prename = filter_input(INPUT_POST, 'prename', FILTER_SANITIZE_STRING);
$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
$sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);
$telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
$birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING);
$birthdate = date_saveto_db($birthdate);

$house = filter_input(INPUT_POST, 'house', FILTER_SANITIZE_STRING);
$community = filter_input(INPUT_POST, 'community', FILTER_SANITIZE_STRING);
$village = filter_input(INPUT_POST, 'village', FILTER_SANITIZE_STRING);
$road = filter_input(INPUT_POST, 'road', FILTER_SANITIZE_STRING);
$changwat = filter_input(INPUT_POST, 'changwat', FILTER_SANITIZE_STRING);
$ampur = filter_input(INPUT_POST, 'ampur', FILTER_SANITIZE_STRING);
$tambon = filter_input(INPUT_POST, 'tambon', FILTER_SANITIZE_STRING);

$level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);
$head = filter_input(INPUT_POST, 'head_data', FILTER_SANITIZE_STRING);
$team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_STRING);

$parents = filter_input(INPUT_POST, 'parents', FILTER_SANITIZE_STRING);

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);


$flag = '1';
$now = date("Y-m-d H:i:s");


	$query1 = "UPDATE ".DB_PREFIX."person_sub SET head = ?,team_id = ? WHERE oid = ? LIMIT 1"; 
	$stmt1 = $conn->prepare($query1);
	$stmt1->bindParam(1, $head, PDO::PARAM_STR);
	$stmt1->bindParam(2, $parents, PDO::PARAM_STR);
	$stmt1->bindParam(3, $personid, PDO::PARAM_STR);
	$stmt1->execute();



			$act_enc = base64_encode('edit');
			$personid_enc = base64_encode($personid);

			$msg = "success";
			echo json_encode(['code'=>200,'personid'=>$personid_enc,'act'=>$act_enc,'action'=>$act]);
		  
			
			
			?>