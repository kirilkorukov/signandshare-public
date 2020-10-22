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
    
    <title>Health - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="../images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Health - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/health/" />
    <meta property="og:title" content="Health - Sign & Share" />
    <meta property="og:description" content="Sign an existing petition or start your own, gain support and help change the world." />
    <meta property="og:image" content="https://www.signandshare.org/images/fb-image.jpg" />
    <meta property="fb:app_id" content="1411923905492915" />
<meta property="og:type"   content="website" /> 
</head>

<body>
<?php 
    include_once("../analyticstracking.php"); 
?>

<!-- Facebook SDK --> <div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=1635035403441162";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>

<div class="container">

<?php
    include("../header.php");
?>

<main class="index-page-wrapper">

    <div class="left-column left">
        <div class="category-title">Health</div>
        <?php
            $per_page = 10;
            $pages_query = mysqli_query($conn, 'SELECT id FROM petition WHERE category = "Health"');
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

            $mysql = 'SELECT title, image, path, currentSupporters, byWho, target, victory FROM petition WHERE category = "Health" ORDER BY id DESC LIMIT ' . $start . ',' . $per_page . '';
            $query = mysqli_query($conn,$mysql);
            if($row = mysqli_fetch_assoc($query)){
                echo '<div class="petition left">';

                if($row['image'] == ""){
                    echo '<a href="/p/' . $row['path'] . '/index"><div class="petition-element-image left" style="background-image: url(../images/default.jpg);"></div></a>';
                }
                else{
                    echo '<a href="/p/' . $row['path'] . '/index"><div class="petition-element-image left" style="background-image: url(/images/petitions/' . $row['image'] . ');"></div></a>';
                }
                    echo '<div class="petition-element-right-content">
                            <div class="petition-element-title left"><a href="/p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                            <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                            <div class="petition-signatures-box right">
                                <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                <a href="/p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">Sign</div></a>
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
                echo '<hr class="petition-element-hr">
                      <div class="petition left">';

                if($row['image'] == ""){
                    echo '<a href="/p/' . $row['path'] . '/index"><div class="petition-element-image left" style="background-image: url(../images/default.jpg);"></div></a>';
                }
                else{
                    echo '<a href="/p/' . $row['path'] . '/index"><div class="petition-element-image left" style="background-image: url(/images/petitions/' . $row['image'] . ');"></div></a>';
                }
                    echo '<div class="petition-element-right-content right">
                            <div class="petition-element-title left"><a href="/p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                            <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                            <div class="petition-signatures-box right">
                                <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                <a href="/p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">Sign</div></a>
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
                        <a href="index.php?page=' . $next . '"><div class="pagination-block">Load More</div></a>
                    </div>';
            }
        ?>
    </div>

    <?php
        include("../right-column.php");
    ?>

</main>

<?php
    include("../footer.php");
?>
</div>

<script type="text/javascript" src="../scripts.js"></script>
</body>

</html>


