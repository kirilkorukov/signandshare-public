<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate" />
    <meta name="description" content="Sign an existing petition or start your own, gain support and help change the world." />

    <title>Sign & Share - Free online petitions</title>
    
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
    <link rel="canonical" href="https://www.signandshare.org" />
</head>
<body>
<!-- Facebook SDK --> <div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=1635035403441162";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
<header class="mobile-header" style="display: block !important;">
    <div class="mobile-inside-header">
        <div class="mobile-inner-header">
            <?php
                if(isset($_SESSION['isLogged'])){
                    echo '<div class="userDropdown2">
                            <div class="header-menu-dropdown header-menu-dropdown-menu">
                                <a href="/start">Start a petition</a>
                                <a href="/petitions/featured">Browse</a>
                                <a href="/search">Search</a>
                            </div>
                        </div>
                        <div class="userDropdown3">
                            <div class="header-menu-dropdown header-menu-dropdown-user">
                                <a href="/my_profile">My petitions</a>
                                <a href="/account/edit_settings">Settings</a>
                                <span>' . $_SESSION['name'] . '</span>
                                <span class="logoutBtn">Log out</span>
                            </div>
                        </div>';
                }
                else{
                    echo '<div class="userDropdown2">
                            <div class="header-menu-dropdown header-menu-dropdown-menu">
                                <a href="/start">Start a petition</a>
                                <a href="/petitions/featured">Browse</a>
                                <a href="/search">Search</a>
                                <span style="cursor: pointer;" class="button-trigger-login">Log in</span>
                                <span style="cursor: pointer;" class="button-trigger-join">Join us</span>
                            </div>
                        </div>';
                }
            ?>
            
            <div class="mobile-logo-holder">
                <div class="mobile-logo"><a href="/"><img alt src="/images/logo3.png" style="width: 100%"></a></div>
                <div class="fb-like mobile-fb-like" data-href="https://www.facebook.com/Sign-Share-173219513163063/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
            </div>
            <?php
                if(isset($_SESSION['isLogged'])){
                    echo '<div class="mobile-header-menu-holder">
                            <span class="mobile-header-menu"><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</span>
                            <span class="mobile-header-menu-user"><i class="fa fa-user" aria-hidden="true"></i></span>
                        </div>';
                }
                else{
                     echo '<div class="mobile-header-menu-holder">
                            <span class="mobile-header-menu"><i class="fa fa-bars" aria-hidden="true"></i></span>
                        </div>';
                }
            ?>
            
        </div>
    </div>
</header>
</body>
</html>