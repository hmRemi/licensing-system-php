<?php

include '../utils/tokens.php';

if (isset($_GET['pl']) && isset($_GET['key'])) {
    if (isset($_COOKIE['USER_TOKEN']) && tokenExist($_COOKIE['USER_TOKEN'])) {
        include '../utils/mysql.php';

        $pl = $_GET['pl'];
        $key = $_GET['key'];

        $stmt = $conn->prepare("DELETE FROM requests WHERE PLUGIN = ? AND LICENSE = ?");
        $stmt->bind_param("ss", $pl, $key);
        $stmt->execute();

        header("Location: /panel/licenses");
        exit();
    } else {
        header("Location: /panel/logout");
        exit();
    }
} else {
    header("Location: /panel/");
    exit();
}