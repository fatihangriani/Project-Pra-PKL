<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

$id = $_POST['id_barang'];
$nama = $_POST['nama_barang'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

$foto = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

// Ambil data gambar lama
$q = mysqli_query($koneksi, "SELECT gambar FROM barang WHERE id_barang = '$id'");
$d = mysqli_fetch_assoc($q);
$gambar_lama = $d['gambar'];

if (!empty($foto)) {
    move_uploaded_file($tmp, "upload/" . $foto);
    $gambar = $foto;
} else {
    $gambar = $gambar_lama;
}

$sql = "UPDATE barang SET 
            nama_barang = '$nama',
            harga = '$harga',
            stok = '$stok',
            gambar = '$gambar'
        WHERE id_barang = '$id'";

mysqli_query($koneksi, $sql);
header("Location: produk.php");
?>
