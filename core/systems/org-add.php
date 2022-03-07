<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";


$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);
$org_name = filter_input(INPUT_POST, 'org_name', FILTER_SANITIZE_STRING);
$org_shortname = filter_input(INPUT_POST, 'org_shortname', FILTER_SANITIZE_STRING);
$org_telephone = filter_input(INPUT_POST, 'org_telephone', FILTER_SANITIZE_STRING);
$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_STRING);
$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_STRING);
$org_address = filter_input(INPUT_POST, 'org_address', FILTER_SANITIZE_STRING);
$org_changwat = filter_input(INPUT_POST, 'changwat', FILTER_SANITIZE_STRING);
$org_ampur = filter_input(INPUT_POST, 'ampur', FILTER_SANITIZE_STRING);
$org_tambon = filter_input(INPUT_POST, 'tambon', FILTER_SANITIZE_STRING);

$flag = filter_input(INPUT_POST, 'flag', FILTER_SANITIZE_STRING);
$now = date("Y-m-d H:i:s");

if($act == 'add'){



$query = "INSERT INTO ".DB_PREFIX."org_main (org_id, org_name,org_shortname,org_address,org_tambon,org_ampur,org_changwat,org_telephone,latitude,longitude, flag,add_date,add_users) VALUES (NULL, ?, ?, ?, ?,?,?,?,?,?,?,?,?)"; 
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $org_name, PDO::PARAM_STR);
$stmt->bindParam(2, $org_shortname, PDO::PARAM_STR);
$stmt->bindParam(3, $org_address, PDO::PARAM_STR);
$stmt->bindParam(4, $org_tambon, PDO::PARAM_STR);
$stmt->bindParam(5, $org_ampur, PDO::PARAM_STR);
$stmt->bindParam(6, $org_changwat, PDO::PARAM_STR);
$stmt->bindParam(7, $org_telephone, PDO::PARAM_STR);
$stmt->bindParam(8, $latitude, PDO::PARAM_STR);
$stmt->bindParam(9, $longitude, PDO::PARAM_STR);
$stmt->bindParam(10, $flag, PDO::PARAM_STR);
$stmt->bindParam(11, $now, PDO::PARAM_STR);
$stmt->bindParam(12, $logged_user_id, PDO::PARAM_STR);
$stmt->execute();
$org_id = $conn->lastInsertId(); // last inserted ID



// LOGO
if($_FILES['image']['name'])
	{
	$f = $_FILES['image']['name'];
	$ext = strtolower(substr(strrchr($f, '.'), 1));
	if (($ext!= "jpg") && ($ext != "jpeg") && ($ext != "gif") && ($ext != "png")) 
		{
		}

	else
		{
		$image_code = random_code();
		$image = $image_code."-".$_FILES['image']['name'];
		$image = RewriteFile($image);
		move_uploaded_file($_FILES["image"]["tmp_name"], "../../uploads/logo/".$image);
		//addSettings ('cfg_logo_image', $image);			

		$sql = "UPDATE ".DB_PREFIX."org_main SET org_logo = ? WHERE org_id = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $org_id]);


		}
	}



$msg = "success";
echo json_encode(['code'=>200, 'msg'=>$msg]);
	
}else if($act == 'edit'){



	$query = "UPDATE  ".DB_PREFIX."org_main SET  org_name = ?,org_shortname=?,org_address=?,org_tambon=?,org_ampur=?,org_changwat=?,org_telephone=?,latitude=?,longitude=?, flag = ?,edit_date = ? ,edit_users = ? WHERE org_id = ? LIMIT 1"; 
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $org_name, PDO::PARAM_STR);
	$stmt->bindParam(2, $org_shortname, PDO::PARAM_STR);
	$stmt->bindParam(3, $org_address, PDO::PARAM_STR);
	$stmt->bindParam(4, $org_tambon, PDO::PARAM_STR);
	$stmt->bindParam(5, $org_ampur, PDO::PARAM_STR);
	$stmt->bindParam(6, $org_changwat, PDO::PARAM_STR);
	$stmt->bindParam(7, $org_telephone, PDO::PARAM_STR);
	$stmt->bindParam(8, $latitude, PDO::PARAM_STR);
	$stmt->bindParam(9, $longitude, PDO::PARAM_STR);
	$stmt->bindParam(10, $flag, PDO::PARAM_STR);
	$stmt->bindParam(11, $now, PDO::PARAM_INT);
	$stmt->bindParam(12, $logged_user_id, PDO::PARAM_STR);
	$stmt->bindParam(13, $org_id, PDO::PARAM_STR);

	$stmt->execute();

// LOGO
if($_FILES['image']['name']){
		$f = $_FILES['image']['name'];
		$ext = strtolower(substr(strrchr($f, '.'), 1));
		if (($ext!= "jpg") && ($ext != "jpeg") && ($ext != "gif") && ($ext != "png")) 
			{
			}

		else
			{
			$image_code = random_code();
			$image = $image_code."-".$_FILES['image']['name'];
			$image = RewriteFile($image);
			move_uploaded_file($_FILES["image"]["tmp_name"], "../../uploads/logo/".$image);
			//addSettings ('cfg_logo_image', $image);			

			$sql = "UPDATE ".DB_PREFIX."org_main SET org_logo = ? WHERE org_id = ? LIMIT 1"; 
			$conn->prepare($sql)->execute([$image, $org_id]);


			}
}


// รูปหน่วยงาน
if($_FILES['org_img']['name']){
	$f = $_FILES['org_img']['name'];
	$ext = strtolower(substr(strrchr($f, '.'), 1));
	if (($ext!= "jpg") && ($ext != "jpeg") && ($ext != "gif") && ($ext != "png")) 
		{
		}

	else
		{
		$image_code = random_code();
		$image = $image_code."-".$_FILES['org_img']['name'];
		$image = RewriteFile($image);
		move_uploaded_file($_FILES["org_img"]["tmp_name"], "../../uploads/org/".$image);
		//addSettings ('cfg_logo_image', $image);			

		$sql = "UPDATE ".DB_PREFIX."org_main SET org_img = ? WHERE org_id = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $org_id]);


		}
}

// ตารางปฏิบัติงาน
if($_FILES['org_worktime']['name']){
	$f = $_FILES['org_worktime']['name'];
	$ext = strtolower(substr(strrchr($f, '.'), 1));
	if (($ext!= "jpg") && ($ext != "jpeg") && ($ext != "gif") && ($ext != "png")) 
		{
		}

	else
		{
		$image_code = random_code();
		$image = $image_code."-".$_FILES['org_worktime']['name'];
		$image = RewriteFile($image);
		move_uploaded_file($_FILES["org_worktime"]["tmp_name"], "../../uploads/org/".$image);
		//addSettings ('cfg_logo_image', $image);			

		$sql = "UPDATE ".DB_PREFIX."org_main SET org_worktime = ? WHERE org_id = ? LIMIT 1"; 
		$conn->prepare($sql)->execute([$image, $org_id]);


		}
}





	$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg]);



}
			
			
			
			?>


