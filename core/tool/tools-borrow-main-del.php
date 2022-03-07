<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';
require_once ABSPATH.'/PasswordHash.php';
require_once ABSPATH.'/resize-class.php';

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$flag = '0';
$now = date('Y-m-d H:i:s');

$query = 'UPDATE '.DB_PREFIX.'tools_borrow_main SET flag = ? , edit_date = ? , edit_users = ? WHERE service_id = ? LIMIT 1 ';
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $flag, PDO::PARAM_STR);
$stmt->bindParam(2, $now, PDO::PARAM_STR);
$stmt->bindParam(3, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(4, $id, PDO::PARAM_STR);
$stmt->execute();

$stmt = $conn->prepare('SELECT s_oid,spare_id,spare_quantity,spare_unit FROM '.DB_PREFIX."tools_borrow_data WHERE service_id = '$id'  ");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $soid = $row['s_oid'];
    $spare_id = $row['spare_id'];
    $spare_quantity = $row['spare_quantity'];
    $spare_unit = $row['spare_unit'];

    $act = 'add';
    addSpareReceive($act, $spare_id, $spare_quantity, $spare_unit);
}

$flag = '0'; // ปิดใช้งาน
$query = 'UPDATE '.DB_PREFIX.'tools_borrow_data SET flag = ? , edit_date = ? , edit_users = ? WHERE service_id = ?';
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $flag, PDO::PARAM_STR);
$stmt->bindParam(2, $now, PDO::PARAM_STR);
$stmt->bindParam(3, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(4, $id, PDO::PARAM_STR);
$stmt->execute();

$act_enc = base64_encode('edit');
$msg = 'success';
echo json_encode(['code' => 200, 'msg' => $msg, 'oid' => $query]);