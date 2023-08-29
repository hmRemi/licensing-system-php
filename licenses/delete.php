<?php

include '../utils/tokens.php';

if (isset($_GET['pl']) && isset($_GET['key']) && isset($_GET['by'])) {
    if (isset($_COOKIE['USER_TOKEN']) && tokenExist($_COOKIE['USER_TOKEN'])) {
        include '../utils/mysql.php';

        $pl = $_GET['pl'];
        $key = $_GET['key'];
        $by = $_GET['by'];

        if (getID($_COOKIE['USER_TOKEN']) !== 'UNX80G' && $by !== getUsername(getID($_COOKIE['USER_TOKEN']))) {
            header("Location: /panel/licenses");
            exit();
        }

        $stmt = $conn->prepare("DELETE FROM licenses WHERE PLUGIN = ? AND LICENSE = ?");
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
