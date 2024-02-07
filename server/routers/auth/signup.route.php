<?php session_start() ?>

<?php
include_once("../../database/conn.php");
include_once("../../utils/mailer.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
            $_SESSION["id"] = $conn->insert_id;

            sendVerificationMail($name, $surname, $email, $verificationCode);

            echo json_encode(array("status" => $result));
            die();
        } else {
            echo json_encode(array("status" => false));
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