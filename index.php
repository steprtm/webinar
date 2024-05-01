<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seminar Universitas</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container"> 
        <h1>Seminar Universitas</h1>
        <?php if ($loggedIn): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="register.php">Register</a> | <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</body>
</html>
