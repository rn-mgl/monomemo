<?php include_once("../../components/global/header.comp.php"); ?>

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
                Home
                <i class="fa-solid fa-house"></i>
            </a>

            <a href="/client/pages/monomemo/notes.php" class="sidenav-link">
                Notes

                <i class="fa-solid fa-note-sticky"></i>
            </a>

            <a href="/client/pages/monomemo/folders.php" class="sidenav-link">
                Folders

                <i class="fa-solid fa-folder-open"></i>
            </a>

            <a href="/client/pages/monomemo/profile.php" class="sidenav-link">
                Profile

                <i class="fa-solid fa-user"></i>
            </a>


            <a href="/server/routers/auth/logout.route.php" class="sidenav-link">
                Log Out

                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>


        </div>
    </div>

</div>

<button class="sidenav-button" id="sidenav-open-button"><i class="fa-solid fa-bars"></i></button>