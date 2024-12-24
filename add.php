<?php
require_once('auth.php');
require_once('db-connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, contact, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $username, $email, $contact, $password);
    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        echo "Gagal menambahkan pengguna.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
</head>
<body>
    <h1>Tambah Pengguna Baru</h1>
    <form action="add.php" method="POST">
        <label for="username">Nama:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="contact">Kontak:</label>
        <input type="text" name="contact" id="contact" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Tambah</button>
    </form>
</body>
</html>
