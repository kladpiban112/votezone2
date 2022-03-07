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
$stmt_data = $conn->prepare('SELECT u.*,t.unit_title
FROM '.DB_PREFIX.'repair_spare u 
LEFT JOIN '.DB_PREFIX."cunit t ON u.spare_unit = t.unit_id
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
                <th>อะไหล่/เครื่องมือ</th>
                <th class="text-right">จำนวน</th>
                <th>หน่วย</th>
                <th>ราคา(บาท)</th>
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

            $spare_name = $row['spare_name'];
            $spare_quantity = $row['spare_quantity'];
            $unit_title = $row['unit_title'];
            $spare_price = $row['spare_price'];
            $sum_spare_price += $spare_price; ?>




            <tr>
                <td class="text-center" width="20px"><?php echo $i; ?></td>


                <td><?php echo $spare_name; ?></td>
                <td class="text-right"><?php echo $spare_quantity; ?></td>
                <td><?php echo $unit_title; ?></td>
                <td><?php echo $spare_price; ?></td>
                <!--<td class="text-center"><span class="label label-lg label-light-<?php echo $status_color; ?> label-inline"><?php echo $status_title; ?></span></td>-->
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
                                    <a href="dashboard.php?module=repairout&page=repairout-edit-data-spare&repairid=<?php echo $repairid_enc; ?>&personid=<?php echo $personid_enc; ?>&spareid=<?php echo $oid_enc; ?>&act=<?php echo base64_encode('edit'); ?>"
                                        class="navi-link">
                                        <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                        <span class="navi-text">แก้ไข</span>
                                    </a>
                                </li>

                                <li class="navi-item">

                                    <a href="#" class="navi-link" onclick='delSpareData(<?php echo $oid; ?>)'>
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

            <?php
        } // end while
    } else {?>
            <tr>
                <td class="text-center" height="50px" colspan="8">ไม่มีข้อมูล</td>
            </tr>
            <?php }
            ?>

        </tbody>
        <tfooter>
            <tr>
                <td colspan="5" class="text-right">รวม</td>
                <td><?php echo $sum_spare_price; ?></td>

            </tr>

        </tfooter>
    </table>
</div>