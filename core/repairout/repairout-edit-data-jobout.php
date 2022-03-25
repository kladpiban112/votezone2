<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$statusid = filter_input(INPUT_POST, 'statusid', FILTER_SANITIZE_STRING);


$jobticket_id = filter_input(INPUT_POST, 'jobticket_id', FILTER_SANITIZE_STRING);
$job_name = filter_input(INPUT_POST, 'job_name', FILTER_SANITIZE_STRING);
$job_date = filter_input(INPUT_POST, 'job_date', FILTER_SANITIZE_STRING);
$job_date = date_saveto_db($job_date);
$job_desc = filter_input(INPUT_POST, 'job_desc', FILTER_SANITIZE_STRING);
$flag = 1;

$query = 'UPDATE '.DB_PREFIX.'repair_jobout SET jobticket_id = ?,job_name = ?,job_date = ?,job_desc = ?,flag = ? WHERE oid = ?';
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $jobticket_id, PDO::PARAM_STR);
$stmt->bindParam(2, $job_name, PDO::PARAM_STR);
$stmt->bindParam(3, $job_date, PDO::PARAM_STR);
$stmt->bindParam(4, $job_desc, PDO::PARAM_STR);
$stmt->bindParam(5, $flag, PDO::PARAM_STR);
$stmt->bindParam(6, $statusid, PDO::PARAM_STR);

$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID


$msg = 'success';
$act_enc = base64_encode('edit');
$repair_oid_enc = base64_encode($repairid);
$person_oid_enc = base64_encode($personid);
//echo json_encode(['code'=>200, 'msg'=>$msg,'statusid'=>$statusid,'statusdesc'=>$status_desc]);
echo json_encode(['code' => 200, 'msg' => $msg, 'personid' => $person_oid_enc, 'repairid' => $repair_oid_enc, 'act' => $act_enc]);