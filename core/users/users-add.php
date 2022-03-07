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

// check for duplicate email
$stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."users WHERE email = ?");
$stmt->execute([$username]);
$exist_email = $stmt->fetchColumn();

if($exist_email!=0){
		$msg = "dup";
		echo json_encode(['code'=>404, 'msg'=>$msg]);
	}else{



$now = date("Y-m-d H:i:s");
$ip_reg = $_SERVER['REMOTE_ADDR'];
$host_reg = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$activation_code = md5(random_code());	

$hasher = new PasswordHash(8, false);
$password_db = $hasher->HashPassword($password);
	
$query = "INSERT INTO ".DB_PREFIX."users (user_id, name, email, permalink, password, role_id, active, email_verified, protected,shortname,telephone,org_id,cid,email_contact) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $fullname, PDO::PARAM_STR);
$stmt->bindParam(2, $username, PDO::PARAM_STR);
$stmt->bindParam(3, $permalink, PDO::PARAM_STR);
$stmt->bindParam(4, $password_db, PDO::PARAM_STR);
$stmt->bindParam(5, $user_role, PDO::PARAM_STR);
$stmt->bindParam(6, $user_status, PDO::PARAM_INT);
$stmt->bindParam(7, $email_verified, PDO::PARAM_INT);
$stmt->bindParam(8, $shortname, PDO::PARAM_STR);
$stmt->bindParam(9, $telephone, PDO::PARAM_STR);
$stmt->bindParam(10, $org_id, PDO::PARAM_STR);
$stmt->bindParam(11, $cid, PDO::PARAM_STR);
$stmt->bindParam(12, $email_contact, PDO::PARAM_STR);
$stmt->execute();

$user_id = $conn->lastInsertId(); // last inserted ID


addUsersExtraUnique ($user_id, 'register_time', $now);
//addUsersExtraUnique ($user_id, 'register_ip', $ip_reg);
//addUsersExtraUnique ($user_id, 'register_host', $host_reg);
//addUsersExtraUnique ($user_id, 'activation_code', $activation_code);
//addUsersExtraUnique ($user_id, 'skype', $skype);


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
		$conn->prepare($sql)->execute([$image, $user_id]);
		}
	}



			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg]);
		  
	}	
			
	
	
}else if($act == 'edit'){



	$query = "UPDATE  ".DB_PREFIX."users SET  name = ?, role_id = ?, active = ?,shortname = ?,telephone = ?,org_id = ?,cid = ? ,email_contact = ? WHERE user_id = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $fullname, PDO::PARAM_STR);
	$stmt->bindParam(2, $user_role, PDO::PARAM_STR);
	$stmt->bindParam(3, $user_status, PDO::PARAM_INT);
	$stmt->bindParam(4, $shortname, PDO::PARAM_STR);
	$stmt->bindParam(5, $telephone, PDO::PARAM_STR);
	$stmt->bindParam(6, $org_id, PDO::PARAM_STR);
	$stmt->bindParam(7, $cid, PDO::PARAM_STR);
	$stmt->bindParam(8, $email_contact, PDO::PARAM_STR);
	$stmt->bindParam(9, $userid, PDO::PARAM_STR);
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


