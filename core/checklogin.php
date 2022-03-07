<?php
if(!isset($_SESSION)) session_start();

if (isset($_COOKIE['token_rememberme']))
	{
		// User is logged (cookie)
		$token = filter_input(INPUT_COOKIE, 'token_rememberme', FILTER_SANITIZE_ENCODED);
	}
	
else if(isset($_SESSION['user_token']))
	{
		// User is logged (session)
		$token = filter_var($_SESSION['user_token']);
	}

else
	{
		// User not logged
		header("location: ".ADMIN_URL."/login.php?msg=not_logged");
		exit;
	}
	
// User logged	
$stmt = $conn->prepare("SELECT u.user_id, u.name, u.email, u.role_id, u.avatar,u.sendid,u.sendtype,o.org_name,u.org_id FROM ".DB_PREFIX."users u
LEFT JOIN org_main o ON u.org_id = o.org_id
WHERE u.token = ? AND u.active = 1 LIMIT 1");
$stmt->bindParam(1, $token);
$stmt->execute();	

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$logged_user_id = $row['user_id'];
$logged_user_name = stripslashes($row['name']);
$logged_user_email = stripslashes($row['email']);
$logged_user_role_id = $row['role_id']; // สิทธิ์ใช้งาน
$logged_user_avatar = $row['avatar'];
if($logged_user_avatar=="") $logged_user_avatar = "no_avatar.png"; // รูปโปรไฟล์
$logged_user_sendid = $row['sendid']; // รหัสสำหรับรับส่งเอกสาร
$logged_user_sendtype = $row['sendtype']; // สิทธิ์การรับส่ง
$logged_org_id = $row['org_id'];
$logged_org_name = stripslashes($row['org_name']);

if ($row==0 or !$row)
	{
		$_SESSION = array();
		session_destroy();
		setcookie('token_rememberme', '', time()-60*60*24*130, "/");  // 130 days ago
		header("location: ".ADMIN_URL."/login.php?msg=invalid_user");
		exit;
	}
// สิทธิ์ใช้งานเมนู			
$sql = "SELECT role,permiss,title FROM ".DB_PREFIX."users_roles WHERE role_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $logged_user_role_id, PDO::PARAM_INT);
$stmt->execute();	
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$logged_user_role = stripslashes($row['role']);
$logged_user_permiss = $row['permiss'];
$logged_user_role_title = $row['title']; // ชื่อสิทธิ์ใช้งาน

// update last activity
$now = date("Y-m-d H:i:s");
$sql = "UPDATE ".DB_PREFIX."users SET last_activity = ? WHERE user_id = ? ORDER BY user_id DESC LIMIT 1"; 
$conn->prepare($sql)->execute([$now, $logged_user_id]);