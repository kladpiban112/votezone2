<?php

    require_once '../config.php';
    //เรียกใช้ไฟล์ autoload.php ที่อยู่ใน Folder vendor
    require_once '../vendor/autoload.php';

    $sql = 'SELECT * FROM order_main';
    $result = $conn->prepare($sql);
    $rs_count = count($conn->prepare($sql));
    $result->execute();
    $content = '';
    if ($rs_count > 0) {
        $i = 1;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $content .= '<tr style="border:1px solid #000;">
				<td style="border-right:1px solid #000;padding:3px;text-align:center;"  >'.$i.'</td>
				<td style="border-right:1px solid #000;padding:3px;text-align:center;" >'.$row['order_id'].'</td>
				<td style="border-right:1px solid #000;padding:3px;"  >'.$row['order_id'].'</td>
				<td style="border-right:1px solid #000;padding:3px;text-align:center;"  >'.$row['order_id'].'</td>
				<td style="border-right:1px solid #000;padding:3px;text-align:right;"  >'.number_format($row['order_id'], 2).'</td>
			</tr>';
            ++$i;
        }
    }

//$mpdf = new mPDF();
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
]);
$head = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>

<h2 style="text-align:center">ใบรับสินค้า</h2>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12pt;margin-top:8px;">
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"   width="10%">ลำดับ</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"  width="15%">รหัสห้อง</td>
        <td  width="45%" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;รายละเอียดสินค้า</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"  width="15%">หน่วยนับ</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%">ราคา (฿)</td>
    </tr>

</thead>
	<tbody>';

$end = '</tbody>
</table>';

$mpdf->WriteHTML($head);

$mpdf->WriteHTML($content);

$mpdf->WriteHTML($end);

$mpdf->Output();
