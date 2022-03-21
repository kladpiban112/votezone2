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

$logisticstatus = filter_input(INPUT_POST, 'logisticstatus', FILTER_SANITIZE_STRING);
$logisticdate = filter_input(INPUT_POST, 'logisticdate', FILTER_SANITIZE_STRING);
$logisticdate = date_saveto_db($logisticdate);
$logistic_desc = filter_input(INPUT_POST, 'logistic_desc', FILTER_SANITIZE_STRING);
$logisticno = filter_input(INPUT_POST, 'logisticno', FILTER_SANITIZE_STRING);
$logisticby = filter_input(INPUT_POST, 'logisticby', FILTER_SANITIZE_STRING);
$flag = 1;
$now = date('Y-m-d H:i:s');

$query = 'UPDATE '.DB_PREFIX.'repair_logistic SET logistic_date = ?,logistic_id = ?,logistic_no = ?,logistic_by = ?,logistic_desc = ?,  edit_date = ?,edit_users = ? WHERE oid = ?';
$stmt = $conn->prepare($query);

$stmt->bindParam(1, $logisticdate, PDO::PARAM_STR);
$stmt->bindParam(2, $logisticstatus, PDO::PARAM_STR);
$stmt->bindParam(3, $logisticno, PDO::PARAM_STR);
$stmt->bindParam(4, $logisticby, PDO::PARAM_STR);
$stmt->bindParam(5, $logistic_desc, PDO::PARAM_STR);
$stmt->bindParam(6, $now, PDO::PARAM_STR);
$stmt->bindParam(7, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(8, $statusid, PDO::PARAM_STR);

$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID

//addRepairStatus($repairid);

//$receiveid_enc = base64_encode($receive_id);
$msg = 'success';
$act_enc = base64_encode('edit');
$repair_oid_enc = base64_encode($repairid);
$person_oid_enc = base64_encode($personid);
//echo json_encode(['code'=>200, 'msg'=>$msg,'statusid'=>$statusid,'statusdesc'=>$status_desc]);
echo json_encode(['code' => 200, 'msg' => $msg, 'personid' => $person_oid_enc, 'repairid' => $repair_oid_enc, 'act' => $act_enc]);