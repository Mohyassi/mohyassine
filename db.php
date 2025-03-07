<?php

$servername = "127.0.0.1";
$username = "u414268532_brizzstore12";
$password = "Sami12@sami12";
$dbname = "u414268532_onlinestore12";

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>
