<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');
require_once "../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);  // level
$person = filter_input(INPUT_POST, 'person', FILTER_SANITIZE_STRING);  //  headid
$teamid = filter_input(INPUT_POST, 'teamid', FILTER_SANITIZE_STRING);  //  teamid
$headid = filter_input(INPUT_POST, 'headid', FILTER_SANITIZE_STRING);  //  teamid

if($headid == ''){
    $headid = $person;
}

$id_h = 0;

$stmt = $conn->prepare ("SELECT team_id FROM person_sub l WHERE l.oid = '$headid' limit 1");
$stmt->execute();              
while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
$id_h = $row->team_id;
} ?>
z
<?php if($id_h != 0){
$stmt1 = $conn->prepare ("SELECT *,lt.level AS levelname 
FROM person_sub l 
LEFT JOIN level_type lt ON l.level = lt.level_id 
WHERE l.oid = '$id_h' limit 1");
$stmt1->execute();     
    while ($row1 = $stmt1->fetch(PDO::FETCH_OBJ)){
        $id = $row1->oid;
        $name = "ระดับ ".$row1->levelname." ". $row1->fname." ".$row1->lname; 
        ?>

<option value="<?php echo $id;?>" <?php if($teamid == $id){ echo "selected";} ?>><?php echo $name;?></option>
<?php  }
}
?>