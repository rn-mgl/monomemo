<?php include_once("../../components/header.comp.php") ?>

<?php

if (isset($_SESSION["verifyError"])) {
    echo "<div class='message-dropdown error-message'>" . $_SESSION["verifyError"] . "</div>";
    $_SESSION["verifyError"] = null;
}

?>

<div id="verify">
    <form class="auth-form verify-form" action="/server/routers/verify.route.php" method="post">

        <div class="auth-text-wrapper">
            <p class="auth-greetings">Welcome to MonoMemo,</p>
            <p class="auth-title verify-title">Verify</p>
        </div>

        <div class="auth-label-input-wrapper">
            <label for="code">Verification Code</label>
            <input type="text" name="code" id="code" class="verify-input" placeholder="Enter verification code">
        </div>

        <button type="submit" class="verify-submit" name="submit">Submit</button>
    </form>

    <div class="accent-block" id="verify-accent-block"></div>

    <img src="/client/public/svg/verify.svg" class="auth-image verify-image" />
</div>