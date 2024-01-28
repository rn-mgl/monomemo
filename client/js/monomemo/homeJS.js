jQuery(function() {
    $.ajax({
        type: "GET",
        url: "/server/routers/monomemo/home.route.php",
        dataType: "json",
        success: function (response) {
            console.log(JSON.parse(response));
        },
    });

    $("#plus-button").on("click", function() {
        this.animate({rotate : "90deg"}, 100);
        $(this).toggleClass("add-button-selected");
        $(".file-button").each(function(index, $button) {
            $(this).slideToggle((index + 1) * 50)
        })
    })
})