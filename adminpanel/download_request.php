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

    <title>Download requests - Sign and Share</title>
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
            $getDownloadRequests = mysqli_query($conn, 'SELECT * FROM download_signatures_requests ORDER BY id DESC');
        ?>

        <table>
            <tr>
                <td>Id</td>
                <td>Petition id</td>
                <td>User id</td>
                <td>Email</td>
                <td>Letter exits</td>
                <td>Format</td>
                <td>Date</td>
                <td>Send email</td>
            </tr>

            <?php
                while($row = mysqli_fetch_assoc($getDownloadRequests)){
                    if($row['letter'] != '') $letter = "Yes";
                    else $letter = "No";

                    echo '
                    <tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['petition_id'] . '</td>
                        <td>' . $row['user_id'] . '</td>
                        <td>' . $row['user_email'] . '</td>
                        <td>' . $letter . '</td>
                        <td>' . $row['format'] . '</td>
                        <td>' . $row['date'] . '</td>
                        <td><a href="download_request_info?id=' . $row['id'] . '">Send email</a></td>
                    </tr>
                    ';
                }
            ?>
        </table>
    </div>

</body>

</html>
