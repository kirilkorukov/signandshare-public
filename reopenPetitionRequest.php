<?php
    session_start();

    require_once("config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    if(isset($_POST)){
        $petitionId = mysqli_real_escape_string($conn, $_POST['petition_id']);

        $isPetitionStarterSql = 'SELECT closed FROM petition WHERE id = ' . $petitionId . ' AND user_id = ' . $_SESSION['userId'];
        $isPetitionStarterQuery = mysqli_query($conn, $isPetitionStarterSql);
        if(!$isPetitionStarterQuery){
            die("Error");
        }
        else if(mysqli_num_rows($isPetitionStarterQuery) == 0){
            header("Location: index.php");     
        }
        else{
            $closePetitionSql = "UPDATE petition SET closed = 0 WHERE id = " . $petitionId;
            $closePetition = mysqli_query($conn, $closePetitionSql); 
                    
            if(!$closePetition){
                echo "Error. 1";
                exit;
            }
            else{
                echo "Success";
                exit;
            }
        }
    }
    else{
        echo "There has been some error. Please try again later.";
        exit;
    }
?>