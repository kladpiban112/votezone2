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

$house = filter_input(INPUT_POST, 'house', FILTER_SANITIZE_STRING);
$community = filter_input(INPUT_POST, 'community', FILTER_SANITIZE_STRING);
$village = filter_input(INPUT_POST, 'village', FILTER_SANITIZE_STRING);
$road = filter_input(INPUT_POST, 'road', FILTER_SANITIZE_STRING);
// $changwat = filter_input(INPUT_POST, 'changwat', FILTER_SANITIZE_STRING);
$changwat = "30";
$ampur = filter_input(INPUT_POST, 'ampur', FILTER_SANITIZE_STRING);
$tambon = filter_input(INPUT_POST, 'tambon', FILTER_SANITIZE_STRING);

$cposition1 = filter_input(INPUT_POST, 'cposition1', FILTER_SANITIZE_STRING);
$cposition2 = filter_input(INPUT_POST, 'cposition2', FILTER_SANITIZE_STRING);
$cposition3 = filter_input(INPUT_POST, 'cposition3', FILTER_SANITIZE_STRING);
$cposition4 = filter_input(INPUT_POST, 'cposition4', FILTER_SANITIZE_STRING);

$level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);
$head = filter_input(INPUT_POST, 'head_data', FILTER_SANITIZE_STRING);
$team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_STRING);
$status_pp = filter_input(INPUT_POST, 'status_pp', FILTER_SANITIZE_STRING);
$cost1 = filter_input(INPUT_POST, 'cost1', FILTER_SANITIZE_STRING);
$cost2 = filter_input(INPUT_POST, 'cost2', FILTER_SANITIZE_STRING);
$cost3 = filter_input(INPUT_POST, 'cost3', FILTER_SANITIZE_STRING);
$cost4 = filter_input(INPUT_POST, 'cost4', FILTER_SANITIZE_STRING);


$parents = filter_input(INPUT_POST, 'parents', FILTER_SANITIZE_STRING);

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_STRING);
$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_STRING);


$flag = '1';
$now = date("Y-m-d H:i:s");
$exist_person = "";

if($act == 'add'){

if($level == "1"){$head = "0";}
$query = "INSERT INTO ".DB_PREFIX."person_sub ( cid, org_id, prename, fname, lname, sex,birthdate,telephone,house,community,road,village,tambon,ampur,changwat,flag,add_date,add_users,cposition1,cposition2,cposition3,cposition4,level,head,latitude,longitude,status,cost1,cost2,cost3,cost4) VALUES ( ?,?,?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?,?,?,?,?,? )"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $cid, PDO::PARAM_STR);
$stmt->bindParam(2, $org_id, PDO::PARAM_STR);
$stmt->bindParam(3, $prename, PDO::PARAM_STR);
$stmt->bindParam(4, $fname);
$stmt->bindParam(5, $lname, PDO::PARAM_STR);
$stmt->bindParam(6, $sex, PDO::PARAM_INT);
$stmt->bindParam(7, $birthdate, PDO::PARAM_STR);
$stmt->bindParam(8, $telephone, PDO::PARAM_STR);
$stmt->bindParam(9, $house, PDO::PARAM_STR);
$stmt->bindParam(10, $community, PDO::PARAM_STR);
$stmt->bindParam(11, $road, PDO::PARAM_STR);
$stmt->bindParam(12, $village, PDO::PARAM_STR);
$stmt->bindParam(13, $tambon, PDO::PARAM_STR);
$stmt->bindParam(14, $ampur, PDO::PARAM_STR);
$stmt->bindParam(15, $changwat, PDO::PARAM_STR);
$stmt->bindParam(16, $flag, PDO::PARAM_STR);
$stmt->bindParam(17, $now, PDO::PARAM_STR);
$stmt->bindParam(18, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(19, $cposition1, PDO::PARAM_STR);
$stmt->bindParam(20, $cposition2, PDO::PARAM_STR);
$stmt->bindParam(21, $cposition3, PDO::PARAM_STR);
$stmt->bindParam(22, $cposition4, PDO::PARAM_STR);
$stmt->bindParam(23, $level, PDO::PARAM_STR);
$stmt->bindParam(24, $head, PDO::PARAM_STR);
$stmt->bindParam(25, $latitude, PDO::PARAM_STR);
$stmt->bindParam(26, $longitude, PDO::PARAM_STR);
$stmt->bindParam(27, $status_pp, PDO::PARAM_STR);
$stmt->bindParam(28, $cost1, PDO::PARAM_STR);
$stmt->bindParam(29, $cost2, PDO::PARAM_STR);
$stmt->bindParam(30, $cost3, PDO::PARAM_STR);
$stmt->bindParam(31, $cost4, PDO::PARAM_STR);

$stmt->execute();


$person_oid = $conn->lastInsertId(); // last inserted ID
$person_oid_enc = base64_encode($person_oid);




if($level == "1"){
	$query1 = "UPDATE ".DB_PREFIX."person_sub SET team_id = ? WHERE oid = ? LIMIT 1"; 
	$stmt1 = $conn->prepare($query1);
	$stmt1->bindParam(1, $person_oid, PDO::PARAM_STR);
	$stmt1->bindParam(2, $person_oid, PDO::PARAM_STR);
	$stmt1->execute();
}else if($parents != 0 OR $parents != null){
	$query1 = "UPDATE ".DB_PREFIX."person_sub SET team_id = ? WHERE oid = ? LIMIT 1"; 
	$stmt1 = $conn->prepare($query1);
	$stmt1->bindParam(1, $parents, PDO::PARAM_STR);
	$stmt1->bindParam(2, $person_oid, PDO::PARAM_STR);
	$stmt1->execute();
}


if($_FILES['img_profile']['name'])
	{
	$f = $_FILES['img_profile']['name'];
	$ext = strtolower(substr(strrchr($f, '.'), 1));
	if (($ext!= "jpg") && ($ext != "jpeg") && ($ext != "gif") && ($ext != "png")) 
		{
		}

	else
		{
		$image_code = random_code();
		$image = $image_code."-".$_FILES['img_profile']['name'];
		$image = RewriteFile($image);
		move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/person/".$image);

	
		$sql = "UPDATE ".DB_PREFIX."person_sub  SET img_profile = ? WHERE oid = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $person_oid]);
		}
	}

		$sql3 = "UPDATE " . DB_PREFIX . "person_sub p
		INNER JOIN level_type l ON p.level = l.level_id
		INNER JOIN cchangwat c ON p.changwat = c.changwatcode
		INNER JOIN campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
		INNER JOIN  ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull
		INNER JOIN csex s ON p.sex = s.sex
		SET p.levelname = l.level,p.changwatname = c.changwatname,p.ampurname = a.ampurname ,p.tambonname = t.tambonname,p.sexname = s.sexname";
		$stmt = $conn->prepare($sql3);
		$stmt->bindParam(1, $cid, PDO::PARAM_STR);
$stmt->execute();
	
			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'act'=>$act_enc,'action'=>$act]);
		  	

	
	
}else if($act == 'edit'){
if($level == "1"){
	$head = "0";
	$parents = $personid;
}
	$query = "UPDATE ".DB_PREFIX."person_sub SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?, sex = ?,birthdate = ?,telephone = ?,house = ?,community = ?,road = ?,village = ?,tambon = ?,ampur = ?,changwat = ?,flag = ?,edit_date = ?,edit_users = ?,  cposition1 = ? ,cposition2 = ?,cposition3 = ? ,cposition4 = ?, level = ?, head = ? ,team_id = ? ,latitude = ? ,longitude = ?,status = ?, cost1 =? ,cost2 = ?,cost3 = ?,cost4 = ? WHERE oid = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $cid, PDO::PARAM_STR);
	$stmt->bindParam(2, $org_id, PDO::PARAM_STR);
	$stmt->bindParam(3, $prename, PDO::PARAM_STR);
	$stmt->bindParam(4, $fname);
	$stmt->bindParam(5, $lname, PDO::PARAM_STR);
	$stmt->bindParam(6, $sex, PDO::PARAM_INT);
	$stmt->bindParam(7, $birthdate, PDO::PARAM_STR);
	$stmt->bindParam(8, $telephone, PDO::PARAM_STR);
	$stmt->bindParam(9, $house, PDO::PARAM_STR);
	$stmt->bindParam(10, $community, PDO::PARAM_STR);
	$stmt->bindParam(11, $road, PDO::PARAM_STR);
	$stmt->bindParam(12, $village, PDO::PARAM_STR);
	$stmt->bindParam(13, $tambon, PDO::PARAM_STR);
	$stmt->bindParam(14, $ampur, PDO::PARAM_STR);
	$stmt->bindParam(15, $changwat, PDO::PARAM_STR);
	$stmt->bindParam(16, $flag, PDO::PARAM_STR);
	$stmt->bindParam(17, $now, PDO::PARAM_STR);
	$stmt->bindParam(18, $logged_user_id, PDO::PARAM_STR);
	$stmt->bindParam(19, $cposition1, PDO::PARAM_STR);
	$stmt->bindParam(20, $cposition2, PDO::PARAM_STR);
	$stmt->bindParam(21, $cposition3, PDO::PARAM_STR);
	$stmt->bindParam(22, $cposition4, PDO::PARAM_STR);
	$stmt->bindParam(23, $level, PDO::PARAM_STR);
	$stmt->bindParam(24, $head, PDO::PARAM_STR);
	$stmt->bindParam(25, $parents, PDO::PARAM_STR);
	$stmt->bindParam(26, $latitude, PDO::PARAM_STR);
	$stmt->bindParam(27, $longitude, PDO::PARAM_STR);
	$stmt->bindParam(28, $status_pp, PDO::PARAM_STR);
	$stmt->bindParam(29, $cost1, PDO::PARAM_STR);
	$stmt->bindParam(30, $cost2, PDO::PARAM_STR);
	$stmt->bindParam(31, $cost3, PDO::PARAM_STR);
	$stmt->bindParam(32, $cost4, PDO::PARAM_STR);
	$stmt->bindParam(33, $personid, PDO::PARAM_INT);

	$stmt->execute();

	$sql2 = "UPDATE " . DB_PREFIX . "person_sub p INNER JOIN level_type l ON p.level = l.level_id SET p.levelname = l.level WHERE p.cid = ?";
$stmt = $conn->prepare($sql2);
$stmt->bindParam(1, $cid, PDO::PARAM_STR);
$stmt->execute();
	
	// AVATAR
		if($_FILES['img_profile']['name'])
		{
		$f = $_FILES['img_profile']['name'];
		$ext = strtolower(substr(strrchr($f, '.'), 1));
		if (($ext!= "jpg") && ($ext != "jpeg") && ($ext != "gif") && ($ext != "png")) 
			{
			}

		else
			{
			$image_code = random_code();
			$image = $image_code."-".$_FILES['img_profile']['name'];
			$image = RewriteFile($image);
			move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/person/".$image);

			
			$sql = "UPDATE ".DB_PREFIX."person_sub  SET img_profile = ? WHERE  = ? LIMIT 1"; 
			$conn->prepare($sql)->execute([$image, $personid]);
			}
		}

		$person_oid_enc = base64_encode($personid);


	$person_oid_enc = base64_encode($personid);


			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'act'=>$act_enc,'action'=>$act,'P'=>$parents]);
			
}
			
			?>