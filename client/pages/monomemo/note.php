<?php session_start() ?>
<?php include_once("../../components/global/header.comp.php"); ?>
<?php include_once("../../components/global/nav.comp.php"); ?>
<?php include_once("../../../server/database/conn.php"); ?>
<?php
include_once("../../../server/utils/tokens.php");

$token = verifyAccessToken();
if (!$token) {
    header("Location: /client/pages/auth/login.php");
    die();
}
?>


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

<div id="single-note-page">
    <div class="move-file-container">
        <div class="move-file-form">
            <button class="close-move-file-form-button">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <p class="move-file-title">Select new file location</p>
            <div class="file-paths"></div>
        </div>
    </div>

    <div class="delete-form-container">
        <div class="delete-form">
            <p id="delete-title">Delete Note?</p>
            <p id="delete-subtitle">a note cannot be retrieved once deleted</p>

            <div class="delete-action-buttons-container">
                <button type="button" id="decline-delete">No</button>
                <button type="button" id="confirm-delete">Yes</button>
            </div>
        </div>
    </div>

    <div id="single-note">
        <div class="note-action-buttons-container">
            <button id="delete-note-button">
                <i class="fa-solid fa-trash-can"></i>
            </button>
            <button id="move-note-button">
                <i class="fa-solid fa-arrows-turn-to-dots"></i>
            </button>
        </div>
    </div>
</div>

<script src="../../js/monomemo/noteJS.js" type="text/javascript"></script>