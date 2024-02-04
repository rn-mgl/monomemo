<?php session_start() ?>
<?php include_once("../../database/conn.php"); ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == "move_note") {

        if (!isset($_GET["note_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    } else if ($_POST["type"] == "move_folder") {

        if (!isset($_GET["folder_uuid"])) {
            header("Location: /client/pages/monomemo/home.php");
            die();
        }

    }
}

?>