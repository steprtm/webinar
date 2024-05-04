<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'db.php';  // Ensure your DB connection settings are correct

// Check if an edit form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    $stmt = $conn->prepare("UPDATE events SET name=?, start_date=?, end_date=?, location=?, capacity=? WHERE event_id=?");
    $stmt->bind_param("ssssii", $name, $start_date, $end_date, $location, $capacity, $event_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo "<p>Webinar updated successfully.</p>";
    } else {
        echo "<p>Error updating webinar: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

$result = $conn->query("SELECT event_id, name FROM events ORDER BY start_date DESC");
$webinars = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Edit Webinar</h2>
    <form action="edit_webinar.php" method="post">
       <label for="webinar_select">Ubah Detail Seminar:</label>
    <select name="event_id" id="webinar_select" onchange="this.form.submit()">
        <?php foreach ($webinars as $webinar): ?>
            <option value="<?= $webinar['event_id']; ?>"
                <?php if (isset($_POST['event_id']) && $_POST['event_id'] == $webinar['event_id']) echo 'selected'; ?>>
                <?= htmlspecialchars($webinar['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    </form>

    <?php

    // Check if a webinar is selected either through POST or you need to persist the selection
$selectedEventId = isset($_POST['event_id']) ? $_POST['event_id'] : (isset($webinars[0]) ? $webinars[0]['event_id'] : null);

if ($selectedEventId !== null) {
  $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $selectedEventId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($webinar = $result->fetch_assoc()) {
        // Display the form here
?>
        <form action="edit_webinar.php" method="post">
            <input type="hidden" name="event_id" value="<?= $webinar['event_id']; ?>">
            <label for="name">Webinar Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($webinar['name']); ?>" required>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?= $webinar['start_date']; ?>" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?= $webinar['end_date']; ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($webinar['location']); ?>" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" value="<?= $webinar['capacity']; ?>" required>

            <input type="submit" name="update" value="Update Webinar">
        </form>
<?php
    }
}
    ?>


<button onclick="window.location.href='admin_dashboard.php';" class="button">Back to Admin Dashboard</button>

<style>
        
body {
  background-color: #242424; 
  margin: 0;
  font-family: Arial, sans-serif;
  color: white;
  height: 100vh; 
  display: flex;
  flex-direction: column;
  justify-content: center; 
  align-items: center;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

.container {
  width: 100%;
  max-width: 600px;
  text-align: center; 
}

.button {
  background-color: #006eff;
  color: white;
  padding: 10px 20px;
  margin: 10px; 
  border: none;
  border-radius: 5px; 
  cursor: pointer; 
  font-size: 16px;
  text-align: center;
  display: inline-block; 
  text-decoration: none;
}

.button:hover {
  background-color: #0056b3;
}

.logout-btn {
  position: absolute;
  bottom: 20px; 
  right: 20px;
}

@media screen and (max-width: 600px) {
  .button {
    width: 90%;
    padding: 12px 0;
  }
}
 .button {
        background-color: #006eff; /* Blue background color */
        color: white; /* Text color */
        padding: 10px 20px; /* Padding around the text */
        margin: 10px; /* Space around the button */
        border: none; /* No border */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        font-size: 16px; /* Font size */
        text-decoration: none; /* No underline */
        display: inline-block; /* Allow placement next to other elements */
        
    }
</style>
</body>
</html>
