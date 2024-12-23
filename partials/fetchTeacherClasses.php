<?php
// fetch_classes.php
session_start();
include('./../includes/db.php');

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'Teacher') {
    // Database connection (use PDO)
    $database = new Database();
    $conn = $database->getConnection();

    try {
        // Query to fetch all classes created by the logged-in teacher
        $query = "SELECT * FROM classes WHERE teacher_id = :teacher_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':teacher_id', $_SESSION['user_id']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>";
                echo "<a href='?route=class&class_id=" . urlencode($row['id']) . "'>";  
                echo "<strong>Class Name:</strong> " . htmlspecialchars($row['name']) . "<br>";
                echo "<strong>Section:</strong> " . htmlspecialchars($row['section']) . "<br>";
                echo "<strong>Subject:</strong> " . htmlspecialchars($row['subject']);
                echo "</a>";  
                echo "</li>";
            }
        } else {
            echo "No classes created yet.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
