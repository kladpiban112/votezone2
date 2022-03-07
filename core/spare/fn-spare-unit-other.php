<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

echo $spare_id = filter_input(INPUT_POST, 'spare_id', FILTER_SANITIZE_NUMBER_INT);
$spare_unit = filter_input(INPUT_POST, 'spare_unit', FILTER_SANITIZE_NUMBER_INT);

if ($spare_id != '0') {
    $spare_condition = "and s.spare_id = '$spare_id'";
} else {
    $spare_condition = ' ';
}

$stmt_data = $conn->prepare('SELECT * FROM '.DB_PREFIX.'cunit u WHERE u.unit_id IN (
	SELECT s.spare_unit_master  FROM '.DB_PREFIX."spare_main s WHERE 1=1 $spare_condition
	UNION
	SELECT s.spare_unit_slave  FROM ".DB_PREFIX."spare_main s WHERE 1=1 $spare_condition
	) 
");
$stmt_data->execute();

?>
<option value="">ระบุ</option>
<?php
            $r = 1;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
                $unit_id = $row['unit_id'];
                $unit_name = $row['unit_title']; ?>
<option value="<?php echo $unit_id; ?>" <?php if ($unit_id == $spare_unit) {
                    echo 'selected';
                } ?>><?php echo $unit_name; ?></option>
<?php
        ++$r;
            } ?>