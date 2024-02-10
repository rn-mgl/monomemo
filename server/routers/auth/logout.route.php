<?php

include_once("../../utils/tokens.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    session_destroy();
    echo json_encode(array("status" => true));
    deleteAccessToken();
    die();
} else {
    header("Location: /client/pages/index.php");
}

?>