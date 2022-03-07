<?php
session_start();
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$serviceid = filter_input(INPUT_POST, 'serviceid', FILTER_SANITIZE_STRING);

$conditions = " AND u.service_id = '$serviceid' ";
$sql = 'SELECT u.*,e.*,c.unit_title 
FROM '.DB_PREFIX.'tools_borrow_data u 
LEFT JOIN '.DB_PREFIX.'spare_main e ON u.spare_id = e.spare_id 
left join '.DB_PREFIX."cunit c ON u.spare_unit = c.unit_id
WHERE u.flag != 0 $conditions 
ORDER BY u.s_oid DESC
$max";
$stmt_data = $conn->prepare($sql);
$stmt_data->execute();

?>


<div class="table-responsive">
    <table class="table table-bordered table-hover table-strip" id="tbData" style="margin-top: 13px !important">
        <thead>
            <tr>
                <th class="text-center">ลำดับ</th>
                <th>รูปภาพ</th>
                <th>รหัส</th>
                <th>ชื่ออุปกรณ์ </th>
                <th>จำนวน</th>
                <th>หน่วยนับ</th>
                <th>รายละเอียด</th>
                <!--<th class="text-center">สถานะ</th>-->
                <th class="text-center">จัดการ</th>
            </tr>
        </thead>
        <tbody>

            <?php

            $i = 0;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
                ++$i;
                $s_oid = $row['s_oid'];
                $oid = $row['oid'];
                $oid_enc = base64_encode($oid);
                $spare_name = $row['spare_name'];
                $spare_desc = $row['spare_desc'];
                $spare_code = $row['spare_code'];
                $org_name = $row['org_name'];
                $spare_quantity = $row['spare_quantity'];
                $receive_date = date_db_2form($row['receive_date']);
                $eq_img = $row['spare_img'];
                $spare_unit = $row['unit_title'];
                $spare_desc = $row['spare_desc'];
                $rec_title = $row['rec_title'];

                $eq_typeid = $row['eq_typeid']; ?>




            <tr>
                <td class="text-center"><?php echo $i; ?></td>
                <td class="text-center">
                    <div class="symbol symbol-50 symbol-lg-60">
                        <?php if ($eq_img == '') {?>
                        <img src="uploads/no-image.jpg" alt="image" />
                        <?php } else {?>
                        <img src="uploads/spare/<?php echo $eq_img; ?>" alt="image" />
                        <?php   } ?>
                    </div>
                </td>
                <td><?php echo $spare_code; ?></td>
                <td><?php echo $spare_name; ?></td>
                <td class="text-center"><?php echo $spare_quantity; ?></td>
                <td class="text-center"><?php echo $spare_unit; ?></td>
                <td><?php echo $spare_desc; ?></td>
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

                                <!-- <li class="navi-item">
                                    <a href="dashboard.php?module=tools&page=tools-print&id=<?php echo $oid_enc; ?>&act=<?php echo base64_encode('view'); ?>"
                                        class="navi-link">
                                        <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                        <span class="navi-text">รายละเอียด</span>
                                    </a>
                                </li> -->

                                <!-- <li class="navi-separator my-3"></li> -->

                                <li class="navi-item">
                                    <a href="#" class="navi-link" onclick='delEquipment(<?php echo $s_oid; ?>)'>
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">ยกเลิก</span>
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
            ?>

        </tbody>
    </table>
</div>