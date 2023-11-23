<?php
include "dbconn.php";
session_start();

if (isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $database = new dbconn(); // Create an instance of your Database class

    try {
        $conn = $database->getConnection();

        $login_sql = "SELECT * FROM user WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($login_sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Verify the entered password against the hashed password
            if (password_verify($password, $row['password'])) {
                // Check if the account is verified
                if ($row['v_status'] == '1') {
                    $_SESSION['user_id'] = $row['user_id']; // Optionally, store user_id in the session
                    header('location: dash.php');
                    exit();
                } else {
                    $_SESSION['l_error'] = 'Please verify your account.';
                    header('location: login.php');
                    exit();
                }
            } else {
                $_SESSION['l_error'] = 'Invalid email or password.';
                header('location: login.php');
                exit();
            }
        } else {
            $_SESSION['l_error'] = 'Invalid email or password.';
            header('location: login.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['l_error'] = 'Internal server error.';
        header('location: login.php');
        exit();
    }
}
?>
