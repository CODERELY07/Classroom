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


// Route access control based on login status
if ($isLoggedIn) {
    // If logged in, restrict access to only logout and user-related pages
    if ($route === 'home' || $route === 'signup' || $route === 'login') {
        header('Location: ?route=room'); // Redirect to a default route for logged-in users
        exit;
    }
} else {
    // If not logged in, restrict access to home, signup, and login pages
    if ($route !== 'home' && $route !== 'signup' && $route !== 'login') {
        header('Location: ?route=login'); // Redirect to login page
        exit;
    }
}

// Include the requested route page or show a 404 error
if (array_key_exists($route, $routes)) {
    include($routes[$route]);
} else {
    include('404.php'); // Show 404 error if the route is invalid
}
?>
