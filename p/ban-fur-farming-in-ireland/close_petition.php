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
        $isPetitionStarterSql = 'SELECT closed, title, path, image, overview  FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
            exit;
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            header("Location: index.php");     
        }
        else{
            if($row = mysqli_fetch_assoc($isPetitionStarterQuery)){
                $overviewForShare = substr($row['overview'],0,170) . "...";
                $title = $row['title'];
                $path = $row['path'];
                $closed = $row['closed'];
                $image = $row['image'];
                if($image == ""){
                    $imageForShare = "fb-image.jpg";
                }
                else{
                    $imageForShare = "p/" . $image;
                }
                $overviewForShare = substr($row['overview'],0,170) . "...";
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

    <title>Close petition - Sign and Share</title>
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
            if($closed == 1){
                echo '<div class="post-update-title">Reopen your petition</div>
                        <div class="after-title-text-petition">Are you sure you want to reopen this petition?</div>
                        <form method="post" action="reopen_petition">
                            <a href="index"><div class="error-404-btn error-404-btn-grey back-to-login">Cancel</div></a>
                            <input type="button" value="Reopen petition" class="error-404-btn" name="reopen-petition" style="height: 47px; padding-top: 12px; padding-bottom: 12px;">
                        </form>';
            }
            else{
                echo '<div class="post-update-title">Close your petition</div>
                        <div class="after-title-text-petition">Are you sure you want to close this petition?</div>
                        <form method="post" action="close_petition">
                            <a href="index"><div class="error-404-btn error-404-btn-grey back-to-login">Cancel</div></a>
                            <input type="button" value="Close petition" class="error-404-btn" name="close-petition" style="height: 47px; padding-top: 12px; padding-bottom: 12px;">
                        </form>';
            }
        ?>
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
$(document).ready(function() {
    var petition_id = <?php echo $petitionId; ?>;
    var closedClicked = 0;
    var reopenedClicked = 0;

    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    $("input[name='close-petition']").click(debounce(function(){
        if(closedClicked == 0){
            $.ajax({
                url: '/closePetitionRequest.php',
                type: 'POST',
                data: { petition_id : petition_id }
            })
                .done(function(result){
                    if(result == "Success"){
                        $(".settings-error-notification").hide();
                        $('.left-column').prepend('<div class="settings-success-notification" style="display: block;"><i class="fa fa-check" aria-hidden="true"></i> Your petition has been closed. <a href="index">View your petition</a></div>');
                        closedClicked = 1;
                    }
                    else{
                        $(".settings-success-notification").hide();
                        $('.left-column').prepend('<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> ' + result + '</div>');
                        closedClicked = 1;
                    }
                })
                .fail(function(){
                    $('.left-column').prepend('<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> ' + result + '</div>');
                    closedClicked = 1;
                }); 
        }
    }, 500)); 

    $("input[name='reopen-petition']").click(debounce(function(){
        if(reopenedClicked == 0){
            $.ajax({
                url: '/reopenPetitionRequest.php',
                type: 'POST',
                data: { petition_id : petition_id }
            })
                .done(function(result){
                    if(result == "Success"){
                        $(".settings-error-notification").hide();
                        $('.left-column').prepend('<div class="settings-success-notification" style="display: block;"><i class="fa fa-check" aria-hidden="true"></i> Your petition has been reopened. <a href="index">View your petition</a></div>');
                        reopenedClicked = 1;
                    }
                    else{
                        $(".settings-success-notification").hide();
                        $('.left-column').prepend('<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> ' + result + '</div>');
                        reopenedClicked = 1;
                    }
                })
                .fail(function(){
                    $('.left-column').prepend('<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> ' + result + '</div>');
                    reopenedClicked = 1;
                }); 
        }
    }, 500)); 
});
</script>
</body>

</html>