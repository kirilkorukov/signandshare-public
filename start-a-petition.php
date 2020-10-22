<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Start a free online petition - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Start a free online petition - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/facebook-ad.png">

    <meta property="og:url" content="https://www.signandshare.org/start-a-petition" />
    <meta property="og:title" content="Start a free online petition - Sign & Share" />
    <meta property="og:description" content="Sign an existing petition or start your own, gain support and help change the world." />
    <meta property="og:image" content="https://www.signandshare.org/images/facebook-ad.png" />
    <meta property="fb:app_id" content="1411923905492915" />
    <meta property="og:type"   content="website" />
</head>

<body>
<?php
    include_once("analyticstracking.php");
?>

<div class="container">

<?php
    include("header.php");
?>

<div class="start-a-petition-about-holder">
    <div class="start-a-petition-about-title">Want to change something? Start a petition and we'll help you succeed!</div>
    <div class="start-a-petition-about-description">Is there a thing you want to change? Follow our 5 steps on creating a petition, gain support and create change.</div>
    <a href="/start" class="start-a-petition-about-btn-a"><div class="start-a-petition-about-btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Start a petition</div></a>
</div>

<div class="start-petition-holder">
    <div class="start-a-petition-faq-title">Frequently Asked Questions</div>
    <div class="start-a-petition-faq-holder">
        <div class="start-a-petition-faq-question">Do online petitions really make a difference?</div>
        <div class="start-a-petition-faq-answer">Online petitions are a very effective way of gathering support for a cause you care about and drawing attention to that cause. To be truly effective in creating change, however, you need to be actively involved in promoting your petition. You should send out emails to all your friends and colleagues, and you should promote your petition on discussion groups and other websites where users might be interested in your cause.</div>
    </div>
    <div class="start-a-petition-faq-holder">
        <div class="start-a-petition-faq-question">Are your petitions free?</div>
        <div class="start-a-petition-faq-answer">Yes, all our petitions are absolutely free. It is also completely free to sign a petition, and we encourage people to send petitions on to their friends and family. Every petition has buttons to automatically share the petition on Facebook, Twitter and Google+. We support ourselves through advertising.</div>
    </div>
    <div class="start-a-petition-faq-holder">
        <div class="start-a-petition-faq-question">Who can start a petition?</div>
        <div class="start-a-petition-faq-answer">Anyone can start a petition. You can start your petition now, gain support and create change.</div>
    </div>
    <div class="start-a-petition-faq-holder">
        <div class="start-a-petition-faq-question">Why should I use signandshare.org?</div>
        <div class="start-a-petition-faq-answer">We give you everything you need to run a campaign. We make the process of starting a petition very easy – its just 5 steps and takes up to 10 minutes. After publishing, we keep helping you to make your petition successful by providing a detailed petition guide.</div>
    </div>

    <a href="/start" class="start-a-petition-about-btn-a"><div class="start-a-petition-about-btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Start a petition</div></a>
</div>

<?php
    include("footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
</body>

</html>
