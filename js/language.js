 // language file
        languCookies = Cookies.get("lang");
        if (!languCookies) {
            Cookies.set("lang", "ar", {
                secure: true,
                sameSite: "strict"
            });
            languCookies = "ar";
        }
        if (languCookies == "en") {
            languFile = "enjs.php";
        } else {
            languFile = "arjs.php";
        }
        var langu;
        $.ajax({
            url: "../includes/lang/" + languFile,
            dataType: "json",
            async: false,
            dataType: "json",
            success: function(languSrc) {
                langu = languSrc;
            },
        });