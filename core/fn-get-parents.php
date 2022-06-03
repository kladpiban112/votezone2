<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$person = filter_input(INPUT_POST, 'person', FILTER_SANITIZE_STRING);  
$id_h = 0;

$stmt = $conn->prepare ("SELECT * FROM person_main l WHERE l.oid = ".$person." limit 1");
$stmt->execute();              
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
        $id_h = $row->team_id;
    }
if($id_h != 0){
$stmt1 = $conn->prepare ("SELECT *,lt.level AS levelname FROM person_main l LEFT JOIN level_type lt ON l.level = lt.level_id WHERE l.oid = ".$id_h." limit 1");
$stmt1->execute();     
    while ($row1 = $stmt1->fetch(PDO::FETCH_OBJ)){
        $id = $row1->oid;
        $name = "ระดับ ".$row1->levelname." ". $row1->fname." ".$row1->lname;
    }
    echo json_encode(['code' => "200", 'id' => $person,'name' => $name]);
}else if($id_h == 0){
    echo json_encode(['code' => "200", 'id' => 0,'name' => 0,'ide'=>$person]);
}

?>
 
