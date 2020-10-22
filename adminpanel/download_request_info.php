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

    <title>Download request info - Sign and Share</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'> <!-- Roboto -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
    <script src=" https://use.fontawesome.com/dd65bc73a0.js " > </script>
</head>

<body>

    <div class="admin-panel-holder">
        <div class="admin-panel-img"><a href="/adminpanel/"><img src="../images/logo3.png"></a></div>

        <?php
            $id = $_GET['id'];
            $getDownloadRequests = mysqli_query($conn, 'SELECT user_email, petition_id, letter FROM download_signatures_requests WHERE id = ' . $id);
            if($row = mysqli_fetch_assoc($getDownloadRequests)){
                $petition_id = $row['petition_id'];
                $email = $row['user_email'];
                $letter = $row['letter'];
            }

            $getPetitionData = mysqli_query($conn, 'SELECT title, byWho FROM petition WHERE id = ' . $petition_id);
            if($row2 = mysqli_fetch_assoc($getPetitionData)){
                $petition_starter = $row2['byWho'];
                $petition_name = $row2['title'];
            }
        ?>

        <input type="text" value="<?php echo $email; ?>" id="email-input">
        <br><br>
        <input type="text" value="Signatures ready for <?php echo $petition_name; ?>" id="subject-input">
        <br><br>
        <textarea id="text-input">Dear <?php echo $petition_starter; ?>,

The signature document for your petition, <?php echo $petition_name; ?>, is ready for download!

We've attached the file to this email. If you have any questions, feel free to contact us at help@signandshare.org</textarea>
        <br><br>
        SQL Query:
        <br>
        <input type="text" value="SELECT firstName, lastName, country, city, date, reason FROM `user_petitions` WHERE petition_id = <?php echo $petition_id; ?>" id="query-input">

        <?php
            if($letter != ''){
                echo '<br><br><br>';
                echo 'Letter:';
                echo '<br>';
                echo '<textarea id="letter-input">' . $letter . '</textarea>';
            }
        ?>

    </div>

<script>
    $(document).ready(function(){
        $("#email-input").click(function(){
            $("#email-input").select();
        });

        $("#subject-input").click(function(){
            $("#subject-input").select();
        });

        $("#text-input").click(function(){
            $("#text-input").select();
        });

        $("#query-input").click(function(){
            $("#query-input").select();
        });

        $("#letter-input").click(function(){
            $("#letter-input").select();
        });
    });
</script>

</body>

</html>
