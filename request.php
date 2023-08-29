<?php

if (!function_exists('getUserIP')) {
    function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }
}

?>

<?php

if (isset($_SERVER['HTTP_LICENSE_KEY'])) {
    if (isset($_SERVER['HTTP_PLUGIN_NAME'])) {
        if (isset($_SERVER['HTTP_REQUEST_KEY'])) {
            include 'config.php';

            if ($_SERVER['HTTP_REQUEST_KEY'] == REQUEST_KEY) {
                include 'utils/mysql.php';
                include 'utils/licenses.php';

                $license = $_SERVER['HTTP_LICENSE_KEY'];
                $plugin = $_SERVER['HTTP_PLUGIN_NAME'];

                if (licenseExists($plugin, $license)) {
                    $ip = getUserIP();
                    $time = time();
                    $currentDate = date("d F", $time);
                    $row = getLicenseInfo($plugin, $license)->fetch_assoc();
                    $maxIps = $row['MAX-IPS'];

                    if ($maxIps !== 0) {
                        $validIps = getLastIP($license);

                        if (!in_array('Not found', $validIps) && getIPsLeft($license, $maxIps) <= 0 && !in_array($ip, $validIps)) {
                            die("TOO_MANY_IPS;");
                        }

                        $licenseCreatedOn = date("d/m/Y h:i:s A", $row['CREATED-IN']);

                        echo "VALID;" . $row['DISCORD'] . ";" . $row['CREATED-BY'] . ";" . $licenseCreatedOn;

                        $stmt = $conn->prepare("INSERT INTO requests (LICENSE, PLUGIN, IP, DATE, TIMESTAMP) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssss", $license, $plugin, $ip, $currentDate, $time);
                        $stmt->execute();
                    } else {
                        $licenseCreatedOn = date("d/m/Y h:i:s A", $row['CREATED-IN']);

                        echo "VALID;" . $row['DISCORD'] . ";" . $row['CREATED-BY'] . ";" . $licenseCreatedOn;

                        $stmt = $conn->prepare("INSERT INTO requests (LICENSE, PLUGIN, IP, DATE, TIMESTAMP) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssss", $license, $plugin, $ip, $currentDate, $time);
                        $stmt->execute();
                    }
                } else {
                    die("INVALID_LICENSE;");
                }
            } else {
                die("INVALID_REQUEST_KEY;");
            }
        } else {
            die("REQUEST_KEY_NOT_FOUND;");
        }
    } else {
        die("PLUGIN_NAME_NOT_FOUND;");
    }
} else {
    die("LICENSE_NOT_FOUND;");
}
