<?php
$personid = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$serviceid = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid);
$serviceid = base64_decode($serviceid);
$action = base64_decode($act);
if ($action == 'view') {
    $txt_title = 'ดูข้อมูล';
    $action = $action;

    $stmt_data = $conn->prepare('SELECT p.*,o.org_name,pr.prename FROM '.DB_PREFIX.'person_borrow p 
    LEFT JOIN '.DB_PREFIX.'org_main o ON p.org_id = o.org_id 
    LEFT JOIN '.DB_PREFIX."cprename pr ON p.prename = pr.id_prename
    WHERE p.oid = '$personid'  LIMIT 1");
    $stmt_data->execute();
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    $fullname = $row_person['prename'].''.$row_person['fname'].' '.$row_person['lname'];
    $cid = $row_person['cid'];
    $telephone = $row_person['telephone'];

    $sql_service = 'SELECT s.*,t.service_title AS service_typename FROM '.DB_PREFIX.'tools_borrow_main s 
    LEFT JOIN '.DB_PREFIX.'person_borrow p ON s.person_id = p.oid 
    LEFT JOIN '.DB_PREFIX."service_type t ON s.service_type = t.service_typeid
    WHERE s.service_id = '$serviceid' AND s.flag != '0'  LIMIT 1";
    $stmt_service = $conn->prepare($sql_service);
    $stmt_service->execute();
    $row_service = $stmt_service->fetch(PDO::FETCH_ASSOC);

    $servicetype = $row_service['service_type'];
    $servicedate = date_db_2form($row_service['service_date']);
    $service_typename = $row_service['service_typename'];

    if ($servicetype == '1') {
        $servicetype_show = 'ยืม';
    } elseif ($servicetype == '2') {
        $servicetype_show = 'คืน';
    }
} else {
}
?>




<!-- begin::Card-->
<div class="card card-custom overflow-hidden">
    <div class="card-body p-0">
        <div id="printableArea">
            <!-- begin: Invoice-->
            <!-- begin: Invoice header-->
            <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                        <h4 class=" mb-10">เอกสาร<?php echo $servicetype_show; ?>เครื่องมือ</h4>
                        <div class="d-flex flex-column align-items-md-end px-0">
                            <!--begin::Logo-->
                            <a href="#" class="mb-5">
                                <?php
                            $orglogo = getOrgLogo($row_person['org_id']);
                            if ($orglogo == '') {?>
                                <img src="assets/images/logo.png" alt="image" width="50" />
                                <?php } else {?>
                                <img src="uploads/logo/<?php echo $orglogo; ?>" alt="image" width="50">
                                <?php   } ?>
                            </a>
                            <!--end::Logo-->
                            <span class=" d-flex flex-column align-items-md-end opacity-70">
                                <h5><?php echo getOrgName($row_person['org_id']); ?></h5>
                                <span><?php echo getOrgAddr($row_person['org_id']); ?></span>
                                <span>โทรศัพท์ <?php echo getOrgTelephone($row_person['org_id']); ?></span>
                            </span>
                        </div>
                    </div>
                    <div class="border-bottom w-100"></div>
                    <div class="d-flex justify-content-between pt-6">
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">ผู้<?php echo $servicetype_show; ?>เครื่องมือ</span>
                            <span class="opacity-70"><?php echo $fullname; ?></span>
                            <span class="opacity-70">เลขที่บัตรประชาชน : <?php echo $cid; ?></span>
                            <span class="opacity-70">โทรศัพท์ : <?php echo $telephone; ?></span>

                        </div>

                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">วันที่รับบริการ</span>
                            <span class="opacity-70 mb-2"><?php echo $servicedate; ?></span>
                            <span class="font-weight-bolder mb-2">รับบริการ</span>
                            <span class="opacity-70"><?php echo $service_typename; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice header-->

            <!-- begin: Invoice body-->
            <div class="row justify-content-center py-8 px-8 py-md-5 px-md-0">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <?php
                    $conditions = " AND u.service_id = '$serviceid' ";
                    $stmt_data = $conn->prepare('SELECT u.*,e.*,c.unit_title
                    FROM '.DB_PREFIX.'tools_borrow_data u 
                    LEFT JOIN  '.DB_PREFIX.'spare_main e ON u.spare_id = e.spare_id
                    left join '.DB_PREFIX."cunit c ON u.spare_unit = c.unit_id
                    WHERE u.flag != '0' $conditions 
                    ORDER BY u.s_oid DESC
                    $max");
                    $stmt_data->execute();
                    ?>

                        <table class="table table-bordered table-strip" id="" style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th>รูปภาพ</th>
                                    <th>รหัส</th>
                                    <th>ชื่ออุปกรณ์ </th>
                                    <th>จำนวน</th>
                                    <th class="text-center">หน่วยนับ</th>
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
                $eq_name = $row['spare_name'];
                $eq_desc = $row['spare_desc'];
                $eq_code = $row['spare_code'];
                $org_name = $row['org_name'];
                $eq_typename = $row['eq_typename'];
                $receive_date = date_db_2form($row['receive_date']);
                $eq_img = $row['spare_img'];
                $status_title = $row['status_title'];
                $unit_title = $row['unit_title'];
                $spare_quantity = $row['spare_quantity'];

                $eq_typeid = $row['eq_typeid'];
                if ($eq_typeid == 1) {
                    $eq_typeother = '<br>('.$row['eq_typeother'].')';
                } else {
                    $eq_typeother = '';
                } ?>




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
                                    <td><?php echo $eq_code; ?></td>
                                    <td><?php echo $eq_name; ?></td>
                                    <td class="text-center"><?php echo $spare_quantity; ?></td>
                                    <td class="text-center"><?php echo $unit_title; ?> </td>


                                </tr>

                                <?php
            } // end while
            ?>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <!-- end: Invoice body-->

            <!-- begin: Invoice footer-->
            <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    หมายเหตุ :
                </div>
            </div>
            <!-- end: Invoice footer-->

        </div>

        <!-- begin: Invoice action-->
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                <div class="d-flex justify-content-between">
                    <!--<button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Invoice</button>
                    <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Invoice</button>-->

                    <!--<button type="button" class="btn btn-light-primary font-weight-bold" onclick="printDiv('printableArea')">ดาวน์โหลดเอกสาร</button>-->
                    <button type="button" class="btn btn-secondary btn-sm" onclick="javascript:history.back()"><i
                            class="fa fa-chevron-left" title="ย้อนกลับ"></i> ย้อนกลับ</button>
                    <button type="button" class="btn btn-success btn-sm font-weight-bold"
                        onclick="printDiv('printableArea')"><i class="fa fa-print" title=""></i> พิมพ์เอกสาร</button>
                </div>
            </div>
        </div>
        <!-- end: Invoice action-->

        <!-- end: Invoice-->
    </div>
</div>
<!-- end::Card-->
</div>
<!-- end::Card-->






<script>
$(document).ready(function() {
    'use strict';
});



function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>