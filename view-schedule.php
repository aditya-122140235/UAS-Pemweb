<?php
require_once('auth.php'); // Pastikan pengguna sudah login
require_once('db-connect.php'); // Koneksi ke database

$stmt = $conn->prepare("SELECT * FROM schedules ORDER BY day_of_week, time_start");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Jadwal</title>
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
    <?php include('sidebar.php'); ?> <!-- Sertakan sidebar -->
    <div class="content">
        <h1>Jadwal Pelajaran</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mata Pelajaran</th>
                    <th>Nama Guru</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['teacher_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['day_of_week']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['time_start']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['time_end']) . "</td>";
                        echo "<td>
                                <a href='edit-schedule.php?id=" . $row['id'] . "'>Edit</a> | 
                                <a href='delete-schedule.php?id=" . $row['id'] . "' onclick=\"return confirm('Yakin ingin menghapus jadwal ini?')\">Hapus</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada jadwal.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
