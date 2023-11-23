<?php
include 'dbconn.php';
include 'sentmail.php';
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $database = new dbconn(); // Create an instance of your Database class

    try {
        $conn = $database->getConnection();
        $sql = "SELECT email FROM user WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
               
        if ($result) {
            // Generate a unique token for password reset
            $token = bin2hex(random_bytes(32)); // Generate a random token
    
            // Store the token in the session to validate later
            $_SESSION['reset_token'] = $token;
            $_SESSION['reset_email'] = $email;
    
            // Send email with a link containing the reset token
            $reset_link = "http://localhost/login/changepassword.php?token=$token";
            
            // Create an instance of the sentmail class
            $sentmail = new sentmail();
            $sentmail->sendmailresetpassword($email, $reset_link);
          

        
        } else {
            $_SESSION['error'] = 'Email does not exist. Please register first.';
            header('location: frogotpassword.php');
            exit();
        }
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
