<?php
include_once("../../components/global/header.comp.php");
include_once("../../../server/utils/tokens.php");

$token = verifyAccessToken();
if (!$token) {
    header("Location: /client/pages/auth/login.php");
    die();
}
?>

<div id="topnav">

    <div id="nav-logo-container" draggable="false">
        <a id="logo" href="/client/pages/monomemo/home.php">
            <img src="/client/public/images/logo.png" alt="logo" width="25" height="25">
            <p>Mono<span class="text-green-gradient">me</span><span class="text-purple-gradient">mo</span></p>
        </a>
    </div>

    <div id="profile-container">
        <button id="profile-button"></button>
        <div id="profile-actions-container">
            <button class="profile-actions-button" id="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log
                Out <i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>
</div>

<script src="../../js/global/navJS.js" type="text/javascript"></script>