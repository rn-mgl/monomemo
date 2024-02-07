<?php
include_once(__DIR__ . "/../../vendor/autoload.php");

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("../../../vendor/phpmailer/phpmailer/src/Exception.php");
require_once("../../../vendor/phpmailer/phpmailer/src/PHPMailer.php");
require_once("../../../vendor/phpmailer/phpmailer/src/SMTP.php");

$dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->safeload();

function sendVerificationMail($name, $surname, $emailTo, $verificationCode)
{
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV["MAILER_HOST"];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV["MAILER_USER"];
        $mail->Password = $_ENV["MAILER_PASS"];
        $mail->SMTPSecure = $_ENV["MAILER_SECURE"];
        $mail->Port = $_ENV["MAILER_PORT"];

        $mail->setFrom("rltnslns@gmail.com");
        $mail->addAddress($emailTo);
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
                        <a href='http://localhost:3000/client/pages/auth/verify.php'>
                            Verify My Account
                        </a>
                    </p>

                    <p>
                        Use the code: <h2>$verificationCode</h2>
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

                    <b>
                        This code will expire in exactly 24 hours.
                    </b>
    
                    <p>
                        Best regards,
                    </p>
    
                    <p>
                        MonoMemo
                        <br>
                        rtlnslns@gmail.com
                    </p>
                    ";

        $mail->send();
    } catch (Exception $e) {
        throw $e;
    }

}

?>