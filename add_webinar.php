<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit('Access Denied: You do not have permission to perform this action.');
}

include 'db.php';  // Make sure your database connection details are correct

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $location = $_POST['location'];
    $capacity = (int) $_POST['capacity'];

    $query = "INSERT INTO events (name, start_date, end_date, location, capacity) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("ssssi", $name, $start_date, $end_date, $location, $capacity);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "<p>Webinar added successfully!</p>";
        } else {
            echo "<p>Error adding webinar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Error preparing statement: " . $conn->error . "</p>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/add_webinar.css">
    
</head>
<body>
    <div class="container">
        <h2>Tambah Seminar Baru</h2>
        <form action="add_webinar.php" method="post">
            <label for="name">Nama Seminar:</label>
            <input type="text" id="name" name="name" required>

            <label for="start_date">Tanggal Mulai:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">Tanggal Selesai:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="location">Tempat:</label>
            <input type="text" id="location" name="location" required>

            <label for="capacity">Kapasitas:</label>
            <input type="number" id="capacity" name="capacity" required>

            <input type="submit" value="Add Webinar">
        </form>
    </div>
</body>
</html>
