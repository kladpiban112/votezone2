<?php
error_reporting(0);
session_start();
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$aid = filter_input(INPUT_POST, 'aid', FILTER_SANITIZE_STRING);
$aid_enc = base64_encode($aid);
$person_num = 0;
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$personid_enc = base64_encode($personid);

$stmt_data = $conn->prepare('SELECT *,COUNT(pm.team_id) AS count_num FROM mapping_person mp 
LEFT JOIN area a ON a.aid = mp.aid
LEFT JOIN person_main pm ON mp.oid = pm.team_id
WHERE mp.aid = '.$aid.' GROUP BY pm.team_id');
$stmt_data->execute();
$numb_rows = $stmt_data->rowCount();

?>


<div class="table-responsive" style="max-height:650px;">
    <table class="table table-bordered table-hover table-strip" id="tbData" style="">
        <thead style="position: sticky; top: 0; z-index: 1;background:#eee;">
            <tr>
                <th class="text-center">ลำดับ</th>
                <th>ชื่อ-สกุล</th>
                <th>รายละเอียด</th>
                <th>จำนวนสมาชิก(รวมตนเอง)</th>
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
            $count_num =  $row['count_num'];
            $person_num = $person_num + $conut_num ;
            ?>

            <tr>
                <td class="text-center" width="20px"><?php echo $i; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $de; ?></td>
                <td><?php echo $count_num; ?></td>
                <td class="text-center">
                    <!--begin::Dropdown-->
                    <div class="dropdown">
                        <a href="#" class="btn btn-clean btn-icon" data-bs-toggle="dropdown">
                            <i class="ki ki-bold-more-hor font-size-md"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover py-1">

                                <li class="navi-item">
                                    <!--<a href="#" class="navi-link"  data-toggle="modal" data-target="#modal_edit_status_<?php echo $oid; ?>">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไข</span>
                                            </a>-->
                                    <a href="dashboard.php?module=person&page=treeview&oid=<?php echo $row['oid']; ?>"
                                        class="navi-link">
                                        <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                        <span class="navi-text">สมาชิก</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="#" class="navi-link" onclick='delperson(<?php echo $row["oid"]; ?>)'>
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">ลบ</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                    <!--end::Dropdown-->

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