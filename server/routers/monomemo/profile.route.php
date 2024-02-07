<?php session_start(); ?>
<?php include_once("../../database/conn.php"); ?>

<?php

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (!isset($_SESSION["id"])) {
            header("Location: /client/pages/auth/login.php");
            die();
        }

        $userID = $_SESSION["id"];

        try {
            $query = "SELECT * FROM users WHERE user_id = ?;";
            $result = $conn->execute_query($query, [$userID]);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo json_encode($row);
            } else {
                echo json_encode(array());
            }

        } catch (Exception $e) {
            header("Location: /client/pages/auth/login.php");
            die();
        }
    } 

?>