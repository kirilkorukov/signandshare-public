<?php
    session_start();

    include("petitionId.php");

    /* Check if the user is logged in. If not, redirect him to the previous page. */
    if(!isset($_SESSION['isLogged'])){
        header("Location: /index");
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
        $isPetitionStarterSql = 'SELECT title, target, overview, category, path, image, letter FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            echo "You don't have the rights to edit this petition.";
            exit;
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
            }

            if(isset($_POST)){
                if(strlen($_POST['petitionTitle'])>100){
                    echo "The petition title must be below 100 characters.";
                }
                else{
                    if(strlen($_POST['petitionTitle']) > 0 && strlen($_POST['petitionTarget']) > 0 && strlen($_POST['petitionDescription']) > 0){
                        $title = mysqli_real_escape_string($conn, $_POST['petitionTitle']);
                        $target = mysqli_real_escape_string($conn, $_POST['petitionTarget']);
                        $description = mysqli_real_escape_string($conn, $_POST['petitionDescription']);
                        $category = mysqli_real_escape_string($conn, $_POST['petitionCategory']);
                        $letter = mysqli_real_escape_string($conn, $_POST['letter']);

                        $uploaddir = '../../images/petitions/';
                        $imagePath = $image;
                        if($image == ""){
                            $imagePath = uniqid() . uniqid() . ".jpg";
                        }
                        $_FILES['imageUpload']['name'] = $imagePath;
                        $uploadfile = $uploaddir . basename($_FILES['imageUpload']['name']);
                        if(move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadfile)){
                            $updatePetitionSql = 'UPDATE petition SET title = "' . $title . '", target = "' . $target . '", overview = "' . $description . '", category = "' . $category . '", image = "' . $imagePath . '", letter = "' . $letter . '" WHERE id = ' . $petitionId;
                            $updatePetitionQuery = mysqli_query($conn, $updatePetitionSql);
                        }
                        else{
                           $updatePetitionSql = 'UPDATE petition SET title = "' . $title . '", target = "' . $target . '", overview = "' . $description . '", category = "' . $category . '", letter = "' . $letter . '" WHERE id = ' . $petitionId;
                            $updatePetitionQuery = mysqli_query($conn, $updatePetitionSql);
                        }

                        if(!$updatePetitionQuery){
                            echo "Please try again later.";
                        }
                        else{
                            echo "Success";
                        }
                    }
                    else{
                        echo "All fields are mandatory.";
                    }
                }
            }
            else{
                echo "Nqma post";
            }
        }
    }
?>
