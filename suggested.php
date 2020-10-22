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

    <title>Suggested petitions - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Suggested petitions - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/suggested" />
    <meta property="og:title" content="Suggested petitions - Sign & Share" />
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

<div class="search-page-holder">
    <div class="search-title">Suggested petitions</div>
    <?php
            $mysql = 'SELECT title, image, path, currentSupporters, byWho, target FROM petition  ORDER BY id DESC LIMIT 10';
            $query = mysqli_query($conn,$mysql);

            $numberOfRows = mysqli_num_rows($query);
            if ($numberOfRows==0) {
                echo '<div class="search-results">No petitions were found.</div>';
            }
            else{
                if($row = mysqli_fetch_assoc($query)){
                echo '<div class="search-petition left">';
                    if($row['image'] == ""){
                        echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(images/default.jpg);"></div></a>';
                    }
                    else{
                        echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(images/petitions/' . $row['image'] . ');"></div></a>';
                    }
                    echo '<div class="search-petition-element-right-content right">
                            <div class="search-petition-element-title left"><a href="p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                            <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                            <div class="petition-signatures-box right">
                                <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                <a href="p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">Sign</div></a>
                            </div>
                            <div class="search-petition-by-to left">by ' . $row['byWho'] . ' to ' . $row['target'];
                            if($row['victory'] == 1){
                                echo '<div class="petition-element-victory-label"> Victory</div>';
                            }
                            echo '</div>
                        </div>
                    </div>';
                }
                while($row = mysqli_fetch_assoc($query)){
                    echo '<hr class="petition-element-hr">
                          <div class="search-petition left">';
                            if($row['image'] == ""){
                                echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(images/default.jpg);"></div></a>';
                            }
                            else{
                                echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(images/petitions/' . $row['image'] . ');"></div></a>';
                            }
                            echo '<div class="search-petition-element-right-content right">
                                <div class="search-petition-element-title left"><a href="p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                                <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                                <div class="petition-signatures-box right">
                                    <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                    <a href="p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">Sign</div></a>
                                </div>
                                <div class="search-petition-by-to left">by ' . $row['byWho'] . ' to ' . $row['target'];
                            if($row['victory'] == 1){
                                echo '<div class="petition-element-victory-label"> Victory</div>';
                            }
                            echo '</div>
                            </div>
                        </div>';
                }
                echo ' <div class="pagination">
                        <a href="petitions/featured?page=2"><div class="pagination-block">Load More</div></a>
                    </div>';
            }
    ?>
</div>    

<?php
    include("footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
</body>

</html>

