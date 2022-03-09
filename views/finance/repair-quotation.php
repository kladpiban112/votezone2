<?php
error_reporting(0);

$startdate = filter_input(INPUT_GET, 'startdate', FILTER_SANITIZE_STRING);
$startdate_ymd = date_saveto_db($startdate);

$enddate = filter_input(INPUT_GET, 'enddate', FILTER_SANITIZE_STRING);
$enddate_ymd = date_saveto_db($enddate);


$payment_success = filter_input(INPUT_GET, 'payment_success', FILTER_SANITIZE_STRING);
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$qt_status = filter_input(INPUT_GET, 'qt_status', FILTER_SANITIZE_STRING);

if(($startdate_ymd != "") AND ($enddate_ymd != "")){
    $repairdate_data = " AND u.repair_date BETWEEN '$startdate_ymd'  AND  '$enddate_ymd' ";
}else if(($startdate_ymd != "") AND ($enddate_ymd == "")){
    $repairdate_data = " AND u.repair_date >= '$startdate_ymd'  ";
}

if($search != ""){
    $search_data = " AND p.cid LIKE '%$search%' OR p.fname LIKE '%$search%'  ";
}

// if($payment_success != ""){
//     $payment_success_data = " AND pm.cost_success = '$payment_success' ";
// }else{
//     $payment_success_data = " AND pm.cost_success = '0' ";
// }
/*if($repairdate_ymd != ""){
    $repairdate_data = " AND u.repair_date = '$repairdate_ymd'  ";
}*/
if($qt_status != ""){
    $qtstatus_data = " AND u.qt_status = '$qt_status'  ";
}
?>
		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                <i class="fas fa-file-invoice-dollar"></i>&nbsp;ข้อมูลใบเสนอราคา/อนุมัติงานซ่อม
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<!--<a href="dashboard.php?module=repair&page=repair-add" class="btn btn-success btn-sm font-weight-bold mr-2" title="เพิ่มรายการแจ้งซ่อม"><i class="fa fa-plus-circle" title="เพิ่มรายการแจ้งซ่อม" data-toggle="tooltip"></i>บันทึกแจ้งซ่อม</a>
                        <a href="views/repair/repair-main-excel.php?startdate=<?php echo $startdate; ?>&enddate=<?php echo $enddate; ?>&status=<?php echo $status; ?>&search=<?php echo $search;?>&act=export" target="_blank" class="btn btn-info btn-sm font-weight-bold mr-2" title="ส่งออกข้อมูล Excel"><i class="fas fa-download " title="ส่งออกข้อมูล Excel" data-toggle="tooltip"></i> ส่งออกข้อมูล</a>-->
					</div>
				</div>
			</div>



	<div class="card-body">

    <?php
    
    ?>

    <!-- <div class="row">
							
                            <div class="col-xl-2">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-calendar-day fa-2x text-info"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php //echo $numb_service_today;?>9,999</div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">ชำระวันนี้</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-xl-2">
                                    <div class="card card-custom gutter-b" style="height: 150px">
                                        <div class="card-body">
                                            <span class="svg-icon svg-icon-3x svg-icon-success"><i class="fas fa-cash-register fa-2x text-info"></i></span>
                                            <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php //echo $numb_service_today;?>9,999</div>
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">รอชำระ</a>
                                        </div>
                                    </div>
                            </div>
    </div>
 -->



    <form class="form" enctype="multipart/form-data" method="GET">
    <input type="hidden" class="form-control"  name="act"  value="<?php echo $action;?>"/>
    <input type="hidden" class="form-control"  name="module"  value="<?php echo $module;?>"/>
    <input type="hidden" class="form-control"  name="page"  value="repair-quotation"/>

    <div class="form-group row">
            <div class="col-lg-2">
				<label>ตั้งแต่วันที่</label>
				<input type="text" class="form-control"  name="startdate" id="startdate" placeholder="วันที่แจ้งซ่อม" value="<?php echo $startdate;?>"  data-date-language="th-th" maxlength="10" />
				<span class="form-text text-muted"></span>
				
			</div>

            <div class="col-lg-2">
				<label>ถึงวันที่</label>
				<input type="text" class="form-control"  name="enddate" id="enddate" placeholder="วันที่แจ้งซ่อม" value="<?php echo $enddate;?>"  data-date-language="th-th" maxlength="10" />
				<span class="form-text text-muted"></span>
				
			</div>

            <div class="col-lg-2">
                <label>สถานะการเสนอราคา</label>
                                          <select class="form-control " name="qt_status" id="qt_status">
                                                      <option value="" <?php if($qt_status == ''){echo "selected";}?>>ทั้งหมด</option>
                                                      <option value="0" <?php if($qt_status == '0'){echo "selected";}?>>รอเสนอราคา</option>
                                                      <option value="1" <?php if($qt_status == '1'){echo "selected";}?>>เสนอราคาแล้ว</option>
                                                      <option value="2" <?php if($qt_status == '2'){echo "selected";}?>>อนุมัติซ่อม</option>
                                                      <option value="3" <?php if($qt_status == '3'){echo "selected";}?>>ไม่อนุมัติซ่อม</option>
                                                      
                                          </select>
             </div>

             <div class="col-lg-3">
				<label>เลขบัตรประชาชน/ชื่อสกุล</label>
				<div class="input-group">
							<input type="text" class="form-control" placeholder="เลขบัตรประชาชน/ชื่อสกุล"  name="search" id="search"  value="<?php echo $search;?>"/>
							<div class="input-group-append">
								<button class="btn btn-primary" type="submit" ><i class="fas fa-search"></i></button>
							</div>
						</div>
			</div>

            </div>

    </form> 

    <?php
       if($logged_user_role_id == '1'){
        $conditions = " ";
        }else{

        $conditions = " AND u.org_id = '$logged_org_id' ";
        }
    $sql = "SELECT count(1) FROM ".DB_PREFIX."repair_main u  
    LEFT JOIN ".DB_PREFIX."person_main p ON u.person_id = p.oid
    WHERE u.flag != 0  $conditions  $search_data $repairdate_data $qtstatus_data $payment_success_data  ";    
    $numb_data = $conn->query($sql)->fetchColumn();

  
        if (!(isset($pagenum))) { $pagenum = 1; }
        if ($numb_data==0) { echo "No Data"; }
        else{
        $page_rows = 10;
        $last = ceil($numb_data/$page_rows);

        if ($pagenum < 1)
        {
        $pagenum = 1;
        }
        elseif ($pagenum > $last)
        {
        $pagenum = $last;
        }

        //สำหรับจัดการหน้า
        $numb_data = $numb_data;
        if($numb_data<=$page_rows)	{
            $Num_Pages =1;
        }else if(($numb_data % $page_rows)==0){
            $Num_Pages =($numb_data/$page_rows) ;
        }else{
            $Num_Pages =($numb_data/$page_rows)+1;
            $Num_Pages = (int)$Num_Pages;
        }

        $max = ' LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;	
        
        $sql = "SELECT u.*,p.*,o.org_shortname ,t.repair_typetitle,if(e.eq_code IS NOT NULL ,e.eq_code,u.eq_code) AS eq_code, if(e.eq_name IS NOT NULL ,e.eq_name,u.eq_name) AS eq_name,st.status_title,u.qt_status
        FROM ".DB_PREFIX."repair_main u 
        LEFT JOIN ".DB_PREFIX."org_main o ON u.org_id = o.org_id 
        LEFT JOIN ".DB_PREFIX."repair_type t ON u.repair_type = t.repair_typeid
        LEFT JOIN ".DB_PREFIX."person_main p ON u.person_id = p.oid
        LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
        LEFT JOIN ".DB_PREFIX."equipment_main e ON u.eq_id = e.oid
        LEFT JOIN ".DB_PREFIX."repair_status_type st ON u.repair_status = st.status_typeid
        WHERE u.flag != 0    $conditions $search_data  $repairdate_data $qtstatus_data $payment_success_data
        ORDER BY u.repair_id DESC
        $max";
        $stmt_data = $conn->prepare ($sql);
        $stmt_data->execute();		


    ?>


<span>จำนวน <?php echo $numb_data;?> รายการ</span>
<div class="table-responsive">
	<table class="table table-bordered table-hover table-strip" id="tbData" style="margin-top: 13px !important; min-height: 200px;">
    <thead>
    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>เลขที่แจ้งซ่อม</th>
                        <th>วันที่แจ้งซ่อม</th>
                        <!-- <th>รูปแบบการซ่อม</th> -->
                        <th>ประเภทแจ้งซ่อม</th>
                        <th>อุปกรณ์</th>
                        <th>อาการแจ้งซ่อม</th>
                        <th>ผู้แจ้ง</th>
                        
                        <th >วันที่เสนอราคา</th>
                        <th >เลขที่ใบเสนอราคา</th>
                        <th >ราคาค่าซ่อม</th>
                        <th class="text-center">สถานะใบเสนอราคา</th>
                        <th class="text-center">วันที่อนุมัติซ่อม</th>
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


                $stmt_qt = $conn->prepare ("SELECT qt.*,qts.qt_statusname,qts.qt_statusicon  FROM ".DB_PREFIX."repair_quotation qt 
                    LEFT JOIN ".DB_PREFIX."repair_quotation_status qts ON qt.qt_status = qts.qt_statusid
                    WHERE qt.flag = '1' AND qt.repair_id = '$repairid'  ORDER BY qt.oid DESC");
                    $stmt_qt->execute();	
                    $row_qt = $stmt_qt->fetch(PDO::FETCH_ASSOC);
 


                $qt_id = $row_qt['oid'];
                $qt_id_enc = base64_encode($qt_id);
                $qt_statusname = $row_qt['qt_statusname'];
                $qt_date = date_db_2form($row_qt['qt_date']);
                $qt_code = $row_qt['qt_code'];
                $qt_price = $row_qt['qt_price'];
                $qt_approvedate = date_db_2form($row_qt['qt_approvedate']);
                $qt_pricetotal = $row_qt['qt_pricetotal'];
                $qt_statusicon = $row_qt['qt_statusicon'];


                ?>
                <tr>
                            <td class="text-center"><?php echo $i;?></td>
                            <td class="text-center"><?php echo $repair_code;?></td>
                            <td><?php echo $repair_date;?></td>
                            <!-- <td class="text-center"><?php echo $repair_inout_show;?></td> -->
                            <td><?php echo $repair_typetitle;?></td>
                            <td><?php echo $eq_name;?></br><small>รหัส : <?php echo $eq_code;?></small></td>
                            <td><?php echo $repair_title;?></td>
                            <td><?php echo $fullname;?></td>
                            
                            <td><?php echo $qt_date;?></td>
                            <td><?php echo $qt_code;?></td>
                            <td class="text-center"><?php echo $qt_pricetotal;?></td>
                            <td class="text-center"><?php echo $qt_statusicon." ".$qt_statusname;?></td>
                            <td class="text-center"><?php echo $qt_approvedate;?></td>

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
                                        <?php if($qt_id != ""){?>
                                        <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=repair-quotation-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&qtid=<?php echo $qt_id_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-print"></i></span>
                                                <span class="navi-text">ใบเสนอราคา</span>
                                            </a>
                                        </li>
                                        <?php }?>

                                        <!-- <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=repair-invoice-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="far fa-file-pdf"></i></span>
                                                <span class="navi-text">ใบแจ้งหนี้</span>
                                            </a>
                                        </li> -->

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=repair-quotation-add&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">จัดการใบเสนอราคา</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=repair-quotation-add&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="far fa-calendar-check"></i></span>
                                                <span class="navi-text">อนุมัติงานซ่อม</span>
                                            </a>
                                        </li>

                                        
                                    </ul>
                                    <?php }else{?>

                                        <ul class="navi navi-hover py-1">
                                        <li class="navi-item">
                                            <a href="dashboard.php?module=repairout&page=repairout-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">ใบส่งซ่อมภายนอก</span>
                                            </a>
                                        </li>

                                        <!-- <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=repairout-invoice-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="far fa-file-pdf"></i></span>
                                                <span class="navi-text">ใบแจ้งหนี้</span>
                                            </a>
                                        </li> -->

                                        <?php if($qt_id != ""){?>
                                        <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=repair-quotation-print&personid=<?php echo $personid_enc;?>&repairid=<?php echo $repairid_enc;?>&qtid=<?php echo $qt_id_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-print"></i></span>
                                                <span class="navi-text">ใบเสนอราคา</span>
                                            </a>
                                        </li>
                                        <?php }?>


                                        <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=repair-quotation-add&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">จัดการใบเสนอราคา</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=repair-quotation-add&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="far fa-calendar-check"></i></span>
                                                <span class="navi-text">อนุมัติงานซ่อม</span>
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
  

<div class="d-flex justify-content-between align-items-center flex-wrap">
    <div class="d-flex flex-wrap py-2 mr-3">


<?php 
$p = 4;	//	กำหนดช่วงตัวเลขทางซ้าย และ ขวา ของหน้าที่ถูกเลือก
$Prev_Page = $pagenum-1;
$Next_Page = $pagenum+1;
$page_link = "dashboard.php?module=$module&page=main&search=$search&startdate=$startdate&stopdate=$stopdate&payment_success=$payment_success&pagenum";

if($pagenum==1)		//	กรณีอยู่หน้า 1 หรือยังไม่เลือกหน้า
{
    echo "<a class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";
            for($a=1;$a<=$p;$a++)
            {
                    if($pagenum+$a<$Num_Pages)
                    {
                    echo  "<a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum+$a)."' >".($pagenum+$a)."</a>";
                    }
            }
    if($Num_Pages==2)
    {
        echo "<a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Num_Pages'>$Num_Pages</a> ";		// แสดงหน้าสุดท้าย
        echo " <a class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Next_Page' title='หน้าถัดไป'><i class='ki ki-bold-arrow-next icon-xs'></i></a> ";		//	แสดงเครื่องหมาย >>
    }
}
else		// กรณีอยู่หน้าอื่นๆ
{
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Prev_Page' title='หน้าก่อนหน้า'><i class='ki ki-bold-arrow-back icon-xs'></i></a> ";		//	แสดงเครื่องหมาย <<
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=1'>1</a> ";		//	แสดงหมายเลข 1
}

if($pagenum==2 )	//	ถ้าอยู่หน้า 2
{
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";
        for($a=1;$a<=$p;$a++)
        {
            if($pagenum+$a<$Num_Pages)
            {		
                echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum+$a)."' >".($pagenum+$a)."</a>";
            }
        }		
}

if($pagenum>2 && $pagenum<$Num_Pages)	//	ถ้าอยู่หน้ามากกว่า 2 แต่น้อยกว่าหน้าสุดท้าย
{
    for($a=$p;$a>=1;$a--)		//	หา $p หน้าด้านซ้าย
    {
        if($pagenum-$a>1)	//	$p หน้าด้านซ้ายต้องมากกว่า 1
        {
            echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum-$a)." '>".($pagenum-$a)."</a>";
        }
    }
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";		//	หน้าปัจจุบัน
    for($a=1;$a<=$p;$a++)		//	หา $p หน้าด้านขวา
    {
        if($pagenum+$a<$Num_Pages)		//	$p หน้าด้านขวาต้องน้อยกว่าหน้าสุดท้าย
        {
            echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum+$a)."' >".($pagenum+$a)."</a>";
        }
    }
}

if($pagenum==$Num_Pages && $Num_Pages!=1 && $Num_Pages!=2)		//	ถ้าเลือกหน้าสุดท้าย
{
    for($a=$p;$a>=1;$a--)		//	หา $p หน้าด้านซ้าย
    {
        if($pagenum-$a>1)
        {
        echo  "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href='$page_link=".($pagenum-$a)." '>".($pagenum-$a)."</a>";
        }
    }
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1' href='$page_link=$pagenum'>$pagenum</a>";		//	แสดงหน้าปัจจุบัน
}

else if($Num_Pages!=1 && $Num_Pages!=2)	//	กรณีไม่ได้เลือกหน้าสุดท้าย
{
    echo "<a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Num_Pages'>$Num_Pages</a> ";		// แสดงหน้าสุดท้าย
    echo " <a  class='btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1' href ='$page_link=$Next_Page' title='หน้าถัดไป'><i class='ki ki-bold-arrow-next icon-xs'></i></a> ";		//	แสดงเครื่องหมาย >>
}


?>



    </div>

    <div class="d-flex align-items-center py-3">
        <span class="text-muted">หน้า <?php echo $pagenum;?> / <?php echo $last;?> </span>
    </div>
</div>


            
<?php
					} // end if
					?>
		
	</div>
	<div class="card-footer">
		<div class="row">
			
		</div>
	</div>


</div>
		<!--end::Card-->

<script>

$('#repairdate').datepicker({
        autoclose: true
});

$('#startdate').datepicker({
        autoclose: true
});

$('#enddate').datepicker({
        autoclose: true
});


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



