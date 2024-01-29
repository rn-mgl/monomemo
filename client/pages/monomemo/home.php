<?php session_start() ?>

<?php
include_once("../../components/global/header.comp.php");
include_once("../../components/global/sidenav.comp.php");
if (!isset($_SESSION["uuid"]) || !isset($_SESSION["name"]) || !isset($_SESSION["surname"]) || !isset($_SESSION["email"])) {
    header("Location: /client/pages/index.php");
    die();
}
?>

<div id="monomemo-home">

    <form action=""></form>

    <div class="add-button-container">
        <button class="add-button file-button" id="note-button"><i class="fa-solid fa-note-sticky"></i></button>
        <button class="add-button file-button" id="folder-button"><i class="fa-solid fa-folder-open"></i></button>
        <button class="add-button add-button-selected" id="plus-button"><i class="fa-solid fa-plus"></i></button>
    </div>

</div>