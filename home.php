<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header('Location: login.php');
    exit();
}

// Include the database connection file
include 'db.php';

// Fetch seminars from the database
$query = "SELECT * FROM events ORDER BY start_date DESC";
$result = $conn->query($query);
$seminars = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $seminars[] = $row;
    }
} else {
    echo "No seminars found.";
}
$conn->close();

function getCertificateTemplate($seminarName) {
    switch ($seminarName) {
        case 'Teknologi Blockchain':
            return 'sertifikat_blockchain.html';
        case 'Pengembangan Web Modern':
            return 'sertifikat_PWM.html';
        case 'AI dan Machine Learning':
            return 'sertifikat_AI.html';
        case 'Pengolahan Citra':
            return 'sertifikat_PC.html';
        default:
            return '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Seminar Details</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Daftar Seminar</h1>
    <div class="container">
        <?php foreach ($seminars as $event): ?>
        <div class="seminar">
            <h2><?php echo htmlspecialchars($event['name']); ?></h2>
            <p>Tempat: <?php echo htmlspecialchars($event['location']); ?></p>
            <p>Waktu: <?php echo htmlspecialchars($event['start_date']); ?></p>
            <?php if (!empty($event['link'])): ?>
                <p>Link: <a href="<?php echo htmlspecialchars($event['link']); ?>">Join Webinar</a></p>
            <?php endif; ?>
            <div class="form-buttons">
                <form action="register_event.php" method="post" style="display: inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit" name="register">Daftar</button>
                </form>
                <form action="cancel_registration.php" method="post" style="display: inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit" name="cancel">Cancel</button>
                </form>
                <button onclick="openCertificate('<?php echo getCertificateTemplate($event['name']); ?>')">Cetak Sertifikat</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="logout-btn">
        <form action="logout.php" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
    <script>
    function openCertificate(templateUrl) {
        window.open(templateUrl, '_blank');
    }
    </script>
    <?php if (isset($_SESSION['alertMessage'])): ?>
<script>
    alert("<?php echo $_SESSION['alertMessage']; ?>");
    <?php unset($_SESSION['alertMessage']); ?> // Clear the message after displaying it
</script>
<?php endif; ?>
</body>
</html>
