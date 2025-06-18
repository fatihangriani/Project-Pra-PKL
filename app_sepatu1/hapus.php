<?php
session_set_cookie_params(['path' => '/']);
session_start();
if (!isset($_SESSION['admin'])) {
  echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';


if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login dahulu'); window.location='login_admin.php';</script>";
    exit;
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $hapus = mysqli_query($koneksi, "DELETE FROM komentar WHERE id = '$id'");

    if ($hapus) {
        echo "<script>alert('Komentar berhasil dihapus.'); window.location='pesan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus komentar.'); window.location='pesan.php';</script>";
    }
} else {
    echo "<script>alert('ID komentar tidak ditemukan.'); window.location='pesan.php';</script>";
}
