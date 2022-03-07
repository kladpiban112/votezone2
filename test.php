<?php
require_once "core/config.php";
$stmt = $conn->query("SELECT * FROM users");
while ($row = $stmt->fetch()) {
    echo $row['email']."<br />\n";
}

?>