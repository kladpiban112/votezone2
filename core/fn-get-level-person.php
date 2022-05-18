<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');
require_once "../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);  
$person = filter_input(INPUT_POST, 'person', FILTER_SANITIZE_STRING);  

$level_type = "l.level != 4";
if($level == 2){$level_type = "l.level = 1";}
elseif($level == 3){$level_type = "l.level = 1 OR l.level = 2";}
elseif($level == 1){$level_type = "l.level != 1 AND l.level != 2 AND l.level != 3 AND l.level != 4";}
$stmt = $conn->prepare ("SELECT * FROM person_main l WHERE ".$level_type." ORDER BY l.level");
$stmt->execute();              
?>
<option value="">--ระบุ--</option>
<?php
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
        $id = $row->oid;
        $name = $row->fname." ".$row->lname; ?>
        <option value="<?php echo $id;?>" <?php if($person == $id){ echo "selected";}?>><?php echo $name;?></option>
        <?php 
            }
    ?>
