
<?php
$personid = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_GET, 'repairid', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid);
$repairid = base64_decode($repairid);
$id = base64_decode($id);
$action = base64_decode($act);
if($action == "view"){
	$txt_title = "ดูข้อมูล";
	$action = $action;

	$stmt_data = $conn->prepare ("SELECT p.*,o.org_name,pr.prename FROM ".DB_PREFIX."person_main p 
    LEFT JOIN ".DB_PREFIX."org_main o ON p.org_id = o.org_id 
    LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
    WHERE p.oid = '$personid'  LIMIT 1");
    $stmt_data->execute();	
    $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    $fullname = $row_person['prename']."".$row_person['fname']." ".$row_person['lname'];
    $cid = $row_person['cid'];
    $telephone = $row_person['telephone'];
    $person_type = $row_person['person_type'];  // 1 บุคคล 2 บริษัท
    $comp_name = $row_person['comp_name'];
  
  
    $sql_service = "SELECT s.*,t.repair_typetitle FROM ".DB_PREFIX."repair_main s 
    LEFT JOIN ".DB_PREFIX."person_main p ON s.person_id = p.oid
    LEFT JOIN  ".DB_PREFIX."repair_type t ON s.repair_type = t.repair_typeid
    WHERE s.repair_id = '$repairid' AND s.flag != '0'  LIMIT 1";
    $stmt_service = $conn->prepare ($sql_service);
    $stmt_service->execute();	
	$row_service = $stmt_service->fetch(PDO::FETCH_ASSOC);
  
    $repairdate = date_db_2form($row_service['repair_date']);
    $repair_code = $row_service['repair_code']; // 
    $repair_typetitle = $row_service['repair_typetitle']; // 

    $approve_date = date_db_2form($row_service['approve_date']);
    $approve_username = $row_service['approve_username']; // 
    $user_add = $row_service['add_users']; // 


    $return_date = date_db_2form($row_service['return_date']);
    $return_username = $row_service['return_username']; // 


    $stmt_payment = $conn->prepare('SELECT u.*,pt.docname,pm.m_title
FROM '.DB_PREFIX.'payment_trans u 
LEFT JOIN  '.DB_PREFIX.'payment_type pt ON u.payment_type = pt.doctype
LEFT JOIN  '.DB_PREFIX."payment_method pm ON u.payment_method = pm.m_id 
WHERE u.id = '$id' 
ORDER BY u.id ASC
$max");
$stmt_payment->execute();
$row_payment = $stmt_payment->fetch(PDO::FETCH_ASSOC);

$payment_date = date_db_2form($row_payment['payment_date']);
            $payment_no = $row_payment['payment_no'];
            $payment_type = $row_payment['payment_type'];
            $doc_no = $payment_type.$payment_no;
            $docname = $row_payment['docname'];
            $method_payment = $row_payment['m_title'];
            $amount = $row_payment['amount'];
            $user_payment = $row_payment['add_users'];


}else{
	
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
                    <h4 class=" ">ใบเสร็จรับเงิน / Receipt</h4>
                    
                    <div class="d-flex flex-column align-items-md-end px-0">
                        <!--begin::Logo-->
                        <a href="#" class="mb-5">
                            <?php 
                            $orglogo = getOrgLogo($row_person['org_id']);
                            if($orglogo == ""){?>
                                <img src="assets/images/logo.png" alt="image"  width="50"/>
                            <?php }else{?>
                                <img src="uploads/logo/<?php echo $orglogo;?>" alt="image" width="50">
                                <?php   } ?>
                        </a>
                        <!--end::Logo-->
                        <span class=" d-flex flex-column align-items-md-end opacity-70">
                            <h5><?php echo getOrgName($row_person['org_id']);?></h5>
                            <span><?php echo getOrgAddr($row_person['org_id']);?></span>
                            <span>โทรศัพท์ <?php echo getOrgTelephone($row_person['org_id']);?></span>
                        </span>
                    </div>
                </div>


                <div class="border-bottom w-100"></div>
                <div class="d-flex justify-content-between pt-6">
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">ข้อมูลลูกค้า</span>
                        <span class="opacity-70"><?php echo $fullname;?></span>
                        <span class="opacity-70">บริษัท : <?php echo $comp_name;?></span>
                        <span class="opacity-70">เลขที่บัตรประชาชน/เลขผู้เสียภาษี : <?php echo $cid;?></span>
                        <span class="opacity-70">โทรศัพท์ : <?php echo $telephone;?></span>
                        <span class="opacity-70">ที่อยู่ : <?php  echo getPersonAddr($personid);?></span>
                    </div>
               
                   <div class="d-flex flex-column flex-root">
                        <!--<span class="font-weight-bolder mb-2">วันที่แจ้ง</span>
                        <span class="opacity-70 mb-2"><?php echo $repairdate;?></span>
                        <span class="font-weight-bolder mb-2">ประเภทการแจ้ง</span>
                        <span class="opacity-70"><?php echo $repair_typetitle;?></span>-->
                    </div>
                    <div class="d-flex flex-column flex-root">
                        <span class="font-weight-bolder mb-2">เลขที่</span>
                        <span class="opacity-70 mb-2"><?php echo $doc_no;?></span>
                        <span class="font-weight-bolder mb-2">วันที่ออกเอกสาร</span>
                        <span class="opacity-70"><?php echo $payment_date;?></span>
                        <span class="font-weight-bolder mb-2">ผู้ออกเอกสาร</span>
                        <span class="opacity-70">(&nbsp;&nbsp;<?php echo getUsername($user_payment);?>&nbsp;&nbsp;)</span>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Invoice header-->

        <!-- begin: Invoice body-->
        <div class="row justify-content-center py-8 px-8 py-md-5 px-md-0">
            <div class="col-md-9">
                <div class="table-responsive">
                
<span class="font-weight-bolder mb-2">รายละเอียด</span>
<table class="table table-bordered table-strip" id="tbData" style="margin-top: 13px !important">
    <thead>
    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>รายการ</th>
                        <th>จำนวน</th>
    </thead>
    <tbody>

                <tr>
                            <td class="text-center" width="20px">1.</td>
                            <td><?php echo $docname;?></td>
                            <td ><?php echo number_format($amount,2);?></td>
                </tr>

               
            </tbody>
            <tfooter>
                    <tr>
                            <td class="text-center" colspan="2"><b><?php echo bahtText($amount);?></b></td>
                            <td ><?php echo number_format($amount,2);?></td>
                </tr>
            </tfooter>
            </table>

            
                </div>





            </div>
        </div>
        <!-- end: Invoice body-->


        

        <!-- begin: Invoice footer-->
        <!--<div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                หมายเหตุ : 
                <?php 
                if($return_date != ''){
                    echo "วันที่รับคืน : ".$return_date;
                    echo " ผู้รับคืน : ".$return_username;
                }
                
                ?>
            </div>
        </div>-->
        <!-- end: Invoice footer-->

        </div>

        <!-- begin: Invoice action-->
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                <div class="d-flex justify-content-between">
                    <!--<button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Invoice</button>
                    <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Invoice</button>-->

                    <!--<button type="button" class="btn btn-light-primary font-weight-bold" onclick="printDiv('printableArea')">ดาวน์โหลดเอกสาร</button>-->
                    <button type="button" class="btn btn-secondary btn-sm" onclick="javascript:history.back()" ><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i> ย้อนกลับ</button>
                    <button type="button" class="btn btn-success btn-sm font-weight-bold" onclick="printDiv('printableArea')"><i class="fa fa-print" title="" ></i> พิมพ์เอกสาร</button>
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
