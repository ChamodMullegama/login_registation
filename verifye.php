<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="con">
        <div class="aleart">
    <?php
   session_start();
    if (isset($_SESSION['success'])) {
        echo '<div class="login-status-message-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']); // Clear the session variable after displaying the message
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="login-status-message-error">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']); // Clear the session variable after displaying the message
    }

    ?>
    </div>
<form method="post" action="verify_otp.php" class="otp">
    <input type="text"  name="otp" required placeholder="Enter otp">
    <input type="submit" name="submit" >
</form>
</div>
</body>
</html>