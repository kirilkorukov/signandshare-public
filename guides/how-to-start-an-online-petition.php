<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>How to Start an Online Petition - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="How to Start an Online Petition - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/guides/how-to-start-an-online-petition" />
    <meta property="og:title" content="How to Start an Online Petition - Sign & Share" />
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
        <div class="about-title">How to Start an Online Petition</div>
        <p class="about-text">Starting a petition isn’t as hard as it sounds. However, in order to simplify the process we have a few tips for you.</p>
        <hr class="about-hr">
        <div class="about-mini-title">1. Begin with deciding what your goal is</div>
        <p class="about-text">You should always choose a specific and achievable goal. Nobody can “End world hunger”. However, a decision maker can take action towards achieving that goal by helping end hunger in a specific country.</p>
        <hr class="about-hr">
        <div class="about-mini-title">2. Choose the correct petition target</div>
        <p class="about-text">The petition target should be the person or organization which has the most power to actually achieve your goal. It could be your local council, a minister, a company CEO, the Mayor, or even your president. To learn more, read: <a href="how-to-select-a-petition-target">How to Select a Petition Target</a></p>
        <hr class="about-hr">
        <div class="about-mini-title">4. Write a clear petition letter to the petition target</div>
        <p class="about-text">Write a short and focused petition letter. Usually, petition targets are busy people and don’t have time to read long letters. They are more likely to respond to well thought-out requests. To learn more, read: <a href="how-to-write-a-petition-letter">How to Write a Petition Letter</a></p>
        <hr class="about-hr">
        <div class="about-mini-title">5. Post your petition online</div>
        <p class="about-text">The power of the Internet lets you reach activists from all over the world. An online petition lets you collect signatures easily without even leaving your house. However, always remember that online readers are also busy. Therefore, create an interesting and well-written title and description for your online petition. To learn more, read: <a href="how-to-write-a-petition">How to Write a Petition</a></p>
        <hr class="about-hr">
        <div class="about-mini-title">6. Spread the word about your petition</div>
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