<?php
error_reporting(0);
ini_set('display_errors', 1);
session_start();
include_once "../../core/config.php";
require_once ABSPATH.'/functions.php';

$cchangwat = filter_input(INPUT_GET, 'changwat', FILTER_SANITIZE_STRING);
$campur = filter_input(INPUT_GET, 'ampur', FILTER_SANITIZE_STRING);
$ctambon = filter_input(INPUT_GET, 'tambon', FILTER_SANITIZE_STRING);
$village = filter_input(INPUT_GET, 'village', FILTER_SANITIZE_STRING);





$sql = "SELECT * FROM person_onerecord p WHERE p.cid NOT IN (SELECT ps.cid FROM person_sub ps) AND p.changwat={$cchangwat} AND p.ampur={$campur} AND p.tambon={$ctambon} AND p.village={$village} ";
        $stmt_data = $conn->prepare($sql);
        $row = $stmt_data->execute();

 
$total_rows = $stmt_data->rowCount(); // จำนวน rows
$total_column = $stmt_data->columnCount(); // จำนวน column
$i = 0;

$strExcelFileName = "รายชื่อที่ไม่อยู่ในระบบ.xls";
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
                <i class="far fa-user"></i>&nbsp; ลูกทีมของ : <?php echo $row_person['fname'];?>
            </h3>
            <div class="card-toolbar">

            </div>


            <div class="table-responsive">
                <table class="table table-bordered table-hover table-strip " id="tbData"
                    style="margin-top: 13px !important; min-height: 300px;">
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับ</th>
                            <th>ระดับ</th>

                            <th>เลขบัตรประชาชน</th>
                            <th>ชื่อ-สกุล</th>
                            <th>เพศ</th>
                            <th>อายุ</th>
                            <th>โทรศัพท์</th>
                            <th>ที่อยู่</th>

                            <!--<th class="text-center">สถานะ</th>-->

                        </tr>
                    </thead>
                    <tbody>

                        <?php

            $i  = 0;
            $no = 1;
	        $no = $no * $Page_Start;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)
            )
            {
                $i++;
                $no++;
                $oid = $row['oid'];
                $personid = $oid;
                $personid_enc = base64_encode($oid);
                $prename = $row['prename_title'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $fullname = $prename." ".$fname." ".$lname;
                $cid = $row['cid'];
                $telephone = $row['telephone'];
                $birthdate = date_db_2form($row['birthdate']);
                $img_profile = $row['img_profile'];
                $today = date("Y-m-d");
                $diff = date_diff(date_create($row['birthdate']), date_create($today));
                $age_y = $diff->format('%y');
                
                
                $house = $row['house'];
                $village = $row['village'];
                    $changwatname = $row['changwatname'];
					$ampurname = $row['ampurname'];
					$tambonname = $row['tambonname'];
					$addr =  "บ้านเลขที่ ".$house." ม.".$village." ต.".$tambonname." อ.".$ampurname." จ.".$changwatname;
                $sexname = $row['sexname'];
                $level = $row['levelname'];
                $status = $row['name'];
                $sid = $row['sid'];
              
          
                
                



                ?>
                        <tr>
                            <td class="text-center"><?php echo $no;?></td>
                            <td><?php echo $level;?></td>

                            <td><?php echo $cid;?></td>
                            <td><?php echo $fullname;?></br></br>
                                <?php 
												if($sid == 2){  ?>
                                <span class="badge bg-success"><?php echo  $status ;?></span>
                                <?php }
												elseif ( $sid == 1   ) { ?>
                                <span class="badge bg-warning"><?php echo  $status ;?></span>
                                <?php }
                            							?>
                            </td>
                            <td><?php echo $sexname;?></td>
                            <td><?php echo $age_y;?></td>
                            <td><?php echo $telephone;?></td>
                            <td><?php echo $addr;?></td>

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