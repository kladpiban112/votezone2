<?php
error_reporting(0);
session_start();
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$aid = filter_input(INPUT_POST, 'aid', FILTER_SANITIZE_STRING);
$aid_enc = base64_encode($aid);
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$personid_enc = base64_encode($personid);

// $stmt_data = $conn->prepare('SELECT *,COUNT(pm.team_id) AS count_num FROM mapping_person mp 
// LEFT JOIN area a ON a.aid = mp.aid
// LEFT JOIN person_main pm ON mp.oid = pm.team_id
// WHERE mp.aid = '.$aid.' GROUP BY pm.team_id');
// $stmt_data->execute();
// $numb_rows = $stmt_data->rowCount();


$stmt_data = $conn->prepare('SELECT * FROM mapping_person mp 
LEFT JOIN area a ON a.aid = mp.aid
LEFT JOIN person_sub pm ON mp.oid_map = pm.team_id
WHERE mp.aid = '.$aid.' AND pm.level = 1 ORDER BY mp.oid_map');
$stmt_data->execute();
$numb_rows = $stmt_data->rowCount();



?>


<div class="table-responsive">
    <table class="table table-bordered table-hover table-strip" id="tbData" style="">
        <thead style="position: sticky; top: 0; z-index: 1;background:#eee;">
            <tr>
                <th class="text-center">ลำดับ</th>
                <th style="width:30%">ชื่อ-สกุล</th>
                <th style="width:20%">รายละเอียด</th>
                <th>จำนวนสมาชิก(N-ผู้มีสิทธิ)</th>
                <th class="text-center">จัดการ</th>
            </tr>
        </thead>
        <tbody>

            <?php
    if ($numb_rows > 0) {
        $i = 0;
        while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
            ++$i;
            $name =  $row['fname'].' '. $row['lname'];
            $de =  $row['datail'];
            $oid = $row['oid'];
            $sql = $conn->prepare("SELECT COUNT(team_id) AS num FROM person_sub WHERE level = 5 AND head = ".$oid." AND team_id = ".$oid);
            $sql->execute();
            $count_num = $sql->fetchColumn();
            ?>

            <tr>
                <td class="text-center" width="20px"><?php echo $i; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $de; ?></td>
                <td><?php echo $count_num; ?></td>
                <td class="text-center text-nowrap">
                    <!--                     
                    <div class="dropdown">
                        <a href="#" class="btn btn-clean btn-icon" data-bs-toggle="dropdown">
                            <i class="ki ki-bold-more-hor font-size-md"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <ul class="navi navi-hover py-1">

                                <li class="navi-item">
                                    <a href="dashboard.php?module=person&page=treeview&oid=<?php echo $row['oid']; ?>"
                                        class="navi-link">
                                        <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                        <span class="navi-text">สมาชิก</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="#" class="navi-link" onclick='delPersonAera(<?php echo $row["oid"]; ?>)'>
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">ลบ</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                    <!-- <a href="dashboard.php?module=person&page=treeview&oid=<?php echo $row['oid']; ?>" class="navi-link" title="ประวัติการทำรายการ">
                        <span class="navi-icon"><i class="fas fa-user-alt text-primary"></i></span>
                    </a> -->
                    <a href="dashboard.php?module=person&page=person-N&oid=<?php echo $row['oid']; ?>&team_id=<?php echo $row['oid']; ?>"
                        class="navi-link" title="ประวัติการทำรายการ">
                        <span class="navi-icon"><i class="fas fa-user-alt text-primary"></i></span>
                    </a>
                    <a href="#" class="navi-link" onclick='delPersonAera(<?php echo $row["oid"]; ?>)'
                        title="ยกเลิกโครงการ">
                        <span class="navi-icon"><i class="fas fa-trash text-danger"></i></span>
                    </a>

                </td>

            </tr>
            <?php include 'modal-repair-edit-status.php'; ?>

            <?php
        } // end while
    } else {?>
            <tr>
                <td class="text-center" height="50px" colspan="8">ไม่มีข้อมูล</td>
            </tr>
            <?php }
            ?>

        </tbody>
    </table>
</div>
<?php $msg123s = "dup"; ?>