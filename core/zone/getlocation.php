<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
$stmt_data = $conn->prepare ("SELECT * FROM ".DB_PREFIX."area ");
$stmt_data->execute();               
while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
{
    $sub_data["id"] = $row["aid"];
    $sub_data["lat"] = $row["latitude"];
    $sub_data["lon"] = $row["longitude"];
    $sub_data["name"] = $row["zone_name"];
    $sub_data["zone_number"] = $row["zone_number"];
    $sub_data["area_number"] = $row["area_number"];

    $data[] = $sub_data;
}   

echo json_encode($data);

?>

