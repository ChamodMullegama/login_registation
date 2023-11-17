<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="con">
    <div class="aleart">
    <?php
            session_start();
            // Check if there is a login status message
            if (isset($_SESSION['erro'])) {
                echo '<div class="login-status-message-error">' . $_SESSION['erro'] . '</div>';
                unset($_SESSION['erro']); // Clear the session variable after displaying the message
            }
            if (isset($_SESSION['susess'])) {
                echo '<div class="login-status-message-success">' . $_SESSION['susess'] . '</div>';
                unset($_SESSION['susess']); // Clear the session variable after displaying the message
            }
        ?>
    </div>
  
    <form action="your_registration.php" method="POST"> 
    <h2>Registration Form</h2>
        <input type="text" id="name" name="name" placeholder="Enter your name" required><br>
        <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
        <input type="password" id="password" name="password" placeholder="Enter password" required><br>
        <button type="submit" name="submit" value="Register"  class="btn">register </button>
        <a href="./login.php">Singin</a>
    </form>

 </div>
</body>
</html>
