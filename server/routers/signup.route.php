<?php
include_once("../../client/components/header.comp.php");
include_once("../../server/database/conn.php");
include_once("../utils/mailer.php");

if (isset($_POST["submit"])) {

    $uuid = bin2hex(openssl_random_pseudo_bytes(25));
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $verificationCode = strtoupper(bin2hex(openssl_random_pseudo_bytes(3)));
    $setDate = strtotime("+ 1 day");
    $expirationDate = date("Y-m-d H:i:s", $setDate);

    try {
        $query = "INSERT INTO users (
                            user_uuid, 
                            user_name, 
                            user_surname, 
                            user_email, 
                            user_password, 
                            verification_code, 
                            verification_code_expiration
                            )
                VALUES (?, ?, ?, ?, ?, ?, ?);";

        $result = $conn->execute_query($query, [$uuid, $name, $surname, $email, $hashedPassword, $verificationCode, $expirationDate]);

        if ($result) {
            $_SESSION["name"] = $name;
            $_SESSION["surname"] = $surname;
            $_SESSION["email"] = $email;
            $_SESSION["uuid"] = $uuid;

            sendVerificationMail($name, $surname, $email, $verificationCode);

            header("Location: /client/pages/auth/verify.php");
            die();
        } else {
            header("Location: /client/pages/auth/signup.php");
            die();
        }

    } catch (Exception $e) {
        $_SESSION["signupError"] = $e->getMessage();
        header("Location: /client/pages/auth/signup.php");
        die();
    }

} else {
    header("Location: /client/pages/auth/signup.php");
    die();
}

?>