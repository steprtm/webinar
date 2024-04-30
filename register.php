<?php
$host = "localhost"; 
$dbname = "event";
$username = "root";
$password = ""; 

try {
    $conn = new PDO("mysql:host=localhost;dbname=event", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

$registered = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $password = $_POST['password'];

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, phone, address, city, state, zip_code, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $email, $phone, $address, $city, $state, $zip_code, $passwordHash]);

    $registered = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
<h2>Registrasi</h2>
    <?php if ($registered): ?>
        <p>User registered successfully. You can now <a href="login.php">login</a>.</p>
    <?php else: ?>
    <form method="post" action="register.php">
    <label for="name">Nama:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="phone">No. HP:</label><br>
        <input type="text" id="phone" name="phone"><br>
        <label for="address">Alamat:</label><br>
        <input type="text" id="address" name="address"><br>
        <label for="city">Kota:</label><br>
        <input type="text" id="city" name="city"><br>
        <label for="state">Provinsi:</label><br>
        <input type="text" id="state" name="state"><br>
        <label for="zip_code">Kode Pos:</label><br>
        <input type="text" id="zip_code" name="zip_code"><br><br>
        <input type="submit" value="Register">
    </form>
    <?php endif; ?>
</body>
</html>