<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

if (isset($_GET['id_barang'])) {
    $id = $_GET['id_barang'];

    // Cek apakah produk punya gambar
    $query_gambar = mysqli_query($koneksi, "SELECT gambar FROM barang WHERE id_barang = '$id'");

    if (!$query_gambar) {
        die("Query gambar gagal: " . mysqli_error($koneksi));
    }

    $data = mysqli_fetch_assoc($query_gambar);
    $gambar = $data['gambar'];

    // Cek apakah file gambar benar-benar ada
    $filePath = "uploads/$gambar";
    if (!empty($gambar) && file_exists($filePath)) {
        if (!unlink($filePath)) {
            echo "Gagal menghapus gambar: $filePath<br>";
        }
    }

    // Hapus data produk dari database
    $hapus = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang = '$id'");
    if ($hapus) {
        header("Location: produk.php?hapus=sukses");
        exit;
    } else {
        die("Gagal menghapus produk: " . mysqli_error($koneksi));
    }
    
} else {
    die("ID produk tidak diberikan");
}
?>
