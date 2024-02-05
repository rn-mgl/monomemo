jQuery(function() {

    let selectedFileUUID;
    let selectedFileType;

    $(".file-container").on("click", ".move-file-button", function() {
        selectedFileType = $(this).attr("fileType");
        selectedFileUUID = $(this).attr("fileUUID");

        $(".move-file-container")
        .fadeIn(100)
        .css({
            display : "flex",
            "align-items" : "center",
            "justify-content" : "center"
        })

        switch (selectedFileType){
            case "note":
                getNotePaths(selectedFileUUID)
                return
            case "folder":
                getFolderPaths(selectedFileUUID)
                return
        }
    })

    $(".file-paths").on("click", ".path-button", function() {
        const path = $(this).attr("path");

        switch (selectedFileType){
            case "note":
                moveNote(path, selectedFileUUID);
                return
            case "folder":
                moveFolder(path, selectedFileUUID)
                return
        }
    })

    $(".close-move-file-form-button").on("click", function() {
        $(".move-file-container").fadeOut(100);
    })

})

function getNotePaths(noteUUID) {
    $.ajax({
        type : "GET",
        url : `/server/routers/monomemo/move.route.php?note_uuid=${noteUUID}`,
        data : {type : "note_path"},
        dataType : "json",
        success : function(response) {
            const mappedPaths = response.map((data, index) => {
                return `<button class="path-button" path="${data.folder_uuid}">
                            ${data.folder_name} <i class="fa-solid fa-folder-open"></i>
                        </button>`
            })

            mappedPaths.splice(0, 0, `<button class="path-button" path>
                                        Home <i class="fa-solid fa-folder-open"></i>
                                    </button>`)

            $(".file-paths").html(mappedPaths);
        }
    })
}

function moveNote(path, noteUUID) {
    $.ajax({
        type : "POST",
        url : `/server/routers/monomemo/move.route.php?note_uuid=${noteUUID}`,
        data : {type : "move_note", path},
        dataType : "json",
        success : function(response) {
            if (response?.new_path) {
                window.location.href = `/client/pages/monomemo/folder.php?folder_uuid=${response?.new_path}`
            } else {
                window.location.href = "/client/pages/monomemo/home.php"
            }
        },
        error : function(response) {
            console.log(response);
        }
    })
}

function getFolderPaths(folderUUID) {
    $.ajax({
        type : "GET",
        url : `/server/routers/monomemo/move.route.php?folder_uuid=${folderUUID}`,
        data : {type : "folder_path"},
        dataType : "json",
        success : function(response) {
            const mappedPaths = response.map((data, index) => {
                return `<button class="path-button" path="${data.folder_uuid}">
                            ${data.folder_name} <i class="fa-solid fa-folder-open"></i>
                        </button>`
            })

            mappedPaths.splice(0, 0, `<button class="path-button" path>
                                        Home <i class="fa-solid fa-folder-open"></i>
                                    </button>`)

            $(".file-paths").html(mappedPaths);
        }
    })
}

function moveFolder(path, folderUUID) {
    console.log(path == "");
    $.ajax({
        type : "POST",
        url : `/server/routers/monomemo/move.route.php?folder_uuid=${folderUUID}`,
        data : {type : "move_folder", path},
        dataType : "json",
        success : function(response) {
            if (response?.new_path) {
                window.location.href = `/client/pages/monomemo/folder.php?folder_uuid=${response?.new_path}`
            } else {
                window.location.href = "/client/pages/monomemo/home.php"
            }
        },
        error : function(response) {
            console.log(response);
        }
    })
}