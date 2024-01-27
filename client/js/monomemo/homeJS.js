jQuery(function() {
    $.ajax({
        type: "GET",
        async: true,
        url: "/server/routers/monomemo/home.route.php",
        dataType: "html",
        success: function (response) {
            $("#container").html(response)
        }
    });
})