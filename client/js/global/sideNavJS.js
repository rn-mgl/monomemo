jQuery(function () {
  $window = $(window);

  $.ajax({
    type: "GET",
    url: "/server/routers/global/sidenav.route.php",
    dataType: "json",
    success: function (response) {
      const userData = response;
      $("#greetings-container").html(`
                <p>
                    Welcome,
                </p>
                <p>
                    <b class="text-green-gradient">${userData.user_name} ${userData.user_surname}</b>
                </p>
            `);
    },
  });

  $("#sidenav-close-button").on("click", function () {
    $sidenav = $("#sidenav");
    $sidenav.animate({ left: "-=100vw" }, 100);
  });

  $("#sidenav-open-button").on("click", function () {
    $sidenav = $("#sidenav");
    $sidenav.animate({ left: "0" }, 100);
  });

  $(".sidenav-link").each(function () {
    const url = window.location.href;
    const linkURL = $(this).attr("href");
    if (url.includes(linkURL)) {
      $(this).toggleClass("navlink-selected");
    }
  });

  $(".sidenav-link").on("click", function () {
    $(".sidenav-link").removeClass("navlink-selected");
    $(this).toggleClass("navlink-selected");
  });
});
