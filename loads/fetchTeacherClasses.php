<?php
// fetch_classes.php
session_start();
include('./../includes/db.php');

// Check if the user is logged in and has the role 'Teacher'
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'Teacher') {
    // Database connection (use PDO)
    $database = new Database();
    $conn = $database->getConnection();

    try {
        // Query to fetch all classes created by the logged-in teacher
        $query = "SELECT * FROM classes WHERE teacher_id = :teacher_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':teacher_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        // Check if the teacher has created any classes
        if ($stmt->rowCount() > 0) {
            // Loop through each class and fetch student count
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Query to count the number of students in the current class
                $studentCountQuery = "SELECT COUNT(*) AS student_count FROM class_members WHERE class_id = :class_id AND role = 'Student'";
                $studentStmt = $conn->prepare($studentCountQuery);
                $studentStmt->bindParam(':class_id', $row['id'], PDO::PARAM_INT);
                $studentStmt->execute();
                $studentCountResult = $studentStmt->fetch(PDO::FETCH_ASSOC);
                $studentCount = $studentCountResult['student_count'] ?? 0; // Default to 0 if no students

                // Display the class and student count
                echo "<a href='?route=class&class_id=" . urlencode($row['id']) . "'>";
                echo htmlspecialchars($row['name']) . " (Students: " . $studentCount . ")<br>";
                echo "</a>";
            }
        } else {
            echo "No classes created yet.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} 
?>
