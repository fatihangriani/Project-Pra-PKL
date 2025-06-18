<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username ada dan role-nya pelanggan
    $query = "SELECT * FROM users WHERE username = '$username' AND role = 'pelanggan'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Cek password
        if (password_verify($password, $user['password'])) {
            // Simpan info ke session
          $_SESSION['user'] = [
    'id' => $user['id_user'], 
    'username' => $user['username'],
    'email' => $user['email'],
    'role' => $user['role']
];


            echo "<script>alert('Login berhasil!'); window.location='../home/home.php';</script>";
            exit;
        }
    }

    echo "<script>alert('Login gagal! Username atau password salah.'); window.location='login.php';</script>";
    exit;
}
?>
