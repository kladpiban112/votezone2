<?php


$personid_enc = filter_input(INPUT_GET, 'personid', FILTER_SANITIZE_STRING);
$serviceid_enc = filter_input(INPUT_GET, 'serviceid', FILTER_SANITIZE_STRING);
$act = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$personid = base64_decode($personid_enc);
$serviceid = base64_decode($serviceid_enc);
$action = base64_decode($act);

if($action == "edit"){
	$txt_title = "แก้ไข";
	// $action = $action;
	// $stmt_data = $conn->prepare ("SELECT p.*,o.org_name FROM ".DB_PREFIX."person_main p 
	// LEFT JOIN ".DB_PREFIX."org_main o ON p.org_id = o.org_id 
    // WHERE p.oid = '$personid'  LIMIT 1");
    // $stmt_data->execute();	
    // $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

    $stmt_data = $conn->prepare ("SELECT pm1.*,pm1.cid AS CID,pm1.fname AS Fname,pm1.lname AS Lname,pm1.sex AS Sex,pm1.birthdate AS Birthdate,pm1.telephone AS Telephone,pm1.house AS House,pm1.community AS Community,pm1.road AS Road,pm1.village AS Village,pm1.tambon AS Tambon,pm1.ampur AS Ampur,pm1.changwat AS Changwat,pm1.img_profile AS Img_profile,pm1.prename AS pre,pm1.level AS pmlevel,
        cp2.prename AS pre2,lt2.level AS namelevel2,pm2.fname AS fname2,pm2.lname AS lname2,
        cp3.prename AS pre3,lt3.level AS namelevel3,pm3.fname AS fname3,pm3.lname AS lname3
        FROM person_sub pm1 
        LEFT JOIN person_sub pm2 ON pm1.head = pm2.oid 
        LEFT JOIN person_sub pm3 ON pm1.team_id = pm3.oid 
        LEFT JOIN cprename cp1 ON pm1.prename = cp1.id_prename 
        LEFT JOIN cprename cp2 ON pm2.prename = cp2.id_prename 
        LEFT JOIN cprename cp3 ON pm3.prename = cp3.id_prename 
        LEFT JOIN level_type lt1 ON pm1.level = lt1.level_id 
        LEFT JOIN level_type lt2 ON pm2.level = lt2.level_id 
        LEFT JOIN level_type lt3 ON pm3.level = lt3.level_id 
        WHERE pm1.oid = '$personid'  LIMIT 1" );
        $stmt_data->execute();	
        $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);

        if($row_person ['namelevel2'] != NULL) 
        {
            $sethead = "ระดับ ".$row_person ['namelevel2']." ". $row_person ['pre2']." ". $row_person ['fname2'] ." ".$row_person ['lname2']; 
        }else{
            $sethead = "-";
        }
        if($row_person ['namelevel3'] != NULL) 
        {
            $setteam = "ระดับ ".$row_person ['namelevel3']." ". $row_person ['pre3']." ". $row_person ['fname3'] ." ".$row_person ['lname3'];  
        }else{
            $setteam = "-";
        }
        // $setteam = "ระดับ ".$row_person ['namelevel3']." ". $row_person ['pre3']." ". $row_person ['fname3'] ." ".$row_person ['lname3']; 



}else{
	$txt_title = "เพิ่ม";
	$action = "add";
}

// if($personid_enc != ""){
// 	$stmt_data = $conn->prepare ("SELECT p.*,o.org_name FROM ".DB_PREFIX."person_main p 
// 	LEFT JOIN ".DB_PREFIX."org_main o ON p.org_id = o.org_id 
//     WHERE p.oid = '$personid'  LIMIT 1");
//     $stmt_data->execute();	
//     $row_person = $stmt_data->fetch(PDO::FETCH_ASSOC);
// }
?>



<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header ribbon ribbon-right">
        <div class="ribbon-target bg-primary" style="top: 10px; right: -2px;">2</div>
        <h3 class="card-title">
            <i class="far fa-user"></i>&nbsp;<?php echo $txt_title;?>ข้อมูลสังกัด
        </h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <!-- <?php if($action == "edit"){?>

                        <a href="dashboard.php?module=service&page=service-add&personid=<?php echo $personid_enc;?>" class="btn btn-info btn-sm font-weight-bold mr-2" title="บันทึกรับบริการ"><i class="fas fa-plus" title="บันทึกรับบริการ" ></i> บันทึกรับบริการ</a>

                    <?php }else{?>

                        <a href="#" class="btn btn-default btn-sm font-weight-bold mr-2" title="บันทึกรับบริการ" disabled><i class="fas fa-plus" title="บันทึกรับบริการ" ></i> บันทึกรับบริการ</a>

                    <?php } ?> -->
                <!-- <a href="dashboard.php?module=<?php echo $module;?>&page=main" class="btn btn-defalse btn-sm font-weight-bold mr-2" title="ย้อนกลับ"><i class="fa fa-chevron-left" title="ย้อนกลับ" ></i></a> -->
            </div>
        </div>
    </div>

    <form class="form" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="act" id="act" value="<?php echo $action;?>" />
        <input type="hidden" class="form-control" name="personid" id="personid" value="<?php echo $personid;?>" />
        <input type="hidden" class="form-control" name="headid" id="headid" value="<?php echo $row_person['head'];?>" />
        <input type="hidden" class="form-control" name="serviceid" id="serviceid" value="<?php echo $serviceid;?>" />
        <input type="hidden" class="form-control" name="org_id" id="org_id" value="<?php echo $logged_org_id;?>" />
        <input type="hidden" class="form-control" name="team_id" id="team_id" value="<?php echo $personid;?>" />

        <div class="card-body">

            <div class="row">
                <div class="col-lg-8">


                    <span><i class="far fa-user"></i> ข้อมูลบุคคล </span>
                    <hr>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label>เลขบัตรประชาชน</label>
                            <input type="text" class="form-control form-control-sm" placeholder="เลขบัตรประชาชน 13 หลัก"
                                name="cid" id="cid" maxlength="13" value="<?php echo $row_person['CID'];?>" disabled />
                        </div>

                        <div class="col-lg-2">
                            <label>คำนำหน้า</label>
                            <select class="form-control form-control-sm" name="prename" id="prename" disabled>
                                <option value="">ระบุ</option>
                                <?php
                          $stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."cprename  ORDER BY id_prename ASC");
                          $stmt_user_role->execute();		
                          while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                            {
                            $id_selected = $row['id_prename'];
                            $title_selected = stripslashes($row['prename']);
                            ?>
                                <option value="<?php echo $id_selected;?>"
                                    <?php if($row_person['pre'] == $id_selected ){echo "selected";} ?>>
                                    <?php echo $title_selected;?></option>
                                <?php
                            }
                          ?>
                            </select>

                        </div>
                        <div class="col-lg-3">
                            <label>ชื่อ</label>
                            <input type="text" class="form-control form-control-sm" name="fname" id="fname"
                                placeholder="ชื่อ" value="<?php echo $row_person['Fname'];?>" disabled />

                        </div>
                        <div class="col-lg-4">
                            <label>สกุล</label>
                            <input type="text" class="form-control form-control-sm" name="lname" id="lname"
                                placeholder="สกุล" value="<?php echo $row_person['Lname'];?>" disabled />

                        </div>



                    </div>


                    <div class="form-group row">

                        <div class="col-lg-2">
                            <label>เพศ</label>
                            <select class="form-control form-control-sm" name="sex" id="sex" disabled>
                                <option value="">ระบุ</option>
                                <?php
                          $stmt_user_role = $conn->prepare("SELECT * FROM ".DB_PREFIX."csex  ORDER BY sex ASC");
                          $stmt_user_role->execute();		
                          while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                            {
                            $id_selected = $row['sex'];
                            $title_selected = stripslashes($row['sexname']);
                            ?>
                                <option value="<?php echo $id_selected;?>"
                                    <?php if($row_person['Sex'] == $id_selected ){echo "selected";} ?>>
                                    <?php echo $title_selected;?></option>
                                <?php
                            }
                          ?>
                            </select>

                        </div>

                        <div class="col-lg-2">
                            <label>วันเดือนปีเกิด</label>
                            <input type="text" class="form-control form-control-sm" name="birthdate" id="birthdate"
                                placeholder="วันเดือนปีเกิด"
                                value="<?php echo date_db_2form($row_person['Birthdate']);?>" data-date-language="th-th"
                                maxlength="10" disabled />
                            <span class="form-text text-muted"></span>

                        </div>


                        <div class="col-lg-3">
                            <label>ตำแหน่ง 1 </label>
                            <select class="form-control form-control-sm" name="cposition1" id="cposition1" disabled>
                                <option value="">ระบุ</option>
                                <?php
                          $stmt_user_role = $conn->prepare("SELECT * FROM  cposition c ");
                          $stmt_user_role->execute();		
                          while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                            {
                            $id = $row['id'];
                            $title_selected = stripslashes($row['name']);
                            ?>
                                <option value="<?php echo $id;?>"
                                    <?php if($row_person['cposition1'] == $id ){echo "selected";} ?>>
                                    <?php echo $title_selected;?></option>
                                <?php
                            }
                          ?>
                            </select>

                        </div>
                        <div class="col-lg-3">
                            <label>ตำแหน่ง 2</label>
                            <select class="form-control form-control-sm" name="cposition2" id="cposition2" disabled>
                                <option value="">ระบุ</option>
                                <?php
                          $stmt_user_role = $conn->prepare("SELECT * FROM  cposition c ");
                          $stmt_user_role->execute();		
                          while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                            {
                            $id = $row['id'];
                            $title_selected = stripslashes($row['name']);
                            ?>
                                <option value="<?php echo $id;?>"
                                    <?php if($row_person['cposition2'] == $id ){echo "selected";} ?>>
                                    <?php echo $title_selected;?></option>
                                <?php
                            }
                          ?>
                            </select>

                        </div>
                        <div class="col-lg-3">
                            <label>ตำแหน่ง 3</label>
                            <select class="form-control form-control-sm" name="cposition3" id="cposition3" disabled>
                                <option value="">ระบุ</option>
                                <?php
                          $stmt_user_role = $conn->prepare("SELECT * FROM  cposition c ");
                          $stmt_user_role->execute();		
                          while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                            {
                            $id = $row['id'];
                            $title_selected = stripslashes($row['name']);
                            ?>
                                <option value="<?php echo $id;?>"
                                    <?php if($row_person['cposition3'] == $id ){echo "selected";} ?>>
                                    <?php echo $title_selected;?></option>
                                <?php
                            }
                          ?>
                            </select>

                        </div>
                        <div class="col-lg-3">
                            <label>ตำแหน่ง 4</label>
                            <select class="form-control form-control-sm" name="cposition4" id="cposition4" disabled>
                                <option value="">ระบุ</option>
                                <?php
                          $stmt_user_role = $conn->prepare("SELECT * FROM  cposition c ");
                          $stmt_user_role->execute();		
                          while ($row = $stmt_user_role->fetch(PDO::FETCH_ASSOC))
                            {
                            $id = $row['id'];
                            $title_selected = stripslashes($row['name']);
                            ?>
                                <option value="<?php echo $id;?>"
                                    <?php if($row_person['cposition4'] == $id ){echo "selected";} ?>>
                                    <?php echo $title_selected;?></option>
                                <?php
                            }
                          ?>
                            </select>

                        </div>
                    </div>

                    <div class="form-group row">


                        <div class="col-lg-4">
                            <label>โทรศัพท์</label>
                            <input type="text" class="form-control form-control-sm" name="telephone" id="telephone"
                                placeholder="โทรศัพท์" value="<?php echo $row_person['Telephone'];?>" maxlength="10"
                                disabled />
                            <!-- <span class="form-text text-muted">หมายเลขโทรศัพท์ 10 หลัก</span> -->

                        </div>


                    </div>


                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>ระดับ</label>
                            <select class="form-control form-control-sm" name="level" id="level" disabled>
                                <?php
                        $stmt = $conn->prepare ("SELECT * FROM level_type l ");
                        $stmt->execute();
                        echo "<option value=''>-ระบุ-</option>";
                        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                        $id = $row->level_id;
                        $name = $row->level; ?>
                                <option value="<?php echo $id;?>"
                                    <?php if($row_person['pmlevel'] == $id){ echo "selected";}elseif($row_person['pmlevel'] == "" && $id == "4"){echo "selected";}?>>
                                    <?php echo $name;?></option>
                                <?php 
                        }
                    ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label>สถานะในระบบ</label>
                            <select class="form-control form-control-sm" name="status_pp" id="status_pp" disabled>
                                <?php
                        $stmt = $conn->prepare ("SELECT * FROM status_pp  ");
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                        $id = $row->sid;
                        $name = $row->name; ?>
                                <option value="<?php echo $id;?>"
                                    <?php if($row_person['status'] == $id){echo "selected";}?>>
                                    <?php echo $name;?></option>
                                <?php 
                        }
                    ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label>สังกัด</label>
                            <input type="text" class="form-control form-control-sm" name="name_head" id="name_head"
                                placeholder="" value="<?php echo $sethead;?>" disabled />

                        </div>
                        <div class="col-lg-4">
                            <label>สังกัดใหญ่</label>
                            <input type="text" class="form-control form-control-sm" name="name_team" id="name_team"
                                placeholder="" value="<?php echo $setteam;?>" disabled />

                        </div>
                    </div>

                    <span><i class="fas fa-house-user"></i> ที่อยู่ :</span>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label>บ้านเลขที่</label>
                            <input type="text" class="form-control form-control-sm" name="house" id="house"
                                placeholder="บ้านเลขที่" value="<?php echo $row_person['House'];?>" disabled />

                        </div>
                        <div class="col-lg-4">
                            <label>หมู่บ้าน/ชุมชน</label>
                            <input type="text" class="form-control form-control-sm" name="community" id="community"
                                placeholder="หมู่บ้าน/ชุมชน" value="<?php echo $row_person['Community'];?>" disabled />

                        </div>



                        <div class="col-lg-3">
                            <label>ถนน</label>
                            <input type="text" class="form-control form-control-sm" name="road" id="road"
                                placeholder="ถนน" value="<?php echo $row_person['Road'];?>" disabled />
                        </div>
                        <div class="col-lg-2">
                            <label>หมู่ที่</label>
                            <select class="form-control form-control-sm" name="village" id="village" disabled>
                                <option value="" <?php if($row_person['Village'] == "0"){ echo "selected";}?>>0
                                </option>

                                <?php for ($n_vil = 1; $n_vil <= 99; $n_vil++) { 
									$n_vil_data = str_pad($n_vil,2,"0",STR_PAD_LEFT);
									?>
                                <option value="<?php echo $n_vil_data;?>"
                                    <?php if($row_person['Village'] == $n_vil_data){ echo "selected";}?>>
                                    <?php echo $n_vil;?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <input type="hidden" class="form-control" name="txt_ampur" id="txt_ampur"
                        value="<?php echo $row_person['Ampur'];?>" />
                    <input type="hidden" class="form-control" name="txt_tambon" id="txt_tambon"
                        value="<?php echo $row_person['Tambon'];?>" />
                    <div class="form-group row">

                        <div class="col-lg-3">
                            <label>จังหวัด</label>
                            <select class="form-control form-control-sm" name="changwat" id="changwat" disabled>

                                <?php
                                $stmt = $conn->prepare ("SELECT * FROM cchangwat c ");
                                $stmt->execute();
                                echo "<option value=''>-ระบุ-</option>";
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                $id = $row->changwatcode;
                                $name = $row->changwatname; ?>
                                <option value="<?php echo $id;?>"
                                    <?php if($row_person['Changwat'] == $id){ echo "selected";}?>>
                                    <?php echo $name;?>
                                </option>
                                <?php 
                                }
                            ?>
                            </select>

                        </div>

                        <div class="col-lg-3">
                            <label>อำเภอ</label>
                            <select class="form-control form-control-sm" name="ampur" id="ampur" disabled>
                                <option value="">ระบุ</option>
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <label>ตำบล</label>
                            <select class="form-control form-control-sm" name="tambon" id="tambon" disabled>
                                <option value="">ระบุ</option>
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <label>หมายเหตุ</label>
                            <select class="form-control form-control-sm" name="addr_note" id="addr_note">
                                <option value="" <?php if($row_person['addr_note'] == ""){ echo "selected";}?>>-
                                </option>
                                <option value="กทม." <?php if($row_person['addr_note'] == "กทม."){ echo "selected";}?>>
                                    กทม.
                                </option>
                                <option value="ตจว." <?php if($row_person['addr_note'] == "ตจว."){ echo "selected";}?>>
                                    ตจว.
                                </option>
                            </select>
                        </div>


                    </div>

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
                <!--col-->


                <div class="col-lg-4 border-x-0 border-x-md border-y border-y-md-0">

                    <div class="form-group row">
                        <div class="col-lg-12">



                            <?php if($row_person['Img_profile'] == ""){?>
                            <div class="symbol symbol-50 symbol-lg-150 ">
                                <img src="uploads/no-image.jpg" alt="image" />
                            </div>
                            <?php }else{?>
                            <a href="uploads/person/<?php echo $row_person['Img_profile'];?>" class=""
                                data-lightbox="example-set" data-title="">
                                <div class="symbol symbol-50 symbol-lg-150 ">

                                    <img src="uploads/person/<?php echo $row_person['Img_profile'];?>" alt="image" />

                                </div>
                            </a>
                            <?php   } ?>


                            <!-- <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove"  title="Remove"> -->
                            <!-- <a href="#" onclick="confirm_person_image('<?php echo $personid; ?>');"><i class="ki ki-bold-close icon-xs text-muted"></i></a> -->
                            </span>


                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>รูปถ่าย</label>
                            <input type="file" class="form-control" name="img_profile" id="img_profile"
                                placeholder="รูปถ่ายผู้พิการ" disabled />
                            <span class="form-text text-muted">.jpg .png เท่านั้น</span>
                        </div>
                    </div>

                    <!-- <span><i class="fas fa-list"></i> ข้อมูลความพิการ
                <?php if($action == "edit"){?>
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalAddDisab"><i class="far fa-plus-square"></i> บันทึกความพิการ</a>
                <?php }else{?>
               <a href="#" class="btn btn-sm btn-default" disabled><i class="far fa-plus-square"></i> บันทึกความพิการ</a>
                <?php }?>
                </span>
                <hr> 
                <div id="disab_detail"></div>  


                <span><i class="fas fa-list"></i> ข้อมูลครอบครัว 
                <?php if($action == "edit"){?>
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalAddFamily"><i class="far fa-plus-square"></i> เพิ่มครอบครัว</a>
                <?php }else{?>
               <a href="#" class="btn btn-sm btn-default" disabled><i class="far fa-plus-square"></i> เพิ่มครอบครัว</a>
                <?php }?>
                </span>
                <hr> 
                <div id="family_detail"></div>  

                <span><i class="fas fa-list"></i> ผู้ดูแลหรือญาติ
                <?php if($action == "edit"){?>
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalAddRelative"><i class="far fa-plus-square"></i> เพิ่มผู้ดูแลหรือญาติ</a>
                <?php }else{?>
               <a href="#" class="btn btn-sm btn-default" disabled><i class="far fa-plus-square"></i> เพิ่มผู้ดูแลหรือญาติ</a>
                <?php }?>
                </span>
                <hr>
                <div id="relative_detail"></div>  
 -->
                    <div class="col-lg-12">

                    </div>
                    </br>
                    <div class="col-lg-12" id="head_h">
                        <label>สังกัด</label>
                        <select class="js-example-basic-single col-lg-12" name="head_data" id="head_data">
                        </select>
                    </div>
                    </br>
                    <div class="col-lg-12" id="parents_h">
                        <label>สังกัดใหญ่</label>
                        <select class="form-control form-control-sm" name="parents" id="parents">
                            <option id="parents_val" value="" selected>--ระบุ--</option>
                        </select>
                        </select>
                    </div>

                </div>

            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary mr-2 btn-sm" id="btnSavePerson"><i class="fa fa-save"
                            title="บันทึก"></i> บันทึก</button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="javascript:history.back()"><i
                            class="fa fa-chevron-left" title="ย้อนกลับ"></i> </button>
                </div>
                <div class="col-lg-6 text-right">
                    <!--<button type="reset" class="btn btn-danger">Delete</button>-->
                </div>
            </div>
        </div>
    </form>

</div>
<!--end::Card-->

<!-- Datepicker Thai -->
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-datepicker-thai.js"></script>
<script src="assets/js/locales/bootstrap-datepicker.th.js"></script>

<script>
$(document).ready(function() {
    'use strict';
    getoptselect_amphur();
    getoptselect_tambon();
    getoptselect_level();
    getteam();
    $('.js-example-basic-single').select2();

    $(".js-example-basic-single").on("change", function(e) {
        var data_val = $(this).val();
        $.ajax({
            type: "POST",
            url: "core/fn-get-parents.php",
            data: {
                person: data_val
            },
            success: function(data) {
                var vals = $.parseJSON(data);
                console.log(vals);
                if (vals.id != "0") {
                    $('#parents_val').text(vals.name);
                    $('#parents_val').val(vals.id);
                } else {
                    $('#parents_val').text("--ระบุ--");
                    $('#parents_val').val("");
                }
            }
        });
    });
});


$(".add-more").click(function() {
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
    $('#parents_val').text("--ระบุ--");
    $('#parents_val').val("");
    var level = $("#level").val();
    var person = $("#headid").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-level-person.php",
        //dataType: "json",
        data: {
            level: level,
            person: person
        },
        success: function(data) {
            console.log(data);
            $("#head_data").empty();
            $("#head_data").append(data);
        } // success
    });
});

function getoptselect_level() {
    var level = $("#level").val();
    var person = $("#headid").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-level-person.php",
        //dataType: "json",
        data: {
            level: level,
            person: person
        },
        success: function(data) {
            $("#head_data").empty();
            $("#head_data").append(data);
        } // success
    });

}


$("#head_data").trigger('change', function(e) {
    var head_data = $("#head_data").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-parents.php",
        data: {
            person: head_data
        },
        success: function(data) {
            console.log(data);
            $("#parents").text();
            $("#head_data").append(data);
        }
    });
});


function getoptselect_amphur() {

    var changwatcode = $("#changwat").val();
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

function getteam() {
    var data_val = $("#team_id").val();
    $.ajax({
        type: "POST",
        url: "core/fn-get-parents.php",
        data: {
            person: data_val
        },
        success: function(data) {
            var vals = $.parseJSON(data);
            if (vals.id != "0") {
                // $('#parents_val').text(vals.name);
                // $('#parents_val').val(vals.id);
            } else {
                $('#parents_val').text("--ระบุ--");
                $('#parents_val').val("");
            }
        }
    });

}




function confirm_person_image(id) {
    //console.log(id);
    Swal.fire({
        title: 'แน่ใจนะ?',
        text: "ต้องการยกเลิกรายการ",
        //type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ยกเลิก',
        confirmButtonText: 'ใช่, ต้องการยกเลิกรายการ !'
    }).then((result) => {
        if (result.value) { //Yes
            $.post("core/person/person-image-del.php", {
                id: id
            }, function(result) {
                //  $("test").html(result);
                console.log(result.oid);
                location.reload();
            });
        }
    })
}


$('#btnSavePerson').click(function(e) {
    e.preventDefault();
    console.log()
    if ($('#head_data').val() == "0") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุสังกัด',
            showConfirmButton: false,
            timer: 1000
        });
    } else {
        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/person/person-add-2.php",
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == "200") {
                    Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then((value) => {
                            if (data.method == "add") {
                                window.location.replace(
                                    "dashboard.php?module=person&page=person-add-2&personid=" +
                                    data.personid + "&act=" + data.act);
                            } else {
                                window.location.replace(
                                    "dashboard.php?module=person&page=person-add-2&personid=" +
                                    data.personid + "&act=" + data.act);
                            }

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
                } else if (data.code == "300") {
                    //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                    Swal.fire({
                            icon: 'error',
                            title: 'มีข้อมูลบุคคลนี้แล้ว',
                            text: 'กรุณาลองใหม่อีกครั้ง'
                        })
                        .then((value) => {
                            //liff.closeWindow();
                        });
                }
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
                // Your error handling logic here..
            } // success
        });

    }

}); //  click


$('#cidSearch').click(function(e) {
    e.preventDefault();
    if ($('#cid').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุเลขบัตรประชาชน',
            showConfirmButton: false,
            timer: 1000
        });
    } else if ($('#org_id').val().length == "") {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาระบุหน่วยงาน',
            showConfirmButton: false,
            timer: 1000
        });
    } else {

        var data = new FormData(this.form);
        $.ajax({
            type: "POST",
            url: "core/healthcare/person-search.php",
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == "200") {
                    Swal.fire({
                            icon: 'success',
                            title: 'ค้นหาข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then((value) => {

                            $('#prename').val(data.prename);
                            $('#fname').val(data.fname);
                            $('#lname').val(data.lname);
                            //liff.closeWindow();
                            //window.location.replace("dashboard.php?module=borrow");
                            //window.location.replace("dashboard.php?module=borrow&page=borrow-add&personid="+data.personid+"&serviceid="+data.serviceid+"&act="+data.act);
                        });
                } else if (data.code == "404") {
                    //swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาลองอีกครั้ง")
                    Swal.fire({
                            icon: 'error',
                            title: 'ไม่พบข้อมูลที่ค้นหา',
                            //text: 'กรุณาลองใหม่อีกครั้ง'
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