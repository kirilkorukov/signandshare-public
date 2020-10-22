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

    $errorCode = 0;

    if(isset($_POST['dimana'])){
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $zip = $_POST['zip'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $phoneNumber = $_POST['phoneNumber'];
        $website = $_POST['website'];
        $aboutMe = $_POST['aboutMe'];

        if($firstName == "" || $lastName == ""){
            $errorCode = 1;
        }
        else{
            $mysqlUpdate = 'UPDATE users SET firstName="' . $firstName . '",lastName="' . $lastName . '", address="' . $address . '",zip="' . $zip . '",city="' . $city . '",country="' . $country . '",state="' . $state . '",phoneNumber="' . $phoneNumber . '",website="' . $website . '",aboutMe="' . $aboutMe . '"  WHERE id = ' . $_SESSION['userId'];
            $query = mysqli_query($conn,$mysqlUpdate);

            if($query){
                $errorCode = 3;
                $_SESSION['name'] = $firstName;
            }
            else{
                $errorCode = 2;
            }
        }
    }

    $mysql = 'SELECT * FROM users WHERE id = ' . $_SESSION['userId'];
    $query = mysqli_query($conn,$mysql);
    if($row = mysqli_fetch_assoc($query)){
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $address = $row['address'];
        $zip = $row['zip'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];
        $phoneNumber = $row['phoneNumber'];
        $website = $row['website'];
        $aboutMe = $row['aboutMe'];
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit settings - Sign & Share</title>   
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
        <div class="settings-error-notification"><i class="fa fa-times" aria-hidden="true"></i></div>
        <div class="settings-success-notification"><i class="fa fa-check" aria-hidden="true"></i> Profile was successfully updated.</div>
        <div class="title">Your Information</div>
        <form method="post" id="edit-settings-form">
        <div class="double-input-holder">
            <input type="text" class="input small-input left" name="firstName" placeholder="First Name" value="<?php echo $firstName; ?>">
            <input type="text" class="input small-input right" name="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>">
        </div>
        <div class="double-input-holder">
            <?php 
                if($address != ""){
                    echo '<input type="text" class="input medium-input left" name="address" placeholder="Address" value="' . $address . '">';
                }
                else{
                    echo '<input type="text" class="input medium-input left" name="address" placeholder="Address">';
                }
                if($zip != ""){
                    echo '<input type="text" class="input extra-small-input left" name="zip" placeholder="ZIP" value="' . $zip . '">';
                }
                else{
                    echo '<input type="text" class="input extra-small-input left" name="zip" placeholder="ZIP">';
                }
            ?>
        </div>
        <div class="double-input-holder">
            <?php 
                if($city != "default"){
                    echo '<input type="text" class="input small-input left" name="city" style="margin-left: 0px !important;" placeholder="City" value="' . $city . '">';
                }
                else{
                    echo '<input type="text" class="input small-input left" name="city" style="margin-left: 0px !important;" placeholder="City">';
                }
            ?>
            
            <select class="country-select input small-input right small-select" name="state">
                <option value="1" selected="">State &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
        </div>
        <?php 
            if($row['country'] != "default"){
                include("select-country-registered.php");
            }
            else{
                include("select-country.php");
            }
        ?> 

        <hr class="small-hr">
        <div class="title middle-title">Additional Information</div>
        <?php 
            if($phoneNumber != ""){
                echo '<input type="text" class="input big-input left" placeholder="Phone Number" value="' . $phoneNumber . '" name="phoneNumber">';
            }
            else{
                echo '<input type="text" class="input big-input" placeholder="Phone Number" name="phoneNumber">';
            }
            if($website != ""){
                echo '<input type="text" class="input big-input left" placeholder="Website" value="' . $website . '" name="website">';
            }
            else{
                 echo '<input type="text" class="input big-input" placeholder="Website" name="website">';
            }
            if($aboutMe != ""){
                echo '<textarea class="input big-input about-me-input" placeholder="About Me" name="aboutMe">' . $aboutMe .'</textarea>';
            }
            else{
                 echo '<textarea class="input big-input about-me-input" placeholder="About Me" name="aboutMe"></textarea>';
            }
        ?>

        <input type="button" class="update-settings-btn" name="dimana" value="Update">
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
            if($.trim($("input[name='firstName']").val()) == "" || $.trim($("input[name='lastName']").val()) == ""){
                $(".settings-success-notification").hide();
                $(".settings-error-notification").html("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> First and last name can\'t be blank.");
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $(".settings-error-notification").hide();
                $(".settings-error-notification").fadeIn(500);
            }
            else{
                $.ajax({
                    url: 'editSettingsRequest.php',
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
                            $(".settings-error-notification").html("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Please contact administrators.");
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $(".settings-error-notification").hide();
                            $(".settings-error-notification").fadeIn(500);
                        }
                    })
                    .fail(function(){
                        $(".settings-success-notification").hide();
                        $(".settings-error-notification").html("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Please contact administrators.");
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $(".settings-error-notification").hide();
                        $(".settings-error-notification").fadeIn(500);
                    });
            }  
        }, 500));    
    });
</script>

</body>

</html>