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


$servicedate = filter_input(INPUT_POST, 'servicedate', FILTER_SANITIZE_STRING);
$servicedate = date_saveto_db($servicedate);
$service = filter_input(INPUT_POST, 'service', FILTER_SANITIZE_STRING); // ประเภทการรับบริการ
$returndate = filter_input(INPUT_POST, 'returndate', FILTER_SANITIZE_STRING);
$returndate = date_saveto_db($returndate);
$returnday = filter_input(INPUT_POST, 'returnday', FILTER_SANITIZE_STRING);
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
	
	$query = "UPDATE ".DB_PREFIX."person_main SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?, sex = ?,birthdate = ?,telephone = ?,house = ?,community = ?,road = ?,village = ?,tambon = ?,ampur = ?,changwat = ?,flag = ?,edit_date = ?,edit_users = ? WHERE oid = ? LIMIT 1"; 
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
	$stmt->bindParam(19, $personid, PDO::PARAM_INT);
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
			move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/temp/".$image);

			// create avatar image
			$resizeObj = new resize("../../uploads/temp/".$image); 
			$resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
			$resizeObj -> saveImage("../../uploads/person/".$image);
			
			@unlink ("../../uploads/temp/".$image);
			$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
			$conn->prepare($sql)->execute([$image, $personid]);
			}
		}

		$person_oid_enc = base64_encode($personid);


		$query = "INSERT INTO ".DB_PREFIX."service_main (service_id,person_id,org_id, service_date, service_type, return_date,flag,add_date,add_users,return_day) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ? ,?)"; 
		$stmt = $conn->prepare($query);
		$stmt->bindParam(1, $personid, PDO::PARAM_STR);
		$stmt->bindParam(2, $org_id, PDO::PARAM_STR);
		$stmt->bindParam(3, $servicedate, PDO::PARAM_STR);
		$stmt->bindParam(4, $service, PDO::PARAM_STR);
		$stmt->bindParam(5, $returndate, PDO::PARAM_STR);
		$stmt->bindParam(6, $flag, PDO::PARAM_STR);
		$stmt->bindParam(7, $now, PDO::PARAM_STR);
		$stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
		$stmt->bindParam(9, $returnday, PDO::PARAM_STR);
		$stmt->execute();

		$service_oid = $conn->lastInsertId(); // last inserted ID
		$service_oid_enc = base64_encode($service_oid);


	
		$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc]);

}else{


$query = "INSERT INTO ".DB_PREFIX."person_main (oid, cid, org_id, prename, fname, lname, sex,birthdate,telephone,house,community,road,village,tambon,ampur,changwat,flag,add_date,add_users) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)"; 
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
$stmt->execute();

$person_oid = $conn->lastInsertId(); // last inserted ID
$person_oid_enc = base64_encode($person_oid);


$query = "INSERT INTO ".DB_PREFIX."service_main (service_id,person_id,org_id, service_date, service_type, return_date,flag,add_date,add_users,return_day) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ? ,? )"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $person_oid, PDO::PARAM_STR);
$stmt->bindParam(2, $org_id, PDO::PARAM_STR);
$stmt->bindParam(3, $servicedate, PDO::PARAM_STR);
$stmt->bindParam(4, $service, PDO::PARAM_STR);
$stmt->bindParam(5, $returndate, PDO::PARAM_STR);
$stmt->bindParam(6, $flag, PDO::PARAM_STR);
$stmt->bindParam(7, $now, PDO::PARAM_STR);
$stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(9, $returnday, PDO::PARAM_STR);
$stmt->execute();

$service_oid = $conn->lastInsertId(); // last inserted ID
$service_oid_enc = base64_encode($service_oid);

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
		move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/temp/".$image);

		// create avatar image
		$resizeObj = new resize("../../uploads/temp/".$image); 
		$resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
		$resizeObj -> saveImage("../../uploads/person/".$image);
		
		@unlink ("../../uploads/temp/".$image);
		$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $person_oid]);
		}
	}

	


			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc]);
		  
	}	
			
	
	
}else if($act == 'edit'){


$query = "UPDATE ".DB_PREFIX."person_main SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?, sex = ?,birthdate = ?,telephone = ?,house = ?,community = ?,road = ?,village = ?,tambon = ?,ampur = ?,changwat = ?,flag = ?,edit_date = ?,edit_users = ? WHERE oid = ? LIMIT 1"; 
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
$stmt->bindParam(19, $personid, PDO::PARAM_INT);
$stmt->execute();


$query = "UPDATE ".DB_PREFIX."service_main SET org_id = ?, service_date = ?, service_type = ?, return_date = ?,flag = ?,edit_date = ?,edit_users = ? , return_day = ? WHERE service_id = ? LIMIT 1"; 
$stmt = $conn->prepare($query);

$stmt->bindParam(1, $org_id, PDO::PARAM_STR);
$stmt->bindParam(2, $servicedate, PDO::PARAM_STR);
$stmt->bindParam(3, $service, PDO::PARAM_STR);
$stmt->bindParam(4, $returndate, PDO::PARAM_STR);
$stmt->bindParam(5, $flag, PDO::PARAM_STR);
$stmt->bindParam(6, $now, PDO::PARAM_STR);
$stmt->bindParam(7, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(8, $returnday, PDO::PARAM_STR);
$stmt->bindParam(9, $serviceid, PDO::PARAM_INT);
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
		move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/temp/".$image);

		// create avatar image
		$resizeObj = new resize("../../uploads/temp/".$image); 
		$resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
		$resizeObj -> saveImage("../../uploads/person/".$image);
		
		@unlink ("../../uploads/temp/".$image);
		$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $personid]);
		}
	}

	

	$person_oid_enc = base64_encode($personid);
	$service_oid_enc = base64_encode($serviceid);


			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'serviceid'=>$service_oid_enc,'act'=>$act_enc]);



}
			
			
			
			?>


