<?php
include_once("../../components/global/header.comp.php");
include_once("../../components/global/logo.comp.php");
?>

<div id="forgot">

    <form class="auth-form forgot-form" id="forgot-form">

        <div class="auth-text-wrapper">
            <p class="auth-greetings">Troubleshoot MonoMemo,</p>
            <p class="auth-title forgot-title">Forgot Password</p>
        </div>

        <div class="auth-label-input-wrapper">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="forgot-input" placeholder="Enter your e-mail">
        </div>

        <button type="submit" id="forgot-submit" name="submit">Submit</button>
    </form>

    <div class="accent-block" id="forgot-accent-block"></div>

    <img src="/client/public/svg/forgot.svg" class="auth-image forgot-image" />
</div>

<script src="../../js/auth/forgotJS.js"></script>