<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>How Online Petitions Work - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="How Online Petitions Work - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/guides/how-online-petitions-work" />
    <meta property="og:title" content="How Online Petitions Work - Sign & Share" />
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
        <div class="about-title">How Online Petitions Work</div>
        <p class="about-text">“Are online petitions are really effective?” – this is a very common question. People also wonder whether they can actually change the minds of businessman and politicians. But most of all, how do you get the petition target to read the online petition in the first place?</p>
        <hr class="about-hr">
        <div class="about-mini-title">Why do we need online petitions, and how do they work?</div>
        <p class="about-text">In short, a petition is a bunch of names with signatures put together to show support for a cause. One of the few ways to draw attention to some issues is by demonstrating public support. Petitions are the easiest and cheapest way to popularize a cause you believe in.</p>
        <hr class="about-hr">
        <div class="about-mini-title">What Successful Petitions have in Common?</div>
        <p class="about-text">1. The goal is achievable and important to the society <br>  The change successful petitions aim to create is very specific. They give a solution to a problem which concerns a lot of people. If you cant express your goal in just one clear sentence, then it is not specific enough. Here is an example of an achievable goal: “Demand the Victorian Government Permanently Bans Duck Hunting”</p>
        <p class="about-text">2.The petition is delivered straight to the target <br> Most online petition tools help you to collect signatures, but you need to deliver the signatures to the target offline. With our tools you can download your petition's signature list and deliver it to the petition target.</p>
        <p class="about-text">3. Promote your petition <br> Social networking sites like Facebook make it easy to gain support without even leaving your house. Successful petitions owe their popularity to the power of the Internet. Once you start a petition on signandshare.org, we will show you exactly how to use the social media tools in order to spread the word and get more signatures. A successful online petition is followed by a lot of offline action, too. Collecting petitions signatures aren’t always enough to make the target take action. You have to be ready to connect directly with your target. Phone calls, hand written letters and even protests are a great way to keep the issue front and center.</p>
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