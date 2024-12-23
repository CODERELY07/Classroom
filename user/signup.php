<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<h2>Sign Up</h2>

<form id="signupForm">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Sign Up">
</form>

<div id="responseMessage"></div>
<?php include('./includes/scripts.php')?>;
</body>
</html>
