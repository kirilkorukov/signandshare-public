        $(document).ready(function() {
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
                                var url = window.location.href;  
                                location.href = url;
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
            js.src = '//connect.facebook.net/en_EN/sdk.js';
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
        });