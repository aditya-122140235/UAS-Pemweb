<?php 
require_once('auth.php');
require_once('db-connect.php');

// Ambil data pengguna dari database berdasarkan sesi user_id
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        // Jika user tidak ditemukan, logout
        header('location: logout.php');
        exit;
    }
} else {
    // Jika sesi tidak valid, redirect ke login
    header('location: login.php');
    exit;
}

// Proses penghapusan akun jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    if ($stmt->execute()) {
        session_destroy(); // Hapus session
        header('location: register.php'); // Redirect ke halaman register setelah akun dihapus
        exit;
    } else {
        $error = "Failed to delete account. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once('header.php') ?>
<body>
  <h1 id="page-title" class="text-center">Home Page</h1>
  <hr id="title_hr" class="mx-auto">
  <div id="profile-wrapper">
    <!-- Tombol Hapus Akun -->
    <form method="POST" style="position: absolute; top: 10px; right: 10px;" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
        <button type="submit" name="delete_account" style="background: none; border: none; cursor: pointer;">
            <i class="fas fa-trash" style="color: #ff4c4c; font-size: 20px;"></i>
        </button>
    </form>

    <!-- Konten Profil -->
    <h2 class="text-center"><strong>Profile</strong></h2>
    <hr width="25px" style="margin: .35em auto">
    <dl>
        <dt><strong>Username:</strong></dt>
        <dd><?= htmlspecialchars($user['username'] ?? "Not provided") ?></dd>
        <dt><strong>Contact:</strong></dt>
        <dd><?= htmlspecialchars($user['contact'] ?? "Not provided") ?></dd>
        <dt><strong>Email:</strong></dt>
        <dd><?= htmlspecialchars($user['email'] ?? "Not provided") ?></dd>
        <dt><strong>Member Since:</strong></dt>
        <dd><?= isset($user['created_at']) ? date('F j, Y', strtotime($user['created_at'])) : "Not provided" ?></dd>
    </dl>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>


</body>
</html>