<?php
// fetch_enrolled_classes.php
session_start();
include('./../includes/db.php');  // Include the database connection

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'Student') {
    // Database connection (use PDO)
    $database = new Database();
    $conn = $database->getConnection();

    try {
        // Query to fetch the classes the student is enrolled in
        $query = "SELECT c.id, c.name, c.section, c.subject
                  FROM Class_Members cm
                  JOIN Classes c ON cm.class_id = c.id
                  WHERE cm.user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();

        // Check if the student is enrolled in any classes
        if ($stmt->rowCount() > 0) {
            // Loop through each class and display the details
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>";
                echo "<a href='?route=class&class_id=" . urlencode($row['id']) . "'>";
                echo "<strong>Class Name:</strong> " . htmlspecialchars($row['name']) . "<br>";
                echo "<strong>Section:</strong> " . htmlspecialchars($row['section']) . "<br>";
                echo "<strong>Subject:</strong> " . htmlspecialchars($row['subject']) . "<br>";
                echo "</a>";
                echo "</li>";
            }
        } else {
            echo "You are not enrolled in any classes yet.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
