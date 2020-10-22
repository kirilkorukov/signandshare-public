<?php
    session_start();
    
    require_once("config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    function cryptPass($input, $rounds=9){
        $salt = "";
        $saltChars = array_merge(range('A','Z'), range('a','z'), range(0,9));
        for($i=0; $i<22; $i++){
            $salt .= $saltChars[array_rand($saltChars)];
        }
        return crypt($input, sprintf('$2y$%02d$', $rounds).$salt);
    }

    if (empty($_GET)) {
        header("Location: index");
        exit;
    }
    else{
        $token = $_GET['token'];
        $email_id = $_GET['email_id'];
        $petitionId = $_GET['pid'];
        $token = mysqli_real_escape_string($conn, $token);
        $email_id = mysqli_real_escape_string($conn, $email_id);
        $petitionId = mysqli_real_escape_string($conn, $petitionId);
        $errorCode = 0;

        $deleteSignature = 'DELETE FROM user_petitions WHERE email = "' . $email_id . '" AND token = "' . $token . '" AND petition_id = ' . $petitionId;
        $deleteSignatureQuery = mysqli_query($conn, $deleteSignature);

        if (mysqli_affected_rows($conn) > 0) {
            $errorCode = 1;
        }

        $updateSupporters = 'UPDATE petition SET currentSupporters = currentSupporters - 1 WHERE id = ' . $petitionId;
        $updateSupportersQuery = mysqli_query($conn, $updateSupporters);
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Remove signature - Sign and Share</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
</head>

<body>
<?php 
    include_once("analyticstracking.php"); 
?>

<!-- Facebook SDK --> <div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=1635035403441162";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>

<div class="container">

<?php
    include("header.php");       
?>

<main class="index-page-wrapper">
    <div class="set-new-pass-holder">
        <?php
            if($errorCode == 1){
                echo '<div class="petition-description">Your signature has been removed successfully. <a href="petitions/featured">Browse other urgent petitions</a></div>';
            }
            else{
                echo '<div class="petition-description">The signature you are attempting to delete was not found. <a href="petitions/featured">Browse other urgent petitions</a></div>';   
            }
        ?>
    </div>
</main>

<?php
    include("footer.php");       
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
</body>

</html>