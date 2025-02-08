<?php
require "db_config.php"; // Ensure database connection

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];  // Get the patient id from the URL

    // SQL query to delete the patient record based on the 'id'
    $deleteQuery = "DELETE FROM patients WHERE id = '$id'";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "Patient deleted successfully!";
        // Redirect back to the patient list after deletion
        header("Location: patients.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No patient ID provided.";
    exit;
}
?>