<?php
    session_start();

    include("petitionId.php");
    
    /* Check if the user is logged in. If not redirect him to the previous page. */
    if(!isset($_SESSION['isLogged'])){
        header("Location: index.php"); 
    }
    else{
        require_once("../../config.php");

        $conn = mysqli_connect($servername,$user,$password,$dbname);
        if($conn == false){
            echo 'ERROR';
            exit;
        }

        mysqli_set_charset($conn, 'utf8');

        /* Check if the user is the owner of the petition. If not redirect him to the previous page. */
        $errorCode = 0;
        $isPetitionStarterSql = 'SELECT victory, closed, lastUpdate, title, overview, image, path, letter FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            header("Location: index.php");     
        }
        else{
            if($row = mysqli_fetch_assoc($isPetitionStarterQuery)){
                $closed = $row['closed'];
                $victory = $row['victory'];
                $title = $row['title'];
                $path = $row['path'];
                $image = $row['image'];
                if($image == ""){
                    $imageForShare = "fb-image.jpg";
                }
                else{
                    $imageForShare = "petitions/" . $image;
                }
                $letter = $row['letter'];
                $overviewForShare = substr($row['overview'],0,170) . "...";
            }
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />

    <title>Download signatures - Sign and Share</title>
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
        <div class="post-update-holder">

            <div class="post-update-title">Download signatures</div>
            <div id="download-signatures-step-1">
                <div class="post-update-tips">
                    If you are ready to hand in your petition, just select the file format you want and click "Create document". Delivering your petition is an essential moment in your campaign. You can email it to your petition's target or even better - deliver it in person.
                </div>
                <div class="download-signatures-select-format">Select format:</div>
                <form method="post" action="download_signatures" class="download-signatures-form">
                    <input name="download-radio-btn" id="generate-format-pdf" type="radio" class="checkbox-downloads" value="pdf" checked="checked" style="margin-top: 18px;">
                    <label for="generate-format-pdf" class="checkbox-label-downloads"> Adobe PDF</label>
                    <br>
                    <div class="download-signatures-text">This format can be printed or sent via email and delivered to the target. The document includes the petition description, signatures and any comments they provided.
                    <br>
                    This format requires Adobe Reader. You can <a href="https://get.adobe.com/reader/" target="_blank">click here</a> to download it for free.<br><br></div>
                    <input name="download-radio-btn" id="generate-format-csv" type="radio" class="checkbox-downloads" value="csv" style="margin-top: 0px;">
                    <label for="generate-format-csv" class="checkbox-label-downloads"> Importable CSV file (for Excel, Word)</label>
                    <div class="download-signatures-text">This format can be imported into a spreadsheet or word processing application for further processing of your petition data. The document includes signatures and any comments they provided. It will not include the petition description.</div>
                    <input type="button" value="Create document" class="error-404-btn download-signatures-btn" style="height: 47px; padding-top: 12px; padding-bottom: 12px;">
                </form>
            </div>
            <div id="download-signatures-step-2">
                <div class="post-update-tips">
                    Your petition does not currently have a letter!<br>
                    We recommend that you add a letter, so that the recipient(s) of your petition will know why people signed your petition. However, if you wish to create a document containing nothing but your petition's signatures, you may proceed. <a href="edit#letter">Click here</a> if you want to add letter.
                </div>
                <input type="button" value="Create without letter" class="error-404-btn create-without-letter" style="height: 47px; padding-top: 12px; padding-bottom: 12px;">
            </div>
            <div id="download-signatures-step-finished">
                <div class="post-update-tips">
                We are currently generating your signature document. When the file is ready, we will send you an email. <a href="index">Go back to your petition.</a>
                </div>
            </div>
        </div>
    </div>

    <?php
        include("../../my_petition_right_column.php");
    ?>

</main>

<?php
    include("../../footer.php");       
?>
</div>

<script type="text/javascript" src="/scripts/scripts.js"></script>
<script type="text/javascript" src="/scripts/scripts-petitions.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var empty = 0;
    <?php 
    if($letter == ""){ echo "empty = 1;";}
    ?>
    var petition_id = <?php echo $petitionId; ?>;
    var letter = "<?php echo $letter; ?>";

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

    $(".download-signatures-btn").click(debounce(function(){
        if(empty == 1){
            $("#download-signatures-step-1").hide();
            $("#download-signatures-step-2").fadeIn(300);
        }
        else{
            var format = $('input[name="download-radio-btn"]:checked').val();
            $.ajax({
                  url: '/downloadSignaturesRequest.php',
                  type: 'POST',
                  data: { petition_id : petition_id, format : format, letter : letter},
              })
                  .done(function(result){
                      if(result == "Success"){
                            $("#download-signatures-step-1").hide();
                            $("#download-signatures-step-2").hide();
                            $("#download-signatures-step-finished").fadeIn(300);
                      }
                      else{
                            $("#download-signatures-step-1").hide();
                            $("#download-signatures-step-2").hide();
                            $("#download-signatures-step-finished").fadeIn(300);
                            $("#download-signatures-step-finished").html('<div class="post-update-tips">' + result + ' <a href="index">Go back to your petition.</a></div>');
                      }
                  })
                  .fail(function(){
                        $("#download-signatures-step-1").hide();
                        $("#download-signatures-step-2").hide();
                        $("#download-signatures-step-finished").fadeIn(300);
                        $("#download-signatures-step-finished").html('<div class="post-update-tips">' + result + ' <a href="index">Go back to your petition.</a></div>');
                  }); 
        }
    }, 500)); 

    $(".create-without-letter").click(debounce(function(){
            var format = $('input[name="download-radio-btn"]:checked').val();
            $.ajax({
                  url: '/downloadSignaturesRequest.php',
                  type: 'POST',
                  data: { petition_id : petition_id, format : format, letter : letter},
              })
                  .done(function(result){
                      if(result == "Success"){
                            $("#download-signatures-step-1").hide();
                            $("#download-signatures-step-2").hide();
                            $("#download-signatures-step-finished").fadeIn(300);
                      }
                      else{
                            $("#download-signatures-step-1").hide();
                            $("#download-signatures-step-2").hide();
                            $("#download-signatures-step-finished").fadeIn(300);
                            $("#download-signatures-step-finished").html('<div class="post-update-tips">' + result + ' <a href="index">Go back to your petition.</a></div>');
                      }
                  })
                  .fail(function(){
                        $("#download-signatures-step-1").hide();
                        $("#download-signatures-step-2").hide();
                        $("#download-signatures-step-finished").fadeIn(300);
                        $("#download-signatures-step-finished").html('<div class="post-update-tips">' + result + ' <a href="index">Go back to your petition.</a></div>');
                  }); 
    }, 500));
});
</script>
</body>

</html>