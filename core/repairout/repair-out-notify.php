<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";


$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);


$func_orgprofile = getOrgProfile($org_id);
//$line_token_key = $func_orgprofile['org_line_token'];
$line_token_key = "3HC0yOTARTdWkA7bYyHCf7aat8ys6wU2uIipjKnoXE3";

 // line notify
		$txt_outjob = "แจ้งซ่อมภายนอกกรุณาตรวจสอบที่ ".ADMIN_URL;
		line_text($txt_outjob,$line_token_key);

?>
