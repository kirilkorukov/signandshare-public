<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>How to Write a Petition - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="How to Write a Petition - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/guides/how-to-write-a-petition" />
    <meta property="og:title" content="How to Write a Petition - Sign & Share" />
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
        <div class="about-title">How to Write a Petition</div>
        <p class="about-text">Our petition tools help you not only to create successful petitions, but also to connect people who share your goal from all over the world. In order to create a successful online petition, we've gathered some useful tips:</p>
        <hr class="about-hr">
        <div class="about-mini-title">1. Petition title</div>
        <p class="about-text">The title of your petition should be short and catchy. It must present your goal in the most accurate way possible. The title is the first thing the reader sees about your petition. Here are some good petition titles:<br> Burberry: Pleae stop using real fur <br> South Korea: ban cat and dog meat</p>
        <hr class="about-hr">
        <div class="about-mini-title">2. Petition description</div>
        <p class="about-text">The description is a summary of your petition`s cause. It should be good enough to convince a reader to sign the petition and even share it online. It should contain a summary of the program of your petition and of your solution to the problem.</p>
        <hr class="about-hr">
        <div class="about-mini-title">3. Petition image</div>
        <p class="about-text">Find or create an image which encourages action. Pictures can show a problem or a solution in a way in which words cannot. As people say : “A picture is worth a thousand words!”</p>
        <hr class="about-hr">
        <div class="about-mini-title">4. Proofing</div>
        <p class="about-text">Never forget to check your spelling and grammar. Even the smallest mistakes can affect the credibility of the petition. Make sure to spell check your text and don’t use ALL CAPS.</p>
        <hr class="about-hr">
        <div class="about-mini-title">5. Promote your petition</div>
        <p class="about-text">Social networking sites and online communities are some of the best tools for popularizing your petition. To learn more, read: <a href="how-to-promote-your-petition">How to Promote Your Petition</a></p>
        <p class="about-text">If you are ready to get started, you can <a href="/start">Start a free petition</a>.</p>
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