<?php

$eqid = filter_input(INPUT_GET, 'eqid', FILTER_SANITIZE_STRING);
$eqid = base64_decode($eqid);
echo $eqid;
?>