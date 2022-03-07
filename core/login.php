<?php
error_reporting(0);
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// header('Content-Type: application/json');

require_once "../core/config.php";
require_once ABSPATH."/PasswordHash.php";
//require_once ABSPATH."/core/random_compat/lib/random.php";
require_once ABSPATH."/functions.php";



$usrname = filter_input(INPUT_POST, 'usrname', FILTER_SANITIZE_STRING);
$pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);




// Passwords should never be longer than 72 characters to prevent DoS attacks
if (strlen($pwd) > 72) { die('Password must be 72 characters or less'); }	

$dbPassword = '*'; // In case the user email is not found

$query = "SELECT password FROM ".DB_PREFIX."users WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $usrname);
$stmt->execute();
$exist_user = $stmt->rowCount();

if($exist_user==1)
{
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbPassword = $row['password'];
    
	$hasher = new PasswordHash(8, false);
	
	if($hasher->CheckPassword($pwd, $dbPassword))
		{
			//paswword OK
			$query = "SELECT user_id, active FROM ".DB_PREFIX."users WHERE email = ? LIMIT 1";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(1, $usrname);
			$stmt->execute();		
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$user_id = $row['user_id'];
			$user_active = $row['active'];
			
			if($user_active==0)
				{
				//header("Location: ../index.php?msg=error_inactive&redirect=$redirect");
				//exit;
				$msg = "error";
				echo json_encode(['code'=>404, 'msg'=>$msg]);      
				}
			
			
			session_regenerate_id (); 
			$authenticator = random_bytes(33);
			$user_token = hash('sha256', $authenticator);
			
			$_SESSION['user_token'] = $user_token;
			$_SESSION['user_id'] = $user_id;	
		
			// remember me
			//if(isset($_POST['remember']))
				//{				
					//setcookie('token_rememberme', $user_token, time()+60*60*24*130, '/', '', true, true);
				//} 
			
			$sql  = "UPDATE ".DB_PREFIX."users SET token = ? WHERE user_id = ? LIMIT 1"; 
			$conn->prepare($sql)->execute([$user_token, $user_id]);
					
			if ( $redirect != "" )
				header("location: ".urldecode($redirect));
			else
				$datenow = date("Y-m-d H:i:s");
				$login_status = "1"; // login success
				//$login_ip = $_SERVER['REMOTE_ADDR'];
				//$login_browser = "";
				//$login_system = "";

				$user_agent = $_SERVER['HTTP_USER_AGENT'];
				$login_ip = getUserIP();
				$login_system = getOS();
				$login_browser = getBrowser(); 

				$used = '1';
				//$sql  = "UPDATE ".DB_PREFIX."users SET used = ? WHERE user_id = ? LIMIT 1"; 
				//$conn->prepare($sql)->execute([$used, $user_id]);

				$stmt = $conn->prepare("INSERT INTO ".DB_PREFIX."users_login (id,user_id, login_date, login_ip, login_browser, login_system, login_status) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
				$stmt->execute([$user_id, $datenow, $login_ip, $login_browser, $login_system,$login_status]);
			
			//header("location: ../dashboard.php");	
			$msg = "success";
			echo json_encode(['code'=>200, 'msg'=>$msg]);
		
			//exit;	
		} // end if
			else
				{
				//header("Location: ../index.php?msg=error&redirect=$redirect");
				//exit;
				$msg = "error";
				echo json_encode(['code'=>404, 'msg'=>$msg]);
				}
} 
else
{

	$msg = "error";
	echo json_encode(['code'=>404, 'msg'=>$msg]);
  
}

unset($hasher);
exit;


