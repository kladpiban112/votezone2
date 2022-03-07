<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';
require_once ABSPATH.'/PasswordHash.php';
require_once ABSPATH.'/resize-class.php';

$staffcid = filter_input(INPUT_POST, 'staffcid', FILTER_SANITIZE_STRING);

$now = date('Y-m-d H:i:s');
//echo $cid;
// check for duplicate email
$sql = 'SELECT * FROM staff_main WHERE cid like "%'.$staffcid.'%" and flag = 1';
$stmt = $conn->prepare($sql);
$stmt->execute();
//$row = $stmt->fetch(PDO::FETCH_ASSOC);
$exist_person = $stmt->rowCount();
//echo $exist_person;
if ($exist_person != 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $personid = $row['oid'];
    $staffcid = $row['cid'];
    $prename = $row['prename'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $telephone = $row['telephone'];
    $org_id = $row['org_id'];

    $act_enc = base64_encode('edit');
    $msg = 'success';
    echo json_encode(['code' => 200, 'msg' => $exist_person, 'personid' => $personid, 'prename' => $prename, 'fname' => $fname, 'lname' => $lname, 'telephone' => $telephone, 'org_id' => $org_id, 'staffcid' => $staffcid]);
} else {
    $act_enc = base64_encode('edit');
    $msg = 'success';
    echo json_encode(['code' => 404, 'msg' => $exist_person, 'personid' => $person_oid_enc, 'serviceid' => $service_oid_enc, 'act' => $act_enc]);
}