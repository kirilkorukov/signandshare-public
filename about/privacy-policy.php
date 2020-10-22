<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Privacy Policy - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Privacy Policy - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/about/privacy-policy" />
    <meta property="og:title" content="Privacy Policy - Sign & Share" />
    <meta property="og:description" content="Sign an existing petition or start your own, gain support and help change the world." />
    <meta property="og:image" content="https://www.signandshare.org/images/fb-image.jpg" />
    <meta property="fb:app_id" content="1411923905492915" />
<meta property="og:type"   content="website" /> 
</head>

<body>
<?php 
    include_once("../analyticstracking.php"); 
?>

<!-- Facebook SDK --> <div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=1635035403441162";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>

<div class="container">

<?php
    include("../header.php");
?>

<main class="petition-page-wrapper">
    <div class="left-column left">
        <div class="about-title">Privacy Policy</div>
        <p class="about-text">Our Privacy Policy outlines how we get and use information about you, who we share it with, and how you can control your privacy settings. </p>
        <hr class="about-hr">
        <div class="about-mini-title">Information we collect and use</div>
        <p class="about-text">Sign & Share will not give or sell your information to any third party. If signing a petition, your information can be accessed by the petition's author. Petition authors agree to use signatures responsibly, legally and in compliance with our Terms and this Privacy Policy. This may involve the author contacting you about the campaign you have supported at Sign & Share. Authors also have permission to forward petition signatures to the relevant petition's target, so petition targets may also ultimately view signature details. Email addresses are stored confidentially and securely with multi-layer protection. We will not email you anything unrelated to Sign & Share. If your email address is supplied, it will be stored securely. Your email address will NEVER be displayed on this website.</p>
        <hr class="about-hr">
        <div class="about-mini-title">Search Engine Access to Signature Lists and Signature Comments</div>
        <p class="about-text">Please note that search engines such as Google and Bing may be able to view your signature and signature comment and may index your signature and signature comment (if made). You may stop indexing by cloaking your signature with an "Don't display my name" designation and by "hiding" your comment.</p>
        <hr class="about-hr">
        <div class="about-mini-title">Signature Confirmation</div>
        <p class="about-text">When you sign a petition on Sign & Share, you will receive an email confirming that your signature has been received. This is a one-time correspondence, sent only to confirm your signature. On an occasional basis, you may be sent infomation about related petitions and site updates.</p>
        <hr class="about-hr">
        <div class="about-mini-title">Links and Content</div>
        <p class="about-text">This website contains links to external sites. Please be aware that Sign & Share is not responsible for the privacy practices of such other sites. While we do everything possible to monitor the contents of individual petitions and comments on our site, we cannot be held liable for any offence, damage, injury or other legal infraction attributed to such content. Sign & Share is a service provider; we are not content generators.</p>
        <hr class="about-hr">
        <div class="about-mini-title">Facebook Comments</div>
        <p class="about-text">If you use the facebook comment facility on any petition then your name and facebook photo may appear on Sign & Share. We use a facebook plugin for the facebook comment facility. Sign & Share does not guarantee that attempts to edit facebook comments by users of this facility will result in the desired editorial results. Any use of the facebook comment facility is at the user's own risk.</p>
        <hr class="about-hr">
        <div class="about-mini-title">Advertisements on Sign & Share</div>
        <p class="about-text">While visiting signandshare.org, you will see advertisements. We use the services of Google. Google uses the DART cookie to serve ads to our users based on their previous visits to our sites and other sites on the Internet. Users may opt out of the use of the DART cookie by visiting the Google ad and content network privacy policy at <a href="http://www.google.com/privacy_ads.html">http://www.google.com/privacy_ads.html</a></p>
        <hr class="about-hr">
        <div class="about-mini-title">Cookies</div>
        <p class="about-text">See the information above.</p>
        <hr class="about-hr">
        <div class="about-mini-title">How to Contact us</div>
        <p class="about-text">The best way to contact us is to send us an email at help@signandshare.org</p>
    </div>

    <?php
        include("right-column.php");
    ?>
</main>

<?php
    include("../footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
</body>

</html>