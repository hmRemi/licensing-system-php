<?php
if (!function_exists('generateToken')) {
    function generateToken($length = 30)
    {
        $characters = '0123456789abcdefghikjlmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('setToken')) {
    function setToken($token, $usr)
    {
        include 'mysql.php';

        $stmt  = $conn->prepare("INSERT INTO tokens (ID, TOKEN) VALUES (?, ?)");
        $stmt->bind_param("ss", $usr, $token);
        $stmt->execute();

        setcookie("USER_TOKEN", $token, strtotime('+3 year'), '/');
    }
}

if (!function_exists('removeToken')) {
    function removeToken($token)
    {
        include 'mysql.php';

        $stmt = $conn->prepare("DELETE FROM tokens WHERE `TOKEN` = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        unset($_COOKIE['USER_TOKEN']);
        setcookie('USER_TOKEN', null, time() - 3600, '/');
    }
}

if (!function_exists('getID')) {
    function getID($token)
    {
        include 'mysql.php';

        $stmt = $conn->prepare( "SELECT * FROM tokens WHERE TOKEN = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        $result = $stmt_result->fetch_assoc();

        return $result['ID'];
    }
}

if (!function_exists('getToken')) {
    function getToken($id)
    {
        include 'mysql.php';

        $stmt = $conn->prepare("SELECT * FROM tokens WHERE ID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        $result = $stmt_result->fetch_assoc();

        return $result['TOKEN'];
    }
}

if(!function_exists('getUsername')) {
    function getUsername($id) {
        include 'mysql.php';

        $stmt = $conn->prepare('SELECT * FROM users WHERE ID = ?');
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['USERNAME'];
    }
}

if (!function_exists('tokenExist')) {
    function tokenExist($token)
    {
        include 'mysql.php';

        $selectStmt = $conn->prepare("SELECT * FROM tokens WHERE TOKEN = ?");
        $selectStmt->bind_param("s", $token);
        $selectStmt->execute();
        $result = $selectStmt->get_result();

        $id = getID($token);

        $userStmt = $conn->prepare("SELECT * FROM users WHERE ID = ?");
        $userStmt->bind_param("s", $id);
        $userStmt->execute();
        $userResult = $userStmt->get_result();


        return $result->num_rows > 0 && $userResult->num_rows > 0;
    }
}
