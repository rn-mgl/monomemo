<?php session_start() ?>

<?php
include_once("../../database/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $candidateEmail = $_POST["email"];
        $candidatePassword = $_POST["password"];

        $checkQuery = "SELECT * FROM users WHERE user_email = ?;";
        $checkResult = $conn->execute_query($checkQuery, [$candidateEmail]);

        if ($checkResult->num_rows > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $password = $row["user_password"];
            $isCorrect = password_verify($candidatePassword, $password);

            if ($isCorrect) {
                $_SESSION["uuid"] = $row["user_uuid"];
                $_SESSION["name"] = $row["user_name"];
                $_SESSION["surname"] = $row["user_surname"];
                $_SESSION["email"] = $row["user_email"];
                $_SESSION["id"] = $row["user_id"];

                echo json_encode(array("status" => $isCorrect));
                die();
            } else {
                echo json_encode(array("status" => false));
                $_SESSION["loginError"] = "Incorrect password";
                die();
            }
        } else {
            header("Location: /client/pages/auth/login.php");
            $_SESSION["loginError"] = "Incorrect credentials";
            die();
        }
    } catch (Exception $e) {
        header("Location: /client/pages/auth/login.php");
        $_SESSION["loginError"] = $e->getMessage();
        die();
    }

} else {
    header("Location: /client/pages/auth/login.php");
    die();
}

?>