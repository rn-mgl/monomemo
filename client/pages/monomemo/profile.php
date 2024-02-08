<?php include_once("../../components/global/nav.comp.php") ?>

<div id="profile">

    <div id="edit-profile-form-container">
        <form id="edit-profile-form">
            <button type="button" class="close-edit-profile-form" 
                id="close-edit-profile-form">
                    <i class="fa-solid fa-xmark"></i>
            </button>
            
            <div class="edit-profile-input-wrapper">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" 
                    class="edit-profile-input" 
                    placeholder="Enter new Name">
            </div>

            <div class="edit-profile-input-wrapper">
                <label for="surname">Surname</label>
                <input type="text" name="surname" id="surname" 
                    class="edit-profile-input" 
                    placeholder="Enter new Surname">
            </div>
            <button type="submit" id="edit-profile-submit" name="submit">Update</button>
        </form>

        <form id="edit-profile-image-form">
            <button type="button" class="close-edit-profile-form" 
                id="close-edit-profile-image-form">
                    <i class="fa-solid fa-xmark"></i>
            </button>
            
            <div class="edit-profile-image-input-wrapper">
                <div id="profile-image-input-display">
                    <i class="fa-solid fa-image"></i>
                </div>

                <div class="edit-profile-image-action-buttons">
                    <label for="profile-image-input" id="profile-image-input-label">
                        <i class="fa-solid fa-image"></i>
                    </label>

                    <button id="remove-profile-image-button" type="button"><i class="fa-solid fa-trash"></i></button>
                </div>

                <input type="file" accept="image/*" name="profile-image" id="profile-image-input" class="edit-profile-image-input" >
            </div>

            <button type="submit" id="edit-profile-submit" name="submit">Update</button>
        </form>
    </div>

    <div id="image-container">
        <button id="edit-profile-image-button">
            <i class="fa-solid fa-pen-to-square"></i>
        </button>
    </div>
    <div id="info-container">
       
    </div>
</div>

<script src="../../js/monomemo/profileJS.js"></script>