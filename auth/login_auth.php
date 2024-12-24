<?php
// Start output buffering
ob_start();
session_start();
// Include database connection
include('./../includes/db.php'); 

// Create a new database instance
$database = new Database();
$conn = $database->getConnection();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT id, password, role, remember_token FROM Users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Check if a user was found
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                
                if (isset($_POST['remember_me'])) {
                    // Generate a unique token
                    $token = bin2hex(random_bytes(16));

                    // Store the token in the database
                    $updateStmt = $conn->prepare("UPDATE Users SET remember_token = :token WHERE id = :id");
                    $updateStmt->bindParam(':token', $token);
                    $updateStmt->bindParam(':id', $user['id']);
                    $updateStmt->execute();

                    // Set cookies to remember the user for 30 days
                    setcookie("user_email", $email, time() + (30 * 24 * 60 * 60), "/");
                    setcookie("remember_token", $token, time() + (30 * 24 * 60 * 60), "/");
                } else {
                    // If not checked, clear cookies and token
                    setcookie("user_email", "", time() - 3600, "/");
                    setcookie("remember_token", "", time() - 3600, "/");
                    
                    // Clear the remember token in the database
                    $updateStmt = $conn->prepare("UPDATE Users SET remember_token = NULL WHERE id = :id");
                    $updateStmt->bindParam(':id', $user['id']);
                    $updateStmt->execute();
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'] ?? 'yes';

                // Respond with a success status and redirect URL
                echo json_encode(['success' => true, 'message' => 'Login successful.', 'redirect' => '?route=room']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid password.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No user found with that email.']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}

// Flush output buffer
ob_end_flush();
?>
