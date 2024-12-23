<?php
     include('./../includes/db.php'); 

    // Create a new database instance
    $database = new Database();
    $conn = $database->getConnection();

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Basic validation
        if (empty($name) || empty($email) || empty($password)) {
            echo 'Please fill in all fields and select a valid role.';
            exit;
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the insert statement
        try {
            $stmt = $conn->prepare("INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)");

            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                echo 'User registered successfully.';
            } else {
                echo 'An error occurred during registration.';
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }
?>
