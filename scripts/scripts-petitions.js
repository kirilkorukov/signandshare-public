    $(document).ready(function() {
        $(".petition-updates-inside").load("updates.php");

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

        $(".petition-updates").show();
        $(".pet-btn-first").click(function(){
            $(".fb-comment").hide();
            $(".supporters").hide();
            $(".petition-updates").show();

            $(".pet-btn-first").addClass("blue");
            $(".pet-btn-second").removeClass("blue");
            $(".pet-btn-third").removeClass("blue");
        });

        $(".pet-btn-second").click(function(){
            $(".fb-comment").show();
            $(".supporters").hide();
            $(".petition-updates").hide();

            $(".pet-btn-first").removeClass("blue");
            $(".pet-btn-second").addClass("blue");
            $(".pet-btn-third").removeClass("blue");
        });

        $(".pet-btn-third").click(function(){
            $(".fb-comment").hide();
            $(".supporters").show();
            $(".petition-updates").hide();

            $(".pet-btn-first").removeClass("blue");
            $(".pet-btn-second").removeClass("blue");
            $(".pet-btn-third").addClass("blue");
        });

        $(".sign-petition-mobile-btn").click(function(){
            $(".petition-mobile-holder").show();
            $(".sign-petition-mobile-btn").hide();
        });

        $(".my-petition-dashboard-button").click(function(){
            $(".left-column").fadeOut(500);
            $(".right-column").fadeIn(200);
        });

        $(".sign-petition-btn-trigger").click(debounce(function(){
            var dali = true;
            
            if($.trim($("input[name='firstName']").val()) == ""){
                $(".spe1").hide();
                $(".spe1").fadeIn();
                dali = false;
            }
            else{
                $(".spe1").fadeOut();
            }

            if($.trim($("input[name='lastName']").val()) == ""){
                $(".spe2").hide();
                $(".spe2").fadeIn();
                dali = false;
            }
            else{
                $(".spe2").fadeOut();
            }

            if($.trim($("input[name='email']").val()) == ""){
                $(".spe3").hide();
                $(".spe3").fadeIn();
                dali = false;
            }
            else{
                $(".spe3").fadeOut();
            }

            if($("select[name=country]").val() == "default"){
                $(".spe4").hide();
                $(".spe4").fadeIn();
                dali = false;
            }
            else{
                $(".spe4").fadeOut();
            }

            if($.trim($("input[name='city']").val()) == ""){
                $(".spe5").hide();
                $(".spe5").fadeIn();
                dali = false;
            }
            else{
                $(".spe5").fadeOut();
            }

            if(dali == true){
                $.ajax({
                    url: 'submit_signature.php',
                    type: 'POST',
                    data: $('.sign-petition-form').serialize(),
                    beforeSend: function(){
                        $(".sign-petition-btn").hide();
                        $(".reason-for-signing").after("<div class='loader' style='margin-top: 10px; margin-bottom: 10px;'></div>");
                    }
                })
                    .done(function(result){
                        if(result == "Success"){
                            $("input[name=firstName]").val("");
                            $("input[name=lastName]").val("");
                            $("input[name=email]").val("");
                            $("input[name=city]").val("");
                            $("input[name=reasonForSigning]").val("");
                            location.href = "just_signed";
                        }
                        else{
                            if(result == "Invalid email address"){
                                $(".spe3").hide();
                                $(".spe3").fadeIn();
                                $(".spe3").html("Invalid email address.");
                                $(".loader").hide();
                                $(".sign-petition-btn").show();
                            }
                            else{
                                $(".spe5").hide();
                                $(".spe5").fadeIn();
                                $(".spe5").html(result);
                            }
                        }
                    })
                    .fail(function(){
                        $(".sign-petition-btn").show();
                        $(".loader").hide();
                    });
            }
        }, 500));

        $(".sign-petition-mobile-btn-trigger").click(debounce(function(){
            var dali = true;
            
            if($.trim($("input[name='firstNameMobile']").val()) == ""){
                $(".spe1").hide();
                $(".spe1").fadeIn();
                dali = false;
            }
            else{
                $(".spe1").fadeOut();
            }

            if($.trim($("input[name='lastNameMobile']").val()) == ""){
                $(".spe2").hide();
                $(".spe2").fadeIn();
                dali = false;
            }
            else{
                $(".spe2").fadeOut();
            }

            if($.trim($("input[name='emailMobile']").val()) == ""){
                $(".spe3").hide();
                $(".spe3").fadeIn();
                dali = false;
            }
            else{
                $(".spe3").fadeOut();
            }

            if($("select[name=countryMobile]").val() == "default"){
                $(".spe4").hide();
                $(".spe4").fadeIn();
                dali = false;
            }
            else{
                $(".spe4").fadeOut();
            }

            if($.trim($("input[name='cityMobile']").val()) == ""){
                $(".spe5").hide();
                $(".spe5").fadeIn();
                dali = false;
            }
            else{
                $(".spe5").fadeOut();
            }
            if(dali == true){
                $.ajax({
                    url: 'submit_signature_mobile.php',
                    type: 'POST',
                    data: $('.sign-petition-form-mobile').serialize(),
                    beforeSend: function(){
                        $(".sign-petition-btn").hide();
                        $( ".reason-for-signing" ).after("<div class='loader' style='margin-top: 10px; margin-bottom: 10px;'></div>");
                    }
                })
                    .done(function(result){
                        if(result == "Success"){
                            $("input[name=firstNameMobile]").val("");
                            $("input[name=lastNameMobile]").val("");
                            $("input[name=emailMobile]").val("");
                            $("input[name=cityMobile]").val("");
                            $("input[name=reasonForSigningMobile]").val("");
                            location.href = "just_signed";
                        }
                        else{
                            if(result == "Invalid email address"){
                                $(".spe3").hide();
                                $(".spe3").fadeIn();
                                $(".spe3").html("Invalid email address.");
                                $(".loader").hide();
                                $(".sign-petition-btn").show();
                            }
                            else{
                                $(".spe5").hide();
                                $(".spe5").fadeIn();
                                $(".spe5").html("An error occurred. Please, try again later.");
                            }
                        }
                    })
                    .fail(function(){
                        $(".sign-petition-btn").show();
                        $(".loader").hide();
                    });
            }
        }, 500));

        $(window).scroll(function(){
            if ($(this).scrollTop() > 75) {
                $('.petition-holder').addClass("fix-search");
            } else {
                $('.petition-holder').removeClass("fix-search");
            }
        });
    });