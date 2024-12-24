<?php
require_once('auth.php'); // Pastikan pengguna sudah login
require_once('db-connect.php'); // Koneksi ke database

// Pastikan ID ada dalam URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$schedule_id = intval($_GET['id']);

// Hapus data berdasarkan ID
$stmt = $conn->prepare("DELETE FROM schedules WHERE id = ?");
$stmt->bind_param('i', $schedule_id);

if ($stmt->execute()) {
    header('Location: view-schedule.php?message=success'); // Redirect ke halaman daftar jadwal
    exit;
} else {
    echo "Gagal menghapus jadwal. Silakan coba lagi.";
    error_log($conn->error); // Log error untuk debugging
}
?>
