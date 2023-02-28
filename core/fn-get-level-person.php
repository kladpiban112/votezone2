<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');
require_once "../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);  // level
$person = filter_input(INPUT_POST, 'person', FILTER_SANITIZE_STRING);  //  headid

$sql = "SELECT *,lt.level AS levelname 
FROM person_sub l 
LEFT JOIN level_type lt ON l.level = lt.level_id
 WHERE  l.level != 4 ORDER BY l.level ";

if($level == 2){
        $sql = "SELECT *,lt.level AS levelname 
        FROM person_sub l 
        LEFT JOIN level_type lt ON l.level = lt.level_id 
        WHERE  l.level = 1 ORDER BY l.level ";
}
else if($level == 3){
        $sql = "SELECT *,lt.level AS levelname FROM person_sub l
         LEFT JOIN level_type lt ON l.level = lt.level_id 
         WHERE   l.level = 2 ORDER BY l.level ";
}
else if($level == 4){
        $sql = "SELECT *,lt.level AS levelname 
        FROM person_sub l 
        LEFT JOIN level_type lt ON l.level = lt.level_id
        WHERE   l.level = 3 ORDER BY l.level ";
}if($level == 6){
        $sql = "SELECT *,lt.level AS levelname 
        FROM person_sub l 
        LEFT JOIN level_type lt ON l.level = lt.level_id
        WHERE   l.level = 4 ORDER BY l.level ";
}
else if($level == 1){
        $sql = "SELECT *,lt.level AS levelname 
        FROM person_sub l 
        LEFT JOIN level_type lt ON l.level = lt.level_id 
        WHERE  l.level != 1 AND l.level != 2 AND l.level != 3 AND l.level != 4 AND l.level != 5  AND l.level != 6  ORDER BY l.level ";
}else{
        $sql = "SELECT *,lt.level AS levelname FROM person_sub l LEFT JOIN level_type lt ON l.level = lt.level_id WHERE  l.level != 5 ORDER BY l.level ";
}



$stmt = $conn->prepare ($sql);
$stmt->execute();              
?>
<option value="0">--ระบุ--</option>
<?php
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
        $id = $row->oid;
        $name = "ระดับ ".$row->levelname.' '. $row->fname." ".$row->lname; ?>
<option value="<?php echo $id;?>"  <?php if($person == $id){ echo "selected";} ?>   ><?php echo $name;?></option>
<?php 
            }
    ?>