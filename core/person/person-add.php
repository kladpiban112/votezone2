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

$religion = filter_input(INPUT_POST, 'religion', FILTER_SANITIZE_STRING);
$occupation = filter_input(INPUT_POST, 'occupation', FILTER_SANITIZE_STRING);
$education = filter_input(INPUT_POST, 'education', FILTER_SANITIZE_STRING);
$abogroup = filter_input(INPUT_POST, 'abogroup', FILTER_SANITIZE_STRING);
$level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);
$head = filter_input(INPUT_POST, 'head_data', FILTER_SANITIZE_STRING);
$team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_STRING);

$parents = filter_input(INPUT_POST, 'parents', FILTER_SANITIZE_STRING);

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);


$flag = '1';
$now = date("Y-m-d H:i:s");



$exist_person = "";
if($act == 'add'){

// check for duplicate email
$stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."person_main WHERE cid = ? AND org_id = ?   ");
$stmt->execute([$cid,$org_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//$exist_person = $stmt->fetchColumn();
$exist_person = $stmt->rowCount();

if($exist_person!=0){

	
	// $personid = $row['oid'];
	// if($level == "1"){
	// 	$head = "0";
	//     $team_id = $personid;
	// }

	// $query = "UPDATE ".DB_PREFIX."person_main SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?, sex = ?,birthdate = ?,telephone = ?,house = ?,community = ?,road = ?,village = ?,tambon = ?,ampur = ?,changwat = ?,flag = ?,edit_date = ?,edit_users = ?,religion = ? , occupation = ? ,education = ?, abogroup = ?, level = ?, head = ? ,email = ?,team_id = ? WHERE oid = ? LIMIT 1"; 
	// $stmt = $conn->prepare($query);
	// $stmt->bindParam(1, $cid, PDO::PARAM_STR);
	// $stmt->bindParam(2, $org_id, PDO::PARAM_STR);
	// $stmt->bindParam(3, $prename, PDO::PARAM_STR);
	// $stmt->bindParam(4, $fname);
	// $stmt->bindParam(5, $lname, PDO::PARAM_STR);
	// $stmt->bindParam(6, $sex, PDO::PARAM_INT);
	// $stmt->bindParam(7, $birthdate, PDO::PARAM_STR);
	// $stmt->bindParam(8, $telephone, PDO::PARAM_STR);
	// $stmt->bindParam(9, $house, PDO::PARAM_STR);
	// $stmt->bindParam(10, $community, PDO::PARAM_STR);
	// $stmt->bindParam(11, $road, PDO::PARAM_STR);
	// $stmt->bindParam(12, $village, PDO::PARAM_STR);
	// $stmt->bindParam(13, $tambon, PDO::PARAM_STR);
	// $stmt->bindParam(14, $ampur, PDO::PARAM_STR);
	// $stmt->bindParam(15, $changwat, PDO::PARAM_STR);
	// $stmt->bindParam(16, $flag, PDO::PARAM_STR);
	// $stmt->bindParam(17, $now, PDO::PARAM_STR);
	// $stmt->bindParam(18, $logged_user_id, PDO::PARAM_STR);
	// $stmt->bindParam(19, $religion, PDO::PARAM_STR);
	// $stmt->bindParam(20, $occupation, PDO::PARAM_STR);
	// $stmt->bindParam(21, $education, PDO::PARAM_STR);
	// $stmt->bindParam(22, $abogroup, PDO::PARAM_STR);
	// $stmt->bindParam(23, $level, PDO::PARAM_STR);
	// $stmt->bindParam(24, $head, PDO::PARAM_STR);
	// $stmt->bindParam(25, $email, PDO::PARAM_STR);
	// $stmt->bindParam(26, $team_id, PDO::PARAM_STR);
	// $stmt->bindParam(27, $personid, PDO::PARAM_INT);
	// $stmt->execute();

	// $service_oid = $conn->lastInsertId(); // last inserted ID
	// // AVATAR
	// 	if($_FILES['img_profile']['name'])
	// 	{
	// 	$f = $_FILES['img_profile']['name'];
	// 	$ext = strtolower(substr(strrchr($f, '.'), 1));
	// 	if (($ext!= "jpg") && ($ext != "jpeg") && ($ext != "gif") && ($ext != "png")) 
	// 		{
	// 		}

	// 	else
	// 		{
	// 		$image_code = random_code();
	// 		$image = $image_code."-".$_FILES['img_profile']['name'];
	// 		$image = RewriteFile($image);
	// 		move_uploaded_file($_FILES["img_profile"]["tmp_name"], "../../uploads/person/".$image);

	// 		// create avatar image
	// 		// $resizeObj = new resize("../../uploads/temp/".$image); 
	// 		// $resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
	// 		// $resizeObj -> saveImage("../../uploads/person/".$image);
			
	// 		// @unlink ("../../uploads/temp/".$image);
	// 		$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
	// 		$conn->prepare($sql)->execute([$image, $personid]);
	// 		}
	// 	}

	// 	$person_oid_enc = base64_encode($personid);
	// 	// if($row['head']==""){
	// 	// 	$query = "INSERT INTO ".DB_PREFIX."mapping_person (oid_head,oid) VALUES ( ?, ?)"; 
	// 	// 	$stmt = $conn->prepare($query);
	// 	// 	$stmt->bindParam(1, $personid, PDO::PARAM_STR);
	// 	// 	$stmt->bindParam(2, $head, PDO::PARAM_STR);
	// 	// 	$stmt->execute();
	// 	// }else{
	// 	// 	$query = "UPDATE ".DB_PREFIX."mapping_person SET oid_head = ? WHERE oid = ?"; 
	// 	// 	$stmt = $conn->prepare($query);
	// 	// 	$stmt->bindParam(1, $head, PDO::PARAM_STR);
	// 	// 	$stmt->bindParam(2, $personid, PDO::PARAM_STR);
	// 	// 	$stmt->execute();
	// 	// }

	
	// 	$act_enc = base64_encode('edit');
	// 	$msg = "success";
		// echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'act'=>$act_enc,'action'=>$act]);
		
		echo json_encode(['code'=>300]);

}else{
if($level == "1"){$head = "0";}
$query = "INSERT INTO ".DB_PREFIX."person_main ( cid, org_id, prename, fname, lname, sex,birthdate,telephone,house,community,road,village,tambon,ampur,changwat,flag,add_date,add_users,religion,occupation,education,abogroup,level,head) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?,?,?,?,?,?,?)"; 
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
$stmt->bindParam(19, $religion, PDO::PARAM_STR);
$stmt->bindParam(20, $occupation, PDO::PARAM_STR);
$stmt->bindParam(21, $education, PDO::PARAM_STR);
$stmt->bindParam(22, $abogroup, PDO::PARAM_STR);
$stmt->bindParam(23, $level, PDO::PARAM_STR);
$stmt->bindParam(24, $head, PDO::PARAM_STR);
$stmt->execute();

$person_oid = $conn->lastInsertId(); // last inserted ID
$person_oid_enc = base64_encode($person_oid);

if($level == "1"){
	$query1 = "UPDATE ".DB_PREFIX."person_main SET team_id = ? WHERE oid = ? LIMIT 1"; 
	$stmt1 = $conn->prepare($query1);
	$stmt1->bindParam(1, $person_oid, PDO::PARAM_STR);
	$stmt1->bindParam(2, $person_oid, PDO::PARAM_STR);
	$stmt1->execute();
}else if($parents != 0){
	$query1 = "UPDATE ".DB_PREFIX."person_main SET team_id = ? WHERE oid = ? LIMIT 1"; 
	$stmt1 = $conn->prepare($query1);
	$stmt1->bindParam(1, $parents, PDO::PARAM_STR);
	$stmt1->bindParam(2, $person_oid, PDO::PARAM_STR);
	$stmt1->execute();
}

// if($row['head'] == null){
// 	$query = "INSERT INTO ".DB_PREFIX."mapping_person (oid_head,oid) VALUES ( ?, ?)"; 
// 	$stmt = $conn->prepare($query);
// 	$stmt->bindParam(1, $head, PDO::PARAM_STR);
// 	$stmt->bindParam(2, $person_oid, PDO::PARAM_STR);
// 	$stmt->execute();
// }else{
// 	$query = "UPDATE ".DB_PREFIX."mapping_person SET oid_head = ? WHERE oid = ?"; 
// 	$stmt = $conn->prepare($query);
// 	$stmt->bindParam(1, $head, PDO::PARAM_STR);
// 	$stmt->bindParam(2, $person_oid, PDO::PARAM_STR);
// 	$stmt->execute();
// }


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

		// create avatar image
		// $resizeObj = new resize("../../uploads/temp/".$image); 
		// $resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
		// $resizeObj -> saveImage("../../uploads/person/".$image);
		
		// @unlink ("../../uploads/temp/".$image);
		$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $person_oid]);
		}
	}

			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'act'=>$act_enc,'action'=>$act]);
		  
	}	
			
	
	
}else if($act == 'edit'){
// check for duplicate email
// $stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."person_main WHERE cid = ? AND org_id = ?   ");
// $stmt->execute([$cid,$org_id]);
// $row = $stmt->fetch(PDO::FETCH_ASSOC);
if($level == "1"){
	$head = "0";
	$team_id = $personid;
}
	$query = "UPDATE ".DB_PREFIX."person_main SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?, sex = ?,birthdate = ?,telephone = ?,house = ?,community = ?,road = ?,village = ?,tambon = ?,ampur = ?,changwat = ?,flag = ?,edit_date = ?,edit_users = ?,religion = ? , occupation = ? ,education = ?, abogroup = ?, level = ?, head = ? ,email = ?,team_id = ? WHERE oid = ? LIMIT 1"; 
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
	$stmt->bindParam(19, $religion, PDO::PARAM_STR);
	$stmt->bindParam(20, $occupation, PDO::PARAM_STR);
	$stmt->bindParam(21, $education, PDO::PARAM_STR);
	$stmt->bindParam(22, $abogroup, PDO::PARAM_STR);
	$stmt->bindParam(23, $level, PDO::PARAM_STR);
	$stmt->bindParam(24, $head, PDO::PARAM_STR);
	$stmt->bindParam(25, $email, PDO::PARAM_STR);
	// $stmt->bindParam(26, $team_id, PDO::PARAM_STR);
	$stmt->bindParam(26, $parents, PDO::PARAM_STR);
	$stmt->bindParam(27, $personid, PDO::PARAM_INT);
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

			// create avatar image
			// $resizeObj = new resize("../../uploads/temp/".$image); 
			// $resizeObj -> resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop) 
			// $resizeObj -> saveImage("../../uploads/person/".$image);
			
			// @unlink ("../../uploads/temp/".$image);
			$sql = "UPDATE ".DB_PREFIX."person_main SET img_profile = ? WHERE oid = ? LIMIT 1"; 
			$conn->prepare($sql)->execute([$image, $personid]);
			}
		}

		$person_oid_enc = base64_encode($personid);

		// if($row['head'] == null){
		// 	$query = "INSERT INTO ".DB_PREFIX."mapping_person (oid_head,oid) VALUES ( ?, ?)"; 
		// 	$stmt = $conn->prepare($query);
		// 	$stmt->bindParam(1, $head, PDO::PARAM_STR);
		// 	$stmt->bindParam(2, $personid, PDO::PARAM_STR);
		// 	$stmt->execute();
		// }else{
		// 	$query = "UPDATE ".DB_PREFIX."mapping_person SET oid_head = ? WHERE oid = ?"; 
		// 	$stmt = $conn->prepare($query);
		// 	$stmt->bindParam(1, $head, PDO::PARAM_STR);
		// 	$stmt->bindParam(2, $personid, PDO::PARAM_STR);
		// 	$stmt->execute();
		// }
	
	$person_oid_enc = base64_encode($personid);


			$act_enc = base64_encode('edit');
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$exist_person,'personid'=>$person_oid_enc,'act'=>$act_enc,'action'=>$act,'P'=>$parents]);
			
}
			
			?>


