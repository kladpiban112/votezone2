<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// add Lib mPDF to projectr
require_once "../config.php";
require_once "../vendor/autoload.php";
require_once "../core/functions.php";

ob_start();

$bookingid = filter_input(INPUT_GET, 'bookingid', FILTER_SANITIZE_STRING);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>invoice</title>
    
    <style>
     body{
        font-family: "garuda";
     }
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
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
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
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
SELECT b.*,st.sts_title,st.sts_color,r.rooms_number,r.rooms_cleaning,t.rooms_typetitle,bb.bed_title
FROM ".DB_PREFIX."booking b
LEFT JOIN ".DB_PREFIX."booking_status st ON b.booking_status = st.sts_id
LEFT JOIN ".DB_PREFIX."rooms r ON b.booking_roomsid = r.rooms_id
LEFT JOIN ".DB_PREFIX."rooms_type t ON r.rooms_type = t.rooms_typeid
LEFT JOIN ".DB_PREFIX."rooms_bed bb ON r.rooms_bed = bb.bed_id
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
    $rooms_cleaning = $row['rooms_cleaning'];
    $sts_title = $row['sts_title'];
    $booking_custcompany = $row['booking_custcompany'];
    $booking_custmax = $row['booking_custmax'];
    $rooms_number = $row['rooms_number'];
    $rooms_typetitle = $row['rooms_typetitle'];
    $bed_title = $row['bed_title'];

    $s_booking_price += $booking_pricetotal;
    $s_booking_amountday += $booking_amountday;
    $s_booking_custmax += $booking_custmax;
    ?>

<?php 
} // end while
?>

?>



<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td>
                                Invoice #: 123<br>
                                Created: <?php echo date()?><br>
                                Due: February 1, 2015
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                ดาหลาวิลล์ อพาร์เมนท์<br>
                                ถ.รามวิถี ต.บ่อยาง<br>
                                อ.เมือง จ.สงขลา 90000 <br>
                                หมายเลขบริษัท/GST 200506877R
                            </td>
                            
                            <td>
                                หมายเลขการจอง : <?php echo $booking_number;?><br>
                                วันที่เรียกเก็บเงิน 20/05/2562<br>
                               
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
                <td> ชื่อ - สกุล : <?php echo $booking_custname;?> </td><td>  </td>
            </tr>
            <tr class="details">
                <td>
                    ที่อยู่ :  <?php echo $booking_custcompany;?>
                </td>
                
                <td>
                
                </td>
            </tr>
            <tr class="details">
                <td>
                    อีเมล์ : <?php echo $booking_custemail; ?>
                </td>
                
                <td>
                  
                </td>
            </tr>
            <tr class="details">
                <td>
                    โทร. <?php echo $booking_custtel;?>
                </td>
                
                <td>
               
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
                   ชื่อโรงแรม
                </td>
                
                <td>
                    
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    ช่วงเวลา :  <?php echo $booking_checkin;?> ถึง <?php echo $booking_checkout;?> จำนวน <?php echo $s_booking_amountday; ?> วัน
                </td>
                
                <td>
               
                </td>
            </tr>
            

            <tr class="item">
                <td>
                   ประเภทห้อง :  <?php echo $bed_title;?>
                </td>
                
                <td>
              
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    จำนวนห้อง 1 ห้อง
                </td>
                
                <td>
                
                </td>
            </tr>
           
            
            <tr class="item">
                <td>
                    ค่าห้องพักทั้งหมด
                </td>
                
                <td>
                    
                </td>
            </tr>
                        
            <tr class="item last">
                <td>
                    Discount
                </td>
                
                <td>
                   
                </td>
            </tr>
            
            <tr class="total">
                <td> </td>
                
                <td>
                รวมค่าใช้จ่ายทั้งหมด : <?php echo number_format($booking_pricetotal,2);?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php

$html = ob_get_contents();
ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'tempDir' => __DIR__ . '/tmp'
]);
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output();

?>
