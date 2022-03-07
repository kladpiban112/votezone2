<?php
session_start();
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$serviceid = filter_input(INPUT_POST, 'serviceid', FILTER_SANITIZE_STRING);

$conditions = " AND u.service_id = '$serviceid' ";
$stmt_data = $conn->prepare ("SELECT u.*,e.*,t.eq_typename
FROM ".DB_PREFIX."service_data u 
LEFT JOIN  ".DB_PREFIX."equipment_main e ON u.eq_id = e.oid
LEFT JOIN ".DB_PREFIX."equipment_type t ON e.eq_typeid = t.eq_typeid
WHERE u.flag != '0' $conditions 
ORDER BY u.s_oid DESC
$max");
$stmt_data->execute();		

?>


<div class="table-responsive">
	<table class="table table-bordered table-hover table-strip" id="tbData" style="margin-top: 13px !important">
    <thead>
    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>รูปภาพ</th>
                        <th>รหัส</th>
                        <th>ชื่ออุปกรณ์	</th>
                        <th>ประเภท</th>
                        <!--<th class="text-center">สถานะ</th>-->
                        <th class="text-center">จัดการ</th>	
    </tr>
    </thead>
    <tbody>

    <?php

            $i  = 0;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $i++;
                $s_oid = $row['s_oid'];
                $oid = $row['oid'];
                $oid_enc = base64_encode($oid);
                $eq_name = $row['eq_name'];
                $eq_desc = $row['eq_desc'];
                $eq_code = $row['eq_code'];
                $org_name = $row['org_name'];
                $eq_typename = $row['eq_typename'];
                $receive_date = date_db_2form($row['receive_date']);
                $eq_img = $row['eq_img'];
                $status_title = $row['status_title'];
                $status_color = $row['status_color'];
                $rec_title = $row['rec_title'];

                $eq_typeid = $row['eq_typeid'];
                if($eq_typeid == 1){
                    $eq_typeother = "<br>(".$row['eq_typeother'].")";  
                }else{
                    $eq_typeother = "";
                }

                ?>


            
 
                <tr>
                            <td class="text-center"><?php echo $i;?></td>
                            <td class="text-center"><div class="symbol symbol-50 symbol-lg-60">
                            <?php if($eq_img == ""){?>
                    <img src="uploads/equipment/no-image.jpg" alt="image"/>
                            <?php }else{?>
                                <img src="uploads/equipment/<?php echo $eq_img;?>" alt="image"/>
                                <?php   } ?>
                </div></td>
                <td><?php echo $eq_code;?></td>
                            <td><?php echo $eq_name;?></td>
                            <td ><?php 
                            echo $eq_typename;
                            echo $eq_typeother;
                            ?></td>
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
                                            <a href="dashboard.php?module=equipment&page=equipment-print&id=<?php echo $oid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-clipboard-list"></i></span>
                                                <span class="navi-text">รายละเอียด</span>
                                            </a>
                                        </li>

                                        <li class="navi-separator my-3"></li>

                                        <li class="navi-item">
                                            <a href="#" class="navi-link" onclick='delEquipment(<?php echo $s_oid; ?>)'>
                                                <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                                <span class="navi-text">ยกเลิก</span>
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