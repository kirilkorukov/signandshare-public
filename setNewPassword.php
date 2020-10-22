<?php
    session_start();
    
    require_once("config.php");

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
        $token = mysqli_real_escape_string($conn,$_POST['token']);
        $email_id = mysqli_real_escape_string($conn,$_POST['email_id']);

        function base64_url_decode($input) {
            return base64_decode(strtr($input, '-_,', '+/='));
        }

        $decodedEmail = base64_url_decode($email_id);

        $getEmail = 'SELECT id FROM forgot_pass WHERE token = "' . $token .'" AND email_id = "' . $email_id . '" AND CURTIME() < time_expires LIMIT 1';
        $getEmailQuery = mysqli_query($conn, $getEmail);

        if(mysqli_num_rows($getEmailQuery) != 0){
            $newPass = mysqli_real_escape_string($conn,$_POST['newPass']);
            $verifyPass = mysqli_real_escape_string($conn,$_POST['verifyPass']);
            if(strlen($newPass) < 6) {
                echo 'Your password must be at least 6 symbols.';
                exit;
            }

            if($newPass == $verifyPass){
                $hashedPass = cryptPass($newPass);
                $changePassSql = 'UPDATE users SET password = "' . $hashedPass . '" WHERE email = "' . $decodedEmail . '"';
                $changePassQuery = mysqli_query($conn,$changePassSql);

                $deleteRow = 'DELETE FROM forgot_pass WHERE token = "' . $token .'" AND email_id = "' . $email_id . '"';
                $deleteRowQuery = mysqli_query($conn,$deleteRow);

                if($changePassQuery && $deleteRowQuery){
                    echo "Success";
                    exit;
                }
                else{
                    echo "Please try again later.";
                    exit;
                }
            }
            else{
                echo "Passwords don't match.";
                exit;
            }
        }
        else{
            echo "Expired password reset link. Please use the 'Forgot Password' link to receive a new reset link.";
            exit;
        }
    }
    else{
        echo "Error";
        exit;
    }
?>