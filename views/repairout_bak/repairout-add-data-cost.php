<?php
session_start();
require_once "../../core/config.php";
require_once ABSPATH."/checklogin.php";
require_once ABSPATH."/functions.php";

$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$repairid_enc = base64_encode($repairid);
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$personid_enc = base64_encode($personid);

$conditions = " AND u.repair_id = '$repairid' ";
$stmt_data = $conn->prepare ("SELECT u.*
FROM ".DB_PREFIX."repair_payment u 
WHERE u.flag != '0' $conditions 
ORDER BY u.oid ASC
$max");
$stmt_data->execute();	
$numb_rows = $stmt_data->rowCount();	

?>


<div class="table-responsive">
	<table class="table table-bordered table-hover table-strip" id="tbData" style="margin-top: 13px !important">
    <thead>
    <tr>

                        <th class="text-center">ค่าซ่อม</th>
                        <th class="text-center">ชำระแล้ว</th>
                        <th class="text-center">สถานะชำระเงิน</th>
                        <th class="text-center">ชำระเงิน</th>	
    </tr>
    </thead>
    <tbody>

    <?php
    if($numb_rows >0){

            $i  = 0;
            while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC))
            {
                $i++;
                $oid = $row['oid'];
                $oid_enc = base64_encode($oid);
                $cost = $row['cost']; // ค่าซ่อม
                $cost_payment = $row['cost_payment']; // ค่าซ่อมชำระแล้ว
                $cost_success = $row['cost_success'];

      
                ?>


            
 
                <tr>
                            <td class="text-center"><?php echo $cost;?></td>
                            <td class="text-center"><?php echo $cost_payment;?></td>
                            <td class="text-center"><?php  if($cost_success == '0'){
                                echo '<i class="fas fa-exclamation-circle text-warning"></i>';
                            }else if($cost_success == '1'){
                                echo '<i class="fas fa-check-circle text-success"></i>';
                            }else{

                            }
                            ?></td>
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
                                            <a href="dashboard.php?module=repairout&page=repairout-edit-data-cost&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&costid=<?php echo $oid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link"  >
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">แก้ไขค่าซ่อม</span>
                                            </a>
                                        </li> 

                                        <li class="navi-item">
                                            <a href="dashboard.php?module=finance&page=payment-repair-add&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&costid=<?php echo $oid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link"  >
                                                <span class="navi-icon"><i class="fas fa-hand-holding-usd"></i></span>
                                                <span class="navi-text">บันทึกชำระเงิน</span>
                                            </a>
                                        </li>

                                        <li class="navi-item">
                                        
                                            <a href="#" class="navi-link" onclick='delCostData(<?php echo $oid; ?>)'>
                                                <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                                <span class="navi-text">ยกเลิกรายการ</span>
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

          }else{?>
          <tr>
              <td class="text-center" height="50px" colspan="4">ไม่มีข้อมูล</td>
          </tr>  
          <?php }
            ?>

            </tbody>
           
            </table>
        </div>