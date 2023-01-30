<?php
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/PasswordHash.php";
require_once ABSPATH."/resize-class.php";
require_once ABSPATH."/BarcodeQR.php";

$aid = filter_input(INPUT_POST, 'aid', FILTER_SANITIZE_STRING);
$stmt_data = $conn->prepare ("SELECT * FROM area WHERE aid = $aid "

);
$stmt_data->execute();      
    
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)){

                $sub_data["zone_code"] = $row["zone_code"];
                $sub_data["zone_name"] = $row["zone_name"];
                $sub_data["area_color"] = $row["area_color"];
                $sub_data["aid"] = $row["aid"];
                $sub_data["lat"] = $row["latitude"];
                $sub_data["lon"] = $row["longitude"];

                $data[] = $sub_data;
                
             
            } 
            echo json_encode($data);
?>