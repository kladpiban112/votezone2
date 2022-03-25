<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../core/config.php';
require_once ABSPATH.'/checklogin.php';
require_once ABSPATH.'/functions.php';

            $act = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $flag = '0';

            $query = 'UPDATE '.DB_PREFIX.'repair_jobout SET flag = ? WHERE oid = ? LIMIT 1';
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $flag, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_STR);
            $stmt->execute();


            $act_enc = base64_encode('edit');
            $msg = 'success';
            echo json_encode(['code' => 200, 'msg' => $msg, 'oid' => $id]);