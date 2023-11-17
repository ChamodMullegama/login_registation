<?php
include 'dbconn.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $sql = "SELECT email FROM user WHERE email = ?";
    $stm =mysqli_stmt_init($conn);
    
    
    
    if(!mysqli_stmt_prepare($stm,$sql)){
        echo "woring";
    }else{
        mysqli_stmt_bind_param($stm,"s",$email);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
    
        if(mysqli_num_rows($result)>0){
             // Generate a unique token for password reset
     $token = bin2hex(random_bytes(32)); // Generate a random token

     // Store the token in the session to validate later
     $_SESSION['reset_token'] = $token;
     $_SESSION['reset_email'] = $email;
 
     // Send email with a link containing the reset token
     $reset_link = "http://localhost/otpsent/changepassword.php?token=$token";

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
       // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'kingchamod2001@gmail.com';                     //SMTP username
        $mail->Password   = 'kgar qzlu zyav wtmv';                               //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('kingchamod2001@gmail.com',$email);
        $mail->addAddress($email);     //Add a recipient
       /*  $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com'); */
    
        //Attachments
       /*  $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   */  //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body =  "Click the link to reset your password: $reset_link";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
        }else{
            $_SESSION['error'] = 'Email does not exist. Please register first.';
            header('location: frogotpassword.php?token=' );
            exit(0);
       

            }

    }
}
   
    

?>

