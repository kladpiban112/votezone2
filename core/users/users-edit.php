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
$userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
$fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING);
$cid = str_replace('-','',$cid);
$shortname = filter_input(INPUT_POST, 'shortname', FILTER_SANITIZE_STRING);
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);
$user_role = filter_input(INPUT_POST, 'user_role', FILTER_SANITIZE_STRING);
$user_status = filter_input(INPUT_POST, 'user_status', FILTER_SANITIZE_STRING);
$telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
$telephone = str_replace(' ','',$telephone);
$email_contact = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

if($act == 'add'){


			
	
	
}else if($act == 'edit'){



	$query = "UPDATE  ".DB_PREFIX."users SET  name = ?,shortname = ?,telephone = ?,cid = ? ,email_contact = ? WHERE user_id = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $fullname, PDO::PARAM_STR);
	$stmt->bindParam(2, $shortname, PDO::PARAM_STR);
	$stmt->bindParam(3, $telephone, PDO::PARAM_STR);
	$stmt->bindParam(4, $cid, PDO::PARAM_STR);
	$stmt->bindParam(5, $email_contact, PDO::PARAM_STR);
	$stmt->bindParam(6, $userid, PDO::PARAM_STR);
	$stmt->execute();


	if($password)
	{
	$hasher = new PasswordHash(8, false);
	$password_db = $hasher->HashPassword($password);
	
	$query = "UPDATE ".DB_PREFIX."users SET password = ? WHERE user_id = ? LIMIT 1"; 	
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $password_db, PDO::PARAM_STR);
	$stmt->bindParam(2, $userid, PDO::PARAM_INT);
	$stmt->execute();
	} 


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
			$resizeObj -> saveImage("../../uploads/avatars/".$image);
			
			@unlink ("../../uploads/temp/".$image);
			$sql = "UPDATE ".DB_PREFIX."users SET avatar = ? WHERE user_id = ? LIMIT 1"; 
			$conn->prepare($sql)->execute([$image, $userid]);
			}
		}


	$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg]);



}
			
			
			
			?>


