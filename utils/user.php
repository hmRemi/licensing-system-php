<?php

if (isset($_COOKIE['USER_TOKEN'])) {
    include 'mysql.php';
    include 'tokens.php';

    if (tokenExist($_COOKIE['USER_TOKEN'])) {

        $id = getID($_COOKIE['USER_TOKEN']);

        $stmt = $conn->prepare("SELECT * FROM users WHERE ID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $resultRow = $result->fetch_assoc();

        $currentPasswordHashed = $resultRow['PASSWORD'];

        $username = $resultRow['USERNAME'];
    } else {
        header("Location: /panel/logout");
        exit();
    }
} else {
    header("Location: /panel/");
    exit();
}
