<?php
session_start();
include('./../includes/db.php');


// Create a new database instance
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect the form data
    $studentID = $_SESSION['user_id'];  // Get the logged-in user's ID
    $classCode = $_POST['classCode'];  // The class code entered by the student

    // Check if the class code is empty
    if (empty($classCode)) {
        echo json_encode(["status" => "error", "message" => "Class code is required."]);
        exit;
    }

    try {
        // Check if the class code exists in the database
        $query = "SELECT * FROM Classes WHERE class_code = :classCode";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':classCode', $classCode);
        $stmt->execute();

        // If the class code is valid
        if ($stmt->rowCount() > 0) {
            $class = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the student is already enrolled
            $checkEnrollmentQuery = "SELECT * FROM Class_Members WHERE class_id = :class_id AND user_id = :user_id";
            $checkStmt = $conn->prepare($checkEnrollmentQuery);
            $checkStmt->bindParam(':class_id', $class['id']);
            $checkStmt->bindParam(':user_id', $studentID);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                echo json_encode(["status" => "error", "message" => "You are already enrolled in this class."]);
            } else {
                // Enroll the student into the class (set role as 'Student')
                $enrollQuery = "INSERT INTO Class_Members (class_id, user_id, role) VALUES (:class_id, :user_id, 'Student')";
                $enrollStmt = $conn->prepare($enrollQuery);
                $enrollStmt->bindParam(':class_id', $class['id']);
                $enrollStmt->bindParam(':user_id', $studentID);

                if ($enrollStmt->execute()) {
                    echo json_encode(["status" => "success", "message" => "You have successfully joined the class!"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Unable to join the class. Please try again."]);
                }
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid class code."]);
        }
    } catch (PDOException $exception) {
        echo json_encode(["status" => "error", "message" => "Error: " . $exception->getMessage()]);
    }
}
?>
