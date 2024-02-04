jQuery(function() {
    const params = new URLSearchParams(window.location.search)
    if (!params.has("note_uuid")) {
        window.location.href = "/client/pages/monomemo/home.php"
    }
    const noteUUID = params.get("note_uuid");

    $("#single-note").on("input", "#single-note-form", function() {
        setTimeout(() => {
            const noteData = $(this).serializeArray();
            const mappedNoteData = {type : "update_note"};
            jQuery.map(noteData, function(data, index){
                mappedNoteData[data.name] = data.value;
            })
            updateNote(mappedNoteData, noteUUID);
        }, [400])
        
    })

    $("#delete-note-button").on("click", function() {
        $(".delete-form-container")
        .fadeIn(100)
        .css({
            display : "flex",
            "align-items": "center",
            "justify-content": "center"
        });
    })

    $("#decline-delete").on("click", function() {
        $(".delete-form-container").fadeOut(100);
    })

    $("#confirm-delete").on("click", function() {
        $.ajax({
            type : "POST",
            url : `/server/routers/monomemo/note.route.php?note_uuid=${noteUUID}`,
            data : {type : "delete_note"},
            dataType : "json",
            success : function (response) {
                if (response?.note_from) {
                    window.location.href = `/client/pages/monomemo/folder.php?folder_uuid=${response.note_from}`;
                } else {
                    window.location.href = "/client/pages/monomemo/home.php";
                }
            }
        })
    })

    $("#move-note-button").on("click", function() {
        $(".move-file-container")
        .fadeIn(100)
        .css({
            display : "flex",
            "align-items" : "center",
            "justify-content" : "center"
        });
        
    })

    $(".file-paths").on("click", ".path-button", function() {
        const folderUUID = $(this).attr("folderUUID");
        const fileType = $(this).attr("fileType");

        console.log(fileType);

        switch (fileType){
            case "note":
                moveNote(folderUUID, noteUUID);
                return;
        }
    })

    $(".close-move-file-form-button").on("click", function() {
        $(".move-file-container").fadeOut(100);
    })

    getPaths();

    getNote(noteUUID)
})


function getNote(noteUUID) {
    $.ajax({
        type: "GET",
        url: `/server/routers/monomemo/note.route.php?note_uuid=${noteUUID}`,
        data : {type : "single_note"},
        dataType: "json",
        success: function (response) {
            $("#single-note")
                .prepend(
                `
                <a href=${response.note_from ? `/client/pages/monomemo/folder.php?folder_uuid=${response.folder_uuid}` : "/client/pages/monomemo/note.php"}>
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <form id="single-note-form">
                    <textarea name="noteTitle" id="single-note-title" placeholder="No Title">${response.note_title}</textarea>
                    <textarea name="noteContent" id="single-note-content" placeholder="No Content">${response.note_content}</textarea>
                </form>
            `);
        },
    });
}

function updateNote(noteData, noteUUID) {
    $.ajax({
        type : "POST",
        url : `/server/routers/monomemo/note.route.php?note_uuid=${noteUUID}`,
        data : noteData,
        dataType : "json",
        success : function (response) {
            console.log("updated successfully");
        },
        error : function (response) {
            console.log(response);
        }
    })
}

function getPaths() {
    $.ajax({
        type : "GET",
        url : "/server/routers/monomemo/folder.route.php",
        data : {type : "my_folders"},
        dataType : "json",
        success : function(response) {
            const mappedPaths = response.map((data, index) => {
                return `<button class="path-button" folderUUID="${data.folder_uuid}" fileType="note">
                    ${data.folder_name} <i class="fa-solid fa-folder-open"></i>
                    </button>`
            })

            $(".file-paths").append(mappedPaths);
        }
    })
}

function moveNote(folderUUID, noteUUID) {
    $.ajax({
        type : "POST",
        url : `/server/routers/monomemo/move.route.php?note_uuid=${noteUUID}`,
        data : {type : "move_note", folderUUID},
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