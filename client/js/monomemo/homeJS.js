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
})