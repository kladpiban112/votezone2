<?php
error_reporting(0);

$startdate = filter_input(INPUT_GET, 'startdate', FILTER_SANITIZE_STRING);
$startdate_ymd = date_saveto_db($startdate);
$enddate = filter_input(INPUT_GET, 'enddate', FILTER_SANITIZE_STRING);
$enddate_ymd = date_saveto_db($enddate);
$paymenttype = filter_input(INPUT_GET, 'paymenttype', FILTER_SANITIZE_STRING);
$paymentmethod = filter_input(INPUT_GET, 'paymentmethod', FILTER_SANITIZE_STRING);
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

if(($startdate_ymd != "") AND ($enddate_ymd != "")){
    $paymentdate_data = " AND t.payment_date BETWEEN '$startdate_ymd'  AND  '$enddate_ymd' ";
}else if(($startdate_ymd != "") AND ($enddate_ymd == "")){
    $paymentdate_data = " AND t.payment_date >= '$startdate_ymd'  ";
}

if($search != ""){
    $search_data = " AND t.payment_no LIKE '%$search%' ";
}

if($paymenttype != ""){
    $paymenttype_data = " AND t.payment_type = '$paymenttype' ";
}else{
    $paymenttype_data = "  ";
}

if($paymentmethod != ""){
    $paymentmethod_data = " AND t.payment_method = '$paymentmethod' ";
}else{
    $paymentmethod_data = "  ";
}

?>
		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                <i class="fas fa-wallet"></i>&nbsp;ข้อมูลการรับเงิน
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<!--<a href="dashboard.php?module=repair&page=repair-add" class="btn btn-success btn-sm font-weight-bold mr-2" title="เพิ่มรายการแจ้งซ่อม"><i class="fa fa-plus-circle" title="เพิ่มรายการแจ้งซ่อม" data-toggle="tooltip"></i>บันทึกแจ้งซ่อม</a>
                        <a href="views/repair/repair-main-excel.php?startdate=<?php echo $startdate; ?>&enddate=<?php echo $enddate; ?>&status=<?php echo $status; ?>&search=<?php echo $search;?>&act=export" target="_blank" class="btn btn-info btn-sm font-weight-bold mr-2" title="ส่งออกข้อมูล Excel"><i class="fas fa-download " title="ส่งออกข้อมูล Excel" data-toggle="tooltip"></i> ส่งออกข้อมูล</a>-->
					</div>
				</div>
			</div>



	<div class="card-body">
<!--
    <div class="row">
							
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
    <input type="hidden" class="form-control"  name="page"  value="payment-trans-list"/>

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
                <label>ประเภทชำระเงิน</label>
                                          <select class="form-control " name="paymenttype" id="paymenttype">
                                                      <option value="" <?php if($paymenttype == '0'){echo "selected";}?>>ทั้งหมด</option>
                                                      <?php
                                               
                                                            $stmt_user_role = $conn->prepare("SELECT s.* FROM ".DB_PREFIX."payment_type s 
                                                            WHERE s.active = 1  ");
                                                            $stmt_user_role->execute();		
                                                            while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                                                              {
                                                              $id_selected = $row['doctype'];
                                                              $title_selected = stripslashes($row['docname']);
                                                              ?>
                                                              <option value="<?php echo $id_selected;?>" <?php if($paymenttype == $id_selected){echo "selected";}?>><?php echo $title_selected;?></option>
                                                              <?php
                                                              }
                                                            ?>
                            
                                                      
                                          </select>
             </div>

             <div class="col-lg-2">
                <label>วิธีชำระเงิน</label>
                                          <select class="form-control " name="paymentmethod" id="paymentmethod">
                                                      <option value="" <?php if($paymentmethod == ''){echo "selected";}?>>ทั้งหมด</option>
                                                      <?php
                                               
                                                            $stmt_user_role = $conn->prepare("SELECT s.* FROM ".DB_PREFIX."payment_method s 
                                                            WHERE s.flag = 1  ");
                                                            $stmt_user_role->execute();		
                                                            while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                                                              {
                                                              $id_selected = $row['m_id'];
                                                              $title_selected = stripslashes($row['m_title']);
                                                              ?>
                                                              <option value="<?php echo $id_selected;?>" <?php if($paymentmethod == $id_selected){echo "selected";}?>><?php echo $title_selected;?></option>
                                                              <?php
                                                              }
                                                            ?>
                                                      
                                                      
                                          </select>
             </div>

             <div class="col-lg-3">
				<label>เลขที่เอกสาร	</label>
				<div class="input-group">
							<input type="text" class="form-control" placeholder="เลขที่เอกสาร"  name="search" id="search"  value="<?php echo $search;?>"/>
							<div class="input-group-append">
								<button class="btn btn-primary" type="submit" ><i class="fas fa-search"></i></button>
							</div>
						</div>
			</div>

            </div>

    </form> 

    <?php
       if($logged_user_role_id == '1'){
        $conditions = " AND r.org_id = '$logged_org_id' ";
        }else{

        $conditions = " AND r.org_id = '$logged_org_id' ";
        }
    $sql = "SELECT count(1) FROM ".DB_PREFIX."payment_trans t
    LEFT JOIN ".DB_PREFIX."payment_type pt ON t.payment_type = pt.doctype
    LEFT JOIN ".DB_PREFIX."payment_method pm ON t.payment_method = pm.m_id
    LEFT JOIN ".DB_PREFIX."repair_main r ON t.tranid = r.repair_id 
    WHERE t.flag IS NOT NULL $paymentdate_data $paymentmethod_data $paymenttype_data $search_data $conditions
    ORDER BY t.id DESC ";    
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
        
        $sql = "SELECT t.*,pt.docname ,pm.m_title,r.repair_code,r.repair_title,r.repair_id,r.person_id
        FROM ".DB_PREFIX."payment_trans t
        LEFT JOIN ".DB_PREFIX."payment_type pt ON t.payment_type = pt.doctype
        LEFT JOIN ".DB_PREFIX."payment_method pm ON t.payment_method = pm.m_id
        LEFT JOIN ".DB_PREFIX."repair_main r ON t.tranid = r.repair_id 
        WHERE t.flag IS NOT NULL $paymentdate_data $paymentmethod_data $paymenttype_data $search_data $conditions
        ORDER BY t.id DESC
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
    <th>วันที่ชำระ</th>
                <th>เลขที่เอกสาร</th>
                <th>ประเภท</th>
                <th>เลขที่แจ้งซ่อม</th>
                <th>เรื่องแจ้งซ่อม</th>
                <th>จำนวนเงิน</th>
                <th>วิธีชำระ</th>
                <th>สถานะ</th>
                <th class="text-center">จัดการ</th>
    </tr>
    </thead>
    <tbody>
            
            <?php

            $i  = 0;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $i++;
                $oid = $row['id'];
                $oid_enc = base64_encode($oid);
                $repairid = $row['repair_id'];
                $repairid_enc = base64_encode($repairid);
                $personid = $row['person_id'];
                $personid_enc = base64_encode($personid);

                $repair_code = $row['repair_code'];
                $repair_title = $row['repair_title'];

                $payment_date = date_db_2form($row['payment_date']);
                $payment_no = $row['payment_no'];
                $payment_type = $row['payment_type'];
                $doc_no = $payment_type.$payment_no;
                $docname = $row['docname'];
                $method_payment = $row['m_title'];
                $amount = number_format($row['amount'],2);
                $flag = $row['flag'];
                if($flag == '0'){
                    $payment_status = '<i class="far fa-times-circle text-danger"></i>';
                }else{
                    $payment_status = '<i class="far fa-check-circle text-success"></i>';
                }


 
                ?>
                <tr>
                <td class="text-center" width="20px"><?php echo $i; ?></td>

                <td><?php echo $payment_date; ?></td>
                <td><?php echo $doc_no; ?></td>
                <td><?php echo $docname; ?></td>
                <td><?php echo $repair_code; ?></td>
                <td><?php echo $repair_title; ?></td>
                <td><?php echo $amount; ?></td>
                <td><?php echo $method_payment; ?></td>
                <td class="text-center"><?php echo $payment_status; ?></td>
                <td class="text-center">
                <?php if($flag == '1'){ ?>
                    <!--begin::Dropdown-->
                    <div class="dropdown">
                        <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                            <i class="ki ki-bold-more-hor font-size-md"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover py-1">

                                <li class="navi-item">
                                    <a href="dashboard.php?module=finance&page=payment-invoice-print&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&id=<?php echo $oid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link" >
                                        <span class="navi-icon"><i class="fas fa-print"></i></span>
                                        <span class="navi-text">พิมพ์ใบชำระเงิน</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="dashboard.php?module=finance&page=payment-repair-add&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&id=<?php echo $oid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link" >
                                        <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                        <span class="navi-text">แก้ไขรายการชำระเงิน</span>
                                    </a>
                                </li>

                                <!--<li class="navi-item">
                                    <a href="#" class="navi-link" onclick='delPaymentData(<?php echo $oid; ?>)'>
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">ยกเลิกรายการ</span>
                                    </a>
                                </li>-->
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                    <!--end::Dropdown-->
                    <?php } ?>

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
$page_link = "dashboard.php?module=$module&page=main&search=$search&startdate=$startdate&stopdate=$stopdate&paymenttype=$paymenttype&paymentmethod=$paymentmethod&pagenum";

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



