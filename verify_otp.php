<?php
session_start();
include 'dbconn.php';

if (isset($_SESSION['otp']) && isset($_POST['submit'])) {
    $user_otp = $_POST['otp'];
    $stored_otp = $_SESSION['otp'];

    // Check if entered OTP matches the stored OTP
    if ($user_otp == $stored_otp) {
        // Update the database to set v_status to '1' for the corresponding user with this OTP
        $database = new dbconn(); // Create an instance of your Database class

        try {
            $conn = $database->getConnection();

            $update_sql = 'UPDATE user SET v_status = "1" WHERE otp = :otp';
            $stmt = $conn->prepare($update_sql);
            $stmt->bindParam(':otp', $stored_otp);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['success'] = 'Your account is verified. Please login.';
                header('location: login.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to update v_status for the user.';
                header('location: verify_otp.php');
                exit();
            }
        } catch(PDOException $e) {
            $_SESSION['error'] = 'Oops, something went wrong: ' . $e->getMessage();
            header('location: login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Invalid OTP. Please try again.';
        header('location: verifye.php');
        exit();
    }
} else {
    $_SESSION['statuss'] = 'Session expired or invalid request.';
    header('location: login.php');
    exit();
}
?>
<!-- Your HTML form for OTP verification here -->
