<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


$seminar = [
    [
        'event_id'=> '1',
        'nama' => 'Teknologi Blockchain',
        'tempat' => 'Auditorium Universitas ABC',
        'waktu' => '26 Maret 2024, 14:00 WIB',
        'link' => '' 
    ],
    [
        'event_id'=> '2',
        'nama' => 'Pengembangan Web Modern',
        'tempat' => 'Online',
        'waktu' => '5 April 2024, 13:00 WIB',
        'link' => 'https://link.com/webinar'
    ],
    [
        'event_id' =>'3',
        'nama' => 'AI dan Machine Learning',
        'tempat' => 'Online',
        'waktu' => '15 Juli 2024, 12:00 WIB',
        'link' => 'https://link.com/webinar'
    ],
    [
        'event_id' => '4',
        'nama' => 'Pengolahan Citra',
        'tempat' => 'Auditorium Universitas ABC',
        'waktu' => '20 Agustus 2024, 10:00 WIB',
        'link' => ''
    ]
];
?>
<?php if (isset($_SESSION['alertMessage'])): ?>
<script>
    alert("<?php echo $_SESSION['alertMessage']; ?>");
</script>
<?php 
    
    unset($_SESSION['alertMessage']); 
?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<script>
function openCertificate(templateUrl) {
    window.open(templateUrl, '_blank'); 
}
<?php
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
</script>

</head>
<body>
    <h1>Daftar Seminar</h1>
    <div id="certificate" style="display:none;">
    <h1>Certificate of Completion</h1>
    <p>This is to certify that <strong>{{name}}</strong> has completed the seminar.</p>
</div>

  <div class="container">
    <?php foreach ($seminar as $event): ?>
        <div class="seminar">
            <h2><?php echo htmlspecialchars($event['nama']); ?></h2>
            <p>Tempat: <?php echo htmlspecialchars($event['tempat']); ?></p>
            <p>Waktu: <?php echo htmlspecialchars($event['waktu']); ?></p>
            <?php if (!empty($event['link'])): ?>
                <p>Link: <a href="<?php echo htmlspecialchars($event['link']); ?>">Join Webinar</a></p>
            <?php endif; ?>
            <div class="form-buttons">
                <form action="register_event.php" method="post" style="margin: 0;">
                    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit" name="register">Daftar</button>
                </form>
                <form action="cancel_registration.php" method="post" style="margin: 0;">
                    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit" name="cancel">Cancel</button>
                </form>
            
            </div>
             <div class="form-buttons">
            <button onclick="openCertificate('<?php echo getCertificateTemplate($event['nama']); ?>')">Cetak Sertifikat</button>
        </div>
        </div>
    <?php endforeach; ?>
</div>

    <div class="logout-btn">
        <form action="logout.php" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
