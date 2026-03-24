<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Greenfield Local Hub</title>
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <header>

    <div class="logo">Greenfield Local Hub</div>

    <nav>
        <ul class="menu">
          
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="purchase.php">Purchase</a></li>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'staff'): ?>
                  <li><a href="staff_dash.php">Staff portal</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign up</a></li>
            <?php endif; ?>

        </ul>
    </nav>

  </header>
  
 
  </head>
  <body>