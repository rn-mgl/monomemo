jQuery(function () {
  $("#info-container").on("click", "#edit-profile-info-button", function () {
    $("#edit-profile-form-container").fadeIn(100).css({
      display: "flex",
      "align-items": "center",
      "justify-content": "center",
    });

    $.ajax({
      type: "GET",
      url: "/server/routers/monomemo/profile.route.php",
      dataType: "json",
      success: function (response) {
        $("#name").val(response.user_name);
        $("#surname").val(response.user_surname);
      },
    });
  });

  $("#close-edit-profile-form").on("click", function () {
    $("#edit-profile-form-container").fadeOut(100);
  });

  $("#edit-profile-form").on("submit", function (e) {
    e.preventDefault();

    const userData = $(this).serializeArray();
    const mappedUserData = { type: "update_names" };

    jQuery.map(userData, function (data, index) {
      mappedUserData[data.name] = data.value;
    });

    $.ajax({
      type: "POST",
      url: "/server/routers/monomemo/profile.route.php",
      data: mappedUserData,
      dataType: "json",
      success: function (response) {
        if (response.updated) {
          $("#edit-profile-form-container").fadeOut(100);
          getUserData();
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });

  getUserData();
});

const numberToMonth = {
  1: "January",
  2: "February",
  3: "March",
  4: "April",
  5: "May",
  6: "June",
  7: "July",
  8: "August",
  9: "September",
  10: "October",
  11: "November",
  12: "December",
};

function localizeDate(date) {
  const localDate = new Date(date).toLocaleDateString();
  const splitDate = localDate.split("/");
  const month = splitDate[0];
  const day = splitDate[1];
  const year = splitDate[2];

  return `${numberToMonth[month]} ${day}, ${year}`;
}

function getUserData() {
  $.ajax({
    type: "GET",
    url: "/server/routers/monomemo/profile.route.php",
    dataType: "json",
    success: function (response) {
      const profileData = `
        <div class="single-info-container">
            <p class="user-info-title">Name</p>
            <div class="user-info">
              <p>${response.user_name} </p>
              <i class="fa-solid fa-user"></i>
            </div>
        </div>
        <div class="single-info-container">
            <p class="user-info-title">Surname</p>
            <div class="user-info">
              <p class="user-info">${response.user_surname}</p>
              <i class="fa-solid fa-user"></i>
            </div>
        </div>
        <div class="single-info-container">
            <p class="user-info-title">Email</p>
            <div class="user-info">
              <p class="user-info">${response.user_email} </p>
              <i class="fa-solid fa-at"></i>
            </div>
        </div>
        <div class="single-info-container">
            <p class="user-info-title">Date Joined</p>
            <div class="user-info">
              <p class="user-info">${localizeDate(response.date_joined)}</p>
              <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>
        <button id="edit-profile-info-button">Edit</button>
        `;

      $("#info-container").html(profileData);
    },
  });
}
