<?php
session_start();
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$serviceid = filter_input(INPUT_POST, 'serviceid', FILTER_SANITIZE_STRING);

$conditions = " AND u.service_id = '$serviceid' ";
$stmt_data = $conn->prepare ("SELECT u.*
FROM ".DB_PREFIX."coordinate_data u 
WHERE u.flag != '0' $conditions 
ORDER BY u.oid ASC ");
$stmt_data->execute();		

?>


<div class="table-responsive">
	<table class="table table-bordered table-hover table-strip" id="tbData" style="">
    <thead>
    <tr>
                        <th class="text-center" width="20px">ลำดับ</th>
                        <th>รายละเอียด</th>
                        <th width="100px">บันทึกโดย</th>
                        <th class="text-center" width="20px">จัดการ</th>	
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
                $service_desc = $row['service_desc'];

                $add_date = date_db_2form($row['add_date'])." ".substr($row['add_date'],11,5)." น.";
                $add_users = getUsername($row['add_users']);

                ?>


            
 
                <tr>
                            <td class="text-center"><?php echo $i;?></td>
                           
                            <td><?php echo $service_desc;?></td>
                            <td ><?php echo $add_users; ?>
                            <small><?php echo $add_date;?></small></td>
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
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไข</span>
                                            </a>
                                        </li>

                                        <li class="navi-separator my-3"></li>

                                        <li class="navi-item">
                                            <a href="#" class="navi-link" onclick='confirm_coordinate_data_delete(<?php echo $oid; ?>)'>
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