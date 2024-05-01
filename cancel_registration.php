<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['cancel'], $_POST['event_id'])) {
    $userId = $_SESSION['user_id'];
    $eventId = $_POST['event_id'];

    // Hapus pendaftaran pengguna dari event ini
    $deleteQuery = "DELETE FROM event_registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $userId, $eventId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['alertMessage'] = "Pendaftaran event berhasil dibatalkan.";
    } else {
        $_SESSION['alertMessage'] = "Gagal membatalkan pendaftaran event atau Anda belum terdaftar.";
    }
    $stmt->close();
    header('Location: home.php');
    exit();
} else {
    // Data POST tidak valid
    $_SESSION['alertMessage'] = "Permintaan tidak valid.";
    header('Location: home.php');
    exit();
}
