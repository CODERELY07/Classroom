<?php 


$isLoggedIn = isset($_SESSION['user_id']);

// Handle auto-login using cookies
if (isset($_COOKIE['user_email']) && isset($_COOKIE['remember_token'])) {
    $email = $_COOKIE['user_email'];
    $token = $_COOKIE['remember_token'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id, password, role FROM Users WHERE email = :email AND remember_token = :token");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'] ?? 'yes'; // Default role to 'yes' if undefined
        header('Location: ?route=room');
        exit;
    }
}

// If not logged in, you might want to display the login form or handle other logic here

?>

<html>
<head>
    <title>Get Started Now</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        p {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
        }
        .btn-google, .btn-apple {
            background-color: #fff;
            border: 1px solid #ddd;
            color: #000;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-google img, .btn-apple img {
            margin-right: 8px;
        }
        .btn-login {
            background-color: #3b82f6;
            color: #fff;
            font-size: 16px;
        }
        .form-check-label a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
        }
        .form-check-label a:hover {
            text-decoration: underline;
        }
        .text-signin a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
        }
        .text-signin a:hover {
            text-decoration: underline;
        }
        .form-label {
            font-size: 14px;
        }
        .form-control {
            font-size: 14px;
        }
        .text-center.my-3 {
            position: relative;
        }
        .text-center.my-3::before, .text-center.my-3::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background-color: #ddd;
        }
        .text-center.my-3::before {
            left: 0;
        }
        .text-center.my-3::after {
            right: 0;
        }
    </style>
</head>
<body>
    <div class="container">
    <div id="responseMessage" class="alert text-center" role="alert" style="display: none;"></div>
        <h2>Sign In Now</h2>
        <p>Enter your credentials to access your account</p>
        <form id="loginForm">
            
            <div class="mb-3">
                <label class="form-label" for="email">Email address</label>
                <input class="form-control" name="email" id="email" type="email" placeholder="example@gmail.com"/>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <label class="form-label" style="margin-bottom:-20px" for="password">Password</label>
                <a class="text-decoration-none" href="#">Forgot password?</a>
            </div>
            <div class="mb-3">
                <input class="form-control" name="password" id="password" placeholder="Your Password" type="password"/>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" name="remember_me" id="remember_me" type="checkbox" />
                <label class="form-check-label" for="remember_me">
                    Remember Me
                </label>
            </div>
            <div class="d-grid">
                <button class="btn btn-login" type="submit">Sign In</button>
            </div>
        </form>
        <p class="text-center text-signin mt-3">
            Don't have an account yet? <a href="?route=signup">Sign up</a>
        </p>

    </div>
    <?php include('./includes/scripts.php')?>;
</body>
</html>
