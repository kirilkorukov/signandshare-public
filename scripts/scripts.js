$(document).ready(function() {
    $(".dropdownBtn").click(function(){
        $(".dropdown-content").toggle();
    });

    $(".mobile-header-menu").click(function(){
        $(".header-menu-dropdown-menu").toggle();
        $(".header-menu-dropdown-user").hide();
    });

    $(".mobile-header-menu-user").click(function(){
        $(".header-menu-dropdown-user").toggle();
        $(".header-menu-dropdown-menu").hide();
    });

        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };

        $(".sign-petition-mobile-btn").click(function(){
            $(".left-column").hide();
            $(".petition-mobile-holder").fadeIn(200);
            $("html, body").animate({ scrollTop: 0 }, "slow");
        });

        $(".petition-mobile-go-back").click(function(){
            $(".petition-mobile-holder").hide();
            $(".left-column").fadeIn(200);
            $(".sign-petition-mobile-btn").show();
            $("html, body").animate({ scrollTop: 0 }, "slow");
        });

        $(window).on('resize', function(){
           if($(this).width() > 723){
                $(".left-column").show();
                $(".petition-mobile-holder").hide();
                $(".sign-petition-mobile-btn").hide();
           }
           else{
                $(".sign-petition-mobile-btn").show();
           }
        });

        $('#btnLogin').click(debounce(function(){
            if($.trim($("input[name='emailLogin']").val()) == "" || $.trim($("input[name='passwordLogin']").val()) == ""){
                $(".show-error-login").text("Please fill out all fields.");
                $(".show-error-login").hide();
                $(".show-error-login").fadeIn(500);
            }
            else{
                $.ajax({
                    url: '/loginRequest.php',
                    type: 'POST',
                    data: $("#login-form").serialize()
                })
                    .done(function(result){
                        if(result == "Success"){
                            var url = window.location.href;
                            location.href = url;
                        }
                        else{
                            $(".show-error-login").text(result);
                            $(".show-error-login").hide();
                            $(".show-error-login").fadeIn(500);
                        }
                    })
                    .fail(function(){
                        $(".show-error-login").text("Please contact administrators.");
                        $(".show-error-login").hide();
                        $(".show-error-login").fadeIn(500);
                    });
            }
        }, 500));

        $('#btnJoin').click(debounce(function(){
            if($.trim($("input[name='firstNameJoin']").val()) == "" || $.trim($("input[name='lastNameJoin']").val()) == "" || $.trim($("input[name='emailJoin']").val()) == "" || $.trim($("input[name='passwordJoin']").val()) == ""){
                    $(".show-error-join").text("Please fill out all fields.");
                    $(".show-error-join").hide();
                    $(".show-error-join").fadeIn(500);
            }
            else{
              $.ajax({
                  url: '/joinRequest.php',
                  type: 'POST',
                  data: $("#reg-form").serialize()
              })
                  .done(function(result){
                      if(result == "Success"){
                            var url = window.location.href;
                            location.href = url;
                      }
                      else{
                          $(".show-error-join").text(result);
                          $(".show-error-join").hide();
                          $(".show-error-join").fadeIn(500);
                      }
                  })
                  .fail(function(){
                        $(".show-error-join").text("There has been troubles. Please contact the administators!");
                        $(".show-error-join").hide();
                        $(".show-error-join").fadeIn(500);
                  });
            }
        }, 500));

        $(".button-trigger-login").click(function(){
            $(".modal").fadeIn(200);
            $(".modal-content").fadeIn(500);
            $(".login-page-holder").show();
            $(".join-page-holder").hide();
            $(".forgot-pass-holder").hide();
        });

         $(".button-trigger-join").click(function(){
            $(".modal").fadeIn(200);
            $(".modal-content").fadeIn(500);
            $(".join-page-holder").show();
            $(".login-page-holder").hide();
            $(".forgot-pass-holder").hide();
        });

        $(".modal, .close").click(function(){
            $(".modal").fadeOut(200);
            $(".modal-content").fadeOut(500);
            $(".login-page-holder").hide();
            $(".join-page-holder").hide();
            $(".forgot-pass-holder").hide();
        });

        $(".modal-content").click(function(){
            event.stopPropagation();
        });

        $(".forgot-pass-q").click(function(){
            $(".forgot-pass-holder").show();
            $(".login-page-holder").hide();
        });

        $(".back-to-login").click(function(){
            $(".forgot-pass-holder").hide();
            $(".login-page-holder").show();
        });

        $(".reset-password").click(debounce(function () {
            var emailAddress = $(".forgot-pass-input").val();
            $.ajax({
                url: '/resetPassRequest.php',
                type: 'POST',
                data: {email : emailAddress},
                beforeSend: function(){
                    $(".reset-password").before("<div class='loader' style='margin-top: 29px; margin-left: 0px; margin-right: 0px; float: right;'></div>");
                    $(".reset-password").hide();
                }
            })
                .done(function(result){
                    if(result == "Success"){
                        $(".forgot-pass-text").text("An email with a link to reset your password has been sent to " + $(".forgot-pass-input").val() + ". For security purposes, the password reset link you have been sent will only work for the next 2 hours.");
                        $(".forgot-pass-input").hide();
                        $("<img alt src='/images/cloud-finished.png' style='width: 37px; float: right; margin-top: 35px;'>").insertBefore(".reset-password");
                        $(".loader").hide();
                    }
                    else{
                        $(".loader").hide();
                        $(".forgot-pass-text").text(result);
                        $(".reset-password").show();
                    }
                })
                .fail(function(){
                    $(".loader").hide();
                    $(".forgot-pass-text").text("There has been some error. Please try again.");
                    $(".reset-password").show();
                });
        }, 500));

        $(".logoutBtn").click(function(){
            $.ajax({
                url: '/logout.php',
                success: function(){
                    var url = window.location.href;
                    window.location.href = url;
                }
            });
        });
});
