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
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING);
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);
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

$house_now = filter_input(INPUT_POST, 'house_now', FILTER_SANITIZE_STRING);
$community_now = filter_input(INPUT_POST, 'community_now', FILTER_SANITIZE_STRING);
$village_now = filter_input(INPUT_POST, 'village_now', FILTER_SANITIZE_STRING);
$road_now = filter_input(INPUT_POST, 'road_now', FILTER_SANITIZE_STRING);
$changwat_now = filter_input(INPUT_POST, 'changwat_now', FILTER_SANITIZE_STRING);
$ampur_now = filter_input(INPUT_POST, 'ampur_now', FILTER_SANITIZE_STRING);
$tambon_now = filter_input(INPUT_POST, 'tambon_now', FILTER_SANITIZE_STRING);

$discharge = filter_input(INPUT_POST, 'discharge', FILTER_SANITIZE_STRING);
$dischargedate = filter_input(INPUT_POST, 'dischargedate', FILTER_SANITIZE_STRING);
$dischargedate = date_saveto_db($dischargedate);

$religion = filter_input(INPUT_POST, 'religion', FILTER_SANITIZE_STRING);
$occupation = filter_input(INPUT_POST, 'occupation', FILTER_SANITIZE_STRING);
$education = filter_input(INPUT_POST, 'education', FILTER_SANITIZE_STRING);
$mstatus = filter_input(INPUT_POST, 'mstatus', FILTER_SANITIZE_STRING);
$abogroup = filter_input(INPUT_POST, 'abogroup', FILTER_SANITIZE_STRING);
$instype = filter_input(INPUT_POST, 'instype', FILTER_SANITIZE_STRING);


$flag = '1';
$now = date("Y-m-d H:i:s");


if($act == 'add'){

// check for duplicate email
$stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."person_main WHERE cid = ? AND org_id = ?   ");
$stmt->execute([$cid,$org_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//$exist_person = $stmt->fetchColumn();
$exist_person = $stmt->rowCount();

if($exist_person!=0){

	
	$personid = $row['oid'];
	
	$query = "UPDATE ".DB_PREFIX."person_main SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?, sex = ?,birthdate = ?,telephone = ?,house = ?,community = ?,road = ?,village = ?,tambon = ?,ampur = ?,changwat = ?,flag = ?,edit_date = ?,edit_users = ? , discharge = ?,dischargedate = ?,religion = ? ,occupation = ? ,education = ? ,mstatus = ? , abogroup = ? , instype = ?,house_now = ?,community_now = ?,road_now = ?,village_now = ?,tambon_now = ?,ampur_now = ?,changwat_now = ?  WHERE oid = ? LIMIT 1"; 
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
	$stmt->bindParam(19, $discharge, PDO::PARAM_STR);
	$stmt->bindParam(20, $dischargedate, PDO::PARAM_STR);
	$stmt->bindParam(21, $religion, PDO::PARAM_STR);
	$stmt->bindParam(22, $occupation, PDO::PARAM_STR);
	$stmt->bindParam(23, $education, PDO::PARAM_STR);
	$stmt->bindParam(24, $mstatus, PDO::PARAM_STR);
	$stmt->bindParam(25, $abogroup, PDO::PARAM_STR);
	$stmt->bindParam(26, $instype, PDO::PARAM_STR);
	$stmt->bindParam(27, $house_now, PDO::PARAM_STR);
	$stmt->bindParam(28, $community_now, PDO::PARAM_STR);
	$stmt->bindParam(29, $road_now, PDO::PARAM_STR);
	$stmt->bindParam(30, $village_now, PDO::PARAM_STR);
	$stmt->bindParam(31, $tambon_now, PDO::PARAM_STR);
	$stmt->bindParam(32, $ampur_now, PDO::PARAM_STR);
	$stmt->bindParam(33, $changwat_now, PDO::PARAM_STR);
	$stmt->bindParam(34, $personid, PDO::PARAM_INT);
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
			// move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/temp/".$image);

			// // create avatar image
			// $resizeObj = new resize("../../uploads/temp/".$image); 
			// $resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
			// $resizeObj -> saveImage("../../uploads/person/".$image);
			
			// @unlink ("../../uploads/temp/".$image);

			move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/person/".$image);

			$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
			$conn->prepare($sql)->execute([$image, $personid]);
			}
		}

		$person_oid_enc = base64_encode($personid);


	
		$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc,'servicetype'=>$service]);

}else{

$hn_new = getHn($org_id);

$query = "INSERT INTO ".DB_PREFIX."person_main (oid, cid, org_id, prename, fname, lname, sex,birthdate,telephone,house,community,road,village,tambon,ampur,changwat,flag,add_date,add_users,discharge,dischargedate,house_now,community_now,road_now,village_now,tambon_now,ampur_now,changwat_now,religion,occupation,education,mstatus,abogroup,instype,hn,regist_date) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
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
$stmt->bindParam(19, $discharge, PDO::PARAM_STR);
$stmt->bindParam(20, $dischargedate, PDO::PARAM_STR);
$stmt->bindParam(21, $house_now, PDO::PARAM_STR);
$stmt->bindParam(22, $community_now, PDO::PARAM_STR);
$stmt->bindParam(23, $road_now, PDO::PARAM_STR);
$stmt->bindParam(24, $village_now, PDO::PARAM_STR);
$stmt->bindParam(25, $tambon_now, PDO::PARAM_STR);
$stmt->bindParam(26, $ampur_now, PDO::PARAM_STR);
$stmt->bindParam(27, $changwat_now, PDO::PARAM_STR);
$stmt->bindParam(28, $religion, PDO::PARAM_STR);
$stmt->bindParam(29, $occupation, PDO::PARAM_STR);
$stmt->bindParam(30, $education, PDO::PARAM_STR);
$stmt->bindParam(31, $mstatus, PDO::PARAM_STR);
$stmt->bindParam(32, $abogroup, PDO::PARAM_STR);
$stmt->bindParam(33, $instype, PDO::PARAM_STR);
$stmt->bindParam(34, $hn_new, PDO::PARAM_STR);
$stmt->bindParam(35, $now, PDO::PARAM_STR);
$stmt->execute();

$person_oid = $conn->lastInsertId(); // last inserted ID
$person_oid_enc = base64_encode($person_oid);


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
		// move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/temp/".$image);

			// // create avatar image
			// $resizeObj = new resize("../../uploads/temp/".$image); 
			// $resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
			// $resizeObj -> saveImage("../../uploads/person/".$image);
			
			// @unlink ("../../uploads/temp/".$image);

			move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/person/".$image);
		$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $person_oid]);
		}
	}

	


			$act_enc = base64_encode('edit');
			$msg = "success";
			$method = "add";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc,'servicetype'=>$service,'method'=>$method]);
		  
	}	
			
	
	
}else if($act == 'edit'){


$query = "UPDATE ".DB_PREFIX."person_main SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?, sex = ?,birthdate = ?,telephone = ?,house = ?,community = ?,road = ?,village = ?,tambon = ?,ampur = ?,changwat = ?,flag = ?,edit_date = ?,edit_users = ?,discharge = ? ,dischargedate = ?,religion = ? ,occupation = ? ,education = ? ,mstatus = ? , abogroup = ? , instype = ?,house_now = ?,community_now = ?,road_now = ?,village_now = ?,tambon_now = ?,ampur_now = ?,changwat_now = ? WHERE oid = ? LIMIT 1"; 
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
$stmt->bindParam(19, $discharge, PDO::PARAM_STR);
$stmt->bindParam(20, $dischargedate, PDO::PARAM_STR);
$stmt->bindParam(21, $religion, PDO::PARAM_STR);
$stmt->bindParam(22, $occupation, PDO::PARAM_STR);
$stmt->bindParam(23, $education, PDO::PARAM_STR);
$stmt->bindParam(24, $mstatus, PDO::PARAM_STR);
$stmt->bindParam(25, $abogroup, PDO::PARAM_STR);
$stmt->bindParam(26, $instype, PDO::PARAM_STR);
$stmt->bindParam(27, $house_now, PDO::PARAM_STR);
$stmt->bindParam(28, $community_now, PDO::PARAM_STR);
$stmt->bindParam(29, $road_now, PDO::PARAM_STR);
$stmt->bindParam(30, $village_now, PDO::PARAM_STR);
$stmt->bindParam(31, $tambon_now, PDO::PARAM_STR);
$stmt->bindParam(32, $ampur_now, PDO::PARAM_STR);
$stmt->bindParam(33, $changwat_now, PDO::PARAM_STR);
$stmt->bindParam(34, $personid, PDO::PARAM_INT);
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
		// move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/temp/".$image);

			// // create avatar image
			// $resizeObj = new resize("../../uploads/temp/".$image); 
			// $resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
			// $resizeObj -> saveImage("../../uploads/person/".$image);
			
			// @unlink ("../../uploads/temp/".$image);

			move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/person/".$image);
		$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $personid]);
		}
	}

	

	$person_oid_enc = base64_encode($personid);
	$service_oid_enc = base64_encode($serviceid);


			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc,'servicetype'=>$service]);



}
			
			
			
			?>


