<?php
include 'dbconn.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

function generateOTP($length = 6) {
    return rand(pow(10, $length-1), pow(10, $length)-1);
}

function sendmail($name,$email,$otp){

   // require 'vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
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
        $mail->Subject = 'Verification Code for Registration: ' . $name;
        $mail->Body = 'Your OTP for registration is: ' . $otp;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

if(isset($_POST['submit'])){
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
$passhash =password_hash($password,PASSWORD_DEFAULT);
//$verification_code=md5(rand());

$otp = generateOTP();
$_SESSION['otp'] = $otp;

$sql = "SELECT email FROM user WHERE email = ?";
$stm =mysqli_stmt_init($conn);



if(!mysqli_stmt_prepare($stm,$sql)){
    echo "woring";
}else{
    mysqli_stmt_bind_param($stm,"s",$email);
    mysqli_stmt_execute($stm);
    $result = mysqli_stmt_get_result($stm);

    if(mysqli_num_rows($result)>0){
          $_SESSION['erro']='email is alredy exists';
          header ("location: index.php");
    }else{
        $sql_insert = "INSERT INTO user (name, email, password, otp) VALUES (?, ?, ?, ?)";

        if (!mysqli_stmt_prepare($stm, $sql_insert)) {
            echo "woring";
        } else {
            mysqli_stmt_bind_param($stm, "ssss", $name, $email, $passhash, $otp);
            mysqli_stmt_execute($stm);
    
            if ($stm) {
                sendmail($name, $email, $otp);
                $_SESSION['success'] = 'Registration successful. Please verify your account with the OTP sent to your email.';
                header("location: verifye.php");
            } else {
                $_SESSION['error'] = 'Registration failed';
                header("location: index.php");
            }
        }
    }
   
    
    
    
    
    
    
    }
} 



?>