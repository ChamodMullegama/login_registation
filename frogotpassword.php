
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
</head>
<body>
    <div class="con">
    <div class="aleart">
    <?php
           
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<div class="login-status-message-error">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']); // Clear the session variable after displaying the message
            }
           
            
    ?>
    </div>
    <form action="frogotpasswordcode.php" method="post">
        <input type="email" name="email">
        <button type="submit" name="submit"> Send mail </button>
    </form>
    </div>
</body>
</html>