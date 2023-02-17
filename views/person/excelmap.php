<?php
error_reporting(0);
ini_set('display_errors', 1);
session_start();
include_once "../../core/config.php";
require_once ABSPATH.'/functions.php';

$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$cid_search = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
$hn_search = filter_input(INPUT_GET, 'hn', FILTER_SANITIZE_STRING);
$cid_search = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
$slevel = filter_input(INPUT_GET, 'slevel', FILTER_SANITIZE_STRING);
$cchangwat = filter_input(INPUT_GET, 'changwat', FILTER_SANITIZE_STRING);
$campur = filter_input(INPUT_GET, 'ampur', FILTER_SANITIZE_STRING);
$ctambon = filter_input(INPUT_GET, 'tambon', FILTER_SANITIZE_STRING);
$cposition1 = filter_input(INPUT_GET, 'cposition1', FILTER_SANITIZE_STRING);
$area= filter_input(INPUT_GET, 'area', FILTER_SANITIZE_STRING);


 if($cid_search != ""){
    $cid_data = " AND ps.cid LIKE '%$cid_search%'  ";
}
if($search != ""){
    $search_data = " AND  ps.fname LIKE '%$search%'  OR ps.lname LIKE '%$search%'  ";
}
if($slevel != ""){
    $slevel_data = " AND  ps.level = '$slevel' ";
}
if($cchangwat != ""){
    $cchangwat_data = " AND  ps.changwat = '$cchangwat' ";
}
if($campur != ""){
    $campur_data = " AND  ps.ampur = '$campur' ";
}
if($ctambon != ""){
    $ctambon_data = " AND  ps.tambon = '$ctambon' ";
}
if($cposition1 != ""){
    $cposition1_data = " AND  ps.cposition1 = '$cposition1' ";
}
if($area != ""){
    $area_data = " AND  a.aid = '$area' ";
}

 $sql = "SELECT a.* FROM area a
        WHERE a.aid = {$area} ";
    $stmt_person = $conn->prepare($sql);
    $stmt_person->execute();
    $row = $stmt_person->fetch(PDO::FETCH_ASSOC);
 

        
$strExcelFileName = "รายชื่อ ".$row['zone_name'].".xls";
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
                <i class="far fa-user"></i>&nbsp; รายชื่อของ : <?php echo $row['zone_name'];?>
            </h3>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-strip " id="tbData"
                    style="margin-top: 13px !important; min-height: 300px;">

                    <?php
             

                    $stmt_data = $conn->prepare ("SELECT mp.*,a.*,ps.*
        FROM ".DB_PREFIX." person_sub ps
        INNER JOIN".DB_PREFIX." mapping_person mp ON  mp.oid_map = ps.team_id 
	    INNER  JOIN ".DB_PREFIX."area a ON a.aid = mp.aid
        WHERE ps.flag != '0'  $conditions  $search_data  $cid_data  $slevel_data $cchangwat_data $campur_data $ctambon_data $cposition1_data $area_data
       ORDER BY ps.level ASC $max");
        $stmt_data->execute();
                   
                        ?>
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
                            <th>เขตที่</th>
                            <th>สังกัด</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

            $i = 0;
                        while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
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
                $zonename = $row['zone_name'];
                $detail = $row['detail'];

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
                            <td><?php echo $zonename;?></td>
                            <td><?php echo $detail;?></td>

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