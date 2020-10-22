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

    function cryptPass($input, $rounds=9){
        $salt = "";
        $saltChars = array_merge(range('A','Z'), range('a','z'), range(0,9));
        for($i=0; $i<22; $i++){
            $salt .= $saltChars[array_rand($saltChars)];
        }
        return crypt($input, sprintf('$2y$%02d$', $rounds).$salt);
    }    

    if(isset($_POST)){
        $currentPass = mysqli_real_escape_string($conn, $_POST['currentPass']);
        $newPass = mysqli_real_escape_string($conn, $_POST['newPass']);
        $verifyPass = mysqli_real_escape_string($conn, $_POST['verifyPass']);

        if($newPass != $verifyPass){
            echo "New password and verify password do not match.";
            exit;
        }

        if(strlen($newPass) < 6){
            echo "Your password must be at least 6 symbols.";
            exit;
        }

        $getPassSql = 'SELECT password FROM users WHERE id=' . $_SESSION['userId'] . ' LIMIT 1';
        $getPassQuery = mysqli_query($conn,$getPassSql);
        if($row = mysqli_fetch_assoc($getPassQuery)){
            $hashedPass = $row['password'];
        }

        if(crypt($currentPass,$hashedPass) == $hashedPass){
            $hashedPass = cryptPass($newPass);
            $changePassSql = 'UPDATE users SET password = "' . $hashedPass . '" WHERE id=' . $_SESSION['userId'];
            $changePassQuery = mysqli_query($conn,$changePassSql);

            if($changePassQuery){
                echo "Success";
                exit;
            }
            else{
                echo "Error in query";
                exit;
            }
        }
        else{
            echo "Incorrect password";
            exit;
        }
    }
?>