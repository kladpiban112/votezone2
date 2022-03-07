<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

$act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$serviceid = filter_input(INPUT_POST, 'serviceid', FILTER_SANITIZE_STRING);
$personid = filter_input(INPUT_POST, 'personid', FILTER_SANITIZE_STRING);
$cid = filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_STRING);
$org_id = filter_input(INPUT_POST, 'org_id', FILTER_SANITIZE_STRING);
$prename = filter_input(INPUT_POST, 'prename', FILTER_SANITIZE_STRING);
$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);

$telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);

$servicedate = filter_input(INPUT_POST, 'servicedate', FILTER_SANITIZE_STRING);
$servicedate = date_saveto_db($servicedate);
$service = filter_input(INPUT_POST, 'service', FILTER_SANITIZE_STRING); // ประเภทการรับบริการ
$returndate = filter_input(INPUT_POST, 'returndate', FILTER_SANITIZE_STRING);
$returndate = date_saveto_db($returndate);
$returnday = filter_input(INPUT_POST, 'returnday', FILTER_SANITIZE_STRING);
$person_type = filter_input(INPUT_POST, 'person_type', FILTER_SANITIZE_STRING);
$staff_id = filter_input(INPUT_POST, 'staff_id', FILTER_SANITIZE_STRING);

$flag = '1';
$now = date('Y-m-d H:i:s');

if ($act == 'add') {

    if($person_type == '1'){
    // check for duplicate email
    $stmt = $conn->prepare('SELECT * FROM '.DB_PREFIX.'person_borrow WHERE cid = ? AND org_id = ?   ');
    $stmt->execute([$cid, $org_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //$exist_person = $stmt->fetchColumn();
    $exist_person = $stmt->rowCount();

    if ($exist_person != 0) {
        $personid = $row['oid'];

        $query = 'UPDATE '.DB_PREFIX.'person_borrow SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?,telephone = ?,person_type = ?,flag = ?,edit_date = ?,edit_users = ? WHERE oid = ? LIMIT 1';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $cid, PDO::PARAM_STR);
        $stmt->bindParam(2, $org_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $prename, PDO::PARAM_STR);
        $stmt->bindParam(4, $fname);
        $stmt->bindParam(5, $lname, PDO::PARAM_STR);
        $stmt->bindParam(6, $telephone, PDO::PARAM_STR);
        $stmt->bindParam(7, $person_type, PDO::PARAM_STR);
        $stmt->bindParam(8, $flag, PDO::PARAM_STR);
        $stmt->bindParam(9, $now, PDO::PARAM_STR);
        $stmt->bindParam(10, $logged_user_id, PDO::PARAM_STR);
        $stmt->bindParam(11, $personid, PDO::PARAM_INT);
        $stmt->execute();

        // AVATAR
        if ($_FILES['img_profile']['name']) {
            $f = $_FILES['img_profile']['name'];
            $ext = strtolower(substr(strrchr($f, '.'), 1));
            if (($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'gif') && ($ext != 'png')) {
            } else {
                $image_code = random_code();
                $image = $image_code.'-'.$_FILES['img_profile']['name'];
                $image = RewriteFile($image);
                move_uploaded_file($_FILES['img_profile']['tmp_name'], '../../uploads/temp/'.$image);

                // create avatar image
                $resizeObj = new resize('../../uploads/temp/'.$image);
                $resizeObj->resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop)
                $resizeObj->saveImage('../../uploads/person/'.$image);

                @unlink('../../uploads/temp/'.$image);
                $sql = 'UPDATE '.DB_PREFIX.'person_borrow SET img_profile = ? WHERE oid = ? LIMIT 1';
                $conn->prepare($sql)->execute([$image, $personid]);
            }
        }

        $person_oid_enc = base64_encode($personid);

        $query = 'INSERT INTO '.DB_PREFIX.'tools_borrow_main (service_id,person_id,org_id, service_date, service_type, return_date,flag,add_date,add_users,return_day,person_type) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ? ,?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $personid, PDO::PARAM_STR);
        $stmt->bindParam(2, $org_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $servicedate, PDO::PARAM_STR);
        $stmt->bindParam(4, $service, PDO::PARAM_STR);
        $stmt->bindParam(5, $returndate, PDO::PARAM_STR);
        $stmt->bindParam(6, $flag, PDO::PARAM_STR);
        $stmt->bindParam(7, $now, PDO::PARAM_STR);
        $stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
        $stmt->bindParam(9, $returnday, PDO::PARAM_STR);
        $stmt->bindParam(10, $person_type, PDO::PARAM_STR);
        $stmt->execute();

        $service_oid = $conn->lastInsertId(); // last inserted ID
        $service_oid_enc = base64_encode($service_oid);

        $act_enc = base64_encode('edit');
        $msg = 'success';
        echo json_encode(['code' => 200, 'msg' => $exist_person, 'personid' => $person_oid_enc, 'serviceid' => $service_oid_enc, 'act' => $act_enc]);
    } else {
        $query = 'INSERT INTO '.DB_PREFIX.'person_borrow (oid, cid, org_id, prename, fname, lname, telephone, person_type ,flag,add_date,add_users) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ? ,? ,?)';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $cid, PDO::PARAM_STR);
        $stmt->bindParam(2, $org_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $prename, PDO::PARAM_STR);
        $stmt->bindParam(4, $fname);
        $stmt->bindParam(5, $lname, PDO::PARAM_STR);
        $stmt->bindParam(6, $telephone, PDO::PARAM_STR);
        $stmt->bindParam(7, $person_type, PDO::PARAM_STR);
        $stmt->bindParam(8, $flag, PDO::PARAM_STR);
        $stmt->bindParam(9, $now, PDO::PARAM_STR);
        $stmt->bindParam(10, $logged_user_id, PDO::PARAM_STR);
        $stmt->execute();

        $person_oid = $conn->lastInsertId(); // last inserted ID
        $person_oid_enc = base64_encode($person_oid);

        $query = 'INSERT INTO '.DB_PREFIX.'tools_borrow_main (service_id,person_id,org_id, service_date, service_type, return_date,flag,add_date,add_users,return_day,person_type) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ? ,?,? )';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $person_oid, PDO::PARAM_STR);
        $stmt->bindParam(2, $org_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $servicedate, PDO::PARAM_STR);
        $stmt->bindParam(4, $service, PDO::PARAM_STR);
        $stmt->bindParam(5, $returndate, PDO::PARAM_STR);
        $stmt->bindParam(6, $flag, PDO::PARAM_STR);
        $stmt->bindParam(7, $now, PDO::PARAM_STR);
        $stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
        $stmt->bindParam(9, $returnday, PDO::PARAM_STR);
        $stmt->bindParam(10, $person_type, PDO::PARAM_STR);
        $stmt->execute();

        $service_oid = $conn->lastInsertId(); // last inserted ID
        $service_oid_enc = base64_encode($service_oid);

        // AVATAR
        if ($_FILES['img_profile']['name']) {
            $f = $_FILES['img_profile']['name'];
            $ext = strtolower(substr(strrchr($f, '.'), 1));
            if (($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'gif') && ($ext != 'png')) {
            } else {
                $image_code = random_code();
                $image = $image_code.'-'.$_FILES['img_profile']['name'];
                $image = RewriteFile($image);
                move_uploaded_file($_FILES['img_profile']['tmp_name'], '../../uploads/temp/'.$image);

                // create avatar image
                $resizeObj = new resize('../../uploads/temp/'.$image);
                $resizeObj->resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop)
                $resizeObj->saveImage('../../uploads/person/'.$image);

                @unlink('../../uploads/temp/'.$image);
                $sql = 'UPDATE '.DB_PREFIX.'person_borrow SET img_profile = ? WHERE oid = ? LIMIT 1';
                $conn->prepare($sql)->execute([$image, $person_oid]);
            }
        }

        $act_enc = base64_encode('edit');
        $msg = 'success';
        echo json_encode(['code' => 200, 'msg' => $exist_person, 'personid' => $person_oid_enc, 'serviceid' => $service_oid_enc, 'act' => $act_enc]);
    }

    }else if($person_type == '2'){

        $query = 'INSERT INTO '.DB_PREFIX.'tools_borrow_main (service_id,staff_id,org_id, service_date, service_type, return_date,flag,add_date,add_users,return_day,person_type) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ? ,?,? )';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $staff_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $org_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $servicedate, PDO::PARAM_STR);
        $stmt->bindParam(4, $service, PDO::PARAM_STR);
        $stmt->bindParam(5, $returndate, PDO::PARAM_STR);
        $stmt->bindParam(6, $flag, PDO::PARAM_STR);
        $stmt->bindParam(7, $now, PDO::PARAM_STR);
        $stmt->bindParam(8, $logged_user_id, PDO::PARAM_STR);
        $stmt->bindParam(9, $returnday, PDO::PARAM_STR);
        $stmt->bindParam(10, $person_type, PDO::PARAM_STR);
        $stmt->execute();

        $service_oid = $conn->lastInsertId(); // last inserted ID
        $service_oid_enc = base64_encode($service_oid);

        $staff_id_enc = base64_encode($staff_id);



        $act_enc = base64_encode('edit');
        $msg = 'success';
        echo json_encode(['code' => 200, 'msg' => $exist_person, 'personid' => $person_oid_enc, 'serviceid' => $service_oid_enc, 'act' => $act_enc, 'staffid' => $staff_id_enc]);


    }

    
} elseif ($act == 'edit') {
    $query = 'UPDATE '.DB_PREFIX.'person_borrow SET cid = ?, org_id = ?, prename = ?, fname = ?, lname = ?, telephone = ?,person_type = ?,flag = ?,edit_date = ?,edit_users = ? WHERE oid = ? LIMIT 1';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $cid, PDO::PARAM_STR);
    $stmt->bindParam(2, $org_id, PDO::PARAM_STR);
    $stmt->bindParam(3, $prename, PDO::PARAM_STR);
    $stmt->bindParam(4, $fname);
    $stmt->bindParam(5, $lname, PDO::PARAM_STR);
    $stmt->bindParam(6, $telephone, PDO::PARAM_STR);
    $stmt->bindParam(7, $person_type, PDO::PARAM_STR);
    $stmt->bindParam(8, $flag, PDO::PARAM_STR);
    $stmt->bindParam(9, $now, PDO::PARAM_STR);
    $stmt->bindParam(10, $logged_user_id, PDO::PARAM_STR);
    $stmt->bindParam(11, $personid, PDO::PARAM_INT);
    $stmt->execute();

    $query = 'UPDATE '.DB_PREFIX.'tools_borrow_main SET org_id = ?, service_date = ?, service_type = ?, return_date = ?,flag = ?,edit_date = ?,edit_users = ? , return_day = ? WHERE service_id = ? LIMIT 1';
    $stmt = $conn->prepare($query);

    $stmt->bindParam(1, $org_id, PDO::PARAM_STR);
    $stmt->bindParam(2, $servicedate, PDO::PARAM_STR);
    $stmt->bindParam(3, $service, PDO::PARAM_STR);
    $stmt->bindParam(4, $returndate, PDO::PARAM_STR);
    $stmt->bindParam(5, $flag, PDO::PARAM_STR);
    $stmt->bindParam(6, $now, PDO::PARAM_STR);
    $stmt->bindParam(7, $logged_user_id, PDO::PARAM_STR);
    $stmt->bindParam(8, $returnday, PDO::PARAM_STR);
    $stmt->bindParam(9, $serviceid, PDO::PARAM_INT);
    $stmt->execute();

    // AVATAR
    if ($_FILES['img_profile']['name']) {
        $f = $_FILES['img_profile']['name'];
        $ext = strtolower(substr(strrchr($f, '.'), 1));
        if (($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'gif') && ($ext != 'png')) {
        } else {
            $image_code = random_code();
            $image = $image_code.'-'.$_FILES['img_profile']['name'];
            $image = RewriteFile($image);
            move_uploaded_file($_FILES['img_profile']['tmp_name'], '../../uploads/temp/'.$image);

            // create avatar image
            $resizeObj = new resize('../../uploads/temp/'.$image);
            $resizeObj->resizeImage(200, 200, 'crop'); // (options: exact, portrait, landscape, auto, crop)
            $resizeObj->saveImage('../../uploads/person/'.$image);

            @unlink('../../uploads/temp/'.$image);
            $sql = 'UPDATE '.DB_PREFIX.'person_borrow SET img_profile = ? WHERE oid = ? LIMIT 1';
            $conn->prepare($sql)->execute([$image, $personid]);
        }
    }

    $person_oid_enc = base64_encode($personid);
    $service_oid_enc = base64_encode($serviceid);

    $act_enc = base64_encode('edit');
    $msg = 'success';
    echo json_encode(['code' => 200, 'msg' => $exist_person, 'personid' => $person_oid_enc, 'serviceid' => $service_oid_enc, 'act' => $act_enc]);
}