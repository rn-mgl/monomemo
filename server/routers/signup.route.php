<?php
include_once("../../client/components/header.comp.php");
include_once("../../server/database/conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("../../vendor/phpmailer/phpmailer/src/Exception.php");
require_once("../../vendor/phpmailer/phpmailer/src/PHPMailer.php");
require_once("../../vendor/phpmailer/phpmailer/src/SMTP.php");

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

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "rltnslns@gmail.com";
            $mail->Password = "ccul pcfs gfxk eyel";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom("rltnslns@gmail.com");
            $mail->addAddress($email);
            $mail->isHTML(true);

            $mail->Subject = "Email Verification";

            $mail->Body = "
                <p>Hello $name $surname,</p>

                <p>
                    We hope this email finds you well. At MonoMemo, your security 
                    is our top priority. In our ongoing efforts to ensure the safety 
                    and integrity of our platform, we require all users to verify 
                    their accounts periodically.
                </p>

                <p>
                    To maintain access to your account and enjoy uninterrupted 
                    service, we kindly request you to complete the verification 
                    process at your earliest convenience.
                </p>

                <p>
                    Click on the link to access the verification page: 
                    <a href='http://localhost:3000/client/pages/home.php'>
                        Verify My Account
                    </a>
                </p>

                <p>
                    Thank you for your prompt attention to this matter. We appreciate 
                    your cooperation in helping us maintain a secure environment 
                    for all our users.
                </p>

                <p>
                    If you did not initiate this account verification process, 
                    you can safely disregard this email.
                </p>

                <p>
                    Best regards,
                </p>

                <p>
                    MonoMemo
                    rtlnslns@gmail.com
                </p>
                ";

            $mail->send();

            header("Location: /client/pages/auth/verify.php");
        }

    } catch (Exception $e) {
        $_SESSION["signupError"] = $e->getMessage();
        header("Location: /client/pages/auth/signup.php");
    }

} else {
    header("Location: /client/pages/auth/signup.php");
}

?>