<?php
    session_start();
    if(!isset($_SESSION['isLogged'])){
        header("Location: ../index.php");
    }
    require_once("../config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }

    mysqli_set_charset($conn, 'utf8');

    if(isset($_POST)){
        $emailPreferences = $_POST['email-preference-1'] . $_POST['email-preference-2'] . $_POST['email-preference-3'];
        $emailPreferences = mysqli_real_escape_string($conn, $emailPreferences);
        
        $mysqlNewPreferences = 'UPDATE users SET emailPreferences = "' . $emailPreferences . '" WHERE id = ' . $_SESSION['userId'];
        $queryNewPreferences = mysqli_query($conn,$mysqlNewPreferences);

        if($queryNewPreferences){
            echo "Success";
        }
        else{
            echo "Error";
        }
    }

    $mysql = 'SELECT emailPreferences FROM users WHERE id = ' . $_SESSION['userId'];
    $query = mysqli_query($conn,$mysql);
    if($row = mysqli_fetch_assoc($query)){
        $oldPreferences = $row['emailPreferences'];
    }
    $firstPreference = substr($oldPreferences,0,1);
    $secondPreference = substr($oldPreferences,1,1);
    $thirdPreference = substr($oldPreferences,2,1);
?>