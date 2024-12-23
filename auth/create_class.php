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
    $className = trim($_POST['className']);
    $section = trim($_POST['section']);
    $subject = trim($_POST['subject']);

    // Check if any field is empty
    if (empty($className) || empty($section) || empty($subject)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    // Generate a unique class code
    $classCode = strtoupper(bin2hex(random_bytes(4))); // Generates a random 8-character hex code

    try {
        // Prepare the INSERT query for the class
        $query = "INSERT INTO classes (name, section, subject, teacher_id, class_code) 
                  VALUES (:className, :section, :subject, :teacher_id, :classCode)";

        $stmt = $conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':className', $className);
        $stmt->bindParam(':section', $section);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':teacher_id', $teacherID);
        $stmt->bindParam(':classCode', $classCode);

        // Execute the query
        if ($stmt->execute()) {
            $classID = $conn->lastInsertId();

            // Enroll the teacher into the class as "Teacher"
            $enrollQuery = "INSERT INTO Class_Members (class_id, user_id, role) 
                            VALUES (:class_id, :user_id, 'Teacher')";
            $enrollStmt = $conn->prepare($enrollQuery);
            $enrollStmt->bindParam(':class_id', $classID);
            $enrollStmt->bindParam(':user_id', $teacherID);

            if ($enrollStmt->execute()) {
                echo json_encode([
                    "success" => true,
                    "message" => "Class created successfully! Class code: " . $classCode,
                    "redirect" => "?route=class&class_id=" . $classID
                ]);
            } else {
                echo json_encode(["success" => false, "message" => "Class created, but failed to enroll the teacher."]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: Unable to create the class.']);
        }
    } catch (PDOException $exception) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $exception->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
