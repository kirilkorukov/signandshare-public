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
        $token = $_GET['set'];
        $email_id = $_GET['email_id'];
        $token = mysqli_real_escape_string($conn, $token);
        $email_id = mysqli_real_escape_string($conn, $email_id);
        $errorCode = 0;

        function base64_url_decode($input) {
            return base64_decode(strtr($input, '-_,', '+/='));
        }

        $decodedEmail = base64_url_decode($email_id);

        $getEmail = 'SELECT id FROM forgot_pass WHERE token = "' . $token .'" AND email_id = "' . $email_id . '" AND CURTIME() < time_expires LIMIT 1';
        $getEmailQuery = mysqli_query($conn, $getEmail);

        if(mysqli_num_rows($getEmailQuery) == 0){
            $errorCode = 1;
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset password - Sign and Share</title>
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
                echo '<div class="petition-description">Expired password reset link. Please use the \'Forgot Password\' link to receive a new reset link.</div>';
            }
            else{
                echo '<div class="login-page-title-main">Set Your New Password</div>
                    <input type="password" class="input login-input" name="newPass" placeholder="New Password">
                    <input type="password" class="input login-input" name="verifyPass" placeholder="Verify Password">

                    <input type="button" class="update-settings-btn set-new-pass-btn" value="Submit">';
            }
        ?>
    </div>
</main>

<?php
    include("footer.php");       
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
<script type="text/javascript">
$(document).ready(function() {

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

    var token = <?php echo "'" . $token . "'"?>;
    var email_id = <?php echo "'" . $email_id . "'"?>;

    $(".set-new-pass-btn").click(debounce(function() {
        $.ajax({
            url: 'setNewPassword.php',
            type: 'POST',
            data: {token : token , email_id : email_id , newPass : $("input[name='newPass']").val() , verifyPass : $("input[name='verifyPass']").val()}
        })
            .done(function(result){
                if(result == "Success"){
                    location.href = "https://www.signandshare.org/set_new_pass_success";
                }
                else{
                    $(".settings-error-notification").hide();
                    $(".set-new-pass-holder").prepend('<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> ' + result + '</div>');
                }
            })
            .fail(function(){
                $(".settings-error-notification").hide();
                $(".set-new-pass-holder").prepend('<div class="settings-error-notification" style="display: block;"><i class="fa fa-times" aria-hidden="true"></i> Please try again.</div>');
            });
    }, 500));
    
});
</script>
</body>

</html>