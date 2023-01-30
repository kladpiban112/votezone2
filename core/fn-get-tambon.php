<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');
require_once "../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$changwatcode = filter_input(INPUT_POST, 'changwatcode', FILTER_SANITIZE_STRING);  // รหัสจังหวัด 2 หลัก
$ampurcodeA = filter_input(INPUT_POST, 'ampurcode', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);  // รหัสอำเภอ 2 หลัก
$ampurA = filter_input(INPUT_POST, 'ampur', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$len = count($ampurcodeA);
$ampurcodefull = 'ampurcode = '.$ampurcodeA[0];
$whereampur = "";
if($len > 1){
    for ($i = 1; $i < $len; $i++) {
        $whereampur = $whereampur." OR ampurcode = ".$ampurcodeA[$i];
      }
}else{}
$tambon = filter_input(INPUT_POST, 'tambon', FILTER_SANITIZE_STRING);  // รหัสตำบล 2 หลัก
// $ampurcodefull = $changwatcode.$ampurcode;
$test = "SELECT tamboncodefull,tamboncode,tambonname FROM ".DB_PREFIX."ctambon WHERE '$ampurcodefull $whereampur '  ORDER BY tamboncode ";
$stmt_data = $conn->prepare ("SELECT tamboncodefull,tamboncode,tambonname FROM ".DB_PREFIX."ctambon WHERE $ampurcodefull $whereampur   ORDER BY tamboncode ");
$stmt_data->execute();               
?>
<?php
            $r = 1;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $tamboncodefull = $row['tamboncodefull']; // 6 หลัก
                $tamboncode = $row['tamboncode']; // 2 หลัก
                $tambonname = $row['tambonname'];
                 ?>
<option value="<?php echo $tamboncodefull;?>"
    <?php 
    //if($tamboncodefull == $changwatcode.$ampurcode.$tambon){echo "selected";}
    ?>><?php echo $tambonname;?>
    
</option>
<?php 
        $r++;
        } echo $test;?>