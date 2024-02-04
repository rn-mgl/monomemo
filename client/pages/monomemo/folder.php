<?php session_start() ?>
<?php include_once("../../components/global/header.comp.php"); ?>
<?php include_once("../../components/global/sidenav.comp.php"); ?>


<div class="monomemo-home">

    <div class="delete-form-container">
        <div class="delete-form">
            <p id="delete-title">Delete File?</p>
            <p id="delete-subtitle">a file cannot be retrieved once deleted</p>

            <div class="delete-action-buttons-container">
                <button type="button" id="decline-delete">No</button>
                <button type="button" id="confirm-delete">Yes</button>
            </div>
        </div>
    </div>

    <div class="delete-folder-form-container">
        <div class="delete-folder-form">
            <p id="delete-folder-title">Delete Folder?</p>
            <p id="delete-folder-subtitle">a folder cannot be retrieved once deleted</p>

            <div class="delete-folder-action-buttons-container">
                <button type="button" id="decline-folder-delete">No</button>
                <button type="button" id="confirm-folder-delete">Yes</button>
            </div>
        </div>
    </div>

    <div class="folder-data-container"></div>

    <div class="file-container">
    </div>

    <div class="folder-file-form-container">
        <form method="post" id="folder-create-note-form" class="folder-create-file-form">
            <div class="create-file-form-title-wrapper">
                <p>Create Note</p>
                <button type="button" class="folder-create-file-form-close-button"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="create-file-label-wrapper">
                <label for="noteTitle">Title</label>
                <input type="text" name="noteTitle" class="create-note-title-input" id="noteTitle">
            </div>

            <div class="create-file-label-wrapper">
                <label for="noteContent">Content</label>
                <textarea name="noteContent" class="create-note-content-input" id="noteContent" rows=10></textarea>
            </div>

            <button type="submit" id="folder-create-note-submit" name="createNoteSubmit"
                class="file-form-submit">Create</button>
        </form>

        <form method="post" id="folder-create-folder-form" class="folder-create-file-form">
            <div class="create-file-form-title-wrapper">
                <p>Create Folder</p>
                <button type="button" class="folder-create-file-form-close-button"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="create-file-label-wrapper">
                <label for="folderName">Title</label>
                <input type="text" name="folderName" class="create-folder-title-input" id="folderName">
            </div>

            <button type="submit" id="folder-create-folder-submit" name="createFormSubmit"
                class="file-form-submit">Create</button>
        </form>
    </div>

    <div class="add-button-container">
        <button class="add-button file-button" id="folder-note-button"><i class="fa-solid fa-note-sticky"></i></button>
        <button class="add-button file-button" id="folder-folder-button"><i
                class="fa-solid fa-folder-open"></i></button>
        <button class="add-button add-button-selected" id="folder-plus-button"><i class="fa-solid fa-plus"></i></button>
    </div>

</div>

<script src="../../js/monomemo/folderJS.js" type="text/javascript"></script>