<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->safeLoad();

function createAccessToken($user)
{
    $nowSeconds = time();

    $payload = [
        "id" => $user["user_id"],
        "uuid" => $user["user_uuid"],
        "email" => $user["user_email"],
        "exp" => $nowSeconds + (60 * 60 * 7)
    ];
    $encodeJWT = JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");

    return "Bearer " . $encodeJWT;
}

function deleteAccessToken()
{
    setcookie("token", "", time() - 3600, "/", "localhost", true, true);
}

function verifyAccessToken()
{

    if (!isset($_COOKIE["token"])) {
        return false;
    }

    $candidateToken = $_COOKIE["token"];

    if (!str_starts_with($candidateToken, "Bearer ")) {
        return false;
    }

    $token = explode(" ", $candidateToken)[1];

    try {
        $decoded = JWT::decode($token, new Key($_ENV["JWT_SECRET"], "HS256"));
        return $decoded;
    } catch (Exception $e) {
        return false;
    }
}

function createEmailToken($user) {
    $nowSeconds = time();
    $payload = [
        "id" => $user["user_id"],
        "uuid" => $user["user_uuid"],
        "email" => $user["user_email"],
        "exp" => $nowSeconds + (60 * 60 * 1)
    ];

    $encode = JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");
    return $encode;
}


?>