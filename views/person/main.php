<?php
error_reporting(0);
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$cid_search = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
$hn_search = filter_input(INPUT_GET, 'hn', FILTER_SANITIZE_STRING);
if($cid_search != ""){
    $cid_data = " AND p.cid LIKE '%$cid_search%'  ";
}
if($search != ""){
    $search_data = " AND  p.fname LIKE '%$search%'  ";
}


?>
		<!--begin::Card-->
		<div class="card card-custom gutter-b example example-compact">
			<div class="card-header">
				<h3 class="card-title">
                <i class="far fa-user"></i>&nbsp;ข้อมูลบุคคล
				</h3>
				<div class="card-toolbar">
					<div class="example-tools justify-content-center">
						<a href="dashboard.php?module=<?php echo $module;?>&page=person-add" class="btn btn-success btn-sm font-weight-bold mr-2" title="เพิ่มบุคคล"><i class="fa fa-plus-circle" title="เพิ่มบุคคล" data-toggle="tooltip"></i>เพิ่มบุคคล</a>
                        <a href="dashboard.php?module=<?php echo $module;?>&page=treeview" class="btn btn-success btn-sm font-weight-bold mr-2" title="โครงสร้าง"><i class="fa fa-plus-circle" title="โครงสร้าง" data-toggle="tooltip"></i>โครงสร้าง</a>
                    </div>
				</div>
			</div>

	<div class="card-body">
    <form class="form" enctype="multipart/form-data" id="frmSearch" method="GET">
    <input type="hidden" class="form-control"  name="act" id="act" value="search"/>
    <input type="hidden" class="form-control"  name="module"  value="<?php echo $module;?>"/>
    <input type="hidden" class="form-control"  name="page"  value="main"/>
    <div class="form-group row">
            <div class="col-lg-3">
				<label>เลขบัตรประชาชน</label>
					<input type="text" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน"  name="cid" id="cid"  value="<?php echo $cid;?>"/>
			</div>
             <div class="col-lg-3">
				<label>ชื่อ-สกุล</label>
				<div class="input-group">
							<input type="text" class="form-control form-control-sm" placeholder="ชื่อ-สกุล"  name="search" id="search"  value="<?php echo $search;?>"/>
							<div class="input-group-append">
								<button class="btn btn-primary btn-sm" type="submit" ><i class="fas fa-search"></i></button>
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

    $numb_data = $conn->query("SELECT count(1) FROM ".DB_PREFIX."person_main p  WHERE p.flag != '0' $conditions  $search_data    $ampur_search ")->fetchColumn();

  
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
        $stmt_data = $conn->prepare ("SELECT p.*,pr.prename AS prename_title,c.changwatname,a.ampurname,t.tambonname,s.sexname
        FROM ".DB_PREFIX."person_main p 
        LEFT JOIN ".DB_PREFIX."cprename pr ON p.prename = pr.id_prename
        LEFT JOIN ".DB_PREFIX."cchangwat c ON p.changwat = c.changwatcode
		LEFT JOIN ".DB_PREFIX."campur a ON CONCAT(p.changwat,p.ampur) = a.ampurcodefull
        LEFT JOIN ".DB_PREFIX."ctambon t ON CONCAT(p.changwat,p.ampur,p.tambon) = t.tamboncodefull
        LEFT JOIN ".DB_PREFIX."csex s ON p.sex = s.sex
        WHERE p.flag != '0' $conditions  $search_data  $cid_data  
        ORDER BY p.oid DESC
        $max");
        $stmt_data->execute();		

        
    ?>



<div class="table-responsive">
	<table class="table table-bordered table-hover table-strip " id="tbData" style="margin-top: 13px !important; min-height: 300px;">
    <thead>
    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>รูป</th>
                        <th>เลขบัตรประชาชน</th>
                        <th>ชื่อ-สกุล</th>
                        <th>เพศ</th>
                        <th>อายุ</th>
                        <th>โทรศัพท์</th>
                        <th>ที่อยู่</th>
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
                $service_id = $row['service_id'];
                $serviceid_enc = base64_encode($service_id);
                $prename = $row['prename_title'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $fullname = $prename.$fname." ".$lname;
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
                ?>
                <tr>
                            <td class="text-center"><?php echo $no;?></td>
                            <td class="text-center">
                            <?php if($img_profile == ""){?>
                                <a  href="uploads/no-image.jpg" class="example-image-link" data-lightbox="example-set" data-title=""><div class="symbol symbol-50 symbol-lg-60">
                                <img src="uploads/no-image.jpg" alt="image"/>
                                </div></a>
                            <?php }else{?>
                                <a  href="uploads/person/<?php echo $img_profile;?>" class="example-image-link" data-lightbox="example-set" data-title=""><div class="symbol symbol-50 symbol-lg-60">
                                <img src="uploads/person/<?php echo $img_profile;?>" alt="image"/>
                                </div></a>
                                <?php } ?>
                            </td>
                            <td><?php echo $cid;?></td>
                            <td><?php echo $fullname;?></td>
                            <td><?php echo $sexname;?></td>
                            <td><?php echo $age_y;?></td>
                            <td><?php echo $telephone;?></td>
                            <td><?php echo $addr;?></td>
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
                                            <a href="?module=person&page=person-detail&personid=<?php echo $personid_enc;?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">ประวัติบุคคล</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=person&page=person-add&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลบุคคล</span>
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



        <script type="text/javascript">

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



