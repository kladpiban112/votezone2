<?php
error_reporting(0);
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$cid_search = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
$hn_search = filter_input(INPUT_GET, 'hn', FILTER_SANITIZE_STRING);
$search_data = "";
if($cid_search != ""){
    // $cid_data = " AND p.cid LIKE '%$cid_search%'  ";
}
if($search != ""){
    // $search_data = " AND  p.fname LIKE '%$search%'  ";
}
error_reporting(0);

$personid_enc = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$serviceid_enc = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid_enc);
$serviceid = base64_decode($serviceid_enc);
$action = base64_decode($act);


?>
		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                <i class="far fa-user"></i>&nbsp;ข้อมูลเขตเลือกตั้ง
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="dashboard.php?module=<?php echo $module;?>&page=zone-add" class="btn btn-success btn-sm font-weight-bold mr-2" title="เพิ่มบุคคล"><i class="fa fa-plus-circle" title="เพิ่มเขตเลือกตั้ง" data-toggle="tooltip"></i>เพิ่มเขตเลือกตั้ง</a>
                    </div>
				</div>
			</div>

	<div class="card-body">
    <form class="form" enctype="multipart/form-data" id="frmSearch" method="GET">
    <input type="hidden" class="form-control"  name="act" id="act" value="search"/>
    <input type="hidden" class="form-control"  name="module"  value="<?php echo $module;?>"/>
    <input type="hidden" class="form-control"  name="page"  value="main"/>
    
    <input type="hidden" class="form-control"  name="txt_ampur" id="txt_ampur" value="<?php echo $row_person['ampur'];?>"/>
    <input type="hidden" class="form-control"  name="txt_tambon" id="txt_tambon" value="<?php echo $row_person['tambon'];?>"/>
    <div class="form-group row">
    <div class="col-lg-2">
				<label>เขตการเลือกตั้ง</label>
                <input type="text" class="form-control form-control-sm"   placeholder="เขตการเลือกตั้ง" />
                        
            
			</div>
    <div class="col-lg-2">
    <label>จังหวัด</label>
            <select class="form-control form-control-sm" name="changwat" id="changwat">
                        
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

      <div class="col-lg-2">
				<label>อำเภอ</label>
            <select class="form-control form-control-sm" name="ampur" id="ampur">
                        <option value="">ระบุ</option>
            </select>
			</div>

      <div class="col-lg-2">
				<label>ตำบล</label>
            <select class="form-control form-control-sm" name="tambon" id="tambon">
                        <option value="">ระบุ</option>
            </select> 
           
           </div>
           <div class="row-lg-2 mt-8" >
 <button class="btn btn-primary btn-sm" type="submit" ><i class="fas fa-search"></i></button>
             <!-- <span><i class="fas fa-house-user"></i> ที่อยู่ปัจจุบัน :</span>
   <hr>
		<div class="form-group row">
			<div class="col-lg-3">
				<label>บ้านเลขที่</label>
				<input type="text" class="form-control form-control-sm"  name="house_now" id="house_now" placeholder="บ้านเลขที่" value="<?php echo $row_person['house_now'];?>"/>
				
			</div>
			<div class="col-lg-4">
				<label>หมู่บ้าน/ชุมชน</label>
        <input type="text" class="form-control form-control-sm"  name="community_now" id="community_now" placeholder="หมู่บ้าน/ชุมชน" value="<?php echo $row_person['community_now'];?>"/>
				
			</div>

			
            <div class="col-lg-3">
				<label>ถนน</label>
             <input type="text" class="form-control form-control-sm"  name="road_now" id="road_now" placeholder="ถนน" value="<?php echo $row_person['road_now'];?>"/>
				
			</div>

            <div class="col-lg-2">
				<label>หมู่ที่</label>
				<select class="form-control form-control-sm" name="village_now" id="village_now">
                    <option value=""  <?php if($row_person['village_now'] == "0"){ echo "selected";}?>>0</option>	
                    <?php for ($n_vil = 1; $n_vil <= 99; $n_vil++) { 
                            $n_vil_data = str_pad($n_vil,2,"0",STR_PAD_LEFT);
                            ?>
                                <option value="<?php echo $n_vil_data;?>" <?php if($row_person['village_now'] == $n_vil_data){ echo "selected";}?>><?php echo $n_vil;?></option>
								<?php } ?>
				</select>
			</div>
		</div> -->

        <!-- <input type="hidden" class="form-control"  name="txt_ampur_now" id="txt_ampur_now" value="<?php echo $row_person['ampur_now'];?>"/>
        <input type="hidden" class="form-control"  name="txt_tambon_now" id="txt_tambon_now" value="<?php echo $row_person['tambon_now'];?>"/>
    <div class="form-group row">

    <div class="col-lg-3">
				<label>จังหวัด</label>
            <select class="form-control form-control-sm" name="changwat_now" id="changwat_now">
                        
            <?php
                    $stmt = $conn->prepare ("SELECT * FROM cchangwat c ");
                    $stmt->execute();
                    echo "<option value=''>-ระบุ-</option>";
                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id = $row->changwatcode;
                    $name = $row->changwatname; ?>
                    <option value="<?php echo $id;?>" <?php if($row_person['changwat_now'] == $id){ echo "selected";}?>><?php echo $name;?></option>
                    <?php 
                    }
                    ?>
            </select>
				
			</div>

      <div class="col-lg-3">
				<label>อำเภอ</label>
            <select class="form-control form-control-sm" name="ampur_now" id="ampur_now">
                        <option value="">ระบุ</option>
            </select>
			</div>

      <div class="col-lg-3">
				<label>ตำบล</label>
            <select class="form-control form-control-sm" name="tambon_now" id="tambon_now">
                        <option value="">ระบุ</option>
            </select>
			</div>



      </div> -->
			</div>

            </div>

    </form> 

    <?php

    if($logged_user_role_id == '1'){
        $conditions = " ";
    }else{
        $conditions = " ";
    }

    $numb_data = $conn->query("SELECT count(1) FROM ".DB_PREFIX."area ")->fetchColumn();

  
        if (!(isset($pagenum))) { $pagenum = 1; }
        if ($numb_data==0) { echo "No Data"; }
        else{
        $page_rows = 20;
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
        $Page_Start = ($pagenum - 1) * $page_rows; // สำหรับลำดับ
        $max = ' LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;		
        $stmt_data = $conn->prepare ("SELECT * FROM ".DB_PREFIX." area p 
        LEFT JOIN cchangwat c ON p.changwat = c.changwatcode
        LEFT JOIN campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
        LEFT JOIN ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull
        $conditions  $search_data  $cid_data  
        ORDER BY p.aid DESC ");
        $stmt_data->execute();		

    ?>

<div class="table-responsive">
	<table class="table table-bordered table-hover table-strip " id="tbData" style="margin-top: 13px !important; min-height: 300px;">
    <thead>
    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>เขตเลือกตั้ง</th>
                        <th>จังหวัด</th>
                        <th>อำเภอ</th>
                        <th>ตำบล</th>
                        <th>หมู่</th>
                        <th>หน่วยเลือกตั้งที่</th>
                        <th>ชื่อหน่วยเลือกตั้ง</th>
                        <th class="text-center">จัดการ</th>	
    </tr>
    </thead>
    <tbody>
            <?php
            $i  = 0;
            $no = 1;
	        $no = $no * $Page_Start;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $i++;
                $no++;
                $aid = $row['aid'];
                $aid_enc = base64_encode($aid);
                $area_number = $row['area_number'];
                $changwat = $row['changwatname'];
                $ampur = $row['ampurname'];
                $tambon = $row['tambonname'];
                $village = $row['village'];
                $zone_number = $row['zone_number'];
                $zone_name = $row['zone_name'];
                ?>
                <tr>
                            <td class="text-center"><?php echo $no;?></td>
                            <td><?php echo $area_number;?></td>
                            <td><?php echo $changwat;?></td>
                            <td><?php echo $ampur;?></td>
                            <td><?php echo $tambon;?></td>
                            <td><?php echo $village;?></td>
                            <td><?php echo $zone_number;?></td>
                            <td><?php echo $zone_name;?></td>
                            <!--<td class="text-center"><span class="label label-lg label-light-<?php echo $status_color;?> label-inline"><?php echo $status_title;?></span></td>-->
                            <td class="text-center">
                            <!--begin::Dropdown-->
                                <div class="dropdown">
                                    <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                                    <i class="fas fa-sort-down"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <!--begin::Navigation-->
                                    <ul class="navi navi-hover py-1">
                                        <li class="navi-item">
                                            <a href="dashboard.php?module=zone&page=zone-add-person&aid=<?php echo $aid_enc;?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="navi-text">จัดการหน่วยเลือกตั้ง</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="dashboard.php?module=zone&page=zone-add&aid=<?php echo $aid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="navi-text">แก้ไข</span>
                                            </a>
                                        </li>

                                    </ul>
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
$page_link = "dashboard.php?module=$module&page=main&search=$search&cid=$cid_search&hn=$hn_search&pagenum";

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



                    
<!-- Datepicker Thai -->
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-datepicker-thai.js"></script>
<script src="assets/js/locales/bootstrap-datepicker.th.js"></script>  

<script>

$(document).ready(function () {
    'use strict';
    getoptselect_amphur();
	getoptselect_tambon();


}); 

$(".add-more").click(function(){ 
		  //alert(99);
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });


$('#birthdate').datepicker({
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


$("#level").change(function() {
    if($("#level").val() == 1 ){
        $("#head_h").hide();
    }else{
        $("#head_h").show();
    }
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

function confirm_borrow_delete(id) {
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
                            $.post("core/borrow/borrow-main-del.php", {id: id}, function(result){
                                //  $("test").html(result);
                                // console.log(result.code);
                                location.reload();
                            });
                        }
                    })
            }


</script>



