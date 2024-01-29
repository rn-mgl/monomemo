<?php include_once("../../components/global/header.comp.php"); ?>

<div id="topnav">
    <button class="sidenav-button" id="sidenav-open-button">
        <i class="fa-solid fa-bars"></i>
    </button>
    <div id="greetings-container">
    </div>
    <a href="/client/pages/monomemo/profile.php" id="profile-link">

    </a>
</div>

<div id="sidenav">
    <div class="sidenav-wrapper">
        <div id="sidenav-logo-container" draggable="false">
            <button class="sidenav-button" id="sidenav-close-button"><i class="fa-solid fa-xmark"></i></button>

            <a id="logo" href="/client/pages/home.php">
                <img src="/client/public/images/logo.png" alt="logo" width="25" height="25">
                <p>Mono<span class="text-green-gradient">me</span><span class="text-purple-gradient">mo</span></p>
            </a>
        </div>

        <div class="sidenav-link-wrapper">

            <a href="/client/pages/monomemo/home.php" class="sidenav-link">
                <span class="sidenav-link-label">Home</span>
                <i class="fa-solid fa-house"></i>
            </a>

            <a href="/client/pages/monomemo/notes.php" class="sidenav-link">
                <span class="sidenav-link-label">Notes</span>
                <i class="fa-solid fa-note-sticky"></i>
            </a>

            <a href="/client/pages/monomemo/folders.php" class="sidenav-link">
                <span class="sidenav-link-label">Folders</span>
                <i class="fa-solid fa-folder-open"></i>
            </a>

            <a href="/server/routers/auth/logout.route.php" class="sidenav-link">
                <span class="sidenav-link-label">Log Out</span>
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>

        </div>
    </div>
</div>

<script src="../../js/global/sideNavJS.js" type="text/javascript"></script>