<?php include_once("../../components/header.comp.php") ?>

<?php

if (isset($_SESSION["loginError"])) {
    echo "<div class='message-dropdown error-message'>" . $_SESSION["loginError"] . "</div>";
    $_SESSION["loginError"] = null;
}

?>

<div id="login">

    <form class="auth-form login-form" action="/server/routers/login.route.php" method="post">

        <div class="auth-text-wrapper">
            <p class="auth-greetings">Welcome back to MonoMemo,</p>
            <p class="auth-title login-title">Log In</p>
        </div>

        <div class="auth-label-input-wrapper">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="login-input" placeholder="Enter your e-mail">
        </div>

        <div class="auth-label-input-wrapper">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="login-input" placeholder="Enter your Password">
        </div>

        <button type="submit" class="login-submit" name="submit">Submit</button>
    </form>

    <div class="accent-block" id="login-accent-block"></div>

    <img src="/client/public/svg/login.svg" class="auth-image login-image" />
</div>