<?php
    session_start();
    
    require_once("config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    if (empty($_GET)) {
        header("Location: index");
        exit;
    }
    else{
        $token = mysqli_real_escape_string($conn, $_GET['token']);
        $errorCode = 0;

        function base64_url_decode($input) {
            return base64_decode(strtr($input, '-_,', '+/='));
        }

        $email = base64_url_decode($token);

        $firstPreference = 1;
        $secondPreference = 1;
        $thirdPreference = 1;

        $getEmail = 'SELECT updates, suggested, tips FROM unsubscribe WHERE email = "' . $email . '" LIMIT 1';
        $getEmailQuery = mysqli_query($conn, $getEmail);

        if($row = mysqli_fetch_assoc($getEmailQuery)){
            $firstPreference = $row['update'];
            $secondPreference = $row['tips'];
            $thirdPreference = $row['suggested'];
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Unsubscribe - Sign and Share</title>
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
        <div class="title">Email me:</iv>
            <div class="email-preferences-wrapper" id="e-first">
                <div class="email-preferences-checkbox e-pref-box-1 <?php if($firstPreference == '1') echo 'email-preferences-checkbox-checked'; ?>"></div>
                <div class="email-preferences-text">When there is an update to a petition I've signed</div>
            </div>
            <div class="email-preferences-wrapper" id="e-second">
                <div class="email-preferences-checkbox e-pref-box-2 <?php if($secondPreference == '1') echo 'email-preferences-checkbox-checked'; ?>"></div>
                <div class="email-preferences-text">When Sign & Share has tips about a petition I've started</div>
            </div>
            <div class="email-preferences-wrapper" id="e-third">
                <div class="email-preferences-checkbox e-pref-box-3 <?php if($thirdPreference == '1') echo 'email-preferences-checkbox-checked'; ?>"></div>
                <div class="email-preferences-text">Suggested petitions</div>
            </div>
            <form method="post" id="edit-settings-form" style="width: 380px;">
                <input type="hidden" name="email-preference-1" id="e-preference-1" value="<?php echo $firstPreference; ?>">
                <input type="hidden" name="email-preference-2" id="e-preference-2" value="<?php echo $secondPreference; ?>">
                <input type="hidden" name="email-preference-3" id="e-preference-3" value="<?php echo $thirdPreference; ?>">
                <input type="hidden" name="email" value="<?php echo $token; ?>">

                <input type="button" class="update-settings-btn unsubscribe-btn" value="Update">
            </form>
        </div>
    </div>
</main>

<?php
    include("footer.php");       
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
<script>
        $("#e-first").click(function () {
            if ($("#e-preference-1").val() == "0") {
                $("#e-preference-1").val("1");
                console.log($("#e-preference-1").val());
                $(".e-pref-box-1").addClass("email-preferences-checkbox-checked");
            }
            else {
                $("#e-preference-1").val("0");
                $(".e-pref-box-1").removeClass("email-preferences-checkbox-checked");
            }
        });
        $("#e-second").click(function () {
            if ($("#e-preference-2").val() == "0") {
                $("#e-preference-2").val("1");
                $(".e-pref-box-2").addClass("email-preferences-checkbox-checked");
            }
            else {
                $("#e-preference-2").val("0");
                $(".e-pref-box-2").removeClass("email-preferences-checkbox-checked");
            }
        });
        $("#e-third").click(function () {
            if ($("#e-preference-3").val() == "0") {
                $("#e-preference-3").val("1");
                $(".e-pref-box-3").addClass("email-preferences-checkbox-checked");
            }
            else {
                $("#e-preference-3").val("0");
                $(".e-pref-box-3").removeClass("email-preferences-checkbox-checked");
            }
        });
</script>
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

    $('.unsubscribe-btn').click(debounce(function(){
        $.ajax({
            url: 'unsubscribeRequest.php',
            type: 'POST',
            data: $('#edit-settings-form').serialize(),
            beforeSend: function(){
                $(".unsubscribe-btn").hide();
                $(".unsubscribe-btn").after("<div class='loader-holder'><div class='loader' style='float: right;'></div></div>");
            }
        })
            .done(function(result){
                if(result == "Success"){
                    location.href = "unsubscribe_success";
                }
                else{
                    $(".unsubscribe-btn").show();
                    $(".loader").hide();
                    console.log(result);
                }
            })
            .fail(function(){
                console.log("failed");
            });
    }, 500)); 
});
</script>
</body>

</html>