<?php
    session_start();
    require_once("../config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

	/*
		Updates

		1. Number of victories
		2. Number of closed petitions
		3. Number of recent updates
	*/

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'> <!-- Roboto -->
    <script src=" https://use.fontawesome.com/dd65bc73a0.js " > </script>
</head>

<body>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=1220629807968024";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

    <?php
      $downloadsS = "SELECT id FROM download_signatures_requests";
      $downloadsQ = mysqli_query($conn, $downloadsS);
      $downloads = number_format(mysqli_num_rows($downloadsQ));

      $signaturesS = "SELECT id FROM user_petitions";
      $signaturesQ = mysqli_query($conn, $signaturesS);
      $signatures = mysqli_num_rows($signaturesQ);
      $earnings = ($signatures - 500)/300;

      $usersS = "SELECT id FROM users";
      $usersQ = mysqli_query($conn, $usersS);
      $users = number_format(mysqli_num_rows($usersQ));

      $petitionsS = "SELECT id FROM petition";
      $petitionsQ = mysqli_query($conn, $petitionsS);
      $petitions = number_format(mysqli_num_rows($petitionsQ));

      $victoriesS = "SELECT id FROM petition WHERE victory = 1";
      $victoriesQ = mysqli_query($conn, $victoriesS);
      $victories = number_format(mysqli_num_rows($victoriesQ));

      $closedS = "SELECT id FROM petition WHERE victory = 1";
      $closedQ = mysqli_query($conn, $closedS);
      $closed = number_format(mysqli_num_rows($closedQ));
    ?>

		<div class="admin-panel-holder">
        <div class="admin-panel-img"><a href="/petitions/recent"><img src="../images/logo3.png"></a></div>
        <a href="download_request"><div class="admin-panel-item blue">
          <div class="ap-choose-icon" style="background-color: #2094C9;"><i class="fa fa-cloud-download" aria-hidden="true"></i></div>
          <div class="ap-choose-title"><?php echo $downloads; ?> downloads</div>
        </div></a>
        <div class="admin-panel-item green">
          <div class="ap-choose-icon" style="background-color: #10A063;"><i class="fa fa-pencil-square" aria-hidden="true"></i></div>
          <div class="ap-choose-title"><?php echo number_format($signatures); ?> signatures</div>
        </div>
        <div class="admin-panel-item purple">
          <div class="ap-choose-icon" style="background-color: #741D88;"><i class="fa fa-user" aria-hidden="true"></i></div>
          <div class="ap-choose-title"><?php echo $users; ?> users</div>
        </div>
        <div class="admin-panel-item orange">
          <div class="ap-choose-icon" style="background-color: #DA9627;"><i class="fa fa-newspaper-o" aria-hidden="true"></i></div>
          <div class="ap-choose-title"><?php echo $petitions; ?> petitions</div>
        </div>

        <div class="admin-panel-petitions-item">
        	Expected earnings: <?php echo number_format($earnings,2,',',''); ?> лева
	        <br>
	        Expected earnings: €<?php echo number_format($earnings/1.95,2,',',''); ?>
	        <br>
        	<?php echo $victories; ?> victories
        	<br>
        	<?php echo $closed; ?> closed petitions
        </div>

        <div class="fb-like" style="float: left; margin-top: 30px;" data-href="https://www.facebook.com/Sign-Share-173219513163063/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
    </div>

</body>

</html>
