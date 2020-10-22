    $(document).ready(function() {
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

        var firstStep = false;
        var secondStep = false;
        var thirdStep = false;
        var forthStep = false;
        var isPetitionSubmitted = false;
        var srcBalloon = "images/cloud-finished.png";
        var srcArrow = "images/arrow-finished.png";

        $(".step1-input").keyup(function(){
            var len = this.value.length;
            if (len >= 100) {
                this.value = this.value.substring(0, 100);
                $('.left-symbols').text(0);
            }
            else{
                $('.left-symbols').text(100 - len);
            }
        });

        function showFirstStepBalloon() {
            $(".step1-li").addClass("step-finished-text");
            $(".step1-arrow img").attr("src",srcArrow);
            $(".step1-cloud img").attr("src",srcBalloon);

            firstStep = true;
        }

        function showSecondStepBalloon() {
            $(".step2-li").addClass("step-finished-text");
            $(".step2-arrow img").attr("src",srcArrow);
            $(".step2-cloud img").attr("src",srcBalloon);

            secondStep = true;
        }

        function showThirdStepBalloon() {
            $(".step3-li").addClass("step-finished-text");
            $(".step3-arrow img").attr("src",srcArrow);
            $(".step3-cloud img").attr("src",srcBalloon);

            thirdStep = true;
        }

        function showForthStepBalloon() {
            $(".step4-li").addClass("step-finished-text");
            $(".step4-arrow img").attr("src",srcArrow);
            $(".step4-cloud img").attr("src",srcBalloon);

            forthStep = true;
        }

        function showFirstStep() {
            $(".step1").show();
            $(".step2").hide();
            $(".step3").hide();
            $(".step4").hide();
            $(".step5").hide();
        }

        function showSecondStep() {
            $(".step1").hide();
            $(".step2").show();
            $(".step3").hide();
            $(".step4").hide();
            $(".step5").hide();
        }

        function showThirdStep() {
            $(".step1").hide();
            $(".step2").hide();
            $(".step3").show();
            $(".step4").hide();
            $(".step5").hide();
        }

        function showForthStep() {
            $(".step1").hide();
            $(".step2").hide();
            $(".step3").hide();
            $(".step4").show();
            $(".step5").hide();
        }

        function showFifthStep() {
            $(".step1").hide();
            $(".step2").hide();
            $(".step3").hide();
            $(".step4").hide();
            $(".step5").show();
        }

        $(".step1-btn").click(function() {
            if($.trim($("input[name='title']").val()) == ""){
                $(".start-petition-error").hide();
                $('<div class="start-petition-error"> Please write a title.</div>').insertAfter(".step1-input");
            }
            else{
                $(".start-petition-error").hide();
                showSecondStep();
                showFirstStepBalloon();
            }
        });
        $(".step2-btn").click(function() {
            if($.trim($("input[name='target']").val()) == ""){
                $(".start-petition-error").hide();
                $('<div class="start-petition-error"> Please write petition target.</div>').insertAfter(".step2-input");
            }
            else{
                $(".start-petition-error").hide();
                showThirdStep();
                showSecondStepBalloon();
            }
        });
        $(".step3-btn").click(function() {
            if($.trim($(".start-petition-textarea").val()) == ""){
                $(".start-petition-error").hide();
                $('<div class="start-petition-error"> Please write a description.</div>').insertAfter(".step3-input");
            }
            else{
                $(".start-petition-error").hide();
                showForthStep();
                showThirdStepBalloon();
            }
        });
        $(".step4-btn").click(function() {
            if($(".category-select-start").val() == "default"){
                $(".start-petition-error").hide();
                $('<div class="start-petition-error"> Please select a category.</div>').insertAfter(".category-select-start");
            }
            else{
                $(".start-petition-error").hide();
                showFifthStep();
                showForthStepBalloon();
            }
        });

        $(".step1-li").click(function() {
            showFirstStep();
        });

        $(".step2-li").click(function() {
            if(firstStep == true){
                showSecondStep();
            }
        });

        $(".step3-li").click(function() {
            if(secondStep == true){
                showThirdStep();
            }
        });

        $(".step4-li").click(function() {
            if(thirdStep == true){
                showForthStep();
            }
        });

        $(".step5-li").click(function() {
            if(forthStep == true){
                showFifthStep();
            }
        });

        $(".upload-image-btn").click(function(){
            $(".upload-image-input").click();
        });

        $(".image-cancel").click(function(){
            $('.upload-image-input')
                .val("");
            $('.image-wrapper')
                .hide();
            $(".start-petition-add-image-title-icon")
                .show();
            $(".start-petition-add-image-title")
                .show();
            $(".image-cancel")
                .hide();
        });

        $('.start-petition-btn-submit').click(debounce(function(){
            if($.trim($("input[name='title']").val()) == ""){
                $(".start-petition-error").hide();
                $('<div class="start-petition-error"> Please write a title.</div>').insertAfter(".step1-input");

                showFirstStep();
                return;
            }
            else{
                if(firstStep == false){
                    showFirstStepBalloon();
                }
            }

            if($.trim($("input[name='target']").val()) == ""){
                $(".start-petition-error").hide();
                $('<div class="start-petition-error"> Please write petition target.</div>').insertAfter(".step2-input");

                showSecondStep();
                return;
            }
            else{
                if(secondStep == false){
                    showSecondStepBalloon();
                }
            }

            if($.trim($(".start-petition-textarea").val()) == ""){
                $(".start-petition-error").hide();
                $('<div class="start-petition-error"> Please write a description.</div>').insertAfter(".step3-input");

                showThirdStep();
                return;
            }
            else{
                if(thirdStep == false){
                    showThirdStepBalloon();
                }
            }

            if($(".category-select-start").val() == "default"){
                $(".start-petition-error").hide();
                $('<div class="start-petition-error"> Please select a category.</div>').insertAfter(".category-select-start");

                showForthStep();
                return;
            }
            else{
                if(forthStep == false){
                    showForthStepBalloon();
                }
            }

            var form = $('#start-a-petition-form')[0]; // You need to use standart javascript object here
            var formData = new FormData(form);
            $.ajax({
                url: 'creating_the_petition.php',
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".start-petition-btn-submit").hide();
                    $(".start-petition-add-image").after("<div class='loader-holder'><div class='loader' style='float: right;'></div></div>");
                }
            })
                .done(function(result){
                    if(result != "Error" && result != "Error folder exists" && result != "Not logged in"){
                        location.href = result;
                    }
                    else{
                        $(".start-petition-btn-submit").show();
                        $( ".loader-holder" ).hide();

                        if(result == "Not logged in"){
                            isPetitionSubmitted = true;
                            $(".modal").show();
                            $(".modal-content").show();
                            $(".join-page-holder").show();
                            $(".login-page-holder").hide();
                            $(".forgot-pass-holder").hide();
                        }
                        else{
                            if(result == "Error folder exists"){
                                $(".start-petition-error").hide();
                                $(".modal").hide();
                                $('<div class="start-petition-error"> There is already a petition with the exact same title. Please write another title.</div>').insertAfter(".step1-input");

                                showFirstStep();
                            }
                            else{
                                $(".start-petition-error").hide();
                                $(".modal").hide();
                                $('<div class="start-petition-error"> Please fill out all fields.</div>').insertAfter(".step1-input");

                                showFirstStep();
                            }
                        }
                    }
                })
                .fail(function(){
                });
        }, 1000));

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
                            $('.start-petition-btn-submit').click();
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
        }, 1000));

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
                            $('.start-petition-btn-submit').click();
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
        }, 1000));

        function statusChangeCallback(response) {
            if (response.status === 'connected') {
                FB.api('/me', {fields: 'id,first_name,last_name,email'}, function(response) {});
            }
          }

          function checkLoginState() {
            FB.getLoginStatus(function(response) {
              statusChangeCallback(response);
            });
          }

          window.fbAsyncInit = function() {
              FB.init({
                appId      : '1411923905492915',
                cookie     : true,  // enable cookies to allow the server to access
                                    // the session
                xfbml      : true,  // parse social plugins on this page
                version    : 'v2.8' // use graph api version 2.8
              });

              FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
              });

              $('.logoutBtn').click(function(){
                FB.logout(function(response) {});
              });

              $('.connect-with-fb-btn').click(function(){
                FB.login(function(response) {
                    if (response.authResponse) {
                     FB.api('/me', {fields: 'id,first_name,last_name,email'}, function(response) {
                       $.ajax({
                       type: 'POST',
                       url: '/facebookRequest.php',
                       data: {email: response.email , firstName: response.first_name, lastName: response.last_name},
                        beforeSend: function(){
                            $('.connect-with-fb-btn').hide();
                            $('.login-page-title-secondary').after("<div class='loader' style='margin-top: 10px; margin-bottom: 10px;'></div>");
                        }
                      })
                        .done(function(result){
                            if(result == 'Success'){
                                $('.start-petition-btn-submit').click();
                            }
                            else{
                                if(result == "Email not provided"){
                                  $('.connect-with-fb-btn').show();
                                  $('.loader').hide();
                                  $('.show-error-login').text("You cannot sign up for signandshare.org using your Facebook account without providing your email address.");
                                  $('.show-error-login').fadeIn();
                                  $('.show-error-join').text("You cannot sign up for signandshare.org using your Facebook account without providing your email address.");
                                  $('.show-error-join').fadeIn();
                                }
                            }
                        })
                        .fail(function(){
                           console.log('FAILED');
                        });
                     });
                    }
                }, {scope: 'email'});
              })
          };

          // Load the SDK asynchronously
          (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = '//connect.facebook.net/en_US/sdk.js';
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));

        $(".button-trigger-login").click(function(){
            $(".modal").show();
            $(".modal-content").show();
            $(".login-page-holder").show();
            $(".join-page-holder").hide();
            $(".forgot-pass-holder").hide();
        });

         $(".button-trigger-join").click(function(){
            $(".modal").show();
            $(".modal-content").show();
            $(".join-page-holder").show();
            $(".login-page-holder").hide();
            $(".forgot-pass-holder").hide();
        });

        $(".modal, .close").click(function(){
            $(".modal").hide();
            $(".modal-content").hide();
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

        $(".logoutBtn").click(function(){
            $.ajax({
                url: 'logout.php',
                success: function(){
                    var url = window.location.href;
                    window.location.href = url;
                }
            });
        });
    });
