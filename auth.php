<?php
session_start();

// Nonaktifkan caching browser
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); // Waktu kadaluwarsa di masa lalu
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Selalu diperbarui
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Ambil nama file saat ini
$_self = basename($_SERVER["PHP_SELF"]);

// Logika untuk halaman yang memerlukan autentikasi (index.php)
if ($_self === 'index.php') {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] <= 0) {
        header('location: login.php');
        exit;
    }
}

// Logika untuk halaman autentikasi (login, reset-password, forgot-password)
elseif (in_array($_self, ['login.php', 'reset-password.php', 'forgot-password.php'])) {
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
        header('location: index.php');
        exit;
    }
}

// Logika tambahan untuk memastikan halaman tidak diakses setelah logout
if ($_self === 'logout.php') {
    session_unset(); // Hapus semua data sesi
    session_destroy(); // Hancurkan sesi
    header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); // Pastikan halaman kadaluwarsa
    header("Location: login.php");
    exit;
}
?>
