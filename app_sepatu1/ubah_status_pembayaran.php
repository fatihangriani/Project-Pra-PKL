<?php
session_start();
include '../home/koneksi.php';

if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

$id_pembayaran = $_POST['id'] ?? '';
$status_baru = $_POST['status'] ?? '';

// Validasi input
if (!$id_pembayaran || !in_array($status_baru, ['lunas', 'ditolak'])) {
    echo "<script>alert('Permintaan tidak valid.'); window.location='pembayaran.php';</script>";
    exit;
}

// Update status_pembayaran di tabel pembayaran
$query = "UPDATE pembayaran SET status_pembayaran = '$status_baru' WHERE id_pembayaran = '$id_pembayaran'";
if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Status pembayaran berhasil diubah menjadi $status_baru.'); window.location='pembayaran.php';</script>";
} else {
    echo "<script>alert('Gagal mengubah status pembayaran.'); window.location='pembayaran.php';</script>";
}
?>
