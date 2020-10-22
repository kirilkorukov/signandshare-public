<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>How to Select a Petition Target - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="How to Select a Petition Target - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/guides/how-to-select-a-petition-target" />
    <meta property="og:title" content="How to Select a Petition Target - Sign & Share" />
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
        <div class="about-title">How to Select a Petition Target</div>
        <div class="about-mini-title">Who to send your petition to</div>
        <p class="about-text">It can be pretty difficult to decide who is the best target for your petition. Choosing a wrong target usually means an ineffective petition and can even stop you from achieving your goal. We want you to succeed with all of your petitions so here are some tips on how to find the best target. Before selecting a target you should ask yourself 1 question: “Is my issue based on a local, district, or national level or am I trying to get the attention of a business, company or organization?”.</p>
        <hr class="about-hr">
        <div class="about-mini-title">1. If you want to target a business:</div>
        <p class="about-text">Except for the CEO, you should also add the communications and press officers to your target list. They are usually the best way to receive a quick response.</p>
        <hr class="about-hr">
        <div class="about-mini-title">2. If your issue is on a national level:</div>
        <p class="about-text">Targeting the President or the Prime Minister isn’t always the best idea.
            Instead try targeting :<br>
            -Congressional or Parliamentary leaders<br>
            -Cabinet secretaries or Ministers<br>
            -Specific members of Congress or Members of Parliament who are involved with your issue
        </p>
        <hr class="about-hr">
        <div class="about-mini-title">3. If your issue is on a district or local level:</div>
        <p class="about-text">Except for the regional or state government, try targeting: 
            -Mayors<br>
            -Prominent community leaders<br>
            -Utility Commissioners<br>
            -School Board members
        </p>
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