<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Start a free online petition - Sign & Share</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <!-- Font Awesome -->
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" /> <!-- Favicon -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@signandshareorg">
    <meta name="twitter:creator" content="@signandshareorg">
    <meta name="twitter:title" content="Start a free online petition - Sign & Share">
    <meta name="twitter:description" content="Sign an existing petition or start your own, gain support and help change the world.">
    <meta name="twitter:image" content="https://www.signandshare.org/images/fb-image.jpg">

    <meta property="og:url" content="https://www.signandshare.org/start" />
    <meta property="og:title" content="Start a free online petition - Sign & Share" />
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

    <div class="start-petition-holder">
        <div class="start-petition-steps">
            <div class="show-error"></div>
            <ul class="steps-list">
                <li class="step1-li step1-cloud" style="margin-left: 0px !important;"><img alt src="images/cloud1.png" width="22px"></li>
                <li class="step1-li step-text"><span class="step-text">Title</span></li>
                <li class="step2-li step1-arrow"><img alt src="images/arrow.png" width="22px"></li>

                <li class="step2-li step2-cloud"><img alt src="images/cloud2.png" width="22px"></li>
                <li class="step2-li step-text"><span class="step-text">Petition Target</span></li>
                <li class="step3-li step2-arrow"><img alt src="images/arrow.png" width="22px"></li>

                <li class="step3-li step3-cloud"><img alt src="images/cloud3.png" width="22px"></li>
                <li class="step3-li step-text">Description</li>
                <li class="step4-li step3-arrow"><img alt src="images/arrow.png" width="22px"></li>

                <li class="step4-li step4-cloud"><img alt src="images/cloud4.png" width="22px"></li>
                <li class="step4-li step-text">Category</li>
                <li class="step5-li step4-arrow"><img alt src="images/arrow.png" width="22px"></li>

                <li class="step5-li step5-cloud"><img alt src="images/cloud5.png" width="22px"></li>
                <li class="step5-li step-text">Image</li>
            </ul>
        </div>
        <hr class="big-hr" style="width: 100%;">
        <form method="POST" id="start-a-petition-form" enctype="multipart/form-data">
        <div class="step1" style="display: block;">
            <div class="title">Petition Title</div>
            <input type="text" name="title" placeholder="What is your petition trying to do?" class="start-petition-input step1-input">
            <div class="left-symbols">100</div>
            <div class="start-petition-btn step1-btn">Continue</div>
            <div class="start-petition-tips">
                The title of your petition, is the very first thing people see. It should be descriptive and noticeable enough, but at the same time, not too long (no more than 10 words, is advisable). <!--Try to focus on the solution, not on the problem.-->
            </div>
        </div>
        <div class="step2">
            <div class="title">Petition Target</div>
            <input type="text" name="target" placeholder="Who has the power to make the change you want?" class="start-petition-input step2-input">
            <div class="start-petition-btn step2-btn">Continue</div>
            <div class="start-petition-tips">
                This is the target of your petition. It could be your local council, a minister, a company CEO, the Mayor, or even your president. Try to choose only one person if possible. If you want to choose more than one petition target, split them with a comma.
            </div>
        </div>
        <div class="step3">
            <div class="title">Petition Description</div>
            <textarea name="description" class="start-petition-textarea step3-input" placeholder="Explain the issue you want to solve"></textarea>
            <div class="start-petition-btn step3-btn">Continue</div>
            <div class="start-petition-tips">
                This is where you tell people what the problem is and offer a solution. Keep it short, simple and clear. Don't use hate speech, make things up or bully.
            </div>
        </div>
        <div class="step4">
            <div class="title">Category</div>
            <select name="category" class="country-select start-petition-input category-select-start">
                <option value="default" selected="">Choose a category</option>
                <option value="Animals">Animals</option>
                <option value="Environment">Environment</option>
                <option value="Education">Education</option>
                <option value="Criminal Justice">Criminal Justice</option>
                <option value="Health">Health</option>
                <option value="Women's Rights">Women's Rights</option>
                <option value="Sustainable Food">Sustainable Food</option>
                <option value="LGBT issues">LGBT issues</option>
                <option value="Human Rights">Human Rights</option>
                <option value="Other">Other</option>
            </select>
            <div class="start-petition-btn step4-btn">Continue</div>
            <div class="start-petition-tips">

            </div>
        </div>
        <div class="step5">
            <div class="start-petition-add-image">
                <div class="image-cancel">x</div>
                <div class="image-wrapper">
                    <img class="image-4">
                </div>
                <div class="settings-error-notification-image"><i class="fa fa-times" aria-hidden="true"></i> Photos should be at least 620 × 310 pixels.</div>
                <div class="start-petition-add-image-title-icon"><img alt src="images/photo-camera.png" class="add-image-img" width="85px"></div>
                <div class="start-petition-add-image-title">Add an image (optional)</div>
                <div class="upload-image-btn">
                    <input type="file" name="imageUpload" class="upload-image-input">
                    <i class='fa fa-upload' aria-hidden='true'></i> Upload Image
                </div>
                <div class="start-petition-tips" style="margin-top: 30px;">
                    Petitions with a photo or video receive <b>six times</b> more signatures than those without. Include one that captures the emotion of your story.
                </div>
            </div>
            <input type="button" name="creating_the_petition" class="start-petition-btn-submit step5-btn" value="Save and preview">
            </form>
        </div>
    </div>

<?php
    include("footer.php");
?>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.upload-image-input').on("change", function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-wrapper')
                    .hide();
                $('.image-4')
                    .attr('src', e.target.result);
                $('.image-wrapper')
                    .css("background-image","url('" + e.target.result + "')");
                $('.image-4')
                    .css("width","100%");
                $('.image-wrapper').show();
                $('.image-cancel').show();
                $(".settings-error-notification-image").hide();
                $(".start-petition-add-image-title-icon").hide();
                $(".start-petition-add-image-title").hide();
                /*var width = $('.image-4').get(0).naturalWidth;
                var height = $('.image-4').get(0).naturalHeight;
                if(width < 620 || height < 310){
                    $(".settings-error-notification-image").show();
                    $('.image-cancel').hide();
                    $(".start-petition-add-image-title-icon") .show();
                    $(".start-petition-add-image-title").show();
                    $(".upload-image-input").val("");
                }
                else{
                    $('.image-wrapper').show();
                    $('.image-cancel').show();
                    $(".settings-error-notification-image").hide();
                    $(".start-petition-add-image-title-icon").hide();
                    $(".start-petition-add-image-title").hide();
                }*/
            };

            reader.readAsDataURL(this.files[0]);
        }
    });

    $(".upload-image-input").click(function(event){
        event.stopPropagation();
    });

    $(".image-cancel").click(function(){
        $('.upload-image-input')
            .val("");
        $('.image-wrapper')
            .hide();
        $(".start-petition-add-image-title-icon")
            .show();
        $(".start-petition-add-image-title")
            .show();
        $(".image-cancel")
            .hide();
    });
});
</script>
<script type="text/javascript" src="/scripts/scripts-start.js"></script>
</body>

</html>
