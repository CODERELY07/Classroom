<?php
// Include your database connection here
// require 'path_to_your_db_connection_file.php';

if (isset($_GET['class_id'])) {
    // Capture the class_id from the URL
    $classID = $_GET['class_id'];

    // Prepare the query to fetch class details
    $query = "SELECT c.name, c.section, c.subject, cm.role
              FROM Class_Members cm
              JOIN Classes c ON cm.class_id = c.id
              WHERE c.id = :class_id";
    
    // Prepare and execute the statement
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':class_id', $classID, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the class details
    $classDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($classDetails) {
        echo "<h2>Class Details:</h2>";
        echo "<strong>Class Name:</strong> " . htmlspecialchars($classDetails['name']) . "<br>";
        echo "<strong>Section:</strong> " . htmlspecialchars($classDetails['section']) . "<br>";
        echo "<strong>Subject:</strong> " . htmlspecialchars($classDetails['subject']) . "<br>";
    } else {
        echo "<p>Class not found.</p>";
    }
} else {
    echo "<p>No class selected.</p>";
}
?>
