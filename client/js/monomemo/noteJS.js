jQuery(function() {
    const params = new URLSearchParams(window.location.search)
    if (!params.has("note_uuid")) {
        window.location.href = "/client/pages/monomemo/home.php"
    }
    const noteUUID = params.get("note_uuid");

    $("#single-note").on("input", "#single-note-form", function(e) {
        setTimeout(() => {
            const noteTitle = $("#single-note-title").val();
            const noteContent = $("#single-note-content").val();
            const noteData = {type : "update_note", noteTitle, noteContent};
            updateNote(noteData, noteUUID)
        }, [400])
    })

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
                .html(
                `
                <a href=${response.note_from ? `/client/pages/monomemo/folder.php?folder_uuid=${response.folder_uuid}` : "/client/pages/monomemo/note.php"}>
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <form id="single-note-form">
                    <textarea id="single-note-title" placeholder="No Title">${response.note_title}</textarea>
                    <textarea id="single-note-content" placeholder="No Content">${response.note_content}</textarea>
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