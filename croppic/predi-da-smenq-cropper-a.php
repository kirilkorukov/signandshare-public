<?php
    session_start();
    
    /* Check if the user is logged in. If not redirect him to the previous page. */
    if(!isset($_SESSION['isLogged'])){
        header("Location: /index.php"); 
    }
    else{
                require_once("config.php");

        $conn = mysqli_connect($servername,$user,$password,$dbname);
        if($conn == false){
            echo 'ERROR';
            exit;
        }

        mysqli_set_charset($conn, 'utf8');

        /* Check if the user is the owner of the petition. If not redirect him to the previous page. */
        $errorCode = 0;
        $petitionId = 7; /* Error */
        $isPetitionStarterSql = 'SELECT * FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            header("Location: /index.php");     
        }
        else{
            while($row = mysqli_fetch_assoc($isPetitionStarterQuery)){
                $petitionTitle = $row['title'];
                $petitionTarget = $row['target'];
                $petitionDescription = $row['description'];
                $petitionCategory = $row['category'];
                $path = $row['path'];
            }

            if(isset($_POST['edit-petition-form'])){
                if(strlen($_POST['petitionTitle'])>100){
                    $errorCode = 2;
                }
                else{
                    if(strlen($_POST['petitionTitle'])>0 && strlen($_POST['petitionTarget'])>0 && strlen($_POST['petitionDescription'])>0){
                        $petitionTitle = $_POST['petitionTitle'];
                        $petitionTarget = $_POST['petitionTarget'];
                        $petitionDescription = $_POST['petitionDescription'];
                        $petitionCategory = $_POST['petitionCategory'];
                        $petitionImage = $_POST['image-url'];
                        $image = file_get_contents($petitionImage);
                        file_put_contents('/images/' . $path . '.jpg', $image);

                        $updatePetitionSql = 'UPDATE petition SET title = "' . $petitionTitle . '", target = "' . $petitionTarget . '", description = "' . $petitionDescription . '", category = "' . $petitionCategory . '" WHERE id = ' . $petitionId;
                        $updatePetitionQuery = mysqli_query($conn, $updatePetitionSql);

                        if(!$updatePetitionQuery){
                            $errorCode = 3;
                        }
                        else{
                            $errorCode = 4;
                        }
                    }
                    else{
                        $errorCode = 1;
                    }
                }
            } 
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign and Share - My Petition</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="main.css" rel="stylesheet" type="text/css">
    <link href="croppic.css" rel="stylesheet" type="text/css">
    <style>
        #cropContainerMinimal {
            width: 620px;
            height: 310px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
<?php 
    include_once("../analyticstracking.php"); 
?>

<!-- Facebook SDK --> <div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=1635035403441162";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>

<?php
    include("http://.org/header.php");       
?>
    
<main class="petition-page-wrapper">
    <div class="left-column left">
        <?php
            if($errorCode != 4){
                if($errorCode == 1){
                    echo '<div class="settings-error-notification"><i class="fa fa-times" aria-hidden="true"></i> All fields are mandatory.</div>';
                }
                else if($errorCode == 2){
                    echo '<div class="settings-error-notification"><i class="fa fa-times" aria-hidden="true"></i> The petition title must be below 100 charachters.</div>';
                }
                else if($errorCode == 3){
                    echo '<div class="settings-error-notification"><i class="fa fa-times" aria-hidden="true"></i> Please try again later.</div>';
                }
            }
            else{
                echo '<div class="settings-success-notification"><i class="fa fa-check" aria-hidden="true"></i> Your petition was successfully updated.</div>';
            }
        ?>
        <form method="post" action="edit">
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
                if($petitionCategory == "Animals"){
                    echo '<option value="Animals" selected>Animals</option>';
                }
                else{
                    echo '<option value="Animals">Animals</option>';
                }

                if($petitionCategory == "Environment"){
                    echo '<option value="Environment" selected>Environment</option>';
                }
                else{
                    echo '<option value="Environment">Environment</option>';
                }

                if($petitionCategory == "Education"){
                    echo '<option value="Education" selected>Education</option>';
                }
                else{
                    echo '<option value="Education">Education</option>';
                }

                if($petitionCategory == "Criminal Justice"){
                    echo '<option value="Criminal Justice" selected>Criminal Justice</option>';
                }
                else{
                    echo '<option value="Criminal Justice">Criminal Justice</option>';
                }

                if($petitionCategory == "Health"){
                    echo '<option value="Health" selected>Health</option>';
                }
                else{
                    echo '<option value="Health">Health</option>';
                }

                if($petitionCategory == "Women\'s Rights"){
                    echo '<option value="Women\'s Rights" selected>Women\'s Rights</option>';
                }
                else{
                    echo '<option value="Women\'s Rights">Women\'s Rights</option>';
                }

                if($petitionCategory == "Sustainable Food"){
                    echo '<option value="Sustainable Food" selected>Sustainable Food</option>';
                }
                else{
                    echo '<option value="Sustainable Food">Sustainable Food</option>';
                }

                if($petitionCategory == "LGBT issues"){
                    echo '<option value="LGBT issues" selected>LGBT issues</option>';
                }
                else{
                    echo '<option value="LGBT issues">LGBT issues</option>';
                }

                if($petitionCategory == "Human Rights"){
                    echo '<option value="Human Rights" selected>Human Rights</option>';
                }
                else{
                    echo '<option value="Human Rights">Human Rights</option>';
                }

                if($petitionCategory == "Other"){
                    echo '<option value="Other" selected>Other</option>';
                }
                else{
                    echo '<option value="Other">Other</option>';
                }
            ?>
        </select>
        <hr class="edit-petition-hr">
        <div class="edit-petition-title">Add an image (optional)</div>
        <div id="cropContainerMinimal"></div>
        <div class="settings-error-notification-image"><i class="fa fa-times" aria-hidden="true"></i> Photos should be at least 620 × 310 pixels.</div>
        <div class="edit-petition-tips-image">Petitions with a photo or video receive <b>six times</b> more signatures than those without. Include one that captures the emotion of your story.</div> 
        <div class="edit-image-holder">
            <div class="upload-image-btn-edit" id="upload-image-btn-edit">
                <i class='fa fa-upload' aria-hidden='true'></i> Upload Image
            </div>
            <div class="edit-image-tips">Photos should be at least 620 × 310 pixels. Large photos without text are best.</div>
        </div>
        <input type="hidden" name="image-url">
        <input type="submit" class="update-settings-btn" name="edit-petition-form" value="Save">
        </form>
    </div>

    <?php
        include("my_petition_right_column.php");
    ?>

    </div>
</main>

<?php
    include("/footer.php");
?>

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="croppic.min.js"></script>

    <script>
        var croppicContaineroutputMinimal = {
                uploadUrl:'img_save_to_file.php',
                cropUrl:'img_crop_to_file.php', 
                modal:false,
                doubleZoomControls:false,
                customUploadButtonId:'upload-image-btn-edit',
                imgEyecandy:false,      
                rotateControls: false,
                loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
                onBeforeImgUpload: function(){ $("#cropContainerMinimal").show(); },
                onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
                onImgDrag: function(){ console.log('onImgDrag') },
                onImgZoom: function(){ console.log('onImgZoom') },
                onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
                onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
                onReset:function(){ $("#cropContainerMinimal").hide(); },
                onError:function(errormessage){ console.log('onError:'+errormessage) }
        }
        var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);
    </script>

</body>

</html>