jQuery(function() {
    $("#create-note-form").on("submit", function(e) {
        e.preventDefault()
        const $noteData = $(this).serializeArray()
        const mappedNoteData = {};

        jQuery.map($noteData, function(data, index) {
            mappedNoteData[data.name] = data.value;
        })
        createNote(mappedNoteData);
    })

    getNotes()
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