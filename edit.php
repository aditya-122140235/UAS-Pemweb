<?php
require_once('auth.php');
require_once('db-connect.php');

$id = $_GET['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, contact = ? WHERE id = ?");
    $stmt->bind_param('sssi', $username, $email, $contact, $id);
    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Gagal memperbarui data pengguna.";
    }
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
</head>
<body>
    <h1>Edit Pengguna</h1>
    <form action="edit.php?id=<?= $id ?>" method="POST">
        <label for="username">Nama:</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
        <label for="contact">Kontak:</label>
        <input type="text" name="contact" id="contact" value="<?= htmlspecialchars($user['contact']) ?>" required><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
