<?php
require "db_config.php";  // Ensure database connection

// Insert a new doctor if the form is submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];

    // Insert query for adding a doctor into the database
    $query = "INSERT INTO doctors (name, specialization, contact) 
              VALUES ('$name', '$specialization', '$contact')";

    if ($conn->query($query) === TRUE) {
        echo "Doctor added successfully!";
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
    <title>Manage Doctors</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function toggleForm() {
            var form = document.getElementById("doctorForm");
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
    <button onclick="toggleForm()">Add Doctor</button>

    <!-- Doctor form -->
    <div id="doctorForm" style="display: none;">
        <form method="POST">
        <h2>Doctor Form</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="specialization">Specialization:</label>
            <input type="text" id="specialization" name="specialization" required><br><br>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required><br><br>

            <input type="submit" name="submit" value="Add Doctor">
        </form>
    </div>

    <table border="1">
        <caption>Doctors Table</caption>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Contact</th>
            <th>Action</th>
        </tr>

        <?php
        // Fetch and display doctors from the database
        $result = $conn->query("SELECT * FROM doctors");

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['specialization']}</td>
                <td>{$row['contact']}</td>
                <td>
                    <a href='edit_doctor.php?id={$row['id']}'>Edit</a> | 
                    <a href='delete_doctor.php?id={$row['id']}'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</div>

</body>
</html