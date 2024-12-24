<?php
require_once 'db.php';

$database = new Database();
$conn = $database->getConnection();

if ($conn) {
   // echo "Database connection established!";
} else {
    echo "Failed to connect to the database.";
}
?>
