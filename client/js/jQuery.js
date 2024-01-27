$(document).ready(function ()  {
    $window = $(window);

    $("#sidenav-close-button").on("click", function ()  {
        $sidenav = $("#sidenav");
        $sidenav.animate({left : "-=100vw"}, 100)
    })

    $("#sidenav-open-button").on("click", function ()  {
        $sidenav = $("#sidenav");
        $sidenav.animate({left : "+=100vw"}, 100)
    })

    $(".sidenav-link").each(function () {
        const url = window.location.href;
        const linkURL = $(this).find("a").attr("href");
        if (url.includes(linkURL)) {
            $(this).toggleClass("selected");
        }
    }) 

    $(".sidenav-link").on("click", function () {
        $(".sidenav-link").removeClass("selected");
        $(this).toggleClass("selected");
    })

})

