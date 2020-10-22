<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign & Share - Free online petitions</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Sign & Share - Free online petitions">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org" />
    <meta property="og:title" content="Sign & Share - Free online petitions" />
    <meta property="og:description" content="Sign an existing petition or start your own, gain support and help change the world." />
    <meta property="og:image" content="https://www.signandshare.org/images/fb-image.jpg" />
    <meta property="fb:app_id" content="1411923905492915" />
<meta property="og:type"   content="website" />
</head>

<body>
<?php
    include_once("/home/peticiic/public_html/analyticstracking.php");
?>

<div class="container">

<?php
    include("/home/peticiic/public_html/header.php");
?>

<main class="edit-settings-main">
    <div class="error-404-img">404</div>
    <div class="error-404-page-holder">
        <div class="error-404-title">Oops.</div>
        <div class="error-404-mobile-title">404 Error</div>
        <div class="after-title-text">Sorry, but we can't find the page you were looking for.</div>

        <a href="/search"><div class="error-404-btn error-404-btn-grey">Search</div></a>
        <a href="/petitions/featured"><div class="error-404-btn">Browse petitions</div></a>
    </div>
</main>

<?php
    include("/home/peticiic/public_html/footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
</body>

</html>
