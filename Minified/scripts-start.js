$(document).ready(function () {
    function t(t, e, i) {
        var o;
        return function () {
            var r = this,
                n = arguments,
                s = function () {
                    (o = null), i || t.apply(r, n);
                },
                a = i && !o;
            clearTimeout(o), (o = setTimeout(s, e)), a && t.apply(r, n);
        };
    }
    function e() {
        $(".step1-li").addClass("step-finished-text"), $(".step1-arrow img").attr("src", w), $(".step1-cloud img").attr("src", m), (p = !0);
    }
    function i() {
        $(".step2-li").addClass("step-finished-text"), $(".step2-arrow img").attr("src", w), $(".step2-cloud img").attr("src", m), (h = !0);
    }
    function o() {
        $(".step3-li").addClass("step-finished-text"), $(".step3-arrow img").attr("src", w), $(".step3-cloud img").attr("src", m), (u = !0);
    }
    function r() {
        $(".step4-li").addClass("step-finished-text"), $(".step4-arrow img").attr("src", w), $(".step4-cloud img").attr("src", m), (f = !0);
    }
    function n() {
        $(".step1").show(), $(".step2").hide(), $(".step3").hide(), $(".step4").hide(), $(".step5").hide();
    }
    function s() {
        $(".step1").hide(), $(".step2").show(), $(".step3").hide(), $(".step4").hide(), $(".step5").hide();
    }
    function a() {
        $(".step1").hide(), $(".step2").hide(), $(".step3").show(), $(".step4").hide(), $(".step5").hide();
    }
    function l() {
        $(".step1").hide(), $(".step2").hide(), $(".step3").hide(), $(".step4").show(), $(".step5").hide();
    }
    function d() {
        $(".step1").hide(), $(".step2").hide(), $(".step3").hide(), $(".step4").hide(), $(".step5").show();
    }
    function c(t) {
        "connected" === t.status && FB.api("/me", { fields: "id,first_name,last_name,email" }, function (t) {});
    }
    var p = !1,
        h = !1,
        u = !1,
        f = !1,
        g = !1,
        m = "images/cloud-finished.png",
        w = "images/arrow-finished.png";
    $(".step1-input").keyup(function () {
        var t = this.value.length;
        t >= 100 ? ((this.value = this.value.substring(0, 100)), $(".left-symbols").text(0)) : $(".left-symbols").text(100 - t);
    }),
        $(".step1-btn").click(function () {
            "" == $.trim($("input[name='title']").val()) ? ($(".start-petition-error").hide(), $('<div class="start-petition-error"> Please write a title.</div>').insertAfter(".step1-input")) : ($(".start-petition-error").hide(), s(), e());
        }),
        $(".step2-btn").click(function () {
            "" == $.trim($("input[name='target']").val())
                ? ($(".start-petition-error").hide(), $('<div class="start-petition-error"> Please write petition target.</div>').insertAfter(".step2-input"))
                : ($(".start-petition-error").hide(), a(), i());
        }),
        $(".step3-btn").click(function () {
            "" == $.trim($(".start-petition-textarea").val())
                ? ($(".start-petition-error").hide(), $('<div class="start-petition-error"> Please write a description.</div>').insertAfter(".step3-input"))
                : ($(".start-petition-error").hide(), l(), o());
        }),
        $(".step4-btn").click(function () {
            "default" == $(".category-select-start").val()
                ? ($(".start-petition-error").hide(), $('<div class="start-petition-error"> Please select a category.</div>').insertAfter(".category-select-start"))
                : ($(".start-petition-error").hide(), d(), r());
        }),
        $(".step1-li").click(function () {
            n();
        }),
        $(".step2-li").click(function () {
            1 == p && s();
        }),
        $(".step3-li").click(function () {
            1 == h && a();
        }),
        $(".step4-li").click(function () {
            1 == u && l();
        }),
        $(".step5-li").click(function () {
            1 == f && d();
        }),
        $(".upload-image-btn").click(function () {
            $(".upload-image-input").click();
        }),
        $(".image-cancel").click(function () {
            $(".upload-image-input").val(""), $(".image-wrapper").hide(), $(".start-petition-add-image-title-icon").show(), $(".start-petition-add-image-title").show(), $(".image-cancel").hide();
        }),
        $(".start-petition-btn-submit").click(
            t(function () {
                if ("" == $.trim($("input[name='title']").val())) return $(".start-petition-error").hide(), $('<div class="start-petition-error"> Please write a title.</div>').insertAfter(".step1-input"), void n();
                if ((0 == p && e(), "" == $.trim($("input[name='target']").val()))) return $(".start-petition-error").hide(), $('<div class="start-petition-error"> Please write petition target.</div>').insertAfter(".step2-input"), void s();
                if ((0 == h && i(), "" == $.trim($(".start-petition-textarea").val())))
                    return $(".start-petition-error").hide(), $('<div class="start-petition-error"> Please write a description.</div>').insertAfter(".step3-input"), void a();
                if ((0 == u && o(), "default" == $(".category-select-start").val()))
                    return $(".start-petition-error").hide(), $('<div class="start-petition-error"> Please select a category.</div>').insertAfter(".category-select-start"), void l();
                0 == f && r();
                var t = $("#start-a-petition-form")[0],
                    d = new FormData(t);
                $.ajax({
                    url: "creating_the_petition.php",
                    data: d,
                    type: "POST",
                    contentType: !1,
                    processData: !1,
                    beforeSend: function () {
                        $(".start-petition-btn-submit").hide(), $(".start-petition-add-image").after("<div class='loader-holder'><div class='loader' style='float: right;'></div></div>");
                    },
                })
                    .done(function (t) {
                        "Error" != t && "Error folder exists" != t && "Not logged in" != t
                            ? (location.href = t)
                            : ($(".start-petition-btn-submit").show(),
                              $(".loader-holder").hide(),
                              "Not logged in" == t
                                  ? ((g = !0), $(".modal").show(), $(".modal-content").show(), $(".join-page-holder").show(), $(".login-page-holder").hide(), $(".forgot-pass-holder").hide())
                                  : "Error folder exists" == t
                                  ? ($(".start-petition-error").hide(),
                                    $(".modal").hide(),
                                    $('<div class="start-petition-error"> There is already a petition with the exact same title. Please write another title.</div>').insertAfter(".step1-input"),
                                    n())
                                  : ($(".start-petition-error").hide(), $(".modal").hide(), $('<div class="start-petition-error"> Please fill out all fields.</div>').insertAfter(".step1-input"), n()));
                    })
                    .fail(function () {});
            }, 1e3)
        ),
        $("#btnLogin").click(
            t(function () {
                "" == $.trim($("input[name='emailLogin']").val()) || "" == $.trim($("input[name='passwordLogin']").val())
                    ? ($(".show-error-login").text("Please fill out all fields."), $(".show-error-login").hide(), $(".show-error-login").fadeIn(500))
                    : $.ajax({ url: "/loginRequest.php", type: "POST", data: $("#login-form").serialize() })
                          .done(function (t) {
                              "Success" == t ? $(".start-petition-btn-submit").click() : ($(".show-error-login").text(t), $(".show-error-login").hide(), $(".show-error-login").fadeIn(500));
                          })
                          .fail(function () {
                              $(".show-error-login").text("Please contact administrators."), $(".show-error-login").hide(), $(".show-error-login").fadeIn(500);
                          });
            }, 1e3)
        ),
        $("#btnJoin").click(
            t(function () {
                "" == $.trim($("input[name='firstNameJoin']").val()) || "" == $.trim($("input[name='lastNameJoin']").val()) || "" == $.trim($("input[name='emailJoin']").val()) || "" == $.trim($("input[name='passwordJoin']").val())
                    ? ($(".show-error-join").text("Please fill out all fields."), $(".show-error-join").hide(), $(".show-error-join").fadeIn(500))
                    : $.ajax({ url: "/joinRequest.php", type: "POST", data: $("#reg-form").serialize() })
                          .done(function (t) {
                              "Success" == t ? $(".start-petition-btn-submit").click() : ($(".show-error-join").text(t), $(".show-error-join").hide(), $(".show-error-join").fadeIn(500));
                          })
                          .fail(function () {
                              $(".show-error-join").text("There has been troubles. Please contact the administators!"), $(".show-error-join").hide(), $(".show-error-join").fadeIn(500);
                          });
            }, 1e3)
        ),
        (window.fbAsyncInit = function () {
            FB.init({ appId: "1411923905492915", cookie: !0, xfbml: !0, version: "v2.8" }),
                FB.getLoginStatus(function (t) {
                    c(t);
                }),
                $(".logoutBtn").click(function () {
                    FB.logout(function (t) {});
                }),
                $(".connect-with-fb-btn").click(function () {
                    FB.login(
                        function (t) {
                            t.authResponse &&
                                FB.api("/me", { fields: "id,first_name,last_name,email" }, function (t) {
                                    $.ajax({
                                        type: "POST",
                                        url: "/facebookRequest.php",
                                        data: { email: t.email, firstName: t.first_name, lastName: t.last_name },
                                        beforeSend: function () {
                                            $(".connect-with-fb-btn").hide(), $(".login-page-title-secondary").after("<div class='loader' style='margin-top: 10px; margin-bottom: 10px;'></div>");
                                        },
                                    })
                                        .done(function (t) {
                                            "Success" == t
                                                ? $(".start-petition-btn-submit").click()
                                                : "Email not provided" == t &&
                                                  ($(".connect-with-fb-btn").show(),
                                                  $(".loader").hide(),
                                                  $(".show-error-login").text("You cannot sign up for signandshare.org using your Facebook account without providing your email address."),
                                                  $(".show-error-login").fadeIn(),
                                                  $(".show-error-join").text("You cannot sign up for signandshare.org using your Facebook account without providing your email address."),
                                                  $(".show-error-join").fadeIn());
                                        })
                                        .fail(function () {
                                            console.log("FAILED");
                                        });
                                });
                        },
                        { scope: "email" }
                    );
                });
        }),
        (function (t, e, i) {
            var o,
                r = t.getElementsByTagName(e)[0];
            t.getElementById(i) || ((o = t.createElement(e)), (o.id = i), (o.src = "//connect.facebook.net/en_US/sdk.js"), r.parentNode.insertBefore(o, r));
        })(document, "script", "facebook-jssdk"),
        $(".button-trigger-login").click(function () {
            $(".modal").show(), $(".modal-content").show(), $(".login-page-holder").show(), $(".join-page-holder").hide(), $(".forgot-pass-holder").hide();
        }),
        $(".button-trigger-join").click(function () {
            $(".modal").show(), $(".modal-content").show(), $(".join-page-holder").show(), $(".login-page-holder").hide(), $(".forgot-pass-holder").hide();
        }),
        $(".modal, .close").click(function () {
            $(".modal").hide(), $(".modal-content").hide(), $(".login-page-holder").hide(), $(".join-page-holder").hide(), $(".forgot-pass-holder").hide();
        }),
        $(".modal-content").click(function () {
            event.stopPropagation();
        }),
        $(".forgot-pass-q").click(function () {
            $(".forgot-pass-holder").show(), $(".login-page-holder").hide();
        }),
        $(".back-to-login").click(function () {
            $(".forgot-pass-holder").hide(), $(".login-page-holder").show();
        }),
        $(".reset-password").click(
            t(function () {
                var t = $(".forgot-pass-input").val();
                $.ajax({
                    url: "/setPassRequest.php",
                    type: "POST",
                    data: { email: t },
                    beforeSend: function () {
                        $(".reset-password").before("<div class='loader' style='margin-top: 29px; margin-left: 0px; margin-right: 0px; float: right;'></div>"), $(".reset-password").hide();
                    },
                })
                    .done(function (t) {
                        "Success" == t
                            ? ($(".forgot-pass-text").text(
                                  "An email with a link to reset your password has been sent to " + $(".forgot-pass-input").val() + ". For security purposes, the password reset link you have been sent will only work for the next 2 hours."
                              ),
                              $(".forgot-pass-input").hide(),
                              $("<img alt src='/images/cloud-finished.png' style='width: 37px; float: right; margin-top: 35px;'>").insertBefore(".reset-password"),
                              $(".loader").hide())
                            : ($(".loader").hide(), $(".forgot-pass-text").text(t), $(".reset-password").show());
                    })
                    .fail(function () {
                        $(".loader").hide(), $(".forgot-pass-text").text("There has been some error. Please try again."), $(".reset-password").show();
                    });
            }, 500)
        ),
        $(".dropdownBtn").click(function () {
            $(".dropdown-content").toggle();
        }),
        $(".mobile-header-menu").click(function () {
            $(".header-menu-dropdown-menu").toggle(), $(".header-menu-dropdown-user").hide();
        }),
        $(".mobile-header-menu-user").click(function () {
            $(".header-menu-dropdown-user").toggle(), $(".header-menu-dropdown-menu").hide();
        }),
        $(".logoutBtn").click(function () {
            $.ajax({
                url: "logout.php",
                success: function () {
                    var t = window.location.href;
                    window.location.href = t;
                },
            });
        });
});
