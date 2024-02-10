<?php
    function setAccessToken($token) {
        setcookie("token", $token, time()+86400 * 7, "/", "localhost", true, true);
    }

?>