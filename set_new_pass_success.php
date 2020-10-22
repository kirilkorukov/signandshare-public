<?php
    session_start();

    if(isset($_SESSION['isLogged'])){
        header("Location: index.php");
    }

    require_once("config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Set new password - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
    <meta name="robots" content="noindex">
</head>

<body>
<?php 
    include_once("analyticstracking.php"); 
?>

<div class="container">

<?php
    include("header.php");
?>

<main class="index-page-wrapper">
    <div class="set-new-pass-holder">
        <div class="settings-success-notification" style="display: block;"><i class="fa fa-check" aria-hidden="true"></i> Your password has been set.</div>
    </div>
</main>

<?php
    include("footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
</body>

</html>