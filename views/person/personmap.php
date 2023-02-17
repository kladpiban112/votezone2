<?php
error_reporting(0);

$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$cid_search = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
$hn_search = filter_input(INPUT_GET, 'hn', FILTER_SANITIZE_STRING);
$cid_search = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
$slevel = filter_input(INPUT_GET, 'slevel', FILTER_SANITIZE_STRING);
$cchangwat = filter_input(INPUT_GET, 'changwat', FILTER_SANITIZE_STRING);
$campur = filter_input(INPUT_GET, 'ampur', FILTER_SANITIZE_STRING);
$ctambon = filter_input(INPUT_GET, 'tambon', FILTER_SANITIZE_STRING);
$cposition1 = filter_input(INPUT_GET, 'cposition1', FILTER_SANITIZE_STRING);
$area= filter_input(INPUT_GET, 'area', FILTER_SANITIZE_STRING);







if($cid_search != ""){
    $cid_data = " AND ps.cid LIKE '%$cid_search%'  ";
}
if($search != ""){
    $search_data = " AND  ps.fname LIKE '%$search%'  OR ps.lname LIKE '%$search%'  ";
}
if($slevel != ""){
    $slevel_data = " AND  ps.level = '$slevel' ";
}
if($cchangwat != ""){
    $cchangwat_data = " AND  ps.changwat = '$cchangwat' ";
}
if($campur != ""){
    $campur_data = " AND  ps.ampur = '$campur' ";
}
if($ctambon != ""){
    $ctambon_data = " AND  ps.tambon = '$ctambon' ";
}
if($cposition1 != ""){
    $cposition1_data = " AND  ps.cposition1 = '$cposition1' ";
}
if($area != ""){
    $area_data = " AND  a.aid = '$area' ";
}

?>


<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-map"></i>&nbsp;แบ่งตามเขตการเลือกตั้ง
        </h3>
        <div class="card-toolbar">

        </div>
    </div>

    <div class="card-body">
        <form class="form" enctype="multipart/form-data" id="frmSearch" method="GET">
            <input type="hidden" class="form-control" name="act" id="act" value="search" />
            <input type="hidden" class="form-control" name="module" value="<?php echo $module;?>" />
            <input type="hidden" class="form-control" name="page" value="personmap" />
            <div class="form-group row">
                <div class="col-lg-2">
                    <label>เขตเลือกตั้ง</label>
                    <select class="form-control form-control-sm" name="area" id="area">

                        <?php
                                $stmt = $conn->prepare ("SELECT * FROM area ");
                                $stmt->execute();
                                echo "<option value=''>-ระบุ-</option>";
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                $id = $row->aid;
                                $name = $row->zone_name; ?>
                        <option value="<?php echo $id;?>"><?php echo $name;?></option>
                        <?php 
                                }
                        ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label>ระดับ</label>
                    <select class="form-control form-control-sm" name="slevel" id="slevel">

                        <?php
                                $stmt = $conn->prepare ("SELECT * FROM level_type ");
                                $stmt->execute();
                                echo "<option value=''>-ระบุ-</option>";
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                $id = $row->level_id;
                                $name = $row->level; ?>
                        <option value="<?php echo $id;?>"><?php echo $name;?></option>
                        <?php 
                                }
                        ?>
                    </select>
                </div>
                <div class="col-lg-1">
                    <label>จังหวัด</label>
                    <select class="form-control form-control-sm" name="changwat" id="changwat" disabled>

                        <?php
                        $stmt = $conn->prepare ("SELECT * FROM cchangwat c   WHERE c.changwatcode = '30'");
                        $stmt->execute();
                        
                        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                        $id = $row->changwatcode;
                        $name = $row->changwatname; ?>
                        <option value="<?php echo $id;?>" <?php if($row_person['changwat'] == $id){ echo "selected";}?>>
                            <?php echo $name;?>
                        </option>
                        <?php 
                                                }
                                            ?>
                    </select>

                </div>

                <div class="col-lg-1">
                    <label>อำเภอ</label>
                    <select class="form-control form-control-sm" name="ampur" id="ampur">
                        <option value="">ระบุ</option>
                    </select>
                </div>

                <div class="col-lg-1">
                    <label>ตำบล</label>
                    <select class="form-control form-control-sm" name="tambon" id="tambon">
                        <option value="">ระบุ</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <label>เลขบัตรประชาชน</label>
                    <input type="text" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน" name="cid"
                        id="cid" value="<?php echo $cid;?>" />
                </div>

                <div class="col-lg-1">
                    <label>อาชีพ</label>
                    <select class="form-control form-control-sm" name="cposition1" id="cposition1">

                        <?php
                                $stmt = $conn->prepare ("SELECT * FROM cposition ");
                                $stmt->execute();
                                echo "<option value=''>-ระบุ-</option>";
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                $id = $row->id;
                                $name = $row->name; ?>
                        <option value="<?php echo $id;?>"><?php echo $name;?></option>
                        <?php 
                                }
                        ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label>ชื่อ-สกุล</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" placeholder="ชื่อ-สกุล" name="search"
                            id="search" value="<?php echo $search;?>" />
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

            </div>

        </form>

        <?php

    if($logged_user_role_id == '1'){
        $conditions = " ";
    }else{
        $conditions = " ";
    }

    $numb_data = $conn->query("SELECT count(1) FROM ".DB_PREFIX."person_sub	ps
        INNER  JOIN".DB_PREFIX." mapping_person mp	ON 	 mp.oid_map = ps.team_id 
	    INNER  JOIN ".DB_PREFIX."	area a ON 	a.aid = mp.aid
        WHERE ps.flag != '0' $conditions  $search_data  $cid_data  $slevel_data $cchangwat_data $campur_data $ctambon_data $cposition1_data  $area_data ")->fetchColumn();

  
        if (!(isset($pagenum))) { $pagenum = 1; }
        if ($numb_data==0) { echo "No Data"; }
        else{
        $page_rows = 15;
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
        $stmt_data = $conn->prepare ("SELECT mp.*,a.*,ps.*
        FROM ".DB_PREFIX." person_sub ps
        INNER JOIN".DB_PREFIX." mapping_person mp ON  mp.oid_map = ps.team_id 
	    INNER  JOIN ".DB_PREFIX."area a ON a.aid = mp.aid
        WHERE ps.flag != '0'  $conditions  $search_data  $cid_data  $slevel_data $cchangwat_data $campur_data $ctambon_data $cposition1_data $area_data
        $max");
        $stmt_data->execute();		
    ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-strip " id="tbData"
                style="margin-top: 13px !important; min-height: 300px;">
                <thead>
                    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>ระดับ</th>

                        <th>เลขบัตรประชาชน</th>
                        <th>ชื่อ-สกุล</th>
                        <th>เพศ</th>
                        <th>อายุ</th>
                        <th>โทรศัพท์</th>
                        <th>ที่อยู่</th>
                        <th>เขตที่</th>
                        <th>สังกัด</th>

                        <!--<th class="text-center">สถานะ</th>-->
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
                $oid = $row['oid'];
                $personid = $oid;
                $personid_enc = base64_encode($oid);
                $prename = $row['prename_title'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $fullname = $prename." ".$fname." ".$lname;
                $cid = $row['cid'];
                $telephone = $row['telephone'];
                $birthdate = date_db_2form($row['birthdate']);
                $img_profile = $row['img_profile'];
                $today = date("Y-m-d");
                $diff = date_diff(date_create($row['birthdate']), date_create($today));
                $age_y = $diff->format('%y');
                
                
                $house = $row['house'];
                $village = $row['village'];
                    $changwatname = $row['changwatname'];
					$ampurname = $row['ampurname'];
					$tambonname = $row['tambonname'];
					$addr =  "บ้านเลขที่ ".$house." ม.".$village." ต.".$tambonname." อ.".$ampurname." จ.".$changwatname;
                $sexname = $row['sexname'];
                $level = $row['levelname'];
                $status = $row['name'];
                $sid = $row['sid'];
                $zonename = $row['zone_name'];
                $detail = $row['detail'];



                ?>
                    <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $level;?></td>

                        <td><?php echo $cid;?></td>
                        <td><?php echo $fullname;?></br></br>
                            <?php 
												if($sid == 2){  ?>
                            <span class="badge bg-success"><?php echo  $status ;?></span>
                            <?php }
												elseif ( $sid == 1   ) { ?>
                            <span class="badge bg-warning"><?php echo  $status ;?></span>
                            <?php }
                            							?>
                        </td>
                        <td><?php echo $sexname;?></td>
                        <td><?php echo $age_y;?></td>
                        <td><?php echo $telephone;?></td>
                        <td><?php echo $addr;?></td>
                        <td><?php echo $zonename;?></td>
                        <td><?php echo $detail;?></td>


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

                                        <!-- <li class="navi-item">
                                            <a href="?module=person&page=person-detail&personid=<?php echo $personid_enc;?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">ประวัติบุคคล</span>
                                            </a>
                                        </li> -->

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=person&page=person-add-1&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลบุคคล</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="dashboard.php?module=person&page=person-add-2&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลสังกัด</span>
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
$page_link = "dashboard.php?module=$module&page=$page&search=$search&cid=$cid_search&hn=$hn_search&pagenum";

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

<script type="text/javascript">
$(document).ready(function() {
    getoptselect_amphur();
});

$("#ampur").change(function() {
    $("#txt_tambon").val('');
    getoptselect_tambon();
});

function getoptselect_amphur() {

    var changwatcode = 30;
    var ampur = $("#txt_ampur").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-ampur-now.php",
        //dataType: "json",
        data: {
            changwatcode: changwatcode,
            ampur: ampur
        },
        success: function(data) {
            $("#ampur").empty();
            $("#ampur").append(data);
        } // success
    });
}


function getoptselect_tambon() {

    var changwatcode = $("#changwat").val();
    var ampur = $("#txt_ampur").val();
    var ampurcode = $("#ampur").val();
    var tambon = $("#txt_tambon").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-tambon-now.php",
        //dataType: "json",
        data: {
            changwatcode: changwatcode,
            ampurcode: ampurcode,
            ampur: ampur,
            tambon: tambon
        },
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
            $.post("core/borrow/borrow-main-del.php", {
                id: id
            }, function(result) {
                //  $("test").html(result);
                // console.log(result.code);
                location.reload();
            });
        }
    })
}
</script>