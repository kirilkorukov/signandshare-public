<?php
    session_start();

    include("petitionId.php");

    require_once("../../config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    if(!isset($_SESSION['isLogged'])){
        header("Location: index");
    }
    else{
        $isPetitionStarterSql = 'SELECT title, path, image, overview FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            header("Location: index");
        }
        else{
            if($row = mysqli_fetch_assoc($isPetitionStarterQuery)){
                $overviewForShare = substr($row['overview'],0,170) . "...";
                $title = $row['title'];
                $path = $row['path'];
                $image = $row['image'];
                if($image == ""){
                    $imageForShare = "fb-image.jpg";
                }
                else{
                    $imageForShare = "p/" . $image;
                }
                $overview = substr($row['overview'], 150);
            }
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />

    <title>Share petition - <?php echo $title; ?> - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <title><?php echo $title; ?> - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Petition: <?php echo $title; ?>">
    <meta name="twitter:description" content="<?php echo $overviewForShare; ?>">
    <meta name="twitter:image" content="https://www.signandshare.org/images/<?php echo $imageForShare; ?>">

    <meta property="og:url" content="https://www.signandshare.org/p/<?php echo $path; ?>/" />
    <meta property="og:title" content="Petition: <?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $overviewForShare; ?>" />
    <meta property="og:image" content="https://www.signandshare.org/images/<?php echo $imageForShare; ?>" />
    <meta property="fb:app_id" content="1411923905492915" />
    <meta property="og:type"   content="website" />
</head>

<body>
<?php
    include_once("../../analyticstracking.php");
?>

<!-- Facebook SDK --> <div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=1635035403441162";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>

<div class="container">

<?php
    include("../../header.php");
?>

<main class="index-page-wrapper">
    <div class="left-column" style="margin-left: auto; margin-right: auto;">
        <div class="thank-you-title" style="margin-bottom: 4px;">Petition created successfully!</div>
        <div class="thank-you-green-title">Start collecting signatures</div>
        <div class="petition-description">Your petition has been created and is live at: <a href="/p/<?php  echo $path; ?>">www.signandshare.org/p/<?php  echo $path; ?></a> The next step is to gain support. Follow <a href="/guides/how-to-promote-your-petition" target="_blank">our steps</a> to spread the word about your petition and reach your signature goal.</div>

        <div class="thank-you-small-title">Promote your petition</div>
        <div class="thank-you-sharing-options">
            <a target="_blank" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=360')" href="http://www.facebook.com/dialog/feed?caption=www.signandshare.org&display=popup&link=www.signandshare.org/p/<?php echo $path; ?>/&app_id=1411923905492915"><div class="thank-you-sharing-option" style="margin-top: 0px; !important;">
                <div class="email-preferences-text left"><div class="left"><i class="fa fa-facebook-square" aria-hidden="true" style="color: #3b5998; font-size: 18px;"></i>&nbsp;&nbsp;&nbsp;Share on facebook</div></div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
            </div></a>
            <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $title . " - Sign the Petition! https://www.signandshare.org/p/" . $path;?>"><div class="thank-you-sharing-option">
                <div class="email-preferences-text left"><i class="fa fa-twitter" aria-hidden="true" style="color: #6faedc; font-size: 19px;"></i>&nbsp;&nbsp;&nbsp;Tweet to your followers</div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
            </div></a>
            <a target="_blank" href="https://plus.google.com/share?url=https://www.signandshare.org/p/<?php echo $path; ?>"><div class="thank-you-sharing-option">
                <div class="email-preferences-text left"><i class="fa fa-google-plus-official" aria-hidden="true" style="color: #de4e43; font-size: 19px;"></i>&nbsp;&nbsp;&nbsp;Share on Google+</div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
            </div></a>
            <div class="thank-you-sharing-option copy-link-address">
                <div class="email-preferences-text left copy-link-address-text"><i class="fa fa-link" aria-hidden="true" style="color: #404040; font-size: 18px;"></i>&nbsp;&nbsp;&nbsp;Copy link address</div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
                <input type="text" class="copy-to-clipboard-link" value="https://www.signandshare.org/p/<?php echo $path; ?>" style="display: none;">
            </div>
        </div>

        <a href="/p/<?php  echo $path; ?>/index" class="thank-you-btn-a"><div class="thank-you-btn">Go to your petition &nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 13px;"></i></div></a>
    </div>
</main>

<?php
    include("../../footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
<script type="text/javascript" src="/scripts/scripts-petitions.js"></script>
<script>
    $(".copy-link-address").click(function(){
        $(".copy-link-address-text").hide();
        $(".copy-to-clipboard-link").show();
        $(".copy-to-clipboard-link").select();
    });
</script>
</body>

</html>
