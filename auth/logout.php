<?php
session_start();

// Debugging: Check the session before logout


// Destroy session variables
session_unset();

// Destroy the session
session_destroy();

// Expire the cookies by setting their expiration time to a past timestamp
setcookie('user_email', '', time() - 3600, '/');  // Expire the user_email cookie
setcookie('user_password', '', time() - 3600, '/');  // Expire the user_password cookie

// Debugging: Check the session and cookies after logout


// Redirect to the home page
header('Location: ?route=home');
exit;
?>
