<?php
require_once('auth.php');
require_once('db-connect.php');

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    header('Location: index.php');
    exit;
} else {
    echo "Gagal menghapus data pengguna.";
}
?>
