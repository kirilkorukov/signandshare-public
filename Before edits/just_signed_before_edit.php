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

    $supporters = 'SELECT title, currentSupporters, goalSupporters, path FROM petition WHERE id = ' . $petitionId;
    $supportersQuery = mysqli_query($conn, $supporters);
    if(!$supportersQuery){
        die("Error");
    }
    else{
        if($row = mysqli_fetch_assoc($supportersQuery)){
            $title = $row['title'];
            $currentSupporters = $row['currentSupporters'];
            $goalSupporters = $row['goalSupporters'];
            $path = $row['path'];
            $neededSupporters = $goalSupporters - $currentSupporters;
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Share petition - <?php echo $title; ?> - Sign and Share</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php 
    include_once("../analyticstracking.php"); 
?>

<?php
    include("../../header.php");       
?>

<div class="thank-you-wrapper">
    <div class="thank-you-text"><img alt src="/images/cloud-finished.png" width="17px" height="17px"> Thank you for signing! This petition still needs <?php echo $neededSupporters; ?> signatures to reach its goal. Share it with your friends and increase your impact.</div>
    <div class="thank-you-sharing-options">
        <div class="thank-you-sharing-option" style="margin-top: 0px; !important;">
            <div class="email-preferences-text left"><div class="left"><i class="fa fa-facebook-square" aria-hidden="true" style="color: #3b5998; font-size: 18px;"></i>&nbsp;&nbsp;&nbsp;Share on facebook</div></div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
        </div>
        <div class="thank-you-sharing-option">
            <div class="email-preferences-text left"><i class="fa fa-twitter" aria-hidden="true" style="color: #6faedc; font-size: 19px;"></i>&nbsp;&nbsp;&nbsp;Tweet to your followers</div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
        </div>
        <div class="thank-you-sharing-option">
            <div class="email-preferences-text left"><i class="fa fa-google-plus-official" aria-hidden="true" style="color: #de4e43; font-size: 19px;"></i>&nbsp;&nbsp;&nbsp;Share on Google+</div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
        </div>
        <div class="thank-you-sharing-option">
            <div class="email-preferences-text left"><i class="fa fa-envelope-o" aria-hidden="true" style="color: #404040; font-size: 16px;"></i>&nbsp;&nbsp;&nbsp;Send an email to your friends</div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
        </div>
        <div class="thank-you-sharing-option copy-link-address">
            <div class="email-preferences-text left copy-link-address-text"><i class="fa fa-link" aria-hidden="true" style="color: #404040; font-size: 18px;"></i>&nbsp;&nbsp;&nbsp;Copy link address</div><div class="right"><i class="fa fa-chevron-right" aria-hidden="true" style="color: rgb(156, 156, 156); font-size: 15px;"></i></div>
            <input type="text" class="copy-to-clipboard-link" value="https://www.signandshare.org/p/<?php echo $path; ?>" style="display: none;">
        </div>
    </div>
    <a href="/suggested" class="thank-you-btn-a"><div class="thank-you-btn">Skip sharing &nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 13px;"></i></div></a>
</div>


<?php
    include("../../footer.php");       
?>

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

/* CSS */
.thank-you-wrapper{
    width: 526px;
    height: auto;
    margin-left: auto;
    margin-right: auto;
    margin-top: 70px;
}

.thank-you-text{
    color: #53b523;
    font-family: 'droid-sans', sans-serif;
    font-size: 17px;
    margin-bottom: 50px;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}

.thank-you-sharing-options{
    width: 100%;
    height: auto;
    margin-left: auto;
    margin-right: auto;
}

.thank-you-sharing-option{
    width: 501px;
    font-family: 'droid-sans', sans-serif;
    border: 2px solid #f2f2f2;
    background-color: white;
    border-radius: 2px;
    padding-left: 8px;
    padding-right: 15px;
    margin-top: 11px;
    height: 29px;
    padding-top: 12px;
    font-size: 15px;
    color: rgb(156, 156, 156);
    cursor: pointer;
    margin-left: auto;
    margin-right: auto;
}

.copy-link-address-input{
    border-style: none;
    border-color: white;
    font-family: 'droid-sans', sans-serif;
    font-size: 15px;
    color: rgb(156, 156, 156);
    margin-left: 10px;
}

.thank-you-btn-a{
    height: 29px;
    margin-left: auto;
    margin-right: auto;
    text-decoration: none;
    display: block;
    width: 180px;
}

.thank-you-btn{
    width: 180px;
    font-family: 'droid-sans', sans-serif;
    border: 2px solid #f2f2f2;
    background-color: white;
    text-align: center;
    border-radius: 2px;
    margin-top: 65px;
    height: 29px;
    padding-top: 12px;
    font-size: 15px;
    color: #404040;
    cursor: pointer;
    margin-left: auto;
    margin-right: auto;
}

.copy-to-clipboard-link{
    margin-left: 10px;
    font-family: 'droid-sans', sans-serif;
    border: none;
    border-radius: 3px;
    width: 90%;
    margin-top: -5px;
    box-sizing: border-box;
    font-size: 15px;
    color: rgb(156, 156, 156);
}

.copy-to-clipboard-link:focus{
    outline: none;
}