<?php
require_once('auth.php');
require_once('db-connect.php');
?>

<script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
