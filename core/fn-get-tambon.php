<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');
require_once "../core/config.php";
//require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$changwatcode = filter_input(INPUT_POST, 'changwatcode', FILTER_SANITIZE_STRING);  // รหัสจังหวัด 2 หลัก
$ampurcode = filter_input(INPUT_POST, 'ampurcode', FILTER_SANITIZE_STRING);  // รหัสอำเภอ 2 หลัก
$ampur = filter_input(INPUT_POST, 'ampur', FILTER_SANITIZE_STRING);
if($ampurcode ==""){
    $ampurcode = $ampur;
}
$tambon = filter_input(INPUT_POST, 'tambon', FILTER_SANITIZE_STRING);  // รหัสตำบล 2 หลัก
$ampurcodefull = $changwatcode.$ampurcode;
$stmt_data = $conn->prepare ("SELECT tamboncodefull,tamboncode,tambonname FROM ".DB_PREFIX."ctambon WHERE ampurcode = '$ampurcodefull' ORDER BY tamboncode ");
$stmt_data->execute();               
?>
<option value="">--ระบุ--</option>
<?php
            $r = 1;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $tamboncodefull = $row['tamboncodefull']; // 6 หลัก
                $tamboncode = $row['tamboncode']; // 2 หลัก
                $tambonname = $row['tambonname'];
                 ?>
                <option value="<?php echo $tamboncode;?>" <?php if($tamboncodefull == $changwatcode.$ampurcode.$tambon){echo "selected";}?>><?php echo $tambonname;?></option>     
            <?php 
        $r++;
        } ?>



