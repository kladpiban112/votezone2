

		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-plus-circle"></i>&nbsp;เพิ่มผู้ใช้งาน 
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="dashboard.php?module=<?php echo $module;?>" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></a>
					</div>
				</div>
			</div>


<form class="form" enctype="multipart/form-data" >
<input type="hidden" class="form-control"  name="act" id="act" placeholder="ชื่อ-สกุล" value="add"/>
	<div class="card-body">
	<div class="row">
	<div class="col-lg-9">
		<div class="form-group row">
			<div class="col-lg-5">
				<label>ชื่อ-สกุล</label>
				<input type="text" class="form-control"  name="fullname" id="fullname" placeholder="ชื่อ-สกุล"/>
				
			</div>
			<div class="col-lg-4">
				<label>ชื่อย่อ</label>
				<input type="text" class="form-control"  name="shortname" id="shortname" placeholder="ชื่อย่อ"/>
				
			</div>
			<div class="col-lg-3">
				<label>เลขบัตรประชาชน</label>
				<input type="text" class="form-control" name="cid" id="cid" placeholder="เลขบัตรประชาชน"/>
				<span class="form-text text-muted">เลขที่บัตรประชาชน 13 หลัก</span>
			</div>
		</div>


		<div class="form-group row">
			<div class="col-lg-3">
				<label>โทรศัพท์</label>
				<input type="text" class="form-control"  name="telephone" id="telephone" placeholder="โทรศัพท์"/>
				<span class="form-text text-muted">หมายเลขโทรศัพท์ 10 หลัก</span>
				
			</div>

			<div class="col-lg-4">
				<label>email</label>
				<input type="text" class="form-control"  name="email" id="email" placeholder="email"/>
				
			</div>

		</div>

		<div class="form-group row">
			<div class="col-lg-3">
				<label>Username</label>
				<input type="text" class="form-control"  name="username" id="username" placeholder="Username"/>
				<span class="form-text text-muted">ภาษาอังกฤษเท่านั้น</span>
			</div>
			<div class="col-lg-3">
				<label>Password</label>
				<input type="text" class="form-control"  name="password" id="password" placeholder="Password"/>
				<span class="form-text text-muted">ไม่น้อยกว่า 8 อักษร</span>
			</div>

			<div class="col-lg-6">
				<label>หน่วยงาน</label>
				<select class="form-control " name="org_id" id="org_id">
                    <option>ระบุ</option>
                    <?php
					$stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."org_main WHERE flag = 1 ORDER BY org_id ASC");
					$stmt_user_role->execute();		
					while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
						{
						$id_selected = $row['org_id'];
						$title_selected = stripslashes($row['org_name']);
						?>
						<option value="<?php echo $id_selected;?>"><?php echo $title_selected;?></option>
						<?php
						}
					?>
				</select>
			</div>
			
		</div>



		

		

		</div><!--col-->

		
		<div class="col-lg-3 border-x-0 border-x-md border-y border-y-md-0">
				<div class="form-group row">
					<div class="col-lg-12">
						<label>รูปโปรไฟล์</label>
						<input type="file" class="form-control"  name="img_profile" id="img_profile" placeholder="รูปโปรไฟล์"/>
						<span class="form-text text-muted">.jpg .png เท่านั้น</span>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-12">
						<label>สิทธิ์ใช้งาน</label>
						<select class="form-control "  name="user_role" id="user_role">
							<option value="">ระบุ</option>
							<?php
							$stmt_user_role = $conn->prepare("SELECT role_id, title FROM ".DB_PREFIX."users_roles WHERE active = 1 ORDER BY role_id ASC");
							$stmt_user_role->execute();		
							while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
								{
								$role_id_selected = $row['role_id'];
								$role_title_selected = stripslashes($row['title']);
								?>
								<option value="<?php echo $role_id_selected;?>"><?php echo $role_title_selected;?></option>
								<?php
								}
							?>
						</select>
					</div>
					</div>
					<div class="form-group row">
					<div class="col-lg-12">
						<label>สถานะใช้งาน</label>
						<select class="form-control "  name="user_status" id="user_status">
							<option value="1">เปิดใช้งาน</option>
							<option value="0">ปิดใช้งาน</option>
						</select>
					</div>
				</div>
				</div>


		</div><!--col-->
		</div><!--row-->



	<div class="card-footer">
		<div class="row">
			<div class="col-lg-6">
				<button type="button" class="btn btn-primary mr-2" id="btnSaveUsers"><i class="fa fa-save" title="ย้อนกลับ" ></i> บันทึก</button>
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
$('#btnSaveUsers').click(function(e){
        e.preventDefault();
        if ($('#fullname').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุชื่อ-สกุล',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#username').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุ Username',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#password').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุ Password',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#user_role').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุสิทธิ์ใช้งาน',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else if ($('#telephone').val().length == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณาระบุโทรศัพท์',
                    showConfirmButton: false,
                    timer: 1000
                    });
        }else {
		var fullname = $("#fullname").val();
        var username = $("#username").val();
		var cid = $("#cid").val();
        var password = $("#password").val();
        var act = $("#act").val();
		var shortname = $("#shortname").val();
		var org_id = $("#org_id").val();
		var user_role = $("#user_role").val();
		var user_status = $("#user_status").val();

		var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/users/users-add.php",
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
                    window.location.replace("dashboard.php?module=users");
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

<script>
      var cid = new Cleave("#cid", {
        delimiters: ["-", "-", "-", "-"],
        blocks: [1, 4, 5, 2, 1],
        uppercase: true,
      });

	  var phoneNumber = new Cleave("#telephone", {
        phone: true,
        phoneRegionCode: "TH",
      });
      
    </script>

