jQuery(function () {
  $("#signup-form").on("submit", function (e) {
    e.preventDefault();

    const signupData = $(this).serializeArray();
    const mappedSignupData = {};

    jQuery.map(signupData, function (data, index) {
      mappedSignupData[data.name] = data.value;
    });

    $.ajax({
      type: "POST",
      url: "/server/routers/auth/signup.route.php",
      data: mappedSignupData,
      dataType: "json",
      success: function (response) {
        if (response.status) {
          window.location.href = "/client/pages/auth/verify.php";
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });
});
