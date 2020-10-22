<?php
    if(!(isset($_SESSION['isLogged']))){
        //echo '<script type="text/javascript" src="/scripts/scripts-facebook.js"></script>';
    }
?>

<header class="desktop-header">
    <div class="desktop-inside-header">
        <div class="inner-header">
            <a href="/"><div class="logo"><img alt src="/images/logo3.png" style="width: 100%"></div></a>
            <div class="header-menu">
                <div class="userDropdown1">
                    <div id="myDropdown" class="dropdown-content">
                        <a href="/my_profile">My petitions</a>
                        <a href="/account/edit_settings">Settings</a>
                        <span class="logoutBtn">Log out</span>
                    </div>
                </div>
                <ul class="header-menu-ul">
                    <li><a href="/start"><img alt src="/images/writer.png" style="margin-top: 1px; width: 28px;"></a></li>
                    <li class="header-menu-li-text"><a href="/start">Start a petition</a></li>
                    <li style="margin-top: -2px;"><a href="/petitions/featured"><img alt src="/images/icon.png" style="margin-top: 1px; width: 26px;"></a></li>
                    <li class="header-menu-li-text"><a href="/petitions/featured">Browse <span class="petitions-extra-text">petitions</span></a></li>
                    <li><form action="/search" method="GET" class="header-input-form">
                        <button type="submit" class="header-input-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <input type="text" name="q" class="header-input">
                    </form></li>
                </ul>
            </div>
                    <?php
                         if(isset($_SESSION['isLogged'])){
                            echo '<div class="dropdownBtn header-menu-user"><div style="font-size: 25px; padding-top: 10px; float: left; color: #626262;"><i class="fa fa-user" aria-hidden="true"></i></div><div class="header-menu-user-inside">&nbsp;&nbsp;' . $_SESSION['name'] . '&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></div></div>
                                ';
                        }
                        else{
                            echo '<div class="header-menu-user"><div style="font-size: 25px; padding-top: 10px; float: left; color: #626262;"><i class="fa fa-user" aria-hidden="true"></i></div><div class="header-menu-user-inside">&nbsp;&nbsp;<span style="cursor: pointer;" class="button-trigger-login">Log in</span>| <span style="cursor: pointer;" class="button-trigger-join hide-button-trigger-join">Join us</span></div></div>';
                        }
                    ?>
        </div>
    </div>
</header>

<header class="mobile-header">
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

<?php
    if(!isset($_SESSION['isLogged'])){
        echo '<div class="modal">

            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="login-page-holder">
                    <div class="login-page-title"><div class="login-page-title-main">Log in to your account</div></div>
                    <div class="login-page-title-secondary">Don\'t have an account? <span class="button-trigger-join">Sign up</span></div>
                    <div class="connect-with-fb-btn">
                        <i class="fa fa-facebook-official" aria-hidden="true"></i>&nbsp; &nbsp; Log in with Facebook
                    </div>
                    <div class="login-or">
                        <hr style="width: 100%;">
                        <div class="login-or-title">or</div>
                    </div>
                    <form method="post" id="login-form">
                        <input type="email" class="input login-input" name="emailLogin" placeholder="Email Address">
                        <input type="password" class="input login-input" name="passwordLogin" placeholder="Password">
                        <div class="show-error-login"></div>
                        <div class="forgot-pass-q">Forgot your password?</div>
                        <input type="button" class="update-settings-btn" id="btnLogin" value="Log in">
                    </form>
                </div>

                <div class="forgot-pass-holder">
                    <div class="reset-pass-title"><div class="login-page-title-main">Reset password</div></div>
                    <div class="after-title-text forgot-pass-text">Enter your email address and we will send you a link to reset your password.</div>
                    <input type="email" class="input login-input forgot-pass-input" placeholder="Enter Your Email Address">

                    <div class="back-to-login">Back to login</div>
                    <div class="reset-password">Reset password</div>
                </div>

                <div class="join-page-holder">
                    <div class="login-page-title"><div class="login-page-title-main">Create an Account</div></div>
                    <div class="login-page-title-secondary">Already have an account? <span class="button-trigger-login">Log in</span></div>
                    <div class="connect-with-fb-btn">
                        <i class="fa fa-facebook-official" aria-hidden="true"></i>&nbsp; &nbsp; Join us with Facebook
                    </div>
                    <div class="login-or">
                        <hr style="width: 100%;">
                        <div class="login-or-title">or</div>
                    </div>
                    <form method="post" id="reg-form">
                        <input type="text" class="input big-input" name="firstNameJoin" placeholder="First Name">
                        <input type="text" class="input big-input" name="lastNameJoin" placeholder="Last Name">
                        <input type="email" class="input big-input" name="emailJoin" placeholder="Email Address">
                        <input type="password" class="input big-input" name="passwordJoin" placeholder="Password">
                        <!--<div class="g-recaptcha" data-sitekey="6LeyZQkUAAAAAOoghbKSTeXKlbfiro6rZMSNyp1q" style="margin-top: 10px; float: right;"></div>-->
                        <div class="show-error-join"></div>
                        <input type="button" class="update-settings-btn" id="btnJoin" value="Join" style="margin-top: 20px; width: 100%;">
                        <div class="accept-terms-text">Creating an account means you agree with Sign & Share\'s <a href="/about/terms-of-service">Terms of Service</a>.</div>
                    </form>
                </div>
            </div>

        </div>';
    }
?>
