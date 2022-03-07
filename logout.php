<?php
session_start();
require_once "core/config.php";
$used = '0';
 $user_id = $_SESSION['user_id'];
 $sql  = "UPDATE ".DB_PREFIX."users SET used = ? WHERE user_id = ? LIMIT 1"; 
$conn->prepare($sql)->execute([$used, $user_id]);

$_SESSION = array();
session_destroy();
setcookie("token_rememberme", "", time()-60*60*24*120, "/");  // 120 days ago
header("location:login.php?msg=logout");
exit;