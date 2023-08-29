<?php
    include 'mysql.php';
    
    $totalLicenses = $conn->query("SELECT * FROM licenses")->num_rows;
    $totalUsers = $conn->query("SELECT * FROM users")->num_rows;
    $totalRequests = $conn->query("SELECT * FROM requests")->num_rows;

    if(!function_exists("getRequestByDay")) {
        function getRequestByDay($day) {
            include 'mysql.php';

            $statement = $conn->prepare("SELECT * FROM requests WHERE DATE = ?");
            $statement->bind_param("s", $day);
            $statement->execute();
            $stmt_result = $statement->get_result();

            return $stmt_result->num_rows;
        }
    }


?>