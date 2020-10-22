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
            $email = 'hun7ercho@gmail.com';
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
              <td>
                <div style="font-family:sans-serif;font-weight:600;letter-spacing:0.2px;font-size:19px;text-align:center;line-height:28px;color:#737273;">Want to change something? Start a petition and we\'ll help you succeed!</div>
                <a href="/start-a-petition" style="color:white;text-decoration:none;display:block;width:310px;margin-left:auto;margin-right:auto;"><div style="width: 310px;margin-left:auto;margin-right:auto;margin-top:20px;height: 20px;text-align:center;padding-top: 11px;padding-bottom:16px;font-family:sans-serif;font-weight:600;font-size:15px;border:none;background: #f99836;text-decoration:none;border-bottom:2px solid #e6821d;border-radius:2px;color:white;">Start a petition</div></a>
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