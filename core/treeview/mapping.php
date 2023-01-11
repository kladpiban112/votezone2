<?php
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/PasswordHash.php";
require_once ABSPATH."/resize-class.php";

$aid = filter_input(INPUT_POST, 'aid', FILTER_SANITIZE_STRING);

$latitude = 0;
$longitude = 0;
$area = "0";
$i = -1;
$stmt_data = $conn->prepare ("SELECT * FROM area WHERE aid = '$aid' ");
$stmt_data->execute();      
    
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)){ 
                
               
                    $latitude = $row["latitude"];
                    $longitude = $row["longitude"];
        

                
                       
            } 
			echo json_encode(['code'=>200, 'latitude'=>$latitude,'longitude'=>$longitude]);
?>