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
$serviceid = filter_input(INPUT_POST, 'serviceid', FILTER_SANITIZE_STRING);
$servicetype = filter_input(INPUT_POST, 'servicetype', FILTER_SANITIZE_STRING);
$spare_id = filter_input(INPUT_POST, 'spare_id', FILTER_SANITIZE_STRING);
$spare_quantity = filter_input(INPUT_POST, 'spare_quantity', FILTER_SANITIZE_STRING);
$spare_unit = filter_input(INPUT_POST, 'spare_unit', FILTER_SANITIZE_STRING);
$spare_code = filter_input(INPUT_POST, 'spare_code', FILTER_SANITIZE_STRING);
$spare_desc = filter_input(INPUT_POST, 'spare_desc', FILTER_SANITIZE_STRING);
$flag = 1;
$now = date('Y-m-d H:i:s');

if ($act == 'add') {
    // check for duplicate email
    $stmt = $conn->prepare('SELECT * FROM '.DB_PREFIX."tools_borrow_data WHERE spare_id = ? AND service_id = ?  AND flag = '1'  ");
    $stmt->execute([$spare_id, $serviceid]);
    $exist_email = $stmt->fetchColumn();

    if ($exist_email != 0) {
        $msg = 'dup';
        echo json_encode(['code' => 404, 'msg' => $msg]);
    } else {
        $now = date('Y-m-d H:i:s');

        $query = 'INSERT INTO '.DB_PREFIX.'tools_borrow_data (s_oid, spare_id, service_id,spare_quantity,spare_unit,spare_desc,flag,add_date,add_users) 
        VALUES (NULL, ?, ?, ?,?,?,?,?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $spare_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $serviceid, PDO::PARAM_STR);
        $stmt->bindParam(3, $spare_quantity, PDO::PARAM_STR);
        $stmt->bindParam(4, $spare_unit, PDO::PARAM_STR);
        $stmt->bindParam(5, $spare_desc, PDO::PARAM_STR);
        $stmt->bindParam(6, $flag, PDO::PARAM_STR);
        $stmt->bindParam(7, $now, PDO::PARAM_STR);
        $stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
        $stmt->execute();

        //$person_oid = $conn->lastInsertId(); // last inserted ID
        //$person_oid_enc = base64_encode($person_oid);

        // if ($servicetype == '1') {
        //     $flag = '5'; // ยืมใช้งาน
        // } elseif ($servicetype == '2') {
        //     $flag = '1'; // คืนอุปกรณ์
        // } else {
        // }

        // $query = 'UPDATE '.DB_PREFIX.'equipment_main SET flag = ? WHERE oid = ? LIMIT 1';
        // $stmt = $conn->prepare($query);
        // $stmt->bindParam(1, $flag, PDO::PARAM_STR);
        // $stmt->bindParam(2, $eqid, PDO::PARAM_STR);
        // $stmt->execute();
        // update stock spare
        // servicetype = 1 ยืม ใช้ delete เพื่อลบออก 2 คืน ใช้ add เพื่อเพิ่มเข้า stock
        if ($servicetype == '1') {
            $act = 'delete';
        }
        if ($servicetype == '2') {
            $act = 'add';
        }
        addSpareReceive($act, $spare_id, $spare_quantity, $spare_unit);

        $act_enc = base64_encode('edit');
        $msg = 'success';
        echo json_encode(['code' => 200, 'msg' => $msg, 'personid' => $person_oid_enc, 'serviceid' => $service_oid_enc, 'act' => $act_enc]);
    }
}