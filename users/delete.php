<?php

include '../utils/tokens.php';

if (isset($_GET['usr']) && isset($_GET['id'])) {
    if (isset($_COOKIE['USER_TOKEN']) && tokenExist($_COOKIE['USER_TOKEN'])) {
        include '../utils/mysql.php';

        $username = $_GET['usr'];
        $id = $_GET['id'];

        if ($id === 'UNX80G') {
            header("Location: /panel/users");
            exit();
        }

        $stmt = $conn->prepare("DELETE FROM users WHERE USERNAME = ? AND ID = ?");
        $stmt->bind_param("ss", $username, $id);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM licenses WHERE `CREATED-BY` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        header("Location: /panel/users");
        exit();
    } else {
        header("Location: /panel/logout");
        exit();
    }
} else {
    header("Location: /panel/");
    exit();
}
