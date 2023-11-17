<?php

session_start();
include 'dbconn.php';

if (isset($_POST['submit'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_GET['token'];
    
    // Validate the token from the session
    if ((isset($_SESSION['reset_token']) && $_SESSION['reset_token'] === $token && isset($_SESSION['reset_email']))) {
        $_SESSION['error'] = 'Invalid or expired token';
        header('location:frogotpassword.php' );
        exit();
    }
    
    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match';
        header('location: changepassword.php');
        exit();
    }

    // Retrieve the email associated with the token
    $email = $_SESSION['reset_email'];

    // Update the user's password
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $update_sql = 'UPDATE user SET password = ? WHERE email = ?';
    $stm = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stm, $update_sql)) {
        $_SESSION['error'] = 'Oops, something went wrong';
        header('location: changepassword.php');
        exit();
    } else {
        mysqli_stmt_bind_param($stm, "ss", $new_password_hash, $email);
        mysqli_stmt_execute($stm);

        if (mysqli_stmt_affected_rows($stm) > 0) {
            $_SESSION['success'] = 'Password updated successfully. Please log in with your new password.';
            header('location: login.php');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update password';
            header('location: changepassword.php');
            exit();
        }
    }
}


?>