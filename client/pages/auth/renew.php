<?php
include_once("../../components/global/header.comp.php");
include_once("../../components/global/logo.comp.php");
?>

<div id="renew">

    <form class="auth-form renew-form" id="renew-form">

        <div class="auth-text-wrapper">
            <p class="auth-greetings">Troubleshoot MonoMemo,</p>
            <p class="auth-title renew-title">New Password</p>
        </div>

        <div class="auth-label-input-wrapper">
            <label for="password">Password</label>
            <input type="password" name="newPassword" id="password" class="renew-input" placeholder="Enter new Password">
        </div>

        <div class="auth-label-input-wrapper">
            <label for="password">Password</label>
            <input type="password" name="retypedPassword" id="password" class="renew-input" placeholder="Retype new Password">
        </div>

        <button type="submit" id="renew-submit" name="submit">Submit</button>
    </form>

    <div class="accent-block" id="renew-accent-block"></div>

    <img src="/client/public/svg/renew.svg" class="auth-image renew-image" />
</div>

<script src="../../js/auth/renewJS.js"></script>