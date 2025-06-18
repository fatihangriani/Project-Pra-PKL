<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

$id_transaksi = $_GET['id_transaksi'];

// Hapus dulu dari detail_transaksi dan pembayaran
mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'");
mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_transaksi = '$id_transaksi'");

// Baru hapus dari transaksi
mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

header("Location: pesanan.php?hapus=sukses");
?>
