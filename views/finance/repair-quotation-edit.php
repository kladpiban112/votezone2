<?php
$personid = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_GET, 'repairid', FILTER_SANITIZE_STRING);
$qtid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid);
$repairid = base64_decode($repairid);
$qtid = base64_decode($qtid);
$action = base64_decode($act);
if($action == "edit"){
	$txt_title = "แก้ไข";
	$action = $action;

$conditions = " AND u.oid = '$qtid' ";
$stmt_data = $conn->prepare ("SELECT u.*
FROM ".DB_PREFIX."repair_quotation u 
WHERE u.flag != '0' $conditions 
ORDER BY u.oid ASC
$max");
$stmt_data->execute();	
$numb_rows = $stmt_data->rowCount();	

$row = $stmt_data->fetch(PDO::FETCH_ASSOC);
$oid = $row['oid'];
                $oid_enc = base64_encode($oid);

                $qt_date = date_db_2form($row['qt_date']);
                $qtcode = $row['qt_code'];
                $qtprice = $row['qt_price'];
                $qtusers = $row['qt_users'];
                $qtnote = $row['qt_note'];
                $qtstatus = $row['qt_status'];
                $qtapprovedate = date_db_2form($row['qt_approvedate']);
                $qtvat = $row['qt_vat'];
                $qtapproveusers = $row['qt_approveusers'];
                $qtdayexp = $row['qt_dayexp'];



}else{
	$txt_title = "เพิ่ม";
	$action = "add";
}
?>



		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header ribbon ribbon-right">
      
				<h3 class="card-title">
        <i class="fas fa-edit"></i>&nbsp;<?php echo $txt_title;?>ใบเสนอราคา 
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="#" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ" onclick="javascript:history.back()"><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></a>
					</div>
				</div>
			</div>


<form class="form" enctype="multipart/form-data" >
<input type="hidden" class="form-control"  name="act" id="act" value="<?php echo $action;?>"/>
<input type="hidden" class="form-control"  name="repairid" id="repairid" value="<?php echo $repairid;?>"/>
<input type="hidden" class="form-control"  name="personid" id="personid" value="<?php echo $personid;?>"/>
<input type="hidden" class="form-control"  name="qtid" id="qtid" value="<?php echo $qtid;?>"/>
	<div class="card-body">

	
	<div class="row">
	<div class="col-lg-12">

 
                                      <div class="form-group row">

                                      <div class="col-lg-2">
                                          <label>เลขที่ใบเสนอราคา</label>
                                          <input type="text" class="form-control"  name="qtcode" id="qtcode"   value="<?php echo $qtcode;?>" disabled/>
                                        </div>

                                        <div class="col-lg-2">
                                          <label>วันที่เสนอราคา</label>
                                          <input type="text" class="form-control"  name="qtdate" id="qtdate" data-date-language="th-th" maxlength="10"  placeholder="" value="<?php echo $qt_date;?>" disabled/>
                                        </div>

                                        <div class="col-lg-2">
                                              <label>จำนวนวันใบเสนอราคา</label>
                                              <input type="number" class="form-control"  name="qtdayexp" id="qtdayexp" placeholder="" value="<?php echo $qtdayexp;?>"/>
                                            </div>



                                           <div class="col-lg-2">
                                              <label>จำนวนเงิน(บาท)</label>
                                              <input type="number" class="form-control"  name="qtprice" id="qtprice" placeholder="" value="<?php echo $qtprice;?>"/>
                                            </div>

                                            <div class="col-lg-2">
                                              <label>%VAT</label>
                                              <input type="number" class="form-control"  name="qtvat" id="qtvat" placeholder="" value="<?php echo $qtvat;?>"/>
                                            </div>

                                            </div>
<div class="form-group row">
                                            <div class="col-lg-12">
                                              <label>ผู้เสนอราคา</label>
                                              <select class="form-control " name="qtusers" id="qtusers" >
                                                          
                                                          <option value="">ระบุ</option>
                                                          <?php
                                               
                                                            $stmt_user_role = $conn->prepare("SELECT s.* FROM ".DB_PREFIX."users s 
                                                            WHERE s.org_id = '$logged_org_id' AND s.active = '1'  ");
                                                            $stmt_user_role->execute();		
                                                            while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                                                              {
                                                              $id_selected = $row['user_id'];
                                                              $title_selected = stripslashes($row['name']);
                                                              ?>
                                                              <option value="<?php echo $id_selected;?>" <?php if($qtusers = $id_selected){echo "selected";}?>  ><?php echo $title_selected;?></option>
                                                              <?php
                                                              }
                                                            ?>
                                                          
                                              </select>
                                              
                                            </div>
                                      </div>

                                      <div class="form-group row">

                                            <div class="col-lg-3">
                                              <label>สถานะเอกสาร</label>
                                              <select class="form-control " name="qtstatus" id="qtstatus" >
                                                          
                                                          <option value="">ระบุ</option>
                                                          <?php
                                               
                                                            $stmt_user_role = $conn->prepare("SELECT s.* FROM ".DB_PREFIX."repair_quotation_status s ");
                                                            $stmt_user_role->execute();		
                                                            while ($rowsts = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                                                              {
                                                              $qt_statusid = $rowsts['qt_statusid'];
                                                              $title_selected = stripslashes($rowsts['qt_statusname']);
                                                              ?>
                                                              <option value="<?php echo $qt_statusid;?>" <?php if($qtstatus == $qt_statusid){echo "selected";}?>  ><?php echo $title_selected;?></option>
                                                              <?php
                                                              }
                                                            ?>
                                                          
                                              </select>
                                              
                                            </div>


                                        <div class="col-lg-2">
                                          <label>วันที่อนุมัติซ่อม</label>
                                          <input type="text" class="form-control"  name="qtapprovedate" id="qtapprovedate" data-date-language="th-th" maxlength="10"  placeholder="" value="<?php echo $qtapprovedate;?>"/>
                                        </div>

                                        <div class="col-lg-4">
                                              <label>ผู้อนุมัติ</label>
                                              <select class="form-control " name="qtapproveusers" id="qtapproveusers" >
                                                          
                                                          <option value="">ระบุ</option>
                                                          <?php
                                               
                                                            $stmt_user_role = $conn->prepare("SELECT s.* FROM ".DB_PREFIX."users s 
                                                            WHERE s.org_id = '$logged_org_id' AND s.active = '1'  ");
                                                            $stmt_user_role->execute();		
                                                            while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                                                              {
                                                              $id_selected_ap = $row['user_id'];
                                                              $title_selected_ap = stripslashes($row['name']);
                                                              ?>
                                                              <option value="<?php echo $id_selected_ap;?>" <?php if($qtapproveusers == $id_selected_ap){echo "selected";}?>  ><?php echo $title_selected_ap;?></option>
                                                              <?php
                                                              }
                                                            ?>
                                                          
                                              </select>
                                              
                                            </div>

                                            

                                      </div>

                                      

                                      <div class="form-group row">
                                        <div class="col-lg-12">
                                          <label>หมายเหตุ</label>
                                          <textarea class="form-control "  name="qtnote" id="qtnote"><?php echo $qtnote;?></textarea>
                                        </div>
                                        </div>

		</div><!--col-->

		
		


		</div><!--col-->
		</div><!--row-->



	<div class="card-footer">
		<div class="row">
			<div class="col-lg-6">
				<button type="button" class="btn btn-primary mr-2" id="btnEditQt"><i class="fa fa-save" title="บันทึก" ></i> บันทึก</button>
				<button type="button" class="btn btn-warning" onclick="javascript:history.back()" ><i class="fa fa-chevron-left " title="ย้อนกลับ" ></i></button>
			</div>
			<div class="col-lg-6 text-right">
				<!--<button type="reset" class="btn btn-danger">Delete</button>-->
			</div>
		</div>
	</div>
</form>

</div>
		<!--end::Card-->


<script>
$(document).ready(function () {
    'use strict';
}); 

$('#qtapprovedate').datepicker({
        autoclose: true
});

$('#qtdate').datepicker({
        autoclose: true
});


$('#btnEditQt').click(function(e){
        e.preventDefault();
        if ($('#repairid').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาทำรายการ',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#qtprice').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุค่าซ่อม',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else {

		var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/finance/repair-quotation-edit.php",
            dataType: "json",
			data: data,
			processData: false,
            contentType: false,
            success: function(data) {  
              if (data.code == "200") {
                Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ',
                showConfirmButton: false,
                timer: 1500
                })
                    .then((value) => {
                      //$('#status_id').val('');
                      //$('#statusdate').val('');
                      //$('#staff_id').val('');
                      //$('#status_desc').val('');
                      //loaddata_status_data();

                      window.location.replace("dashboard.php?module=finance&page=repair-quotation-add&personid="+data.personid+"&repairid="+data.repairid+"&act="+data.act);
                    
                }); 
                } else if (data.code == "404") {
                  //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                   Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถบันทึกข้อมูลได้',
                    text: 'กรุณาลองใหม่อีกครั้ง'
                    })
                    .then((value) => {
                      //liff.closeWindow();
                  });
                }
            } // success
        });

        }
    
      }); //  click


</script>



