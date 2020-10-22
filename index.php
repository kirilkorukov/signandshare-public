<?php
    session_start();
    require_once("config.php");

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
    <meta name="google" content="notranslate" />
    <meta name="description" content="Sign an existing petition or start your own, gain support and help change the world." />

    <title>Sign & Share - Free online petitions</title>

    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
    <link rel="canonical" href="https://www.signandshare.org" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Sign & Share - Free online petitions">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org" />
    <meta property="og:title" content="Sign & Share - Free online petitions" />
    <meta property="og:description" content="Sign an existing petition or start your own, gain support and help change the world." />
    <meta property="og:image" content="https://www.signandshare.org/images/fb-image.jpg" />
    <meta property="fb:app_id" content="1411923905492915" />
    <meta property="og:type"   content="website" />
</head>

<body>
<?php
    include_once("analyticstracking.php");
?>

<div class="container">

<?php
    include("header.php");
?>

<div class="mobile-pod-header">
    <div class="mobile-pod-header-text">Sign an existing petition or start your own, gain support and help change the world.</div>
</div>

<main class="index-page-wrapper">
    <div class="index-3-steps">
        <img alt src="images/banner.png" style="width: 100%">
    </div>
    <div class="index-3-steps1">
        <div class="index-step" style="margin-left: 0px;"><a href="start-a-petition">START A PETITION</a></div>
        <div class="index-step2"><a href="start-a-petition">GAIN SUPPORT</a></div>
        <div class="index-step2"><a href="start-a-petition">CREATE CHANGE</a></div>
    </div>
    <div class="left-column left">
        <div class="featured-petitions/featured">
            <hr style="width: 100%; margin-top: 22px;">
            <div class="featured-petitions-title">Featured Petitions</div>
        </div>
        <?php
            $per_page = 10;
            $pages_query = mysqli_query($conn, 'SELECT id FROM petition WHERE featured = 1');

            $pages = ceil(mysqli_num_rows($pages_query)/$per_page );
            if(!isset($_GET['page']))
            {
                $page = 1;
            }
            else{
                $page = mysqli_real_escape_string($conn, $_GET['page']);
            }
            $next = $page+1;
            $start = (($page-1)*$per_page);

            $mysql = 'SELECT title, image, path, currentSupporters, byWho, target, victory FROM petition WHERE featured = 1 ORDER BY id DESC LIMIT ' . $start . ',' . $per_page . '';
            $query = mysqli_query($conn,$mysql);
            $petitionNumber = 1;
            if($row = mysqli_fetch_assoc($query)){
                echo '<div class="petition left">';

                if($row['image'] == ""){
                    echo '<a href="p/' . $row['path'] . '/index"><div class="petition-element-image left" style="background-image: url(images/default.jpg);"></div></a>';
                }
                else{
                    echo '<a href="p/' . $row['path'] . '/index"><div class="petition-element-image left" style="background-image: url(/images/petitions/' . $row['image'] . ');"></div></a>';
                }
                    echo '<div class="petition-element-right-content">
                            <div class="petition-element-title left"><a href="p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                            <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                            <div class="petition-signatures-box right">
                                <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                <a href="p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">Sign</div></a>
                            </div>
                            <div class="petition-element-by-to left">by ' . $row['byWho'] . ' to ' . $row['target'];
                            if($row['victory'] == 1){
                                echo '<div class="petition-element-victory-label"> Victory</div>';
                            }
                            echo '</div>
                        </div>
                    </div>';
            }
            while($row = mysqli_fetch_assoc($query)){
                /*if($petitionNumber == 4){
                    echo '<div class="ad-unit-square"><img alt src="/images/ad-unit-square.jpg" style="width: 100%"></div>';
                }
                $petitionNumber++;  */

                echo '<hr class="petition-element-hr">
                      <div class="petition left">';

                if($row['image'] == ""){
                    echo '<a href="p/' . $row['path'] . '/index"><div class="petition-element-image left" style="background-image: url(images/default.jpg);"></div></a>';
                }
                else{
                    echo '<a href="p/' . $row['path'] . '/index"><div class="petition-element-image left" style="background-image: url(/images/petitions/' . $row['image'] . ');"></div></a>';
                }
                    echo '<div class="petition-element-right-content right">
                            <div class="petition-element-title left"><a href="p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                            <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                            <div class="petition-signatures-box right">
                                <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                <a href="p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">Sign</div></a>
                            </div>
                            <div class="petition-element-by-to left">by ' . $row['byWho'] . ' to ' . $row['target'];
                            if($row['victory'] == 1){
                                echo '<div class="petition-element-victory-label"> Victory</div>';
                            }
                            echo '</div>
                        </div>
                    </div>';
            }
            if($pages > 1 && $next <= $pages){
                echo ' <div class="pagination">
                        <a href="petitions/featured?page=' . $next . '"><div class="pagination-block">Load More</div></a>
                    </div>';
            }
        ?>
        <div class="start-petition-banner-index">
            <div class="start-petition-banner-text">Is there a cause you are passionate about? Start a free online petition and bring the change you want to see!</div>
            <a href="/start"><div class="start-petition-banner-big-button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Start a petition</div></a>
        </div>
    </div>

    <?php
        include("right-column.php");
    ?>

</main>


<?php
    include("footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
</body>

</html>
