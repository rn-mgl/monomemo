<?php
include_once("../../client/components/header.comp.php");
include_once("../../server/database/conn.php");

if (isset($_POST["submit"])) {

    $uuid = bin2hex(openssl_random_pseudo_bytes(25));
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $query = "INSERT INTO users (user_uuid, user_name, user_surname, user_email, user_password)
                VALUES ('$uuid', '$name', '$surname', '$email', '$hashedPassword');";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION["name"] = $name;
            $_SESSION["surname"] = $surname;
            $_SESSION["email"] = $email;
            $_SESSION["uuid"] = $uuid;
            header("Location: /client/pages/monomemo/home.php");
        }

    } catch (Exception $e) {
        $_SESSION["signupError"] = $e->getMessage();
        header("Location: /client/pages/signup.php");
    }

} else {
    echo "123";
}

?>