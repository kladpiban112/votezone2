<?php
error_reporting(0);

$personid = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$repairid = filter_input(INPUT_GET, 'repairid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid);
$repairid = base64_decode($repairid);
$action = base64_decode($act);
if($action == "edit"){
	$txt_title = "แก้ไข";
	$action = $action;

	$stmt_data = $conn->prepare ("SELECT p.*,o.org_name FROM ".DB_PREFIX."person_main p 
	LEFT JOIN ".DB_PREFIX."org_main o ON p.org_id = o.org_id 
  WHERE p.oid = '$personid'  LIMIT 1");
  $stmt_data->execute();	
  $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);
  
   $sql_service = "SELECT s.* FROM ".DB_PREFIX."repair_main s 
	LEFT JOIN ".DB_PREFIX."person_main p ON s.person_id = p.oid 
    WHERE s.repair_id = '$repairid' AND s.flag != '0'  LIMIT 1";
  $stmt_service = $conn->prepare ($sql_service);
  $stmt_service->execute();	
	$row_service = $stmt_service->fetch(PDO::FETCH_ASSOC);

}else{
	$txt_title = "เพิ่ม";
	$action = "add";
}
?>



		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header ribbon ribbon-right">
      <div class="ribbon-target bg-danger" style="top: 10px; right: -2px;"></div>
				<h3 class="card-title">
        <i class="fas fa-cash-register"></i>&nbsp;บันทึกการชำระเงิน 
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="dashboard.php?module=<?php echo $module;?>" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></a>
					</div>
				</div>
			</div>


<form class="form" enctype="multipart/form-data" >
<input type="hidden" class="form-control"  name="act" id="act" value="<?php echo $action;?>"/>
<input type="hidden" class="form-control"  name="repairid" id="repairid" value="<?php echo $repairid;?>"/>
<input type="hidden" class="form-control"  name="personid" id="personid" value="<?php echo $personid;?>"/>
<input type="hidden" class="form-control"  name="org_id" id="org_id" value="<?php echo $row_service['org_id'];?>"/>
	<div class="card-body">

	
	<div class="row">
	<div class="col-lg-6">
  <span><i class="far fa-user"></i> ข้อมูลผู้แจ้งซ่อม</span>
  <hr>      

  <div class="form-group row">
			<div class="col-lg-3">
				<label>เลขบัตรประชาชน</label>
				
							<input type="text" class="form-control" placeholder="เลขบัตรประชาชน 13 หลัก"  name="cid" id="cid" maxlength="13" value="<?php echo $row_person['cid'];?>" disabled/>
							
						
			</div>

			<div class="col-lg-6">
				<label>ชื่อผู้แจ้งซ่อม</label>
				<input type="text" class="form-control"  name="fullname" id="fullname" placeholder="ชื่อผู้แจ้งซ่อม" value="<?php echo $row_person['fullname'];?>" disabled/>
				
			</div>
			<div class="col-lg-3">
				<label>โทรศัพท์</label>
				<input type="text" class="form-control"  name="telephone" id="telephone" placeholder="โทรศัพท์" value="<?php echo $row_person['telephone'];?>" disabled/>
				
			</div>

    </div>
    <div class="form-group row">
    <div class="col-lg-12">
				<label>หน่วยงาน/บริษัท</label>
				<input type="text" class="form-control"  name="comp_name" id="comp_name" placeholder="หน่วยงาน/บริษัท" value="<?php echo $row_person['comp_name'];?>" disabled/>
				
			</div>
      

    </div>
    

    <span><i class="far fa-bookmark"></i> ข้อมูลแจ้งซ่อม</span>
    <hr>   
    <div class="form-group row">

            <div class="col-lg-3">
				<label>เลขที่แจ้งซ่อม</label>
				<input type="text" class="form-control"  name="repair_code" id="repair_code" placeholder="" value="<?php echo $row_service['repair_code'];?>"  disabled />
				<span class="form-text text-muted"></span>
				
			</div>

            <div class="col-lg-3">
				<label>วันที่แจ้งซ่อม</label>
				<input type="text" class="form-control"  name="repairdate" id="repairdate" placeholder="วันที่รับบริการ" value="<?php echo date_db_2form($row_service['repair_date']);?>"  data-date-language="th-th" maxlength="10" disabled/>
				<span class="form-text text-muted"></span>
				
			</div>

            <div class="col-lg-3">
				<label>ประเภทการซ่อม</label>
                    <select class="form-control " name="repair_type" id="repair_type"  disabled>
                    <?php
				
					$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."repair_type  ");
					$stmt_user_role->execute();		
					while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
						{
						$id_selected = $row['repair_typeid'];
						$title_selected = stripslashes($row['repair_typetitle']);
						?>
						<option value="<?php echo $id_selected;?>" <?php if($row_service['repair_type'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
						<?php
						}
					?>
                    </select>
			</div>

      <div class="col-lg-3">
				<label>สถานที่ซ่อม</label>
                    <select class="form-control " name="repair_place" id="repair_place" disabled >
                    <?php
				
					$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."repair_place  ");
					$stmt_user_role->execute();		
					while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
						{
						$id_selected = $row['place_id'];
						$title_selected = stripslashes($row['place_title']);
						?>
						<option value="<?php echo $id_selected;?>" <?php if($row_service['repair_place'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
						<?php
						}
					?>
                    </select>
            </div>
            </div>

    <div class="form-group row">
        <div class="col-lg-3">
				<label>รูปแบบการซ่อม</label>
                    <select class="form-control " name="repair_out" id="repair_out"  disabled>

            <option value="I" <?php if($row_service['repair_out'] == 'I' ){echo "selected";} ?>>ซ่อมเอง</option>
            <option value="O" <?php if($row_service['repair_out'] == 'O' ){echo "selected";} ?>>ส่งซ่อมภายนอก</option>
						
                    </select>
        </div>

        <div class="col-lg-3">
				<label>วันที่ส่งซ่อมภายนอก</label>
				<input type="text" class="form-control"  name="repairoutdate" id="repairoutdate" placeholder="วันที่ส่งซ่อมภายนอก" value="<?php echo date_db_2form($row_service['repair_outdate']);?>"  data-date-language="th-th" maxlength="10" disabled/>
				<span class="form-text text-muted"></span>
				
      </div>
      
      <div class="col-lg-6">
				<label>เลขที่ส่งซ่อมภายนอก</label>
				<input type="text" class="form-control"  name="repair_outcode" id="repair_outcode" placeholder="" value="<?php echo $row_service['repair_outcode'];?>"  disabled />
				<span class="form-text text-muted"></span>
				
			</div>



    </div>
    

        <span><i class="fas fa-user-cog"></i> รายละเอียดการแจ้งซ่อม</span>
        <hr>  

        <div class="form-group row">
          <div class="col-lg-12">
            <label>เรื่องแจ้งซ่อม</label>
                <input type="text" class="form-control" placeholder=""  name="repair_title" id="repair_title" value="<?php echo $row_service['repair_title'];?>" disabled/>
          </div>
        </div>

        <div class="form-group row">
        <div class="col-lg-4">
        <label>คลังอุปกรณ์</label>
            <select class="form-control " name="eq_id" id="eq_id" disabled>
                        <option value="">ระบุ</option>
                        
                        <?php
              if($logged_user_role_id == '1'){
                $conditions = " ";
              }else{
                $conditions = " AND org_id = '$logged_org_id' ";
              }
              $stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."equipment_main WHERE flag != 0  $conditions  ");
              $stmt_user_role->execute();		
              while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                {
                $id_selected = $row['oid'];
                $eq_code = $row['eq_code'];
                $title_selected = stripslashes($row['eq_name']);
                ?>
                <option value="<?php echo $id_selected;?>" <?php if($row_service['eq_id'] == $id_selected ){echo "selected";} ?>><?php echo "[".$eq_code."] ".$title_selected;?></option>
                <?php
                }
              ?>
              <option value="0" <?php if($row_service['eq_id'] == 0 ){echo "selected";} ?>>อุปกรณ์อื่น ๆ ระบุ</option>
            </select>
        </div>
          <div class="col-lg-4">
            <label>ชื่ออุปกรณ์(อื่นๆ)</label>
                <input type="text" class="form-control" placeholder=""  name="eq_name" id="eq_name" value="<?php echo $row_service['eq_name'];?>" disabled/>
          </div>
          <div class="col-lg-4">
            <label>รหัสอุปกรณ์(อื่นๆ)</label>
                <input type="text" class="form-control" placeholder=""  name="eq_code" id="eq_code" value="<?php echo $row_service['eq_code'];?>" disabled/>
          </div>

        </div>

        <div class="form-group row">
            <div class="col-lg-12">
              <label>รายละเอียด/อาการแจ้งซ่อม</label>
              <textarea rows="" class="form-control editor" name="repair_desc" id="repair_desc" disabled><?php echo $row_service['repair_desc'];?></textarea>
            </div>
		    </div>

        <span><i class="fas fa-camera"></i> รูปถ่ายอุปกรณ์แจ้งซ่อม </span>
        <hr> 

         <div class="form-group row">

                <?php 

                          $sql_files = "SELECT * FROM ".DB_PREFIX."repair_files WHERE repair_id = '$repairid' AND file_status = '1' ORDER BY file_id ASC ";
                          $stmt_files = $conn->prepare ($sql_files);
                          $stmt_files->execute();
                                          
                          while ($row_files = $stmt_files->fetch(PDO::FETCH_ASSOC)){
                            $file_id = $row_files['file_id'];
                            $file_name = $row_files['file_name'];
                            ?>

                  <div class="col-lg-6">
                  
                  <div class="symbol symbol-150 mr-3">
                  <img src="uploads/repair/<?php echo $file_name;?>" alt="image" class="img img-responsive"/>

                </div>
                  </div>

                  <?php } 
                          ?>


        </div>
	


		</div><!--col-->

		
		<div class="col-lg-6 border-x-0 border-x-md border-y border-y-md-0">
      
        <span><i class="fas fa-cash-register"></i> ข้อมูลชำระเงิน <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalAddPayment"><i class="far fa-plus-square"></i> บันทึกชำระเงิน</a></span>
        <hr>  
        <div id="spare_detail"></div>   

        


				</div>


		</div><!--col-->
		</div><!--row-->



	<div class="card-footer">
		<div class="row">
			<div class="col-lg-6">
				<!--<button type="button" class="btn btn-primary mr-2" id="btnSave"><i class="fa fa-save" title="บันทึก" ></i> บันทึก</button>-->
				<button type="button" class="btn btn-warning" onclick="javascript:history.back()" ><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></button>
			</div>
			<div class="col-lg-6 text-right">
				<!--<button type="reset" class="btn btn-danger">Delete</button>-->
			</div>
		</div>
	</div>
</form>

</div>
		<!--end::Card-->


                        <!--begin::Modal-->
                        <div class="modal fade" id="modalAddPayment" tabindex="-1" role="dialog" aria-labelledby="modalAddPayment" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-plus-square"></i> บันทึกชำระเงิน</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                       
                                    <form class="form" enctype="multipart/form-data" autocomplete="off">
                                        <input type="hidden" class="form-control"  name="act" id="act" value="add"/>
                                        <input type="hidden" class="form-control"  name="repairid" id="repairid" value="<?php echo $repairid;?>"/>
                                          <div class="form-group row">
                                          <div class="col-lg-2">
                                          <label>วันที่ทำรายการ</label>
                                          <input type="text" class="form-control"  name="paymentdate" id="paymentdate" data-date-language="th-th" maxlength="10"  placeholder="" value="<?php echo date("d/m/").(date("Y")+543)?>"/>
                                        </div>

                                          <div class="col-lg-3">
                                              <label>ประเภทการชำระ</label>
                                              <select class="form-control " name="payment_type" id="payment_type">
                                                          <option value="">ระบุ</option>
                                                          <?php
                                               
                                                            $stmt_user_role = $conn->prepare("SELECT s.* FROM ".DB_PREFIX."payment_type s 
                                                            WHERE s.active = 1  ");
                                                            $stmt_user_role->execute();		
                                                            while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                                                              {
                                                              $id_selected = $row['doctype'];
                                                              $title_selected = stripslashes($row['docname']);
                                                              ?>
                                                              <option value="<?php echo $id_selected;?>" ><?php echo $title_selected;?></option>
                                                              <?php
                                                              }
                                                            ?>
                                              </select>
                                            </div>
                                            <div class="col-lg-2">
                                              <label>จำนวนเงิน(บาท)</label>
                                              <input type="number" class="form-control"  name="amount" id="amount" placeholder="" value=""/>
                                            </div>

                                            <div class="col-lg-2">
                                              <label>วิธิชำระเงิน</label>
                                              <select class="form-control " name="payment_method" id="payment_method" >
                                                          
                                                          <option value="">ระบุ</option>
                                                          <?php
                                               
                                                            $stmt_user_role = $conn->prepare("SELECT s.* FROM ".DB_PREFIX."payment_method s 
                                                            WHERE s.flag = 1  ");
                                                            $stmt_user_role->execute();		
                                                            while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                                                              {
                                                              $id_selected = $row['m_id'];
                                                              $title_selected = stripslashes($row['m_title']);
                                                              ?>
                                                              <option value="<?php echo $id_selected;?>" ><?php echo $title_selected;?></option>
                                                              <?php
                                                              }
                                                            ?>
                                                          
                                              </select>
                                              
                                            </div>

                                            
                                            
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-lg-12">
                                              <label>หมายเหตุ</label>
                                              <textarea class="form-control"  name="payment_desc" id="payment_desc"></textarea>
                                            </div>
                                            </div>


                                          <div class="form-group row">
                                            <div class="col-lg-2">
                                            <button type="button" class="btn btn-success mr-2" id="btnAddPayment"><i class="far fa-save"></i> บันทึก</button>
                                            </div>
                                            
                                          </div>
                                   
    
    
                                    </div>
                                    <div class="modal-footer">
                                    
                                        <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal"><i class="far fa-times-circle"></i> ปิด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <!--end::Modal-->


                       


<script>
$(document).ready(function () {
    'use strict';
    loaddata_payment_data();


    var eq_id = $("#eq_id").val();
    if(eq_id == '0' ){
        
    }else if(eq_id == '' ){
        
      }else{
      $("#eq_name").attr('disabled','disabled');
      $("#eq_code").attr('disabled','disabled');
    }

    $('#eq_id').change(function(e){
        e.preventDefault();
        var eq_id = $("#eq_id").val();

        if(eq_id == '0' ){
            $('#eq_name').prop('disabled', false);
            $('#eq_code').prop('disabled', false);
        }else{
          $("#eq_name").attr('disabled','disabled');
            $("#eq_code").attr('disabled','disabled');
            //$("#eq_typeother").val('');
        }
  
      }); //


}); 

    //Example 2
    $('#filer_example2').filer({
        limit: 10,
        maxSize: 10,
        //extensions: ['jpg', 'jpeg', 'png', 'gif','pdf','doc','docx','xls','xlsx','ppt','pptx','zip','rar'],
		extensions: ['jpg', 'jpeg', 'png', 'gif'],
        changeInput: true,
        showThumbs: true,
        addMore: true
    });


$('#repairoutdate').datepicker({
        autoclose: true
});

$('#repairdate').datepicker({
        autoclose: true
});

$('#approvedate').datepicker({
        autoclose: true
});

$('#paymentdate').datepicker({
        autoclose: true
});

$('#returndate').datepicker({
        autoclose: true
});





function loaddata_payment_data() {
            var repairid = $("#repairid").val();
            var personid = $("#personid").val();
                $.ajax({
                    type: "POST",
                    url: "views/finance/payment-repair-data.php",
                    //dataType: "json",
                    data: {repairid:repairid,personid:personid},
                    success: function(data) {
                        $("#spare_detail").empty(); //add preload
                        $("#spare_detail").append(data);

                    } // success
                });
}


// del status
function delPaymentData(id) {
          Swal.fire({
              title: 'แน่ใจนะ?',
              text: "ต้องการยกเลิกรายการ !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'ยกเลิก',
              confirmButtonText: 'ใช่, ต้องการยกเลิกรายการ!'
          }).then((result) => {
              if (result.value) { //Yes
                  $.post("core/finance/payment-repair-del.php", {id: id}, function(result){
                    loaddata_payment_data();
                  });
              }
          })
      }


</script>

		                             
<script>




$('#btnAddPayment').click(function(e){
        e.preventDefault();
        if ($('#repairid').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาทำรายการ',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#payment_type').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุประเภทชำระเงิน',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#paymentdate').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุวันที่ทำรายการ',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#amount').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุจำนวนเงิน',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#payment_method').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุวิธีการชำระเงิน',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else {

		var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/finance/payment-repair-add.php",
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
                      // $('#spare_id').val('');
                      // $('#spare_quantity').val('');
                      // $('#spare_unit').val('');
                      // $('#spare_price').val('0');
                      // $('#spare_desc').val('');
                      $('#modalAddPayment').modal('hide');
                      loaddata_payment_data();
                    
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
                }else if (data.code == "201") {
                  //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                   Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถบันทึกข้อมูลได้',
                    text: 'ยอดเงินเกินจำนวนค่าซ่อม'
                    })
                    .then((value) => {
                      //liff.closeWindow();
                  });
                }
            } // success
        });

        }
    
      }); //  click



    

      $('.editor').trumbowyg({
				removeformatPasted: true,
				lang: 'th',
				autogrow: true,
				btnsDef: {
					// Create a new dropdown
					image: {
						dropdown: ['insertImage', 'noembed'],
						ico: 'insertImage'
					}
				}, 

					
				btns: [
						['viewHTML'],
						['undo', 'redo'],
						['formatting'],
						'btnGrp-semantic',
						['link'],
						['table'],
						['image'],
						'btnGrp-justify',
						'btnGrp-lists',
						['horizontalRule'],
						['removeformat'],
						['fullscreen'],
						['foreColor', 'backColor'],
						['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
					],
							
				plugins: {
						upload: {
							serverPath: '<?php echo ADMIN_URL;?>/assets/plugins/trumbowyg/texteditor-upload.php',
							fileFieldName: 'image'
							}
						},
						table: {
            // Some table plugin options, see details below
        }				
							
			});	


			var defaultOptions = {
        rows: 8,
        columns: 8,
        styler: 'table'
    };

    $.extend(true, $.trumbowyg, {
        langs: {
            en: {
                table: 'Insert table',
                tableAddRow: 'Add row',
                tableAddColumn: 'Add column',
                tableDeleteRow: 'Delete row',
                tableDeleteColumn: 'Delete column',
                tableDestroy: 'Delete table',
                error: 'Error'
            }
            
        },

        plugins: {
            table: {
                init: function (t) {
                    t.o.plugins.table = $.extend(true, {}, defaultOptions, t.o.plugins.table || {});

                    var buildButtonDef = {
                        fn: function () {
                          t.saveRange();

                          var btnName = 'table';

                          var dropdownPrefix = t.o.prefix + 'dropdown',
                              dropdownOptions = { // the dropdown
                              class: dropdownPrefix + '-' + btnName + ' ' + dropdownPrefix + ' ' + t.o.prefix + 'fixed-top'
                          };
                          dropdownOptions['data-' + dropdownPrefix] = btnName;
                          var $dropdown = $('<div/>', dropdownOptions);

                          if (t.$box.find("." + dropdownPrefix + "-" + btnName).length === 0) {
                            t.$box.append($dropdown.hide());
                          } else {
                            $dropdown = t.$box.find("." + dropdownPrefix + "-" + btnName);
                          }

                          // clear dropdown
                          $dropdown.html('');

                          // when active table show AddRow / AddColumn
                          if (t.$box.find("." + t.o.prefix + "table-button").hasClass(t.o.prefix + 'active-button')) {
                            $dropdown.append(t.buildSubBtn('tableAddRow'));
                            $dropdown.append(t.buildSubBtn('tableAddColumn'));
                            $dropdown.append(t.buildSubBtn('tableDeleteRow'));
                            $dropdown.append(t.buildSubBtn('tableDeleteColumn'));
                            $dropdown.append(t.buildSubBtn('tableDestroy'));
                          } else {
                            var tableSelect = $('<table></table>');
                            for (var i = 0; i < t.o.plugins.table.rows; i += 1) {
                              var row = $('<tr></tr>').appendTo(tableSelect);
                              for (var j = 0; j < t.o.plugins.table.columns; j += 1) {
                                $('<td></td>').appendTo(row);
                              }
                            }
                            tableSelect.find('td').on('mouseover', tableAnimate);
                            tableSelect.find('td').on('mousedown', tableBuild);

                            $dropdown.append(tableSelect);
                            $dropdown.append($('<center>1x1</center>'));
                          }

                          t.dropdown(btnName);
                        }
                    };

                    var tableAnimate = function(column_event) {
                      var column = $(column_event.target),
                          table = column.parents('table'),
                          colIndex = this.cellIndex,
                          rowIndex = this.parentNode.rowIndex;

                      // reset all columns
                      table.find('td').removeClass('active');

                      for (var i = 0; i <= rowIndex; i += 1) {
                        for (var j = 0; j <= colIndex; j += 1) {
                          table.find("tr:nth-of-type("+(i+1)+")").find("td:nth-of-type("+(j+1)+")").addClass('active');
                        }
                      }

                      // set label
                      table.next('center').html((colIndex+1) + "x" + (rowIndex+1));
                    };

                    var tableBuild = function(column_event) {
                      t.saveRange();

                      var tabler = $('<table></table>');
                      if (t.o.plugins.table.styler) {
                        tabler.attr('class', t.o.plugins.table.styler);
                      }

                      var column = $(column_event.target),
                          colIndex = this.cellIndex,
                          rowIndex = this.parentNode.rowIndex;

                      for (var i = 0; i <= rowIndex; i += 1) {
                        var row = $('<tr></tr>').appendTo(tabler);
                        for (var j = 0; j <= colIndex; j += 1) {
                          $('<td></td>').appendTo(row);
                        }
                      }

                      t.range.deleteContents();
                      t.range.insertNode(tabler[0]);
                      t.$c.trigger('tbwchange');
                    };

                    var addRow = {
                      title: t.lang['tableAddRow'],
                      text: t.lang['tableAddRow'],
                      ico: 'row-below',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode;
                        var table = $(node).closest('table');

                        if(table.length > 0) {
                          var row = $('<tr></tr>');
                          // add columns according to current columns count
                          for (var i = 0; i < table.find('tr')[0].childElementCount; i += 1) {
                            $('<td></td>').appendTo(row);
                          }
                          // add row to table
                          row.appendTo(table);
                        }

                        return true;
                      }
                    };

                    var addColumn = {
                      title: t.lang['tableAddColumn'],
                      text: t.lang['tableAddColumn'],
                      ico: 'col-right',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode;
                        var table = $(node).closest('table');

                        if(table.length > 0) {
                          $(table).find('tr').each(function() {
                            $(this).find('td:last').after('<td></td>');
                          });
                        }

                        return true;
                      }
                    };

                    var destroy = {
                      title: t.lang['tableDestroy'],
                      text: t.lang['tableDestroy'],
                      ico: 'table-delete',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            table = $(node).closest('table');

                        table.remove();

                        return true;
                      }
                    };

                    var deleteRow = {
                      title: t.lang['tableDeleteRow'],
                      text: t.lang['tableDeleteRow'],
                      ico: 'row-delete',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            row = $(node).closest('tr');

                        row.remove();

                        return true;
                      }
                    };

                    var deleteColumn = {
                      title: t.lang['tableDeleteColumn'],
                      text: t.lang['tableDeleteColumn'],
                      ico: 'col-delete',

                      fn: function () {
                        t.saveRange();

                        var node = t.doc.getSelection().focusNode,
                            table = $(node).closest('table'),
                            td = $(node).closest('td'),
                            cellIndex = td.index();

                        $(table).find('tr').each(function() {
                          $(this).find('td:eq('+cellIndex+')').remove();
                        });

                        return true;
                      }
                    };

                    t.addBtnDef('table', buildButtonDef);
                    t.addBtnDef('tableAddRow', addRow);
                    t.addBtnDef('tableAddColumn', addColumn);
                    t.addBtnDef('tableDeleteRow', deleteRow);
                    t.addBtnDef('tableDeleteColumn', deleteColumn);
                    t.addBtnDef('tableDestroy', destroy);
                }
            }
        }
    });
</script>



