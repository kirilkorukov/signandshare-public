<?php
    session_start();

    include("petitionId.php");

    $date;
    $signed = false;
    $loggedIn = false;
    $starter = false;

    require_once("../../config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    if(isset($_SESSION['isLogged'])){
        $userId = $_SESSION['userId'];
        $loggedIn = true;

        $isPetitionStarterSql = 'SELECT id FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if($isPetitionStarterQuery){
            if($row = mysqli_fetch_assoc($isPetitionStarterQuery)){
                $starter = true;
            }
        }

        function isSigned($userId, $petitionId, $conn){
            $checkIfIsSignedSql = 'SELECT date FROM user_petitions WHERE user_id = ' . $userId . ' AND petition_id = ' . $petitionId;
            $checkIfIsSignedQuery = mysqli_query($conn, $checkIfIsSignedSql);

            if($row = mysqli_fetch_assoc($checkIfIsSignedQuery)){
                $date = $row['date'];
                return $date;
            }
            else{
                return "Not signed";
            }
        }
        if(isSigned($userId, $petitionId, $conn) != "Not signed"){
            $date = isSigned($userId, $petitionId, $conn);
            $date = strtotime( $date );
            $dateSigned = date( 'F d, Y', $date );
            $signed = true;
        }
    }

    $isClosedOrVictory = 'SELECT date, closed, victory, currentSupporters, goalSupporters, image, title, category, overview, path, byWho, target FROM petition WHERE id = ' . $petitionId;
    $isClosedOrVictoryQuery = mysqli_query($conn, $isClosedOrVictory);
    if(!$isClosedOrVictoryQuery){
        die("Error");
    }
    else{
        if($row = mysqli_fetch_assoc($isClosedOrVictoryQuery)){
            $title = $row['title'];
            $path = $row['path'];
            $category = $row['category'];
            $overview = $row['overview'];
            $overviewForShare = substr($row['overview'],0,170) . "...";
            $byWho = $row['byWho'];
            $target = $row['target'];
            $closed = $row['closed'];
            $victory = $row['victory'];
            $image = $row['image'];
            if($image == ""){
                $imageForShare = "fb-image.jpg";
            }
            else{
                $imageForShare = "petitions/" . $image;
            }
            $date = $row['date'];
            $currentSupporters = $row['currentSupporters'];
            $goalSupporters = $row['goalSupporters'];
            $neededSupporters = $goalSupporters - $currentSupporters;
            $percentSupporteres = ceil($currentSupporters * 100 / $goalSupporters);
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $overviewForShare; ?>" />

    <title><?php echo $title; ?> - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Petition: <?php echo $title; ?>">
    <meta name="twitter:description" content="<?php echo $overviewForShare; ?>">
    <meta name="twitter:image" content="https://www.signandshare.org/images/<?php echo $imageForShare; ?>">

    <meta property="og:url" content="https://www.signandshare.org/p/<?php echo $path; ?>/" />
    <meta property="og:title" content="Petition: <?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $overviewForShare; ?>" />
    <meta property="og:image" content="https://www.signandshare.org/images/<?php echo $imageForShare; ?>" />
    <meta property="fb:app_id" content="1411923905492915" />
    <meta property="og:type"   content="website" /> 

    <style>
        @keyframes razshirqvane {
            from { width: 0%;}
            to {width: <?php echo $percentSupporteres; ?>%;}
        }
    </style>
</head>

<body>

<?php
    include_once("../../analyticstracking.php");
?>

<!-- Facebook SDK --> <div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=1635035403441162";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>

<div class="container">

<?php
    include("../../header.php");
?>

<main class="petition-page-wrapper">
    <div class="left-column left">
        <?php
            if($starter == 1){
                echo '<div class="my-petition-dashboard-button"> <i class="fa fa-eye" aria-hidden="true"></i> Show dashboard</div>';
            }

            if($closed == 1){
                echo '<div class="petition-closed-label-top"><i class="fa fa-lock" aria-hidden="true"></i> Petition closed</div>';
            }
            else if($victory == 1){
                echo '<div class="petition-victory-label-top"><i class="fa fa-trophy" aria-hidden="true"></i> Confirmed Victory</div>';
            }
            if($starter == false){
                if($image != ""){
                    echo '<div class="petition-img" style="display: block; background-image: url(/images/petitions/' . $row['image'] . ');"></div>
                        <div class="image-corner-wrapper">
                            <div class="image-corner-left"></div>
                            <div class="image-corner-right"></div>
                        </div>';
                }
            }
            else{
                if($image == ""){
                    echo '<div class="add-image-holder">
                            <div class="add-image"><img alt src="/images/photo-camera.png" style="width: 100%"></div>
                            <a href="edit#image" class="add-image-btn">Add Image</a>
                            <div class="add-image-text">Petition with images tend to get 6 times more signatures.<span class="make-new-line-add-image"><br></span> Make sure you have the permission to use this image, if it is not your own</div>
                        </div>';
                }
                else{
                    echo '<div class="petition-img" style="display: block; background-image: url(/images/petitions/' . $row['image'] . ');"></div>
                        <div class="image-corner-wrapper">
                            <div class="image-corner-left"></div>
                            <div class="image-corner-right"></div>
                        </div>';
                }
            }
        ?>
        <div class="petition-title"><?php echo $title; ?></div>
        <div class="petition-by"><font style="font-family: 'droid-sans-bold', sans-serif;font-weight: 600;">By:</font> <?php echo $byWho; ?></div>
        <div class="petition-to"><font style="font-family: 'droid-sans-bold', sans-serif;font-weight: 600;">To:</font> <?php echo $target; ?></div>

        <?php
            if($victory == 1){
                include('victory_message.php');
            }
            else{
                echo '<div class="petition-progress-holder-1">
                        <div class="petition-progress-supporters">' . number_format($currentSupporters) . ' supporters</div>
                        <div class="petition-progress-holder-2">
                            <div class="petition-progress-line-inside" style="width: ' . $percentSupporteres . '%;'; if($closed == 1){ echo 'background-color: #7a7a7a;'; } echo '"></div>
                        </div>
                        <div class="petition-progress-holder-3">
                            ' . number_format($neededSupporters) . ' needed to reach ' . number_format($goalSupporters) . '
                        </div>
                    </div>';
            }

        ?>
        <?php
            if($starter == 1){

            }
            else if($loggedIn == true){
                if($signed == false){
                    if($closed == 0 && $victory == 0){
                        $getUserDataSql = 'SELECT firstName,lastName,email,country,city FROM users WHERE id = ' . $userId;
                        $getUserDataQuery = mysqli_query($conn, $getUserDataSql);

                        if($row = mysqli_fetch_assoc($getUserDataQuery)){

                            echo '<div class="sign-petition-mobile-btn">
                                    <div class="sign-petition-btn center" style="padding-bottom: 0px; height: 32px;">Sign Petition</div>
                                </div>';
                            }
                        }
                    }
                    else{
                        echo '<div class="you-took-action-mobile-holder">
                                <div class="you-took-action-title">' . $_SESSION['name'] . ',<br> you took action on ' . $dateSigned . '</div>
                            </div>';
                    }
            }
            else if($closed == 0 && $victory == 0){
                echo '<div class="sign-petition-mobile-btn">
                        <div class="sign-petition-btn center" style="padding-bottom: 0px; height: 32px;">Sign Petition</div>
                    </div>';
            }
        ?>
        <div class="petition-overview-title">Overview</div>
        <div class="petition-description"><?php echo $overview; ?></div>
        <div class="petition-overview-title">Petition activity</div>
        <ul class="petition-inside-buttons">
            <li class="pet-btn-first blue"><i class="fa fa-rss" aria-hidden="true"></i>&nbsp;&nbsp;Updates</li>
            <li class="pet-btn-second"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;&nbsp;Comments</li>
            <li class="pet-btn-third"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Supporters</li>
        </ul>
        <div class="fb-comment"><div class="fb-comments" data-href="<?php echo $actual_link; ?>" data-width="100%" data-numposts="3"></div></div>
        <div class="petition-updates">
            <div class="petition-updates-inside"></div>
            <div class="petition-update-holder" style="border-bottom: 0px;">
                <div class="petition-update-label"><i class="fa fa-rss" aria-hidden="true"></i>&nbsp;&nbsp;Petition Started</div>
                <div class="petition-update-posted"><?php echo date('d F Y', strtotime($date)); ?></div>
            </div>
        </div>
        <div class="supporters">
            <?php
                $getSupporters = 'SELECT firstName, lastName, public, date, reason, country FROM user_petitions WHERE petition_id = ' . $petitionId . ' ORDER BY id DESC LIMIT 10';
                $getSupportersQuery = mysqli_query($conn, $getSupporters);

                $start_from = 10;

                if(!$getSupportersQuery){
                    die("Error");
                    exit;
                }
                else{
                    while($row = mysqli_fetch_assoc($getSupportersQuery)){
                        $date = strtotime($row['date']);
                        if($row['public'] == 0){
                            $names = "Name not displayed";
                        }
                        else{
                            $names = $row['firstName'] . ' ' . $row['lastName'];
                        }
                        echo '<div class="supporters-item">
                                <div class="supporter-img"><img alt src="/images/supporter.png" style="width: 100%"></div>
                                <div class="supporter-name">' . $names . ' <span class="supporter-date">signed ' . time_elapsed_string(date("Y-m-d G:H:s", $date)) . '</span> <br> <div class="supporter-country">' . $row['country'] . '</div></div>
                                <div class="supporter-reason-for-signing">' . $row['reason'] . '</div>
                            </div>';
                    }
                }

                if($currentSupporters > 10){
                    echo '<div class="load-more-supporters"><i class="fa fa-chevron-down" aria-hidden="true"></i> Load more</div>';
                }
            ?>
        </div>
        <!--<div class="report-policy-violation"><i class="icon-flag-filled"></i> Report a policy violation</div>-->
    </div>
        <?php
            if($starter == true){
                echo '<div class="right-column right">';
                    include("../../my_petition_right_column.php");

                    if($signed == true){
                        echo '<div class="you-took-action-title" style="float: left; margin-top: 60px;">' . $_SESSION['name'] . ',<br> you took action on ' . $dateSigned . '</div>';
                    }
                    else{
                        $getUserDataSql = 'SELECT firstName,lastName,email,country,city FROM users WHERE id = ' . $userId;
                        $getUserDataQuery = mysqli_query($conn, $getUserDataSql);

                        if($row = mysqli_fetch_assoc($getUserDataQuery)){

                            echo '
                                <div class="petition-holder" style="position: static !important; float: left; margin-top: 0px !important; width: 100% !important;">
                                    <div class="victory-right-column-title" style="margin-top: 60px; margin-bottom: 20px;">Sign Petition</div>
                                    <form method="POST" class="sign-petition-form">
                                        <input type="text" class="input sign-petition-input" value="' . $row['firstName'] . '" placeholder="First Name" name="firstName">
                                        <div class="sign-petition-error spe1">Please enter a first name.</div>
                                        <input type="text" class="input sign-petition-input" value="' . $row['lastName'] . '" placeholder="Last Name" name="lastName">
                                        <div class="sign-petition-error spe2">Please enter a last name.</div>
                                        <input type="email" class="input sign-petition-input" value="' . $row['email'] . '" placeholder="Email Address" name="email">
                                        <div class="sign-petition-error spe3">Please enter an email address.</div>';


                                        if($row['country'] != "default"){
                                            include("../../select-country-registered.php");
                                            $isCountrySet = true;
                                        }
                                        else{
                                            include("../../select-country.php");
                                            $isCountrySet = false;
                                        }

                                        echo '<div class="sign-petition-error spe4">Please select a country.</div>';

                                        if($row['city'] != "default"){
                                            echo '<input type="text" class="input sign-petition-input" value="' . $row['city']  . '"  placeholder="City" name="city">';
                                            $isCityySet = true;
                                        }
                                        else{
                                            echo '<input type="text" class="input sign-petition-input" placeholder="City" name="city">';
                                            $isCitySet = false;
                                        }

                                        echo '<div class="sign-petition-error spe5">Please enter a city.</div>
                                        <textarea placeholder="Reason for signing... (optional)" class="reason-for-signing" name="reasonForSigning"></textarea>
                                        <input type="button" value="Sign Now" class="sign-petition-btn center sign-petition-btn-trigger" name="submitSignature">
                                        <input name="davai" id="anonymous1" type="checkbox" tabindex="-1" value="1">
                                        <label for="anonymous1" tabindex="-1" class="checkbox-label">Don\'t display my name</label>
                                        <div class="by-signing-you-accept">
                                            By signing, you accept signandshare.org’s <a href="/about/terms-of-service">terms of service</a> and <a href="/about/privacy-policy">privacy policy</a>
                                        </div>
                                        <input type="hidden" name="isCountrySet" value="' . $isCountrySet . '">
                                        <input type="hidden" name="isCitySet" value="' . $isCountrySet . '">
                                    </form>
                                </div>';
                        }
                    }
                echo "</div>";
            }
            else if($victory == 1){
                include('../../victory_column.php');
            }
            else if($closed == 1){
                 include('../../closed_petition_column.php');
            }
            else if($loggedIn == true){
                if($signed == false){
                    $getUserDataSql = 'SELECT firstName,lastName,email,country,city FROM users WHERE id = ' . $userId;
                    $getUserDataQuery = mysqli_query($conn, $getUserDataSql);

                    if($row = mysqli_fetch_assoc($getUserDataQuery)){

                        echo '<div class="right-column right">
                            <div class="petition-holder">
                                <div class="sign-petition-title center">Sign Petition</div>
                                <form method="POST" class="sign-petition-form">
                                    <input type="text" class="input sign-petition-input" value="' . $row['firstName'] . '" placeholder="First Name" name="firstName">
                                    <div class="sign-petition-error spe1">Please enter a first name.</div>
                                    <input type="text" class="input sign-petition-input" value="' . $row['lastName'] . '" placeholder="Last Name" name="lastName">
                                    <div class="sign-petition-error spe2">Please enter a last name.</div>
                                    <input type="email" class="input sign-petition-input" value="' . $row['email'] . '" placeholder="Email Address" name="email">
                                    <div class="sign-petition-error spe3">Please enter an email address.</div>';


                                    if($row['country'] != "default"){
                                        include("../../select-country-registered.php");
                                        $isCountrySet = true;
                                    }
                                    else{
                                        include("../../select-country.php");
                                        $isCountrySet = false;
                                    }

                                    echo '<div class="sign-petition-error spe4">Please select a country.</div>';

                                    if($row['city'] != "default"){
                                        echo '<input type="text" class="input sign-petition-input" value="' . $row['city']  . '"  placeholder="City" name="city">';
                                        $isCityySet = true;
                                    }
                                    else{
                                        echo '<input type="text" class="input sign-petition-input" placeholder="City" name="city">';
                                        $isCitySet = false;
                                    }

                                    echo '<div class="sign-petition-error spe5">Please enter a city.</div>
                                    <textarea placeholder="Reason for signing... (optional)" class="reason-for-signing" name="reasonForSigning"></textarea>
                                    <input type="button" value="Sign Now" class="sign-petition-btn center sign-petition-btn-trigger" name="submitSignature">
                                    <input name="davai" id="anonymous2" type="checkbox" tabindex="-1" value="1">
                                    <label for="anonymous2" tabindex="-1" class="checkbox-label">Don\'t display my name</label>
                                    <div class="by-signing-you-accept">
                                        By signing, you accept signandshare.org’s <a href="/about/terms-of-service">terms of service</a> and <a href="/about/privacy-policy">privacy policy</a>
                                    </div>
                                    <input type="hidden" name="isCountrySet" value="' . $isCountrySet . '">
                                    <input type="hidden" name="isCitySet" value="' . $isCountrySet . '">
                                </form>
                            </div>
                            </div>';
                        }
                    }
                    else{
                        echo '<div class="right-column right">
                                <div class="you-took-action-title">' . $_SESSION['name'] . ',<br> you took action on ' . $dateSigned . '</div>
                                <div class="victory-right-column-second-title" style="width:100%;">You can help by sharing:</div>
                                <div class="victory-share-buttons">
                                    <a href=""><div class="victory-share-btn share-btn-fb"><i class="fa fa-facebook-official" aria-hidden="true"></i></div></a>
                                    <a href=""><div class="victory-share-btn share-btn-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></div></a>
                                    <a href=""><div class="victory-share-btn share-btn-google"><i class="fa fa-google-plus" aria-hidden="true"></i></div></a>
                                </div>
                                <div class="victory-right-column-second-title">Other urgent petitions:</div>';
                                $otherUrgentPetitions = 'SELECT path, image, title FROM petition WHERE victory = 0 AND closed = 0 AND featured = 1 LIMIT 3';
                                $otherUrgentPetitionsQuery = mysqli_query($conn, $otherUrgentPetitions);

                                if(!$otherUrgentPetitions){
                                    die("Error");
                                    exit;
                                }
                                else{
                                    $i = 0;

                                    while($row = mysqli_fetch_assoc($otherUrgentPetitionsQuery)){
                                        $i++;

                                        if($i == 3){
                                            echo '<div class="victory-other-petition" style="border-bottom: none;">';
                                        }
                                        else{
                                            echo '<div class="victory-other-petition">';
                                        }

                                        if($row['image'] == ""){
                                            echo '<a href="/p/' . $row['path'] . '/index"><div class="victory-other-petition-img"><img alt src="/images/default.jpg" width="100%" height="100%"></div></a>';
                                        }
                                        else{
                                            echo '<a href="/p/' . $row['path'] . '/index"><div class="victory-other-petition-img"><img alt src="/images/petitions/' . $row['image'] . '" width="100%" height="100%"></div></a>';
                                        }

                                        echo '<a href="/p/' . $row['path'] . '/index"><div class="victory-other-petition-title">' . $row['title'] . '</div></a>
                                            </div>';
                                    }
                                }
                                echo '<div class="right-column-start-petition-banner">
                                    <div class="right-column-start-petition-banner-text">Sign an existing petition or start your own, gain support and help change the world for the better.</div>
                                    <a href="/start"><div class="start-petition-banner-button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Start a petition</div></a>
                                </div>';
                    }
            }
            else{
                echo '<div class="right-column right">
                    <div class="petition-holder">
                        <div class="sign-petition-title center">Sign Petition</div>
                        <form method="POST" class="sign-petition-form">
                            <input type="text" class="input sign-petition-input" placeholder="First Name" name="firstName">
                            <div class="sign-petition-error spe1">Please enter a first name.</div>
                            <input type="text" class="input sign-petition-input" placeholder="Last Name" name="lastName">
                            <div class="sign-petition-error spe2">Please enter a last name.</div>
                            <input type="email" class="input sign-petition-input" placeholder="Email Address" name="email">
                            <div class="sign-petition-error spe3">Please enter an email address.</div>
                            ';
                include("../../select-country.php");
                echo '      <div class="sign-petition-error spe4">Please select a country.</div>
                            <input type="text" class="input sign-petition-input" placeholder="City" name="city">
                            <div class="sign-petition-error spe5">Please enter a city.</div>
                            <textarea placeholder="Reason for signing... (optional)" class="reason-for-signing" name="reasonForSigning"></textarea>
                            <input type="button" value="Sign Now" class="sign-petition-btn center sign-petition-btn-trigger" name="submitSignature">
                            <input name="davai" id="anonymous3" type="checkbox" tabindex="-1" value="1">
                            <label for="anonymous3" tabindex="-1" class="checkbox-label">Don\'t display my name</label>
                            <div class="by-signing-you-accept">
                                By signing, you accept signandshare.org’s <a href="/about/terms-of-service">terms of service</a> and <a href="/about/privacy-policy">privacy policy</a>
                            </div>
                        </form>
                    </div>
                    </div>';
            }
        ?>

        <?php
            if($starter == 1){

            }
            else if($loggedIn == true){
                if($signed == false){
                    if($closed == 0 && $victory == 0){
                        $getUserDataSql = 'SELECT firstName,lastName,email,country,city FROM users WHERE id = ' . $userId;
                        $getUserDataQuery = mysqli_query($conn, $getUserDataSql);

                        if($row = mysqli_fetch_assoc($getUserDataQuery)){

                            echo '<div class="petition-mobile-holder">
                                    <div class="sign-petition-title center">Sign Petition</div>
                                    <form method="POST" class="sign-petition-form-mobile">
                                        <input type="text" class="input sign-petition-input" value="' . $row['firstName'] . '" placeholder="First Name" name="firstNameMobile">
                                        <div class="sign-petition-error spe1">Please enter a first name.</div>
                                        <input type="text" class="input sign-petition-input" value="' . $row['lastName'] . '" placeholder="Last Name" name="lastNameMobile">
                                        <div class="sign-petition-error spe2">Please enter a last name.</div>
                                        <input type="email" class="input sign-petition-input" value="' . $row['email'] . '" placeholder="Email Address" name="emailMobile">
                                        <div class="sign-petition-error spe3">Please enter an email address.</div>';


                                        if($row['country'] != "default"){
                                            include("../../select-country-registered-mobile.php");
                                            $isCountrySet = true;
                                        }
                                        else{
                                            include("../../select-country-mobile.php");
                                            $isCountrySet = false;
                                        }

                                        echo '<div class="sign-petition-error spe4">Please select a country.</div>';

                                        if($row['city'] != "default"){
                                            echo '<input type="text" class="input sign-petition-input" value="' . $row['city']  . '"  placeholder="City" name="cityMobile">';
                                            $isCityySet = true;
                                        }
                                        else{
                                            echo '<input type="text" class="input sign-petition-input" placeholder="City" name="cityMobile">';
                                            $isCitySet = false;
                                        }

                                        echo '<div class="sign-petition-error spe5">Please enter a city.</div>
                                        <textarea placeholder="Reason for signing... (optional)" class="reason-for-signing" name="reasonForSigningMobile"></textarea>
                                        <input type="button" value="Sign Now" class="sign-petition-btn center sign-petition-mobile-btn-trigger" name="submitSignatureMobile">
                                        <input name="davaiMobile" id="anonymous4" type="checkbox" tabindex="-1" value="1">
                                        <label for="anonymous4" tabindex="-1" class="checkbox-label">Don\'t display my name</label>
                                        <div class="by-signing-you-accept">
                                            By signing, you accept signandshare.org’s <a href="/about/terms-of-service">terms of service</a> and <a href="/about/privacy-policy">privacy policy</a>
                                        </div>
                                        <input type="hidden" name="isCountrySetMobile" value="' . $isCountrySet . '">
                                        <input type="hidden" name="isCitySetMobile" value="' . $isCountrySet . '">
                                    </form>
                                    <div class="petition-mobile-go-back"><i class="fa fa-chevron-left" aria-hidden="true"></i> Go back to the petition</div>
                                </div>';
                            }
                        }
                    }
                    else{
                        echo '<div class="you-took-action-mobile-holder">
                                <div class="you-took-action-title">' . $_SESSION['name'] . ',<br> you took action on ' . $dateSigned . '</div>
                            </div>';
                    }
            }
            else if($closed == 0 && $victory == 0){
                echo '<div class="petition-mobile-holder">
                        <div class="sign-petition-title center">Sign Petition</div>
                        <form method="POST" class="sign-petition-form-mobile">
                            <input type="text" class="input sign-petition-input" placeholder="First Name" name="firstNameMobile">
                            <div class="sign-petition-error spe1">Please enter a first name.</div>
                            <input type="text" class="input sign-petition-input" placeholder="Last Name" name="lastNameMobile">
                            <div class="sign-petition-error spe2">Please enter a last name.</div>
                            <input type="email" class="input sign-petition-input" placeholder="Email Address" name="emailMobile">
                            <div class="sign-petition-error spe3">Please enter an email address.</div>
                            ';
                include("../../select-country-mobile.php");
                echo '      <div class="sign-petition-error spe4">Please select a country.</div>
                            <input type="text" class="input sign-petition-input" placeholder="City" name="cityMobile">
                            <div class="sign-petition-error spe5">Please enter a city.</div>
                            <textarea placeholder="Reason for signing... (optional)" class="reason-for-signing" name="reasonForSigningMobile"></textarea>
                            <input type="button" value="Sign Now" class="sign-petition-btn center sign-petition-mobile-btn-trigger" name="submitSignatureMobile">
                            <input name="davaiMobile" id="anonymous5" type="checkbox" tabindex="-1" value="1">
                            <label for="anonymous5" tabindex="-1" class="checkbox-label">Don\'t display my name</label>
                            <div class="by-signing-you-accept">
                                By signing, you accept signandshare.org’s <a href="/about/terms-of-service">terms of service</a> and <a href="/about/privacy-policy">privacy policy</a>
                            </div>
                        </form>
                        <div class="petition-mobile-go-back"><i class="fa fa-chevron-left" aria-hidden="true"></i> Go back to the petition</div>
                    </div>';
            }
        ?>
</main>

<?php
    include("../../footer.php");
?>
</div>

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

        var petition_id = <?php echo $petitionId; ?>;
        var start_from = <?php echo $start_from; ?>;
        var current_supporters = <?php echo $currentSupporters; ?>;

        $(".load-more-supporters").click(debounce(function(){
            $.ajax({
                url: '/moreSupportersQuery.php',
                type: 'POST',
                data: { petition_id : petition_id, start_from : start_from},
                beforeSend: function(){
                    $(".load-more-supporters").after("<div class='loader' style='margin-top: 10px; margin-bottom: 10px;'></div>");
                    $(".load-more-supporters").hide();
                }
            })
                .done(function(result){
                    if(result != "Error"){
                        setTimeout(function() {
                            $(".load-more-supporters").show();
                            $(".loader").hide();
                            $(result).insertBefore(".load-more-supporters");
                            if(start_from + 15 >= current_supporters){
                                $(".load-more-supporters").hide();
                            }
                            else{
                                start_from += 15;
                            }
                        }, 800);
                    }
                    else{
                        $(".load-more-supporters").html("An error occurred. Please, try again later.");
                        $(".loader").hide();
                    }
                })
                .fail(function(){
                    $(".load-more-supporters").show();
                    $(".loader").hide();
                });
        }, 400));
    });
</script>
<script type="text/javascript" src="/scripts/scripts.js"></script>
<script type="text/javascript" src="/scripts/scripts-petitions.js"></script>
</body>

</html>
