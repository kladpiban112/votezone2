<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// add Lib mPDF to projectr
require_once '../config.php';
require_once '../vendor/autoload.php';
require_once '../core/functions.php';

ob_start();
$datenow = date('Y-m-d');
$dtnow = date('Y-m-d H:i:s');

$orderid = filter_input(INPUT_GET, 'orderid', FILTER_SANITIZE_STRING);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="print-style.css">



 
    <title>ใบเสนอราคา/QUOTATION</title>
    <style>
body {font-family: angsana;
	font-size: 16pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { vertical-align: top; }
.items td {
	border-left: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
}
</style>

</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; ">
<pan><img width="150" src="https://goverlution.teamtamweb.com/my-account/assets/images/logo-gov.png"></span><br />
<span style="font-weight: bold; font-size: 14pt;">EZKAE Company Limited</span><br />
65/206 อาคาร/หมู่บ้าน ชำนาญเพ็ญชาติ ชั้น 24  <br />
ถนนพระราม 9 แขวงห้วยขวาง เขตห้วยขวาง<br />
กรุงเทพมหานคร 10320<br />
<span style="font-family:dejavusanscondensed;">&#9742;</span> 
026-430-744
</td>

<td width="50%" style="text-align: right;">
<span><h2> ใบเสนอราคา/QUOTATION</h2></span><br/>
Invoice No. 
<span style="font-weight: bold; font-size: 14pt;"><?php echo gov_orderidshow($orderid); ?></span>
</td>
</tr>
</table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

    <?php
    $sql = 'SELECT a.*,b.*,DATE_ADD(a.add_date, INTERVAL 7 DAY) valid_date
            FROM '.DB_PREFIX."order_main a 
            left join users b on a.add_users = b.user_id
            WHERE a.order_id = '$orderid'
            ";
//echo $sql;
$result = $conn->prepare($sql);
$result->execute();

$rs = $result->fetch(PDO::FETCH_ASSOC);
//echo $rs_count = count($conn->prepare ($sql));

$username = $rs['name'];
$adddate = $rs['add_date'];
$valid_date = $rs['valid_date'];
$orderid = $rs['order_id'];
$addr .= isset($rs['buyer_soi']) ? ' ซ.'.$rs['buyer_soi'] : '';
$addr .= isset($rs['buyer_road']) ? ' ถ.'.$rs['buyer_road'] : '';
$addr .= isset($rs['buyer_village']) ? ' ม.'.$rs['buyer_village'] : '';
$addr1 = isset($rs['buyer_tambon']) ? ' ต.'.$rs['buyer_tambon'] : '';
$addr1 .= isset($rs['buyer_ampur']) ? ' อ.'.$rs['buyer_ampur'] : '';
$addr1 .= isset($rs['buyer_changwat']) ? ' จ.'.$rs['buyer_changwat'] : '';

?>

<table width="100%" border=1>
<tr>
<td width='60%'>
    <table width="100%">
    <tr><td>
    
    </td><td>
    <span><center><h3> ( ต้นฉบับ / ORIGINAL )</h3></center></span>
    </td></tr>
    </table>
</td>

<td><center><img width="200" src="https://goverlution.teamtamweb.com/my-account/assets/images/logo-gov.png"></center></td>
</tr>
<tr>
<td>
<table width="100%" border=1>
    <tr><td>
    ลูกค้า / Customer :
    </td><td><left>
    <?php echo $username; ?>
    </left></td></tr>
    </table>
    </td>
<td>
<table width="100%" border=1>
    <tr><td>
    เลขที่ / No :
    </td><td><left>
    
    </left></td></tr>
    </table> </td>
</tr>
<tr>
<td>
<table width="100%" border=1>
    <tr><td>
    ที่อยู่ / Address :
    </td><td>
    <?php echo '-'; ?>
    </td></tr>
    </table></td>
<td>
<table width="100%" border=1>
    <tr><td>
    วันที่ / Issue :
    </td><td><left>
    <?php echo date_sub_thai($adddate); ?>
    </left></td></tr>
    </table></td>
</tr>
<tr>
<td>
<table width="100%" border=1>
    <tr><td>
    เลขผู้เสียภาษี / Tax ID :
    </td><td>
    -
    </td></tr>
    </table></td>
<td>
<table width="100%" border=1>
    <tr><td>
    ใช้ได้ถึง / Valid :
    </td><td><left>
    <?php echo date_sub_thai($valid_date); ?>
    </left></td></tr>
    </table> </td>
</tr>
<tr>
<td>
<table width="100%" border=1>
    <tr><td>
    ผู้ติดต่อ / Attention :
    </td><td>
    -
    </td></tr>
    </table></td>
<td>
<table width="100%" border=1>
    <tr><td>
    อ้างอิง / Ref :
    </td><td>
    -
    </td></tr>
    </table></td>
</tr>

</table>
  <hr>                                              
<table width="100%">
<tr>
<td width="5%">ผู้ออก <br> Issuer </td>
<td width="45%"> <?php echo $username; ?><br>ที่อยู่</td>
<td width="25%">เลขผู้เสียภาษี / Tax ID : </td>
<td width="25%">111111111111</td>
</tr>

</table>
                                               
 <table style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px;" width="100%">
 <thead>
        <tr>
            <td width="7%" style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:center;"><strong>ลำดับที่ </strong><br> No.</td>
            <td width="15%" style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:center;"><strong>รหัส </strong><br> ID No.</td>
             <td width="38%" style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:center;"><strong>คำอธิบาย </strong><br> Description.</td>
            <td width="10%" style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:center;"><strong>จำนวน </strong><br>Quantity</td>
             <td width="15%" style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:center;"><strong>ราคาต่อหน่วย </strong><br>UNIT PRICE (BAHT)</td>
            <td width="15%" style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:center;"><strong>ราคารวม </strong><br>TOTAL PRICE (BAHT)</td>
</tr>
                                                                            </thead>
                                                                            <tbody>
                                                                           
                                                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                                                <?php

                                                                               echo $sql = "SELECT o.order_id,o.order_session,od.oid AS od_id,od.quantity,od.productprice,od.productid proid,od.productname,omd.price_total,omd.discount,omd.grand_total 
                                                                               FROM order_detail od 
                                                                               LEFT JOIN order_main o ON od.order_id = o.order_id
                                                                               LEFT JOIN order_main_detail omd ON od.order_id = omd.order_id
                                                                               WHERE o.order_id = '$orderid' AND o.flag != '99' AND od.flag = '1'
                                                                               ";
    $result = $conn->prepare($sql);
    $rs_count = count($conn->prepare($sql));
    $result->execute();
    $content = '';
    if ($rs_count > 0) {
        $i = 1;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $totalprice = $row['productprice'] * $row['quantity'];
            $grandtotal = $row['grand_total'];
            $discounttotal = $row['discount'];
            $pricetotal += $totalprice; ?>
			<tr style="border:1px #000;">
				<td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:center;"  ><?php echo $i; ?></td>
                <td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:left;" ><?php echo getProductID($row['proid']); ?></td>
				<td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:left;" ><?php echo $row['productname']; ?></td>
				<td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:center;"  ><?php echo $row['quantity']; ?></td>
				<td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:right;"  ><?php echo $row['productprice']; ?></td>
				<td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:right;"  ><?php echo number_format($totalprice, 2); ?></td>
				
                
			</tr>
            <?php
            ++$i;
        }
    }
        ?>                                                            
                                                                            </tbody>
                                                                            <tfoot>
                                                                            <tr>
                                                                            <td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:right;" colspan='5'>ราคาสุทธิสินค้ายกเว้นภาษี (บาท) / VAT-Exempted Amount</td>
                                                                            <td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:right;"><?php echo number_format($pricetotal, 2); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:right;" colspan='5'>ส่วนลด / Discount</td>
                                                                            <td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:right;"><?php echo $discounttotal; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:right;" colspan='5'>จํานวนเงินรวมทั้งสิ้น (<?php echo bahtText($grandtotal); ?>) / Grand Total</td>
                                                                            <td style="border:1px solid #000000; border-collapse:collapse; cellpadding:0px; cellspacing:0px; text-align:right;"><?php echo number_format($grandtotal, 2); ?></td>
                                                                            </tr>
                                                                            
                                                                            </tfoot>
                                                                        </table>
                                                                        <br>
<table>
<tr>
<td width="50%">
<table><tr><td>การชำระเงิน</td></tr>
<tr><td>&nbsp;โอนเข้าบัญชีธนาคาร........... ชื่อบัญชี ......................</td></tr>
<tr><td>&nbsp;สาขา......... เลขที่บัญชี .................................</td></tr>
<tr><td>&nbsp;วันที่ ........................ จำนวน ................... บาท</td></tr>
</table>
</td>
<td width="25%">
<table><tr><td>อนุมัติโดย / Approved by</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;...........................</td></tr>
<tr><td>&nbsp;วันที่ / Date........................ </td></tr>
</table>
</td>
<td width="25%">
<table><tr><td>ยอมรับใบเสนอราคา / Accept by</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;...........................</td></tr>
<tr><td>&nbsp;วันที่ / Date........................ </td></tr>
</table>
</td>
</tr>


</table>

</body>
</html> 

<?php

$html = ob_get_contents();
ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font' => 'angsana',
    'default_font_size' => 14,
    'tempDir' => __DIR__.'/tmp',
    'margin_left' => 20,
    'margin_right' => 15,
    'margin_top' => 48,
    'margin_bottom' => 25,
    'margin_header' => 10,
    'margin_footer' => 10,
     ]);
     $mpdf->SetProtection(['print']);
     $mpdf->SetTitle('Goverlution. - Invoice');
     $mpdf->SetAuthor('Goverlution.');
     $mpdf->SetWatermarkText('Invoice');
     $mpdf->showWatermarkText = true;
     $mpdf->watermark_font = 'DejaVuSansCondensed';
     $mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output();

?>



