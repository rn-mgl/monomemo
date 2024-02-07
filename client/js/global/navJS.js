jQuery(function () {
  $.ajax({
    type: "GET",
    url: "/server/routers/global/nav.route.php",
    dataType: "json",
    success: function (response) {
      const userData = response;
      const profile = `
      <a href="/client/pages/monomemo/profile.php" id="name-image-container">
        <div id="profile-image"></div>
        <p id="profile-name">${userData.user_name} ${userData.user_surname} </p>
      </a>
      `;

      $("#profile-actions-container").prepend(profile);
    },
  });

  $("#profile-button").on("click", function () {
    $("#profile-actions-container").fadeToggle(100).css({
      display: "flex",
      "align-items": "center",
      "justify-content": "center",
    });
  });

  $("#logout").on("click", function () {
    $.ajax({
      type: "POST",
      url: "/server/routers/auth/logout.route.php",
      dataType: "json",
      success: function (response) {
        if (response.status) {
          window.location.href = "/client/pages/index.php";
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });
});
