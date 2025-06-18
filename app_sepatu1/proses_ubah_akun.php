<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
include '../home/koneksi.php';

$id       = mysqli_real_escape_string($koneksi, $_POST['id_user']);
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$email    = mysqli_real_escape_string($koneksi, $_POST['email']);

$sql = "UPDATE users SET 
          username='$username',
          email='$email'
        WHERE id_user='$id'";
$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: akun.php?edit=sukses");
} else {
    header("Location: akun.php?edit=gagal");
}
exit;
?>
