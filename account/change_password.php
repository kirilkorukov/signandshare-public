<?php
    session_start();
    if(!isset($_SESSION['isLogged'])){
        header("Location: ../index.php");
    }
    require_once("../config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change password - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php 
    include_once("../analyticstracking.php"); 
?>

<div class="container">

<?php
    include("../header.php");
?>

<main class="edit-settings-main">
    <?php
        include("edit_settings_left_column.php");
    ?>
    <div class="settings-right-column">
        <div class="settings-success-notification"><i class="fa fa-check" aria-hidden="true"></i> Your password was successfully changed.</div>
        <div class="settings-error-notification"></div>
        <div class="title">Change password</div>
        <form method="post" id="change-password-form">
            <input type="password" class="input big-input" name="currentPass" placeholder="Current Password">
            <input type="password" class="input big-input" name="newPass" placeholder="New Password">
            <input type="password" class="input big-input" name="verifyPass" placeholder="Verify Password">

            <input type="button" class="update-settings-btn" value="Update">
        </form>
    </div>
    <?php 
        include("edit_settings_left_column_responsive.php");
    ?>
</main>

<?php
    include("../footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
<script>
    $(function(){
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

        $('.update-settings-btn').click(debounce(function(){
            if($.trim($("input[name='currentPass']").val()) == "" || $.trim($("input[name='newPass']").val()) == "" || $.trim($("input[name='verifyPass']").val()) == ""){
                $(".settings-success-notification").hide();
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $(".settings-error-notification").hide();
                $(".settings-error-notification").fadeIn(500);
                $(".settings-error-notification").html("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Please fill out all fields.");
            }
            else{
                $.ajax({
                    url: 'changePasswordRequest.php',
                    type: 'POST',
                    data: $("#change-password-form").serialize()
                })
                    .done(function(result){
                        if(result == "Success"){
                            $(".settings-error-notification").hide();
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $(".settings-success-notification").hide();
                            $(".settings-success-notification").fadeIn(500);
                        }
                        else{
                            $(".settings-success-notification").hide();
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $(".settings-error-notification").hide();
                            $(".settings-error-notification").fadeIn(500);
                            $(".settings-error-notification").html("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> " + result);
                        }
                    })
                    .fail(function(){
                        $(".settings-success-notification").hide();
                        $(".settings-error-notification").show();
                        $(".settings-error-notification").html();
                    });
            }
        }, 500));    
    });
</script>
</body>

</html>