<?php

if (!function_exists('getLastIP')) {
    function getLastIP($license)
    {
        include 'mysql.php';

        $statement = $conn->prepare("SELECT IP FROM requests WHERE LICENSE = ? ORDER BY TIMESTAMP DESC");
        $statement->bind_param("s", $license);
        $statement->execute();
        $stmt_result = $statement->get_result();

        if ($stmt_result->num_rows > 0) {
            $previousValue = "";
            $return = array();

            while ($row = $stmt_result->fetch_assoc()) {
                if ($previousValue != $row['IP']) {
                    array_push($return, $row['IP']);
                    $previousValue = $row['IP'];
                }
            }
            return $return;
        } else {
            return array('Not found');
        }
    }
}

if (!function_exists('getIPsLeft')) {
    function getIPsLeft($license, $max)
    {
        if ($max === '0') {
            return "Unlimited";
        } else if (in_array('Not found', getLastIP($license))) {
            return $max;
        } else {
            return ($max - count(getLastIP($license)) < 0 ? 0 : $max - count(getLastIP($license)));
        }
    }
}

if (!function_exists('getLastRequest')) {
    function getLastRequest($license)
    {
        include 'mysql.php';

        $statement = $conn->prepare("SELECT * FROM requests WHERE LICENSE = ? ORDER BY TIMESTAMP DESC LIMIT 1");
        $statement->bind_param("s", $license);
        $statement->execute();
        $stmt_result = $statement->get_result();

        if ($stmt_result->num_rows > 0) {
            $row = $stmt_result->fetch_assoc();

            return date('d/m/Y h:i:s A', $row['TIMESTAMP']);
        } else {
            return "Not found";
        }
    }
}

if (!function_exists('generateLicense')) {
    function generateLicense()
    {
        $characters = '0123456789abcdefghikjlmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 25; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('licenseExists')) {
    function licenseExists($pl, $license)
    {
        include 'mysql.php';

        $stmt = $conn->prepare("SELECT * FROM licenses WHERE PLUGIN = ? AND LICENSE = ?");
        $stmt->bind_param("ss", $pl, $license);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        return $stmt_result->num_rows > 0;
    }
}

if (!function_exists('getLicenseInfo')) {
    function getLicenseInfo($pl, $license)
    {
        include 'mysql.php';

        $stmt = $conn->prepare("SELECT * FROM licenses WHERE PLUGIN = ? AND LICENSE = ?");
        $stmt->bind_param("ss", $pl, $license);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        return $stmt_result;
    }
}
