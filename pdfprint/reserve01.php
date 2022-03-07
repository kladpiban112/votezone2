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
$UserDetailsArray = getUserDetailsArray($logged_user_id);
$name = $UserDetailsArray['name'];
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ใบจอง</title>
    
    <style>

    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 330px 5x 5px 2px;
       /* border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15); */
        font-size: 15px;
        line-height: 22px;
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
        padding-bottom: 2px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 35px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 2px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 5px;
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
,p.payment_vat,p.payment_pricevat,p.payment_price,p.payment_advince,u.name
FROM ".DB_PREFIX."booking b
LEFT JOIN ".DB_PREFIX."booking_status st ON b.booking_status = st.sts_id
LEFT JOIN ".DB_PREFIX."rooms r ON b.booking_roomsid = r.rooms_id
LEFT JOIN ".DB_PREFIX."rooms_type t ON r.rooms_type = t.rooms_typeid
LEFT JOIN ".DB_PREFIX."rooms_bed bb ON r.rooms_bed = bb.bed_id
LEFT JOIN ".DB_PREFIX."payment p on b.booking_id = p.payment_bookingid
LEFT JOIN ".DB_PREFIX."users u on b.booking_addusers = u.user_id
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
    $booking_custcid = $row['booking_custcid'];
    $booking_custemail = $row['booking_custemail'];
    $booking_price = $row['booking_price'];
    $booking_pricetotal = $row['booking_pricetotal'];
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
    $payment_advince = $row['payment_advince'];


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
                   <h2>ใบจอง</h2>
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
                                โทร. <?php echo $companytel; ?> โทรสาร. <?php echo $companyfax; ?><br>
                                หมายเลขการจอง : <?php echo $booking_number;?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan=2> ชื่อ - สกุล : <?php echo $booking_custname;?> อีเมล์ : <?php echo $booking_custemail; ?> โทร. <?php echo $booking_custtel;?> </td>
            </tr>
            <tr>
                <td colspan=2>
                    วันเดือนปีเกิด (DOB) : ...........................  สัญชาติ (Nationality) :................. อาชีพ (Occupation) : ........................
                </td>
                
            </tr>
            <tr>
                <td colspan=2>
                    เลขประจำตัวประชาชน (Thai ID NO.) :<?php echo $booking_custcid;?>  
                </td>
                
            </tr>
            <tr>
                <td colspan=2>
                    ออกให้โดย (Issued at) : ...........................  วันออกบัตร :............................. บัตรหมดอายุ : ......................................
                </td>
                
            </tr>
            <tr>
                <td colspan=2>
                    ที่อยู่ปัจจุบัน :  <?php echo $booking_custaddress;?>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    มาจาก (Come From) :  ....................................  กำลังจะไป (Go To) : ...............................................
                </td>
            </tr>
            <tr class="heading">
            <td colspan=2 align="center">** โรงแรมไม่รับผิดชอบการสูญหายของทรัพย์สินมีค่าของท่าน ** <br> (The Hotel is not responsible for safety of any valuables left in Guest Room) <td>
            </tr>

<tr>
<td colspan=2>

<table border="1">
<tr>
<td>วันเดือนปี ที่เข้าพัก Arrival Date <br><?php echo date_sub_thai($booking_checkin);?><br>
วันเดือนปี ที่ออก Departure Date<br><?php echo date_sub_thai($booking_checkout);?></td>
<td>ห้องพัก <?php echo $rooms_number."<br>".$rooms_typetitle."(".$bed_title.")";?><br><br><center>( <?php echo $booking_custname;?> )<br>ลายมือชื่อผู้พัก</center></td>
<td align="center"><br>( <?php echo $addusername; ?> )<br>เจ้าหน้าที่<br>วันที่พิมพ์ <?php echo date_sub_thai($dtnow); ?></td>
</tr>
</table>

</td>
</tr>
<!--
            <tr class="detail">
                <td colspan=2 style="color:red;">
                    (***ได้รับค่ามัดจำ <?php echo number_format($payment_advince,2); ?> บาท)</td>
            </tr>
-->
    

        </table>
    </div>
</body>
</html>

<?php

$html = ob_get_contents();
ob_end_clean();

//$mpdf = new \Mpdf\Mpdf();

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
