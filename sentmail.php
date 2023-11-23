<?php
include ("dbconn.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require '../PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';




class sentmail{

    public $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();                                           //Send using SMTP
        $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = 'kingchamod2001@gmail.com';                     //SMTP username
        $this->mail->Password   = 'kgar qzlu zyav wtmv';                               //SMTP password
        $this->mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $this->mail->Port       = 465;      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
      
        // ... rest of your mail configuration
    }


 public function sendmail($name,$email,$otp){

   // require 'vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
   
    
    try {
        $this->mail->setFrom('kingchamod2001@gmail.com',$email);
        $this->mail->addAddress($email);
        //Server settings
          //Add a recipient
       /*  $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com'); */
    
        //Attachments
       /*  $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   */  //Optional name
    
        //Content
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = 'Verification Code for Registration: ' . $name;
        $this->mail->Body = 'Your OTP for registration is: ' . $otp;
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $this->mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: { $this->mail->ErrorInfo}";
    }

}

public function sendmailresetpassword($email,$reset_link){
    
    try {
        //Server settings
     
        //Recipients
        $this->mail->setFrom('kingchamod2001@gmail.com',$email);
        $this->mail->addAddress($email);     //Add a recipient
       /*  $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com'); */
    
        //Attachments
       /*  $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   */  //Optional name
    
        //Content
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = 'Here is the subject';
        $this->mail->Body =  "Click the link to reset your password: $reset_link";
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $this->mail->send();
        $_SESSION['success'] = 'password reset link in your inbox please chek your inbox.';
        header("location: frogotpassword.php");
        echo 'Message has been sent';
    
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: { $this->mail->ErrorInfo}";
    }

}


}
 


?>