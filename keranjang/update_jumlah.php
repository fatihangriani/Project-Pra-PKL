<?php
session_set_cookie_params(['path' => '/']);
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../home/login.php';</script>";
    exit;
}

if (isset($_POST['index']) && isset($_POST['aksi'])) {
    $index = intval($_POST['index']);
    $aksi = $_POST['aksi'];

    if (isset($_SESSION['keranjang'][$index])) {
        if ($aksi === 'tambah') {
            $_SESSION['keranjang'][$index]['jumlah'] += 1;
        } elseif ($aksi === 'kurang') {
            $_SESSION['keranjang'][$index]['jumlah'] -= 1;

            if ($_SESSION['keranjang'][$index]['jumlah'] <= 0) {
                unset($_SESSION['keranjang'][$index]);
                $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); // Reset indeks
            }
        }
    }
}

header('Location: keranjang.php');
exit;
