<?php
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";
require_once ABSPATH."/PasswordHash.php";
require_once ABSPATH."/resize-class.php";
require_once ABSPATH."/BarcodeQR.php";


$oid = filter_input(INPUT_GET, 'oid', FILTER_SANITIZE_STRING);
$stmt_data = $conn->prepare ("SELECT * FROM ".DB_PREFIX."person_main WHERE flag = 1 && team_id = '.$oid.' ORDER BY oid");
$stmt_data->execute();      
?>
<?php
            
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                echo "ssssssssss".$oid;
                $sub_data["id"] = $row["oid"];
                $sub_data["name"] = $row["fname"].' '.$row["lname"];
                $sub_data["text"] = $row["fname"].' '.$row["lname"];
                $sub_data["parent_id"] = $row["head"];
                $data[] = $sub_data;
            } 
            foreach($data as $key => &$value)
            {
                $output[$value["id"]] = &$value;
            }
            foreach($data as $key => &$value)
            {
                if($value["parent_id"] && isset($output[$value["parent_id"]]))
                {
                    $output[$value["parent_id"]]["nodes"][] = &$value;
                }
            }
            foreach($data as $key => &$value)
            {
                if($value["parent_id"] && isset($output[$value["parent_id"]]))
                {
                    unset($data[$key]);
                }
            }
            echo json_encode($data);
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';        

?>


