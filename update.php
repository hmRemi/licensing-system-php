<?php

include 'utils/mysql.php';

$licensesStmt = $conn->prepare("ALTER TABLE `licenses` ADD `MAX-IPS` INT(11) NOT NULL DEFAULT '0' AFTER `CREATED-IN`;");
$licensesStmt->execute();


die("Successfully updated the tables, now you can delete this file.");
