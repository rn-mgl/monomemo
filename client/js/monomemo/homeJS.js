jQuery(function() {
    $("#plus-button").on("click", function() {
        this.animate({rotate : "90deg"}, 200);
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
        const mappedNoteData = {type : "new_note"};
        jQuery.map($noteData, function(data, index) {
            mappedNoteData[data.name] = data.value;
        })
        createNote(mappedNoteData);
    })

    $("#create-folder-form").on("submit", function(e) {
        e.preventDefault()
        const $folderData = $(this).serializeArray();
        const mappedFolderData = {type : "new_folder"};
        jQuery.map($folderData, function(data, index) {
            mappedFolderData[data.name]=  data.value;
        })
        createFolders(mappedFolderData)
    })

    getFiles()
})

function createNote(noteData) {
    $.ajax({
        type: "POST",
        url: "/server/routers/monomemo/note.route.php",
        data: noteData,
        dataType: "json",
        success: function (response) {
            getFiles()
            $(".file-form-container, .create-file-form").fadeOut(100)
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
            getFiles()
            $(".file-form-container, .create-file-form").fadeOut(100)
        },
    });
}

function getFiles() {
    $.ajax({
        type: "GET",
        url: "/server/routers/monomemo/home.route.php",
        dataType: "json",
        success: function (response) {
            const mappedFiles = response.map((fileData, index) => {
                return fileData.type === "note" ? 
                `<a class="note-card-container" 
                    href="/client/pages/monomemo/note.php?note_uuid=${fileData.uuid}">
                    <p class="note-card-title">${fileData.title ? fileData.title : ""}</p>
                    <p class="note-card-content">${fileData.content ? fileData.content : ""}</p>
                </a>` 
            : 
                `<a class="folder-card-container" 
                    href="/client/pages/monomemo/folder.php?folder_uuid=${fileData.uuid}" >
                    <p class="folder-card-title">${fileData.title ? fileData.title : ""}</p>
                </a>` 
            }) 
            $(".file-container").html(mappedFiles);
        },
        error : function(re) {
            console.log(re);
        }

    });
}