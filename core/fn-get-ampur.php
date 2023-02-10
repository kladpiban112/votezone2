<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');
require_once "../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$changwatcode = filter_input(INPUT_POST, 'changwatcode', FILTER_SANITIZE_STRING);  // รหัสจังหวัด 2 หลัก
$ampur = filter_input(INPUT_POST, 'ampur', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);  // รหัสอำเภอ 2 หลัก
$stmt_data = $conn->prepare ("SELECT ampurcode,ampurname,ampurcodefull FROM ".DB_PREFIX."campur WHERE changwatcode = '$changwatcode' ORDER BY ampurcodefull ");
$stmt_data->execute();                
?>
<option value="">--ระบุ--</option>
<?php
            $r = 1;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $ampurcode = $row['ampurcode']; // 2 หลัก
                $ampurname = $row['ampurname']; // ชื่ออำเภอ
                $ampurcodefull = $row['ampurcodefull']; // 4 หลัก
                 ?>
<option value="<?php echo $ampurcodefull;?>" <?php if($changwatcode.$ampur == $ampurcodefull){echo "selected";}?>>
    <?php echo $ampurname;?></option>
<?php 
        $r++;
        } ?>