<?php session_start() ?>
<?php 
include_once("../../database/conn.php");
include_once("../../utils/tokens.php");
include_once("../../utils/mailer.php");
 ?>

<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!isset($_POST["email"])) {
            header("Location: /client/pages/auth/forgot.php");
            die();
        }

        try {

            $email = $_POST["email"];

            $query = "SELECT * FROM users WHERE user_email = ?";
            $result = $conn->execute_query($query, [$email]);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $token = createEmailToken($row);
                sendPasswordRestMail($row["user_name"], $row["user_surname"], $row["user_email"], $token);
                
                echo json_encode(["status" => "successful"]);

            } else {
                header("Location: /client/pages/auth/forgot.php");
                die();
            }

        } catch (Exception $e) {
            header("Location: /client/pages/auth/forgot.php");
            die();
        }

    }

?>
