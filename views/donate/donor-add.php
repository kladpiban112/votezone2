<?php
$personid = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$serviceid = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid);
$serviceid = base64_decode($serviceid);
$action = base64_decode($act);
if($action == "edit"){
	$txt_title = "แก้ไข";
	$action = $action;

	$stmt_data = $conn->prepare ("SELECT p.*,o.org_name FROM ".DB_PREFIX."donor_main p 
	LEFT JOIN ".DB_PREFIX."org_main o ON p.org_id = o.org_id 
  WHERE p.oid = '$personid'  LIMIT 1");
  $stmt_data->execute();	
  $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);
  
  $sql_service = "SELECT s.* FROM ".DB_PREFIX."donate_main s 
  LEFT JOIN ".DB_PREFIX."donor_main p ON s.person_id = p.oid 
WHERE s.service_id = '$serviceid' AND s.flag != '0'  LIMIT 1";
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
      <div class="ribbon-target bg-primary" style="top: 10px; right: -2px;">1</div>
				<h3 class="card-title">
        <i class="fas fa-clipboard-list"></i>&nbsp;<?php echo $txt_title;?>รับบริจาค 
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="dashboard.php?module=<?php echo $module;?>" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></a>
					</div>
				</div>
			</div>


<form class="form" enctype="multipart/form-data" >
<input type="hidden" class="form-control"  name="act" id="act" value="<?php echo $action;?>"/>
<input type="hidden" class="form-control"  name="serviceid" id="serviceid" value="<?php echo $serviceid;?>"/>
<input type="hidden" class="form-control"  name="personid" id="personid" value="<?php echo $personid;?>"/>
	<div class="card-body">

	
	<div class="row">
	<div class="col-lg-9">

    <span><i class="far fa-bookmark"></i> ข้อมูลรับบริจาค</span>
  <hr>   
    <div class="form-group row">

    <div class="col-lg-2">
				<label>วันที่รับบริจาค</label>
				<input type="text" class="form-control"  name="servicedate" id="servicedate" placeholder="วันที่รับบริจาค" value="<?php echo date_db_2form($row_service['service_date']);?>"  data-date-language="th-th" maxlength="10" />
				<span class="form-text text-muted"></span>
				
			</div>

            
			

		</div>
<span><i class="far fa-user"></i> ข้อมูลผู้บริจาค</span>
  <hr>      

  <div class="form-group row">
			<div class="col-lg-4">
				<label>เลขบัตรประชาชน</label>
				<div class="input-group">
							<input type="text" class="form-control" placeholder="เลขบัตรประชาชน 13 หลัก"  name="cid" id="cid" maxlength="13" value="<?php echo $row_person['cid'];?>"/>
							<div class="input-group-append">
								<button class="btn btn-secondary" type="button" id = "cidSearch"><i class="fas fa-search"></i></button>
							</div>
						</div>
			</div>
      <div class="col-lg-4">
				<label>หน่วยงานรับบริจาค</label>
				<select class="form-control " name="org_id" id="org_id">
                    <!--<option value="">ระบุ</option>-->
                    <?php
					if($logged_user_role_id == '1'){
						$conditions = " ";
					}else{
						$conditions = " AND org_id = '$logged_org_id' ";
					}
					$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."org_main WHERE flag = 1  $conditions  ORDER BY org_id ASC");
					$stmt_user_role->execute();		
					while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
						{
						$id_selected = $row['org_id'];
						$title_selected = stripslashes($row['org_name']);
						?>
						<option value="<?php echo $id_selected;?>" <?php if($row_person['org_id'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
						<?php
						}
					?>
				</select>
			</div>

		</div>

  <div class="form-group row">
      <div class="col-lg-2">
				<label>คำนำหน้า</label>
            <select class="form-control " name="prename" id="prename">
                        <option value="">ระบุ</option>
                        <?php
                          $stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."cprename  ORDER BY id_prename ASC");
                          $stmt_user_role->execute();		
                          while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                            {
                            $id_selected = $row['id_prename'];
                            $title_selected = stripslashes($row['prename']);
                            ?>
                            <option value="<?php echo $id_selected;?>" <?php if($row_person['prename'] == $id_selected ){echo "selected";} ?>><?php echo $title_selected;?></option>
                            <?php
                            }
                          ?>
            </select>
				
			</div>
			<div class="col-lg-5">
				<label>ชื่อ</label>
				<input type="text" class="form-control"  name="fname" id="fname" placeholder="ชื่อ" value="<?php echo $row_person['fname'];?>"/>
				
			</div>
			<div class="col-lg-5">
				<label>สกุล</label>
				<input type="text" class="form-control"  name="lname" id="lname" placeholder="สกุล" value="<?php echo $row_person['lname'];?>"/>
				
			</div>
			
		</div>


		<div class="form-group row">

            <div class="col-lg-12">
				<label>ชื่อหน่วยงาน</label>
				<input type="text" class="form-control"  name="companyname" id="companyname" placeholder="ชื่อหน่วยงาน" value="<?php echo $row_person['company_name'];?>" />

				
            </div>
            </div>
            <div class="form-group row">

            <div class="col-lg-4">
				<label>โทรศัพท์</label>
				<input type="text" class="form-control"  name="telephone" id="telephone" placeholder="โทรศัพท์" value="<?php echo $row_person['telephone'];?>" maxlength="10"/>
				<span class="form-text text-muted">หมายเลขโทรศัพท์ 10 หลัก</span>
				
            </div>
            
            <div class="col-lg-8">
				<label>อีเมลล์</label>
				<input type="text" class="form-control"  name="email" id="email" placeholder="อีเมลล์" value="<?php echo $row_person['email'];?>" />
				
				
			</div>
			

		</div>

   <span><i class="fas fa-house-user"></i> ที่อยู่ :</span>
<hr>
		<div class="form-group row">
			<div class="col-lg-3">
				<label>บ้านเลขที่</label>
				<input type="text" class="form-control"  name="house" id="house" placeholder="บ้านเลขที่" value="<?php echo $row_person['house'];?>"/>
				
			</div>
			<div class="col-lg-4">
				<label>หมู่บ้าน/ชุมชน</label>
        <input type="text" class="form-control"  name="community" id="community" placeholder="หมู่บ้าน/ชุมชน" value="<?php echo $row_person['community'];?>"/>
				
			</div>

			

            <div class="col-lg-3">
				<label>ถนน</label>
             <input type="text" class="form-control"  name="road" id="road" placeholder="ถนน" value="<?php echo $row_person['road'];?>"/>
				
			</div>

            <div class="col-lg-2">
				<label>หมู่ที่</label>
				<select class="form-control " name="village" id="village">
                    <option value=""  <?php if($row_person['village'] == "0"){ echo "selected";}?>>0</option>
								
								<?php for ($n_vil = 1; $n_vil <= 99; $n_vil++) { 
									$n_vil_data = str_pad($n_vil,2,"0",STR_PAD_LEFT);
									?>
										<option value="<?php echo $n_vil_data;?>" <?php if($row_person['village'] == $n_vil_data){ echo "selected";}?>><?php echo $n_vil;?></option>
								<?php } ?>
								
                    
				</select>
			</div>
			
		</div>

        <input type="hidden" class="form-control"  name="txt_ampur" id="txt_ampur" value="<?php echo $row_person['ampur'];?>"/>
        <input type="hidden" class="form-control"  name="txt_tambon" id="txt_tambon" value="<?php echo $row_person['tambon'];?>"/>
    <div class="form-group row">

    <div class="col-lg-3">
				<label>จังหวัด</label>
            <select class="form-control " name="changwat" id="changwat">
                        
                        <?php
                                                            $stmt = $conn->prepare ("SELECT * FROM cchangwat c ");
                                                            $stmt->execute();
                                                            echo "<option value=''>-ระบุ-</option>";
                                                            while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                                            $id = $row->changwatcode;
                                                            $name = $row->changwatname; ?>
                                                            <option value="<?php echo $id;?>" <?php if($row_person['changwat'] == $id){ echo "selected";}?>><?php echo $name;?></option>
                                                            <?php 
                                                            }
                                                        ?>
            </select>
				
			</div>

      <div class="col-lg-3">
				<label>อำเภอ</label>
            <select class="form-control " name="ampur" id="ampur">
                        <option value="">ระบุ</option>
            </select>
			</div>

      <div class="col-lg-3">
				<label>ตำบล</label>
            <select class="form-control " name="tambon" id="tambon">
                        <option value="">ระบุ</option>
            </select>
			</div>



      </div>

	


		</div><!--col-->

		
		<div class="col-lg-3 border-x-0 border-x-md border-y border-y-md-0">

		        <div class="form-group row">
					<div class="col-lg-12">
					
								<div class="symbol symbol-50 symbol-lg-150 ">
								

                                    <?php if($row_person['img_profile'] == ""){?>
                                         <img src="uploads/equipment/no-image.jpg" alt="image"/>
                                        <?php }else{?>
                                            <img src="uploads/donate/<?php echo $row_person['img_profile'];?>" alt="image"/>
                                        <?php   } ?>


									<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
								</div>	
					</div>
				</div>


				<div class="form-group row">
					<div class="col-lg-12">
						<label>รูปถ่ายผู้บริจาค</label>
						<input type="file" class="form-control"  name="img_profile" id="img_profile" placeholder="รูปถ่ายผู้บริจาค"/>
						<span class="form-text text-muted">.jpg .png เท่านั้น</span>
					</div>
				</div>


				</div>


		</div><!--col-->
		</div><!--row-->



	<div class="card-footer">
		<div class="row">
			<div class="col-lg-6">
				<button type="button" class="btn btn-primary mr-2" id="btnSavePerson"><i class="fa fa-save" title="ย้อนกลับ" ></i> บันทึก</button>
				<button type="button" class="btn btn-secondary" onclick="javascript:history.back()" ><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i> ย้อนกลับ</button>
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

    getoptselect_amphur();
	getoptselect_tambon();

						
}); 


$('#servicedate').datepicker({
        autoclose: true
});






$("#changwat").change(function() {
    $("#txt_ampur").val('');
    $("#txt_tambon").val('');
    getoptselect_amphur();
    getoptselect_tambon();
});


$("#ampur").change(function() {
    $("#txt_tambon").val('');
    getoptselect_tambon();
});




function getoptselect_amphur(){

    var changwatcode = $("#changwat").val();
    var ampur = $("#txt_ampur").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-ampur.php",
        //dataType: "json",
        data: {changwatcode:changwatcode,ampur:ampur},
        success: function(data) {
        
            $("#ampur").empty();
            $("#ampur").append(data);
        } // success
    });
}	

function getoptselect_tambon(){

var changwatcode = $("#changwat").val();
var ampur = $("#txt_ampur").val();
var ampurcode = $("#ampur").val();
var tambon = $("#txt_tambon").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-tambon.php",
        //dataType: "json",
        data: {changwatcode:changwatcode,ampurcode:ampurcode,ampur:ampur,tambon:tambon},
        success: function(data) {
        
            $("#tambon").empty();
            $("#tambon").append(data);
        } // success
    });

}	



</script>

		                             
<script>



$('#btnSavePerson').click(function(e){
        e.preventDefault();
        if ($('#servicedate').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุวันที่รับบริจาค',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#cid').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุเลขบัตรประชาชน',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#org_id').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุหน่วยงาน',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#fname').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุชื่อ',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#lname').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุนามสกุล',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else {

		var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/donate/donor-add.php",
            dataType: "json",
			data: data,
			processData: false,
            contentType: false,
            /*data: {
                fullname:fullname,
				username:username,
                password:password,
                act:act,
				cid:cid,
				shortname:shortname,
				org_id:org_id,
				user_role:user_role,
				user_status:user_status
                },*/
            success: function(data) {  
              if (data.code == "200") {
                Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ',
                showConfirmButton: false,
                timer: 1500
                })
                    .then((value) => {
                    //liff.closeWindow();
                    //window.location.replace("dashboard.php?module=borrow");
                    window.location.replace("dashboard.php?module=donate&page=donate-add&personid="+data.personid+"&serviceid="+data.serviceid+"&act="+data.act);
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



