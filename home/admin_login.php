<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    // Cek username, email, dan role 'admin'
    $query = "SELECT * FROM users WHERE username = '$username' AND email = '$email' AND role = 'admin'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {
            $_SESSION['id_user']  = $admin['id_user'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['email']    = $admin['email'];
            $_SESSION['role']     = $admin['role'];

            header("Location: ../akun.php");
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location='admin_login.php';</script>";
        }
    } else {
        echo "<script>alert('Akun tidak ditemukan atau bukan admin!'); window.location='admin_login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow max-w-sm w-full">
    <h2 class="text-xl font-bold mb-4">Login Admin</h2>
    <?php if ($error): ?>
      <div class="text-red-600 text-sm mb-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
   <form action="proses_login.php" method="post" class="w-full">
      <div class="mb-4">
        <label class="block mb-1">Username</label>
        <input type="text" name="username" required class="w-full border rounded px-3 py-2">
      </div>
      <div class="mb-4">
        <label class="block mb-1">Password</label>
        <input type="password" name="password" required class="w-full border rounded px-3 py-2">
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">Login</button>
    </form>
  </div>
</body>
</html>
