<?php include_once("../../components/header.comp.php") ?>

<?php

if (isset($_SESSION["signupError"])) {
    echo "<div class='message-dropdown error-message'>" . $_SESSION["signupError"] . "</div>";
    $_SESSION["signupError"] = null;
}

?>

<div id="signup">

    <form class="auth-form signup-form" action="/server/routers/signup.route.php" method="post">

        <div class="auth-text-wrapper">
            <p class="auth-greetings">Welcome to MonoMemo,</p>
            <p class="auth-title signup-title">Sign Up</p>
        </div>

        <div class="auth-label-input-wrapper">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="signup-input" placeholder="Enter your Name">
        </div>

        <div class="auth-label-input-wrapper">
            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname" class="signup-input" placeholder="Enter your Surname">
        </div>

        <div class="auth-label-input-wrapper">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="signup-input" placeholder="Enter your e-mail">
        </div>

        <div class="auth-label-input-wrapper">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="signup-input" placeholder="Enter your Password">
        </div>

        <button type="submit" class="signup-submit" name="submit">Submit</button>
    </form>

    <div class="accent-block" id="signup-accent-block"></div>

    <img src="/client/public/svg/signUp.svg" class="auth-image signup-image" />
</div>