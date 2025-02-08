<?php
require "db_config.php"; // Ensure database connection

// Check if 'id' is set in the URL (it will be passed from the patient list)
if (isset($_GET['id'])) {
    $id = $_GET['id'];  // Get the patient id from the URL
    
    // Query to get the patient's details based on the 'id'
    $result = $conn->query("SELECT * FROM patients WHERE id = '$id'");
    
    if ($result->num_rows > 0) {
        // Fetch the patient's data
        $row = $result->fetch_assoc();
    } else {
        echo "No patient found with that ID.";
        exit;
    }
} else {
    echo "No patient ID provided.";
    exit;
}

// Update the patient's data if the form is submitted
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $disease = $_POST['disease'];
    $contact = $_POST['contact'];

    // SQL query to update the patient's record
    $updateQuery = "UPDATE patients SET name='$name', age='$age', gender='$gender', disease='$disease', contact='$contact' WHERE id='$id'";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "Patient details updated successfully!";
        // Redirect back to the patient list after successful update
        header("Location: patients.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<nav class="navbar">
        <ul><li id="hname">Tirvexa Medical</li>
            <li><a href="index.html">Home</a></li>
            <li><a href="patients.php">Patient</a></li>
            <li><a href="doctors.php">Doctor</a></li>
        <li><a href="appointments.php">Appointment</a></li>
        </ul>
    </nav> 
    <div class="content" id="main">
    <form method="POST">
    <h2>Edit Patient Details</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $row['age']; ?>" required><br><br>

        <label>Gender:</label><br>
        <input type="radio" name="gender" value="male" <?php if ($row['gender'] == 'male') echo "checked"; ?>> Male
        <input type="radio" name="gender" value="female" <?php if ($row['gender'] == 'female') echo "checked"; ?>> Female
        <br><br>

        <label for="disease">Disease:</label>
        <input type="text" id="disease" name="disease" value="<?php echo $row['disease']; ?>"><br><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo $row['contact']; ?>" required><br><br>

        <input type="submit" name="update" value="Update Patient">
    </form>
</div>
</body>
</html>