<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Start a petition</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<?php 
    include_once("../analyticstracking.php"); 
?>

<header>

</header>

<main>
    <div class="login-page-img"><img alt src="images/login.png" width="300px" height="299px"></div>
    <div class="login-page-holder">
        <div class="login-page-title"><div class="login-page-title-main">Create an Account</div> <div  class="login-page-title-secondary">Already have an account? <a href="login">Login</a></div></div>
        <div class="double-input-holder">
            <input type="text" class="input small-input left" placeholder="First Name">
            <input type="text" class="input small-input right" placeholder="Last Name">
        </div>
        <input type="email" class="input big-input" placeholder="Email Address">
        <input type="password" class="input big-input" placeholder="Password">
        <input id="checkbox-3" class="checkbox-custom" name="checkbox-3" type="checkbox">
        <label for="checkbox-3"class="checkbox-custom-label">I agree to the Terms of Service.</label>
    </div>
</main>

</body>

</html>

