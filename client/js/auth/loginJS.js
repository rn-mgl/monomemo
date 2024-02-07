jQuery(function () {
  $("#login-form").on("submit", function (e) {
    e.preventDefault();

    const loginData = $(this).serializeArray();
    const mappedLoginData = {};

    jQuery.map(loginData, function (data, index) {
      mappedLoginData[data.name] = data.value;
    });

    $.ajax({
      type: "POST",
      url: "/server/routers/auth/login.route.php",
      data: mappedLoginData,
      dataType: "json",
      success: function (response) {
        if (response.status) {
          window.location.href = "/client/pages/monomemo/home.php";
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });
});
