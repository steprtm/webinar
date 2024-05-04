<?php
$servername = "localhost";  // your server name
$username = "root";         // your database username
$password = "";             // your database password
$dbname = "event";          // your database name

$conn = new mysqli($servername, $username, $password, $dbname); // Create connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Rest of your code...
