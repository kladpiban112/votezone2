<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// add Lib mPDF to projectr
require_once "../config.php";
require_once "../vendor/autoload.php";

ob_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="print-style.css">



 
    <title>printout</title>

</head>
<body>

                                           
                                                <h3><i class="fa fa-table"></i> Invoice example</h3>
                                                <!-- Favicon -->

                                          

                                                

                                                    
                      
                                                    



                                                                        <table class="table table-condensed">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td><strong>Item</strong></td>
                                                                                    <td class="text-center"><strong>Price</strong></td>
                                                                                    <td class="text-center"><strong>Quantity</strong></td>
                                                                                    <td class="text-right"><strong>Totals</strong></td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                                                <tr>
                                                                                    <td>BS-200</td>
                                                                                    <td class="text-center">$10.99</td>
                                                                                    <td class="text-center">1</td>
                                                                                    <td class="text-right">$10.99</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>BS-400</td>
                                                                                    <td class="text-center">$20.00</td>
                                                                                    <td class="text-center">3</td>
                                                                                    <td class="text-right">$60.00</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>BS-1000</td>
                                                                                    <td class="text-center">$600.00</td>
                                                                                    <td class="text-center">1</td>
                                                                                    <td class="text-right">$600.00</td>
                                                                                </tr>
                                                                    
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
    'tempDir' => __DIR__ . '/tmp'
]);
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output();

?>



