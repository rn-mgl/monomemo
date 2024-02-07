jQuery(function () {
  $.ajax({
    type: "GET",
    url: "/server/routers/monomemo/profile.route.php",
    dataType: "json",
    success: function (response) {
      console.log(response);

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
        `;

      $("#info-container").html(profileData);
    },
  });
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
