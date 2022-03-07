<?php

    //เรียกใช้ไฟล์ autoload.php ที่อยู่ใน Folder vendor
    require_once __DIR__.'../vendor/autoload.php';
    //ตั้งค่าการเชื่อมต่อฐานข้อมูล

    /*
    $servername = 'localhost';
    $username = 'root';
    $password = '1234';
    $dbname = 'webapp';
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, 'utf8');
    if (!$conn) {
        die('Connection failed: '.mysqli_connect_error());
    }
    $sql = 'SELECT * FROM tbtest';
    $result = mysqli_query($conn, $sql);
    $content = '';
    if (mysqli_num_rows($result) > 0) {
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $content .= '
            <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >'.$i.'</td>
                <td style="border-right:1px solid #000;padding:3px;"  >'.$row['name'].'</td>
            </tr>';
            ++$i;
        }
    }
    mysqli_close($conn);
*/
    $mpdf = new mPDF();
    $head = '
    <style>
        body{
            font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
        }
    </style>
    <h2 style="text-align:center">ทดสอบดึงข้อมูลจาก Mysql</h2>
    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12pt;margin-top:8px;">
    <thead>
        <tr style="border:1px solid #000;padding:4px;">
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;"   width="10%">ลำดับ</td>
            <td  width="45%" style="border-right:1px solid #000;padding:4px;text-align:center;">&nbsp;รายละเอียดสินค้า</td>
        </tr>
    </thead>
    <tbody>';
    $end = '</tbody></table>';
    $mpdf->WriteHTML($head);
    //$mpdf->WriteHTML($content);
    $mpdf->WriteHTML($end);
    $mpdf->Output();
