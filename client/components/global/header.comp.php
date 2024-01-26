<?php
session_start();
include_once(__DIR__ . "/../../../vendor/autoload.php");
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../../../");
$dotenv->safeload();
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
		integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
		integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<link rel="icon" type="image/x-icon" href="/client/public/images/logo.png">
	<link rel="stylesheet" href="/client/css/variables.css">
	<link rel="stylesheet" href="/client/css/global.css">
	<link rel="stylesheet" href="/client/css/animate.css">

	<link rel="stylesheet" href="/client/css/landing/hero.css">
	<link rel="stylesheet" href="/client/css/landing/offers.css">
	<link rel="stylesheet" href="/client/css/landing/action.css">

	<link rel="stylesheet" href="/client/css/auth/auth.css">
	<link rel="stylesheet" href="/client/css/auth/signup.css">
	<link rel="stylesheet" href="/client/css/auth/verify.css">
	<link rel="stylesheet" href="/client/css/auth/login.css">

	<link rel="stylesheet" href="/client/css/global/sidenav.css">

	<script src="../../js/prac.js" type="text/javascript"></script>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=1, initial-scale=1.0">
	<title>MonoMemo</title>
</head>

<body>