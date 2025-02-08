<?php
require 'db_config.php';  // Include the database configuration file

// Get the doctor ID from the URL
if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // Delete query to remove the doctor from the database
    $delete_query = "DELETE FROM doctors WHERE id = $doctor_id";

    // Execute the delete query
    if ($conn->query($delete_query) === TRUE) {
        // Redirect back to the doctors list page after successful deletion
        header("Location: doctors.php");
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
} else {
    echo "<p>No doctor ID provided!</p>";
}
?>
