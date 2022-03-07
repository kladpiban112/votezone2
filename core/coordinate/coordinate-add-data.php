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
$serviceid = filter_input(INPUT_POST, 'serviceid', FILTER_SANITIZE_STRING);
$service_status = 1;
$service_desc = filter_input(INPUT_POST, 'service_desc');
$flag = '1';
$now = date("Y-m-d H:i:s");
$servicecode = "";


if($act == 'add'){


$query = "INSERT INTO ".DB_PREFIX."coordinate_data (oid,service_id, service_status, service_desc,flag,add_date,add_users) VALUES (NULL, ?, ?, ?, ?, ?, ?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $serviceid, PDO::PARAM_STR);
$stmt->bindParam(2, $service_status, PDO::PARAM_STR);
$stmt->bindParam(3, $service_desc, PDO::PARAM_STR);
$stmt->bindParam(4, $flag, PDO::PARAM_STR);
$stmt->bindParam(5, $now, PDO::PARAM_STR);
$stmt->bindParam(6, $logged_user_id, PDO::PARAM_STR);
$stmt->execute();

$service_oid = $conn->lastInsertId(); // last inserted ID
$service_oid_enc = base64_encode($service_oid);




$act_enc = base64_encode('edit');
$msg = "success";
echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc]);
		  	
	
}else if($act == 'edit'){


$query = "UPDATE ".DB_PREFIX."coordinate_main SET service_code=?,service_date = ?, org_id = ?,service_title=?,service_desc = ?, prename = ?, fname = ?, lname = ?,telephone = ?,house = ?,community = ?,road = ?,village = ?,tambon = ?,ampur = ?,changwat = ?,flag = ?,edit_date = ?,edit_users = ? WHERE service_id = ? LIMIT 1"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $servicecode, PDO::PARAM_STR);
$stmt->bindParam(2, $servicedate, PDO::PARAM_STR);
$stmt->bindParam(3, $org_id, PDO::PARAM_STR);
$stmt->bindParam(4, $servicetitle, PDO::PARAM_STR);
$stmt->bindParam(5, $servicedesc, PDO::PARAM_STR);
$stmt->bindParam(6, $prename, PDO::PARAM_STR);
$stmt->bindParam(7, $fname);
$stmt->bindParam(8, $lname, PDO::PARAM_STR);
$stmt->bindParam(9, $telephone, PDO::PARAM_STR);
$stmt->bindParam(10, $house, PDO::PARAM_STR);
$stmt->bindParam(11, $community, PDO::PARAM_STR);
$stmt->bindParam(12, $road, PDO::PARAM_STR);
$stmt->bindParam(13, $village, PDO::PARAM_STR);
$stmt->bindParam(14, $tambon, PDO::PARAM_STR);
$stmt->bindParam(15, $ampur, PDO::PARAM_STR);
$stmt->bindParam(16, $changwat, PDO::PARAM_STR);
$stmt->bindParam(17, $flag, PDO::PARAM_STR);
$stmt->bindParam(18, $now, PDO::PARAM_STR);
$stmt->bindParam(19, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(20, $serviceid, PDO::PARAM_INT);
$stmt->execute();




	$person_oid_enc = base64_encode($personid);
	$service_oid_enc = base64_encode($serviceid);


			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc]);



}
			
			
			
			?>


