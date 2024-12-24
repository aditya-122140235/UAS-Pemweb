<?php 
require_once('auth.php');
require_once('db-connect.php');

// Cek jika ada data POST dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validasi input
    if (empty($email) || empty($password)) {
        $error = "Please fill in all required fields.";
    } else {
        // Query untuk mencari pengguna berdasarkan email
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Simpan data pengguna ke session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['contact'] = $user['contact'] ?? null;
                $_SESSION['msg']['success'] = "You have logged in successfully.";

                // Redirect ke halaman index.php
                header('location: index.php');
                exit;
            } else {
                $error = "Incorrect Email or Password.";
            }
        } else {
            $error = "Incorrect Email or Password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('header.php') ?>
    <style>
        /* Tambahkan gaya untuk pesan error */
        .message-error-box {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <h1 id="page-title" class="text-center">Login Page</h1>
    <hr id="title_hr" class="mx-auto">
    <div id="login-wrapper">
        <div class="text-muted"><small><em>Please fill in all the required fields</em></small></div>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error) && !empty($error)): ?>
            <div class="message-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Tampilkan pesan sukses jika ada -->
        <?php if (isset($_SESSION['msg']['success']) && !empty($_SESSION['msg']['success'])): ?>
        <div class="message-success">
            <?php 
            echo htmlspecialchars($_SESSION['msg']['success']);
            unset($_SESSION['msg']);
            ?>
        </div>  
        <?php endif; ?>

        <!-- Form Login -->
        <form action="" method="POST" novalidate> <!-- Tambahkan 'novalidate' di sini -->
            <div class="input-field">
                <label for="email" class="input-label">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <div class="message-error-box" id="email-error"></div> <!-- Pesan error email -->
            </div>
            <div class="input-field">
                <label for="password" class="input-label">Password</label>
                <input type="password" id="password" name="password">
                <div class="message-error-box" id="password-error"></div> <!-- Pesan error password -->
            </div>
            <button class="login-btn">Login</button>
        </form>

        <div class="text-center">
            <small>Don't have an account? <a href="register.php">Register here</a></small>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');

            form.addEventListener('submit', (e) => {
                // Reset pesan error
                emailError.textContent = '';
                emailError.style.display = 'none';
                passwordError.textContent = '';
                passwordError.style.display = 'none';

                // Validasi input
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                let hasError = false;

                if (!email) {
                    emailError.textContent = 'Email is required.';
                    emailError.style.display = 'block';
                    hasError = true;
                }

                if (!password) {
                    passwordError.textContent = 'Password is required.';
                    passwordError.style.display = 'block';
                    hasError = true;
                }

                if (hasError) {
                    e.preventDefault(); // Hentikan pengiriman form
                }
            });
        });
    </script>
</body>
</html>
