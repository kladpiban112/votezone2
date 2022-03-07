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
    $today_date = date("Y-m-d");
    if($logged_user_role_id == '1'){
        $conditions = " ";
    }else{
        $conditions = " AND s.org_id = '$logged_org_id' ";
    }

    $numb_service = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."service_main s WHERE s.flag != '0' $conditions ")->fetchColumn();

    $numb_service_today = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."service_main s WHERE s.flag != '0' AND s.service_date = '$today_date' $conditions  ")->fetchColumn();

    $numb_equipment = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."equipment_main s WHERE s.flag != '0' $conditions  ")->fetchColumn();
    $numb_donate = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."donate_main s WHERE s.flag != '0'  $conditions  ")->fetchColumn();
    ?>

	<div class="row">
							<div class="col-xl-3">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="far fa-user fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_service;?></div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">ผู้รับบริการทั้งหมด</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-3">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-calendar-day fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_service_today;?></div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">รับบริการวันนี้</a>
                                        </div>
                                    </div>
                            </div>


                            <div class="col-xl-3">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-wheelchair fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_equipment;?></div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">จำนวนกายอุปกรณ์</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-3">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-boxes fa-3x text-success"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo $numb_donate;?></div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">จำนวนรับบริจาค</a>
                                        </div>
                                    </div>
                            </div>

					
					
					
				</div>


<div class="row">

				<div class="col-lg-12 col-xxl-12">
		<!--begin::Advance Table Widget 1-->
<div class="card card-custom card-stretch gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">รายการยืมคืน</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">ทั้งหมด <?php echo $numb_service;?> รายการ</span>
        </h3>
        <div class="card-toolbar">
            <a href="?module=borrow&page=person-add" class="btn btn-success btn-sm font-weight-bolder font-size-sm">
            <i class="fas fa-plus-circle"></i></span>บันทึกรายการยืม-คืน
            </a>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body py-0">
    <?php 
    //$numb_data = $conn->query("SELECT count(1) FROM ".DB_PREFIX."service_main s  WHERE s.flag != '0' $conditions  ")->fetchColumn();
        
        $stmt_data = $conn->prepare ("SELECT p.*,s.*,o.org_name,o.org_shortname,pr.prename AS prename_title,t.service_title,a.grp_eq
        FROM ".DB_PREFIX."service_main s 
        LEFT JOIN ".DB_PREFIX."service_type t ON s.service_type = t.service_typeid
        LEFT JOIN ".DB_PREFIX."person_main p ON s.person_id = p.oid
        LEFT JOIN ".DB_PREFIX."org_main o ON p.org_id = o.org_id
        LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
        LEFT JOIN (
            SELECT sd.service_id,GROUP_CONCAT('(',e.eq_code,')',e.eq_name,' ') AS grp_eq
            FROM ".DB_PREFIX."service_data sd
            LEFT JOIN ".DB_PREFIX."equipment_main e ON sd.eq_id = e.oid
            WHERE sd.flag = '1' GROUP BY sd.service_id
        )a ON s.service_id = a.service_id
        WHERE s.flag != '0' $conditions 
        ORDER BY s.service_id DESC
        LIMIT 5 ");
        $stmt_data->execute();

    ?>
        <!--begin::Table-->
        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center table-hover " id="kt_advance_table_widget_1" style="min-height: 300px;">
                <thead>
                    <tr class="text-left">


                        <th class="text-center">ลำดับ</th>
                        <th>ผู้รับบริการ</th>
                        <th>ชื่อรับบริการ</th>
                        <th>วันที่รับบริการ</th>
                        <th class="text-center">ประเภทรับบริการ</th>
                        <th>กายอุปกรณ์</th>
                        <th>หน่วยงาน</th>
                        <!--<th class="text-center">สถานะ</th>-->
                        <th class="text-center">จัดการ</th>	


                    </tr>
                </thead>
                <tbody>
                <?php

            $r  = 1;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $i++;
                $oid = $row['oid'];
                $personid_enc = base64_encode($oid);
                $service_id = $row['service_id'];
                $serviceid_enc = base64_encode($service_id);
                $prename = $row['prename_title'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $fullname = $prename.$fname." ".$lname;
                $cid = $row['cid'];
                $org_name = $row['org_name'];
                $org_shortname = $row['org_shortname'];
                $birthdate = date_db_2form($row['birthdate']);
                $img_profile = $row['img_profile'];

                $servicedate = date_db_2form($row['service_date']);
                $servicetype = $row['service_type'];
                $service_title = $row['service_title'];
                $grp_eqname = $row['grp_eq'];
      

                ?>
                    <tr>
                        <td class="pl-0">
                        <?php echo $r;?>
                        </td>
                        <td class="pr-0">
                            <div class="symbol symbol-50 symbol-light mt-1">
                                <span class="symbol-label">
                                 
                                    <?php if($img_profile == ""){?>
                                <img src="uploads/equipment/no-image.jpg" alt="image" class="h-75 align-self-end"/>
                            <?php }else{?>
                                <img src="uploads/person/<?php echo $img_profile;?>" alt="image" class="h-75 align-self-end"/>
                                <?php   } ?>
                                </span>
                            </div>
                        </td>
                        <td class="pl-0">
                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $fullname;?></a>
                            <span class="text-muted font-weight-bold text-muted d-block">เลขบัตร : <?php echo $cid;?></span>
                        </td>
                        <td><?php echo $servicedate;?></td>
                            <td ><?php echo $service_title;?></td>
                            <td><?php echo str_replace(",","<br>",$grp_eqname);?></td>
                            <td><?php echo $org_shortname;?></td>
                            
                            <!--<td class="text-center"><span class="label label-lg label-light-<?php echo $status_color;?> label-inline"><?php echo $status_title;?></span></td>-->
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
                                            <a href="dashboard.php?module=borrow&page=borrow-print&personid=<?php echo $personid_enc;?>&serviceid=<?php echo $serviceid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">รายละเอียด</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=borrow&page=person-add&personid=<?php echo $personid_enc;?>&serviceid=<?php echo $serviceid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลผู้รับบริการ</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=borrow&page=borrow-add&personid=<?php echo $personid_enc;?>&serviceid=<?php echo $serviceid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลการรับบริการ</span>
                                            </a>
                                        </li>



                                        <!--<li class="navi-separator my-3"></li>

                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                                <span class="navi-text">ยกเลิกรายการ</span>
                                            </a>
                                        </li> -->
                                    </ul>
                                    <!--end::Navigation-->
                                    </div>
                                </div>
                <!--end::Dropdown-->
                            </td>
                    
                    </tr>
                    <?php 
                    $r++;
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