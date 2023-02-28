<?php
error_reporting(0);
$searchf = filter_input(INPUT_GET, 'searchf', FILTER_SANITIZE_STRING);
$searchl = filter_input(INPUT_GET, 'searchl', FILTER_SANITIZE_STRING);

$cid_search = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
$hn_search = filter_input(INPUT_GET, 'hn', FILTER_SANITIZE_STRING);
$cid_search = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_STRING);
$slevel = filter_input(INPUT_GET, 'slevel', FILTER_SANITIZE_STRING);
$cchangwat = filter_input(INPUT_GET, 'changwat', FILTER_SANITIZE_STRING);
$campur = filter_input(INPUT_GET, 'ampur', FILTER_SANITIZE_STRING);
$ctambon = filter_input(INPUT_GET, 'tambon', FILTER_SANITIZE_STRING);
$cposition1 = filter_input(INPUT_GET, 'cposition1', FILTER_SANITIZE_STRING);
$village = filter_input(INPUT_GET, 'village', FILTER_SANITIZE_STRING);


    $numb_A = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub WHERE  level ='1' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_B = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='2' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_C = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='3' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_D = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='4' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_N = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  level ='5' ")->fetchColumn();//แจ้งซ่อมวันนี้
    $numb_T = $conn->query("SELECT COUNT(1) FROM ".DB_PREFIX."person_sub  WHERE  oid ")->fetchColumn();//แจ้งซ่อมวันนี้




if($cid_search != ""){
    $cid_data = " AND p.cid LIKE '%$cid_search%'  ";
}
if($searchf!= ""){
    $searchf_data = " AND  p.fname LIKE '%$searchf%'  ";
}
if($searchl != ""){
    $searchl_data = " AND  p.lname LIKE '%$searchl%'  ";
}
if($slevel != ""){
    $slevel_data = " AND  p.level = '$slevel' ";
}
if($cchangwat != ""){
    $cchangwat_data = " AND  p.changwat = '$cchangwat' ";
}
if($campur != ""){
    $campur_data = " AND  p.ampur = '$campur' ";
}
if($ctambon != ""){
    $ctambon_data = " AND  p.tambon = '$ctambon' ";
}
if($cposition1 != ""){
    $cposition1_data = " AND  p.cposition1 = '$cposition1' ";
}
if($village != ""){
    $village_data = " AND  p.village = '$village' ";
}
?>

<div class="row">
    <div class="col-xl-2">
        <a href="././dashboard.php?act=search&module=person&page=main&slevel=1"
            class="text-dark text-hover-primary font-weight-bold font-size-lg mt-3">
            <div class="card card-custom gutter-b bg-warning" style="height: 150px">
                <div class="card-body">

                    <!-- <span class="svg-icon svg-icon-3x svg-icon-success"><i class='bx bx-calendar bx-lg'></i></span> -->
                    <!-- แจ้งซ่อมวันนี้ -->
                    <div class="text-dark font-weight-bolder font-size-h2 mt-3">
                        <?php echo number_format($numb_A,0);?>
                    </div>
                    <strong>สมาชิกกลุ่ม A</strong>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-2">
        <a href="././dashboard.php?act=search&module=person&page=main&slevel=2"
            class="text-dark text-hover-primary font-weight-bold font-size-lg mt-3">
            <div class="card card-custom gutter-b bg-warning" style="height: 150px">
                <div class="card-body">

                    <!-- <span class="svg-icon svg-icon-3x svg-icon-success"><i class='bx bxs-collection bx-lg'></i></span> -->
                    <!-- รายการซ่อมทั้งหมด -->
                    <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo  number_format($numb_B,0);?>
                    </div>
                    <strong>สมาชิกกลุ่ม B</strong>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-2">
        <a href="././dashboard.php?act=search&module=person&page=main&slevel=3"
            class="text-dark text-hover-primary font-weight-bold font-size-lg mt-3">
            <div class="card card-custom gutter-b bg-success" style="height: 150px">
                <div class="card-body">
                    <!-- <span class="svg-icon svg-icon-3x svg-icon-success "><i class='bx bx-message-alt-check bx-lg'></i></span> -->
                    <!-- รอซ่อม -->
                    <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo  number_format($numb_C,0);?>
                    </div>
                    <strong>สมาชิกกลุ่ม C</strong>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-2">
        <a href="././dashboard.php?act=search&module=person&page=main&slevel=4"
            class="text-dark text-hover-primary font-weight-bold font-size-lg mt-3">
            <div class="card card-custom gutter-b bg-success" style="height: 150px">
                <div class="card-body">
                    <!-- <span class="svg-icon svg-icon-3x svg-icon-success "><i class='bx bx-message-alt-check bx-lg'></i></span> -->
                    <!-- เสนอราคา -->
                    <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo  number_format($numb_D,0);?></div>

                    <strong>สมาชิกกลุ่ม D</strong>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-2">
        <a href="././dashboard.php?act=search&module=person&page=main&slevel=5"
            class="text-dark text-hover-primary font-weight-bold font-size-lg mt-3">
            <div class="card card-custom gutter-b bg-success" style="height: 150px">
                <div class="card-body">
                    <!-- <span class="svg-icon svg-icon-3x svg-icon-success"><i class='bx bxs-cog bx-lg'></i></span> -->
                    <!-- กำลังซ่อม -->
                    <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo  number_format($numb_N,0);?>
                    </div>
                    <strong>สมาชิกกลุ่ม N</strong>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-2">
    <a href="././dashboard.php?act=search&module=person&page=main"
            class="text-dark text-hover-primary font-weight-bold font-size-lg mt-3">
            <div class="card card-custom gutter-b bg-success" style="height: 150px">
                <div class="card-body">
                    <!-- <span class="svg-icon svg-icon-3x svg-icon-success "><i class='bx bx-message-alt-check bx-lg'></i></span> -->
                    <!-- เสนอราคา -->
                    <div class="text-dark font-weight-bolder font-size-h2 mt-3"><?php echo  number_format($numb_T,0);?></div>

                    <strong>อยู่ในระบบ</strong>
                </div>
            </div>
        </a>

    </div>




</div>
<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-user"></i>&nbsp;ข้อมูลบุคคล
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <a href="dashboard.php?module=<?php echo $module;?>&page=person-add-3"
                    class="btn btn-success btn-sm font-weight-bold mr-2" title="เพิ่มบุคคล"><i class="fa fa-plus-circle"
                        title="เพิ่มบุคคล" data-toggle="tooltip"></i>เพิ่มบุคคล</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form class="form" enctype="multipart/form-data" id="frmSearch" method="GET">
            <input type="hidden" class="form-control" name="act" id="act" value="search" />
            <input type="hidden" class="form-control" name="module" value="<?php echo $module;?>" />
            <input type="hidden" class="form-control" name="page" value="<?php echo $page;?>" />
            <div class="form-group row">
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

                <div class="col-lg-1">
                            <label>หมู่ที่</label>
                            <select class="form-control form-control-sm" name="village" id="village">
                            <option value="" <?php if($village == ""){ echo "selected";}?>>-</option>
                            <option value="" <?php if($village == "0"){ echo "selected";}?>>0
                                </option>

                                <?php for ($n_vil = 1; $n_vil <= 99; $n_vil++) { 
									$n_vil_data = str_pad($n_vil,2,"0",STR_PAD_LEFT);
									?>
                                <option value="<?php echo $n_vil_data;?>"
                                    <?php if($village == $n_vil_data){ echo "selected";}?>>
                                    <?php echo $n_vil;?></option>
                                <?php } ?>


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

                <div class="col-lg-1">
                    <label>ชื่อ</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" placeholder="ชื่อ" name="searchf"
                            id="searchf" value="<?php echo $searchf;?>" />

                    </div>
                </div>
                <div class="col-lg-2">
                    <label>สกุล</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" placeholder="สกุล" name="searchl"
                            id="searchl" value="<?php echo $searchl;?>" />
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

    $numb_data = $conn->query("SELECT count(1) FROM ".DB_PREFIX."person_sub p WHERE p.flag != '0' $conditions  $searchf_data $searchl_data   $cid_data  $slevel_data $cchangwat_data $campur_data $ctambon_data $cposition1_data  $village_data")->fetchColumn();

  
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
        $stmt_data = $conn->prepare ("SELECT p.*,
        cp2.prename AS pre2,lt2.level AS namelevel2,pm2.fname AS fname2,pm2.lname AS lname2,
        cp3.prename AS pre3,lt3.level AS namelevel3,pm3.fname AS fname3,pm3.lname AS lname3
    
        FROM ".DB_PREFIX."person_sub p
        LEFT JOIN person_sub pm2 ON p.head = pm2.oid 
        LEFT JOIN person_sub pm3 ON p.team_id = pm3.oid 
        LEFT JOIN cprename cp2 ON pm2.prename = cp2.id_prename 
        LEFT JOIN cprename cp3 ON pm3.prename = cp3.id_prename 
        LEFT JOIN level_type lt1 ON p.level = lt1.level_id 
        LEFT JOIN level_type lt2 ON pm2.level = lt2.level_id 
        LEFT JOIN level_type lt3 ON pm3.level = lt3.level_id
        WHERE p.flag != '0' $conditions  $searchf_data $searchl_data  $cid_data  $slevel_data $cchangwat_data $campur_data $ctambon_data 
        $cposition1_data  $village_data
        ORDER BY p.level ASC  $max ");
        $stmt_data->execute();		
    ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-strip " id="tbData"
                style="margin-top: 13px !important; min-height: 300px;">
                <thead>
                    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>ระดับ</th>
                        <th>รูป</th>
                        <th>เลขบัตรประชาชน</th>
                        <th>ชื่อ-สกุล</th>
                        <th>เพศ</th>
                        <th>อายุ</th>
                        <th>โทรศัพท์</th>
                        <th>ที่อยู่</th>
                        <th>หมายเหตุ</th>
                        <th>สังกัด</th>
                        <th>สังกัดใหญ่</th>

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
                $fullname = $prename." ".$fname." ".$lname;
                $cid = $row['cid'];
                $telephone = $row['telephone'];
                $birthdate = date_db_2form($row['birthdate']);
                $img_profile = $row['img_profile'];
                $today = date("Y-m-d");
                $diff = date_diff(date_create($row['birthdate']), date_create($today));
                $age_y = $diff->format('%y');
                $team_id = $row['team_id'];
                $team_id_enc= base64_encode($team_id);
                $level_id = $row['level'];

                $addr_note = $row['addr_note'];
                
                $house = $row['house'];
                $village_addr = $row['village'];
                    $changwatname = $row['changwatname'];
					$ampurname = $row['ampurname'];
					$tambonname = $row['tambonname'];
					$addr =  "บ้านเลขที่ ".$house." ม.".$village_addr." ต.".$tambonname." อ.".$ampurname." จ.".$changwatname;
                $sexname = $row['sexname'];
                $level = $row['levelname'];
                $status = $row['name'];
                $sid = $row['sid'];

                if($row ['namelevel2'] != NULL) 
        {
            $sethead = "ระดับ ".$row ['namelevel2']." </br>". $row ['pre2']."". $row ['fname2'] ." ".$row ['lname2']; 
        }else{
            $sethead = "-";
        }
        if($row ['namelevel3'] != NULL) 
        {
            $setteam = "ระดับ ".$row ['namelevel3']." </br>". $row ['pre3']."". $row ['fname3'] ." ".$row ['lname3'];  
        }else{
            $setteam = "-";
        }


                ?>
                    <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $level;?></td>
                        <td class="text-center">
                            <?php if($img_profile == ""){?>
                            <a href="uploads/no-image.jpg" class="example-image-link" data-lightbox="example-set"
                                data-title="">
                                <div class="symbol symbol-50 symbol-lg-60">
                                    <img src="uploads/no-image.jpg" alt="image" />
                                </div>
                            </a>
                            <?php }else{?>
                            <a href="uploads/person/<?php echo $img_profile;?>" class="example-image-link"
                                data-lightbox="example-set" data-title="">
                                <div class="symbol symbol-50 symbol-lg-60">
                                    <img src="uploads/person/<?php echo $img_profile;?>" alt="image" />
                                </div>
                            </a>
                            <?php } ?>
                        </td>
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
                        <td><?php echo $addr_note;?></td>
                        <td><?php echo $sethead;?></td>
                        <td><?php echo $setteam;?></td>

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
                                            <a href="dashboard.php?module=person&page=person-add-3&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลบุคคล</span>
                                            </a>
                                        </li>
                                        <!-- <li class="navi-item">
                                            <a href="dashboard.php?module=person&page=person-add-2&personid=<?php echo $personid_enc;?>&act=<?php echo base64_encode('edit');?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="navi-text">แก้ไขข้อมูลสังกัด</span>
                                            </a>
                                        </li> -->
                                        <li class="navi-item">


                                            <?php 
												if($level_id == 5){  ?>

                                            <?php }
												else { ?>
                                            <a href="dashboard.php?module=person&page=report&personid=<?php echo $personid_enc;?>&teamid=<?php echo $team_id_enc;?>&levelid=<?php echo $level_id;?>"
                                                class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-user-edit"></i></span>
                                                <span class="navi-text">ออกรายงาน</span>
                                            </a>
                                            <?php }
                            							?>


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
$page_link = "dashboard.php?module=$module&page=$page&slevel=$slevel&ampur=$campur&tambon=$ctambon&cid=$cid_search&cposition1=$cposition1&searchf=$searchf&searchl=$searchl&village=$village&pagenum";

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