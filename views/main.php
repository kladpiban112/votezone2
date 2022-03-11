		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                DASHBOARD
				</h3>
				<div class="card-toolbar">
					<!--<div class="example-tools justify-content-center">
						<span class="example-toggle" data-toggle="tooltip" title="View code"></span>
						<span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
					</div>-->
				</div>
			</div>


	<div class="card-body">

    <?php
    error_reporting(0);
    $today_date = date("Y-m-d");
    $today = date("d")."/".date("m")."/".(date("Y")+543);
    $repair_today = "#";
    if($logged_user_role_id == '1'){
        $conditions = " ";
        }else{

        $conditions = " AND u.org_id = '$logged_org_id' ";

        }

    $numb_service = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."repair_main u WHERE u.flag != '0' $conditions ")->fetchColumn();

    $numb_service_today = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."repair_main u WHERE u.flag != '0' AND u.repair_date = '$today_date' $conditions  ")->fetchColumn();
    
    $numb_add_today = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."repair_main u WHERE u.flag != '0' AND repair_status = '1' $conditions ")->fetchColumn();
    $numb_begin_work = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."repair_main u WHERE u.flag != '0' AND repair_status = '2' $conditions ")->fetchColumn();
    $numb_finish_repair = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."repair_main u WHERE u.flag != '0' AND repair_status = '3' $conditions ")->fetchColumn();
    $numb_add_out = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."repair_main u WHERE u.flag != '0' AND repair_inout = 'O'  $conditions ")->fetchColumn();
    if( $numb_service_today != '0'){$repair_today = "dashboard.php?act=&module=repair&page=main&startdate=".$today."&enddate=&status=&search=";}
    //$numb_equipment = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."equipment_main s WHERE s.flag != '0' $conditions  ")->fetchColumn();
    //$numb_donate = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."donate_main s WHERE s.flag != '0'  $conditions  ")->fetchColumn();
    ?>

	<div class="row">
                            <div class="col-xl-2">
                                    <div class="card card-custom gutter-b bg-secondary" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-calendar-day fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_service_today;?></div>
                                            <a href="<?php echo $repair_today ?>" class="text-dark text-hover-primary font-weight-bold font-size-lg mt-1">รายการซ่อมวันนี้</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-2">
                                    <div class="card card-custom gutter-b bg-secondary " style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-user-cog fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_service;?></div>
                                            <a href="././dashboard.php?module=repair&page=main" class="text-dark text-hover-primary font-weight-bold font-size-lg mt-1">รายการซ่อม</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-2">
                                    <div class="card card-custom gutter-b bg-secondary" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-user-plus fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_add_today;?></div>
                                            <a href="././dashboard.php?act=&module=repair&page=main&startdate=&enddate=&status=1&search=" class="text-dark text-hover-primary font-weight-bold font-size-lg mt-1">แจ้งรับการซ่อม</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-2">
                                    <div class="card card-custom gutter-b bg-secondary" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-screwdriver fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_begin_work;?></div>
                                            <a href="././dashboard.php?act=&module=repair&page=main&startdate=&enddate=&status=2&search=" class="text-dark text-hover-primary font-weight-bold font-size-lg mt-1">รายการกำลังซ่อม</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-2">
                                    <div class="card card-custom gutter-b bg-secondary" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="far fa-calendar-check fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_finish_repair;?></div>
                                            <a href="././dashboard.php?act=&module=repair&page=main&startdate=&enddate=&status=3&search=" class="text-dark text-hover-primary font-weight-bold font-size-lg mt-1">รายการซ่อมเสร็จ</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-2">
                                    <div class="card card-custom gutter-b bg-secondary" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-truck fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_add_out;?></div>
                                            <a href="././dashboard.php?module=repairout&page=main" class="text-dark text-hover-primary font-weight-bold font-size-lg mt-1">รายการซ่อมภายนอก</a>
                                        </div>
                                    </div>
                            </div>

                            <!-- <div class="col-xl-2">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-user-clock fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php//echo $numb_service_today;?></div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">รายการรอรับคืน</a>
                                        </div>
                                    </div>
                            </div> -->

                            <!--<div class="col-xl-3">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-wheelchair fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"></div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">จำนวนกายอุปกรณ์</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-3">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-boxes fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"></div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">จำนวนรับบริจาค</a>
                                        </div>
                                    </div>
                            </div>-->
				</div>


<div class="row">

				<div class="col-lg-12 col-xxl-12">
		<!--begin::Advance Table Widget 1-->
<div class="card card-custom card-stretch gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark"><i class="fas fa-users-cog"></i>&nbsp;รายการแจ้งซ่อมบันทึกล่าสุด</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm"><a href="dashboard.php?module=repair&page=main">ทั้งหมด <?php echo $numb_service;?> รายการ</a></span>
        </h3>
        <div class="card-toolbar">
            <a href="?module=repair&page=repair-add" class="btn btn-success btn-sm font-weight-bolder font-size-sm">
            <i class="fas fa-plus-circle"></i></span>บันทึกแจ้งซ่อม
            </a>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body py-0">
    <?php 
    //$numb_data = $conn->query("SELECT count(1) FROM ".DB_PREFIX."service_main s  WHERE s.flag != '0' $conditions  ")->fetchColumn();
        
    $stmt_data = $conn->prepare ("SELECT u.*,p.*,o.org_shortname ,t.repair_typetitle,if(e.eq_code IS NOT NULL ,e.eq_code,u.eq_code) AS eq_code, if(e.eq_name IS NOT NULL ,e.eq_name,u.eq_name) AS eq_name,st.status_title,pm.cost,pm.cost_payment,pm.cost_success
    FROM ".DB_PREFIX."repair_main u 
    LEFT JOIN ".DB_PREFIX."org_main o ON u.org_id = o.org_id 
    LEFT JOIN ".DB_PREFIX."repair_type t ON u.repair_type = t.repair_typeid
    LEFT JOIN ".DB_PREFIX."person_main p ON u.person_id = p.oid
    LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
    LEFT JOIN ".DB_PREFIX."equipment_main e ON u.eq_id = e.oid
    LEFT JOIN ".DB_PREFIX."repair_status_type st ON u.repair_status = st.status_typeid
    LEFT JOIN ".DB_PREFIX."repair_payment pm ON u.repair_id = pm.repair_id
    WHERE u.flag != 0  $conditions
    ORDER BY u.repair_id DESC LIMIT 10");
    $stmt_data->execute();		

    ?>
        <!--begin::Table-->
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-strip" id="tbData" style="margin-top: 13px !important; min-height: 200px;">
    <thead>
    <tr>
    <th class="text-center">ลำดับ</th>
                        <th>qrcode</th>
                        <th>เลขที่แจ้งซ่อม</th>
                        <th>วันที่แจ้งซ่อม</th>
                        <th>รูปแบบการซ่อม</th>
                        <th>ประเภทแจ้งซ่อม</th>
                        <th>อุปกรณ์</th>
                        <th>อาการแจ้งซ่อม</th>
                        <th>ผู้แจ้ง</th>
                        <th>หน่วยงาน</th>
                        <th >สถานะ</th>
                        <th >ค่าซ่อม</th>
                        <th >รับคืน</th>
                        <th class="text-center">จัดการ</th>	
    </tr>
    </thead>
    <tbody>
            
            <?php

            $i  = 0;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $i++;
                $repair_code = $row['repair_code'];
                $repairid = $row['repair_id'];
                $repairid_enc = base64_encode($repairid);
                $personid = $row['person_id'];
                $personid_enc = base64_encode($personid);

                $prename = $row['prename_title'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $fullname = $prename.$fname." ".$lname;
                $cid = $row['cid'];
                $org_name = $row['org_name'];
                $org_shortname = $row['org_shortname'];
                $birthdate = date_db_2form($row['birthdate']);
                $img_profile = $row['img_profile'];

                $repair_date = date_db_2form($row['repair_date']);
                $repairtype = $row['repair_type'];
                $repair_typetitle = $row['repair_typetitle'];
                $repair_title = $row['repair_title'];
                $eq_name = $row['eq_name'];
                $eq_id = $row['eq_id'];
                $eq_code = $row['eq_code'];
                $status_title = $row['status_title'];

                $repair_status = $row['repair_status'];
                $repair_inout = $row['repair_inout'];
                if($repair_inout == 'I'){
                    $repair_inout_show = "<i class='fas fa-tools text-success'></i>";
                }else{
                    $repair_inout_show = "<i class='fas fa-truck text-danger'></i>";
                }

                $return_date = date_db_2form($row['return_date']);

                if(($repair_status == '3') AND ($return_date != "")){

                    $return_status = "<i class='fas fa-check-circle text-success'></i>";

                }else{
                    $return_status = "";
                }
                    $stmt_spare = $conn->prepare ("SELECT SUM(u.spare_price) AS sum_price
                    ,GROUP_CONCAT(s.spare_name,' ',u.spare_quantity,' ',t.unit_title,' ราคา ',u.spare_price,' บาท') AS detail
                    FROM ".DB_PREFIX."repair_spare u 
                    LEFT JOIN  ".DB_PREFIX."spare_main s ON u.spare_id = s.spare_id
                    LEFT JOIN ".DB_PREFIX."cunit t ON u.spare_unit = t.unit_id
                    WHERE u.flag != '0' AND u.repair_id = '$repairid'
                    ");
                    $stmt_spare->execute();	
                    $row_spare = $stmt_spare->fetch(PDO::FETCH_ASSOC);

                    $sum_price = $row_spare['sum_price'];

                    $cost = $row['cost'];
                    $cost_payment = $row['cost_payment'];
                    $cost_success = $row['cost_success'];

                ?>
                <tr>
                            <td class="text-center"><?php echo $i;?></td>
                            <td class="text-center">
                            <?php 
                                    if($repair_inout == 'I'){
                                        
                                        ?>  
                            <a href="dashboard.php?module=repair&page=repair-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&act=<?php echo base64_encode('view');?>" > <div class="symbol symbol-50 symbol-lg-60">          
                            <img src="uploads/qrcode-repair/<?php echo $repairid;?>.png" alt="image"/>         
                            </div></a>
                            <?php }else{ ?>
                                <a href="dashboard.php?module=repairout&page=repairout-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&act=<?php echo base64_encode('view');?>" > <div class="symbol symbol-50 symbol-lg-60">          
                            <img src="uploads/qrcode-repair/<?php echo $repairid;?>.png" alt="image"/>         
                            </div></a>
                                
                            <?php }?>
                            </td>
                            <td class="text-center"><?php echo $repair_code;?></td>
                            <td><?php echo $repair_date;?></td>
                            <td class="text-center"><?php echo $repair_inout_show;?></td>
                            <td><?php echo $repair_typetitle;?></td>
                            <td><?php echo $eq_name;?></br><small>รหัส : <?php echo $eq_code;?></small></td>
                            <td><?php echo $repair_title;?></td>
                            <td><?php echo $fullname;?></br><small>เลขบัตร : <?php echo $cid;?></small></td>
                            <td><?php echo $org_shortname;?></td>
                            <td><?php echo $status_title;?></td>
                            <td><?php echo $cost;?></td>
                            <td class="text-center"><?php echo $return_status;?></td>
                            <td class="text-center">
                            <!--begin::Dropdown-->
                                <div class="dropdown">
                                    <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                        <i class="ki ki-bold-more-hor font-size-md"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <!--begin::Navigation-->

                                    <?php 
                                    if($repair_inout == 'I'){

                                        ?>    
                                    <ul class="navi navi-hover py-1">
                                        <li class="navi-item">
                                            <a href="dashboard.php?module=repair&page=repair-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">ใบแจ้งซ่อม</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=repair&page=repair-add&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลผู้แจ้งซ่อม</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=repair&page=repair-add-data&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-cogs"></i></span>
                                                <span class="navi-text">บันทึกผลการซ่อม</span>
                                            </a>
                                        </li>

                                        <li class="navi-separator my-3"></li>

                                        <li class="navi-item">
                                            <a href="#" class="navi-link" onclick='delRepairMain(<?php echo $repairid; ?>)'>
                                                <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                                <span class="navi-text">ยกเลิกรายการ</span>
                                            </a>
                                        </li> 
                                    </ul>
                                    <?php }else {?>

                                        <ul class="navi navi-hover py-1">
                                        <li class="navi-item">
                                            <a href="dashboard.php?module=repairout&page=repairout-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">ใบส่งซ่อมภายนอก</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=repairout&page=repairout-add&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลผู้แจ้งซ่อม</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=repairout&page=repairout-add-data&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-cogs"></i></span>
                                                <span class="navi-text">บันทึกผลการซ่อมภายนอก</span>
                                            </a>
                                        </li>

                                        <li class="navi-separator my-3"></li>

                                        <li class="navi-item">
                                            <a href="#" class="navi-link" onclick='delRepairMain(<?php echo $repairid; ?>)'>
                                                <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                                <span class="navi-text">ยกเลิกรายการ</span>
                                            </a>
                                        </li> 
                                    </ul>


                                    <?php }?>
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
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 1-->
	</div>
	</div>				

</div>


</div>
		<!--end::Card-->


        <script>

function delRepairMain(id) {
                    Swal.fire({
                        title: 'แน่ใจนะ?',
                        text: "ต้องการยกเลิกรายการ",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ยกเลิก',
                        confirmButtonText: 'ใช่, ต้องการยกเลิกรายการ !'
                    }).then((result) => {
                        if (result.value) { //Yes
                            $.post("core/repair/repair-del.php", {id: id}, function(result){
                                //  $("test").html(result);
                                // console.log(result.code);
                                location.reload();
                            });
                        }
                    })
            }


</script>