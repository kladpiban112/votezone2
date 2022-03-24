<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";

$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$repairid_enc = base64_encode($repairid);


$conditions = " AND u.repair_id = '$repairid' ";
$sql = 'SELECT u.* FROM '.DB_PREFIX.'repair_status u WHERE u.status_id = "5" AND flag = "1"'. $conditions;
$stmt_data = $conn->prepare($sql);
$stmt_data->execute();
$numb_rows = $stmt_data->rowCount();

echo json_encode($numb_rows);


?>