<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>About - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="About - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/about/" />
    <meta property="og:title" content="About - Sign & Share" />
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
        <div class="about-title">Start an online petition, gain support and create change</div>
        <p class="about-text">Sign & Share is a free, easy and powerful online petition platform, that gives people all around the world, the tools to start an online petition, gain support and create change. You'll be able to:</p><br><br>
        <p class="about-mini-title">1. Start a Petition</p><br>
        <p class="about-text">Free and easy to create, in just 4 steps.<br>
        Ability to post frequent updates to everyone, who has signed your petition</p>
        <br>
        <br>
        <p class="about-mini-title">2. Gain Support</p><br>
        <p class="about-text">Integrated sharing tools with Facebook, Twitter and Google+</p>
        <br>
        <br>
        <p class="about-mini-title">3. Create Change</p><br>
        <p class="about-text">Ability to download and print the signatures on your petition in two formats</p>

        <div class="start-petition-banner">
            <div class="start-petition-banner-text">Is there a cause you are passionate about? Start a free online petition and bring the change you want to see!</div>
            <a href="/start"><div class="start-petition-banner-big-button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Start a petition</div></a>
        </div>
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
<script>
    $(document).ready(function() {

        $('.help-question-box').click(function() {

            if ($(this).parent().is('.open')){
                $(this).closest('.help-question-box').find('.faq_answer_container').animate({'height':'0'},500);
                $(this).closest('.help-question-box').removeClass('open');

            }else{
                var newHeight =$(this).closest('.help-question-box').find('.faq_answer').height() +'px';
                $(this).closest('.help-question-box').find('.faq_answer_container').animate({'height':newHeight},500);
                $(this).closest('.help-question-box').addClass('open');
            }

        });

    });
</script>

</body>

</html>