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
        $isPetitionStarterSql = 'SELECT title, target, overview, category, path, image, closed, victory, letter FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            header("Location: index.php");     
        }
        else{
            while($row = mysqli_fetch_assoc($isPetitionStarterQuery)){
                $petitionTitle = $row['title'];
                $petitionTarget = $row['target'];
                $petitionDescription = $row['overview'];
                $petitionCategory = $row['category'];
                $path = $row['path'];
                $image = $row['image'];
                $letter = $row['letter'];
                $closed = $row['closed'];
                $victory = $row['victory'];
                $title = $row['title'];
                if($image == ""){
                    $imageForShare = "fb-image.jpg";
                }
                else{
                    $imageForShare = "petitions/" . $image;
                }
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

    <title>Edit petition - Sign and Share</title>
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
        <div class="settings-error-notification"></div>  
        <form method="post" id="edit-petition-form" enctype="multipart/form-data">
        <div class="edit-petition-title" style="margin-top: 0px;">Edit Petition Title</div>
        <input type="text" class="edit-petition-input" placeholder="What is your petition trying to do?" value="<?php echo $petitionTitle; ?>" name="petitionTitle">
        <div class="edit-petition-tips">The title of your petition, is the very first thing people see. It should be descriptive and noticeable enough, but at the same time, not too long (no more than 10 words, is advisable).</div>
        <hr class="edit-petition-hr">
        <div class="edit-petition-title">Edit Petition Target</div>
        <input type="text" class="edit-petition-input" placeholder="Who has the power to make the change you want?" value="<?php echo $petitionTarget; ?>" name="petitionTarget">
        <div class="edit-petition-tips">This is the target of your petition. It could be your local council, a minister, a company CEO, the Mayor, or even your president. Try to choose only one person if possible. If you want to choose more than one petition target, split them with a comma.</div>
        <hr class="edit-petition-hr">
        <div class="edit-petition-title">Edit Petition Description</div>
        <textarea class="start-petition-textarea step3-input" placeholder="Explain the issue you want to solve" name="petitionDescription"><?php echo $petitionDescription; ?></textarea>
        <div class="edit-petition-tips">This is where you tell people what the problem is and offer a solution. Keep it short, simple and clear. Don't use hate speech, make things up or bully.</div>
        <hr class="edit-petition-hr">
        <div class="edit-petition-title">Edit Category</div>
        <select class="country-select start-petition-input category-select" name="petitionCategory" style="width: 100%;">
            <?php
                if($petitionCategory == "Animals") echo '<option value="Animals" selected>Animals</option>';
                else echo '<option value="Animals">Animals</option>';
                if($petitionCategory == "Environment") echo '<option value="Environment" selected>Environment</option>';
                else echo '<option value="Environment">Environment</option>';
                if($petitionCategory == "Education") echo '<option value="Education" selected>Education</option>';
                else echo '<option value="Education">Education</option>';
                if($petitionCategory == "Criminal Justice") echo '<option value="Criminal Justice" selected>Criminal Justice</option>';
                else echo '<option value="Criminal Justice">Criminal Justice</option>';
                if($petitionCategory == "Health") echo '<option value="Health" selected>Health</option>';
                else echo '<option value="Health">Health</option>';
                if($petitionCategory == "Women\'s Rights") echo '<option value="Women\'s Rights" selected>Women\'s Rights</option>';
                else echo '<option value="Women\'s Rights">Women\'s Rights</option>';
                if($petitionCategory == "Sustainable Food") echo '<option value="Sustainable Food" selected>Sustainable Food</option>';
                else echo '<option value="Sustainable Food">Sustainable Food</option>';
                if($petitionCategory == "LGBT issues") echo '<option value="LGBT issues" selected>LGBT issues</option>';
                else echo '<option value="LGBT issues">LGBT issues</option>';
                if($petitionCategory == "Human Rights")echo '<option value="Human Rights" selected>Human Rights</option>';
                else echo '<option value="Human Rights">Human Rights</option>';
                if($petitionCategory == "Other") echo '<option value="Other" selected>Other</option>';
                else echo '<option value="Other">Other</option>';
            ?>
        </select>
        <hr class="edit-petition-hr">
        <a name="image"></a>
        <div class="edit-petition-title">Add an image (optional)</div>
        <div class="settings-error-notification-image"><i class="fa fa-times" aria-hidden="true"></i> Photos should be at least 620 × 310 pixels.</div>
        <?php
            if($image != ""){
                echo '<div class="petition-img" style="display: block; background-image: url(\'/images/petitions/' . $image . '\');">
                        <img class="image-4" src="/images/petitions/' . $image . '">
                    </div>';
            }
            else{
                echo '<div class="edit-petition-tips-image">Petitions with a photo or video receive <b>six times</b> more signatures than those without. Include one that captures the emotion of your story.</div>
                    <div class="petition-img">
                        <img class="image-4">
                    </div>';
            }
        ?>
        <div class="edit-image-holder">
            <input type="file" onchange="readURL(this);" name="imageUpload" class="upload-image-input">
            <div class="upload-image-btn-edit" id="upload-image-btn-edit">
                <i class='fa fa-upload' aria-hidden='true'></i> Upload Image
            </div>
            <div class="edit-image-tips">Photos should be at least 620 × 310 pixels. Large photos without text are best.</div>
        </div>
        <input type="hidden" name="image-url">
        <hr class="edit-petition-hr">
        <a name="letter"></a>
        <div class="edit-petition-title">Edit Petition Letter</div>
        <div class="petition-letter-text">To [Petition Target],</div>
        <textarea class="start-petition-textarea step3-input" name="letter"><?php echo $letter; ?></textarea>
        <div class="petition-letter-text last-edit-settings">Sincerely,<br>
        [Signer’s Name]</div>
        <input type="button" class="update-settings-btn" name="edit-petition-form" value="Save">
        </form>
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
<script>
    $(".upload-image-btn-edit").click(function(){
        $(".upload-image-input").click();
    });

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

    $(function(){
        $('.update-settings-btn').click(debounce(function(){
            if($.trim($("input[name='petitionTitle']").val()) == "" || $.trim($("input[name='petitionTarget']").val()) == "" || $.trim($(".start-petition-textarea").val()) == ""){
                $(".settings-error-notification").html("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> All fields are mandatory.");
                $(".settings-error-notification").show();
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
            else{
                var form = $('#edit-petition-form')[0]; // You need to use standart javascript object here
                var formData = new FormData(form);
                $.ajax({
                    url: 'editRequest.php',       
                    data: formData,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $(".update-settings-btn").hide();
                        $(".last-edit-settings").after("<div class='loader-holder'><div class='loader' style='float: right;'></div></div>");
                    }
                })
                    .done(function(result){
                        if(result == "Success"){
                            location.href = "index";
                        }
                        else{
                            $(".settings-error-notification").html("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> " + result);
                            $(".settings-error-notification").show();
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $(".update-settings-btn").show();
                            $( ".loader-holder" ).hide();
                        }
                    })
                    .fail(function(){
                    });
            }
        }, 500));         
    }); 

    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $(".edit-petition-tips-image")
                    .hide();
                $('.petition-img')
                    .hide();
                $('.image-4')
                    .attr('src', e.target.result);
                $('.petition-img')
                    .css("background-image","url('" + e.target.result + "')");
                $('.image-4')
                    .css("width","100%");
                $('.petition-img').show();
                $(".settings-error-notification-image").hide();
                $(".start-petition-add-image-title-icon").hide();
                $(".start-petition-add-image-title").hide();
                /*var width = $('.image-4').get(0).naturalWidth;
                var height = $('.image-4').get(0).naturalHeight;
                if(width < 620 || height < 310){
                    $(".settings-error-notification-image").show();
                    $(".upload-image-input").val("");
                }
                else{
                    $('.petition-img').show();
                    $(".settings-error-notification-image").hide();
                    $(".start-petition-add-image-title-icon").hide();
                    $(".start-petition-add-image-title").hide();
                }*/
            };

            reader.readAsDataURL(input.files[0]);
        }
    } 
</script>

</body>

</html>