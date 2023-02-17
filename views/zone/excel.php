<?php
error_reporting(0);
ini_set('display_errors', 1);
session_start();
include_once "../../core/config.php";
require_once ABSPATH.'/functions.php';



$sql = "SELECT * FROM area AS a  WHERE a.flag != '0' ";
        $stmt_data = $conn->prepare($sql);
        $row = $stmt_data->execute();

 
 
$total_rows = $stmt_data->rowCount(); // จำนวน rows
$total_column = $stmt_data->columnCount(); // จำนวน column
$i = 0;

$strExcelFileName = "ยอดรวม.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");


?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <br>
    <div class="card card-custom gutter-b example example-compact">

        <div class="card-body">
            <h3 class="card-title">
                <i class="far fa-user"></i>&nbsp; ยอดรวมทั้งหมด
            </h3>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-strip " id="tbData"
                    style="margin-top: 13px !important; min-height: 300px;">
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับ</th>
                            <th>ชื่อหน่วยเลือกตั้ง</th>

                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>D</th>
                            <th>N</th>
                            <th>อยู๋ในระบบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
            $i  = 0;
            $no = 1;
	        $no = $no * $Page_Start;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $i++;
                $no++;
                $aid = $row['aid'];
                $aid_enc = base64_encode($aid);
                $area_number = $row['area_number'];
                $changwat = $row['changwatname'];
                $ampur = $row['ampurname'];
                $tambon = $row['tambonname'];
                $village = $row['village'];
                $zone_number = $row['zone_number'];
                $zone_name = $row['zone_name'];


                $numb_A = $conn->query("SELECT COUNT(level) AS num FROM".DB_PREFIX." mapping_person mp 
                                         INNER  JOIN area a ON a.aid = mp.aid
                                         INNER  JOIN person_sub pm ON mp.oid_map = pm.team_id
                                         WHERE mp.aid = ".$aid." AND pm.level = '1' ORDER BY mp.oid_map" )->fetchColumn();
                 $numb_B = $conn->query("SELECT COUNT(level) AS num FROM".DB_PREFIX." mapping_person mp 
                                         INNER  JOIN area a ON a.aid = mp.aid
                                         INNER  JOIN person_sub pm ON mp.oid_map = pm.team_id
                                         WHERE mp.aid = ".$aid." AND pm.level = '2' ORDER BY mp.oid_map" )->fetchColumn();
                 $numb_C = $conn->query("SELECT COUNT(level) AS num FROM".DB_PREFIX." mapping_person mp 
                                         INNER  JOIN area a ON a.aid = mp.aid
                                         INNER  JOIN person_sub pm ON mp.oid_map = pm.team_id
                                         WHERE mp.aid = ".$aid." AND pm.level = '3' ORDER BY mp.oid_map" )->fetchColumn();
                 $numb_D = $conn->query("SELECT COUNT(level) AS num FROM".DB_PREFIX." mapping_person mp 
                                         INNER  JOIN area a ON a.aid = mp.aid
                                         INNER  JOIN person_sub pm ON mp.oid_map = pm.team_id
                                         WHERE mp.aid = ".$aid." AND pm.level = '4' ORDER BY mp.oid_map" )->fetchColumn();
                $numb_N = $conn->query("SELECT COUNT(level) AS num FROM".DB_PREFIX." mapping_person mp 
                                         INNER  JOIN area a ON a.aid = mp.aid
                                         INNER  JOIN person_sub pm ON mp.oid_map = pm.team_id
                                         WHERE mp.aid = ".$aid." AND pm.level = '5' ORDER BY mp.oid_map" )->fetchColumn();
                 $numb_T = $conn->query("SELECT COUNT(level) AS num FROM".DB_PREFIX." mapping_person mp 
                                         INNER  JOIN area a ON a.aid = mp.aid
                                         INNER  JOIN person_sub pm ON mp.oid_map = pm.team_id
                                         WHERE mp.aid = ".$aid." ORDER BY mp.oid_map" )->fetchColumn();
                
                ?>
                        <tr>
                            <td class="text-center"><?php echo $no;?></td>
                            <td><?php echo $zone_name;?></td>
                            <td>
                                <h5><?php echo  number_format($numb_A);?> </h5>
                            </td>
                            <td>
                                <h5><?php echo  number_format($numb_B);?> </h5>
                            </td>
                            <td>
                                <h5><?php echo  number_format($numb_C);?> </h5>
                            </td>
                            <td>
                                <h5><?php echo  number_format($numb_D);?> </h5>
                            </td>
                            <td>
                                <h5><?php echo  number_format($numb_N);?> </h5>
                            </td>
                            <td>
                                <h5><?php echo  number_format($numb_T);?> </h5>
                            </td>

                        </tr>
                        <?php 
              } // end while
            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>