<?php
include('./../includes/db.php');

// Create a new database instance
$database = new Database();
$conn = $database->getConnection();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $role = isset($_POST['role']) ? htmlspecialchars(trim($_POST['role'])) : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields and select a valid role.']);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
        exit;
    }

    // Password validation: at least 8 characters, at least one number and one letter
    if (strlen($password) < 6 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long and contain both letters and numbers.']);
        exit;
    }

    // Check if the email or name already exists in the database
    try {
        // Check for existing email
        $stmt = $conn->prepare("SELECT id FROM Users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'This email is already registered.']);
            exit;
        }

        // Check for existing username
        $stmt = $conn->prepare("SELECT id FROM Users WHERE name = :name LIMIT 1");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'This username is already taken.']);
            exit;
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO Users (name, email, role, password) VALUES (:name, :email, :role ,:password)");

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User registered successfully.', 'redirect' => '?route=login']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'An error occurred during registration.']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}
?>
