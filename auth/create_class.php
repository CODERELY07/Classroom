<?php
session_start();
include('./../includes/db.php');

// Create a new database instance
$database = new Database();
$conn = $database->getConnection();

// Check if data is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect the form data
    $teacherID = $_SESSION['user_id'];
    $className = $_POST['className'];
    $section = $_POST['section'];
    $subject = $_POST['subject'];

    // Check if any field is empty
    if (empty($className) || empty($section) || empty($subject)) {
        echo "All fields are required.";
        exit;
    }

    // Generate a unique class code
    $classCode = strtoupper(bin2hex(random_bytes(4))); // Generates a random 8-character hex code

    try {
        // Prepare the INSERT query
        $query = "INSERT INTO classes (name, section, subject, teacher_id, class_code) VALUES (:className, :section, :subject, :teacher_id, :classCode)";
        
        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':className', $className);
        $stmt->bindParam(':section', $section);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':teacher_id', $teacherID);
        $stmt->bindParam(':classCode', $classCode);

        // Execute the query
        if ($stmt->execute()) {
            echo "Class created successfully! Class code: " . $classCode;
        } else {
            echo "Error: Unable to create the class.";
        }
    } catch (PDOException $exception) {
        echo "Error: " . $exception->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
