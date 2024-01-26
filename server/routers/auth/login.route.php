<?php
include_once("../../../client/components/global/header.comp.php");
include_once("../../database/conn.php");

if (isset($_POST["submit"])) {

    try {
        $candidateEmail = $_POST["email"];
        $candidatePassword = $_POST["password"];

        $checkQuery = "SELECT * FROM users WHERE user_email = ?;";
        $checkResult = $conn->execute_query($checkQuery, [$candidateEmail]);

        if (mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $password = $row["user_password"];
            $isCorrect = password_verify($candidatePassword, $password);

            if ($isCorrect) {
                $_SESSION["uuid"] = $row["user_uuid"];
                $_SESSION["name"] = $row["user_name"];
                $_SESSION["surname"] = $row["user_surname"];
                $_SESSION["email"] = $row["user_email"];

                header("Location: /client/pages/monomemo/home.php");
                die();
            } else {
                header("Location: /client/pages/auth/login.php");
                $_SESSION["loginError"] = "Incorrect password";
                die();
            }
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