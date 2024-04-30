<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


if (isset($_POST['register'], $_POST['event_id'])) {
    $userId = $_SESSION['user_id'];
    $eventId = $_POST['event_id'];

    
    $query = "SELECT * FROM event_registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        
        $insertQuery = "INSERT INTO event_registrations (user_id, event_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $userId, $eventId);
        $insertStmt->execute();

        if ($insertStmt->affected_rows > 0) {
            // Pendaftaran berhasil
            $_SESSION['alertMessage'] = "Pendaftaran berhasil!";
        } else {
            // Pendaftaran gagal
            $_SESSION['alertMessage'] = "Pendaftaran gagal.";
        }
        $insertStmt->close();
    } else {
       
        $_SESSION['alertMessage'] = "Anda sudah terdaftar di event ini.";
    }
    $stmt->close();
    header('Location: home.php');
    exit();
} else {
  
    $_SESSION['alertMessage'] = "Permintaan tidak valid.";
    header('Location: home.php');
    exit();
}

