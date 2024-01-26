<?php
include_once("../../client/components/header.comp.php");

if (isset($_ENV["DB_HOST"]) && isset($_ENV["DB_USER"]) && isset($_ENV["DB_PASS"]) && isset($_ENV["DB_NAME"])) {
    $dbhost = $_ENV["DB_HOST"];
    $dbuser = $_ENV["DB_USER"];
    $dbpass = $_ENV["DB_PASS"];
    $dbname = $_ENV["DB_NAME"];

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }
}



