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
        $token = $_POST['email'];
        $updates = $_POST['email-preference-1'];
        $tips = $_POST['email-preference-2'];
        $suggested = $_POST['email-preference-3'];
        $token = mysqli_real_escape_string($conn, $email);
        $updates = mysqli_real_escape_string($conn, $updates);
        $tips = mysqli_real_escape_string($conn, $tips);
        $suggested = mysqli_real_escape_string($conn, $suggested);

        function base64_url_decode($input) {
            return base64_decode(strtr($input, '-_,', '+/='));
        }

        $email = base64_url_decode($token);

        $mysqlNewPreferences = 'SELECT id FROM unsubscribe WHERE email = "' . $email . '"';
        $queryNewPreferences = mysqli_query($conn,$mysqlNewPreferences);

        if(!$queryNewPreferences){
            echo "Error";
            $fp = fopen('../../adminpanel/errors.txt', 'w');
            fwrite($fp, 'Unsubscribe error: Query New Preferences Email address: ' . $email);
            fclose($fp);
            exit;
        }

        if(mysqli_num_rows($queryNewPreferences) == 0){
            $mysqlNewPreferences = 'INSERT INTO unsubscribe (updates, tips, suggested, email) VALUES ("' . $updates .'", "' . $tips . '", "' . $suggested . '", "' . $email . '")';
            $queryNewPreferences = mysqli_query($conn,$mysqlNewPreferences);

            if($queryNewPreferences){
                echo "Success";
                exit;
            }
            else{
                echo "Error";
                exit;
            }
        }
        else{
            $mysqlNewPreferences = 'UPDATE unsubscribe SET updates = "' . $updates . '", tips = "' . $tips . '", suggested = "' . $suggested . '" WHERE email = "' . $email . '"';
            $queryNewPreferences = mysqli_query($conn,$mysqlNewPreferences); 

            if($queryNewPreferences){
                echo "Success";
                exit;
            }
            else{
                echo "Error";
                exit;
            }
        }
    }
    else{
        echo "Error";
        exit;
    }
?>