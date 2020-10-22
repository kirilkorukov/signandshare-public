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
        $isPetitionStarterSql = 'SELECT victory, closed, lastUpdate, title, overview, image, path FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
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
                $year = substr($row['lastUpdate'], 0, 4);
                $month = substr($row['lastUpdate'], 5, 2);
                $day = substr($row['lastUpdate'], 8, 2);

                $currYear = date("o");
                $currMonth = date("m");
                $currDay = date("d");

                    if($currDay <= $day){
                        if($currYear > $year || $currMonth > $month){
                            if(isset($_POST['post-update'])){
                                $text = trim($_POST['update_msg']); 
                                $text = nl2br($text); 
                                $updateMsg;
                                /*if($year == "0000" && $month == "00" && $day == "00"){*/
                                $updateMsg = '<div class="petition-update-holder">
                                            <div class="petition-update-label"><i class="fa fa-rss" aria-hidden="true"></i>&nbsp;&nbsp;Petition Update</div>
                                            <div class="petition-update-posted">' . date('d') . ' ' . date('F Y') . '</div>
                                            <div class="petition-update-text">' . $text . '</div>
                                        </div>';
                                /*}
                                else{
                                    $updateMsg = '<div class="petition-update-holder">
                                                <div class="petition-update-label"><i class="fa fa-rss" aria-hidden="true"></i>&nbsp;&nbsp;Petition Update</div>
                                                <div class="petition-update-posted">' . date('d') . ' ' . date('F Y') . '</div>
                                                <div class="petition-update-text">' . $text . '</div>
                                            </div>';
                                }*/
                                if (file_exists("updates.php")) {
                                    $updateMsg .= file_get_contents('updates.php');
                                }
                                file_put_contents('updates.php', $updateMsg);
                                $lastUpdateSql = 'UPDATE petition SET lastUpdate = "' . date("Y-m-d") . '" WHERE id = ' . $petitionId;
                                $lastUpdate = mysqli_query($conn, $lastUpdateSql); 
                                    
                                if(!$lastUpdate){
                                    $errorCode = 1;
                                }
                                else{
                                    $errorCode = 2;
                                }
                            }
                        }
                        else{
                            $errorCode = 3;
                        }
                    }
                    else{
                        if(isset($_POST['post-update'])){
                            $text = trim($_POST['update_msg']); 
                            $text = trim($_POST['update_msg']); 
                            $text = nl2br($text); 
                            $updateMsg;
                            $updateMsg = '<div class="petition-update-holder">
                                            <div class="petition-update-label"><i class="fa fa-rss" aria-hidden="true"></i>&nbsp;&nbsp;Petition Update</div>
                                            <div class="petition-update-posted">' . date('d') . ' ' . date('F Y') . '</div>
                                            <div class="petition-update-text">' . $text . '</div>
                                        </div>';

                            if (file_exists("updates.php")) {
                                $updateMsg .= file_get_contents('updates.php');
                            }
                            file_put_contents('updates.php', $updateMsg);
                            $lastUpdateSql = 'UPDATE petition SET lastUpdate = "' . date("Y-m-d") . '" WHERE id = ' . $petitionId;
                            $lastUpdate = mysqli_query($conn, $lastUpdateSql); 
                                    
                            if(!$lastUpdate){
                                $errorCode = 1;
                            }
                            else{
                                $errorCode = 2;
                            }
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

    <title>Update your supporters - Sign and Share</title>
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
        <div class="post-update-holder">
            <?php
                if($errorCode != 2){
                    if($errorCode == 1){
                        echo '<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> Please try again later.</div>';
                    }
                    else if($errorCode == 3){
                        echo '<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> You can post one update every 24 hours. Updates appear on your petition page.</div>';
                    }
                }
                else{
                    echo '<div class="settings-success-notification" style="display: block;"><i class="fa fa-check" aria-hidden="true"></i> Your update was saved successfully. <a href="index">View your petition</a></div>';
                }
            ?>
            <div class="post-update-title">Update your supporters</div>
            <div class="post-update-tips" style="text-align: left;">
                You can post one update per day. Updates appear on your petition page. Keep them short and to the point.
            </div>
            <form method="post" action="post_update" class="post-update-form">
                <textarea placeholder="Post your update here..." class="update-petition-textarea" name="update_msg"></textarea>
                <input type="submit" value="Post update" class="error-404-btn" name="post-update" style="height: 47px; padding-top: 12px; padding-bottom: 12px;">
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
    $(".post-update-form").submit(function(e){
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