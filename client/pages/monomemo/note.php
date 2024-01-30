<?php session_start() ?>
<?php include_once("../../components/global/header.comp.php"); ?>
<?php include_once("../../components/global/sidenav.comp.php"); ?>
<?php include_once("../../../server/database/conn.php"); ?>


<?php
if (!isset($_SESSION["uuid"])) {
    header("Location: /client/pages/auth/login.php");
    die();
}

if (!isset($_GET["note_uuid"])) {
    header("Location: /client/pages/monomemo/home.php");
    die();
}
?>

<div id="single-note"></div>

<script src="../../js/monomemo/noteJS.js"></script>