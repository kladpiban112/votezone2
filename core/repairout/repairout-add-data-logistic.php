<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);

$logisticno = filter_input(INPUT_POST, 'logisticno', FILTER_SANITIZE_STRING);
$logisticby = filter_input(INPUT_POST, 'logisticby', FILTER_SANITIZE_STRING);
$logisticstatus = filter_input(INPUT_POST, 'logisticstatus', FILTER_SANITIZE_STRING);
$logisticdate = filter_input(INPUT_POST, 'logisticdate', FILTER_SANITIZE_STRING);
$logisticdate = date_saveto_db($logisticdate);
$logistic_desc = filter_input(INPUT_POST, 'logistic_desc', FILTER_SANITIZE_STRING);
$staff_id = filter_input(INPUT_POST, 'staff_id', FILTER_SANITIZE_STRING);
$flag = 1;
$now = date('Y-m-d H:i:s');
$status_out = 'O';

$query = 'INSERT INTO '.DB_PREFIX.'repair_logistic (oid,repair_id,logistic_date,logistic_id,logistic_no,logistic_by,logistic_desc,flag,add_date,add_users,status_out) 
VALUES (NULL, ?,?,?,?,?,?,?,?,?,?)';
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $repairid, PDO::PARAM_STR);
$stmt->bindParam(2, $logisticdate, PDO::PARAM_STR);
$stmt->bindParam(3, $logisticstatus, PDO::PARAM_STR);
$stmt->bindParam(4, $logisticno, PDO::PARAM_STR);
$stmt->bindParam(5, $logisticby, PDO::PARAM_STR);
$stmt->bindParam(6, $logistic_desc, PDO::PARAM_STR);
$stmt->bindParam(7, $flag, PDO::PARAM_STR);
$stmt->bindParam(8, $now, PDO::PARAM_STR);
$stmt->bindParam(9, $logged_user_id, PDO::PARAM_STR);
$stmt->bindParam(10, $status_out, PDO::PARAM_STR);

$stmt->execute();
$lastid = $conn->lastInsertId(); // last inserted ID

    // $query = 'DELETE FROM  '.DB_PREFIX.'repair_staff WHERE status_id = ? ';
    // $stmt = $conn->prepare($query);
    // $stmt->bindParam(1, $lastid, PDO::PARAM_STR);
    // $stmt->execute();

    // // เพิ่มประเภทผู้ช่วยนักกาย
    //     if (!empty($_POST['staffs'])) {
    //         foreach ($_POST['staffs'] as $check) {
    //             $query = 'INSERT INTO '.DB_PREFIX.'repair_staff (service_id,status_id,staff_id,add_date,add_users) VALUES (?,?,?,?,?)';
    //             $stmt = $conn->prepare($query);
    //             $stmt->bindParam(1, $repairid, PDO::PARAM_STR);
    //             $stmt->bindParam(2, $lastid, PDO::PARAM_STR);
    //             $stmt->bindParam(3, $check, PDO::PARAM_STR);
    //             $stmt->bindParam(4, $now, PDO::PARAM_STR);
    //             $stmt->bindParam(5, $logged_user_id, PDO::PARAM_STR);
    //             $stmt->execute();
    //         }
    //     }

//addRepairStatus($repairid);

$receiveid_enc = base64_encode($receive_id);
$msg = 'success';
$act_enc = base64_encode('edit');
echo json_encode(['code' => 200, 'msg' => $msg]);