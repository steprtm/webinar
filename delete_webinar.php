<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Database connection

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $event_id = $_POST['event_id'];

    if ($event_id) {
        $stmt = $conn->prepare("DELETE FROM events WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p>Webinar deleted successfully.</p>";
        } else {
            echo "<p>Error deleting webinar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Fetch all webinars for the dropdown
$result = $conn->query("SELECT event_id, name FROM events ORDER BY start_date DESC");
$webinars = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus Seminar</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
<div class="container"> <!-- Container to center the content -->
    <h2>Hapus Seminar</h2>
    <form action="delete_webinar.php" method="post">
        <label for="webinar_select">Select Webinar to Delete:</label>
        <select name="event_id" id="webinar_select">
            <?php foreach ($webinars as $webinar): ?>
                <option value="<?= $webinar['event_id']; ?>"><?= htmlspecialchars($webinar['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input type="submit" name="delete" value="Delete Webinar" class="button">
    </form>

    <?php if (isset($_POST['delete'])): ?>
        <form action="delete_webinar.php" method="post">
            <input type="hidden" name="event_id" value="<?= $_POST['event_id']; ?>">
            <p>Konfirmasi Penghapusan</p>
            <input type="submit" name="confirm_delete" value="Konfirmasi" class="button">
        </form>
    <?php endif; ?>

    <button onclick="window.location.href='admin_dashboard.php';" class="button">Back to Admin Dashboard</button>
</div>

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

.container {
    width: auto;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
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
}

.button:hover {
    background-color: #0056b3;
}
</style>
</body>
</html>
