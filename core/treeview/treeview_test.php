<?php
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/PasswordHash.php";
require_once ABSPATH."/resize-class.php";
require_once ABSPATH."/BarcodeQR.php";

$oid = filter_input(INPUT_POST, 'oid', FILTER_SANITIZE_STRING);
$area = "0";
$i = -1;
// $stmt_data = $conn->prepare ("SELECT * ,a.latitude AS lat ,a.longitude AS lon FROM mapping_person mp
// LEFT JOIN area a ON mp.aid = a.aid
// LEFT JOIN person_main pm ON mp.oid = pm.oid  
// LEFT JOIN person_main pp ON mp.oid = pp.team_id ORDER BY a.aid ASC"
// );
// $stmt_data->execute();      
    
//             while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)){
                
//                 if( $area != $row["aid"] ){
//                     $i++;
//                     $sub_data["id"] = $row["aid"];
//                     $sub_data["lat"] = $row["lat"];
//                     $sub_data["lon"] = $row["lon"];
//                     $sub_data["zone_name"] = $row["zone_name"];
//                     $sub_data["zone_number"] = $row["zone_number"];
//                     $sub_data["area_number"] = $row["area_number"];
//                     $data[] = $sub_data;

//                 }   
//                 if($area = $row["aid"]){
//                     $data[$i]["person"][]  = $row["fname"]." ".$row["lname"];
//                 }            
//             } 
//             echo json_encode($data);

$stmt_data = $conn->prepare ("SELECT * FROM area "

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
                
                // if( $area != $row["aid"] ){
                //     $i++;
                //     // $sub_data["id"] = $row["aid"];
                //     // $sub_data["lat"] = $row["lat"];
                //     // $sub_data["lon"] = $row["lon"];
                //     // $sub_data["zone_name"] = $row["zone_name"];
                //     // $sub_data["zone_number"] = $row["zone_number"];
                //     // $sub_data["area_number"] = $row["area_number"];
                //     // $data[] = $sub_data;

                // }   
                // if($area = $row["aid"]){
                //     $data[$i]["person"][]  = $row["fname"]." ".$row["lname"];
                // }            
            } 
            echo json_encode($data);
?>