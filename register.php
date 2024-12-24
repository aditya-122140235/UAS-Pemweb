<?php
ob_start();
require_once('db-connect.php');
require_once('header.php'); // Pastikan header.php tidak memiliki output

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $password = trim($_POST['password']);
    $password_again = trim($_POST['password_again']);

    if (empty($username) || strlen($username) < 3) {
        $error = "Username must be at least 3 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match('/^[0-9]+$/', $contact)) {
        $error = "Contact must contain only numeric values.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif ($password !== $password_again) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, contact, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $contact, $hashed_password);

        if ($stmt->execute()) {
            $success = "Registration successful! Redirecting to login...";
            header("Location: login.php"); // Panggil header sebelum ada output
            exit; // Pastikan script berhenti
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <h1 id="page-title" class="text-center">Register Page</h1>
    <hr id="title_hr" class="mx-auto">
    <div id="register-wrapper">
        <div class="text-muted"><small><em>Please fill all the required fields</em></small></div>
        <form action="" method="POST" id="register-form">
            <div class="input-field">
                <label for="username" class="input-label">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? "") ?>">
                <span class="error-message" id="username-error"></span>
            </div>
            <div class="input-field">
                <label for="email" class="input-label">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? "") ?>">
                <span class="error-message" id="email-error"></span>
            </div>
            <div class="input-field">
                <label for="contact" class="input-label">Contact</label>
                <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($_POST['contact'] ?? "") ?>">
                <span class="error-message" id="contact-error"></span>
            </div>
            <div class="input-field">
                <label for="password" class="input-label">Password</label>
                <input type="password" id="password" name="password">
                <span class="error-message" id="password-error"></span>
            </div>
            <div class="input-field">
                <label for="password_again" class="input-label">Password Again</label>
                <input type="password" id="password_again" name="password_again">
                <span class="error-message" id="password-again-error"></span>
            </div>

            <button class="register-btn" type="submit">Register</button>
        </form>
        <div class="text-center">
            <small>Already have an account? <a href="login.php">Login here</a></small>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("register-form");
            const usernameInput = document.getElementById("username");
            const emailInput = document.getElementById("email");
            const contactInput = document.getElementById("contact");
            const passwordInput = document.getElementById("password");
            const passwordAgainInput = document.getElementById("password_again");

            function clearError(inputId) {
                const errorSpan = document.getElementById(`${inputId}-error`);
                if (errorSpan) {
                    errorSpan.textContent = "";
                }
            }

            function showError(inputId, message) {
                const errorSpan = document.getElementById(`${inputId}-error`);
                if (errorSpan) {
                    errorSpan.textContent = message;
                    errorSpan.style.color = "red";
                }
            }

            form.addEventListener("submit", function (e) {
                let isValid = true;

                clearError("username");
                clearError("email");
                clearError("contact");
                clearError("password");
                clearError("password_again");

                if (usernameInput.value.trim().length < 3) {
                    showError("username", "Username must be at least 3 characters long.");
                    isValid = false;
                }

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailInput.value)) {
                    showError("email", "Please enter a valid email address.");
                    isValid = false;
                }

                const contactPattern = /^[0-9]+$/;
                if (!contactPattern.test(contactInput.value)) {
                    showError("contact", "Contact must contain only numeric values.");
                    isValid = false;
                }

                if (passwordInput.value.length < 6) {
                    showError("password", "Password must be at least 6 characters long.");
                    isValid = false;
                }

                if (passwordInput.value !== passwordAgainInput.value) {
                    showError("password_again", "Passwords do not match.");
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
