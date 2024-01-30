jQuery(function() {
    $("#plus-button").on("click", function() {
        this.animate({rotate : "90deg"}, 100);
        $(this).toggleClass("add-button-selected");
        $(".file-button").each(function(index, $button) {
            $(this).slideToggle((index + 1) * 50)
    })
    })

    $("#note-button").on("click", function () {
        $(".file-form-container, #create-note-form")
        .fadeIn(100)
        .css({
            display : "flex", 
            "align-items" : "center", 
            "justify-content" : "center"
        });
    })

    $("#folder-button").on("click", function () {
        $(".file-form-container, #create-folder-form")
        .fadeIn(100)
        .css({
            display : "flex", 
            "align-items" : "center", 
            "justify-content" : "center"
        });
    })

    $(".create-file-form-close-button").on("click", function () {
        $(".file-form-container, .create-file-form").fadeOut(100)
    })

    $("#create-note-form").on("submit", function(e) {
        e.preventDefault()
        const $noteData = $(this).serializeArray()
        const mappedNoteData = {};

        jQuery.map($noteData, function(data, index) {
            mappedNoteData[data.name] = data.value;
        })
        createNote(mappedNoteData);
    })

    $("#create-folder-form").on("submit", function(e) {
        e.preventDefault()
        const $folderData = $(this).serializeArray();
        const mappedFolderData = {};
        jQuery.map($folderData, function(data, index) {
            
            mappedFolderData[data.name]=  data.value;
        })
        createFolders(mappedFolderData)
    })

    getNotes()
    getFolders()
})

function createNote(noteData) {
    $.ajax({
        type: "POST",
        url: "/server/routers/monomemo/note.route.php",
        data: noteData,
        dataType: "json",
        success: function (response) {
            getNotes()
            $(".file-form-container, .create-file-form").fadeOut(100)
        },
    });
}

function getNotes() {
    $.ajax({
        type: "GET",
        url: "/server/routers/monomemo/note.route.php",
        dataType: "json",
        success: function (response) {
            const mappedNotes = response.map((noteData, index) => {
                return `<div class="note-card-container" key=${index}>
                            <p class="note-card-title">${noteData.note_title}</p>
                            <p class="note-card-content">${noteData.note_content}</p>
                        </div>`
            }) 
            $(".file-container").html(mappedNotes);
        },
    });
}

function createFolders(folderData) {
    $.ajax({
        type: "POST",
        url: "/server/routers/monomemo/folder.route.php",
        data: folderData,
        dataType: "json",
        success: function (response) {
            getFolders()
            $(".file-form-container, .create-file-form").fadeOut(100)
        },
    });
}

function getFolders() {
    $.ajax({
        type: "GET",
        url: "/server/routers/monomemo/folder.route.php",
        dataType: "json",
        success: function (response) {
            const mappedFolders = response.map((folderData, index) => {
                return `<div class="folder-card-container" key=${index}>
                            <p class="folder-card-title">${folderData.folder_name}</p>
                        </div>`
            }) 
            $(".file-container").html(mappedFolders);
        },
    });
}