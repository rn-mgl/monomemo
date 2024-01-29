jQuery(function() {
    $("#create-note-form").on("submit", function(e) {
        e.preventDefault()
        const $noteData = $(this).serializeArray()
        const mappedNoteData = {};

        jQuery.map($noteData, function(data, index) {
            mappedNoteData[data.name] = data.value;
        })
        
        $.ajax({
            type: "POST",
            url: "/server/routers/monomemo/note.route.php",
            data: mappedNoteData,
            dataType: "json",
            success: function (response) {
                $(".file-form-container, .create-file-form").fadeOut(100);
                $(".file-container").html(response.map(data => {
                    console.log(data);
                    return `<h1>${data.note_title}</h1>`
                }))
            },
            error: function (response) {
                console.log(response);
            },
        });
    })
})