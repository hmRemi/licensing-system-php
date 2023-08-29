<?php
include $_SERVER['DOCUMENT_ROOT'] . '/panel/config.php';

// Create connection
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // Create tables
    $conn->query("CREATE TABLE IF NOT EXISTS users (`USERNAME` VARCHAR(300) NOT NULL, `PASSWORD` VARCHAR(300) NOT NULL, `ID` VARCHAR(6) NOT NULL);");
    $conn->query("CREATE TABLE IF NOT EXISTS tokens (`ID` VARCHAR(6) NOT NULL, `TOKEN` VARCHAR(30) NOT NULL);");
    $conn->query("CREATE TABLE IF NOT EXISTS licenses (`DISCORD` VARCHAR(300) NOT NULL, `PLUGIN` VARCHAR(300) NOT NULL, `LICENSE` VARCHAR(300) NOT NULL, `CREATED-BY` VARCHAR(300) NOT NULL, `CREATED-IN` VARCHAR(300) NOT NULL, `MAX-IPS` INT(11) NOT NULL);");
    $conn->query("CREATE TABLE IF NOT EXISTS requests (`LICENSE` VARCHAR(300) NOT NULL, `PLUGIN` VARCHAR(300) NOT NULL, `IP` VARCHAR(300) NOT NULL, `DATE` VARCHAR(300) NOT NULL, `TIMESTAMP` VARCHAR(300) NOT NULL);");

    // Create initial user
    $initialStmt = $conn->prepare("SELECT * FROM users");
    $initialStmt->execute();
    
    if ($initialStmt->get_result()->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO users (`USERNAME`, `PASSWORD`, `ID`) VALUES (?, ?, ?)");

        $INITIAL_ID = "UNX80G";
        $INITIAL_USER = INITIAL_USERNAME;
        $first_hash = hash('sha256', INITIAL_PASSWORD);
        $second_hash = hash('sha512', $first_hash);
        $third_hash = hash('sha512', $second_hash);
        $final_hash = password_hash($third_hash, PASSWORD_ARGON2I, ['memory_cost' => 1024, 'time_cost' => 4, 'threads' => 1]);

        $stmt->bind_param("sss", $INITIAL_USER, $final_hash, $INITIAL_ID);

        $stmt->execute();
    }
}
