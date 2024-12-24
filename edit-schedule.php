<?php
require_once('auth.php'); // Pastikan pengguna sudah login
require_once('db-connect.php'); // Koneksi ke database

// Cek apakah ID ada dalam URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$schedule_id = intval($_GET['id']);

// Ambil data jadwal berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM schedules WHERE id = ?");
$stmt->bind_param('i', $schedule_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Jadwal tidak ditemukan!");
}

$schedule = $result->fetch_assoc();

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_name = $_POST['subject_name'];
    $teacher_name = $_POST['teacher_name'];
    $day_of_week = $_POST['day_of_week'];
    $time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];

    $update_stmt = $conn->prepare("UPDATE schedules SET subject_name = ?, teacher_name = ?, day_of_week = ?, time_start = ?, time_end = ? WHERE id = ?");
    $update_stmt->bind_param('sssssi', $subject_name, $teacher_name, $day_of_week, $time_start, $time_end, $schedule_id);

    if ($update_stmt->execute()) {
        $success_message = "Jadwal berhasil diperbarui!";
    } else {
        $error_message = "Gagal memperbarui jadwal.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        background-color: #F3F4F6;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 200px;
        height: 100%;
        background-color: #CBD5E0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .sidebar .logo img {
        width: 80px;
        margin-bottom: 15px;
        border-radius: 50%;
    }

    .sidebar h2 {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        width: 100%;
    }

    .sidebar ul li {
        margin: 15px 0;
    }

    .sidebar ul li a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .sidebar ul li a:hover {
        background-color: #A0AEC0;
    }

    .sidebar ul li a span {
        margin-right: 10px;
    }

    .content {
        margin-left: 220px;
        padding: 20px;
        width: calc(100% - 220px);
    }

    .content h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    form label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    form input, form select, form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    form button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    form button:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        margin-top: 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #e1f5fe;
    }

    .action-buttons a {
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 5px;
        color: white;
        font-size: 12px;
        margin-right: 5px;
    }

    .action-buttons a.edit {
        background-color: #007bff;
    }

    .action-buttons a.delete {
        background-color: #dc3545;
    }

    .action-buttons a:hover {
        opacity: 0.8;
    }
</style>
</head>
<body>
<?php include('sidebar.php'); ?>
<div class="content">
    <h1>Edit Jadwal Pelajaran</h1>
    <?php if (isset($success_message)) echo "<p style='color: green;'>$success_message</p>"; ?>
    <?php if (isset($error_message)) echo "<p style='color: red;'>$error_message</p>"; ?>
    <form method="POST">
        <label>Mata Pelajaran:</label>
        <input type="text" name="subject_name" value="<?= htmlspecialchars($schedule['subject_name']); ?>" required><br>

        <label>Nama Guru:</label>
        <input type="text" name="teacher_name" value="<?= htmlspecialchars($schedule['teacher_name']); ?>" required><br>

        <label>Hari:</label>
        <select name="day_of_week" required>
            <option value="Senin" <?= $schedule['day_of_week'] === 'Senin' ? 'selected' : ''; ?>>Senin</option>
            <option value="Selasa" <?= $schedule['day_of_week'] === 'Selasa' ? 'selected' : ''; ?>>Selasa</option>
            <option value="Rabu" <?= $schedule['day_of_week'] === 'Rabu' ? 'selected' : ''; ?>>Rabu</option>
            <option value="Kamis" <?= $schedule['day_of_week'] === 'Kamis' ? 'selected' : ''; ?>>Kamis</option>
            <option value="Jumat" <?= $schedule['day_of_week'] === 'Jumat' ? 'selected' : ''; ?>>Jumat</option>
        </select><br>

        <label>Jam Mulai:</label>
        <input type="time" name="time_start" value="<?= htmlspecialchars($schedule['time_start']); ?>" required><br>

        <label>Jam Selesai:</label>
        <input type="time" name="time_end" value="<?= htmlspecialchars($schedule['time_end']); ?>" required><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
