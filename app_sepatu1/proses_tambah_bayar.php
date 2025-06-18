<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_transaksi = $_POST['id_transaksi'];
    $metode = $_POST['metode'];
    $tanggal_bayar = date("Y-m-d");

    // Upload file
    $bukti = $_FILES['bukti']['name'];
    $tmp = $_FILES['bukti']['tmp_name'];
    $upload_dir = "../uploads/";

    // Pastikan folder uploads ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_path = $upload_dir . $bukti;
    move_uploaded_file($tmp, $file_path);

    // Simpan ke database
    $query = "INSERT INTO pembayaran (id_transaksi, metode_pembayaran, bukti, tanggal_bayar)
              VALUES ('$id_transaksi', '$metode', '$bukti', '$tanggal_bayar')";
    $insert = mysqli_query($koneksi, $query);

    if ($insert) {
        // Update status transaksi menjadi "diterima"
        mysqli_query($koneksi, "UPDATE transaksi SET status = 'diterima' WHERE id_transaksi = '$id_transaksi'");
        echo "<script>alert('Pembayaran berhasil ditambahkan!'); window.location.href='pembayaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan pembayaran!'); window.history.back();</script>";
    }
} else {
    header("Location: tambah_pembayaran.php");
    exit;
}
