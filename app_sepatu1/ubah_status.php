<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $status = $_POST['status'];

    $query = "UPDATE transaksi SET status = '$status' WHERE id_transaksi = '$id_transaksi'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: pembayaran.php?id_transaksi=$id_transaksi");
        exit;
    } else {
        echo "Gagal mengubah status.";
    }
} else {
    echo "Metode tidak diperbolehkan.";
}
