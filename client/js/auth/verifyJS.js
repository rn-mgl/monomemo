jQuery(function () {
  $("#verify-form").on("submit", function (e) {
    e.preventDefault();

    const verifyData = $(this).serializeArray();
    const mappedVerifyData = {};

    jQuery.map(verifyData, function (data, index) {
      mappedVerifyData[data.name] = data.value;
    });

    $.ajax({
      type: "POST",
      url: "/server/routers/auth/verify.route.php",
      data: verifyData,
      dataType: "json",
      success: function (response) {
        if (response.status) {
          window.location.href = "/client/pages/auth/login.php";
        } else {
          window.location.reload();
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });
});
