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
    	$email = mysqli_real_escape_string($conn, $_POST['email']);
    	
        if($email != "" && filter_var($email, FILTER_VALIDATE_EMAIL)){
            $checkEmailExistingSql = 'SELECT firstName, lastName FROM users WHERE email = "' . $email . '" LIMIT 1';
            $checkEmailExisting = mysqli_query($conn, $checkEmailExistingSql);
            if(mysqli_num_rows($checkEmailExisting) != 0){
                if($row = mysqli_fetch_assoc($checkEmailExisting)){
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                }
            }
            else{
                echo "Success";
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

            $cryptedEmail = base64_url_encode($email);

            $forgotPassSql = 'INSERT INTO forgot_pass (time_created, time_expires, token, email_id) VALUES(CURTIME(),CURRENT_TIMESTAMP + INTERVAL "2" HOUR, "' . $token . '", "' . $cryptedEmail . '")';
            $forgotPassQuery = mysqli_query($conn, $forgotPassSql);
            if(!$forgotPassQuery){
                echo "There has been some error. Please try again.";
                exit;
            }

            require 'phpmailer/PHPMailerAutoload.php';

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

            $mail->Subject = 'Reset Your Sign & Share password';
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
             <td align="left" style="font-family: sans-serif;font-size:16px;line-height:24px;"> <p style="font-family: sans-serif;font-size:16px;line-height:24px;margin-bottom:0;margin-top:0;color: #3c3c3c;">Hi ' . $firstName . ',</p> <p style="font-family: sans-serif;font-size:16px;line-height:24px;margin-bottom:0;margin-top:16px;color: #3c3c3c !important;">You’re receiving this email because you recently requested a new password for your signandshare.org account.</p> <p style="font-family: sans-serif;font-size:16px;line-height:24px;margin-bottom:0;margin-top:16px;color: #3c3c3c;">To reset your password, click the link below or copy and paste it into your web browser.</p> <p class="" style="font-family: sans-serif;font-size:16px;line-height:24px;margin-bottom:0;margin-top:16px;max-width:100.0%;word-break:break-all;word-wrap:break-word;"> <a href="/reset_password?set=' . $token . '&email_id=' . $cryptedEmail . '" style="color:#4d8ca5;text-decoration:underline;" target="_blank">https://www.signandshare.org/reset_password?set=' . $token . '&email_id=' . $cryptedEmail . '</a> </p> </td> 
            </tr> 
            <tr><td><hr style="color:#dbd9db;height:1px;background-color:#dbd9db;border-style:none;margin-top:20px;margin-bottom:15px;"></td></tr>
            <tr> 
             <td style="color:#737273;font-family: sans-serif;font-size:13px;line-height:19px;margin-bottom:0;margin-top:0;">This email was sent to ' . $email . '.  <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $cryptedEmail . '" target="_blank">Click here</a> to update your e-mail preferences or to <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $cryptedEmail . '" target="_blank">unsubscribe</a>.</td> 
            </tr> 
           </tbody>
          </table> </td> 
        </tr> 
       </tbody>
      </table>';
            $mail->AltBody = 'Hi ' . $firstName . ',
                                You’re receiving this email because you recently requested a new password for your signandshare.org account.
                                To reset your password, click the link below or copy and paste it into your web browser.
                                https://www.signandshare.org/reset_password?set=' . $token . ' . This email was sent to ' . $email . '.  <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $cryptedEmail . '" target="_blank">Click here</a> to update your e-mail preferences or to <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $cryptedEmail . '" target="_blank">unsubscribe</a>.';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
            } else {
                echo "Success";
            }
        }
        else{
            echo "Success";
        }
    }
    else{
    	echo "There has been some error. Please try again.";
    	exit;
    }
?>