<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// add Lib mPDF to projectr
require_once '../config.php';
require_once '../vendor/autoload.php';

ob_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="print-style.css">




    <title>ใบเสร็จรับเงิน/invoice</title>

</head>

<body>
    <table width="100%">
        <tr>
            <td>ที่อยู่ : </td>
            <td></td>
        </tr>
        <tr>
            <td>ดาหลา อพาร์ทเมนท์</td>
            <td></td>
        </tr>
        <tr>
            <td>ถ.รามวิถี อ.เมือง</td>
            <td></td>
        </tr>
        <tr>
            <td>จ.สงขลา 90000</td>
            <td></td>
        </tr>
        <tr>
            <td>โทร. 0891111111111</td>
            <td></td>
        </tr>
        <tr>
            <td>หมายเลขบริษัท/GST 200S06877R</td>
            <td></td>
        </tr>
    </table>
    <div valign="center">
        <h3> ใบเสร็จรับเงิน</h3>
    </div>
    <table>
        <tr>
            <td colspan="2" class="center">ชื่อและที่อยู่ของลูกค้า </td>
        </tr>
        <tr>
            <td>ชื่อ</td>
            <td>ชื่อ</td>
        </tr>
        <tr>
            <td>ที่อยู่</td>
            <td>ที่อยู่</td>
        </tr>
        <tr>
            <td>อีเมล์</td>
            <td>อีเมล์</td>
        </tr>
        <tr>
            <td>โทร. </td>
            <td>0891111111111</td>
        </tr>
    </table>
    <br>
    <table style="border:1px solid #000000;" width="100%">
        <thead>
            <tr>
                <td><strong>Item</strong></td>
                <td class="text-center"><strong>Price</strong></td>
                <td class="text-center"><strong>Quantity</strong></td>
                <td class="text-right"><strong>Totals</strong></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Item</strong></td>
                <td class="text-center"><strong><?php echo 'ccccc'; ?></strong></td>
                <td class="text-center"><strong>Quantity</strong></td>
                <td class="text-right"><strong>Totals</strong></td>
            </tr>
            <!-- foreach ($order->lineItems as $line) or some such thing here -->
            <?php

                                                                               echo $sql = 'SELECT b.*,st.sts_title,st.sts_color,r.rooms_number,r.rooms_cleaning,t.rooms_typetitle,bb.bed_title
                                                                               FROM '.DB_PREFIX.'booking b
                                                                               LEFT JOIN '.DB_PREFIX.'booking_status st ON b.booking_status = st.sts_id
                                                                               LEFT JOIN '.DB_PREFIX.'rooms r ON b.booking_roomsid = r.rooms_id
                                                                               LEFT JOIN '.DB_PREFIX.'rooms_type t ON r.rooms_type = t.rooms_typeid
                                                                               LEFT JOIN '.DB_PREFIX."rooms_bed bb ON r.rooms_bed = bb.bed_id
                                                                               WHERE b.booking_company = '$companyid' AND b.booking_branch = '$branchid'
                                                                               $status_search 
                                                                               ORDER BY b.booking_id DESC";
    $result = $conn->prepare($sql);
    echo $rs_count = count($conn->prepare($sql));
    $result->execute();
    $content = '';
    if ($rs_count > 0) {
        $i = 1;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"><?php echo $i; ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"><?php echo $row['rooms_id']; ?>
                </td>
                <td style="border-right:1px solid #000;padding:3px;"><?php echo $row['rooms_number']; ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">
                    <?php echo $row['rooms_title']; ?></td>
                <td><?php echo number_format($row['rooms_price'], 2); ?></td>
            </tr>
            <?php
            ++$i;
        }
    }
        ?>
        </tbody>
    </table>

</body>

</html>

<?php

$html = ob_get_contents();
ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'tempDir' => __DIR__.'/tmp',
]);
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output();

?>