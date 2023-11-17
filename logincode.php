<?php
include "dbconn.php";
session_start();

if(isset($_POST['login_submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $login_sql = "SELECT * FROM user WHERE email = ? LIMIT 1;";
    $stm = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stm, $login_sql)) {
        mysqli_stmt_bind_param($stm, 's', $email);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            // Verify the entered password against the hashed password
            if (password_verify($password, $row['password'])) {
                // Check if the account is verified
                if ($row['v_status'] == '1') {
                    // User is authenticated, proceed to dashboard or another page
                    $_SESSION['user_id'] = $row['user_id']; // Optionally, store user_id in the session
                    header('location: dash.php');
                    exit(0);
                } else {
                    $_SESSION['l_error'] = 'Please verify your account.';
                    header('location: login.php');
                    exit(0);
                }
            } else {
                $_SESSION['l_error'] = 'Invalid email or password.';
                header('location: login.php');
                exit(0);
            }
        } else {
            $_SESSION['l_error'] = 'Invalid email or password.';
            header('location: login.php');
            exit(0);
        }

        mysqli_stmt_close($stm);
    } else {
        $_SESSION['l_error'] = 'Internal server error.';
        header('location: login.php');
        exit(0);
    }
}
?>
