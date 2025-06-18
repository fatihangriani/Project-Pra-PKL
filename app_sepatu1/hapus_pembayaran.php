<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

if (isset($_GET['id'])) {
    $id_pembayaran = $_GET['id']; // ← Perbaikan di sini

    $query = "DELETE FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data pembayaran berhasil dihapus.'); window.location.href='pembayaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.'); window.location.href='pembayaran.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='pembayaran.php';</script>";
}
?>
