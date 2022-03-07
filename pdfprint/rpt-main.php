<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// add Lib mPDF to projectr
require_once '../config.php';
//require_once ABSPATH."/core/checklogin.php";
require_once '../vendor/autoload.php';
require_once '../core/functions.php';

ob_start();
$datenow = date('Y-m-d');
$dtnow = date('Y-m-d H:i:s');

$refno = filter_input(INPUT_GET, 'refno', FILTER_SANITIZE_STRING);
echo $sql = "SELECT s.id as refno,s.*, u.name as processby,cprename.detail,cnation.nationname ,coccupation.occupationname
,cprovince.province_name,campur.ampurname,ctambon.tambonname,cn.country_name_th
FROM novelcorona2 s 
    left join cprename on s.prename = cprename.id_prename 
    LEFT JOIN users u on s.addby = u.user_id 
    left join cnation on s.nation = cnation.nationcode
    left join ccountry cn on s.from_country = cn.id
    left join coccupation on s.occupation = coccupation.occupationcode 
    left join cprovince on s.addr_province = cprovince.province_code
    left join campur on s.addr_ampur = campur.ampurcodefull
    left join ctambon on s.addr_tambon = ctambon.tamboncodefull 
  
    WHERE s.flag_status = '1' and s.id = $refno 
    ORDER BY s.id desc";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rs = $stmt->fetch(PDO::FETCH_OBJ);

// $txt_rep_name = "";
// if($rs->payment_type == "HS"){ //ใบเสร็จ
//     $txt_rep_name = "ใบเสร็จรับเงิน";
// }elseif($rs->payment_type == "AI") { //มัดจำ
//     $txt_rep_name = "ใบรับเงินมัดจำ";
// }elseif($rs->payment_type == "OI") { //ประกัน
//     $txt_rep_name = "บิลเงินสด";
// }elseif($rs->payment_type == "SR") { //คืนเงิน
//     $txt_rep_name = "ใบสำคัญคืนเงิน";
// }

?>

<?php

//$tamount = number_format($rs->amount,2);
//$bt_amount = bahtText($rs->amount);
$html = "<div style='color:red;position:absolute;top:20px;left:650px;width:100px;font-size:16px'>PUI NO #$rs->no </div>
<div style='color:red;position:absolute;top:58px;left:85px;'> $rs->code </div>
<div style='color:red;position:absolute;top:92px;left:560px;'>$rs->cid</div> 

<div style='color:red;position:absolute;top:116px;left:150px;'>$rs->detail$rs->name $rs->lname</div>
<div style='color:red;position:absolute;top:116px;left:415px;'>".($rs->sex == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:116px;left:465px;'>".($rs->sex == '2' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:116px;left:543px;width:20px;'>$rs->age_y</div>
<div style='color:red;position:absolute;top:116px;left:583px;width:20px;'>$rs->age_m</div>
<div style='color:red;position:absolute;top:116px;left:685px;width:30px;width:40px'>$rs->nationname</div>

<div style='color:red;position:absolute;top:135px;left:565px;'>".($rs->occupation == '0' ? 'ไม่ระบุ' : $rs->occupationname)."</div>

<div style='color:red;position:absolute;top:156px;left:200px;width:200px;'>$rs->workplace</div>
<div style='color:red;position:absolute;top:156px;left:560px;'>$rs->telephone</div>

<div style='color:red;position:absolute;top:180px;left:215px;'>".($rs->disease_at_home == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:180px;left:265px;'>".($rs->disease_at_oth == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:180px;left:340px;'>".($rs->disease_at_oth_detail != '' ? $rs->disease_at_oth_detail : '')."</div>
<div style='color:red;position:absolute;top:180px;left:470px;width:40px;'>$rs->addr_no</div>
<div style='color:red;position:absolute;top:180px;left:540px;width:100px;'>$rs->addr_moo</div>
<div style='color:red;position:absolute;top:180px;left:640px;'>$rs->addr_moo_name</div>

<div style='color:red;position:absolute;top:200px;left:90px;width:50px;'>$rs->addr_soi</div>
<div style='color:red;position:absolute;top:200px;left:200px;'>$rs->addr_road</div>
<div style='color:red;position:absolute;top:200px;left:340px;'>$rs->tambonname</div>
<div style='color:red;position:absolute;top:200px;left:480px;'>$rs->ampurname</div>
<div style='color:red;position:absolute;top:200px;left:640px;width:50px;'>$rs->province_name</div>

<div style='color:red;position:absolute;top:220px;left:150px;'>$rs->private_disease</div>


<div style='color:red;position:absolute;top:282px;left:130px;'>".($rs->date_b_sick != '' ? date_sub_thai($rs->date_b_sick) : '')."</div>
<div style='color:red;position:absolute;top:282px;left:355px;'>".($rs->date_first_heal_sick != '' ? date_sub_thai($rs->date_first_heal_sick) : '')."</div>
<div style='color:red;position:absolute;top:282px;left:520px;'>".getHospname($rs->hospital_first)."</div>
<div style='color:red;position:absolute;top:282px;left:675px;width:50px;'>".getProvname($rs->hospital_first)."</div>

<div style='color:red;position:absolute;top:305px;left:270px;'>".getHospname($rs->hospital_current)."</div>
<div style='color:red;position:absolute;top:305px;left:415px;'>".getProvname($rs->hospital_current)."</div>

<div style='color:red;position:absolute;top:325px;left:255px;'>".($rs->is_flu == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:325px;left:378px;'>$rs->temp_first</div>
<div style='color:red;position:absolute;top:325px;left:560px;'>$rs->o2sat</div>

<div style='color:red;position:absolute;top:348px;left:79px;'>".($rs->is_i == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:348px;left:161px;'>".($rs->is_throat == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:348px;left:245px;'>".($rs->is_muscle_pain == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:348px;left:378px;'>".($rs->is_snot == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:348px;left:472px;'>".($rs->is_phlegm == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:348px;left:570px;'>".($rs->is_dyspnea == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:368px;left:79px;'>".($rs->is_headache == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:368px;left:161px;'>".($rs->is_drain_liquid == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:368px;left:245px;'>".($rs->is_symptom_oth == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:368px;left:325px;'>".($rs->symptom_oth_detail == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:368px;left:570px;'>".($rs->is_respirator == '1' ? 'X' : '')."</div>


<div style='color:red;position:absolute;top:389px;left:185px;'>".($rs->is_first_xray == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:389px;left:281px;'>".($rs->is_first_xray == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:389px;left:365px;'>".date_sub_thai($rs->date_first_xray)."</div>
<div style='color:red;position:absolute;top:389px;left:530px;'>$rs->xray_first_why</div>

<div style='color:red;position:absolute;top:411px;left:173px;'>".date_sub_thai($rs->date_first_cbc)."</div>
<div style='color:red;position:absolute;top:411px;left:345px;'>$rs->hb</div>
<div style='color:red;position:absolute;top:411px;left:465px;'>$rs->hct</div>
<div style='color:red;position:absolute;top:411px;left:630px;'>$rs->platelet_count</div>

<div style='color:red;position:absolute;top:431px;left:87px;width:50px;'>$rs->wbc</div>
<div style='color:red;position:absolute;top:431px;left:224px;'>$rs->n</div>
<div style='color:red;position:absolute;top:431px;left:294px;'>$rs->l</div>
<div style='color:red;position:absolute;top:431px;left:418px;'>$rs->atyp</div>
<div style='color:red;position:absolute;top:431px;left:513px;'>$rs->mono</div>
<div style='color:red;position:absolute;top:431px;left:605px;width:50px;'>$rs->rlab_oth</div>

<div style='color:red;position:absolute;top:453px;left:260px;width:100px;'>$rs->method_test_influ</div>
<div style='color:red;position:absolute;top:453px;left:470px;'>".($rs->method_test_influ != '' && $rs->influ_test_result == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:453px;left:548px;'>".($rs->method_test_influ != '' && $rs->influ_test_result == '2' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:453px;left:623px;'>".($rs->method_test_influ != '' && $rs->influ_test_seed == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:453px;left:685px;'>".($rs->method_test_influ != '' && $rs->influ_test_seed == '2' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:523px;left:87px;'>1</div>
<div style='color:red;position:absolute;top:523px;left:140px;'>".date_sub_thai($rs->test_sarscov2_1_date)."</div>
<div style='color:red;position:absolute;top:523px;left:252px;width:100px;'>$rs->test_sarscov2_1_type_sample</div>
<div style='color:red;position:absolute;top:523px;left:380px;width:170px;'>".getLocationname($rs->test_sarscov2_1_lab)."</div>
<div style='color:red;position:absolute;top:523px;left:560px;'>".($rs->test_sarscov2_1_result == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:523px;left:643px;'>".($rs->test_sarscov2_1_result == '2' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:544px;left:87px;'>2</div>
<div style='color:red;position:absolute;top:544px;left:140px;'>".date_sub_thai($rs->test_sarscov2_2_date)."</div>
<div style='color:red;position:absolute;top:544px;left:252px;width:100px;'>$rs->test_sarscov2_2_type_sample</div>
<div style='color:red;position:absolute;top:544px;left:380px;width:170px;'>".getLocationname($rs->test_sarscov2_2_lab)."</div>
<div style='color:red;position:absolute;top:544px;left:560px;'>".($rs->test_sarscov2_2_result == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:544px;left:643px;'>".($rs->test_sarscov2_2_result == '2' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:576px;left:136px;'>".($rs->patient_type == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:576px;left:213px;'>".($rs->patient_type == '2' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:576px;left:345px;'>".date_sub_thai($rs->date_admit)."</div>
<div style='color:red;position:absolute;top:576px;left:562px;width:150px;'>$rs->doctor_diag</div>

<div style='color:red;position:absolute;top:596px;left:285px;'>".($rs->is_cov_medicine == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:596px;left:339px;'>".($rs->is_cov_medicine == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:596px;left:475px;'>".date_sub_thai($rs->date_first_cov_medicine)."</div>

<div style='color:red;position:absolute;top:616px;left:61px;'>".($rs->is_medicine_drv == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:616px;left:282px;'>".($rs->is_medicine_lpv == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:616px;left:521px;'>".($rs->is_medicine_favipiravir == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:638px;left:61px;'>".($rs->is_medicine_chloroquine == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:638px;left:282px;'>".($rs->is_medicine_hydroxychloroquine == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:638px;left:521px;'>".($rs->is_medicine_oth == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:638px;left:605px;'>".($rs->is_medicine_oth == '1' ? $rs->medicine_oth_detail : '')."</div>

<div style='color:red;position:absolute;top:658px;left:138px;'>".($rs->status_patient == '1' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:658px;left:186px;'>".($rs->status_patient == '2' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:658px;left:280px;'>".($rs->status_patient == '3' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:658px;left:378px;'>".($rs->status_patient == '4' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:658px;left:458px;'>".($rs->status_patient == '4' ? $rs->hospital_2refer : '')."</div>
<div style='color:red;position:absolute;top:658px;left:570px;'>".($rs->status_patient == '5' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:658px;left:641px;'>".($rs->status_patient == '5' ? $rs->status_patient_oth_detail : '')."</div>


<div style='color:red;position:absolute;top:725px;left:468px;'>$rs->from_city</div>
<div style='color:red;position:absolute;top:725px;left:597px;width:100px;'>$rs->country_name_th</div>
<div style='color:red;position:absolute;top:725px;left:668px;'>".($rs->is_c14day_from_area_danger == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:725px;left:716px;'>".($rs->is_c14day_from_area_danger == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:745px;left:228px;'>".date_sub_thai($rs->date_back2home)."</div>
<div style='color:red;position:absolute;top:745px;left:417px;'>$rs->by_airline</div>
<div style='color:red;position:absolute;top:745px;left:570px;'>$rs->by_airline_no</div>
<div style='color:red;position:absolute;top:745px;left:690px;width:100px;'>$rs->by_airline_seat_no</div>

<div style='color:red;position:absolute;top:768px;left:668px;'>".($rs->is_c14day_treat_area_danger == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:768px;left:716px;'>".($rs->is_c14day_treat_area_danger == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:792px;left:668px;'>".($rs->is_c14day_contact_person_flu == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:792px;left:716px;'>".($rs->is_c14day_contact_person_flu == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:815px;left:505px;width:100px;'>".($rs->is_c14day_contact_confirmcase == '1' ? $rs->c14day_contact_confirmcase_detail : '')." </div>
<div style='color:red;position:absolute;top:815px;left:668px;'>".($rs->is_c14day_contact_confirmcase == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:815px;left:716px;'>".($rs->is_c14day_contact_confirmcase == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:840px;left:668px;'>".($rs->is_c14day_contact_traveler == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:840px;left:716px;'>".($rs->is_c14day_contact_traveler == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:863px;left:518px;width:150px;'>".($rs->is_c14day_contact_place_lotpeople == '1' ? $rs->c14day_contact_place_lotpeople_detail : '')." </div>
<div style='color:red;position:absolute;top:863px;left:668px;'>".($rs->is_c14day_contact_place_lotpeople == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:863px;left:716px;'>".($rs->is_c14day_contact_place_lotpeople == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:887px;left:668px;'>".($rs->is_lung_patient == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:887px;left:716px;'>".($rs->is_lung_patient == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:910px;left:668px;'>".($rs->is_lung_patient_noroot == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:910px;left:716px;'>".($rs->is_lung_patient_noroot == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:933px;left:668px;'>".($rs->is_publichealth_person == '0' ? 'X' : '')."</div>
<div style='color:red;position:absolute;top:933px;left:716px;'>".($rs->is_publichealth_person == '1' ? 'X' : '')."</div>

<div style='color:red;position:absolute;top:956px;left:145px;'>$rs->part3_oth_detail</div>

<div style='color:red;position:absolute;top:998px;left:75px;'>$rs->risk_cov_detail</div>

<pagebreak>

<div style='color:red;position:absolute;top:98px;left:125px;'>".date_sub_thai($rs->date_investigate_1)."</div>
<div style='color:red;position:absolute;top:98px;left:225px;width:250px;'>$rs->activity_localtion_detail_1</div>
<div style='color:red;position:absolute;top:98px;left:495px;width:100px;'>$rs->activity_participant_1</div>

<div style='color:red;position:absolute;top:120px;left:125px;'>".date_sub_thai($rs->date_investigate_2)."</div>
<div style='color:red;position:absolute;top:120px;left:225px;width:250px;'>$rs->activity_localtion_detail_2</div>
<div style='color:red;position:absolute;top:120px;left:495px;width:100px;'>$rs->activity_participant_2</div>

<div style='color:red;position:absolute;top:142px;left:125px;'>".date_sub_thai($rs->date_investigate_3)."</div>
<div style='color:red;position:absolute;top:142px;left:225px;width:250px;'>$rs->activity_localtion_detail_3</div>
<div style='color:red;position:absolute;top:142px;left:495px;width:100px;'>$rs->activity_participant_3</div>

<div style='color:red;position:absolute;top:164px;left:125px;'>".date_sub_thai($rs->date_investigate_4)."</div>
<div style='color:red;position:absolute;top:164px;left:225px;width:250px;'>$rs->activity_localtion_detail_4</div>
<div style='color:red;position:absolute;top:164px;left:495px;width:100px;'>$rs->activity_participant_4</div>

<div style='color:red;position:absolute;top:186px;left:125px;'>".date_sub_thai($rs->date_investigate_5)."</div>
<div style='color:red;position:absolute;top:186px;left:225px;width:250px;'>$rs->activity_localtion_detail_5</div>
<div style='color:red;position:absolute;top:186px;left:495px;width:100px;'>$rs->activity_participant_5</div>

<div style='color:red;position:absolute;top:208px;left:125px;'>".date_sub_thai($rs->date_investigate_6)."</div>
<div style='color:red;position:absolute;top:208px;left:225px;width:250px;'>$rs->activity_localtion_detail_6</div>
<div style='color:red;position:absolute;top:208px;left:495px;width:100px;'>$rs->activity_participant_6</div>

<div style='color:red;position:absolute;top:230px;left:125px;'>".date_sub_thai($rs->date_investigate_7)."</div>
<div style='color:red;position:absolute;top:230px;left:225px;width:250px;'>$rs->activity_localtion_detail_7</div>
<div style='color:red;position:absolute;top:230px;left:495px;width:100px;'>$rs->activity_participant_7</div>

<div style='color:red;position:absolute;top:252px;left:125px;'>".date_sub_thai($rs->date_investigate_8)."</div>
<div style='color:red;position:absolute;top:252px;left:225px;width:250px;'>$rs->activity_localtion_detail_8</div>
<div style='color:red;position:absolute;top:252px;left:495px;width:100px;'>$rs->activity_participant_8</div>

<div style='color:red;position:absolute;top:273px;left:125px;'>".date_sub_thai($rs->date_investigate_9)."</div>
<div style='color:red;position:absolute;top:273px;left:225px;width:250px;'>$rs->activity_localtion_detail_9</div>
<div style='color:red;position:absolute;top:273px;left:495px;width:100px;'>$rs->activity_participant_9</div>

<div style='color:red;position:absolute;top:295px;left:125px;'>".date_sub_thai($rs->date_investigate_10)."</div>
<div style='color:red;position:absolute;top:295px;left:225px;width:250px;'>$rs->activity_localtion_detail_10</div>
<div style='color:red;position:absolute;top:295px;left:495px;width:100px;'>$rs->activity_participant_10</div>

<div style='color:red;position:absolute;top:317px;left:125px;'>".date_sub_thai($rs->date_investigate_11)."</div>
<div style='color:red;position:absolute;top:317px;left:225px;width:250px;'>$rs->activity_localtion_detail_11</div>
<div style='color:red;position:absolute;top:317px;left:495px;width:100px;'>$rs->activity_participant_11</div>

<div style='color:red;position:absolute;top:339px;left:125px;'>".date_sub_thai($rs->date_investigate_12)."</div>
<div style='color:red;position:absolute;top:339px;left:225px;width:250px;'>$rs->activity_localtion_detail_12</div>
<div style='color:red;position:absolute;top:339px;left:495px;width:100px;'>$rs->activity_participant_12</div>

<div style='color:red;position:absolute;top:360px;left:125px;'>".date_sub_thai($rs->date_investigate_13)."</div>
<div style='color:red;position:absolute;top:360px;left:225px;width:250px;'>$rs->activity_localtion_detail_13</div>
<div style='color:red;position:absolute;top:360px;left:495px;width:100px;'>$rs->activity_participant_13</div>

<div style='color:red;position:absolute;top:381px;left:125px;'>".date_sub_thai($rs->date_investigate_14)."</div>
<div style='color:red;position:absolute;top:381px;left:225px;width:250px;'>$rs->activity_localtion_detail_14</div>
<div style='color:red;position:absolute;top:381px;left:495px;width:100px;'>$rs->activity_participant_14</div>

<div style='color:red;position:absolute;top:419px;left:115px;'>$rs->reporter</div>
<div style='color:red;position:absolute;top:419px;left:345px;'>".getHospname($rs->reporter_from)."</div>
<div style='color:red;position:absolute;top:419px;left:600px;width:100px;'>$rs->reporter_telephone</div>

<div style='color:red;position:absolute;top:441px;left:130px;width:100px;'>".($rs->date_report != '' ? date_sub_thai($rs->date_report) : '').'</div>
';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__.'/ttfonts',
    ]),
    'fontdata' => $fontData + [
        'garuda' => [
            'R' => 'garuda.ttf',
            //'I' => 'THSarabunNew Italic.ttf',
            //'B' => 'THSarabunNew Bold.ttf',
        ],
    ],
    'default_font_size' => 9,
    'default_font' => 'garuda', //browallia
    'mode' => 'utf-8',
    'format' => ['210', '297'],
    'margin_left' => 0,     // 15 margin_left
 'margin_right' => 0,     // 15 margin right
 // 'mgt' => $headerTopMargin,     // 16 margin top
    // 'mgb' => $footerTopMargin,     // margin bottom
    'margin_top' => 0,
    'margin_bottom' => 0,
 'margin_header' => 0,     // 9 margin header
 'margin_footer' => 0,     // 9 margin footer
 'orientation' => 'P',   // L - landscape, P - portrait
    'tempDir' => __DIR__.'/tmp',
]);

//$mpdf->SetImportUse();
$mpdf->SetDocTemplate('rpt-main.pdf', true);

$mpdf->AddPage();
$mpdf->WriteHTML($html);

$mpdf->Output();

?>