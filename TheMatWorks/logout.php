<?php
// The code for joining the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// The code for clearing session variables
$_SESSION = array();

// The code for destroying the session
session_destroy();

// The code for redirecting to login page
header("Location: login.php");
exit;
?>