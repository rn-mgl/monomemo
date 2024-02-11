jQuery(function () {
  $("#renew-form").on("submit", function (e) {
    e.preventDefault();
    const param = new URLSearchParams(window.location.search);
    const token = param.get("reset_token");

    if (!token) {
      return;
    }

    const renewData = $(this).serializeArray();
    const mappedRenewData = { token };

    jQuery.map(renewData, function (data, index) {
      mappedRenewData[data.name] = data.value;
    });

    $.ajax({
      type: "POST",
      url: "/server/routers/auth/renew.route.php",
      data: mappedRenewData,
      dataType: "json",
      success: function (response) {
        if (response.updated) {
          window.location.href = "/client/pages/auth/login.php";
        } else {
          window.location.href = "/client/pages/auth/login.php";
        }
      },
      error: function (response) {
        window.location.href = "/client/pages/auth/login.php";
      },
    });
  });
});
