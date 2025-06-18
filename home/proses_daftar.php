<?php
session_start();
require 'koneksi.php'; // pastikan koneksi.php sudah terhubung ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nohp     = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);


    // Cek apakah email atau username sudah dipakai
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' OR username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email atau username sudah terdaftar!'); window.location='login.php';</script>";
        exit;
    }

    // Simpan ke database
   $query = "INSERT INTO users (email, username, password, no_hp, alamat, role)
          VALUES ('$email', '$username', '$password', '$nohp', '$alamat', 'pelanggan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Pendaftaran gagal!'); window.location='register.php';</script>";
    }
}
?>
