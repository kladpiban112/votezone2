<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

//เลือกข้อมูลมาเพื่อตัด stock ก่อน
$stmt = $conn->prepare('SELECT * FROM '.DB_PREFIX.'tools_borrow_data WHERE s_oid = ? limit 1');
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$spare_id = $row['spare_id'];
$spare_quantity = $row['spare_quantity'];
$spare_unit = $row['spare_unit'];

$act = 'add';
addSpareReceive($act, $spare_id, $spare_quantity, $spare_unit);

//หลังจากนั้นอัพเดทแฟลกเพื่อปิดข้อมูล
$stmt2 = $conn->prepare("UPDATE tools_borrow_data SET flag = '0' WHERE s_oid = ?  LIMIT 1");
$chk = $stmt2->execute([$id]);

if ($chk) {
    $msg = 'success';
    echo json_encode([
    'code' => 200,
    'msg' => $msg,
  ]);
} else {
    $msg = 'unsuccess';
    echo json_encode(['code' => 404, 'msg' => $msg]);
}