<?php
session_start();
include 'dbconn.php';

if (isset($_SESSION['otp']) && isset($_POST['submit'])) {
    $user_otp = $_POST['otp'];
    $stored_otp = $_SESSION['otp'];

    // Check if entered OTP matches the stored OTP
    if ($user_otp == $stored_otp) {
        // Update the database to set v_status to '1' for the corresponding user with this OTP
        $update_sql = 'UPDATE user SET v_status = "1" WHERE otp = ?';
        $stm = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stm, $update_sql)) {
            $_SESSION['error'] = 'Oops, something went wrong: ' . mysqli_error($conn);
            header('location: login.php');
            exit(0);
        } else {
            mysqli_stmt_bind_param($stm, "s", $stored_otp);
            mysqli_stmt_execute($stm);

            if (mysqli_stmt_affected_rows($stm) > 0) {
                $_SESSION['success'] = 'Your account is verified. Please login.';
                header('location: login.php');
                exit(0);
            } else {
                $_SESSION['error'] = 'Failed to update v_status for the user.';
                header('location: verify_otp.php');
                exit(0);
            }
        }
    } else {
        $_SESSION['error'] = 'Invalid OTP. Please try again.';
        header('location: verifye.php');
        exit(0);
    }
} else {
    $_SESSION['statuss'] = 'Session expired or invalid request.';
    header('location: login.php');
    exit(0);
}
?>
<!-- Create a form to accept OTP -->
<!-- Your HTML form for OTP verification here -->
