<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login Form</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="con">
    <div class="aleart">
    <?php
           
            session_start();
            // Check if there is a login status message
            if (isset($_SESSION['l_error'])) {
                echo '<div class="login-status-message-error">' . $_SESSION['l_error'] . '</div>';
                unset($_SESSION['l_error']); // Clear the session variable after displaying the message
            }
           
            if (isset($_SESSION['success'])) {
                echo '<div class="login-status-message-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']); // Clear the session variable after displaying the message
            }
           
            
    ?>
    </div>
  
    <form action="logincode.php" method="POST" > 
    <h2>Login</h2>
        <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
        <input type="password" id="password" name="password" placeholder="Enter password" required><br>
        <div class="links">
            <a href="./frogotpassword.php" class="forgot-password">Forgot password?</a>
            <a href="./index.php" class="create-account">Create account</a>
        </div>
      <button type="submit" name="login_submit" value="Register"  class="btn">login </button>
      
    </form>
 
 </div>
</body>
</html>
