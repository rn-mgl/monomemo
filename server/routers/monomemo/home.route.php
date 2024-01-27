<?php
include_once("../../database/conn.php");

if (!isset($_SESSION["uuid"]) || !isset($_SESSION["name"]) || !isset($_SESSION["surname"]) || !isset($_SESSION["email"])) {
    header("Location: /client/pages/index.php", true, 301);
    die();
}

try {
    $uuid = $_SESSION["uuid"];
    $query = "SELECT * FROM users WHERE user_uuid = ?;";
    $result = $conn->execute_query($query, [$uuid]);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo "<h1>" . $row["user_name"] . "</h1>";
    } else {
        header("Location: /client/pages/index.php", true, 301);
        die();
    }

} catch (Exception $e) {
    header("Location: /client/pages/index.php", true, 301);
    die();
}

?>