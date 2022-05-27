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

$stmt_data = $conn->prepare('SELECT * FROM '.DB_PREFIX.'mapping_person m
LEFT JOIN  '.DB_PREFIX.'person_main p ON m.oid = p.oid');
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
                <th class="text-center">จัดการ</th>
            </tr>
        </thead>
        <tbody>

            <?php
    if ($numb_rows > 0) {
        $i = 0;
        while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
            ++$i;
            // $oid = $row['oid'];
            // $oid_enc = base64_encode($oid);
            // $status_date = date_db_2form($row['status_date']);
            // $status_title = $row['status_title'];
            // $status_id = $row['status_id'];
            // $status_desc = $row['status_desc'];
            // $staff_name = $row['prename_title'].$row['fname'].' '.$row['lname'].' ('.$row['nickname'].')';

            // $stmt_detail = $conn->prepare("SELECT GROUP_CONCAT(s.fname,' ',s.lname) AS gstaff_name,GROUP_CONCAT(s.oid) AS gstaff_id
            //     FROM ".DB_PREFIX.'repair_staff u 
            //     LEFT JOIN  '.DB_PREFIX."staff_main s ON u.staff_id = s.oid
            //     WHERE u.status_id = '$oid' ");
            // $stmt_detail->execute();
            // $row_detail = $stmt_detail->fetch(PDO::FETCH_ASSOC);
            // $gstaff_name = str_replace(',', '</br>', $row_detail['gstaff_name']);
            // $gstaff_id = $row_detail['gstaff_id'];
            // $gstaff_id_exp = explode(',', $gstaff_id);
            $name =  $row['fname'].' '. $row['lname'];
            $de =  $row['datail'];
            
            ?>

            <tr>
                <td class="text-center" width="20px"><?php echo $i; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $de; ?></td>
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
                                    <a href="dashboard.php?module=repair&page=repair-edit-data-status&repairid=<?php echo $repairid_enc; ?>&personid=<?php echo $personid_enc; ?>&statusid=<?php echo $oid_enc; ?>&act=<?php echo base64_encode('edit'); ?>"
                                        class="navi-link">
                                        <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                        <span class="navi-text">ลบ</span>
                                    </a>
                                </li>

                                <!-- <li class="navi-item">
                                    <a href="#" class="navi-link" onclick='delStatusData(<?php echo $oid; ?>)'>
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">ลบ</span>
                                    </a>
                                </li> -->
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