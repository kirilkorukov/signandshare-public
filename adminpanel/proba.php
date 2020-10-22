<?php
    session_start();
    require_once("../config.php");

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

    <title>Sign and Share - Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'> <!-- Roboto -->
    <script src=" https://use.fontawesome.com/dd65bc73a0.js " > </script>
</head>

<body>

    <?php
		    $getEmails = 'SELECT DISTINCT email FROM user_petitions';
        $getEmailsQuery = mysqli_query($conn, $getEmails);

        while($row = mysqli_fetch_assoc($getEmailsQuery)){
            $token = $row['token'];
            $emailEncoded = $row['email'];
            $token = mysqli_real_escape_string($conn, $_GET['token']);

            $email = base64_decode(strtr($emailEncoded, '-_,', '+/='));
            echo $email . "<br>";
        }
	?>

    <div class="admin-panel-holder">
        <div class="admin-panel-img"><a href="/petitions/recent"><img src="../images/logo3.png"></a></div>

        <div class="admin-panel-send-email-title">Send email</div>
        From: <input type="number" name="from">
        <br>
        To: <input type="number" name="to">
    </div>

</body>

</html>
