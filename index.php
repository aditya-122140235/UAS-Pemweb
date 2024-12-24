<?php
require_once('auth.php'); // Pastikan pengguna sudah login
require_once('db-connect.php'); // Koneksi ke database

// Query untuk mendapatkan data dari tabel users
$stmt = $conn->prepare("SELECT id, username, email, contact FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            background-color: #F3F4F6;
        }

        .content h1 {
            font-size: 24px; /* Samakan dengan ukuran teks sidebar */
            color: #333;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="index.php"><span class="material-icons">dashboard</span>Dashboard</a></li>
            <li><a href="profile.php"><span class="material-icons">account_circle</span>Profil</a></li>
            <li><a href="add-schedule.php"><span class="material-icons">schedule</span>Tambah Jadwal</a></li>
            <li><a href="view-schedule.php"><span class="material-icons">event_note</span>Lihat Jadwal</a></li>
            <li><a href="cookies.php"><span class="material-icons">cookie</span>Cookies</a></li>
            <li><a href="logout.php"><span class="material-icons">logout</span>Logout</a></li>
        </ul>
    </aside>

    <div class="content">
        <h1>Daftar Pengguna</h1>
        <!-- Tombol Tambah Pengguna -->
        <button onclick="document.getElementById('addUserModal').style.display='block'" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Tambah Pengguna</button>

        <!-- Modal Form Tambah Pengguna -->
        <div id="addUserModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
            <div style="background-color: white; width: 400px; margin: 100px auto; padding: 20px; border-radius: 10px;">
                <h2>Tambah Pengguna</h2>
                <form action="add.php" method="POST">
                    <label for="username">Nama:</label>
                    <input type="text" name="username" id="username" required style="width: 100%; margin-bottom: 10px;"><br>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required style="width: 100%; margin-bottom: 10px;"><br>
                    <label for="contact">Kontak:</label>
                    <input type="text" name="contact" id="contact" required style="width: 100%; margin-bottom: 10px;"><br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required style="width: 100%; margin-bottom: 10px;"><br>
                    <button type="submit" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Tambah</button>
                    <button type="button" onclick="document.getElementById('addUserModal').style.display='none'" style="background-color: #f44336; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-left: 10px;">Batal</button>
                </form>
            </div>
        </div>

        <!-- Tabel Pengguna -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Kontak</th>
                    <th>Browser</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                        echo "<td>" . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . "</td>"; // Ambil data browser
                        echo "<td>
                                <a href='edit.php?id=" . $row['id'] . "'>Edit</a> | 
                                <a href='delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Yakin ingin menghapus pengguna ini?')\">Hapus</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data pengguna.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
