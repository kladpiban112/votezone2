<?php

 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

// add Lib mPDF to projectr
require_once '../vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
]);

$stylesheet = file_get_contents('print-style.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->WriteHTML('<h1>สวัสดีครับ!</h1>');
$mpdf->Output();
