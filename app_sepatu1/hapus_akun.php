<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

$id_user = $_GET['id_user'];

// Cek apakah user punya transaksi
$cek = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_user = '$id_user'");
if (mysqli_num_rows($cek) > 0) {
    // Redirect dengan pesan gagal
    header("Location: pelanggan.php?hapus=gagal_user_punya_transaksi");
    exit();
}

// Jika tidak ada transaksi, hapus user
mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id_user'");
header("Location: akun.php?hapus=sukses");
?>
