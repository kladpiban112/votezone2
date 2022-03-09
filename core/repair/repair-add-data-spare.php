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

$spare_id = filter_input(INPUT_POST, 'spare_id', FILTER_SANITIZE_STRING);
$spare_other = filter_input(INPUT_POST, 'spare_other', FILTER_SANITIZE_STRING);
$spare_quantity = filter_input(INPUT_POST, 'spare_quantity', FILTER_SANITIZE_STRING);
$spare_unit = filter_input(INPUT_POST, 'spare_unit', FILTER_SANITIZE_STRING);
$spare_price = filter_input(INPUT_POST, 'spare_price', FILTER_SANITIZE_STRING);
$spare_code = filter_input(INPUT_POST, 'spare_code', FILTER_SANITIZE_STRING);
$spare_desc = filter_input(INPUT_POST, 'spare_desc', FILTER_SANITIZE_STRING);
$flag = 1;
$now = date('Y-m-d H:i:s');
$status_out = 'I';
$receive_id = '';

$query = 'INSERT INTO '.DB_PREFIX.'repair_spare (oid,repair_id,spare_id,spare_code,spare_quantity,spare_unit,spare_price,spare_desc, flag,add_date,add_users,status_out,spare_other) VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?,?)';
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $repairid, PDO::PARAM_STR);
$stmt->bindParam(2, $spare_id, PDO::PARAM_STR);
$stmt->bindParam(3, $spare_code, PDO::PARAM_STR);
$stmt->bindParam(4, $spare_quantity, PDO::PARAM_STR);
$stmt->bindParam(5, $spare_unit, PDO::PARAM_STR);
$stmt->bindParam(6, $spare_price, PDO::PARAM_STR);
$stmt->bindParam(7, $spare_desc, PDO::PARAM_STR);
$stmt->bindParam(8, $flag, PDO::PARAM_STR);
$stmt->bindParam(9, $now, PDO::PARAM_STR);
$stmt->bindParam(10, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(11, $status_out, PDO::PARAM_STR);
$stmt->bindParam(12, $spare_other, PDO::PARAM_STR);

$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID

// update stock spare
if ($spare_id != '99') {
    $act = 'delete';
    addSpareReceive($act, $spare_id, $spare_quantity, $spare_unit);
}

$receiveid_enc = base64_encode($receive_id);
$msg = 'success';
$act_enc = base64_encode('edit');
echo json_encode(['code' => 200, 'msg' => $msg]);