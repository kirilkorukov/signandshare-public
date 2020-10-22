<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>How to Promote Your Petition - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="How to Promote Your Petition - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/guides/how-to-promote-your-petition" />
    <meta property="og:title" content="How to Promote Your Petition - Sign & Share" />
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
        <div class="about-title">How to Promote Your Petition</div>
        <p class="about-text">One of the biggest advantages of online petitions, is that you don't have to walk the streets, in order to gather signatures. But how exactly could you get the required amount of support, so that you win your campaign? Below are our top tips to spread the word about your petition and get more signatures:</p>
        <hr class="about-hr">
        <div class="about-mini-title">Share Your Petition on Facebook</div>
        <p class="about-text">Facebook is one of the best ways to instantly let lots of people know about your petition. And then your friends can share it with their friends with a single click too. You can also post updates on your petition's progress for people who may have missed it the first time. You can send individual messages to friends through Facebook, and share it with groups or post it on pages relevant to your issue.</p>
        <hr class="about-hr">
        <div class="about-mini-title">Tweet Your Petition</div>
        <p class="about-text">Tweet your petition to Twitter and make sure to include any user handles that will help make your target see your messages and any trending or topical hashtags that will help people with similar interest notice your tweet. With only 140 characters available, you can't afford to use 20-30 characters just on the link to the petition. Free link-shortener websites like <a target="_blank" href="https://bitly.com/">bit.ly</a> work great. Also, post frequent updates about your petition. </p>
        <hr class="about-hr">
        <div class="about-mini-title">Email Your Friends</div>
        <p class="about-text">Direct email is one of the most effective ways to get people involved in your petition. Email all your friends asking them to sign your petition. (But remember, only email people you know. Emailing strangers could land your messages in the spam folder!)</p>
        <hr class="about-hr">
        <div class="about-mini-title">Join a Conversation Online</div>
        <p class="about-text">Search Google news for stories about your issue if you see one, consider posting a link to your petition in the comments section of the story - readers might visit the petition and the reporter will learn about your efforts. Also, submit a link to your petition to <a target="_blank" href="https://www.reddit.com/">Reddit</a>, a popular content aggregator, and encourage other Reddit users to leave comments or messages of suppport.
        </p>
        <hr class="about-hr">
        <div class="about-mini-title">Talk About Your Petition in Forums</div>
        <p class="about-text">To attract people who care about your cause, find the communities they belong to. Search for forums related to your cause and start meaningful conversations about your campaign. This is a very effective way to get people involved in your petition.</p>
        <hr class="about-hr">
        <div class="about-mini-title">Post Your Petition on Your Blog or Website</div>
        <p class="about-text">Post the link of your petition on your blog or website and ask your readers to sign it. They are already fans of your content, so they’re highly likely to be interested in your petition too.</p>
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