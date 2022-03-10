<?php
error_reporting(0);

$personid_enc = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$repairid_enc = filter_input(INPUT_GET, 'repairid', FILTER_SANITIZE_STRING);
$qtid_enc = filter_input(INPUT_GET, 'qtid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid_enc);
$repairid = base64_decode($repairid_enc);
$qtid = base64_decode($qtid_enc);
$action = base64_decode($act);
if ($action == 'view') {
    $txt_title = 'ดูข้อมูล';
    $action = $action;

    $stmt_data = $conn->prepare('SELECT p.*,o.org_name,pr.prename FROM '.DB_PREFIX.'person_main p 
    LEFT JOIN '.DB_PREFIX.'org_main o ON p.org_id = o.org_id 
    LEFT JOIN '.DB_PREFIX."cprename pr ON p.prename = pr.id_prename
    WHERE p.oid = '$personid'  LIMIT 1");
    $stmt_data->execute();
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    $fullname = $row_person['prename'].''.$row_person['fname'].' '.$row_person['lname'];
    $cid = $row_person['cid'];
    $telephone = $row_person['telephone'];
    $person_type = $row_person['person_type'];  // 1 บุคคล 2 บริษัท
    $comp_name = $row_person['comp_name'];

    $sql_service = 'SELECT s.*,t.repair_typetitle,qt.qt_code,qt.qt_date,qt.qt_price,qt.qt_approvedate,qt.oid AS qt_id ,qt.qt_vat,qt.qt_vatprice,qt.qt_pricetotal,qt.qt_dayexp
    FROM '.DB_PREFIX.'repair_main s 
    LEFT JOIN '.DB_PREFIX.'person_main p ON s.person_id = p.oid
    LEFT JOIN  '.DB_PREFIX.'repair_type t ON s.repair_type = t.repair_typeid
    LEFT JOIN '.DB_PREFIX."repair_quotation qt ON s.repair_id = qt.repair_id AND qt.flag = '1'
    WHERE s.repair_id = '$repairid' AND qt.oid = '$qtid'   AND s.flag != '0'  LIMIT 1";
    $stmt_service = $conn->prepare($sql_service);
    $stmt_service->execute();
    $row_service = $stmt_service->fetch(PDO::FETCH_ASSOC);

    $repairdate = date_db_2form($row_service['repair_date']);
    $repair_code = $row_service['repair_code'];
    $repair_typetitle = $row_service['repair_typetitle'];

    $approve_date = date_db_2form($row_service['approve_date']);
    $approve_username = $row_service['approve_username'];
    $user_add = $row_service['add_users'];

    $return_date = date_db_2form($row_service['return_date']);
    $return_username = $row_service['return_username'];

    $qt_id = $row_service['oid'];
    $qt_id_enc = base64_encode($qt_id);
    $qt_statusname = $row_service['qt_statusname'];
    $qt_date = date_db_2form($row_service['qt_date']);
    $qt_code = $row_service['qt_code'];
    $qt_price = $row_service['qt_price'];
    $qt_approvedate = date_db_2form($row_service['qt_approvedate']);
    $qt_vat = $row_service['qt_vat'];
    $qt_vatprice = $row_service['qt_vatprice'];
    $qt_pricetotal = $row_service['qt_pricetotal'];
    $qt_dayexp = $row_service['qt_dayexp'];
} else {
}
?>




<!-- begin::Card-->
<div class="card card-custom overflow-hidden">
    <div class="card-body p-0">
        <div id="printableArea">
            <!-- begin: Invoice-->
            <!-- begin: Invoice header-->
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
                        <h4 class=" ">ใบเสนอราคา / Quotation <br>
                            <p class=" ">เลขที่ : <?php echo $qt_code; ?></p>
                        </h4>

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
                            <span class="font-weight-bolder mb-2">ลูกค้า</span>
                            <span class="opacity-70"><?php echo $fullname; ?></span>
                            <span class="opacity-70">บริษัท : <?php echo $comp_name; ?></span>
                            <span class="opacity-70">เลขที่บัตรประชาชน/เลขผู้เสียภาษี : <?php echo $cid; ?></span>
                            <span class="opacity-70">โทรศัพท์ : <?php echo $telephone; ?></span>
                            <span class="opacity-70">ที่อยู่ : <?php  echo getPersonAddr($personid); ?></span>
                        </div>

                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">วันที่เสนอราคา</span>
                            <span class="opacity-70 mb-2"><?php echo $qt_date; ?></span>

                        </div>

                        <div class="d-flex flex-column flex-root">
                            <!-- <span class="font-weight-bolder mb-2">ผู้รับแจ้ง</span>
                        <span class="opacity-70 mb-2"><?php echo getUsername($user_add); ?></span>
                        <span class="font-weight-bolder mb-2">ผู้อนุมัติดำเนินการซ่อม</span>
                        <span class="opacity-70">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</span>
                        <span class="opacity-70"><?php echo $approve_username; ?></span>
                        <span class="font-weight-bolder mb-2">วันที่อนุมัติแจ้งซ่อม</span>
                        <span class="opacity-70"><?php echo $approve_date; ?></span> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice header-->

            <!-- begin: Invoice body-->
            <div class="row justify-content-center py-8 px-8 py-md-5 px-md-0">
                <div class="col-md-9">






                    <div class="table-responsive">


                        <span class="font-weight-bolder mb-2">รายละเอียดการซ่อม</span>
                        <table class="table table-bordered table-hover table-strip" id="tbData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th width="400px">รายละเอียด</th>
                                    <th class="text-right" width="200px">จำนวน</th>
                                    <th class="text-center" width="200px">หน่วย</th>
                                    <th class="text-right" width="200px">ราคา/หน่วย</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" width="20px">1.</td>
                                    <td>ค่าซ่อม</td>
                                    <td class="text-right"><?php echo $qt_price; ?></td>
                                    <td class="text-center">1</td>
                                    <td class="text-right"><?php echo $qt_price; ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="4">รวมเงิน</td>
                                    <td class="text-right"><?php echo $qt_price; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="4">ภาษีมูลค่าเพิ่ม <?php echo $qt_vat; ?>%</td>
                                    <td class="text-right"><?php echo $qt_vatprice; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center" colspan="3">(
                                        <?php echo ThaiBahtConversion($qt_pricetotal); ?> )</td>
                                    <td class="text-right">รวมเป็นเงินทั้งสิ้น</td>
                                    <td class="text-right"><?php echo $qt_pricetotal; ?></td>
                                </tr>
                            </tfoot>
                        </table>


                    </div>



                </div>
            </div>
            <!-- end: Invoice body-->




            <!-- begin: Invoice footer-->
            <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    หมายเหตุ : ใบเสนอราคานี้ สามารถใช้งานได้ภายใน <?php echo $qt_dayexp; ?> วัน นับจากวันที่เสนอราคา

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

                    <a href="././pdfprint/finance/rpt-repair-quatation.php?personid=<?php echo $personid_enc; ?>&repairid=<?php echo $repairid_enc; ?>&qtid=<?php echo $qtid_enc; ?>&act=<?php echo base64_encode('view'); ?>"
                        class="btn btn-success btn-sm font-weight-bold" target="_blank"><i class="fa fa-print"
                            title=""></i> พิมพ์เอกสาร</a>
                    <!-- <button type="button" class="btn btn-success btn-sm font-weight-bold"
                        onclick="printDiv('printableArea')"><i class="fa fa-print" title=""></i> พิมพ์เอกสาร</button> -->



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