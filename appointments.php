<?php
require 'db_config.php';

// Fetch data
$appointments = $conn->query("SELECT a.id, p.name AS patient, d.name AS doctor, a.date, a.time, a.status FROM appointments a JOIN patients p ON a.patient_id = p.id JOIN doctors d ON a.doctor_id = d.id");
$patients = $conn->query("SELECT id, name FROM patients");
$doctors = $conn->query("SELECT id, name FROM doctors");

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $patient = $_POST['patient_id'];
    $doctor = $_POST['doctor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];

    if (isset($_POST['delete'])) {
        $conn->query("DELETE FROM appointments WHERE id='$id'");
    } elseif ($id) {
        $conn->query("UPDATE appointments SET patient_id='$patient', doctor_id='$doctor', date='$date', time='$time', status='$status' WHERE id='$id'");
    } else {
        $conn->query("INSERT INTO appointments (patient_id, doctor_id, date, time, status) VALUES ('$patient', '$doctor', '$date', '$time', '$status')");
    }
    echo "<script>location.href='';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Appointments</title>
    <style>
    #appointmentForm {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    width: 300px;
    z-index: 1000;
}
td form {
    display: inline;
    margin: 0;
    padding: 0;
}
td form button {
    display: inline;
}</style>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function toggleForm() {
            var form = document.getElementById("appointmentForm");
            form.style.display = (form.style.display === "none" || form.style.display === "") ? "block" : "none";
        }

        function edit(id, patient, doctor, date, time, status) {
            document.getElementById('id').value = id;
            document.querySelector("select[name='patient_id']").value = patient;
            document.querySelector("select[name='doctor_id']").value = doctor;
            document.querySelector("input[name='date']").value = date;
            document.querySelector("input[name='time']").value = time;
            document.querySelector("select[name='status']").value = status;
            document.getElementById("appointmentForm").style.display = "block";
        }
    </script>
</head>
<body>
    <div class="navbar">
        <span id="hname">Hospital Management</span>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="appointments.php">Appointments</a></li>
            <li><a href="doctors.php">Doctors</a></li>
            <li><a href="patients.php">Patients</a></li>
        </ul>
    </div>
    <div class="content">
        <button onclick="toggleForm()">Add Appointment</button>
        <div id="appointmentForm" style="display: none;">
            <form method="POST">
                <input type="hidden" name="id" id="id">
                <select name="patient_id" required><?php while ($p = $patients->fetch_assoc()) echo "<option value='{$p['id']}'>{$p['name']}</option>"; ?></select>
                <select name="doctor_id" required><?php while ($d = $doctors->fetch_assoc()) echo "<option value='{$d['id']}'>{$d['name']}</option>"; ?></select>
                <input type="date" name="date" required>
                <input type="time" name="time" required>
                <select name="status"><option>Scheduled</option><option>Completed</option><option>Canceled</option></select>
                <button type="submit">Save</button>
            </form>
        </div>
        <table>
    <caption>Appointments</caption>
    <tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th><th>Actions</th></tr>
    <?php while ($row = $appointments->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['patient'] ?></td>
            <td><?= $row['doctor'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['time'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <button onclick="edit('<?= $row['id'] ?>', '<?= $row['patient'] ?>', '<?= $row['doctor'] ?>', '<?= $row['date'] ?>', '<?= $row['time'] ?>', '<?= $row['status'] ?>')">Edit</button>
                <a href="delete_appointment.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
    </div>
</body>
</html>
