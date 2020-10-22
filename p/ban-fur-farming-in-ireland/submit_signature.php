<?php
    session_start();

    include("petitionId.php");

    if($_POST){
        require_once("../../config.php");

        $conn = mysqli_connect($servername,$user,$password,$dbname);
        if($conn == false){
            echo 'ERROR';
            $fp = fopen('../../adminpanel/errors.txt', 'a+');
            fwrite($fp, "\r\n Error connecting to database");
            fclose($fp);
            exit;
        }

        mysqli_set_charset($conn, 'utf8');

        $firstName = mysqli_real_escape_string($conn,$_POST['firstName']);
        $lastName = mysqli_real_escape_string($conn,$_POST['lastName']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $country = mysqli_real_escape_string($conn,$_POST['country']);
        $city = mysqli_real_escape_string($conn,$_POST['city']);
        $reasonForSigning = mysqli_real_escape_string($conn,$_POST['reasonForSigning']);
        if(isset($_POST['davai'])){
            $public = 0;
        }
        else{
            $public = 1;
        }
        $date = date("Y/m/d H:i:s");

        $getPetitionData = 'SELECT path, title FROM petition WHERE id = ' . $petitionId;
        $getPetitionDataQuery = mysqli_query($conn, $getPetitionData);
        if(!$getPetitionDataQuery){
            $fp = fopen('../../adminpanel/errors.txt', 'a+');
            fwrite($fp, "\r\n Error getting petition database");
            fclose($fp);
            die("Error");
        }
        else{
            if($row = mysqli_fetch_assoc($getPetitionDataQuery)){
                $path = $row['path'];
                $title = $row['title'];
            }
        }

        // Check if the email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address";
            exit;
        }

        function base64_url_encode($input) {
            return strtr(base64_encode($input), '+/=', '-_,');
        }

        function crypto_rand_secure($min, $max) {
            $range = $max - $min;
            if ($range < 0) return $min;
            $log = log($range, 2);
            $bytes = (int) ($log / 8) + 1;
            $bits = (int) $log + 1;
            $filter = (int) (1 << $bits) - 1;
            do {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter;
            } while ($rnd >= $range);
            return $min + $rnd;
        }

        function getToken($length = 32){
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet.= "0123456789";
            for($i=0;$i<$length;$i++){
                $token .= $codeAlphabet[crypto_rand_secure(0,strlen($codeAlphabet))];
            }
            return $token;
        }

        $token = getToken();

        $emailEncoded = base64_url_encode($email);

        $checkGoalSupporters = 'SELECT closed, currentSupporters, goalSupporters FROM petition WHERE id = ' . $petitionId;
        $checkGoalSupportersQuery = mysqli_query($conn, $checkGoalSupporters);
        $changeGoal = false;
        if($checkGoalSupportersQuery){
            if($row = mysqli_fetch_assoc($checkGoalSupportersQuery)){
                if($row['currentSupporters'] + 2 == $row['goalSupporters']){
                    $goalSupporters = $row['goalSupporters'];
                    $changeGoal = true;
                }
            }
        }
        else{
            echo "Error in query";
            $fp = fopen('../../adminpanel/errors.txt', 'a+');
            fwrite($fp, "\r\n Error checking goals supporters");
            fclose($fp);
            exit;
        }
        if(isset($_SESSION['isLogged'])){
            $insertSignatureSql = 'INSERT INTO user_petitions (user_id,petition_id,date,firstName,lastName,email,country,city,reason,public,token) VALUES(' .$_SESSION["userId"] . ',' . $petitionId . ', "' . $date . '","' . $firstName . '","' . $lastName . '","' . $emailEncoded . '","' . $country . '","' . $city . '","' . $reasonForSigning . '", "' . $public . '", "' . $token . '")';
            $insertSignatureQuery = mysqli_query($conn, $insertSignatureSql);
            echo mysqli_error($conn);
            if($changeGoal == true){
                if($goalSupporters == 100) $goalSupporters = 500;
                else if($goalSupporters == 500) $goalSupporters = 1000;
                else if($goalSupporters == 1000) $goalSupporters = 5000;
                else if($goalSupporters == 5000) $goalSupporters = 10000;
                else if($goalSupporters == 10000) $goalSupporters = 25000;
                else if($goalSupporters == 25000) $goalSupporters = 50000;
                else if($goalSupporters == 50000) $goalSupporters = 100000;
                else if($goalSupporters == 100000) $goalSupporters = 250000;
                else if($goalSupporters == 250000) $goalSupporters = 500000;
                else if($goalSupporters == 500000) $goalSupporters = 1000000;
                $updateSupporters = 'UPDATE petition SET currentSupporters = currentSupporters + 1, goalSupporters = ' . $goalSupporters . ' WHERE id = ' . $petitionId;
                $updateSupportersQuery = mysqli_query($conn, $updateSupporters);
            }
            else{
                $updateSupporters = 'UPDATE petition SET currentSupporters = currentSupporters + 1 WHERE id = ' . $petitionId;
                $updateSupportersQuery = mysqli_query($conn, $updateSupporters);
            }

            if($insertSignatureQuery && $updateSupportersQuery){
                echo "Success";
            }
            else{
                echo "Error in query2";
                $fp = fopen('../../adminpanel/errors.txt', 'a+');
                if($insertSignatureQuery){
                    fwrite($fp, "\r\n Error updating supporters query");
                }
                else{
                    fwrite($fp, "\r\n Error inserting signatures - First name: " . $firstName . ' Last name: ' . $lastName . ' Email: ' . $emailEncoded . ' Country: ' . $country . ' City: ' . $city . ' Reason: ' . $reasonForSigning);
                }

                fclose($fp);
                exit;
            }

            //Check if a logged user has country and city. If not update his information

            $isCountrySet = $_POST['isCountrySet'];
            $isCitySet = $_POST['isCitySet'];

            if($isCountrySet == false){
                if($isCitySet == false){
                    $updateLoggedUserInfo = 'UPDATE users SET country = "' . $country . '", city = "' . $city . '" WHERE id = ' . $_SESSION["userId"];
                    $updateLoggedUserInfoQuery = mysqli_query($conn, $updateLoggedUserInfo);
                }
                else{
                    $updateLoggedUserInfo = 'UPDATE users SET country = "' . $country . '" WHERE id = ' . $_SESSION["userId"];
                    $updateLoggedUserInfoQuery = mysqli_query($conn, $updateLoggedUserInfo);
                }
            }
            else{
                if($isCitySet == false){
                    $updateLoggedUserInfo = 'UPDATE users SET city = "' . $city . '" WHERE id = ' . $_SESSION["userId"];
                    $updateLoggedUserInfoQuery = mysqli_query($conn, $updateLoggedUserInfo);
                }
            }

            require '../../phpmailer/PHPMailerAutoload.php';

            $mail = new PHPMailer;

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'sega.superhosting.bg';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'online@signandshare.org';                 // SMTP username
            $mail->Password = '38356112789kircho';                           // SMTP password
            //$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;                                       // TCP port to connect to
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('online@signandshare.org', 'Sign & Share');
            $mail->addAddress($email, $firstName . ' ' . $lastName);     // Add a recipient
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Thank you for making a difference!';
            $mail->Body    = '<table align="center" border="0" cellpadding="0" cellspacing="0" class="" width="520">
       <tbody>
        <tr>
         <td style="font-family: sans-serif;font-size:16px;line-height:24px;">
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
           <tbody>
            <tr>
             <td align="center" style="font-family: sans-serif;font-size:16px;line-height:24px;">
              <table border="0" cellpadding="0" cellspacing="0">
               <tbody>
                <tr>
                 <td align="center" style="font-family: sans-serif;font-size:16px;line-height:24px;"> <a href="https://www.signandshare.org" style="color:#4d8ca5;text-decoration:underline;" target="_blank"> <img alt="signandshare.org" class="" height="22" src="https://www.signandshare.org/images/logo3.png" width="106" style="border:none;display:block;height:44px;max-width:100.0%;outline:none;text-decoration:none;width:172px;"> </a> </td>
                </tr>
               </tbody>
              </table> </td>
            </tr>
            <tr><td style="height: 20px;"></td></tr>
            <tr>
             <td align="left" style="font-family: sans-serif;font-size:16px;line-height:24px;"> <p style="font-family: sans-serif;font-size:16px;line-height:24px;margin-bottom:0;margin-top:0;color: #3c3c3c;">' . $firstName . ', thank you for signing a petition on signandshare.org. Your signature is valuable and makes a real difference. Help even more by sharing this petition with your friends and family: </p></td>
            </tr>
            <tr><td style="height:40px;"></td></tr>
            <tr>
              <td style="height:20px;width:250px;background-color:#f3f3f3;padding:15px;border-radius:3px;">
                <div style="font-family:sans-serif;font-size:16px;font-weight:600;line-height:24px;text-align:center;color:#737273;">Share this petition</div>
                <a target="_blank" href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=https://www.signandshare.org/p/' . $path . '/"><div style="width:45%;float:left;font-family:sans-serif;background-color:#3b5998;text-decoration:none;border-radius: 2px; margin-top:20px;height:34px;padding-top:9px;font-size:17px;color:white;cursor:pointer;text-align:center;"><img alt="" height="22" src="https://www.signandshare.org/images/facebook-logo-email.png" width="22" style="outline:none;text-decoration:none;vertical-align:middle;border-top-style:none;border-right-style:none;border-bottom-style:none;border-left-style:none;">
                &nbsp;&nbsp;Share</div></a><a target="_blank" href="https://twitter.com/intent/tweet?text=' . $title . ' - Sign the Petition! https://www.signandshare.org/p/' . $path .'/ via @signandshareorg"><div style="width:45%;float:right;font-family:sans-serif;background-color:#6faedc;text-decoration:none;border-radius: 2px;margin-top:20px;height:34px;padding-top:9px;font-size:17px;color:white;cursor:pointer;text-align:center;"><img alt="" height="22" src="https://www.signandshare.org/images/twitter-logo-email.png" width="22" style="outline:none;text-decoration:none;vertical-align:middle;border-top-style:none;border-right-style:none;border-bottom-style:none;border-left-style:none;">
                &nbsp;&nbsp;Tweet</div></a>
              </td>
            </tr>
            <tr><td style="height:30px;"></td></tr>
            <tr>
              <td>
                <div style="font-family:sans-serif;font-weight:600;letter-spacing:0.2px;font-size:18px;text-align:center;line-height:27px;color:#737273;">Want to change something? Start a petition and we\'ll help you succeed!</div>
                <a href="/start-a-petition" style="color:white;text-decoration:none;display:block;width:310px;margin-left:auto;margin-right:auto;"><div style="width: 310px;margin-left:auto;margin-right:auto;margin-top:20px;height: 20px;text-align:center;padding-top: 11px;padding-bottom:16px;font-family:sans-serif;font-weight:600;font-size:15px;border:none;background: #f99836;text-decoration:none;border-bottom:2px solid #e6821d;border-radius:2px;color:white;">Start a petition</div></a>
              </td>
            </tr>
            <tr><td><hr style="color:#dbd9db;height:1px;background-color:#dbd9db;border-style:none;margin-top:20px;margin-bottom:15px;"></td></tr>
            <tr>
             <td style="color:#737273;font-family: sans-serif;font-size:13px;line-height:19px;margin-bottom:0;margin-top:0;">This email was sent to ' . $email . ', because you signed a petition on signandshare.org. If you want to remove your signature <a href="/remove_signature?email_id=' . $emailEncoded . '&token=' . $token . '&pid=' . $petitionId . '" target="_blank" style="color:#4d8ca5;text-decoration:underline;">click here</a>.  <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">Click here</a> to update your e-mail preferences or to <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">unsubscribe</a></td>
            </tr>
           </tbody>
          </table> </td>
        </tr>
       </tbody>
      </table>';
            $mail->AltBody = 'Hi ' . $firstName . ',
                                , thank you for signing a petition on signandshare.org. Your signature is valuable and makes a real difference. Help even more by sharing this petition with your friends and family. This email was sent to ' . $email . ', because you signed a petition on signandshare.org. If you want to remove your signature <a href="/remove_signature?email_id=' . $emailEncoded . '&token=' . $token . '&pid=' . $petitionId . '" target="_blank">click here</a>.  <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">Click here</a> to update your e-mail preferences or to <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">unsubscribe</a>';

            $mail->send();
        }
        else{
            $insertSignatureSql = 'INSERT INTO user_petitions (user_id,petition_id,date,firstName,lastName,email,country,city,reason,public,token) VALUES(0,"' . $petitionId . '", "' . $date . '","' . $firstName . '","' . $lastName . '","' . $emailEncoded . '","' . $country . '","' . $city . '","' . $reasonForSigning . '", "' . $public . '", "' . $token . '")';
            $insertSignatureQuery = mysqli_query($conn, $insertSignatureSql);

            if($changeGoal == true){
                if($goalSupporters == 100) $goalSupporters = 500;
                else if($goalSupporters == 500) $goalSupporters = 1000;
                else if($goalSupporters == 1000) $goalSupporters = 5000;
                else if($goalSupporters == 5000) $goalSupporters = 10000;
                else if($goalSupporters == 10000) $goalSupporters = 25000;
                else if($goalSupporters == 25000) $goalSupporters = 50000;
                else if($goalSupporters == 50000) $goalSupporters = 100000;
                else if($goalSupporters == 100000) $goalSupporters = 250000;
                else if($goalSupporters == 250000) $goalSupporters = 500000;
                else if($goalSupporters == 500000) $goalSupporters = 1000000;
                $updateSupporters = 'UPDATE petition SET currentSupporters = currentSupporters + 1, goalSupporters = ' . $goalSupporters . ' WHERE id = ' . $petitionId;
                $updateSupportersQuery = mysqli_query($conn, $updateSupporters);
            }
            else{
                $updateSupporters = 'UPDATE petition SET currentSupporters = currentSupporters + 1 WHERE id = ' . $petitionId;
                $updateSupportersQuery = mysqli_query($conn, $updateSupporters);
            }

            if($insertSignatureQuery && $updateSupportersQuery){
                echo "Success";
            }
            else{
                echo "Error in query 1";
                $fp = fopen('../../adminpanel/errors.txt', 'a+');
                if($insertSignatureQuery){
                    fwrite($fp, "\r\n Error updating supporters query");
                }
                else{
                    fwrite($fp, "\r\n Error inserting signatures - First name: " . $firstName . ' Last name: ' . $lastName . ' Email: ' . $emailEncoded . ' Country: ' . $country . ' City: ' . $city . ' Reason: ' . $reasonForSigning);
                }

                fclose($fp);
                exit;
            }

            require '../../phpmailer/PHPMailerAutoload.php';

            $mail = new PHPMailer;

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'sega.superhosting.bg';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'online@signandshare.org';                 // SMTP username
            $mail->Password = '38356112789kircho';                           // SMTP password
            //$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;                                       // TCP port to connect to
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('online@signandshare.org', 'Sign & Share');
            $mail->addAddress($email, $firstName . ' ' . $lastName);     // Add a recipient
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            $mail->isHTML(true);                                  // Set email format to HTML

           $mail->Subject = 'Thank you for making a difference!';
            $mail->Body    = '<table align="center" border="0" cellpadding="0" cellspacing="0" class="" width="520">
       <tbody>
        <tr>
         <td style="font-family: sans-serif;font-size:16px;line-height:24px;">
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
           <tbody>
            <tr>
             <td align="center" style="font-family: sans-serif;font-size:16px;line-height:24px;">
              <table border="0" cellpadding="0" cellspacing="0">
               <tbody>
                <tr>
                 <td align="center" style="font-family: sans-serif;font-size:16px;line-height:24px;"> <a href="https://www.signandshare.org" style="color:#4d8ca5;text-decoration:underline;" target="_blank"> <img alt="signandshare.org" class="" height="22" src="https://www.signandshare.org/images/logo3.png" width="106" style="border:none;display:block;height:44px;max-width:100.0%;outline:none;text-decoration:none;width:172px;"> </a> </td>
                </tr>
               </tbody>
              </table> </td>
            </tr>
            <tr><td style="height: 20px;"></td></tr>
            <tr>
             <td align="left" style="font-family: sans-serif;font-size:16px;line-height:24px;"> <p style="font-family: sans-serif;font-size:16px;line-height:24px;margin-bottom:0;margin-top:0;color: #3c3c3c;">' . $firstName . ', thank you for signing a petition on signandshare.org. Your signature is valuable and makes a real difference. Help even more by sharing this petition with your friends and family: </p></td>
            </tr>
            <tr><td style="height:40px;"></td></tr>
            <tr>
              <td style="height:20px;width:250px;background-color:#f3f3f3;padding:15px;border-radius:3px;">
                <div style="font-family:sans-serif;font-size:16px;font-weight:600;line-height:24px;text-align:center;color:#737273;">Share this petition</div>
                <a target="_blank" href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=https://www.signandshare.org/p/' . $path . '/"><div style="width:45%;float:left;font-family:sans-serif;background-color:#3b5998;text-decoration:none;border-radius: 2px; margin-top:20px;height:34px;padding-top:9px;font-size:17px;color:white;cursor:pointer;text-align:center;"><img alt="" height="22" src="https://www.signandshare.org/images/facebook-logo-email.png" width="22" style="outline:none;text-decoration:none;vertical-align:middle;border-top-style:none;border-right-style:none;border-bottom-style:none;border-left-style:none;">
                &nbsp;&nbsp;Share</div></a><a target="_blank" href="https://twitter.com/intent/tweet?text=' . $title . ' - Sign the Petition! https://www.signandshare.org/p/' . $path .'/ via @signandshareorg"><div style="width:45%;float:right;font-family:sans-serif;background-color:#6faedc;text-decoration:none;border-radius: 2px;margin-top:20px;height:34px;padding-top:9px;font-size:17px;color:white;cursor:pointer;text-align:center;"><img alt="" height="22" src="https://www.signandshare.org/images/twitter-logo-email.png" width="22" style="outline:none;text-decoration:none;vertical-align:middle;border-top-style:none;border-right-style:none;border-bottom-style:none;border-left-style:none;">
                &nbsp;&nbsp;Tweet</div></a>
              </td>
            </tr>
            <tr><td style="height:30px;"></td></tr>
            <tr>
              <td>
                <div style="font-family:sans-serif;font-weight:600;letter-spacing:0.2px;font-size:18px;text-align:center;line-height:27px;color:#737273;">Want to change something? Start a petition and we\'ll help you succeed!</div>
                <a href="/start-a-petition" style="color:white;text-decoration:none;display:block;width:310px;margin-left:auto;margin-right:auto;"><div style="width: 310px;margin-left:auto;margin-right:auto;margin-top:20px;height: 20px;text-align:center;padding-top: 11px;padding-bottom:16px;font-family:sans-serif;font-weight:600;font-size:15px;border:none;background: #f99836;text-decoration:none;border-bottom:2px solid #e6821d;border-radius:2px;color:white;">Start a petition</div></a>
              </td>
            </tr>
            <tr><td><hr style="color:#dbd9db;height:1px;background-color:#dbd9db;border-style:none;margin-top:20px;margin-bottom:15px;"></td></tr>
            <tr>
             <td style="color:#737273;font-family: sans-serif;font-size:13px;line-height:19px;margin-bottom:0;margin-top:0;">This email was sent to ' . $email . ', because you signed a petition on signandshare.org. If you want to remove your signature <a href="/remove_signature?email_id=' . $emailEncoded . '&token=' . $token . '&pid=' . $petitionId . '" target="_blank" style="color:#4d8ca5;text-decoration:underline;">click here</a>.  <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">Click here</a> to update your e-mail preferences or to <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">unsubscribe</a></td>
            </tr>
           </tbody>
          </table> </td>
        </tr>
       </tbody>
      </table>';
            $mail->AltBody = 'Hi ' . $firstName . ',
                                , thank you for signing a petition on signandshare.org. Your signature is valuable and makes a real difference. Help even more by sharing this petition with your friends and family. This email was sent to ' . $email . ', because you signed a petition on signandshare.org. If you want to remove your signature <a href="/remove_signature?email_id=' . $emailEncoded . '&token=' . $token . '&pid=' . $petitionId . '" target="_blank">click here</a>.  <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">Click here</a> to update your e-mail preferences or to <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">unsubscribe</a>';

            $mail->send();
        }
    }
    else{
        header("Location: index.php");
    }

?>
