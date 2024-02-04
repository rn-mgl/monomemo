jQuery(function() {
    $("#move-note-button").on("click", function() {
        $(".move-file-container")
        .fadeIn(100)
        .css({
            display : "flex",
            "align-items" : "center",
            "justify-content" : "center"
        });
        
    })

    $(".close-move-file-form-button").on("click", function() {
        $(".move-file-container").fadeOut(100);
    })

    getPaths();
})

function getPaths() {
    $.ajax({
        type : "GET",
        url : "/server/routers/monomemo/folder.route.php",
        data : {type : "my_folders"},
        dataType : "json",
        success : function(response) {
            const mappedPaths = response.map((data, index) => {
                return `<button class="path-button">${data.folder_name} <i class="fa-solid fa-folder-open"></i></button>`
            })

            $(".file-paths").append(mappedPaths);
        }
    })
}