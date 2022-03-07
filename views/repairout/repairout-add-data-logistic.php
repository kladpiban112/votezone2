<?php
session_start();
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$repairid_enc = base64_encode($repairid);

$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$personid_enc = base64_encode($personid);

$conditions = " AND u.repair_id = '$repairid' ";
$stmt_data = $conn->prepare('SELECT u.*,s.logistic_title,t.logistic_transport_title
FROM '.DB_PREFIX.'repair_logistic u 
LEFT JOIN  '.DB_PREFIX.'repair_logistic_type s ON u.logistic_id = s.logistic_typeid
LEFT JOIN  '.DB_PREFIX."repair_logistic_transport t ON u.logistic_by = t.logistic_transport_id
WHERE u.flag != '0' $conditions 
ORDER BY u.oid ASC
$max");
$stmt_data->execute();
$numb_rows = $stmt_data->rowCount();

?>


<div class="table-responsive">
    <table class="table table-bordered table-hover table-strip" id="tbData" style="margin-top: 13px !important">
        <thead>
            <tr>
                <th class="text-center">ลำดับ</th>
                <th>วันที่</th>
                <th>สถานะการส่งซ่อม</th>
                <th>ส่งโดย</th>
                <th>เลขที่ส่ง</th>
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
            $oid = $row['oid'];
            $oid_enc = base64_encode($oid);
            $status_date = date_db_2form($row['logistic_date']);
            $status_title = $row['logistic_title'];
            $status_id = $row['logistic_no'];
            $status_transport = $row['logistic_transport_title'];
            $status_desc = $row['logistic_desc']; ?>




            <tr>
                <td class="text-center" width="20px"><?php echo $i; ?></td>

                <td><?php echo $status_date; ?></td>
                <td><?php echo $status_title; ?></td>
                <td><?php echo $status_transport; ?></td>
                <td><?php echo $status_id; ?></td>

                <td><?php echo $status_desc; ?></td>
                <td class="text-center">
                    <!--begin::Dropdown-->
                    <div class="dropdown">
                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
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
                                    <a href="dashboard.php?module=repairout&page=repairout-edit-data-logistic&repairid=<?php echo $repairid_enc; ?>&personid=<?php echo $personid_enc; ?>&statusid=<?php echo $oid_enc; ?>&act=<?php echo base64_encode('edit'); ?>"
                                        class="navi-link">
                                        <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                        <span class="navi-text">แก้ไข</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="#" class="navi-link" onclick='delLogisticData(<?php echo $oid; ?>)'>
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">ยกเลิกรายการ</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                    <!--end::Dropdown-->

                </td>

            </tr>
            <?php //include 'modal-repairout-edit-status.php';?>

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