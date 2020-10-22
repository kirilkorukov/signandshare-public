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
            $email = 'konstanfo3@abv.bg';
            $firstName = 'Admin';            
            $mail->Password = '38356112789kircho';                       
            $mail->Port = 25;
            $mail->CharSet = 'UTF-8';                          

            $mail->setFrom('online@signandshare.org', 'Sign & Share');
            $mail->addAddress($email, $firstName . ' ' . $lastName);
            $mail->isHTML(true);

            $mail->Subject = 'Test';
            $mail->Body    = '<table align="center" border="0" cellpadding="0" cellspacing="0" class="" width="520"> 
       <tbody>
        <tr> 
         <td style="font-family: sans-serif;font-size:16px;line-height:24px;"> 
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"> 
           <tbody>
            <tr>
              <td style="height:20px;width:250px;background-color:#ececec;padding:15px;border-radius:3px;">
                <div style="font-family:sans-serif;font-size:16px;font-weight:600;line-height:24px;text-align:center;color:#464646;">Share this petition</div>
                <a target="_blank" href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=https://www.signandshare.org/p/' . $path . '/"><div style="width:45%;float:left;font-family:sans-serif;background-color:#3b5998;text-decoration:none;border-radius: 2px; margin-top:20px;height:34px;padding-top:9px;font-size:17px;color:white;cursor:pointer;text-align:center;"><img alt="" height="22" src="https://www.signandshare.org/images/facebook-logo-email.png" width="22" style="outline:none;text-decoration:none;vertical-align:middle;border-top-style:none;border-right-style:none;border-bottom-style:none;border-left-style:none;">
                &nbsp;&nbsp;Share</div></a><a target="_blank" href="https://twitter.com/intent/tweet?text=' . $title . ' - Sign the Petition! https://www.signandshare.org/p/' . $path .'/ via @signandshareorg"><div style="width:45%;float:right;font-family:sans-serif;background-color:#6faedc;text-decoration:none;border-radius: 2px;margin-top:20px;height:34px;padding-top:9px;font-size:17px;color:white;cursor:pointer;text-align:center;"><img alt="" height="22" src="https://www.signandshare.org/images/twitter-logo-email.png" width="22" style="outline:none;text-decoration:none;vertical-align:middle;border-top-style:none;border-right-style:none;border-bottom-style:none;border-left-style:none;">
                &nbsp;&nbsp;Tweet</div></a>
              </td>
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