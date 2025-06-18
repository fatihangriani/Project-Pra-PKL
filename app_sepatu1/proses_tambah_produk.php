<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

$nama_barang = $_POST['nama_barang'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$kategori = $_POST['kategori'];
$deskripsi = $_POST['deskripsi'];

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

// Pindahkan gambar ke folder uploads/
if (move_uploaded_file($tmp, "upload/" . $gambar)) {
    // Simpan data ke database
    $sql = "INSERT INTO barang (nama_barang, harga, stok, kategori, deskripsi, gambar) 
            VALUES ('$nama_barang', '$harga', '$stok', '$kategori', '$deskripsi', '$gambar')";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo "<script>alert('Produk berhasil ditambahkan'); window.location='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan ke database'); window.location='tambah_produk.php';</script>";
    }
} else {
    echo "<script>alert('Gagal upload gambar'); window.location='tambah_produk.php';</script>";
}
?>
