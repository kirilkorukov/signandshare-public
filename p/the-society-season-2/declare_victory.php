<?php
    session_start();

    include("petitionId.php");
    
    /* Check if the user is logged in. If not redirect him to the previous page. */
    if(!isset($_SESSION['isLogged'])){
        header("Location: index.php"); 
    }
    else{
        require_once("../../config.php");

        $conn = mysqli_connect($servername,$user,$password,$dbname);
        if($conn == false){
            echo 'ERROR';
            exit;
        }

        mysqli_set_charset($conn, 'utf8');

        /* Check if the user is the owner of the petition. If not redirect him to the previous page. */
        $errorCode = 0;
        $isPetitionStarterSql = 'SELECT closed, victory, title, overview, path, image FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            header("Location: index.php");     
        }
        else{
            if($row = mysqli_fetch_assoc($isPetitionStarterQuery)){
                $closed = $row['closed'];
                $victory = $row['victory'];
                $title = $row['title'];
                $path = $row['path'];
                $image = $row['image'];
                if($image == ""){
                    $imageForShare = "fb-image.jpg";
                }
                else{
                    $imageForShare = "petitions/" . $image;
                }
                $overviewForShare = substr($row['overview'],0,170) . "...";
                if($row['victory'] == 1){
                    header("Location: index.php");
                }

                if(isset($_POST['declare-victory'])){
                    $text = trim($_POST['victory_msg']); 
                    $text = nl2br($text); 
                    $victoryMsg = '<div class="victory-message-wrapper">
                                        <div class="victory-message-image"><img alt src="/images/medal.png" style="width: 100%"></div>
                                        <div class="victory-message-title">Confirmed Victory</div>
                                        <div class="victory-message">' . date('d') . ' ' . date('F Y') . ' - ' . $text . '</div>
                                    </div>';
                    $victoryMsgFile = fopen("victory_message.php", "w");
                    fwrite($victoryMsgFile, $victoryMsg);
                    $declareVictorySql = "UPDATE petition SET victory = 1 WHERE id = " . $petitionId;
                    $declareVictory = mysqli_query($conn, $declareVictorySql); 
                    
                    if(!$declareVictory){
                        $errorCode = 1;
                    }
                    else{

                        header("Location: index.php");
                    }
                }
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

    <title>Declare victory - Sign and Share</title>
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
    
<main class="petition-page-wrapper">
    <div class="left-column left">
        <?php
            if($errorCode == 1){
                echo '<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> There has been some error. Please try again later.</div>';
            }
        ?>
        <div class="post-update-holder">
            <div class="post-update-title">Declare victory</div>
            <div class="post-update-tips" style="text-align: left;">
                If you've reached your goal you can declare victory. An update will be added to your petition. Keep in mind that people won't be able to sign your petition anymore.
            </div>
            <form method="post" action="declare_victory" class="declare-victory-form">
                <textarea placeholder="Write your message here..." class="update-petition-textarea" name="victory_msg"></textarea>
                <input type="submit" value="Declare victory" class="error-404-btn" name="declare-victory" style="height: 47px; padding-top: 12px; padding-bottom: 12px;">
            </form>
        </div>
    </div>

    <?php
        include("../../my_petition_right_column.php");
    ?>

</main>

<?php
    include("../../footer.php");       
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
<script type="text/javascript" src="/scripts/scripts-petitions.js"></script>
<script type="text/javascript">
    $(".declare-victory-form").submit(function(e){
        if($.trim($(".update-petition-textarea").val()) == ""){
            e.preventDefault();
            $(".settings-error-notification").hide();
            $(".left-column").prepend('<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> Please write a description.</div>');
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
    });
</script>
</body>

</html>