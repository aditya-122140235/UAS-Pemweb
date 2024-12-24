<?php
require_once('auth.php'); // Pastikan pengguna sudah login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Cookie dan Browser Storage</title>
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

        form input, form button {
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

        .storage-display {
            margin-top: 20px;
            background: #e9ecef;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include('sidebar.php'); ?> <!-- Sertakan sidebar -->
    <div class="content">
        <h1>Kelola Cookie dan Browser Storage</h1>

        <!-- Form untuk Cookie -->
        <form id="cookieForm">
            <label for="cookieInput">Masukkan Nilai Cookie:</label>
            <input type="text" id="cookieInput" placeholder="Masukkan nilai..." required>
            <button type="button" id="setCookie">Set Cookie</button>
            <button type="button" id="deleteCookie">Hapus Cookie</button>
        </form>
        <div class="storage-display">
            <strong>Nilai Cookie:</strong>
            <span id="cookieDisplay">Belum ada nilai</span>
        </div>

        <!-- Form untuk LocalStorage -->
        <form id="localStorageForm">
            <label for="localStorageInput">Masukkan Nilai LocalStorage:</label>
            <input type="text" id="localStorageInput" placeholder="Masukkan nilai..." required>
            <button type="button" id="setLocalStorage">Set LocalStorage</button>
            <button type="button" id="deleteLocalStorage">Hapus LocalStorage</button>
        </form>
        <div class="storage-display">
            <strong>Nilai LocalStorage:</strong>
            <span id="localStorageDisplay">Belum ada nilai</span>
        </div>

        <!-- Form untuk SessionStorage -->
        <form id="sessionStorageForm">
            <label for="sessionStorageInput">Masukkan Nilai SessionStorage:</label>
            <input type="text" id="sessionStorageInput" placeholder="Masukkan nilai..." required>
            <button type="button" id="setSessionStorage">Set SessionStorage</button>
            <button type="button" id="deleteSessionStorage">Hapus SessionStorage</button>
        </form>
        <div class="storage-display">
            <strong>Nilai SessionStorage:</strong>
            <span id="sessionStorageDisplay">Belum ada nilai</span>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cookieInput = document.getElementById("cookieInput");
            const localStorageInput = document.getElementById("localStorageInput");
            const sessionStorageInput = document.getElementById("sessionStorageInput");

            const cookieDisplay = document.getElementById("cookieDisplay");
            const localStorageDisplay = document.getElementById("localStorageDisplay");
            const sessionStorageDisplay = document.getElementById("sessionStorageDisplay");

            function updateDisplays() {
                const cookies = document.cookie.split("; ").reduce((acc, cookie) => {
                    const [key, value] = cookie.split("=");
                    acc[key] = value;
                    return acc;
                }, {});
                cookieDisplay.textContent = cookies.cookie || "Belum ada nilai";
                localStorageDisplay.textContent = localStorage.getItem("localStorage") || "Belum ada nilai";
                sessionStorageDisplay.textContent = sessionStorage.getItem("sessionStorage") || "Belum ada nilai";
            }

            document.getElementById("setCookie").addEventListener("click", () => {
                const value = cookieInput.value.trim();
                if (!value) {
                    alert("Masukkan nilai terlebih dahulu!");
                    return;
                }
                document.cookie = `cookie=${value}; path=/; max-age=3600`;
                updateDisplays();
            });

            document.getElementById("deleteCookie").addEventListener("click", () => {
                document.cookie = "cookie=; path=/; max-age=0";
                updateDisplays();
            });

            document.getElementById("setLocalStorage").addEventListener("click", () => {
                const value = localStorageInput.value.trim();
                if (!value) {
                    alert("Masukkan nilai terlebih dahulu!");
                    return;
                }
                localStorage.setItem("localStorage", value);
                updateDisplays();
            });

            document.getElementById("deleteLocalStorage").addEventListener("click", () => {
                localStorage.removeItem("localStorage");
                updateDisplays();
            });

            document.getElementById("setSessionStorage").addEventListener("click", () => {
                const value = sessionStorageInput.value.trim();
                if (!value) {
                    alert("Masukkan nilai terlebih dahulu!");
                    return;
                }
                sessionStorage.setItem("sessionStorage", value);
                updateDisplays();
            });

            document.getElementById("deleteSessionStorage").addEventListener("click", () => {
                sessionStorage.removeItem("sessionStorage");
                updateDisplays();
            });

            updateDisplays();
        });
    </script>
</body>
</html>
