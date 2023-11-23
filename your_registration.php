<?php
include 'dbconn.php';
include 'sentmail.php';
session_start();



function generateOTP($length = 6) {
    return rand(pow(10, $length-1), pow(10, $length)-1);
}

$otp = generateOTP();
$_SESSION['otp'] = $otp;


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passhash = password_hash($password, PASSWORD_DEFAULT);
    $otp = generateOTP();
    $_SESSION['otp'] = $otp;

    $database = new dbconn(); // Create an instance of your Database class

    try {
        $conn = $database->getConnection();
         

  $sql = "SELECT email FROM user WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$result = $stmt->fetch();


if($result){
    $_SESSION['erro'] = 'email is already exists';
    header("location: index.php");
} else {
    // ...rest of the code

    $sql_insert = "INSERT INTO user (name, email, password, otp) VALUES (:name, :email, :password, :otp)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bindParam(':name', $name);
$stmt_insert->bindParam(':email', $email);
$stmt_insert->bindParam(':password', $passhash);
$stmt_insert->bindParam(':otp', $otp);
$result_insert = $stmt_insert->execute();

if ($result_insert) {
    // ...rest of the code
    $sentmail = new sentmail(); 
    $sentmail->sendmail($name, $email, $otp);
    $_SESSION['success'] = 'Registration successful. Please verify your account with the OTP sent to your email.';
    header("location: verifye.php");
} else {
    // ...rest of the code
    $_SESSION['error'] = 'Registration failed';
    header("location: index.php");
}
}
     
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>












