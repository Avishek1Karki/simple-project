<?php
require 'db_config.php';  // Include the database configuration file

// Get the doctor ID from the URL
$doctor_id = $_GET['id'];

// Fetch the doctor details from the database
$query = "SELECT * FROM doctors WHERE id = $doctor_id";
$result = $conn->query($query);
$doctor = $result->fetch_assoc();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the updated values from the form
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];

    // Update query to modify doctor details
    $update_query = "UPDATE doctors SET 
                     name = '$name', 
                     specialization = '$specialization', 
                     contact = '$contact' 
                     WHERE id = $doctor_id";

    // Execute the query and check for success
    if ($conn->query($update_query) === TRUE) {
        header("Location: doctors.php");
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<nav class="navbar">
        <ul><li id="hname">Tirvexa Medical</li>
            <li><a href="home.html">Home</a></li>
            <li><a href="patients.php">Patient</a></li>
            <li><a href="doctors.php">Doctor</a></li>
        <li><a href="appointments.php">Appointment</a></li>
        </ul>
    </nav> 

    <div class="content" id="main">

<!-- Edit Doctor Form -->
<form method="POST" action="">
    <h2>Edit Doctor Details</h2>
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo $doctor['name']; ?>" required><br><br>

    <label for="specialization">Specialization:</label>
    <input type="text" name="specialization" value="<?php echo $doctor['specialization']; ?>" required><br><br>

    <label for="contact">Contact:</label>
    <input type="text" name="contact" value="<?php echo $doctor['contact']; ?>" required><br><br>

    <input type="submit" name="submit" value="Update Doctor">
</form>
</div>
</body>
</html>