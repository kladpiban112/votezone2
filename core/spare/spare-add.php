<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/resize-class.php";


$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$spare_id = filter_input(INPUT_POST, 'spare_id', FILTER_SANITIZE_STRING);
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);
$spare_name = filter_input(INPUT_POST, 'spare_name', FILTER_SANITIZE_STRING);
$spare_code = filter_input(INPUT_POST, 'spare_code', FILTER_SANITIZE_STRING);
$spare_desc = filter_input(INPUT_POST, 'spare_desc');
$spare_type = filter_input(INPUT_POST, 'spare_type', FILTER_SANITIZE_STRING);
$spare_unit = filter_input(INPUT_POST, 'spare_unit', FILTER_SANITIZE_STRING);
$spare_stock = filter_input(INPUT_POST, 'spare_stock', FILTER_SANITIZE_STRING);
$spare_unit_master = filter_input(INPUT_POST, 'spare_unit_master', FILTER_SANITIZE_STRING);
$spare_unit_slave = filter_input(INPUT_POST, 'spare_unit_slave', FILTER_SANITIZE_STRING);
$spare_unit_cal = filter_input(INPUT_POST, 'spare_unit_cal', FILTER_SANITIZE_STRING);
$flag = filter_input(INPUT_POST, 'flag', FILTER_SANITIZE_STRING);
$now = date("Y-m-d H:i:s");

if($act == 'add'){



$query = "INSERT INTO ".DB_PREFIX."spare_main (spare_id,org_id,spare_code,spare_name,spare_desc,spare_type, flag,add_date,add_users,spare_stock,spare_unit,spare_unit_master,spare_unit_slave,spare_unit_cal) VALUES (NULL, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $org_id, PDO::PARAM_STR);
$stmt->bindParam(2, $spare_code, PDO::PARAM_STR);
$stmt->bindParam(3, $spare_name, PDO::PARAM_STR);
$stmt->bindParam(4, $spare_desc);
$stmt->bindParam(5, $spare_type, PDO::PARAM_STR);
$stmt->bindParam(6, $flag, PDO::PARAM_STR);
$stmt->bindParam(7, $now, PDO::PARAM_STR);
$stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(9, $spare_stock, PDO::PARAM_STR);
$stmt->bindParam(10, $spare_unit, PDO::PARAM_STR);
$stmt->bindParam(11, $spare_unit_master, PDO::PARAM_STR);
$stmt->bindParam(12, $spare_unit_slave, PDO::PARAM_STR);
$stmt->bindParam(13, $spare_unit_cal, PDO::PARAM_STR);
$stmt->execute();
$spare_id = $conn->lastInsertId(); // last inserted ID


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
		$resizeObj -> saveImage("../../uploads/spare/".$image);
		
		@unlink ("../../uploads/temp/".$image);
		$sql = "UPDATE ".DB_PREFIX."spare_main SET spare_img = ? WHERE spare_id = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $spare_id]);
		}
	}


$msg = "success";
echo json_encode(['code'=>200, 'msg'=>$msg]);
	
}else if($act == 'edit'){



	$query = "UPDATE  ".DB_PREFIX."spare_main SET  org_id = ?,spare_code = ?,spare_name=?,spare_desc=?,spare_type=?, flag = ?,edit_date = ? ,edit_users = ? , spare_unit = ?, spare_unit_master = ?, spare_unit_slave = ?, spare_unit_cal = ? , spare_stock = ? WHERE spare_id = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $org_id, PDO::PARAM_STR);
	$stmt->bindParam(2, $spare_code, PDO::PARAM_STR);
	$stmt->bindParam(3, $spare_name, PDO::PARAM_STR);
	$stmt->bindParam(4, $spare_desc);
	$stmt->bindParam(5, $spare_type, PDO::PARAM_STR);
	$stmt->bindParam(6, $flag, PDO::PARAM_STR);
	$stmt->bindParam(7, $now, PDO::PARAM_INT);
	$stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
	$stmt->bindParam(9, $spare_unit, PDO::PARAM_STR);
	$stmt->bindParam(10, $spare_unit_master, PDO::PARAM_STR);
	$stmt->bindParam(11, $spare_unit_slave, PDO::PARAM_STR);
	$stmt->bindParam(12, $spare_unit_cal, PDO::PARAM_STR);
	$stmt->bindParam(13, $spare_stock, PDO::PARAM_STR);
	$stmt->bindParam(14, $spare_id, PDO::PARAM_STR);

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
		$resizeObj -> saveImage("../../uploads/spare/".$image);
		
		@unlink ("../../uploads/temp/".$image);
		$sql = "UPDATE ".DB_PREFIX."spare_main SET spare_img = ? WHERE spare_id = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $spare_id]);
		}
	}

	$msg = "success";
	echo json_encode(['code'=>200, 'msg'=>$msg]);



}
			
			
			
			?>


