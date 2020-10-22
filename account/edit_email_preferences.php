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

    $mysql = 'SELECT emailPreferences FROM users WHERE id = ' . $_SESSION['userId'];
    $query = mysqli_query($conn,$mysql);
    if($row = mysqli_fetch_assoc($query)){
        $oldPreferences = $row['emailPreferences'];
    }
    $firstPreference = substr($oldPreferences,0,1);
    $secondPreference = substr($oldPreferences,1,1);
    $thirdPreference = substr($oldPreferences,2,1);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit email preferences - Sign & Share</title>
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
        <div class="settings-success-notification"><i class="fa fa-check" aria-hidden="true"></i> Your email preferences were successfully updated.</div>
        <div class="settings-error-notification"><i class="fa fa-times" aria-hidden="true"></i> Please contact administrators.</div>
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
            <form method="post" id="edit-settings-form">
                <input type="hidden" name="email-preference-1" id="e-preference-1" value="<?php echo $firstPreference; ?>">
                <input type="hidden" name="email-preference-2" id="e-preference-2" value="<?php echo $secondPreference; ?>">
                <input type="hidden" name="email-preference-3" id="e-preference-3" value="<?php echo $thirdPreference; ?>">

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
            $.ajax({
                url: 'editEmailPreferencesRequest.php',
                type: 'POST',
                data: $('#edit-settings-form').serialize()
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
                    }
                })
                .fail(function(){
                    $(".settings-success-notification").hide();
                    $(".settings-error-notification").show();
                });
        }, 500));    
    });
</script>

</body>

</html>