<?php
session_start();
include('includes/db.php');
$database = new Database();
$conn = $database->getConnection();
include('includes/functions.php');

$routes = [
    'home' => 'home.php',
    'signup' => 'user/signup.php',
    'login' => 'user/login.php',
    'room' => 'user/index.php',
    'subject' => 'user/subject.php',
    'logout' => 'auth/logout.php',
    'class' => 'user/class.php',
];

$route = isset($_GET['route']) ? $_GET['route'] : 'home';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Route access control
if ($isLoggedIn) {
    // If logged in, restrict access to only logout and user pages
    if ($route === 'home' || $route === 'signup' || $route === 'login') {
        header('Location: ?route=room'); // Redirect to a default route for logged-in users
        exit;
    }
} else {
    // If not logged in, restrict access to only home, signup, and login
    if ($route !== 'home' && $route !== 'signup' && $route !== 'login') {
        header('Location: ?route=login');
        exit;
    }
}

// Include the requested route page or show a 404 error
if (array_key_exists($route, $routes)) {
    include($routes[$route]);
} else {
    include('404.php'); 
}
?>
