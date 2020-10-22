<?php
    session_start();
    require_once("../config.php");

    $conn = mysqli_connect($servername,$user,$password,$dbname);
    if($conn == false){
        echo 'ERROR';
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign and Share - Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script> <!-- Jquery -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'> <!-- Roboto -->
    <script src=" https://use.fontawesome.com/dd65bc73a0.js " > </script>
</head>

<body>

		<?php
		        require '../phpmailer/PHPMailerAutoload.php';

            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'sega.superhosting.bg';
            $mail->SMTPAuth = true;
            $mail->Username = 'online@signandshare.org';
            $mail->Password = '38356112789kircho';
            $mail->Port = 25;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('online@signandshare.org', 'Sign & Share');

            $getEmails = "SELECT email, token, firstName, lastName FROM user_petitions WHERE petition_id = 43 LIMIT 1000";
            $getEmailsQuery = mysqli_query($conn, $getEmails);

            while($row = mysqli_fetch_assoc($getEmailsQuery)){
                $token = $row['token'];
                $emailEncoded = $row['email'];
                $firstName = $row['firstName'];
                $lastName = $row['lastName'];
                $email = base64_decode(strtr($emailEncoded, '-_,', '+/='));
            }

            $mail->isHTML(true);

            $petitionTitle = "";

            $mail->Subject = '1 new update on a petition you support';
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
             <td align="left" style="font-family: sans-serif;font-size:16px;line-height:24px;"> <p style="font-family: sans-serif;font-size:16px;line-height:24px;margin-bottom:0;margin-top:0;color: #3c3c3c;">Katy Rhoades has posted an update on a petition you\'ve signed: <br>"Hessle Town Clerk have confimed this matter has been added to the items to be discussed at their next meeting. I will be attending....and would love some additonal support if anyone would like to join.<br>
                 Hessle Town Hall 2nd May 7.30pm. Residents welcome.<br><br>

                 Hull daily mail have also agreed to support us with this petition and i am meeting with them tomorrow.<br>
                 Remember to keep sharing people we need alot more to be done :) xxx".<br> Updates are sent from each petition’s author. See the petition <a href="/p/east-riding-of-yorkshire-council-to-allow-first-lane-residents-to-park-on-the-access-bridges/">here</a>.
            </p></td>
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
             <td style="color:#737273;font-family: sans-serif;font-size:13px;line-height:19px;margin-bottom:0;margin-top:0;">The persons (or organizations), who started these petitions, are not affiliated with signandshare.org. Sign & Share did not create these petitions and is not responsible for their content. This email was sent to ' . $email . ', because you signed a petition on signandshare.org. If you want to remove your signature <a href="/remove_signature?email_id=' . $emailEncoded . '&token=' . $token . '&pid=' . $petitionId . '" target="_blank" style="color:#4d8ca5;text-decoration:underline;">click here</a>.  <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">Click here</a> to update your e-mail preferences or to <a style="color:#4d8ca5;" href="/unsubscribe?token=' . $emailEncoded . '" target="_blank">unsubscribe</a></td>
            </tr>
           </tbody>
          </table> </td>
        </tr>
       </tbody>
      </table>';
            if($mail->send()){
            	echo 'send';
            }
            else{
            	echo 'no send';
            }
		?>

</body>

</html>
