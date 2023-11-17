<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=h, initial-scale=">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
</head>
<body>
    <div class="con">
       <div class="aleart">
             <?php
             session_start();
                 // Check if there is a login status message
              if (isset($_SESSION['error'])) {
              echo '<div class="login-status-message-error">' . $_SESSION['error'] . '</div>';
              unset($_SESSION['error']); // Clear the session variable after displaying the message
              }
              ?>
        </div>
       <form action="reset_password.php" method="post">
           <input type="password" name="new_password" placeholder="Enter new password" required>
           <input type="password" name="confirm_password" placeholder="Confrom password" required>
           <button type="submit" name="submit">change password</button>
       </form>
   </div>
</body>
</html>