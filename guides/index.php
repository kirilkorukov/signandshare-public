<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Guides - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Guides - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/guides/" />
    <meta property="og:title" content="Guides - Sign & Share" />
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
       <div class="help-element">
           <div class="help-element-img"><img alt src="/images/configuration.png" style="width: 100%"></div>
           <a href="how-online-petitions-work"><div class="help-element-title">How Online Petitions Work</div></a>
           <div class="help-element-description">“Are online petitions are really effective?” – this is a very common question. People also wonder whether they can actually change the minds of businessman and politicians. But most of all, how do you get the petition target to read the online petition in the first place?</div>
       </div>
       <hr class="about-hr">
       <div class="help-element">
            <div class="help-element-img"><img alt src="/images/panel.png" style="width: 100%"></div>
            <a href="how-to-start-an-online-petition"><div class="help-element-title">How to Start an Online Petition</div></a>
            <div class="help-element-description">Starting a petition isn’t as hard as it sounds. However, in order to simplify the process we have a few tips for you.</div>
        </div>
        <hr class="about-hr">
        <div class="help-element">
            <div class="help-element-img"><img alt src="/images/team.png" style="width: 100%"></div>
            <a href="how-to-select-a-petition-target"><div class="help-element-title">How to Select a Petition Target</div></a>
            <div class="help-element-description">It can be pretty difficult to decide who is the best target for your petition. Choosing a wrong target usually means an ineffective petition and can even stop you from achieving your goal. We want you to succeed with all of your petitions so here are some tips on how to find the best target.</div>
        </div>
        <hr class="about-hr">
        <div class="help-element">
            <div class="help-element-img"><img alt src="/images/writing.png" style="width: 100%"></div>
            <a href="how-to-write-a-petition"><div class="help-element-title">How to Write a Petition</div></a>
            <div class="help-element-description">Our petition tools help you not only to create successful petitions, but also to connect people who share your goal from all over the world. In order to create a successful online petition, we've gathered some useful tips.</div>
        </div>
        <hr class="about-hr">
        <div class="help-element">
            <div class="help-element-img"><img alt src="/images/letter.png" style="width: 100%"></div>
            <a href="how-to-write-a-petition-letter"><div class="help-element-title">How to Write a Petition Letter</div></a>
            <div class="help-element-description">Your petition letter is extremely important to the success of the petition. See our tips on writing a petition letter</div>
        </div>
        <hr class="about-hr">
        <div class="help-element">
            <div class="help-element-img"><img alt src="/images/megaphone-guides.png" style="width: 100%"></div>
            <a href="how-to-promote-your-petition"><div class="help-element-title">How to Promote Your Petition</div></a>
            <div class="help-element-description">One of the biggest advantages of online petitions, is that you don't have to walk the streets, in order to gather signatures. But how exactly could you get the required amount of support, so that you win your campaign? See our top tips to spread the word about your petition and get more signatures.</div>
        </div>
        <hr class="about-hr">
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