<?php
error_reporting(0);

session_start();
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$repairid = filter_input(INPUT_POST, 'repairid', FILTER_SANITIZE_STRING);
$repairid_enc = base64_encode($repairid);

$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$personid_enc = base64_encode($personid);

$conditions = " AND u.repair_id = '$repairid' ";
$stmt_data = $conn->prepare("SELECT u.*,qts.qt_statusname
FROM ".DB_PREFIX."repair_quotation u
LEFT JOIN ".DB_PREFIX."repair_quotation_status qts ON u.qt_status = qts.qt_statusid
WHERE u.flag = '1' $conditions 
ORDER BY u.oid ASC");
$stmt_data->execute();
$numb_rows = $stmt_data->rowCount();


$qRepair = getRepairPayment($repairid);
$cost = $qRepair["cost"];
$cost_payment = $qRepair["cost_payment"];
$payment_amount_now = $qRepair["cost"] - $qRepair["cost_payment"];
$cost_success = $qRepair["cost_success"];

?>


<!-- <div class="form-group row">
<div class="col-lg-12 mb-5">
<?php if($cost_success == '0'){?>
<div class="alert alert-custom alert-notice alert-light-warning fade show " role="alert">
                            <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
                            <div class="alert-text">รอชำระเงิน</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                </button>
                            </div>
                            </div>

<?php }else if($cost_success == '1'){ ?>
    <div class="alert alert-custom alert-notice alert-light-success fade show " role="alert">
                            <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="alert-text">ชำระเงินเรียบร้อยแล้ว</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                </button>
                            </div>
                            </div>
<?php }?>
</div>

        <div class="col-lg-6">
            <label>ค่าซ่อม(บาท)</label>
            <input type="text" class="form-control"  name="cost" id="cost" placeholder="" value="<?php echo $cost;?>" disabled/>
         </div>

         <div class="col-lg-6">
            <label>ชำระแล้ว(บาท)</label>
            <input type="text" class="form-control"  name="cost_payment" id="cost_payment" placeholder="" value="<?php echo $cost_payment;?>" disabled/>
         </div>

</div>
       -->
<div class="table-responsive">
    <table class="table table-bordered table-hover table-strip" id="tbData" style="margin-top: 13px !important">
        <thead>
            <tr>
                <th class="text-center">ลำดับ</th>
                <th>วันที่เสนอราคา</th>
                <th>เลขที่ใบเสนอราคา</th>
                <th>จำนวนเงิน</th>
                
                <th>สถานะ</th>
                <th>วันที่อนุมัติซ่อม</th>
                <th class="text-center">จัดการ</th>
            </tr>
        </thead>
        <tbody>

            <?php
    if ($numb_rows > 0) {
        $i = 0;
        while ($row = $stmt_data->fetch(PDO::FETCH_ASSOC)) {
            ++$i;
            $oid = $row['oid'];
            $oid_enc = base64_encode($oid);
            $qt_date = date_db_2form($row['qt_date']);
            $qt_code = $row['qt_code'];
            $qt_price = $row['qt_price'];
            $qt_statusname = $row['qt_statusname'];
            $qt_approvedate = date_db_2form($row['qt_approvedate']);
            $qt_pricetotal = $row['qt_pricetotal'];
            
            $flag = $row['flag'];
            if($flag == '0'){
                $payment_status = '<i class="far fa-times-circle text-danger"></i>';
            }else{
                $payment_status = '<i class="far fa-check-circle text-success"></i>';
            }
?>

            <tr>
                <td class="text-center" width="20px"><?php echo $i; ?></td>

                <td><?php echo $qt_date; ?></td>
                <td><?php echo $qt_code; ?></td>
                <td><?php echo $qt_pricetotal; ?></td>
                
                <td class="text-center"><?php echo $qt_statusname; ?></td>
                <td><?php echo $qt_approvedate; ?></td>
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
                                    <a href="dashboard.php?module=finance&page=repair-quotation-print&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&qtid=<?php echo $oid_enc;?>&act=<?php echo base64_encode('view');?>" class="navi-link" >
                                        <span class="navi-icon"><i class="fas fa-print"></i></span>
                                        <span class="navi-text">พิมพ์ใบเสนอราคา</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="dashboard.php?module=finance&page=repair-quotation-edit&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&id=<?php echo $oid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link" >
                                        <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                        <span class="navi-text">แก้ไขใบเสนอราคา</span>
                                    </a>
                                </li>


                                <li class="navi-item">
                                    <a href="dashboard.php?module=finance&page=repair-quotation-edit&repairid=<?php echo $repairid_enc;?>&personid=<?php echo $personid_enc;?>&id=<?php echo $oid_enc;?>&act=<?php echo base64_encode('edit');?>" class="navi-link" >
                                        <span class="navi-icon"><i class="far fa-calendar-check"></i></span>
                                        <span class="navi-text">อนุมัติซ่อม</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="#" class="navi-link" onclick='delQtData(<?php echo $oid; ?>)'>
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">ยกเลิกรายการ</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                    <!--end::Dropdown-->
                    <?php } ?>

                </td>

            </tr>
            <?php //include 'modal-repair-edit-status.php'; ?>

            <?php
        } // end while
    } else {?>
            <tr>
                <td class="text-center" height="50px" colspan="8">ไม่มีข้อมูล</td>
            </tr>
            <?php }
            ?>

        </tbody>
    </table>
</div>