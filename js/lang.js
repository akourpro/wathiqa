$(document).ready(function () {
  languCookies = Cookies.get("lang");
  if (!languCookies) {
    Cookies.set("lang", "ar", {
      secure: false,
      sameSite: "",
      expires: 365,
    });
  }
  $(document).on("click", ".lango", function () {
    lango = $(this).attr("id");
    if (lango == "ar") {
      Cookies.set("lang", "ar", {
        secure: false,
        sameSite: "",
        expires: 365,
      });
    }
    if (lango == "en") {
      Cookies.set("lang", "en", {
        secure: false,
        sameSite: "",
        expires: 365,
      });
    }
    if ((lango != "ar") & (lango != "en")) {
      Cookies.set("lang", "ar", {
        secure: false,
        sameSite: "",
        expires: 365,
      });
    }
    location.reload(true);
  });
});
