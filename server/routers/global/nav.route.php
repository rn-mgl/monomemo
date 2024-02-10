<?php session_start() ?>
<?php
include_once("../../database/conn.php");
include_once("../../utils/tokens.php");
?>

<?php

$token = verifyAccessToken();

if (!$token) {
    header("Location: /client/pages/auth/login.php");
    die();
}

try {
    $uuid = $_SESSION["uuid"];
    $query = "SELECT * FROM users WHERE user_uuid = ?;";
    $result = $conn->execute_query($query, [$uuid]);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
        exit();
    } else {
        header("Location: /client/pages/index.php");
        exit();
    }

} catch (Exception $e) {
    header("Location: /client/pages/index.php");
    exit();
}

?>