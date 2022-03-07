<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// add Lib mPDF to projectr
require_once "../config.php";
require_once "../vendor/autoload.php";
require_once "../core/functions.php";

ob_start();
$datenow = date("Y-m-d");
$dtnow = date("Y-m-d H:i:s");
$bookingid = filter_input(INPUT_GET, 'bookingid', FILTER_SANITIZE_STRING);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>GUEST FOLIO</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 10px;
       /* border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15); */
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 10px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 10px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<?php
$sql = "
SELECT b.*,st.sts_title,st.sts_color,r.rooms_number,r.rooms_cleaning,t.rooms_typetitle,bb.bed_title,p.payment_vat
,p.payment_pricevat,p.payment_price,bcus.cust_customername,u.name
FROM ".DB_PREFIX."booking b
LEFT JOIN ".DB_PREFIX."booking_status st ON b.booking_status = st.sts_id
LEFT JOIN ".DB_PREFIX."rooms r ON b.booking_roomsid = r.rooms_id
LEFT JOIN ".DB_PREFIX."rooms_type t ON r.rooms_type = t.rooms_typeid
LEFT JOIN ".DB_PREFIX."rooms_bed bb ON r.rooms_bed = bb.bed_id
LEFT JOIN ".DB_PREFIX."payment p on b.booking_id = p.payment_bookingid
LEFT JOIN ".DB_PREFIX."users u on b.booking_addusers = u.user_id
LEFT JOIN (SELECT cust_bookingid,GROUP_CONCAT(cust_custname) cust_customername FROM ".DB_PREFIX."booking_customer WHERE cust_bookingid = '$bookingid') bcus on b.booking_id = bcus.cust_bookingid
WHERE b.booking_id = '$bookingid' 
ORDER BY b.booking_id DESC";	
$stmt_users = $conn->prepare ($sql);
$stmt_users->execute();

$s_booking_price = 0;
while ($row = $stmt_users->fetch(PDO::FETCH_ASSOC))
{
    $booking_id = $row['booking_id'];
    $booking_number = $row['booking_number'];						
    $booking_checkin = $row['booking_checkin'];
    $booking_checkout = $row['booking_checkout'];
    $booking_amountday = $row['booking_amountday'];
    $booking_custname = $row['booking_custname'];
    $booking_custtel = $row['booking_custtel'];
    $booking_custemail = $row['booking_custemail'];
    $booking_pricetotal = $row['booking_pricetotal'];
    $booking_price = $row['booking_price'];
    $booking_custaddress = $row['booking_custaddress'];
    $rooms_cleaning = $row['rooms_cleaning'];
    $sts_title = $row['sts_title'];
    $booking_custcompany = $row['booking_custcompany'];
    $booking_custmax = $row['booking_custmax'];
    $rooms_number = $row['rooms_number'];
    $rooms_typetitle = $row['rooms_typetitle'];
    $bed_title = $row['bed_title'];
    $addusername = $row['name'];


    $payment_vat = $row['payment_vat'];
    $payment_pricevat = $row['payment_pricevat'];
    $payment_price = $row['payment_price'];

    $cust_customername = $row['cust_customername'];

    $s_booking_price += $booking_pricetotal;
    $s_booking_amountday += $booking_amountday;
    $s_booking_custmax += $booking_custmax;

    $roomprice = $booking_price*$s_booking_amountday;
    ?>

<?php 
} // end while
?>

?>



<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
        <tr>
                <td colspan= "2" align="center">
                   <h2>GUEST FOLIO</h2>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                    <tr>
                            <td align="left">
                            <img src="../assets/images/dala_logo.png" style="width:100%; max-width:350px;">
                            </td>
                            
                            <td>
                            <?php
                            $sql_company = "SELECT * FROM ".DB_PREFIX."sys_company";
                            $stmt_company = $conn->prepare ($sql_company);
                            $stmt_company->execute();
                            $row_comp = $stmt_company->fetch(PDO::FETCH_ASSOC);
                            $companyname = $row_comp['companyname_th'];
                            $companyaddress = $row_comp['companyaddress'];
                            $companytel = $row_comp['companytel'];
                            $companyfax = $row_comp['companyfax'];
                            ?>
                                <?php echo $companyname; ?>
                                <?php echo $companyaddress; ?><br>
                                โทร. <?php echo $companytel; ?> โทรสาร. <?php echo $companyfax; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                            หมายเลขการจอง : <?php echo $booking_number;?> 
                                 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
           <tr class="heading">
                <td>
                   ชื่อและที่อยู่ของลูกค้า
                </td>
                
                <td>
                    
                </td>
            </tr>
            
            
            <tr class="details">
                <td> ชื่อ - สกุล : <?php echo $cust_customername;?> </td><td>  </td>
            </tr>
            <tr class="item">
                <td colspan="2">ที่อยู่ : <?php echo $booking_custaddress;?></td>
            </tr>
            <tr class="item">
                <td colspan=2>
                    วันที่เข้าพัก : <?php echo date_sub_thai($booking_checkin); ?>             วันที่ออก : <?php echo date_sub_thai($booking_checkout);?> จำนวน <?php echo $s_booking_amountday; ?> คืน
                </td>
            </tr>
            <tr class="item">
                <td colspan=2>
                   ประเภทห้อง :  <?php echo $rooms_typetitle."(".$bed_title.") ROOM NO. ".$rooms_number; ?>
                </td>
                
            </tr>

            <tr class="heading">
                <td>
                    รายละเอียด
                </td>
                
                <td>
                    ค่าใช้จ่าย
                </td>
            </tr>
            <tr class="item">
                <td>
                    ค่าห้องพัก <?php echo $booking_price." X ".$s_booking_amountday; ?>
                </td>
                
                <td>
                <?php echo number_format($roomprice,2); ?>
                </td>
            </tr>
            <?php
$sql_additional = "SELECT p_id,p_bookingid,p_title,p_price FROM ".DB_PREFIX."payment_additional WHERE p_bookingid = '$bookingid'";
$stmt_additional = $conn->prepare ($sql_additional);
$stmt_additional->execute();
$nRows = $stmt_additional->rowCount(); 
//$number_additional = $stmt_additional->fetchColumn(); 


			if($nRows > 0){?>
			    <tr class="item last">
                <td>
                    ชำระเพิ่มเติม <?php echo $nRows; ?> รายการ
                   
                </td>
                
                <td></td>
            </tr>
            <?php
                    $i=1;
                    while ($rs = $stmt_additional->fetch(PDO::FETCH_ASSOC))
                    {
                        $ptitle = $rs['p_title'];
                        $pprice = $rs['p_price'];

                        $spprice += $pprice;
                    
              echo  "<tr class='item last'><td>".$i.". ".$ptitle."</td><td>".$pprice."</td></tr>";
          
            $i++;
                    }
            ?>

			<?php 
			}
			?>
            <tr class="total">
                <td>( <?php echo ThaiBahtConversion($booking_pricetotal); ?> ) </td>
                
                <td>
                รวมค่าใช้จ่ายทั้งหมด : <?php echo number_format($booking_pricetotal,2);?>
                </td>
            </tr>
            <tr class="detail">
                <td colspan=2  align="center">&nbsp;</td>
            </tr>
            <tr class="detail">
                <td colspan=2  align="center">&nbsp;</td>
            </tr>
            <tr class="detail">
                <td colspan=2  align="center">&nbsp;</td>
            </tr>
            <tr class="detail">
                <td colspan=2  align="center">&nbsp;</td>
            </tr>
            <tr class="detail">
            <td align="center">( <?php echo $booking_custname;?> )<br>ลายมือชื่อผู้พัก</td><td align="center">( <?php echo $addusername; ?> )<br>เจ้าหน้าที่<br>วันที่พิมพ์ <?php echo date_sub_thai($dtnow); ?></td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php

$html = ob_get_contents();
ob_end_clean();

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'THSarabunNew.ttf',
            //'I' => 'THSarabunNew Italic.ttf',
            //'B' => 'THSarabunNew Bold.ttf',
        ]
    ],
    'default_font_size' => 16,
    'default_font' => 'thsarabun',
    'mode' => 'utf-8',
    'format' => 'A4',
    'tempDir' => __DIR__ . '/tmp',
]);
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output();

?>
