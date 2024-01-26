<?php

include_once("../../../client/components/global/header.comp.php");
include_once("../../database/conn.php");

if (isset($_POST["submit"])) {

    if (!isset($_SESSION["email"])) {
        header("Location: /client/pages/auth/signup.php");
        die();
    }

    $candidateCode = $_POST["code"];
    $email = $_SESSION["email"];

    try {
        $getUser = "SELECT * FROM users WHERE user_email = ?;";
        $getResult = $conn->execute_query($getUser, [$email]);

        if (mysqli_num_rows($getResult) > 0) {
            $row = mysqli_fetch_assoc($getResult);
            if ($row["verification_code"] === $candidateCode) {
                $verifyUser = "UPDATE users SET is_verified = '1' WHERE user_id = ?;";
                $result = $conn->execute_query($verifyUser, [$row["user_id"]]);

                if ($result) {
                    header("Location: /client/pages/auth/login.php");
                    die();
                } else {
                    header("Location: /client/pages/auth/verify.php");
                    die();
                }
            }
        }
    } catch (Exception $e) {
        header("Location: /client/pages/auth/verify.php");
        $_SESSION["verifyError"] = $e->getMessage();
        die();
    }

} else {
    header("Location: /client/pages/auth/verify.php");
    die();
}

?>