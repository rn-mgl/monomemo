jQuery(function () {
  $("#forgot-form").on("submit", function (e) {
    e.preventDefault();

    const forgotData = $(this).serializeArray();
    const mappedForgotdata = {};

    jQuery.map(forgotData, function (data, index) {
      mappedForgotdata[data.name] = data.value;
    });

    $.ajax({
      type: "POST",
      url: "/server/routers/auth/forgot.route.php",
      data: mappedForgotdata,
      dataType: "json",
      success: function (response) {
        if (response.status) {
          window.location.href = "/client/pages/sending.php";
        }
      },
    });
  });
});
