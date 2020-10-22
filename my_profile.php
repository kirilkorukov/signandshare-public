<?php
    session_start();

    if(!isset($_SESSION['isLogged'])){
        header("Location: index.php");
    }

    require_once("config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    $getInfoSql = 'SELECT firstName, lastName, country, city FROM users WHERE id = ' . $_SESSION['userId'];
    $getInfoQuery = mysqli_query($conn,$getInfoSql);

    if($getInfoQuery){
        while($row = mysqli_fetch_assoc($getInfoQuery)){
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $country = $row['country'];
            $city = $row['city'];
        }
    }
    else{
        die("Error");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My profile - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

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

<div class="search-page-holder">
    <div class="my-profile-img"><img alt src="images/supporter.png" style="width: 100%"></div>
    <div class="my-profile-name"><?php echo $firstName . ' ' . $lastName; ?></div>
    <div class="my-profile-country">
         <?php
            if($country != "default" && $city != "default"){
                echo $city . ', ' . $country;
            }
            else if($country == "default" && $city == "default"){
                echo '<a href="account/edit_settings"><i class="fa fa-cog" aria-hidden="true"></i> Edit profile</a>';
            }
            else if($country != "default"){
                echo $country;
            }
            else{
                echo $city;
            }
        ?>
    </div>
    <?php
        $mysql = 'SELECT DISTINCT petition.id,petition.path, petition.title, petition.image, petition.currentSupporters, petition.byWho, petition.target, petition.user_id FROM petition INNER JOIN users ON petition.user_id = ' . $_SESSION['userId'] . ' ORDER BY petition.id DESC';
        $query = mysqli_query($conn,$mysql);

        $mysqlStarted = 'SELECT * FROM petition WHERE id IN (SELECT petition_id FROM user_petitions WHERE user_id = ' . $_SESSION['userId'] . ')';
        $queryStarted = mysqli_query($conn, $mysqlStarted);

        if($query){
            echo '<ul class="petition-inside-buttons-profile">
                    <li class="pet-btn-first blue">Started (' . mysqli_num_rows($query) . ')</li>
                    <li class="pet-btn-second">Signed (' . mysqli_num_rows($queryStarted) . ')</li>
                </ul>
                <div id="my-profile-started">';
                if($row = mysqli_fetch_assoc($query)){
                    echo '<div class="search-petition left">';
                        if($row['image'] == ""){
                            echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(/images/default.jpg);"></div></a>';
                        }
                        else{
                            echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(/images/petitions/' . $row['image'] . ');"></div></a>';
                        }
                        echo '<div class="search-petition-element-right-content right">
                                <div class="search-petition-element-title left"><a href="p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                                <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                                <div class="petition-signatures-box right">
                                    <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                    <a href="p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">View</div></a>
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
                                    echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(/images/default.jpg);"></div></a>';
                                }
                                else{
                                    echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(/images/petitions/' . $row['image'] . ');"></div></a>';
                                }
                                echo '<div class="search-petition-element-right-content right">
                                    <div class="search-petition-element-title left"><a href="p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                                    <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                                    <div class="petition-signatures-box right">
                                        <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                        <a href="p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">View</div></a>
                                    </div>
                                    <div class="search-petition-by-to left">by ' . $row['byWho'] . ' to ' . $row['target'];
                                if($row['victory'] == 1){
                                    echo '<div class="petition-element-victory-label"> Victory</div>';
                                }
                                echo '</div>
                                </div>
                            </div>';
                }
                echo '</div>';
        }
        else{
            die("Please contact the administrator.");
        }

        if($queryStarted){
            if(mysqli_num_rows($queryStarted)!=0){
                if($row = mysqli_fetch_assoc($queryStarted)){
                echo '<div id="my-profile-signed">
                    <div class="search-petition left">';
                        if($row['image'] == ""){
                            echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(/images/default.jpg);"></div></a>';
                        }
                        else{
                            echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(/images/petitions/' . $row['image'] . ');"></div></a>';
                        }
                        echo '<div class="search-petition-element-right-content right">
                                <div class="search-petition-element-title left"><a href="p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                                <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                                <div class="petition-signatures-box right">
                                    <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                    <a href="p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">Signed</div></a>
                                </div>
                                <div class="search-petition-by-to left">by ' . $row['byWho'] . ' to ' . $row['target'];
                                if($row['victory'] == 1){
                                    echo '<div class="petition-element-victory-label"> Victory</div>';
                                }
                                echo '</div>
                            </div>
                        </div>';
                }
                while($row = mysqli_fetch_assoc($queryStarted)){
                    echo '<hr class="petition-element-hr">
                              <div class="search-petition left">';
                                if($row['image'] == ""){
                                    echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(/images/default.jpg);"></div></a>';
                                }
                                else{
                                    echo '<a href="p/' . $row['path'] . '/index"><div class="search-petition-image left" style="background-image: url(/images/petitions/' . $row['image'] . ');"></div></a>';
                                }
                                echo '<div class="search-petition-element-right-content right">
                                    <div class="search-petition-element-title left"><a href="p/' . $row['path'] . '/index">' . $row['title'] . '</a></div>
                                    <div class="petition-element-supporters"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;' . number_format($row['currentSupporters'])  . ' supporters</div>
                                    <div class="petition-signatures-box right">
                                        <div class="petition-signatures-box-text">' . number_format($row['currentSupporters']) . '<br><span>supporters</span></div>
                                        <a href="p/' . $row['path'] . '/index" style="text-decoration: none;"><div class="petition-signatures-btn">Signed</div></a>
                                    </div>
                                    <div class="search-petition-by-to left">by ' . $row['byWho'] . ' to ' . $row['target'];
                                if($row['victory'] == 1){
                                    echo '<div class="petition-element-victory-label"> Victory</div>';
                                }
                                echo '</div>
                                </div>
                            </div>';
                }
                echo '</div>';
            }
        }
        else{
            die("Please contact the administrator.");
        }

    ?>
    
    <!--<div class="pagination">
        <a href=""><div class="pagination-block">Load More</div></a>
    </div>-->
</div>

<?php
    include("footer.php");
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
<script>
    $(document).ready(function() {
        $("#my-profile-started").show();
        $(".pet-btn-first").click(function(){
            $("#my-profile-started").show();
            $("#my-profile-signed").hide();

            $(".pet-btn-first").addClass("blue");
            $(".pet-btn-second").removeClass("blue");
        });

        $(".pet-btn-second").click(function(){
            $("#my-profile-started").hide();
            $("#my-profile-signed").show();

            $(".pet-btn-first").removeClass("blue");
            $(".pet-btn-second").addClass("blue");
        });
    });
</script>

</body>

</html>

