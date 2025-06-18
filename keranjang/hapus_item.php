<?php
session_set_cookie_params(['path' => '/']);
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../home/login.php';</script>";
    exit;
}

$key = $_GET['key'] ?? null;

if ($key !== null && isset($_SESSION['keranjang'][$key])) {
    unset($_SESSION['keranjang'][$key]);
}

header('Location: keranjang.php');
exit;
