jQuery(function() {
    const params = new URLSearchParams(window.location.search);
    const noteUUID = params.get("note_uuid")
    const folderUUID = params.get("folder_uuid")

    $("#move-note-button").on("click", function() {

        $(".move-file-container")
        .fadeIn(100)
        .css({
            display : "flex",
            "align-items" : "center",
            "justify-content" : "center"
        });
        getNotePaths(noteUUID);
    })

    $(".file-paths").on("click", ".path-button", function() {
        const path = $(this).attr("path");
        const fileType = $(this).attr("fileType");

        switch (fileType){
            case "note":
                moveNote(path, noteUUID);
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
                return `<button class="path-button" path="${data.folder_uuid}" fileType="note">
                            ${data.folder_name} <i class="fa-solid fa-folder-open"></i>
                        </button>`
            })

            mappedPaths.splice(0, 0, `<button class="path-button" path fileType="note">
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