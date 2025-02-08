<?php
require 'db_config.php'; // Database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete appointment query
    $query = "DELETE FROM appointments WHERE id = '$id'";
    
    if ($conn->query($query) === TRUE) {
        header("Location: appointments.php");
    } else {
        echo "<script>alert('Error deleting appointment: " . $conn->error . "'); window.location='appointments.php';</script>";
    }
} else {
    echo "<script>window.location='appointments.php';</script>";
}
?>