<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';
require_once ABSPATH.'/resize-class.php';

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$spareid = filter_input(INPUT_POST, 'spareid', FILTER_SANITIZE_STRING);

$spare_id = filter_input(INPUT_POST, 'spare_id', FILTER_SANITIZE_STRING);
$spare_quantity = filter_input(INPUT_POST, 'spare_quantity', FILTER_SANITIZE_STRING);
$spare_unit = filter_input(INPUT_POST, 'spare_unit', FILTER_SANITIZE_STRING);
$spare_price = filter_input(INPUT_POST, 'spare_price', FILTER_SANITIZE_STRING);
$spare_code = filter_input(INPUT_POST, 'spare_code', FILTER_SANITIZE_STRING);
$spare_other = filter_input(INPUT_POST, 'spare_other', FILTER_SANITIZE_STRING);
$spare_desc = filter_input(INPUT_POST, 'spare_desc', FILTER_SANITIZE_STRING);

$spare_id_old = filter_input(INPUT_POST, 'txt_spare_id', FILTER_SANITIZE_STRING);
$spare_quantity_old = filter_input(INPUT_POST, 'txt_spare_quantity', FILTER_SANITIZE_STRING);
$spare_unit_old = filter_input(INPUT_POST, 'txt_spare_unit', FILTER_SANITIZE_STRING);

$flag = 1;
$now = date('Y-m-d H:i:s');

$query = 'UPDATE '.DB_PREFIX.'repair_spare 
SET spare_id = ?,spare_code = ?,spare_quantity = ?,spare_unit = ?,spare_price = ?,spare_desc =?, 
edit_date = ?,edit_users = ? , spare_other = ? WHERE oid = ? ';
$stmt = $conn->prepare($query);

$stmt->bindParam(1, $spare_id, PDO::PARAM_STR);
$stmt->bindParam(2, $spare_code, PDO::PARAM_STR);
$stmt->bindParam(3, $spare_quantity, PDO::PARAM_STR);
$stmt->bindParam(4, $spare_unit, PDO::PARAM_STR);
$stmt->bindParam(5, $spare_price, PDO::PARAM_STR);
$stmt->bindParam(6, $spare_desc, PDO::PARAM_STR);
$stmt->bindParam(7, $now, PDO::PARAM_STR);
$stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(9, $spare_other, PDO::PARAM_STR);
$stmt->bindParam(10, $spareid, PDO::PARAM_STR);

$stmt->execute();
//$lastid = $conn->lastInsertId(); // last inserted ID

if ($spare_id != '0') {
    // update stock spare
    $act = 'delete';
    addSpareReceive($act, $spare_id, $spare_quantity, $spare_unit);

    // update stock spare
    $act = 'add';
    addSpareReceive($act, $spare_id_old, $spare_quantity_old, $spare_unit_old);
}
$receiveid_enc = base64_encode($receive_id);
$msg = 'success';
$act_enc = base64_encode('edit');
//echo json_encode(['code'=>200, 'msg'=>$msg]);

$repair_oid_enc = base64_encode($repairid);
$person_oid_enc = base64_encode($personid);
//echo json_encode(['code'=>200, 'msg'=>$msg,'statusid'=>$statusid,'statusdesc'=>$status_desc]);
echo json_encode(['code' => 200, 'msg' => $msg, 'personid' => $person_oid_enc, 'repairid' => $repair_oid_enc, 'act' => $act_enc]);