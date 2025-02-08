<?php
require "db_config.php"; // Ensure database connection

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $disease = $_POST['disease'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO patients (name, age, gender, disease, contact) 
            VALUES ('$name', '$age', '$gender', '$disease', '$contact')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Patient added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function toggleForm() {
            var form = document.getElementById("patientForm");
            form.style.display = (form.style.display === "none") ? "block" : "none";
        }
    </script>
</head>
<body>
<nav class="navbar">
        <ul>
            <li id="hname">Tirvexa Medical</li>
            <li><a href="index.html">Home</a></li>
            <li><a href="patients.php">Patient</a></li>
            <li><a href="doctors.php">Doctor</a></li>
        <li><a href="appointments.php">Appointment</a></li>
        </ul>
    </nav>
    <div class="content" id="main">
    <button onclick="toggleForm()">Add Patient</button>

    <!-- Patient form -->
    <div id="patientForm" style="display: none;">
        <form method="POST">
        <h2>Patient Form</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required><br><br>

            <div class="gender-container">
    <label>Gender:</label>
    <input type="radio" name="gender" value="male" required> Male
    <input type="radio" name="gender" value="female" required> Female
            </div>

            <label for="disease">Disease:</label>
            <input type="text" id="disease" name="disease"><br><br>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required><br><br>

            <input type="submit" name="submit" value="Add Patient">
        </form>
    </div>

    <table border="1">
        <caption>Patients Table</caption>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Disease</th>
            <th>Contact</th>
            <th>Action</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM patients");

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['age']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['disease']}</td>
                <td>{$row['contact']}</td>
                <td>
                    <a href='edit_patient.php?id={$row['id']}'>Edit</a> | 
                    <a href='delete_patient.php?id={$row['id']}'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>