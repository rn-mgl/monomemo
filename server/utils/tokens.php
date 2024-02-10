<?php
    require_once __DIR__ . "/../../vendor/autoload.php";

    use Firebase\JWT\JWT;

    use Dotenv\Dotenv;
    $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
    $dotenv->safeLoad();

    function createAccessToken($user) {
        $now_seconds = time();

        $payload = ["id" => $user["user_id"], 
                    "uuid" => $user["user_uuid"], 
                    "email" => $user["user_email"], 
                    "exp" => $now_seconds + (60 * 60 * 7)];
        $encodeJWT = JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");

        return $encodeJWT;
    }

    function deleteAccessToken() {
        setcookie("token", "", time() - 3600, "/", "localhost", true, true);
    }


?>