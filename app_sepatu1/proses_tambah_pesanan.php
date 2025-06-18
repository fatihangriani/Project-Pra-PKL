<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

$id_user = $_POST['id_user'];
$id_barang = $_POST['id_barang'];
$ukuran = $_POST['ukuran'];
$jumlah = $_POST['jumlah'];

// Ambil harga satuan dari tabel barang
$q = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id_barang = '$id_barang'");
$row = mysqli_fetch_assoc($q);
$harga_satuan = $row['harga'];

// Hitung total
$total_harga = $harga_satuan * $jumlah;

// Tambah ke transaksi
mysqli_query($koneksi, "INSERT INTO transaksi (id_user, total_harga, tanggal_transaksi, status) 
VALUES ('$id_user', '$total_harga', NOW(), 'diproses')");

// Ambil id_transaksi terakhir
$id_transaksi = mysqli_insert_id($koneksi);

// Tambah ke detail_transaksi
mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_barang, ukuran, jumlah, harga_satuan) 
VALUES ('$id_transaksi', '$id_barang', '$ukuran', '$jumlah', '$harga_satuan')");

header("Location: pesanan.php?simpan=sukses");
?>