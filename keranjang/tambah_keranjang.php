<?php
session_set_cookie_params(['path' => '/']);
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../home/login.php';</script>";
    exit;
}
include '../home/koneksi.php';

// Cek apakah request POST valid
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_barang = isset($_POST['id_barang']) ? intval($_POST['id_barang']) : 0;
    $ukuran = isset($_POST['ukuran']) ? $_POST['ukuran'] : '';
    $jumlah = isset($_POST['jumlah']) ? intval($_POST['jumlah']) : 1;

    // Validasi data
    if ($id_barang <= 0 || empty($ukuran) || $jumlah <= 0) {
        die("Data tidak valid");
    }

    // Cek apakah barang ada di database
    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = $id_barang");
    if (mysqli_num_rows($query) === 0) {
        die("Barang tidak ditemukan");
    }

    // Inisialisasi keranjang jika belum ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Buat key unik berdasarkan id_barang dan ukuran
    $key = $id_barang . '_' . $ukuran;

    // Cek apakah item sudah ada di keranjang
    $item_exists = false;
    foreach ($_SESSION['keranjang'] as $key_cart => $item) {
        if ($item['id_barang'] == $id_barang && $item['ukuran'] == $ukuran) {
            // Update jumlah jika item sudah ada
            $_SESSION['keranjang'][$key_cart]['jumlah'] += $jumlah;
            $item_exists = true;
            break;
        }
    }

    // Jika item belum ada, tambahkan baru
    if (!$item_exists) {
        $_SESSION['keranjang'][$key] = [
            'id_barang' => $id_barang,
            'ukuran' => $ukuran,
            'jumlah' => $jumlah
        ];
    }

    // Redirect kembali ke halaman sebelumnya atau keranjang
 if (isset($_POST['beli_langsung'])) {
    header('Location: checkout.php');
    exit;
} else {
    header('Location: keranjang.php');
    exit;
}


    exit;
} else {
    die("Metode request tidak valid");
}