<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Delete account -Sign & Share</title>
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
        <div class="title-delete">Are You Sure You Want To Delete Your Account?</div>
        <div class="after-title-text">Once you delete your account all your petitions will be deleted and can not be recovered.</div>

        <input type="submit" class="update-settings-btn cancel-btn" value="Cancel">
        <input type="submit" class="update-settings-btn" value="Delete my account" style="width: 200px;">
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
</body>

</html>