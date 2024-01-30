jQuery(function() {
    const params = new URLSearchParams(window.location.search)
    if (!params.has("note_uuid")) {
        window.location.href = "/client/pages/monomemo/home.php"
    }
    const noteUUID = params.get("note_uuid");
    getNote(noteUUID)
})


function getNote(noteUUID) {
    $.ajax({
        type: "GET",
        url: `/server/routers/monomemo/note.route.php?note_uuid=${noteUUID}`,
        data : {type : "single_note"},
        dataType: "json",
        success: function (response) {
            console.log(response);
            $("#single-note")
                .html(
                `
                <div id="single-note-wrapper">
                    <textarea id="single-note-title" placeholder="No Title">${response.note_title}</textarea>
                    <textarea id="single-note-content" placeholder="No Content">${response.note_content}</textarea>
                </div>
                `);
        },
    });
}