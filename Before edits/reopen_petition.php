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
        $isPetitionStarterSql = 'SELECT closed, path FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
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
                $path = $row['path'];

                if($closed == 0){
                    header("Location: close_petition.php"); 
                }
            }
            if(isset($_POST['reopen-petition'])){

                $closePetitionSql = "UPDATE petition SET closed = 0 WHERE id = " . $petitionId;
                $closePetition = mysqli_query($conn, $closePetitionSql); 
                
                if(!$closePetition){
                    $errorCode = 1;
                }
                else{
                    $errorCode = 2;
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

    <title>Reopen your petition - Sign and Share</title>

    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta property="og:url" content="https://www.signandshare.org/p/<?php echo $path; ?>/" />
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
            if($errorCode != 2){
                if($errorCode == 1){
                    echo '<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> There has been some error. Please try again later.</div>';
                }
            }
            else{
                echo '<div class="settings-success-notification" style="display: block;"><i class="fa fa-check" aria-hidden="true"></i> Your petition has been reopened. <a href="index">View your petition</a></div>';
            }
        ?>
        <div class="post-update-title">Reopen your petition</div>
        <div class="after-title-text-petition">Are you sure you want to reopen this petition?</div>
        <form method="post" action="reopen_petition">
            <a href="index"><div class="error-404-btn error-404-btn-grey back-to-login">Cancel</div></a>
            <input type="submit" value="Reopen petition" class="error-404-btn reset-password" name="reopen-petition" style="height: 47px; padding-top: 12px; padding-bottom: 12px;">
        </form>

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
</body>

</html>